<?php $__env->startSection('payment_redirect'); ?>
<form method="post" action="<?php echo e($txn_url); ?>" name="f1" style="visibility: hidden;">
<table border="1">
<tbody>
<?php foreach($params as $key => $value): ?>
<input type="hidden" name="<?php echo e($key); ?>"  value="<?php echo e($value); ?>" />
<?php endforeach; ?>
<input type="hidden" name="CHECKSUMHASH" value="<?php echo e($checkSum); ?>">
</tbody>
</table>
<script type="text/javascript">
document.f1.submit();
</script>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($view, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>