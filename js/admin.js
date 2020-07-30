var base = location.protocol+'//'+location.host;
var route = document.getElementsByName('routeName')[0].getAttribute('content');

document.addEventListener('DOMContentLoaded', function(){
	
	document.getElementsByClassName('lk-'+route)[0].classList.add('active');


	var btn_deleted = document.getElementsByClassName('btn-deleted');

		for(i=0; i < btn_deleted.length; i++){
			btn_deleted[i].addEventListener('click', delete_object);
		}

});

$(document).ready(function(){
	editor_init('editor');
});

function editor_init(field){

	CKEDITOR.replace(field,{
		toolbar: [
		{ name: 'clipboard', items: ['Cut','Copy','Paste','PasteText','-','Undo','Redo'] } ,
		{ name: 'basicstyles', items: ['Bold','Italic','BulletedList',,'Strike','Image','Link','Unlink','Blockquote'] },
		{ name: 'document', items: ['CodeSpippet','EmojiPanel','Preview','Source'] }

		]
	});
}



function delete_object(e){

	e.preventDefault();
	var object = this.getAttribute('data-object');
	var action = this.getAttribute('data-action');
	var path = this.getAttribute('data-path');
	var url = base + '/' + path + '/' + object + '/' + action;
	var text,title;

	if(action == "delete"){
		title = "Seguro que desea borrar el elemento?";
		text = "Una vez borrado, se moverá a la 'papelera'.";
	}
	if(action == "restore"){
		title = "Seguro que desea restaurar el elemento?";
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




