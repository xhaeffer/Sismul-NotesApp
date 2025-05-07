  <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>Detail Catatan</title>
  </head>
  <body>
    <?php include('header.php'); ?>

    <div class="note-app__body">
      <div class='add-new-page__input'>
        <input 
          class='add-new-page__input__title' 
          type='text' 
          placeholder='Ini adalah judul...'
          value="<?= htmlspecialchars($note->title ?? "-", ENT_QUOTES) ?>"
          id="note-title"
          name="title"
        />
        <div 
          class='add-new-page__input__body' 
          contentEditable="true" 
          data-placeholder="Tuliskan catatanmu di sini..."
          id="note-content"
          name="content"
        >
          <?= htmlspecialchars(trim($note->content ?? "-")) ?>
        </div>
      </div>

      <div class='add-new-page__action'>
        <form id="note-form" method="POST" action="<?= $action ?>" enctype="multipart/form-data">
        <input type="hidden" name="title" id="title-hidden" />
        <textarea name="content" id="content-hidden" hidden></textarea>
        <?php if (!empty($note->image)): ?>
  <div style="margin: 10px 0;">
    <p>Gambar saat ini:</p>
    <img src="<?= base_url('uploads/' . $note->image) ?>" alt="Gambar Catatan" style="max-width: 200px; border: 1px solid #ccc;" />
  </div>
<?php endif; ?>
        <input type="file" name="image" accept="image/*" style="margin: 10px 0;" />
          <button class="action" type="submit" title="Simpan">
            <span class="material-icons">check</span>
          </button>
        </form>
      </div>
    </div>

    <?php include('alert.php'); ?>

    <script>
      const noteContent = document.getElementById('note-content');
      const noteTitle = document.getElementById('note-title');
      const form = document.getElementById('note-form');

      const hiddenTitle = document.getElementById('title-hidden');
      const hiddenContent = document.getElementById('content-hidden');

      form.addEventListener('submit', function (e) {
        hiddenTitle.value = noteTitle.value;
        hiddenContent.value = noteContent.innerText.trim();
      });

      function togglePlaceholder() {
        const isEmpty = noteContent.innerText.trim() === '';
        noteContent.classList.toggle('placeholder', isEmpty);
      }

      togglePlaceholder();
      noteContent.addEventListener('input', togglePlaceholder);
    </script>
  </body>
  </html>
