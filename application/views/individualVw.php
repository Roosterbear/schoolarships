<div class="container-fluid">

	<h1 id="form_space"><strong>Carga Individual de Becas</strong> &nbsp;<small>&nbsp;Usuario: <?php echo $usuario ?></small></h1>


	<div id="seleccion">
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


			<!-- ************************************ -->  
			<!-- ************ MATRICULA ************* -->  
			<!-- ************************************ -->  

			<h2>
				<div class="input-group">
					<label for="data_matricula">Matr&iacute;cula: </label>
					<input id="data_matricula" name="data_matricula" value="" class="form-control">
				</div>
			</h2>


			<!-- ************************************ -->  
			<!-- ********* TIPOS DE BECAS *********** -->  
			<!-- ************************************ -->  
			<br />
			<div class="row">
				<div class="col-lg-12">
					<div id="data_becas">	
						<h2><label for="elegir_tipo_beca">Tipo de Beca:</label></h2>
						<select id="elegir_tipo_beca" class="form-control input-sm" name="elegir_tipo_beca">
							<option value="0">Selecciona la Beca a aplicar</option>
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
	</div><!-- seleccion -->  

	<br />
	<h1>
		<div id="respuesta_asignacion_beca"></div>
	</h1>

	<br />
	<span class="input-group-btn">
		<!-- BOTON PARA VERIFICAR (Que el alumno exista y no tenga BECA) -->  
		<a href="#" class="btn btn-success btn-md" id="btn_asignar_alumno" name="btn_asignar_alumno" disabled="disabled">Proceder <i class="fa fa-check-circle" aria-hidden="true"></i></a>
	</span>


	<!-- BOTON PARA RESETEAR (Recarga la pagina) -->  
	<a href="#" class="btn btn-danger btn-md" id="btn_resetear_individual" name="btn_resetear_individual">Regresar <i class="fa fa-rotate-left" aria-hidden="true"></i></a>
</div>

<?php 
//print_r($carreras);
//print_r($tipos_beca);
 ?>


<script type="text/javascript">

var asignacion_beca_individual = "<?=base_url()?>"+"index.php/Individual/asignarBeca/";
var matricula = '';
var periodo = '';
var beca = '';

// mensajeLobibox(tipo,mensaje);

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

	/* ------ VERIFICACION DE INFORMACION ------- */	


	$('#data_matricula').focusout(function(){
		matricula = parseInt($('#data_matricula').val());
		if (matricula > 100000){
			$('#btn_asignar_alumno').attr('disabled', false);
		}else{
			$('#btn_asignar_alumno').attr('disabled', true);
			mensajeLobibox('error','Matricula NO valida');
		}
	});


	$('#btn_asignar_alumno').on('click',function(){
		
		// Ocultar para que no modifiquen
		$('#seleccion').hide();

		beca = $('#elegir_tipo_beca').val();

		// VALIDAR PERIODO (Si es el activo o elije uno)
		if ($('periodo').hasClass('tachar')){
			periodo = $('#elegir_periodo').val();
		}else{
			periodo = $('idPeriodo').html();
		}

		// VALIDAR MATRICULA (Que no esté vacía)
		// Es una doble validacion que vale la pena para que no truene
		if ($('#data_matricula').val() == ''){
			matricula = 0;			
		}else{
			matricula = $('#data_matricula').val();
		}

		$('#btn_resetear_individual').show();
		$('#btn_asignar_alumno').hide();

		$.post(asignacion_beca_individual,{periodo:periodo,matricula:matricula,beca:beca},function(resp){
			$('#respuesta_asignacion_beca').html(resp);
		}); 


	});	

	// RESETEAR DATOS
	$('#btn_resetear_individual').on('click',function(){		
		location.reload(true);
	});

/*
success
info
error
warning
default
*/

});
</script>