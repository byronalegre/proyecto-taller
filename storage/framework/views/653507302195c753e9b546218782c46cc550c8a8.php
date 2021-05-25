<?php if(count($backups)): ?>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>File</th>
                <th>Size</th>
                <th>Date</th>
                <th>Age</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $backups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $backup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($backup['file_name']); ?></td>
                    <td><?php echo e($backup['file_size']); ?></td>
                    <td>
                        <?php echo e(date('d/M/Y, g:ia', strtotime($backup['last_modified']))); ?>

                    </td>
                    <td>
                        <?php echo e(diff_date_for_humans($backup['last_modified'])); ?>

                    </td>
                    <td class="text-right">
                        <a class="btn btn-primary" href="<?php echo e(url('admin/backup/download/'.$backup['file_name'])); ?>">
                            <i class="fas fa-cloud-download"></i> Download</a>
                        <a class="btn btn-xs btn-danger" data-button-type="delete" href="<?php echo e(url('admin/backup/delete/'.$backup['file_name'])); ?>">
                            <i class="fal fa-trash"></i>
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="text-center py-5">
        <h1 class="text-muted">No existen backups</h1>
    </div>
<?php endif; ?><?php /**PATH G:\www\cms\resources\views/admin/backups/backups-table.blade.php ENDPATH**/ ?>