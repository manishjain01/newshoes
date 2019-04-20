<?php if(isset($breadcrumb)): ?>
  <ol class="breadcrumb">
 <?php foreach($breadcrumb['pages'] as $key=>$pages): ?>


  		<?php if(is_array($pages)): ?>

	     <li>  <?php echo Html::decode(Html::linkAsset(route($pages[0],$pages[1]), $key)); ?></li>
	     <?php else: ?>
	     <li>  <?php echo Html::decode(Html::linkAsset(route($pages), $key)); ?></li>
	     <?php endif; ?>
<?php endforeach; ?>
       


   <li class="active"><?php echo e($breadcrumb['actives']); ?></li>
         </ol>
<?php endif; ?>