
<?php if(kvfj(Auth::user()->permisos, 'piezas_editar')): ?>
	<?php if(is_null($deleted_at)): ?>
			<a class="btn btn-primary btn-sm" href="<?php echo e(route('piezas_editar',$id)); ?>" data-toggle="tooltip" data-placement="top" title="Editar">
			<i class="fas fa-edit"></i>
			</a>
		<?php endif; ?>
<?php endif; ?>

<?php if(kvfj(Auth::user()->permisos, 'piezas_eliminar')): ?>		
	<a href="#" data-path="admin/piezas" data-action="delete" data-object="<?php echo e($id); ?>" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm btn-deleted">
	<i class="fas fa-trash-alt"></i>
	</a> 
<?php endif; ?>

<script>
	function delete_object(e){
	e.preventDefault();
	var object = this.getAttribute('data-object');
	var action = this.getAttribute('data-action');
	var path = this.getAttribute('data-path');
	var url = base + '/' + path + '/' + object + '/' + action;
	var text,title;

	if(action == "delete"){
		title = "Desea enviar el elemento a la papelera?";
		text = "Para restaurarlo dirijase a 'Papelera'.";
	}
	if(action == "restore"){
		title = "Desea restaurar el elemento?";
		text = "Una vez restaurado, volverá a estar disponible.";
	}
	swal({
	  title: title,
	  text: text,
	  buttons: ["Cancelar",true],
	  dangerMode: true,
	})
	.then((willDelete) => {
	  if (willDelete) {
	  	window.location.href = url;	   
	  }
	});	
}
</script>
<?php /**PATH G:\www\cms\resources\views/admin/piezas/btn.blade.php ENDPATH**/ ?>