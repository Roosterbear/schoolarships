<div class="col-lg-12">
		<h1 class="gris"><strong>ABC Validadores de Becas</strong></h1>
		<div class="row">
			<div class="col-lg-12">

				<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
				<!-- @@@@@@@@@@@@@@@@ ALTA VALIDADORES @@@@@@@@@@@@@@@@@  -->  
				<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
				
				<div class="col-lg-6">
				<div class="row">
				<form id="alta_validadores" name="alta_validadores" method="post" action="#" role="form">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-8">
								<label for="ingresar_usuario">
									<h4>Ingresar clave de usuario: </h4>
								</label>
								<div class="input-group">
									<input type="text" id="data_ingresar_usuario" name="data_ingresar_usuario" value="" class="form-control" />
									<span class="input-group-btn">
										<button type="button" campo class="btn btn-md btn-success form-element" id="btn_ingresar_usuario" title="ingresar usuario">
											<i class="fa fa-arrow-right"></i>
										</button>
									</span>
								</div>
								<br />
		                		<div class="input-group">
				                  <input type="text" id="data_nombre_usuario" name="data_nombre_usuario" value="" disabled="disabled" class="form-control" />
				                  <span class="input-group-btn">
				                    <button type="button" campo class="btn btn-md btn-success form-element" id="btn_agregar_validador" title="Agregar validador">
				                    Agregar </button>
				                  </span>
				                </div>
								<br />
								<!-- Tipo de Beca que puede ver el Validador -->  
								<div id="div_tipo">
									<div id="form_space" class="input-group">
										<div class="text-right">
											<div class="numero">1</div>
										</div>	
										<legend>Tipo de Beca que puede ver el Validador</legend>
										<input type="checkbox" name="becas_chk" id="beca_academica_chk" checked="checked"> Becas Acad&eacute;micas<br />
										<input type="checkbox" name="becas_chk" id="beca_deportiva_chk" checked="checked"> Becas Deportivas / Culturales<br />
										<input type="checkbox" name="becas_chk" id="beca_transporte_chk" checked="checked"> Becas Transporte<br /><br />
										<div class="text-right">
											<button type="button" campo class="btn btn-md btn-success form-element" id="btn_div_tipo" title="Tipo de Beca">
									    	<i class="fa fa-floppy-o"></i> Guardar</button>
									    </div>
									</div>
								</div>
								<br />

								<!-- Carreras que puede ver el Validador -->  
								<div id="div_carreras">
									<div id="form_space" class="input-group">
										<div class="text-right">
											<div class="numero">2</div>
										</div>	
										<legend>Coordinaciones a las que puede acceder el Validador</legend>
										<input type="checkbox" name="todas_chk" id="todas_chk" checked="checked"> <strong>Todas las carreras (por Coordinaci&oacute;n)</strong><br />
										<br />
										<input type="checkbox" name="carreras_chk" id="aarh_chk"> Administraci&oacute;n<br />
										<input type="checkbox" name="carreras_chk" id="dnam_chk"> Desarrollo de Negocios<br />
										<input type="checkbox" name="carreras_chk" id="mai_chk"> Mantenimiento<br />
										<input type="checkbox" name="carreras_chk" id="mt_chk"> Mecatr&oacute;nica<br />
										<input type="checkbox" name="carreras_chk" id="piam_chk"> Param&eacute;dico / Procesos<br />
										<input type="checkbox" name="carreras_chk" id="tics_chk"> Tecnolog&iacute;as de la Informaci&oacute;n<br /><br />
										<div class="text-right">
											<button type="button" campo class="btn btn-md btn-success form-element" id="btn_div_carreras" title="Carreras Validador">
									    	<i class="fa fa-floppy-o"></i> Guardar</button>
									    </div>
									</div>
								</div>
								<br />

								<!-- Restricciones que puede autorizar el Validador -->  
								<div id="div_restricciones">
									<div id="form_space" class="input-group">
										<div class="text-right">
											<div class="numero">3</div>
										</div>	
										<legend>Restricciones que puede autorizar el Validador</legend>
										<input type="checkbox" name="restricciones_chk" id="promedio_chk"> Promedio 8.5<br />
										<input type="checkbox" name="restricciones_chk" id="servicio_chk" checked="checked"> Servicio Social<br />
										<input type="checkbox" name="restricciones_chk" id="seleccion_chk"> Formar parte de una selecci&oacute;n<br />
										<input type="checkbox" name="restricciones_chk" id="comprobante_chk"> Comprobante de domicilio<br />
										<input type="checkbox" name="restricciones_chk" id="alumno_chk"> Ser un alumno regular<br />
										<input type="checkbox" name="restricciones_chk" id="inscrito_chk"> Estar inscrito<br />
										<input type="checkbox" name="restricciones_chk" id="zona_chk"> Vivir fuera de la zona urbana sin transporte<br /><br />
										<div class="text-right">
											<button type="button" campo class="btn btn-md btn-success form-element" id="btn_div_restricciones" title="Restricciones Validador">
									    	<i class="fa fa-floppy-o"></i> Guardar</button>
									    </div>
									</div>
								</div>
								<br />
							</div>	
						</div>
					</div>
					<br>
					
				</form>
				</div>
				</div>


				<div class="col-lg-6">
					<div class="row">

						<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
						<!-- @@@@@@@@@@@@@@@@ MODIFICAR VALIDADORES @@@@@@@@@@@@@@@@  -->  
						<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  

						<h4><i class="fa fa-pencil-square"></i> Modificar un validador: </h4>	
						<select id="modificar_validador" name="modificar_validador" class="form-control">
							<option value="0">Seleccione validador a modificar</option>
							<?php foreach ($lista_grupo_seguridad as $g) { ?>
								<option value="<?=$g['cve_empleado']?>">[<?=$g['cve_empleado']?>] <?=$g['nombre']?></option>';
							<?php }  ?>
						</select>
						<br />

						<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
						<!-- @@@@@@@@@@@@@@ ELIMINAR VALIDADORES @@@@@@@@@@@@@@@  -->  
						<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --> 
				
						<div id = "eliminar">
							<h4><i class="fa fa-eraser" aria-hidden="true"></i> Eliminar una validador: </h4>	
			                <div class="input-group col-lg-4">
			                  <input type="text" id="data_id_borrar_validador" name="data_id_borrar_validador" value="" class="form-control" maxlength="8">
			                  <span class="input-group-btn">
			                    <button type="button" campo class="btn btn-md btn-success form-element" id="btn_borrar_validador" title="Eliminar validador">
			                    <i class="fa fa-floppy-o"></i></button>
			                  </span>
			                </div>
						</div>
						<br />
						<!-- fin de eliminar validadores -->  



						<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
						<!-- @@@@@@@@@@@@@@ MODIFICAR VALIDACIONES @@@@@@@@@@@@@@@  -->  
						<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --> 

						<div id="modificar_validadores">
							<div id="form_space" class="input-group">
								<!-- Tipo de Beca que puede ver el Validador -->  	
								<legend>Tipo de Beca que puede ver el Validador</legend>
								
								<!-- DIV dinamico donde se cargan los filtros de tipo de beca x usuario-->  
								<div id="printBecas"></div>


								<!-- Carreras que puede ver el Validador -->  
								<legend>Carreras que puede acceder el Validador</legend>
								
								<!-- DIV dinamico donde se cargan los filtros de carreras x usuario -->  
								<div id="printCarreras"></div>

								<!-- Restricciones que puede autorizar el Validador -->  
								<legend>Restricciones que puede autorizar el Validador</legend>
								
								<!-- DIV dinamico donde se cargan los filtros de restricciones x usuario -->  
								<div id="printRestricciones"></div>
								
							</div>
						</div>



						<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
						<!-- @@@@@@@@@@@@@@@@@@ LISTADO VALIDADORES @@@@@@@@@@@@@@@@  -->  
						<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  

						<div id="listado_validadores" class="hidden-xs">
							<div class="col-lg-12 seccion detalle">
								<h4><i class="fa fa-graduation-cap"></i> Listado Validadores</h4>
								<table class="table table-stripped table-condensed table-bordered table-hover">
									<tr>
										<th class="text-center titular">Usuario</th>
										<th class="text-center titular">Nombre</th>
									</tr>
									<?php 
										foreach ($lista_grupo_seguridad as $g) { 
											
									?>
										<tr> <!-- //  -->  
											<td class="text-center text-info"><?=$g['cve_empleado']?></td>
											<td class="text-warning"><?=$g['nombre']?></td>
										</tr>
									<?php }  ?>
								</table>
							</div>
						</div>
						<!-- fin de listado validadores -->  
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">

$(document).ready(function(){	
	$('#btn_agregar_validador').attr("disabled", true);
	$("#aarh_chk").attr("disabled", true);
	$("#dnam_chk").attr("disabled", true);
	$("#mai_chk").attr("disabled", true);
	$("#mt_chk").attr("disabled", true);
	$("#piam_chk").attr("disabled", true);
	$("#tics_chk").attr("disabled", true);
});

// ----------------------------------------
// Boton para cargar usuario a dar de alta
// ----------------------------------------

function buscarValidador(){
      var usuario = $("#data_ingresar_usuario").val();
      $.post("<?=base_url()?>"+"index.php/Validador/esEmpleado/",{usuario:usuario},function(resp){          
            var nombre = resp;
            if (nombre == ""){
                  mensajeLobibox('error','No existe usuario');                
            }else{
                  $.post("<?=base_url()?>"+"index.php/Validador/esValidador/",{usuario:usuario},function(resp){
                        var esValidador = resp;
                        $("#data_nombre_usuario").val(nombre);    
                        if (esValidador > 0){
                              mensajeLobibox('warning','Este usuario ya es Validador');
                        }else{
                              $("#data_nombre_usuario").val(nombre);    
                              $('#btn_agregar_validador').attr("disabled", false);  
                              $("#data_ingresar_usuario").attr("disabled", true);         
                              $("#limpiar").show();                     
                        }
                  });
            }
      });   
}  

$("#data_ingresar_usuario").on("keydown",function(e){
	if(e.keyCode == 13){
		e.preventDefault();
		e.stopImmediatePropagation();
		buscarValidador();
	}
});

$("#btn_ingresar_usuario").click(function(){
	   buscarValidador();
});


// ------------------------------
// Boton para agregar Validador
// ------------------------------

function agregarValidador(){
	var usuario = $("#data_ingresar_usuario").val();
      $.post("<?=base_url()?>"+"index.php/Validador/insertValidador/",{usuario:usuario},function(resp){           
            var agregado = resp;
            
            if (agregado > 0){
                  mensajeLobibox('success','Agregado '+usuario);
                  $("#div_tipo").show();
            }
      });
}

$("#btn_agregar_validador").click(function(){
	agregarValidador();	
});


// ------------------------------
// Boton para borrar Validador
// ------------------------------

function borrarValidador(){
      var usuario = $("#data_id_borrar_validador").val();
      $.post("<?=base_url()?>"+"index.php/Validador/deleteValidador/",{usuario:usuario},function(resp){           
            var eliminado = resp;

            if (eliminado > 0){
                  mensajeLobibox('info','Eliminado '+usuario);
            }else{
                  mensajeLobibox('error',usuario+' no es un Validador');
            }
      });
}

$("#data_id_borrar_validador").on("keydown",function(e){
	if(e.keyCode == 13){
		e.preventDefault();
		e.stopImmediatePropagation();
		borrarValidador();
	}
});

$("#btn_borrar_validador").click(function(){
	borrarValidador();
});


// --------------------
// Modificar Validador
// --------------------

$("#modificar_validador").change(function(){
	var usuario = $("#modificar_validador").val();

	if (usuario == "0"){
		$("#listado_validadores").show();
		$("#eliminar").show();
		$("#modificar_validadores").hide();
	}else{
		$("#listado_validadores").hide();
		$("#eliminar").hide();
		$("#modificar_validadores").show();
	}

	// Con esta funcion desplegamos los filtros de becas que tenga activados el usuario
	$.post("<?=base_url()?>"+"index.php/Validador/displayFiltros/",{usuario:usuario,filtro:'1'},function(resp){
		 var html_code = resp;
		 $("#printBecas").html(html_code);
	});

	// Con esta funcion desplegamos los filtros de carreras que tenga activados el usuario
	$.post("<?=base_url()?>"+"index.php/Validador/displayFiltros/",{usuario:usuario,filtro:'2'},function(resp){
		 var html_code = resp;
		 $("#printCarreras").html(html_code);
	});

	// Con esta funcion desplegamos los filtros de restricciones que tenga activados el usuario
	$.post("<?=base_url()?>"+"index.php/Validador/displayFiltros/",{usuario:usuario,filtro:'3'},function(resp){
		 var html_code = resp;
		 $("#printRestricciones").html(html_code);
	});
});


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// Las funciones de agregar aceptan 2 parametros
// parametro1 -> indica si es filtro de tipo de beca, carrera o restriccion
// parametro2 -> indica la opcion: cual tipo de beca(3), cual carrera[coordinacion](6) o cual restriccion(7)
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

$("#printBecas").on('click',function(){ //<--Para que agarre IDs dinamicos, debemos encerrarlos en un evento de ID padre
	$("#beca_academica_mod").on('change',function(e){
		if($("#beca_academica_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(1,1);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(1,1);
		}
	});

	$("#beca_deportiva_mod").on('change',function(e){
		if($("#beca_deportiva_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(1,2);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(1,2);
		}
	});

	$("#beca_transporte_mod").on('change',function(e){
		if($("#beca_transporte_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(1,3);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(1,3);
		}
	});
});

$("#printCarreras").on('click',function(){
	$("#aarh_mod").on('change',function(e){
		if($("#aarh_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(2,1);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(2,1);
		}
	});

	$("#dnam_mod").on('change',function(e){
		if($("#dnam_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(2,2);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(2,2);
		}
	});

	$("#mai_mod").on('change',function(e){
		if($("#mai_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(2,3);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(2,3);
		}
	});

	$("#mt_mod").on('change',function(e){
		if($("#mt_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(2,4);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(2,4);
		}
	});

	$("#piam_mod").on('change',function(e){
		if($("#piam_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(2,5);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(2,5);
		}
	});

	$("#tics_mod").on('change',function(e){
		if($("#tics_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(2,6);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(2,6);
		}
	});
});

$("#printRestricciones").on('click',function(){
	$("#promedio_mod").on('change',function(e){
		if($("#promedio_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(3,1);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(3,1);
		}
	});

	$("#servicio_mod").on('change',function(e){
		if($("#servicio_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(3,2);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(3,2);
		}
	});

	$("#seleccion_mod").on('change',function(e){
		if($("#seleccion_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(3,3);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(3,3);
		}
	});

	$("#comprobante_mod").on('change',function(e){
		if($("#comprobante_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(3,4);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(3,4);
		}
	});

	$("#alumno_mod").on('change',function(e){
		if($("#alumno_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(3,5);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(3,5);
		}
	});

	$("#inscrito_mod").on('change',function(e){
		if($("#inscrito_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(3,6);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(3,6);
		}
	});

	$("#zona_mod").on('change',function(e){
		if($("#zona_mod").prop('checked')){
			e.stopImmediatePropagation();
			agregarUnFiltro(3,7);		
		}else{
			e.stopImmediatePropagation();
			borrarUnFiltro(3,7);
		}
	});
});

// @@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@
// ------- Filtros -------
// @@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@

// Esta toma el usuario en ALTA
function agregarFiltros(validacion,dato){
	var usuario = $("#data_ingresar_usuario").val();
	$.post("<?=base_url()?>"+"index.php/Validador/modifyValidador/",{usuario:usuario,validacion:validacion,dato:dato,borrar:'0'});
}



// Estas 2 funciones toman el usuario del SELECT de modificacion
function agregarUnFiltro(validacion,dato){
	var usuario = $("#modificar_validador").val();
	var mensaje = "Filtro agregado";
	$.post("<?=base_url()?>"+"index.php/Validador/modifyValidador/",{usuario:usuario,validacion:validacion,dato:dato,borrar:'0'});
	mensajeLobibox('success',mensaje);
}

function borrarUnFiltro(validacion,dato){
	var usuario = $("#modificar_validador").val();
	var mensaje = "Filtro eliminado";
	$.post("<?=base_url()?>"+"index.php/Validador/modifyValidador/",{usuario:usuario,validacion:validacion,dato:dato,borrar:'1'});
	mensajeLobibox('error',mensaje);
}


// FILTRO TIPO DE BECA Validacion = 1
$("#btn_div_tipo").click(function(){
		var mensaje = 'Tipos de Beca agregados';

		if($("#beca_academica_chk").prop('checked')){agregarFiltros(1,1);}

		if($("#beca_deportiva_chk").prop('checked')){agregarFiltros(1,2);}

		if($("#beca_transporte_chk").prop('checked')){agregarFiltros(1,3);}

		mensajeLobibox('success',mensaje);
	   $("#div_tipo").html(mensajeHtml0k(mensaje));
	   $("#div_carreras").show();
});

// FILTRO CARRERAS Validacion = 2
$("#todas_chk").change(function(){
	var todas_sw = $('input[name="todas_chk"]:checked').val();
	
	if (todas_sw){
		$("#aarh_chk").attr("disabled", true);
		$("#dnam_chk").attr("disabled", true);
		$("#mai_chk").attr("disabled", true);
		$("#mt_chk").attr("disabled", true);
		$("#piam_chk").attr("disabled", true);
		$("#tics_chk").attr("disabled", true);
	}else{
		$("#aarh_chk").attr("disabled", false);
		$("#dnam_chk").attr("disabled", false);
		$("#mai_chk").attr("disabled", false);
		$("#mt_chk").attr("disabled", false);
		$("#piam_chk").attr("disabled", false);
		$("#tics_chk").attr("disabled", false);
	}
});

$("#btn_div_carreras").click(function(){
		var mensaje = 'Carreras agregadas';

		if ($("#todas_chk").prop('checked')){
			// Agregamos TODAS las carreras
			agregarFiltros(2,1);
			agregarFiltros(2,5);
			agregarFiltros(2,2);
			agregarFiltros(2,3);
			agregarFiltros(2,4);
			agregarFiltros(2,6);
		}else{
			if($("#aarh_chk").prop('checked')){agregarFiltros(2,1);}
			if($("#dnam_chk").prop('checked')){agregarFiltros(2,5);}
			if($("#mai_chk").prop('checked')){agregarFiltros(2,2);}
			if($("#mt_chk").prop('checked')){agregarFiltros(2,3);}
			if($("#piam_chk").prop('checked')){agregarFiltros(2,4);}
			if($("#tics_chk").prop('checked')){agregarFiltros(2,6);}	
		}

		mensajeLobibox('success',mensaje);
	   $("#div_carreras").html(mensajeHtml0k(mensaje));
	   $("#div_restricciones").show();
});

// FILTRO RESTRICCIONES Validacion = 3
$("#btn_div_restricciones").click(function(){
	var mensaje = 'Restricciones agregadas';

	if($("#promedio_chk").prop('checked')){agregarFiltros(3,1);}

	if($("#servicio_chk").prop('checked')){agregarFiltros(3,2);}

	if($("#seleccion_chk").prop('checked')){agregarFiltros(3,3);}
	
	if($("#comprobante_chk").prop('checked')){agregarFiltros(3,4);}

	if($("#alumno_chk").prop('checked')){agregarFiltros(3,5);}

	if($("#inscrito_chk").prop('checked')){agregarFiltros(3,6);}

	if($("#zona_chk").prop('checked')){agregarFiltros(3,7);}

	mensajeLobibox('success',mensaje);
   $("#div_restricciones").html(mensajeHtml0k(mensaje));
});


// ------------------------------------------------------------------
// Cambio de color al dar click al boton de actualizar datos
// ------------------------------------------------------------------
$("[campo]").click(function(){  
    var myID = $(this).attr("id");
    $('#'+myID).addClass("btn-warning");
    setTimeout(
        function(){
            $('#'+myID).removeClass("btn-warning");
        }, 800);
});
// ------------------------------------------------------------------
</script>