<?php if(Session::has('alert-sucess')): ?>

<script type="text/javascript">
	showSuccessMessageBottomRight("<?php echo Session::get('alert-sucess'); ?>");
</script>

<?php endif; ?>
<?php if(Session::has('alert-error')): ?>

<script type="text/javascript">
	showErrorMessageBottomRight("<?php echo Session::get('alert-error'); ?>");
</script>

<?php endif; ?>