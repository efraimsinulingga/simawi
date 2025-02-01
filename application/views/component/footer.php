
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url('public/js/scripts.js'); ?>"></script>
<?php if ($this->session->flashdata('errors')): ?>
<script>
Swal.fire({
  title: "Ooops",
  text: "<?php echo $this->session->flashdata('errors'); ?>",
  icon: "error"
});
</script>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
<script>

Swal.fire({
  title: "Berhasil",
  html: "<?php echo $this->session->flashdata('success'); ?>",
  timer: 2000,
  timerProgressBar: true,  
  
});
</script>
<?php endif; ?>