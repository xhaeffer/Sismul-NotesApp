<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <title>Notes App</title>
</head>
<body>
  <?php include('header.php'); ?>

  <div class='note-app__body'>
    <div class="add-new-page__action">
      <a href="<?= site_url('notes/new') ?>" class="action" title="Buat Catatan Baru" style="text-decoration: none;">
        <span class="material-icons">add</span>
      </a>
    </div>
    <?php if (empty($notes)): ?>
      <p class="notes-list__empty-message">Tidak ada catatan</p>
    <?php else: ?>
      <div class="notes-list">
        <?php foreach ($notes as $note): ?>
          <div class='note-item'>
            <div class='note-item__content'>
              <h3 class='note-item__title'><?= $note->title ?? "-" ?></h3>
              <p class='note-item__date'><?= $note->updated_at ?? "-" ?></p>
              <p class='note-item__body'><?= $note->content ?? "-" ?></p>
            </div>
            <div class='note-item__action'>
              <a href="<?= site_url('notes/' . $note->id) ?>" class="note-item__edit-button">Edit</a>
              <form 
                method="POST" 
                action="<?= site_url('notes/delete/'.$note->id) ?>" 
                onsubmit="return confirm('Yakin ingin menghapus catatan ini?')"
              >
                <button type="submit" class="note-item__delete-button">Hapus</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    
  </div>

  <?php include('alert.php'); ?>
</body>
</html>
