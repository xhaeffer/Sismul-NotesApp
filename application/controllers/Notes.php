<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('Note_model', 'notes');
    $this->load->helper('url');
    $this->load->library('session');
  }

  public function index() {
    $data['notes'] = $this->notes->get();
    $this->load->view('notes', $data);
  }

  public function new_note() {
    $data['note'] = (object) ['title' => '', 'content' => ''];
    $data['action'] = site_url('notes/create');

    $this->load->view('note_detail', $data);
  }

  public function detail($id) {
    $data['note'] = $this->notes->get($id);
    if (!$data['note']) {
      show_404();
    }
    
    $data['action'] = site_url('notes/update/'.$id);
    $this->load->view('note_detail', $data);
  }

  public function create() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $title = $this->input->post('title');
      $content = $this->input->post('content');
      
      if (empty($title) || empty($content)) {
        $this->session->set_flashdata('error_message', 'Judul dan Konten tidak boleh kosong!');

        $data['note'] = (object) ['title' => $title, 'content' => $content];
        $data['action'] = site_url('notes/create');

        $this->load->view('note_detail', $data);
        return;
      }

      $image_name = null;
      if (!empty($_FILES['image']['name'])) {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;
      
        $this->load->library('upload', $config);
      
        if ($this->upload->do_upload('image')) {
          $image_name = $this->upload->data('file_name');
        } else {
          $this->session->set_flashdata('error_message', $this->upload->display_errors());
        }
      }
      
      $this->notes->insert([
        'title' => $title,
        'content' => $content,
        'image' => $image_name
      ]);

      redirect('notes');
    }
  }

  public function update($id) {
    $title = $this->input->post('title');
    $content = $this->input->post('content');
  
    if (empty($title) || empty($content)) {
      $this->session->set_flashdata('error_message', 'Judul dan Konten tidak boleh kosong!');

      $data['note'] = (object) ['title' => $title, 'content' => $content];
      $data['action'] = site_url('notes/update/' . $id);

      $this->load->view('note_detail', $data);
      return;
    }

    $image_name = null;
    if (!empty($_FILES['image']['name'])) {
      $config['upload_path'] = './uploads/';
      $config['allowed_types'] = 'jpg|jpeg|png|gif';
      $config['max_size'] = 2048;
      $config['encrypt_name'] = TRUE;
    
      $this->load->library('upload', $config);
    
      if ($this->upload->do_upload('image')) {
        $image_name = $this->upload->data('file_name');
      } else {
        $this->session->set_flashdata('error_message', $this->upload->display_errors());
      }
    }
    
    $data = [
      'title' => $title,
      'content' => $content
    ];
    
    if ($image_name !== null) {
      $data['image'] = $image_name;
    }
    
    $this->notes->update($id, $data);

    $this->session->set_flashdata('success_message', 'Catatan berhasil disimpan.');
    redirect('notes');
  }

  public function delete($id) {
    if (!$this->notes->get($id)) {
      show_404();
    }

    $this->notes->delete($id);
    redirect('notes');
  }
}
