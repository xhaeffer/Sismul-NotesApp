<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Note_model extends CI_Model {
  public function get($id = null) {
    if ($id === null) {
      return $this->db->get('notes')->result();
    } else {
      return $this->db->get_where('notes', ['id' => $id])->row();
    }
  }

  public function insert($data) {
    $timestamp = date('Y-m-d H:i:s');
    $data['created_at'] = $timestamp;
    $data['updated_at'] = $timestamp;
    
    return $this->db->insert('notes', $data);
}

  public function update($id, $data) {
    $data['updated_at'] = date('Y-m-d H:i:s');
        
    $this->db->where('id', $id);
    return $this->db->update('notes', $data);
  }

  public function delete($id) {
    return $this->db->delete('notes', ['id' => $id]);
  }
}