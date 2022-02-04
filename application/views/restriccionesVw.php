<div class="container">
	<h1 class="gris"><strong>Aplicaci&oacute;n de Servicio Social para alumnos con Beca Interna</strong></h1>
	<div class="row">
		<div class="col-lg-12">
			<form id="restricciones_beca" name="restricciones_beca" method="post" action="#" role="form">
				<div class="row">
					<div class="col-lg-10">
						<h4>Empleado: 
							<span class="text-<?=$empleado!=''?'success':'danger'?>"><i class="fa fa-<?=$empleado!=''?'check':'times'?>" aria-hidden="true"></i></span>
							<input type="text" class="form-control" id="nombre_empleado" name="nombre_empleado" disabled="disabled" value ="<?=$empleado?>">
						</h4>
					</div><!-- col-10 -->  
					<div class="col-lg-2">
						<h4>Validador: 
							<span class="text-<?=$es_validador?'success':'danger'?>"><i class="fa fa-<?=$es_validador?'check':'times'?>" aria-hidden="true"></i></span>
							<input type="text" class="form-control" id="check_validador" name="check_validador" disabled="disabled" value ="<?=$es_validador?$usuario:''?>">
						</h4>
					</div><!-- col-2 -->  	
				</div><!-- row -->  	

				<!-- ***************************** -->  
				<!-- ********* PERIODO *********** -->  
				<!-- ***************************** -->  
				<div class="row">
					<div class="col-lg-12">
						<div id="data_periodos">
							<h4>Periodo:</h4>
							<select id="periodos" class="form-control input-sm" name="periodos">
								<option value="0">Selecciona el periodo</option>	                            
	                            <option value="<?=$id_periodo_actual?>"><?=$periodo_actual?></option>
	                            <option value="<?=$id_periodo_anterior?>"><?=$periodo_anterior?></option>
                        </select>
						</div>
					</div>
				</div>	

				<br />
				<div class="row">
					<div class="col-lg-12">
						<div id="data_carreras">	
							
						</div>
					</div>
				</div>	

				<br />
				<div class="row">
					<div class="col-lg-12">
						<div id="data_becas">	
							
						</div>
					</div>
				</div>	

				<br />
				<div class="row">
					<div class="col-lg-12">
						<div id="data_list">	
							
						</div>
					</div>
				</div>	
				<br />

			</form>
		</div><!-- col-12 -->  
	</div><!-- row -->  	
</div><!-- container -->  

<script type="text/javascript">
var dire_carreras = "<?=base_url()?>"+"index.php/Convocatoria/printCarreras/";
var dire_tipos_beca = "<?=base_url()?>"+"index.php/Convocatoria/printTiposBeca/";
var dire_solicitantes = "<?=base_url()?>"+"index.php/Restriccion/printSolicitantes/";
var dire_servicio_social = "<?=base_url()?>"+"index.php/Restriccion/setServicioSocial/";
var icon = false;

var numero_de_periodo = '';
var validacion = '';
var filtro = '';

var id_carrera = 0;
var id_tipo_beca = 0;
var matricula = '';

$(document).ready(function(){

	// Resetear valores
	$("#periodos").val('0').prop('selected', true);
	$('input[name="validar"]')[0].checked = false;
	$('input[name="validar"]')[1].checked = false;
	$('input[name="filtrar"]')[0].checked = false;
	$('input[name="filtrar"]')[1].checked = false;
	

	if ($('#check_validador').val() != ''){
		$('#data_periodos').show();
	}else{
		$('#data_periodos').hide();
	}	

});

/* -------------------------------------------- */

$('#data_periodos').change(function(){

	/* ----------------------------------- */
	/* ----------- PERIODO --------------- */
	/* ----------------------------------- */
	numero_de_periodo = $('#periodos').val();

	if (numero_de_periodo > 0){
		$.post(dire_carreras,function(resp){
			$('#data_carreras').html(resp);		
		});		

		$.post(dire_tipos_beca,function(resp){
			$('#data_becas').html(resp);		
		});	

	}
});


$('#data_carreras').on('click',function(){

	/* --- carrera --- */
	$('#elegir_carrera').change(function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		id_carrera = $('#elegir_carrera').val();
		id_tipo_beca = $('#elegir_tipo_beca').val();
		
		$.post(dire_solicitantes,{periodo:numero_de_periodo,carrera:id_carrera,tipo:id_tipo_beca},function(resp){
			$('#data_list').html(resp);
		});	 
	});
});

$('#data_becas').on('click',function(){

	/* --- tipo de beca --- */
	$('#elegir_tipo_beca').change(function(e){
		e.stopImmediatePropagation();
		e.stopImmediatePropagation();
		id_carrera = $('#elegir_carrera').val();
		id_tipo_beca = $('#elegir_tipo_beca').val();
		
			$.post(dire_solicitantes,{periodo:numero_de_periodo,carrera:id_carrera,tipo:id_tipo_beca},function(resp){
				$('#data_list').html(resp);
			});
	});
});

$('body').on("click","[agregar_servicio]",function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
	matricula = $(this).attr("id");

	$.post(dire_servicio_social,{matricula:matricula,periodo:numero_de_periodo,change:1},function(resp){
		mensajeLobibox('success','Servicio agregado');
	});	

	$.post(dire_solicitantes,{periodo:numero_de_periodo,carrera:id_carrera,tipo:id_tipo_beca},function(resp){
		$('#data_list').html(resp);
	});	 
});


$('body').on("click","[quitar_servicio]",function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
	matricula = $(this).attr("id");
	
	$.post(dire_servicio_social,{matricula:matricula,periodo:numero_de_periodo,change:0},function(resp){
		mensajeLobibox('error','Servicio eliminado');
	});	

	$.post(dire_solicitantes,{periodo:numero_de_periodo,carrera:id_carrera,tipo:id_tipo_beca},function(resp){
		$('#data_list').html(resp);
	});	 
});
</script>