<?php if ($this->session->flashdata('error_message')): ?>
  <script type="text/javascript">
    alert('<?= $this->session->flashdata('error_message'); ?>');
  </script>
<?php endif; ?>

<?php if ($this->session->flashdata('success_message')): ?>
  <script type="text/javascript">
    alert('<?= $this->session->flashdata('success_message'); ?>');
  </script>
<?php endif; ?>