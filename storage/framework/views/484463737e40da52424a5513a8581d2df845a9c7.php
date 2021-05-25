

<?php $__env->startSection('content'); ?>
<p>Hola <strong><?php echo e($name); ?></strong></p>
<p>Este es tu nuevo usuario y contraseña para el sistema:</p>
<ul>
	<li><strong>Usuario:</strong> <?php echo e($email); ?></li>
	<li><strong>Contraseña:</strong> <?php echo e($password); ?></li>
</ul>
<p>Para establecer una nueva contraseña, debe dirigirse a:</p>
<p> <?php echo e(url('/admin/micuenta/edit')); ?> </p>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/emails/nuevo_usuario_y_contraseña.blade.php ENDPATH**/ ?>