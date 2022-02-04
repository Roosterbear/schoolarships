<div class="new-container">
	<h1 class="gris"><strong>Filtrado de Solicitudes de Becas</strong></h1>
	<div class="row">
		<div class="col-lg-12">
			<form id="reporte_beca" name="reporte_beca" method="post" action="#" role="form">

				<!-- ***************************** -->  
				<!-- ********* PERIODO *********** -->  
				<!-- ***************************** -->  
				<div class="row">
					<div class="col-lg-12">
						<div id="data_periodos">
							<h4>Periodo:</h4>
							<select id="periodos" class="form-control input-sm" name="periodos">
								<option value="0" selected = "selected">Selecciona el periodo</option>	                            
								<option value="<?=$id_periodo_anterior?>"><?=$periodo_anterior?></option>
								<option value="<?=$id_periodo_actual?>"><?=$periodo_actual?></option>
								<!-- Al validar que el periodo sea mayor a 20 estamos checando que exista -->
								<?php if($id_periodo_siguiente>20){ ?>
								<option value="<?=$id_periodo_siguiente?>"><?=$periodo_siguiente?></option>
								<?php } ?>
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

var numero_de_periodo = 0;
var id_carrera = 0;
var id_tipo_beca = 0;

var dire_carreras = "<?=base_url()?>"+"index.php/Convocatoria/printCarreras/";
var dire_tipos_beca = "<?=base_url()?>"+"index.php/Convocatoria/printTiposBeca/";
var dire_solicitantes = "<?=base_url()?>"+"index.php/Reportes/printSolicitantes/";

$(document).ready(function(){
	$("#periodos option[value='0']").prop("selected",true);
	/* -------------------------------------------- */

	$('#data_periodos').change(function(){
		
		/* ----------------------------------- */
		/* ----------- PERIODO --------------- */
		/* ----------------------------------- */
		numero_de_periodo = $('#periodos').val();

		if (numero_de_periodo > 0){

			$('#data_list').html('');

			$.post(dire_carreras,function(resp){
				$('#data_carreras').html(resp);		
			});		

			$.post(dire_tipos_beca,function(resp){
				$('#data_becas').html(resp);		
			});	
		}else{
			$('#data_list').html('');
			$('#data_carreras').html('');	
			$('#data_becas').html('');	
		}
	});


	$('#data_carreras').on('click',function(){

		/* --- carrera --- */
		$('#elegir_carrera').change(function(e){
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
			id_carrera = $('#elegir_carrera').val();
			id_tipo_beca = $('#elegir_tipo_beca').val();
			
			$.post(dire_solicitantes,{periodo:numero_de_periodo,carrera:id_carrera,tipo:id_tipo_beca},function(resp){
				$('#data_list').html(resp);
			});	 
		});
	});

});


</script>