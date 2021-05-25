
<?php $__env->startSection('title','Registrar entrada'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
  <a href="<?php echo e(url('/admin/cart/show')); ?>"><i class="far fa-plus-square"></i> Compras</a>
</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
  <div class="panel shadow">
    <div class="header">
      <h2 class="title"><i class="far fa-plus-square"></i> Nueva compra</h2>
    </div>
    <div class="inside">
   <div class="table-cart col-md-12">
       <div class="table-responsive">
           <?php if(!$cart): ?>
               <div class="no-cart col-md-12 text-center">
                   <h3>No hay productos en el carrito</h3>
               </div>
                   <?php else: ?>
                        <p class="text-center">
                            <a href="<?php echo e(route('cart-trash')); ?>" class="btn btn-danger">
                               Vaciar carro <i class="fa fa-trash"></i>
                            </a>
                        </p>
                       <table class="table table-striped table-hover table-bordered">
                           <thead>
                           <tr>
                               <th>Producto</th>
                               <th>Precio</th>
                               <th>Cantidad</th>
                               <th>Subtotal</th>
                               <th>Quitar</th>
                           </tr>
                           </thead>
                       <tbody>
 
                           <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <tr>
                                   <td><img src="<?php echo e($item->image); ?>" alt="<?php echo e($item->name); ?>" title="<?php echo e($item->name); ?>" ></td>
                                   <td><?php echo e($item->name); ?></td>
                                   <td>$ <?php echo e(number_format($item->price,2)); ?></td>
                                   <td>
                                       <input id="product_<?php echo e($item->id); ?>" type="number" min="1" max="100" value="<?php echo e($item->quantity); ?>">
                                       <a href="" class="btn btn-warning btn-update-item" data-href="<?php echo e(route('cart-update',$item->slug)); ?>" data-id="<?php echo e($item->id); ?>">
                                           <i class="fa fa-refresh"></i>
                                       </a>
                                   </td>
                                   <td>$ <?php echo e(number_format($item->price * $item->quantity,2)); ?></td>
                                   <td>
                                       <a href="<?php echo e(route('cart-delete',$item->slug)); ?>" class="btn btn-danger">
                                           <i class="fa fa-remove"></i>
                                       </a>
                                   </td>
                               </tr>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   <?php endif; ?>
                        </tbody>
           </table>
       </div>

       <hr>
      <div class="btn-cart text-center">
          <p>
              <a href="<?php echo e(route('entradas_agregar')); ?>" class="btn btn-primary">
                  <i class="fa fa-chevron-circle-left"></i> Añadir items
              </a>
              <a href="#" class="btn btn-primary">
                  Finalizar compra <i class="fa fa-chevron-circle-right"></i>
              </a>
          </p>
      </div>
   </div>
 </div>
  </div>
</div>
 
 
 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/admin.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/compras/cart.blade.php ENDPATH**/ ?>