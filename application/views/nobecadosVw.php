<div class="new-container">
	<!-- ********************************************************************************** -->
	<!-- ******************************** FILTROS ***************************************** -->
	<!-- ********************************************************************************** -->
	<div id="tab_details">
		<!-- FILTROS -->
		<span id="filtros">
			<span class="details_text"><z class="ocultar_filtrado"></z>FILTRADO <i class="fa fa-caret-up" aria-hidden="true"></i></span>
		</span>
	</div>

	<h1 class="gris"><strong>Reporte de No Becados</strong>
		<input type="hidden" id="periodo_actual" value="<?php echo $id_periodo_actual?>">
	</h1>

	<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
	<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
	<h2 id="select_periodos"><u>Periodo: </u><strong><periodo class="sin_tachar azul"> <?php echo $periodo_actual; ?></periodo></strong>
		<small id="cambiar_periodos"><z class="ocultar_periodos"></z><i class="fa fa-caret-down" aria-hidden="true"></i></small>
	</h2>

	<span id="ocultar">
		<idPeriodo><?php echo $id_periodo_actual; ?></idPeriodo>
	</span>

	<form id="carga_individual_de_becas" name="carga_individual_de_becas" method="post" action="#" role="form">

		<!-- ************************************ -->
		<!-- ********* ELEGIR PERIODO *********** -->
		<!-- ************************************ -->
		<br />
		<div class="row">
			<div class="col-lg-12">
				<div id="data_periodos_alta">
					<h2><label for="elegir_periodo">Periodo:</label></h2>
					<select id="elegir_periodo" class="form-control input-sm" name="elegir_periodo">
						<option value="0">Selecciona Periodo a aplicar</option>
						<?php
							for($i=$cuantos_periodos_hay;$i>=1;$i--){
								echo "<option value=\"{$i}\">{$todos_los_periodos[$i]}</option>";
							}
						?>
					</select>
				</div>
			</div>
		</div>

	</form>
	<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
	<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->


	<form id="filtros_options" name="filtros_options" method="post" action="#" role="form">

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
		<!-- ************** ORDEN *************** -->
		<!-- ************************************ -->
		<br />
		<div class="row">
			<div class="col-lg-12">
				<div id="orden_becas">
					<h4>Ordenar por:</h4>
					<span class="margen_derecho">
						<input type="radio" id="matricula" name="ordenar" value="1" checked>
	  					<label for="matricula" class="margen_derecho">Matr&iacute;cula</label>
					</span>

					<span class="margen_derecho">
						<input type="radio" id="nombre" name="ordenar" value="2">
	  					<label for="nombre" class="margen_derecho">Nombre</label>
  					</span>

  					<span class="margen_derecho">
	  					<input type="radio" id="sexo" name="ordenar" value="3">
	  					<label for="sexo" class="margen_derecho">Sexo</label>
  					</span>

  					<span class="margen_derecho">
	  					<input type="radio" id="cuatrimestre" name="ordenar" value="4">
	  					<label for="cuatrimestre" class="margen_derecho">Cuatrimestre</label>
	  				</span>

  					<span class="margen_derecho">
	  					<input type="radio" id="carrera" name="ordenar" value="5">
	  					<label for="carrera" class="margen_derecho">Carrera</label>
	  				</span>

	  				<span class="margen_derecho">
	  					<input type="radio" id="rechazo" name="ordenar" value="6">
	  					<label for="rechazo" class="margen_derecho">Causa Rechazo</label>
	  				</span>

	  				<span class="margen_derecho">
	  					<input type="radio" id="convocatoria" name="ordenar" value="7">
	  					<label for="convocatoria" class="margen_derecho">Convocatoria</label>
	  				</span>

				</div>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-lg-12">
				<div id="orden_becas_ad">
  					<span class="margen_derecho">
	  					<input type="radio" id="asc" name="ordenar_ad" value="0" checked>
	  					<label for="asc" class="margen_derecho">Ascendente</label>
	  				</span>

	  				<span class="margen_derecho">
	  					<input type="radio" id="des" name="ordenar_ad" value="1">
	  					<label for="descendente" class="margen_derecho">Descendente</label>
	  				</span>
				</div>
			</div>
		</div>
	<br />
	</form>
	<button id="mostrar_no_becados" class="btn btn-danger btn-sm">Mostrar NO Becados <i class="fa fa-list"></i></button>
	<br /><br /><br />
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

</div><!-- container -->



<script type="text/javascript">

var dire_no_becados = "<?=base_url()?>"+"index.php/NoBecados/printNoBecados/";
var orden = 0;
var orden_ad = 0;
var periodo = 0;

$(document).ready(function(){

	/* ------ CAMBIAR PERIODO ------- */
	$('#select_periodos').click(function(){
	    $('#data_periodos_alta').slideToggle( 'fast' );
	    $('#select_periodos').find('i').toggleClass('fa-caret-down fa-rotate-left');
		$('#select_periodos').find('z').toggleClass('ocultar_periodos mostrar_periodos');
		$('#select_periodos').find('periodo').toggleClass('sin_tachar tachar');
		$('#select_periodos').find('periodo').toggleClass('azul gris');
  		return true;
	});

  /* ------ TABS DE CONFIGURACION ------- */
  $('#filtros').click(function(){
    $('#filtros_options').slideToggle( 'fast' );
    $('#filtros').find('i').toggleClass('fa-caret-up fa-caret-down');
	$('.details_text').find('z').toggleClass('ocultar_filtrado mostrar_filtrado');
    return true;
  });
});

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// CHANGING THE VALUE OF A PERIOD
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function changePeriod(){
	// Check period (If actived or selected)
	if ($('periodo').hasClass('tachar')){ // Tachar give us the tip
		periodo = $('#elegir_periodo').val();
	}else{
		periodo = $('idPeriodo').html();
	}
}

function refreshData(){
	changePeriod();
	id_carrera = $('#elegir_carrera').val();
	orden = $('input:radio[name=ordenar]:checked').val();
	$.post(dire_no_becados,{periodo:periodo,carrera:id_carrera,orden:orden,orden_ad:orden_ad},function(resp){
		$('#data_list').html(resp);
	});
}
// --------------------------
// Boton "Mostrar No Becados"
// --------------------------
$('#mostrar_no_becados').click(function(e){
	refreshData();
});

$('#elegir_periodo').change(function(e){
	refreshData();
});

$('#elegir_carrera').change(function(e){
	refreshData();
});

// Ordenar
$('#orden_becas').click(function(e){
	refreshData();
});

$('#orden_becas_ad').click(function(e){
	changePeriod();
	id_carrera = $('#elegir_carrera').val();
	orden = $('input:radio[name=ordenar]:checked').val();
	orden_ad = $('input:radio[name=ordenar_ad]:checked').val();

	$.post(dire_no_becados,{periodo:periodo,carrera:id_carrera,orden:orden,orden_ad:orden_ad},function(resp){
		$('#data_list').html(resp);
	});

});
</script>
