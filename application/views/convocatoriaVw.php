<div class="col-lg-12">
	<h1 class="gris"><strong>ABC Convocatorias de Beca</strong></h1>
	<div class="row">
		<div class="col-lg-12">

			<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
			<!-- @@@@@@@@@@@@@@@@ ALTA CONVOCATORIA @@@@@@@@@@@@@@@@  -->  
			<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
			
			<div class="col-lg-5">
			<div class="row">
			<form id="alta_convocatorias" name="alta_convocatorias" method="post" action="http://sito-misc.app.utags.edu.mx/becas_plus/index.php/Convocatoria/insertConvocatoria" role="form">
				<div class="col-lg-12">
					<label for="tipo_beca">
					<h4><span class="verde"><i class="fa fa-graduation-cap"></i></span> Tipo de Beca: </h4>
					</label>
					<select id="tipo_beca" name="tipo_beca" class="form-control">
						<option value="0">Seleccione el tipo de beca</option>
						<?php foreach ($convocatorias as $c) { ?>
							<option value="<?=$c['id']?>"><?=$c['descripcion']?></option>';
						<?php }  ?>
					</select>
				</div>
				<div class="col-lg-6">
			        <label for="periodo_publicacion"><h4><i class="fa fa-hourglass-half"></i> Periodo de publicaci&oacute;n: </h4></label>     
			        <input type="text" id="periodo_publicacion" name="periodo_publicacion" value="<?=$periodo_actual?>" disabled="disabled" class="form-control" />      
			    </div>
			    <div class="col-lg-6">
			        <label for="periodo_aplicacion"><h4><i class="fa fa-hourglass"></i> Periodo de aplicacion: 
			        	<?=$next?'':'<small><a href="#"> No existe periodo siguiente</a></small>'?></h4></label>     
			        <input type="text" id="periodo_aplicacion" name="periodo_aplicacion" value="<?=$next?$periodo_siguiente:$periodo_actual?>" disabled="disabled" class="form-control" />      
			    </div>

				<div class="col-lg-4">
			        <label for="fecha_publicacion"><h4><i class="fa fa-calendar"></i> Fecha de publicaci&oacute;n: </h4></label>     
			        <input type="text" id="fecha_publicacion" name="fecha_publicacion" calendario value="<?=$fecha_hoy?>" class="form-control" />      
			    </div>
			    <div class="col-lg-4">
			        <label for="fecha_vencimiento"><h4><i class="fa fa-calendar"></i> Fecha de vencimiento: </h4></label>     
			        <input type="text" id="fecha_vencimiento" name="fecha_vencimiento" calendario value="<?=$fecha_hoy?>" class="form-control" />      
			    </div>
			    <div class="col-lg-4">
			        <label for="fecha_resultados"><h4><i class="fa fa-calendar"></i> Fecha de resultados: </h4></label>     
			        <input type="text" id="fecha_resultados" name="fecha_resultados" calendario value="<?=$fecha_hoy?>" class="form-control" />      
			    </div>
			    <div class="col-lg-12">
				    <label for="descripcion"><h4><span class="rojo"><i class="fa fa-pencil"></i></span> Descripci&oacute;n: </h4></label>     
				    <input type="text" id="descripcion" name="descripcion" value="" class="form-control" />
				</div>
				<div class="col-lg-12">
				    <label for="fecha_limite_inscripcion"><h4><span class="amarillo"><i class="fa fa-exclamation-triangle"></i></span> Fecha L&iacute;mite de Inscripci&oacute;n: </h4></label>     
				    <input type="text" id="fecha_limite_inscripcion" name="fecha_limite_inscripcion" value="" placeholder="Por ejemplo: 5 de enero del 2018" class="form-control" />
				    <span><u>Este texto es el que aparecer&aacute; como fecha limite de inscripci&oacute;n en los requisitos</u></span>
				</div>
			    <div class="col-lg-12">
				    <div class="col-lg-4 text-center">
				    </div> 
				    <div class="col-lg-4 text-center">
				    	<br>
				    	<a href="#" id="enviar" class="btn btn-success btn-lg">Crear Convocatoria</a>
				    </div> 
				    <div class="col-lg-4 text-center">
				    </div> 
				</div>
				<br>
			</form>
			</div>
			</div>
			<!-- fin de formulario de alta convocatoria -->  

			
			<div class="col-lg-5 col-lg-offset-1">
				
				<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
				<!-- @@@@@@@@@@@@@ MODIFICAR CONVOCATORIAS @@@@@@@@@@@@@  -->  
				<!-- @@@@@@@@@@@@@@@@@@@ (SELECT) @@@@@@@@@@@@@@@@@@@@@@  --> 
				<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --> 
			
				<div class="row">
				<form id="modificar_convocatorias" name="modificar_convocatorias" method="post" action="#" role="form">
					<h4 class="ocultar"><i class="fa fa-pencil-square"></i> Modificar una convocatoria: 
						<span class="ojito-closed text-danger"><i class="fa fa-eye-slash" aria-hidden="true"></i> <small>[Ocultar] </small></span>
					</h4>	
					
					<select id="una_convocatoria" name="una_convocatoria" class="form-control">
						<option value="0">Seleccione convocatoria a modificar </option>
						<?php 
							
							foreach ($las_convocatorias as $c) { 
							
						?>
							<option value="<?=$c['id']?>">[<?=$c['id']?>] <?=$c['descripcion']?></option>';
						<?php }  ?>
					</select>
					
					<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
					<!-- @@@@@@@@@@@@@@ ELIMINAR CONVOCATORIAS @@@@@@@@@@@@@  -->  
					<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --> 
			
					<div id = "eliminar">
						<h4><i class="fa fa-eraser" aria-hidden="true"></i> Eliminar una convocatoria: </h4>	
						<div class="row">
							<div class="col-lg-4">
				                <div class="input-group">
				                  <input type="text" id="data_id_erase_convocatoria" name="data_id_erase_convocatoria" value="" class="form-control" maxlength="5">
				                  <span class="input-group-btn">
				                    <button type="button" campo class="btn btn-md btn-success form-element" id="btn_erase_convocatoria" title="Eliminar convocatoria">
				                    <i class="fa fa-floppy-o"></i></button>
				                  </span>
				                </div>
							</div>
						</div>
					</div>
					<!-- fin de eliminar convocatoria -->  


					<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
					<!-- @@@@@@@@@@@@@ MODIFICAR CONVOCATORIAS @@@@@@@@@@@@@  -->  
					<!-- @@@@@@@@@@@@@@@@@@@ (DETALLES) @@@@@@@@@@@@@@@@@@@@  --> 
					<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --> 
					<div id="modificar">
						<div class="row">
							<!-- Id -->  
							<div class="col-lg-2">
								<label for="data_id"><h5><small>Id: </small></h5></label> 
								<input type="text" id="data_id" name="data_id" value="" class="form-control" disabled="disabled">
							</div>
							
							<!-- Descripcion --> 
							<div class="col-lg-10">
				                <label for="data_descripcion"><h5><small>Descripci&oacute;n: </small></h5></label>    
				                <div class="input-group">
				                  <input type="text" id="data_descripcion" name="data_descripcion" value="" class="form-control" maxlength="150">
				                  <span class="input-group-btn">
				                    <button type="button" campo class="btn btn-md btn-success form-element" id="btn_descripcion" title="Descripcion">
				                    <i class="fa fa-floppy-o"></i></button>
				                  </span>
				                </div>
				            </div>
			            </div>

			            <!-- Fechas -->  
		            	<div class="row">
				            <!-- fecha publicacion -->  
			            	<div class="col-lg-4">
						        <label for="data_fecha_publicacion"><h5><small>Fecha de publicaci&oacute;n: </small></h5></label> 
						        <div class="input-group">    
						        	<input type="text" id="data_fecha_publicacion" name="data_fecha_publicacion" calendario value="" class="form-control" />  
						        	<span class="input-group-btn">   
							        	<button type="button" campo class="btn btn-md btn-success form-element" id="btn_fp" title="Fecha publicacion">
				                    	<i class="fa fa-floppy-o"></i></button> 
				                    </span>
						        </div>	
						    </div>

						    <!-- fecha vencimiento -->  
						    <div class="col-lg-4">
						        <label for="data_fecha_vencimiento"><h5><small>Fecha de vencimiento: </small></h5></label> 
						        <div class="input-group">    
						        	<input type="text" id="data_fecha_vencimiento" name="data_fecha_vencimiento" calendario value="" class="form-control" />  
						        	<span class="input-group-btn">   
							        	<button type="button" campo class="btn btn-md btn-success form-element" id="btn_fv" title="Fecha vencimiento">
				                    	<i class="fa fa-floppy-o"></i></button> 
				                    </span>
						        </div>	
						    </div>

						    <!-- fecha resultados -->  
						    <div class="col-lg-4">
						        <label for="data_fecha_resultados"><h5><small>Fecha de resultados: </small></h5></label> 
						        <div class="input-group">    
						        	<input type="text" id="data_fecha_resultados" name="data_fecha_resultados" calendario value="" class="form-control" />  
						        	<span class="input-group-btn">   
							        	<button type="button" campo class="btn btn-md btn-success form-element" id="btn_fr" title="Fecha resultados">
				                    	<i class="fa fa-floppy-o"></i></button> 
				                    </span>
						        </div>	
						    </div>
						</div>
						<!-- fin de fechas -->  
						
						<!-- Tipo de Beca --> 
						
		                <label for="data_tipo_beca"><h5><small>Tipo de Beca actual: </small></h5></label>    
		                <div class="input-group">
							<select id="data_tipo_beca" name="data_tipo_beca" class="form-control">	
							<option value="0"></option>
								
								<?php foreach ($convocatorias as $c) { ?>
									<option value="<?=$c['id']?>"><?=$c['descripcion']?></option>';
								<?php }  ?>
							</select>
							<span class="input-group-btn">
			                    <button type="button" campo class="btn btn-md btn-success form-element" id="btn_tipo_beca" title="Tipo de Beca">
			                    <i class="fa fa-floppy-o"></i></button>
			                </span>
		                </div>

			        </div><!-- modificar -->  
				</form>

				<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
				<!-- @@@@@@@@@@@@@@@ LISTADO CONVOCATORIAS @@@@@@@@@@@@@  -->  
				<!-- @@@@@@@@@@@@@@@@@@@@ (ACTUAL) @@@@@@@@@@@@@@@@@@@@@  --> 
				<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --> 
				<div class="hidden-xs">
					<div class="col-lg-12 seccion detalle">
						<h4 class="convocatoria_actual"><i class="fa fa-graduation-cap"></i> Detalle Convocatorias <strong class="text-danger"><?=$year?></strong>:</h4>
						<table class="table table-stripped table-condensed table-bordered table-hover">
							<tr>
								<th class="text-center titular">Id</th>
								<th class="text-center titular">Tipo</th>
								<th class="text-center titular">Publicaci&oacute;n</th>
								<th class="text-center titular">Vencimiento</th>
								<th class="text-center titular">Resultados</th>
								<th class="text-center titular">Periodo</th>
							</tr>
							<?php 
								foreach ($las_convocatorias as $c) { 
									if($c['a'] >= $year){
							?>
								<tr>
									<?php $color = $c['id_tipo'] === 1?'success':$color = $c['id_tipo'] === 2?'warning':$color = $c['id_tipo'] === 3?'info':'primary'?>
									<td colspan="6" class="<?=@$color?>">
										<i class="fa fa-hand-o-right" aria-hidden="true"></i> 
										<?=$c['descripcion']?>
									</td>
								</tr>

								<tr> <!-- // id - tipo - publicacion - vencimiento - resultados - aplicacion - periodo -->  
									<td class="text-center text-<?=@$color?>"><?=$c['id']?></td>
									<td class="text-<?=@$color?>"><?=$c['tipo']?></td>
									<td class="text-<?=@$color?>"><?=$c['publicacion']?></td>
									<td class="text-<?=@$color?>"><?=$c['vencimiento']?></td>
									<td class="text-<?=@$color?>"><?=$c['resultados']?></td>
									<td class="text-<?=@$color?>">[<strong><?=$c['aplicacion']?></strong>] <?=$c['periodo']?></td>
								</tr>
							<?php }}  ?>
						</table>
					</div>
				</div>
				
				<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->  
				<!-- @@@@@@@@@@@@@@@ LISTADO CONVOCATORIAS @@@@@@@@@@@@@  -->  
				<!-- @@@@@@@@@@@@@@@@@@@ (ANTERIORES) @@@@@@@@@@@@@@@@@@  --> 
				<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --> 
				<p class="anteriores hidden-xs	">
					<span class="text-danger"><i class="fa fa-eye" aria-hidden="true"></i></span> 
					<small>[Mostrar / Ocultar] </small> Convocatorias anteriores al <?=$year?> 
				</p>

				<!-- Detalle convocatorias pasado-->  
				<div class="hidden-xs">
					<div class="col-lg-12 seccion detalle convocatoria_pasado">
						<h4><i class="fa fa-graduation-cap"></i> Detalle Convocatorias anteriores</h4>
						<table class="table table-stripped table-condensed table-bordered table-hover">
							<tr>
								<th class="text-center titular">Id</th>
								<th class="text-center titular">Tipo</th>
								<th class="text-center titular">Publicaci&oacute;n</th>
								<th class="text-center titular">Vencimiento</th>
								<th class="text-center titular">Resultados</th>
								<th class="text-center titular">Periodo</th>
							</tr>
							<?php 
								foreach ($las_convocatorias as $c) { 
									if($c['a'] < $year){
							?>
								<tr>
									<?php $color = $c['id_tipo'] === 1?'success':$color = $c['id_tipo'] === 2?'warning':$color = $c['id_tipo'] === 3?'info':'primary'?>
									<td colspan="6" class="<?=@$color?>">
										<i class="fa fa-hand-o-right" aria-hidden="true"></i> 
										<?=$c['descripcion']?>
									</td>
								</tr>

								<tr> <!-- // id - tipo - publicacion - vencimiento - resultados - aplicacion - periodo -->  
									<td class="text-center text-<?=@$color?>"><?=$c['id']?></td>
									<td class="text-<?=@$color?>"><?=$c['tipo']?></td>
									<td class="text-<?=@$color?>"><?=$c['publicacion']?></td>
									<td class="text-<?=@$color?>"><?=$c['vencimiento']?></td>
									<td class="text-<?=@$color?>"><?=$c['resultados']?></td>
									<td class="text-<?=@$color?>">[<strong><?=$c['aplicacion']?></strong>] <?=$c['periodo']?></td>
								</tr>
							<?php } } ?>
						</table>
					</div>
				</div>

			</div><!-- row -->  
			<!-- fin de listado de convocatorias -->  

		</div>
	</div>	
</div>

<script type="text/javascript">

var tipo = '';
var indice = 0;
var id_convocatoria = 0;
var texto = '';
var descripcion = '';
var fp = '';
var fv = '';
var fr = '';
var fh = '<?=$fecha_hoy?>';

// ------------------------------------------------------------------
// Texto sugerido para convocatorias de becas segun el tipo y periodo
// ------------------------------------------------------------------
$('#tipo_beca').change(function(){
	t = $('#tipo_beca').val();
	if (t == 1){
		$('#descripcion').val('BECA ACADEMICA - CONVOCATORIA <?=$next?$periodo_siguiente:''?>');
	}
	if (t == 2){
		$('#descripcion').val('BECA DEPORTIVA / CULTURAL - CONVOCATORIA <?=$next?$periodo_siguiente:''?>');
	}
	if (t == 3){
		$('#descripcion').val('BECA DE TRANSPORTE - CONVOCATORIA <?=$next?$periodo_siguiente:''?>');
	}
	if (t == 8){
		$('#descripcion').val('BECA DE VULNERABILIDAD - CONVOCATORIA <?=$next?$periodo_siguiente:''?>');
	}
});
// ------------------------------------------------------------------


// ------------------------------------------------------------------
// Cambio de color al dar click al boton de actualizar datos
// ------------------------------------------------------------------
$("[campo]").click(function(){  
    var myID = $(this).attr("id");
    $('#'+myID).addClass("btn-warning");
    setTimeout(
        function(){
            $('#'+myID).removeClass("btn-warning");
        }, 900);
});
// ------------------------------------------------------------------

$("[calendario]").datepicker({
            startView: 0,
            format: "yyyy-mm-dd",
            language: "es",
            weekStart: 1,
            autoclose: true,
            orientation: "bottom auto",
            todayHighlight: true,
            keyboardNavigation: false
            //daysOfWeekDisabled: []
    });



// -------------------------------
// Modificacion de convocatorias 
// -------------------------------

$('#una_convocatoria').change(function(){
	
	$('#modificar').show();
	$('.ojito-closed').show();
	$('#eliminar').hide();
	id_convocatoria = $('#una_convocatoria').val();	

	
	// Esto es para extraer el texto del select
	indice = document.modificar_convocatorias.una_convocatoria.selectedIndex;
	texto = document.modificar_convocatorias.una_convocatoria.options[indice].text;	
	$('#data_id').val(id_convocatoria);
	$.post("<?=base_url()?>"+"index.php/Convocatoria/setDataToDisplay/",{id:id_convocatoria,campo:'descripcion'},function(resp){
		$('#data_descripcion').val(resp);		
	}); 
	$.post("<?=base_url()?>"+"index.php/Convocatoria/setDataToDisplay/",{id:id_convocatoria,campo:'fecha_publicacion'},function(resp){
		$('#data_fecha_publicacion').val(resp);		
	}); 
	$.post("<?=base_url()?>"+"index.php/Convocatoria/setDataToDisplay/",{id:id_convocatoria,campo:'fecha_vencimiento'},function(resp){
		$('#data_fecha_vencimiento').val(resp);		
	}); 
	$.post("<?=base_url()?>"+"index.php/Convocatoria/setDataToDisplay/",{id:id_convocatoria,campo:'fecha_resultados'},function(resp){
		$('#data_fecha_resultados').val(resp);		
	});
	
	// Sacar una variable que tenga el tipo de beca
	$.post("<?=base_url()?>"+"index.php/Convocatoria/setDataToDisplay/",{id:id_convocatoria,campo:'id_beca_tipo'},function(resp){
		tipo = resp;		
	});      
});

$('.ocultar').click(function(){
	$('#modificar').hide();
	$('.ojito-closed').hide();
	$('#eliminar').show();
});

$('.anteriores').click(function(){
	$('.convocatoria_pasado').toggle();
});


// --------------------------------------
// Boton para eliminar una convocatoria
// --------------------------------------

function eliminarConvocatoria(){
	id = $('#data_id_erase_convocatoria').val();
	$.post("<?=base_url()?>"+"index.php/Convocatoria/setDataToDelete/",{id:id});
	setTimeout(
    function(){
        location.reload(true); 
    }, 180); 
}

$("#btn_erase_convocatoria").click(function(){	
    eliminarConvocatoria();
});

$("#data_id_erase_convocatoria").on("keydown",function(e){
	if(e.keyCode === 13){
		eliminarConvocatoria();
	}
});

// ----------------------------------------------
// Botones para modificar campos en convocatorias
// ----------------------------------------------

$("#btn_descripcion").click(function(){
	descripcion = $('#data_descripcion').val();	
    $.post("<?=base_url()?>"+"index.php/Convocatoria/setDataToUpdate/",{id:id_convocatoria,dato:descripcion,campo:'descripcion'});     
    mensajeLobibox('info','Descripcion modificada satisfactoriamente');
    setTimeout(
    function(){
        location.reload(true); 
    }, 1800); 
});

$("#btn_tipo_beca").click(function(){
	tipo_beca = $('#data_tipo_beca').val();	
	if (tipo_beca > 0){
		$.post("<?=base_url()?>"+"index.php/Convocatoria/setDataToUpdate/",{id:id_convocatoria,dato:tipo_beca,campo:'id_beca_tipo'});    
		mensajeLobibox('info','Tipo de beca modificado satisfactoriamente');
	}else{
		mensajeLobibox('error','Debes elegir un tipo de Beca');
	}

	setTimeout(
	function(){
		location.reload(true); 
	}, 1800);     
});

$("#btn_fp").click(function(){
	fp = $('#data_fecha_publicacion').val();
	//fp = fp+" 00:00:00";
	if (fh > fp){
		var mensaje = "CUIDADO: La fecha de publicacion es menor a la actual";
        mensajeLobibox('warning',mensaje);

		$.post("<?=base_url()?>"+"index.php/Convocatoria/setDataToUpdate/",{id:id_convocatoria,dato:fp,campo:'fecha_publicacion'});      	
	}else{
		$.post("<?=base_url()?>"+"index.php/Convocatoria/setDataToUpdate/",{id:id_convocatoria,dato:fp,campo:'fecha_publicacion'});      	
		mensajeLobibox('info','Fecha de Publicacion modificada satisfactoriamente');
	}
	setTimeout(
    function(){
        location.reload(true); 
    }, 1800);
});

$("#btn_fv").click(function(){
	fv = $('#data_fecha_vencimiento').val();	
	fv = fv+" 23:59:59";
    $.post("<?=base_url()?>"+"index.php/Convocatoria/setDataToUpdate/",{id:id_convocatoria,dato:fv,campo:'fecha_vencimiento'});     
    mensajeLobibox('info','Fecha de Vencimiento modificada satisfactoriamente');
    setTimeout(
    function(){
        location.reload(true); 
    }, 1800);          
});

$("#btn_fr").click(function(){
	fr = $('#data_fecha_resultados').val();	
    $.post("<?=base_url()?>"+"index.php/Convocatoria/setDataToUpdate/",{id:id_convocatoria,dato:fr,campo:'fecha_resultados'}); 
    mensajeLobibox('info','Fecha de Resultados modificada satisfactoriamente');
    setTimeout(
    function(){
        location.reload(true); 
    }, 1800);     
});
// -------------------------------


// ----------------------------------------------
// Boton Enviar para crear una convocatoria NUEVA
// ----------------------------------------------

$("#enviar").click(function(){
	t = $('#tipo_beca').val();
	fh = '<?=$fecha_hoy?>';
	fp = $('#fecha_publicacion').val();
	fv = $('#fecha_vencimiento').val();
	fr = $('#fecha_resultados').val();
	enviar = false;
	mensaje = '';

	if (t == 0){
		enviar = false;
		mensaje = 'No has elegido un tipo de beca';
	}else{
		if (fh > fp){
			enviar = false;
			mensaje = 'La fecha de publicacion debe ser igual o mayor a la actual';
		}else{
			if (fp > fv){
				enviar = false;
				mensaje = 'La fecha de vencimiento debe ser igual o mayor a la de publicacion';	
			}else{
				if (fv > fr){
					enviar = false;
					mensaje = 'La fecha de resultados debe ser igual o mayor a la de vencimiento';	
				}else{
					enviar = true;
				}
			}
		}
	}

	
	if (enviar){
		$("#alta_convocatorias").submit();
	}else{
		mensajeLobibox('error',mensaje);
	}
	
});
// ----------------------------------------------

</script>