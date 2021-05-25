

<?php $__env->startSection('title','Copias de seguridad'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
    <a href="<?php echo e(url('/admin/backup')); ?>"><i class="fas fa-database"></i> Copias de seguridad</a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <div class="container-fluid">
  	<div class="panel shadow-lg">
  		<div class="header">
  			<h2 class="title"><i class="fas fa-database"></i> Copias de seguridad</h2>
  		</div>	

  		<div class="inside" style="text-align: center">	
        <div class="card text-center">
          <div class="card-header text-muted">
           <b>Listado de copias de seguridad</b>
          </div>

          <div class="card-body">  
            <?php if(kvfj(Auth::user()->permisos, 'backup_create')): ?>
              <button class="btn btn-secondary" type="button" disabled id="cargando" style="display: none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Creando...
              </button>      
              <a href="<?php echo e(url('admin/backup/create')); ?>" class="btn btn-danger" id="create_b">
                <i class="fas fa-plus-circle"></i> Nuevo
              </a>
            <?php endif; ?>
          </div>

          <div class="card-footer text-muted">
             <?php if(($files != '[]') && (file_exists(config('filesystems.disks.backups.root').'/'.env('GOOGLE_DRIVE_FOLDER_ID')))): ?>

                <table class="table table-striped">
                  <thead class="table">
                    <tr style="font-weight: bold;">
                      <td>Responsable - Nombre de la copia</td>
                      <td>Tamaño (bytes)</td>
                      <td>Fecha de creación</td>
                      <td width="100"></td>
                    </tr>
                  </thead>

                  <tbody>     
                            
                    <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a=>$k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td><?php echo e($k['name']); ?></td>
                        <td><?php echo e($k['size']); ?></td>
                        <td><?php echo e(date('d/m/Y (H:i)',$k['timestamp'])); ?></td>
                        <td>
                          <?php if(kvfj(Auth::user()->permisos, 'backup_dowload')): ?>
                            <a class="btn btn-dark btn-sm" href="<?php echo e(url('admin/backup/dowload/'.$k['name'] )); ?>" target="_self" data-toggle="tooltip" data-placement="top" title="Descargar">
                              <i class="fas fa-download"></i>
                            </a>
                          <?php endif; ?>

                          <?php if(kvfj(Auth::user()->permisos, 'backup_delete')): ?>
                            <a class="btn btn-danger btn-sm" href="<?php echo e(url('admin/backup/delete/'.$k['name'] )); ?>" data-toggle="tooltip" data-placement="top" title="Eliminar">
                              <i class="fas fa-trash-alt"></i>
                            </a>
                          <?php endif; ?>
                          
                        </td>
                      </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>     

                  </tbody>     

                </table>    
                      
            <?php else: ?>
              <h5 style="font-family: courier new; font-weight: bold;">No existen backups</h5>
            <?php endif; ?>

          </div>
        </div>         
      </div>	
    </div>
  </div>
<?php $__env->stopSection(); ?>

<!--
	Personalizar notificaciones en la carpeta:
	vendor/spatie/laravel-backup/src/Notifications/BaseNotification
-->
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/backups/backups.blade.php ENDPATH**/ ?>