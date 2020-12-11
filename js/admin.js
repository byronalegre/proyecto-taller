var base = location.protocol+'//'+location.host;
var route = document.getElementsByName('routeName')[0].getAttribute('content');
var http = new XMLHttpRequest();
var csrfToken = document.getElementsByName('csrf-token')[0].getAttribute('content');
//------------------------------------------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function(){	
	document.getElementsByClassName('lk-'+route)[0].classList.add('active');

	var btn_deleted = document.getElementsByClassName('btn-deleted');

		for(i=0; i < btn_deleted.length; i++){
			btn_deleted[i].addEventListener('click', delete_object);
		}		
});
//------------------------------------------------------------------------------------------------------------------------------
if(route == "piezas_editar" || route == "piezas_agregar"){
$(document).ready(function(){
	editor_init('editor');
});
//------------------------------------------------------------------------------------------------------------------------------
function editor_init(field){
	CKEDITOR.replace(field,{
		toolbar: [
		{ name: 'clipboard', items: ['Cut','Copy','Paste','PasteText','-','Undo','Redo'] } ,
		{ name: 'basicstyles', items: ['Bold','Italic','BulletedList',,'Strike','Image','Link','Unlink','Blockquote'] },
		{ name: 'document', items: ['CodeSpippet','EmojiPanel','Preview','Source'] }

		]
	});
}
}

//------------------------------------------------------------------------------------------------------------------------------
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

//------------------------------------------------------------------------------------------------------------------------------
//FUNCION PARA CREAR TABLA AGREGAR PRODUCTOS A COMPRA
if(route == "remitos_agregar" || route == "compras_agregar"){
	var count = 0;
	var acum = 0;
	var list = {
				 'datos' :[]
				};
	$(function(){	
		//agrega fila a tabla compra
		$('#agregar').click(function(e){
			e.preventDefault();		
			var combo = document.getElementById("producto");
			var selected = combo.options[combo.selectedIndex].text;//nombre 
			var cant = document.getElementById("cantidad").value;
	 		var price = document.getElementById("precio").value;	
	 		var id_prod = combo.options[combo.selectedIndex].value;

	 		if(cant>0 && price>0){//esto valida que no se ingresen valores 0
				var tr = '<tr><td hidden="true">'+count+'</td><td>'+selected+'</td><td>'+cant+'</td><td>'+price+'</td><td>'+cant*price+'</td><td><input type="button" class="borrar btn btn-danger btn-sm" value="Eliminar"></td></tr>';
				
				$('tbody').append(tr); 
			    list.datos.push({
			    "id":count,
			    "id_p": id_prod,
			    "producto": selected,
			    "cantidad": cant,
			    "precio": price
			  	});
				
				var json = JSON.stringify(list.datos); // aqui tienes la lista de objetos en Json
			//	var Obj = JSON.parse(json); //Parsea el Json al objeto anterior.
				count++;

				$("#productos").val(json);	
		      
		//ACTUALIZA Y ACUMULA TOTAL
				for (var item in list.datos){
					var td = parseInt(list.datos[item].precio * list.datos[item].cantidad);
				}
				acum += td;
				
				$('h6').html("Total: $"+ acum);
				}
		})		

	//BORRA FILA, ACTUALIZA ARRAY DE PRODUCTOS y TOTAL $
		$('body').on('click', 'input.borrar', function(e) {		
		   e.preventDefault();
		   var index = $(this).closest("tr").index();
	       var id = $(this).parents("tr").find("td")[0].innerHTML; 
	       var erase = $(this).parents("tr").find("td")[4].innerHTML;

	       for(var item in list.datos){     	
	        	if(list.datos[item].id == id){
	       			list.datos.splice(index,1);
	       		}
	       }

			if(list.datos.length == 0){			
				location.reload();
			}
			
	        var json = JSON.stringify(list.datos);
			$("#productos").val(json);
	   		$(this).parents('tr').remove(); 

	   		acum -= erase;
	   		$('h6').html("Total: $"+ acum);
	   	});    
	})
}
//------------------------------------------------------------------------------------------------------------------------------
//FUNCION CALCULA TOTAL PANEL INICIO

var acum_tot_compras = 0;
$(document).ready(function(){
	//cargar_productos('inicio');
	//var info = prods_bdd;
	//console.log(prods_bdd)
	let today = new Date();
	//console.log(today.getMonth())
	var json_c = document.getElementById('all_prods').value;
	var Obj_c = JSON.parse(json_c);
	//console.log(Obj_c)
	for(var item in Obj_c){
		var aux = Obj_c[item];
		var fecha = new Date(aux.created_at)
		if(fecha.getFullYear() == today.getFullYear()){
			if(fecha.getMonth() == today.getMonth()){
		//console.log(fecha.getDate()+"/"+fecha.getMonth()+"/"+fecha.getFullYear())
				var prods = JSON.parse(aux.productos)
				for(var i in prods){
				var aux2=prods[i];
		//	console.log(parseInt(aux2.cantidad*aux2.precio))
				acum_tot_compras += parseInt(aux2.cantidad*aux2.precio);
				}
			}
		}	
	}
	$('h3').append(acum_tot_compras);
});

/*---------------------------------------------------------------------------------------------------------------------*/
// SIDEBAR OCULTO
function abrir(){
	document.getElementById('sidebar').style.display = "block";
	document.getElementById('cuerpo').style.display = "none";
}

function cerrar(){
	document.getElementById('sidebar').style.display = "none";
	document.getElementById('cuerpo').style.display = "block";
}

/*---------------------------------------------------------------------------------------------------------------------*/
//FUNCION PARA CREAR TABLA AGREGAR PRODUCTOS A TAREA
if(route == "tareas_agregar" || route == "pedidos_agregar"){
var contar = 0;
var lista_t = {
			 'tarea' :[]
			};
$(function(){	
	cargar_productos('tareas');
	//var listado_prod = document.getElementById("todos").value;
	var info = prods_bdd;//JSON.parse(listado_prod);

	//agrega fila a tabla tarea
	$('#agregar_tarea').click(function(e){
		e.preventDefault();		
		var seleccion = document.getElementById("producto");
		var id_selected = seleccion.options[seleccion.selectedIndex].value;
		var selected = seleccion.options[seleccion.selectedIndex].text;//nombre 
		var cant = document.getElementById("cantidad").value;
 		var id_prod = seleccion.options[seleccion.selectedIndex].value;

 		if(cant>0){//esto valida que no se ingresen valores 0
 			if(cant >= info[seleccion.selectedIndex].cantidad){ 				
				swal({
					  title: 'Advertencia',
					  text: 'La cantidad ingresada supera el stock.'
					})
 			}
 			else{
				var tr = '<tr><td hidden="true">'+contar+'</td><td>'+selected+'</td><td>'+cant+'</td><td><input type="button" class="borrar_t btn btn-danger btn-sm" value="Eliminar"></td></tr>';

				$('tbody').append(tr); 
			    lista_t.tarea.push({
			    "id":contar,
			    "id_p": id_prod,
			    "producto": selected,
			    "cantidad": cant
			  	});
				
				var json = JSON.stringify(lista_t.tarea); // aqui tienes la lista de objetos en Json
			//	var Obj = JSON.parse(json); //Parsea el Json al objeto anterior.
				contar++;

				$("#productos").val(json);	
		    
				}
			}
			})		

//BORRA FILA, ACTUALIZA ARRAY DE PRODUCTOS y TOTAL $
	$('body').on('click', 'input.borrar_t', function(e) {		
	   e.preventDefault();
	   var index = $(this).closest("tr").index();
       var id = $(this).parents("tr").find("td")[0].innerHTML; 

       for(var item in lista_t.tarea){     	
        	if(lista_t.tarea[item].id == id){
       			lista_t.tarea.splice(index,1);
       		}
       }

		if(lista_t.tarea.length == 0){			
			location.reload();
		}
		
        var json = JSON.stringify(lista_t.tarea);
		$("#productos").val(json);
   		$(this).parents('tr').remove(); 
   	});    
})
}
/*----------------------------------------------------------------------------------------------------------------------*/
//FUNCION BOTON BACKUP
if(route == "backup" || route == "backup_create"){
$(document).ready(function(){
	$('#create_b').click(function() {
		$('#create_b').hide(); 
		$('#cargando').show();
	 });
})};
//----------------------------------------------------------------------------------------------------------------------*/

$(document).ready(function(){
	var direccion = base + '/admin/' + route + '/';

	if(window.location == direccion+'0'){
		$('h7').append('Piezas');
	}
	if(window.location == direccion+'1'){
		$('h7').append('Marcas');
	}
	if(window.location == direccion+'2'){
		$('h7').append('Tareas');
	}

});

//----------------------------------------------------------------------------------------------------------------------*/
//DESACTIVA BOTONES E INSPECTOR DE NAVEGADOR
if(route == "inicio" || route == "compras_agregar" || route == "compra_detalle" || route == "tareas_agregar" || route == "tarea_detalle"){
document.onkeydown = function(e) {
	if(event.keyCode == 123) {
	return false;
	}
	if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
	return false;
	}
	if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
	return false;
	}
	if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
	return false;
	}
	if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
	return false;
	}
	if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)){
	return false;
	}
	if(e.ctrlKey && e.keyCode == 'H'.charCodeAt(0)){
	return false;
	}
	if(e.ctrlKey && e.keyCode == 'A'.charCodeAt(0)){
	return false;
	}
	if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
	return false;
	}
	}
}
//----------------------------------------------------------------------------------------------------------------------*/
//FUNCION CARGAR PIEZAS
var prods_bdd = [];
function cargar_productos(seccion){
	var url = base + '/admin/' + 'md/api/load/piezas/' + seccion;

	http.open('GET', url, true);
	http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
	http.send();
	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var data = this.responseText;
			data = JSON.parse(data)
			for(var item in data){
				prods_bdd[item]=data[item];	
			}				
		}
		else{}			
	}
//console.log(prods_bdd)
}

//----------------------------------------------------------------------------------------------------------------------*/

/*ORDENAR
$('th').click(function() {
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc) {
      rows = rows.reverse()
    }
    for (var i = 0; i < rows.length; i++) {
      table.append(rows[i])
    }
    setIcon($(this), this.asc);
  })

  function comparer(index) {
    return function(a, b) {
      var valA = getCellValue(a, index),
        valB = getCellValue(b, index)
      return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
    }
  }

  function getCellValue(row, index) {
    return $(row).children('td').eq(index).html()
  }

  function setIcon(element, asc) {
    $("th").each(function(index) {
      $(this).removeClass("sorting");
      $(this).removeClass("asc");
      $(this).removeClass("desc");
    });
    element.addClass("sorting");
    if (asc) element.addClass("asc");
    else element.addClass("desc");
  }
  */

/*------------------------------------------------------------------------------------------------------------*/

/*BUSQUEDA INSTANTANEA - Solo por pagina
$(document).ready(function(){
	 $("#searchTerm").keyup(function(){
	 _this = this;
	 // Show only matching TR, hide rest of them
	 $.each($("#datos tbody tr"), function() {
	 if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
	 $(this).hide();
	 else
	 $(this).show();
	 });
	 });
});
*/

/*------------------------------------------------------------------------------------------------------------*/