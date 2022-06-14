<div class="new-container">

	<div id="tab_details">
		<!-- FILTROS -->  
		<span id="filtros">
			<span class="details_text"><z class="ocultar_filtrado"></z>FILTRADO <i class="fa fa-caret-up" aria-hidden="true"></i></span>
		</span>
	</div>
	
	<div class="row">
		<div class="col-lg-12">

			<!-- ********************************************************************************** -->  
			<!-- ******************************** FILTROS ***************************************** -->  
			<!-- ********************************************************************************** -->  

			<form id="filtros_options" name="filtros_options" method="post" action="#" role="form">

				<!-- ***************************** -->  
				<!-- ********* PERIODO *********** -->  
				<!-- ***************************** -->  
				<div class="row">
					<div class="col-lg-12">
						<div id="data_periodos">
							<h4>Periodo:</h4>
							<select id="elegir_periodo" class="form-control input-sm" name="elegir_periodo">
							<?php foreach($todos_los_periodos as $p){ ?>
	                            <option value="<?php echo $cuantos_periodos_hay--;?>"><?=$p?></option>
							<?php	} ?>
                        </select>
						</div>
					</div>
				</div>	

				<!-- ****************************** -->  
				<!-- ********* CARRERAS *********** -->  
				<!-- ****************************** -->  
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div id="data_carreras">	
							<h4>Carrera:</h4>
							<select id="elegir_carrera" class="form-control input-sm" name="elegir_carrera">
								<option value="0" selected:"selected">Todas las carreras</option>
								<?php 
									foreach ($carreras as $c){
										echo "<option value=\"{$c['id']}\">{$c['descripcion']}</option>";
									}
		
								?>
							</select>
						</div>
					</div>
				</div>	

				<!-- ************************************ -->  
				<!-- ********* TIPOS DE BECAS *********** -->  
				<!-- ************************************ -->  
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div id="data_becas">	
							<h4>Tipo de Beca:</h4>
							<select id="elegir_tipo_beca" class="form-control input-sm" name="elegir_tipo_beca">
								<option value="0">Todos los tipos de beca del periodo</option>
								<?php 
									foreach ($tipos_beca as $tb){
										echo "<option value=\"{$tb['id']}\">{$tb['descripcion']}</option>";
									}
		
								?>
							</select>
						</div>
					</div>
				</div>	
			</form>

			<h1 class="gris"><strong>Detallado de Solicitudes de Beca</strong>
				<button id="mostrar_becados" class="btn btn-danger btn-sm">Mostrar Becados <i class="fa fa-list"></i></button>
				<button id="exportar_excel" class="btn btn-success btn-sm">Exportar a Excel <i class="fa fa-file-excel-o"></i></button>
				<button id="imprimir_becados" class="btn btn-primary btn-sm">Imprimir <i class="fa fa-print"></i></button>
			</h1>
			<br />

			<!-- ********************************************************************************** -->  
			<!-- ******************* LISTADO DINAMICO DE SOLICITANTES DE BECA ********************* -->  
			<!-- ********************************************************************************** -->  
			<div class="row">
				<div class="col-lg-12">
					<div id="data_list">	
						
					</div>
				</div>
			</div>	
			<br />

			<!-- ********************************************************************************** -->  

		</div><!-- col-12 -->  
	</div><!-- row -->  	
</div><!-- container -->  

<div class="modal fade printable" tabindex="-1" role="dialog" aria-labelledby="myModal" id="modal_motivos">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" id="modal_detalle">

		</div>
	</div>
</div>


<script type="text/javascript">

var dire_solicitantes = "<?=base_url()?>"+"index.php/Detallado/printSolicitantes/";

var numero_de_periodo = 0;
var id_carrera = 0;
var id_tipo_beca = 0;
var excel = 0;

$(document).ready(function(){

  /* ------ TABS DE CONFIGURACION ------- */	
  $('#filtros').click(function(){
    $('#filtros_options').slideToggle( 'fast' );
    $('#filtros').find('i').toggleClass('fa-caret-up fa-caret-down');
	$('.details_text').find('z').toggleClass('ocultar_filtrado mostrar_filtrado');
    return true;
  });

  	$('#exportar_excel').hide();
  	$('#imprimir_becados').hide();

});

$(document).on("hidden.bs.modal", function(e){
	$(e.target).removeData("bs.modal").find(".modal-content").empty();
});

$('#elegir_carrera').change(function(e){
	$.isLoading({ text: "Obteniendo datos " });
	numero_de_periodo = $('#elegir_periodo').val();
	id_carrera = $('#elegir_carrera').val();
	id_tipo_beca = $('#elegir_tipo_beca').val();	
  	//$('#exportar_excel').show();
  	//$('#imprimir_becados').show();
	$.post(dire_solicitantes,{periodo:numero_de_periodo,carrera:id_carrera,tipo:id_tipo_beca},function(resp){
		$('#data_list').html(resp);
	});	
});

$('#elegir_tipo_beca').change(function(e){
	$.isLoading({ text: "Obteniendo datos " });
	numero_de_periodo = $('#elegir_periodo').val();
	id_carrera = $('#elegir_carrera').val();
	id_tipo_beca = $('#elegir_tipo_beca').val();
  	//$('#exportar_excel').show();
  	//$('#imprimir_becados').show();
	$.post(dire_solicitantes,{periodo:numero_de_periodo,carrera:id_carrera,tipo:id_tipo_beca},function(resp){
		$('#data_list').html(resp);
	});	
});


// Boton "Mostrar Becados"
$('#mostrar_becados').click(function(e){
	$.isLoading({ text: "Obteniendo datos " });
	numero_de_periodo = $('#elegir_periodo').val();
	id_carrera = $('#elegir_carrera').val();
	id_tipo_beca = $('#elegir_tipo_beca').val();	
  	//$('#exportar_excel').show();
  	//$('#imprimir_becados').show();
	$.post(dire_solicitantes,{periodo:numero_de_periodo,carrera:id_carrera,tipo:id_tipo_beca},function(resp){
		$('#data_list').html(resp);
	});	
});

// Boton "Excel"
$('#exportar_excel').click(function(e){
	//$.isLoading({ text: "Obteniendo datos " });
	//$('#exportar_excel').show();
  	//$('#imprimir_becados').show();
    $.post(dire_solicitantes,{periodo:numero_de_periodo,carrera:id_carrera,tipo:id_tipo_beca,excel:1},function(resp){
		$('#data_list').html(resp);
	});	
});

// Boton "Imprimir"
$('#imprimir_becados').click(function(){
    window.print();
    return false;
});
</script>