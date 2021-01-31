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
/*if(route == "piezas_editar" || route == "piezas_agregar"){
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
}*/

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
//FUNCION PARA CREAR TABLA AGREGAR PRODUCTOS A REMITO - COMPRA
if(route == "remitos_agregar" || route == "compras_agregar" || route == "compras_editar"){
	var count = 0;
	var acum = 0;
	var list = {
				 'datos' :[]
				};
	$(function(){	

//*********************************************COMIENZO AJAX***********************************************
		// function cargar_all(seccion){
		function cargar_all(){
			// var url = base + '/admin/' + 'md/api/load/all/' + seccion;
			var url = base + '/admin/' + 'md/api/load/piezas-R-OC';
			http.open('GET', url, true);
			http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
			http.send();
			http.onreadystatechange = function(){

				if(this.readyState == 4 && this.status == 200){

					var data = this.responseText;
					data = JSON.parse(data);//datos AJAX para obtener Nombres de productos de la bdd

//******************************************ACCIONES AJAX*************************************************

					//agrega productos de remito a tabla 
					
					var content = document.getElementById("productos").value;//trae las ordenes

//---------------------------------------AGREGAR REMITOS---------------------------------------------------					

					if(route == "remitos_agregar"){ //se asegura que sea Agregar remitos

						var parseado = JSON.parse(content);//parsea el json de productos						

						if(parseado.length == 1){ //Si hay una sola Orden APROBADA

							var combo = document.getElementById("producto");
						
							for(i=0; i<$("#producto option").length; i++){	
								for(n in parseado){
									for(p in parseado[n].detalle){
										if(combo.options[i].value == parseado[n].detalle[p].pieza_id){
											$("#producto option[value='"+combo.options[i].value+"']").attr('disabled', true);
										}	
									}
								}							
							}

							for(var i in parseado){//Por la cantidad de ordenes que haya aprobadas => 1 es decir i=0
				 				for(a in parseado[i].detalle){//Por cada producto del Detalle
						 				var tr = '<tr><td hidden="true">'//Genera tabla
										+count
										+'</td><td>'
										+data[parseInt(parseado[i].detalle[a].pieza_id)]
										+'</td><td>'
										+parseInt(parseado[i].detalle[a].cantidad_req)
										+'</td><td>'
										+parseInt(parseado[i].detalle[a].precio)
										+'</td><td>'
										+parseInt(parseado[i].detalle[a].cantidad_req)*parseInt(parseado[i].detalle[a].precio)
										+'</td><td><input type="button" class="borrar btn btn-danger btn-sm" value="Eliminar"></td></tr>';

										$('tbody').append(tr);//Pinta contenido de tabla	

										acum += parseInt(parseado[i].detalle[a].cantidad_req)*parseInt(parseado[i].detalle[a].precio);//acumula Total
						 				
							 			list.datos.push({//Llena arreglo de Datos que se van a pasar al controlador
										    "id": count,
										    "pieza_id": parseado[i].detalle[a].pieza_id.toString(),
										    "producto": data[parseInt(parseado[i].detalle[a].pieza_id)],
										    "cantidad": parseado[i].detalle[a].cantidad_req.toString(),
										    "precio": parseado[i].detalle[a].precio.toString()
										});										
									count++;//aumenta el contador de filas
									$('h5').html("Total: $"+ acum);//Pinta Total
								}
							}//fin for ordenes
							var json = JSON.stringify(list.datos);//lista de objetos en Json
							$("#productos").val(json);//Pasa el valor al Input de productos que luego se maneja en el Controlador
						}
						else //Si hay mas de una Orden APROBADA
						{
							$('#orden_id').on('change', function(e) { //detecta el cambio en la seleccion del Select
								e.preventDefault();	

								var orden = document.getElementById("orden_id");//trae el Select de orden
								var aux = orden.options[orden.selectedIndex].value;//trae el ID seleccionado del select
								$('tbody').empty();//Borra la tabla al cambiar de Orden
								list.datos.splice(0,list.datos.length);//Borra el arreglo de productos al cambiar de Orden
								acum = 0;//Reinicia el Total
								var combo = document.getElementById("producto");

								for(i=0; i<$("#producto option").length; i++){
									$("#producto option[value='"+combo.options[i].value+"']").attr('disabled', false);
								}
						
								for(i=0; i<$("#producto option").length; i++){	
									for(n in parseado){
										for(p in parseado[n].detalle){
											if(parseado[n].detalle[p].orden_id == aux){
												if(combo.options[i].value == parseado[n].detalle[p].pieza_id){
													$("#producto option[value='"+combo.options[i].value+"']").attr('disabled', true);
												}
											}	
										}
									}							
								}

								for(var i in parseado){//Por cada orden aprobada => i>0
					 				for(a in parseado[i].detalle){//Por cada producto del Detalle
						 				if(parseado[i].detalle[a].orden_id == aux){//Se asegura que sea el Detalle de la Orden seleccionada
							 				var tr = '<tr><td hidden="true">'//Genera tabla
											+count
											+'</td><td>'
											+data[parseInt(parseado[i].detalle[a].pieza_id)]
											+'</td><td>'
											+parseInt(parseado[i].detalle[a].cantidad_req)
											+'</td><td>'
											+parseInt(parseado[i].detalle[a].precio)
											+'</td><td>'
											+parseInt(parseado[i].detalle[a].cantidad_req)*parseInt(parseado[i].detalle[a].precio)
											+'</td><td><input type="button" class="borrar btn btn-danger btn-sm" value="Eliminar"></td></tr>';

											$('tbody').append(tr);//Pinta contenido de tabla	

											acum += parseInt(parseado[i].detalle[a].cantidad_req)*parseInt(parseado[i].detalle[a].precio);//acumula Total
							 				
								 			list.datos.push({//Llena arreglo de Datos que se van a pasar al controlador
											    "id": count,
											    "pieza_id": parseado[i].detalle[a].pieza_id.toString(),
											    "producto": data[parseInt(parseado[i].detalle[a].pieza_id)],
											    "cantidad": parseado[i].detalle[a].cantidad_req.toString(),
											    "precio": parseado[i].detalle[a].precio.toString()
											});										
										count++;//aumenta el contador de filas
										$('h5').html("Total: $"+ acum);//Pinta Total
										}
									}
								}//fin for ordenes
								var json = JSON.stringify(list.datos);//lista de objetos en Json
								$("#productos").val(json);//Pasa el valor al Input de productos que luego se maneja en el Controlador
							}); //fin onchange
						}																						
				 	}

//-----------------------------------FIN AGREGAR REMITOS---------------------------------------------------				 	

//----------------------------------------EDITAR COMPRAS---------------------------------------------------

				 	if(route == "compras_editar"){
				 		var parseado = JSON.parse(content);//parsea el json de productos
				 		var orden = document.getElementById("orden_id").value;//trae el Select de orden
				 		var combo = document.getElementById("producto");

						for(i=0; i<$("#producto option").length; i++){	
							for(p in parseado.detalle){
								if(combo.options[i].value == parseado.detalle[p].pieza_id){
									$("#producto option[value='"+combo.options[i].value+"']").attr('disabled', true);
								}
							}			
						}
				 		if(parseado.codigo == orden){
							for(var a in parseado.detalle){							 			
				 				var tr = '<tr><td hidden="true">'//Genera tabla
								+count
								+'</td><td>'
								+data[parseInt(parseado.detalle[a].pieza_id)]
								+'</td><td>'
								+parseInt(parseado.detalle[a].cantidad_req)
								+'</td><td>'
								+parseInt(parseado.detalle[a].precio)
								+'</td><td>'
								+parseInt(parseado.detalle[a].cantidad_req)*parseInt(parseado.detalle[a].precio)
								+'</td><td><input type="button" class="borrar btn btn-danger btn-sm" value="Eliminar"></td></tr>';

								$('#tablaEditarOCompra tbody').append(tr);//Pinta contenido de tabla	

								acum += parseInt(parseado.detalle[a].cantidad_req)*parseInt(parseado.detalle[a].precio);//acumula Total
				 				
					 			list.datos.push({//Llena arreglo de Datos que se van a pasar al controlador
								    "id": count,
								    "pieza_id": parseado.detalle[a].pieza_id.toString(),
								    "producto": data[parseInt(parseado.detalle[a].pieza_id)],
								    "cantidad": parseado.detalle[a].cantidad_req.toString(),
								    "precio": parseado.detalle[a].precio.toString()
								});										
							count++;//aumenta el contador de filas
							$('h5').html("Total: $"+ acum);//Pinta Total
							}
						}
						var json = JSON.stringify(list.datos);//lista de objetos en Json
						$("#productos").val(json);//Pasa el valor al Input de productos que luego se maneja en el Controlador
				 	}
//------------------------------------FIN EDITAR COMPRAS---------------------------------------------------

//---------------------------------------AGREGAR COMPRAS---------------------------------------------------

				 	if(route == "compras_agregar"){
				 		var parseado = JSON.parse(content);

				 	/*	if(parseado.length == 1){
				 			for(var i in parseado){//Por la cantidad de ordenes que haya aprobadas => 1 es decir i=0
				 				for(a in parseado[i].detalle){//Por cada producto del Detalle
						 				var dt = '<dt class="list-group-item">'
										+data[parseInt(parseado[i].detalle[a].pieza_id)]
										+'</dt><dd class="list-group-item list-group-item-warning">'
										+parseInt(parseado[i].detalle[a].cantidad_req)
										+'</dd>';
										$('#card').show();
										$('dl').append(dt);//Pinta contenido de tabla	
								}
							}//fin for ordenes							
				 		}
				 		else //Si hay mas de una Orden APROBADA
						{*/
							$('#orden_id').on('change', function(e) {//detecta el cambio en la seleccion del Select
								e.preventDefault();	

								var orden = document.getElementById("orden_id");//trae el Select de orden
								var aux = orden.options[orden.selectedIndex].value;//trae el ID seleccionado del select
								$('#tablaODC tbody').empty();//Borra la tabla al cambiar de Orden								
								var combo = document.getElementById("producto");	

								if(aux == ''){
									$('#card').hide();
								}

								for(var i in parseado){//Por cada orden aprobada => i>0
					 				for(a in parseado[i].detalle){//Por cada producto del Detalle
						 				if(parseado[i].detalle[a].orden_id == aux){//Se asegura que sea el Detalle de la Orden seleccionada
							 				var tr = '<tr><td hidden="true">'//Genera tabla
											+count
											+'</td><td>'
											+data[parseado[i].detalle[a].pieza_id]
											+'</td><td>'
											+parseInt(parseado[i].detalle[a].cantidad_req)
											+'</td><td><input type="checkbox" class="esta" id="check_is'+a+'"></td></tr>';
											$('#tablaODC').append(tr);//Pinta contenido de tabla

											$('#card').show();
											list.datos.splice(0,list.datos.length);
											count++;//aumenta el contador de filas

											if(list.datos.length == 0){
												$("#productos").val('0');
											}

							 			// 	var dt = '<dt class="list-group-item">'
											// +data[parseInt(parseado[i].detalle[a].pieza_id)]
											// +'</dt><dt class="list-group-item list-group-item-warning">'
											// +parseInt(parseado[i].detalle[a].cantidad_req)
											// +'</dt>';										
											// $('#card').show();
											// $('dl').append(dt);//Pinta contenido de tabla
										}
									}
								}//fin for ordenes								
							}); //fin onchange
						//}
				 	}
//-----------------------------------FIN AGREGAR COMPRAS---------------------------------------------------
			 	}//fin respuesta ajax
				else{}			
			}//fin ajax		
	}//fin funcion contenedora de ajax

//************************************************FIN AJAX*************************************************

		//cargar_all('remitos_agregar');//Llama la funcion creada arriba pasando la Seccion
		cargar_all();//Llama la funcion creada arriba pasando la Seccion

//*********************************************BOTON AGREGAR***********************************************

		$('#agregar').click(function(e){//Detecta el clic en AGREGAR (+)
			e.preventDefault();		
			var combo = document.getElementById("producto");//trae Select de productos
			var selected = combo.options[combo.selectedIndex].text;//Obtiene el nombre seleccionado  
			var cant = document.getElementById("cantidad").value;//trae la cantidad
	 		var price = document.getElementById("precio").value;//trae el precio
	 		var id_prod = combo.options[combo.selectedIndex].value;//Obtiene el ID del producto seleccionado
	
			if(id_prod != '' && cant>0 && price>0){//Valida que no se ingresen valores 0 en Cant y Precio

				if(route == "compras_agregar"){
					$(combo.options[combo.selectedIndex]).attr('disabled','disabled'); //Deshabilita opcion del select

					var tr = '<tr><td hidden="true">'
					+count
					+'</td><td>'
					+selected
					+'</td><td>'
					+cant
					+'</td><td>'
					+price
					+'</td><td>'
					+cant*price
					+'</td><td><input type="button" class="borrar btn btn-danger btn-sm" value="Eliminar"></td></tr>';

					$('#tablaCompra tbody').append(tr); 

				    list.datos.push({
					    "id": count,
					    "pieza_id": id_prod,
					    "producto": selected,
					    "cantidad": cant,
					    "precio": price
				  	});
					
					var json = JSON.stringify(list.datos); //lista de objetos en Json
					count++;
					$("#productos").val(json);	

			//ACTUALIZA Y ACUMULA TOTAL
					for (var item in list.datos){
						var td = parseInt(list.datos[item].precio * list.datos[item].cantidad);
					}

					acum += td;
					$('h5').html("Total: $"+ acum);

					var cant_check=0;

					$('#tablaODC tbody tr').each(function(index,element){									
						if($(this).find("td")[1].innerHTML == selected){
							$(this).find("td")[2].innerHTML = $(this).find("td")[2].innerHTML - cant;
							$(this).find('.esta').prop('checked',true);
						}
						if ($('#check_is'+index+'').prop('checked') ) {
							cant_check ++; 
						}
						if((cant_check == $('#tablaODC tbody tr').length)&&($(this).find("td")[2].innerHTML == 0))
						{
							document.getElementById('card').classList.remove('border-warning');
							document.getElementById('card').classList.add('border-success');							
						}										
					});
				}
				else
				{
					$(combo.options[combo.selectedIndex]).attr('disabled','disabled'); //Deshabilita opcion del select

					var tr = '<tr><td hidden="true">'
					+count
					+'</td><td>'
					+selected
					+'</td><td>'
					+cant
					+'</td><td>'
					+price
					+'</td><td>'
					+cant*price
					+'</td><td><input type="button" class="borrar btn btn-danger btn-sm" value="Eliminar"></td></tr>';

					$('tbody').append(tr); 

				    list.datos.push({
					    "id": count,
					    "pieza_id": id_prod,
					    "producto": selected,
					    "cantidad": cant,
					    "precio": price
				  	});
					
					var json = JSON.stringify(list.datos); //lista de objetos en Json
					count++;
					$("#productos").val(json);	

			//ACTUALIZA Y ACUMULA TOTAL
					for (var item in list.datos){
						var td = parseInt(list.datos[item].precio * list.datos[item].cantidad);
					}

					acum += td;
					$('h5').html("Total: $"+ acum);
				}	 			
			}
			else{
				if(id_prod == ''){
					swal({
					  title: 'Advertencia',
					  text: 'Seleccione un item a agregar.'
					})
				}
				else{
					swal({
					  title: 'Advertencia',
					  text: 'La cantidad/precio ingresados deben ser mayores a 0 (cero).'
					})
				}				
			}
			$('#precio').val('');//limpia los campos
			$('#cantidad').val('');	 		
		});		
//*****************************************FIN BOTON AGREGAR***********************************************

//********************************************BOTON BORRAR*************************************************

//BORRA FILA, ACTUALIZA ARRAY DE PRODUCTOS y TOTAL $
		$('body').on('click', 'input.borrar', function(e){//Detecta clic en Eliminar item	
		   e.preventDefault();

		   var combo = document.getElementById("producto");//trae Select de productos
		   var texto = $(this).parents("tr").find("td")[1].innerHTML;//trae texto del producto borrado
		   var index = $(this).closest("tr").index();//trae el indice de la fila cliqueada
	       var id = $(this).parents("tr").find("td")[0].innerHTML; //trae el id de la columna cliqueada
	       var erase = $(this).parents("tr").find("td")[4].innerHTML;//trae el total de la columna cliqueada
	       var cant_delete = parseInt($(this).parents("tr").find("td")[2].innerHTML);

	       for(i=0; i<$('#producto option').length; i++){//por cada opcion del select
	   			if(combo.options[i].text == texto){//si es el mismo que el producto eliminado	
	   				var pos = combo.options[i].value;//guarda su id
	   			}
	   		}
	   		$("#producto option[value='"+pos+"']").attr('disabled', false);//Habilita producto del select

	        for(var item in list.datos){//Por cada item del arreglo de productos
	        	if(list.datos[item].id == id){//Si el id cliqueado es igual al indice del producto
	       			list.datos.splice(index,1);//Borra el producto a traves de su indice
	       		}
	        }

			if(list.datos.length == 0){//Si se borraron todos los items de la tabla Recarga la pagina asi se asegura que no haya restos	
				location.reload();
			}
			
	        var json = JSON.stringify(list.datos);
			$("#productos").val(json);
	   		$(this).parents('tr').remove();//Remueve la fila 
	   		acum -= erase;//Decrementa Total
	   		$('h5').html("Total: $"+ acum);//Pinta Total
			
			if(route == "compras_agregar"){
	   			$('#tablaODC tbody tr').each(function(index,element){									
					if($(this).find("td")[1].innerHTML == texto){
						$(this).find("td")[2].innerHTML = cant_delete + parseInt($(this).find("td")[2].innerHTML);
						$(this).find('.esta').prop('checked',false);
					}
						document.getElementById('card').classList.remove('border-success');
						document.getElementById('card').classList.add('border-warning');		
				});
	   		}
	   	});    
	});
}

//*****************************************FIN BOTON BORRAR*********************************************

//_____________________________________________________________________________________________________________________________________

//FUNCION PARA CREAR TABLA AGREGAR PRODUCTOS A TAREA
if((route == "tareas_agregar") || (route == "tareas_editar") || (route =="pedidos_agregar") || (route == "pedidos_editar")){
	var contar = 0;
	var lista = {
				 'datos' :[]
				};
	$(function(){	
		// function cargar_items(seccion){
		// 	var url = base + '/admin/' + 'md/api/load/piezas/' + seccion;
		function cargar_items(){
			var url = base + '/admin/' + 'md/api/load/piezas-OP-T';

			http.open('GET', url, true);
			http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
			http.send();
			http.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					var data = this.responseText;
					data = JSON.parse(data);
					
					var content = document.getElementById("productos").value;//trae las ordenes

//-------------------------------------------PEDIDOS EDITAR---------------------------------------------------

						if(route == "pedidos_editar"){
							var parseado = JSON.parse(content);//parsea el json de productos
					 		var orden = document.getElementById("orden_id").value;//trae el Select de orden
					 		var combo = document.getElementById("producto");

							for(i=0; i<$("#producto option").length; i++){	
								for(p in parseado.detalle){
									if(combo.options[i].value == parseado.detalle[p].pieza_id){
										$("#producto option[value='"+combo.options[i].value+"']").attr('disabled', true);
									}
								}			
							}
					 		if(parseado.codigo == orden){
								for(var a in parseado.detalle){			
								//console.log(parseado.detalle[a]) 			
					 				var tr = '<tr><td hidden="true">'//Genera tabla
									+contar
									+'</td><td>'
									+data[parseado.detalle[a].pieza_id]
									+'</td><td>'
									+parseInt(parseado.detalle[a].cantidad_req)
									+'</td><td><input type="button" class="eliminar btn btn-danger btn-sm" value="Eliminar"></td></tr>';

									$('tbody').append(tr);//Pinta contenido de tabla	
					 				
						 			lista.datos.push({//Llena arreglo de Datos que se van a pasar al controlador
									    "id": contar,
									    "pieza_id": parseado.detalle[a].pieza_id.toString(),
									    "producto": data[parseInt(parseado.detalle[a].pieza_id)],
									    "cantidad": parseado.detalle[a].cantidad_req.toString()
									});										
								contar++;//aumenta el contador de filas
								}
							}
							var json = JSON.stringify(lista.datos);//lista de objetos en Json
							$("#productos").val(json);//Pasa el valor al Input de productos que luego se maneja en el Controlador
						}

//-------------------------------------------FIN PEDIDOS EDITAR-----------------------------------------------

//-------------------------------------------TAREAS EDITAR---------------------------------------------------

						if(route == "tareas_editar"){
							var parseado = JSON.parse(content);//parsea el json de productos
					 		var orden = document.getElementById("orden_id").value;//trae el Select de orden
					 		var combo = document.getElementById("producto");

					 		if(parseado.codigo == orden){
								for(var a in parseado.detalle){			
								//console.log(parseado.detalle[a]) 			
					 				var tr = '<tr><td hidden="true">'//Genera tabla
									+contar
									+'</td><td>'
									+data[parseado.detalle[a].pieza_id]
									+'</td><td>'
									+parseInt(parseado.detalle[a].cantidad_req)
									+'</td><td><input type="checkbox" class="esta" id="check_is'+a+'"></td></tr>';

									$('#tablaTarea').append(tr);//Pinta contenido de tabla
									
						 			// lista.datos.push({//Llena arreglo de Datos que se van a pasar al controlador
									//     "id": contar,
									//     "pieza_id": parseado.detalle[a].pieza_id.toString(),
									//     "producto": data[parseInt(parseado.detalle[a].pieza_id)],
									//     "cantidad": parseado.detalle[a].cantidad_req.toString()
									// });
									$('#tablaTarea').show();
								lista.datos.splice(0,lista.datos.length);
								contar++;//aumenta el contador de filas
								}
							}
							 var json = JSON.stringify(lista.datos);//lista de objetos en Json
							 $("#productos").val(json);//Pasa el valor al Input de productos que luego se maneja en el Controlador
						}
//-------------------------------------------FIN TAREAS EDITAR-----------------------------------------------
				}	
				else{}			
			}		
		}
	
		cargar_items();

//*********************************************BOTON AGREGAR***********************************************

		//agrega fila a tabla tarea
		$('#agregar_item').click(function(e){
			e.preventDefault();		
			var seleccion = document.getElementById("producto"); //select de productos
			var selected = seleccion.options[seleccion.selectedIndex].text;//nombre de la seleccion			
	 		var id_prod = seleccion.options[seleccion.selectedIndex].value;	//id del producto	 	

//---------------------------------------------- TAREAS AGREGAR-----------------------------------------------	 	

	 			 if(route == "tareas_agregar"){	//Si es la ruta tareas_agregar, va a fijarse en el stock
	 			 	var cant = document.getElementById("cantidad").value;//cantidad ingresada
	 			 	var max = $('#cantidad').attr('max'); //trae todos los productos para ver el atributo MAX
					max = JSON.parse(max); //convertidos a objetos para manejarlos y llegar a la cantidad de cada producto					
					
					if(id_prod != '' && cant>0){//esto valida que no se ingresen valores 0	
						for(item in max){		
							if(seleccion.value == max[item].id){
								if(max[item].cantidad < cant){
									swal({
									  title: 'Advertencia',
									  text: 'La cantidad ingresada supera el stock.'
									})	
								}
								else
								{
									$(seleccion.options[seleccion.selectedIndex]).attr('disabled','disabled'); //Deshabilita opcion del select

									var tr = '<tr><td hidden="true">'
									+contar
									+'</td><td>'
									+selected
									+'</td><td>'
									+cant
									+'</td><td><input type="button" class="eliminar btn btn-danger btn-sm" value="Eliminar"></td></tr>';

									$('tbody').append(tr);

								    lista.datos.push({
									    "id": contar,
									    "pieza_id": id_prod,
									    "producto": selected,
									    "cantidad": cant
								  	});

									var json = JSON.stringify(lista.datos); // aqui tienes la lista de objetos en Json
									contar++;
									$("#productos").val(json);	
								}
							}						
						}
					}
					else
					{
						if(id_prod == ''){
							swal({
							  title: 'Advertencia',
							  text: 'Seleccione un item a agregar.'
							})
						}
						else{
							swal({
							  title: 'Advertencia',
							  text: 'La cantidad/precio ingresados deben ser mayores a 0 (cero).'
							})
						}
					}
	 			}			

//-------------------------------------------FIN TAREAS AGREGAR-----------------------------------------------
//-----------------------------------------------DEMAS RUTAS--------------------------------------------------

	 			if((route != "tareas_agregar")&&(route != "tareas_editar")){

	 				var cant = document.getElementById("cantidad").value;//cantidad ingresada
	 				
	 				if(id_prod != '' && cant>0){//esto valida que no se ingresen valores 0
						$(seleccion.options[seleccion.selectedIndex]).attr('disabled','disabled'); //Deshabilita opcion del select

						var tr = '<tr><td hidden="true">'
						+contar
						+'</td><td>'
						+selected
						+'</td><td>'
						+cant
						+'</td><td><input type="button" class="eliminar btn btn-danger btn-sm" value="Eliminar"></td></tr>';

						$('tbody').append(tr);

					    lista.datos.push({
						    "id": contar,
						    "pieza_id": id_prod,
						    "producto": selected,
						    "cantidad": cant
					  	});

						var json = JSON.stringify(lista.datos); // aqui tienes la lista de objetos en Json
						contar++;
						$("#productos").val(json);	
					}
					else
					{
						if(id_prod == ''){
							swal({
							  title: 'Advertencia',
							  text: 'Seleccione un item a agregar.'
							})
						}
						else{
							swal({
							  title: 'Advertencia',
							  text: 'La cantidad/precio ingresados deben ser mayores a 0 (cero).'
							})
						}
					}
				}
//-------------------------------------------FIN DEMAS RUTAS-------------------------------------------------
//---------------------------------------------- TAREAS EDITAR-----------------------------------------------

			if(route == "tareas_editar"){	//Si es la ruta tareas_agregar, va a fijarse en el stock

 			 	var max = $('#cantidad_usada').attr('max'); //trae todos los productos para ver el atributo MAX
				max = JSON.parse(max); //convertidos a objetos para manejarlos y llegar a la cantidad de cada producto					
				var cant_use = document.getElementById("cantidad_usada").value;//cantidad ingresada
				
				if(id_prod != '' && cant_use>0){

					for(item in max){		
						if(seleccion.value == max[item].id){
							if(max[item].cantidad <= cant_use){
								swal({
								  title: 'Advertencia',
								  text: 'La cantidad ingresada supera el stock.'
								})	
							}
							else
							{							
								$(seleccion.options[seleccion.selectedIndex]).attr('disabled','disabled'); //Deshabilita opcion del select
								var tr = '<tr><td hidden="true">'
								+contar
								+'</td><td>'
								+selected
								+'</td><td>'
								+cant_use
								+'</td><td><input type="button" class="eliminar btn btn-danger btn-sm" value="Eliminar"></td></tr>';

								$('#tabla').append(tr);

							    lista.datos.push({
								    "id": contar,
								    "pieza_id": id_prod,
								    "producto": selected,
								    "cantidad": cant_use
							  	});

								var json = JSON.stringify(lista.datos); // aqui tienes la lista de objetos en Json
								contar++;
								$("#productos").val(json);

								var cant_check=0;

								$('#tablaTarea tbody tr').each(function(index,element){									
									if($(this).find("td")[1].innerHTML == selected){
										$(this).find("td")[2].innerHTML = $(this).find("td")[2].innerHTML - cant_use;
										$(this).find('.esta').prop('checked',true);
									}
									if ($('#check_is'+index+'').prop('checked') ) {
										cant_check ++; 
									}
									if((cant_check == $('#tablaTarea tbody tr').length)&&($(this).find("td")[2].innerHTML == 0))
									{
										document.getElementById('card_check').classList.remove('border-warning');
										document.getElementById('card_check').classList.add('border-success');							
									}										
								});
							}
						}						
					}
				}
				else
					{
						if(id_prod == ''){
							swal({
							  title: 'Advertencia',
							  text: 'Seleccione un item a agregar.'
							})
						}
						else{
							swal({
							  title: 'Advertencia',
							  text: 'La cantidad/precio ingresados deben ser mayores a 0 (cero).'
							})
						}
					}				
 			}
//-------------------------------------------FIN TAREAS EDITAR-----------------------------------------------

			$('#cantidad').val('');	//limpia campo cantidad luego de ingresar algun valor
			$('#cantidad_usada').val('');	//limpia campo cantidad luego de ingresar algun valor
		});				

//*****************************************FIN BOTON AGREGAR***********************************************

//********************************************BOTON BORRAR*************************************************

	//BORRA FILA, ACTUALIZA ARRAY DE PRODUCTOS y TOTAL $
		$('body').on('click', 'input.eliminar', function(e) {		
		   e.preventDefault();
		   var combo = document.getElementById("producto");//trae Select de productos
		   var texto = $(this).parents("tr").find("td")[1].innerHTML;//trae texto del producto borrado
		   var index = $(this).closest("tr").index();
	       var id = $(this).parents("tr").find("td")[0].innerHTML; 
	       var cant_delete = parseInt($(this).parents("tr").find("td")[2].innerHTML);

	       for(i=0; i<$('#producto option').length; i++){//por cada opcion del select
	   			if(combo.options[i].text == texto){//si es el mismo que el producto eliminado	
	   				var pos = combo.options[i].value;//guarda su id
	   			}
	   		}
	   		$("#producto option[value='"+pos+"']").attr('disabled', false);//Habilita producto del select

	       for(var item in lista.datos){     	
	        	if(lista.datos[item].id == id){
	       			lista.datos.splice(index,1);
	       		}
	       }
			if(lista.datos.length == 0){			
				location.reload();
			}
			
	        var json = JSON.stringify(lista.datos);
			$("#productos").val(json);
	   		$(this).parents('tr').remove(); 

	   		if(route == "tareas_editar"){
	   			$('#tablaTarea tbody tr').each(function(index,element){									
					if($(this).find("td")[1].innerHTML == texto){
						$(this).find("td")[2].innerHTML = cant_delete + parseInt($(this).find("td")[2].innerHTML);
						$(this).find('.esta').prop('checked',false);
					}
						document.getElementById('card_check').classList.remove('border-success');
						document.getElementById('card_check').classList.add('border-warning');		
				});
	   		}
	   	});  

//*****************************************FIN BOTON ELIMINAR***********************************************

	});
}

/*----------------------------------------------------------------------------------------------------------------------*/
// SIDEBAR OCULTO
function abrir(){
	document.getElementById('sidebar').style.display = "block";
	document.getElementById('cuerpo').style.display = "none";
	document.getElementById('footer').style.display = "none";
}

function cerrar(){
	document.getElementById('sidebar').style.display = "none";
	document.getElementById('cuerpo').style.display = "block";
	document.getElementById('footer').style.display = "block";
}

 $(window).resize(function () {
   if ($(window).width() > 1267) {   	   
       document.getElementById('cuerpo').style.display = "block";
       document.getElementById('sidebar').style.display = "block";
       document.getElementById('footer').style.display = "block";
       document.getElementById('navCuenta').classList.add('justify-content-end');
   }
   
   if ($(window).width() <= 1267) {   		
   		document.getElementById('navCuenta').classList.remove('justify-content-end');
       	cerrar();
   }
   if(route == 'inicio'){
	   if($(window).width() <= 720 ){
	   		document.getElementById('grupo-btn').classList.add('btn-group-vertical');
	   		document.getElementById('grupo-btn').classList.remove('btn-group');
	   	   
	   }else{
			document.getElementById('grupo-btn').classList.remove('btn-group-vertical');
	   	 	document.getElementById('grupo-btn').classList.add('btn-group');
	   }
	}
});
/*---------------------------------------------------------------------------------------------------------------------*/
//FUNCION BOTON BACKUP
if(route == "backup" || route == "backup_create"){
$(document).ready(function(){
	$('#create_b').click(function() {
		$('#create_b').hide(); 
		$('#cargando').show();
	 });
})};

//----------------------------------------------------------------------------------------------------------------------*/
//FUNCION PARA MOSTRAR TITULO DE CATEGORIA SELECCIONADA
if(route == 'categorias'){
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
}
//----------------------------------------------------------------------------------------------------------------------*/
//DESACTIVA BOTONES E INSPECTOR DE NAVEGADOR
if(route == "compras_agregar" || route == "compra_detalle" || route == "tareas_agregar" || route == "tarea_detalle"){
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
//FUNCION AJAX CARGAR PIEZAS
var items_bdd = [];
function cargar_items(seccion){
	var url = base + '/admin/' + 'md/api/load/piezas/' + seccion;

	http.open('GET', url, true);
	http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
	http.send();
	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var data = this.responseText;
			data = JSON.parse(data);
			for(var item in data){
				items_bdd[item]=data[item];	
			}				
		}
		else{}			
	}
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

//------------------------------------------------------------------------------------------------------------------------------
//FUNCION PARA CREAR TABLA AGREGAR PRODUCTOS A COMPRA
/*if(route == "remitos_agregar" || route == "compras_agregar"){
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
}*/
//------------------------------------------------------------------------------------------------------------------------------
//FUNCION CALCULA TOTAL PANEL INICIO
/*
var acum_tot_compras = 0;
$(document).ready(function(){
	let today = new Date();
	var json_c = document.getElementById('all_prods').value;
	var Obj_c = JSON.parse(json_c);
	for(var item in Obj_c){
		var aux = Obj_c[item];
		var fecha = new Date(aux.created_at)
		if(fecha.getFullYear() == today.getFullYear()){
			if(fecha.getMonth() == today.getMonth()){
				var prods = JSON.parse(aux.productos)
				for(var i in prods){
				var aux2=prods[i];
				acum_tot_compras += parseInt(aux2.cantidad*aux2.precio);
				}
			}
		}	
	}
	$('h3').append(acum_tot_compras);
});
*/