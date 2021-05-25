

<?php $__env->startSection('content'); ?>
<p>Hola <strong><?php echo e($name); ?></strong></p>
<p>Esta es tu nueva contraseña.</p>
<p><h1 ><?php echo e($password); ?></h1></p>
<p>Para continuar, presiona el siguiente botón:</p>

<p><a href="<?php echo e(url('/login')); ?>" style="box-shadow: 16px; display: inline-block; background-color: green; color: #fff; padding: 12px; border-radius: 4px; text-decoration: none;">Ingresar</a></p>
<p>Si el botón no funciona, copie y pegue la siguiente dirección en el navegador:</p>
<p style="font-size: 15px; color: green;"><?php echo e(url('/login')); ?></p>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/emails/nueva_contraseña_usuario.blade.php ENDPATH**/ ?>