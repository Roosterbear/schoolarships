<div class="new-container">
	<h1 class="gris"><strong>Solicitud de Becas <?=$real?></strong> </h1>
	<div class="row">
		<div class="col-lg-12 no-printable">

			<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->
			<!-- @@@@@@@@@@@@@@@@ SOLICITUD DE BECA @@@@@@@@@@@@@@@@  -->
			<!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->

			<div class="col-lg-12">
				<div class="row">
					<form id="solicitud_beca" name="solicitud_beca" method="post" action="#" role="form">
					<div class="row">
						<div class="col-lg-3">
							<h4>Matricula:
								<input type="text" class="form-control" id="matricula_alumno" name="matricula_alumno" value="<?=$matricula?>" disabled="disabled" style='text-align:center;' >
							</h4>
						</div>

						<div class="col-lg-6">
							<h4>Alumno: <input type="text" class="form-control" id="nombre_alumno" name="nombre_alumno" value="<?=$nombre?>" disabled="disabled" ></h4>
						</div>

						<div class="col-lg-3">
							<h4>Becado:
								<input type="text" class="form-control" id="becado" name="becado" value="<?=$externo?>" disabled="disabled" style='text-align:center;' >
							</h4>
						</div>
					</div>
					<hr />
					<br>
					<a class="btn btn-danger" title="externo" href="http://www.utags.edu.mx/index.php/servicios/becas" target="_blank" >Informaci&oacute;n de Becas <i class="fa fa-external-link" aria-hidden="true"></i> </a>
					<a class="btn btn-primary" title="externo" href="http://www.utags.edu.mx/images/academia/DOCS/PDF/Calendarios/CA21-22.jpg" target="_blank" >Calendario Acad&eacute;mico <i class="fa fa-external-link" aria-hidden="true"></i> </a>
					<a class="btn btn-success" title="externo" href="http://www.utags.edu.mx/images/Archivos/legislacion_uni/REGLAMENTO-ADMVO.pdf" target="_blank" >Reglamento Administrativo <i class="fa fa-external-link" aria-hidden="true"></i> </a>

					<div id="los_tipos_de_beca" name="los_tipos_de_beca" class="row">
						<h3>Elige un tipo de beca:</h3>
						<div class="col-lg-4">
							<input type="radio" name="tipo_solicitud" id="tipo_academica" checked="checked">
								<span class="text-success type_beca">Academica</span>
						</div>

						<div class="col-lg-4">
							<input type="radio" name="tipo_solicitud" id="tipo_deportiva">
							<span class="text-warning type_beca">Deportiva / Cultural</span>
						</div>

						<div class="col-lg-4">
							<input type="radio" name="tipo_solicitud" id="tipo_transporte">
							<span class="text-info type_beca">Transporte</span>
						</div>
					</div>
					<hr />

					<div class="row">
						<div class="col-lg-12">
							<div id="data_convocatorias">
								<!-- datos dinamicos de acuerdo al tipo de beca -->
								<!-- SELECT "elegir_convocatoria" -->
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div id="datos_convocatoria">
								<!-- datos dinamicos de acuerdo a la convocatoria seleccionada -->
								<!-- FECHA INICIO - FECHA VENCIMIENTO - FECHA RESULTADOS -->
								<!-- PERIODO SOLICITUD - PERIODO APLICACION -->
								<!-- REQUISITOS (convocatorias->printConvocatoriasByTipo) -->
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div id="motivos_solicitud" class="text-center">
								<h3 class="text-left">Motivos:</h3>
								<textarea name="motivos" id="motivos" form="solicitud_beca" rows="4" cols="80" style="resize: none;" class="form-control" placeholder="Escribe la razon por la cual necesitas un apoyo (Al menos 10 caracteres)"></textarea>
								<br />
								<button type="button" class="btn btn-md btn-success form-element" id="btn_enviar_solicitud" name="btn_enviar_solicitud">
									Enviar Solicitud
								</button>
							</div>
						</div>
					</div><br /><hr />
					<div id="botones">
						<div class="row">
							<div class="col-lg-12 mi_tab" id="btn_mostrar_historial">
								<h3>
									<i class="fa fa-folder-open-o" aria-hidden="true"></i> Mis Becas solicitadas
									<strong class="margen_derecho">Imprime tu folio <i class="fa fa-hand-o-down" aria-hidden="true"></i></strong>
								</h3>

									<!-- Contenido dinamico de modelo - convocatorias->printHistorial  -->
									<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

							</div>
						</div><br />
						<div id="historial"></div>
						<div class="row">
							<div class="col-lg-12 mi_tab" id="btn_mostrar_asignadas">
								<h3>
									<i class="fa fa-folder-open-o" aria-hidden="true"></i>
	 								Mis Becas asignadas
	 							</h3>
							</div>
						</div><br />
						<div id="asignadas"></div>
						</div>
					</form>
				</div><!-- row -->
			</div><!-- col-12 -->
		</div><!-- col-12 -->
	</div><!-- row -->
</div><!-- container -->

<!-- Modal -->
<div class="modal printable" tabindex="-1" role="dialog" aria-labelledby="myModal" id="modal_folio">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" id="modal_detalle">

		</div>
	</div>
</div>

<script type="text/javascript">

var listado_historial_mostrado = false;
var listado_asignadas_mostrado = false;

// Ya no es necesario checar esto porque se checa desde antes
var dio_click_en_estudio_socioeconomico = 1; // Invalidamos con 1
dio_click_en_estudio_socioeconomico++;

$(document).ready(function(){
	var tipo;
	var dire_get = "<?=base_url()?>"+"index.php/Convocatoria/getConvocatorias/";

	if ($("#tipo_academica").prop('checked')){tipo = '1';}
	if ($("#tipo_deportiva").prop('checked')){tipo = '2';}
	if ($("#tipo_transporte").prop('checked')){tipo = '3';}

	if ($("#matricula_alumno").val() == '00'){
		mensajeLobibox('error','El usuario con el que se ha ingresado no tiene una matr&iacute;cula');
		$('#los_tipos_de_beca').hide();
	}else{
		if ($("#matricula_alumno").val() == '000'){
			mensajeLobibox('error','El Alumno no est&aacute; inscrito');
			$('#botones').hide();
			$('#los_tipos_de_beca').hide();
		}else{
			if ($("#becado").val() == 'EXTERNO'){
				mensajeLobibox('error','El Alumno tiene Beca Externa');
				$('#los_tipos_de_beca').hide();
			}else{
				$.post(dire_get,{tipo:tipo},function(resp){
					var html_code = resp;
					// SELECT por default con Academica
					$('#data_convocatorias').html(html_code);
				});
			}//else3
		}//else2
	}//else1

	/* AVISOS PARA BECAS */
	//mensajeLobibox('error','LAS CONVOCATORIAS DE BECA SEP-DIC 2018 COMENZARAN A PARTIR DE LAS 12 HRS');

});

$(document).on("hidden.bs.modal", function(e){
	$(e.target).removeData("bs.modal").find(".modal-content").empty();
});

function cambiarConvocatoriasByTipo(tipo){
	var dire_get = "<?=base_url()?>"+"index.php/Convocatoria/getConvocatorias/";
	$.post(dire_get,{tipo:tipo},function(resp){
		var html_code = resp;
		// SELECT con las Becas del Tipo seleccionado
		$('#data_convocatorias').html(html_code);
	});
	$('#datos_convocatoria').html('');
	$('#motivos_solicitud').hide();
}


//.requisitos #liga
    $("a[title!=externo]").click(function(event) {
      event.preventDefault();
      dio_click_en_estudio_socioeconomico++;
    });

$("#solicitud_beca").on('click',function(){ //<--Para que agarre IDs dinamicos, debemos encerrarlos en un evento de ID padre
	$("#elegir_convocatoria").change(function(e){
		e.stopImmediatePropagation();
		var dire_get = "<?=base_url()?>"+"index.php/Convocatoria/getDatosConvocatoriaById/";
		var dire_valida_duplicacion = "<?=base_url()?>"+"index.php/Convocatoria/validaDuplicacionConvocatoriaSolicitada/";
		var dire_valida_fecha = "<?=base_url()?>"+"index.php/Convocatoria/validaFechaConvocatoriaSolicitada/";
		var id_beca = $("#elegir_convocatoria").val();
		var matricula = $("#matricula_alumno").val();

		$.post(dire_get,{id:id_beca},function(resp){
			var html_code = resp;
			// RESPUESTA con informacion de la CONVOCATORIA elegida
			$('#datos_convocatoria').html(html_code);
		});

		$.post(dire_valida_duplicacion,{id:id_beca,matricula:matricula},function(resp){
			if (resp != ''){
				$('#datos_convocatoria').html('');
				$('#motivos_solicitud').hide();
				mensajeLobibox('error',resp);
			}else{
				$.post(dire_valida_fecha,{id:id_beca},function(resp){
					if (resp != ''){
						$('#datos_convocatoria').html('');
						$('#motivos_solicitud').hide();
						mensajeLobibox('error',resp);
					}else{
						$('#motivos_solicitud').show();
					}
				});
			}
		});
	});
});

$("#tipo_academica").click(function(){
	cambiarConvocatoriasByTipo('1');
});

$("#tipo_deportiva").click(function(){
	cambiarConvocatoriasByTipo('2');
});

$("#tipo_transporte").click(function(){
	cambiarConvocatoriasByTipo('3');
});

$("#btn_enviar_solicitud").click(function(){
	var mensaje;
	var tipo;
	var dire_inserta_solicitud = "<?=base_url()?>"+"index.php/Convocatoria/insertarSolicitud/";
	var id = $("#elegir_convocatoria").val();
	var matricula = $("#matricula_alumno").val();
	var motivo = $('#motivos').val();
	var	motivoTrim = $.trim(motivo);
	var hubo_error;

	if (dio_click_en_estudio_socioeconomico > 0){
		if (motivoTrim.length < 10){
			mensaje = "Creemos que tienes mas motivos para solicitar una beca";
			tipo = 'error';
		}else{
			var motivos = $('#motivos').val();
			$.post(dire_inserta_solicitud,{matricula:matricula,id:id,motivos:motivos},function(resp){
				hubo_error = resp === true?true:false;
			});

			mensaje = hubo_error == true?"Ocurrio un error al enviar la solicitud":"Tu solicitud de Beca ha sido enviada";
			tipo = hubo_error == true?'error':'success';
			$('#motivos').val("");
			$('#datos_convocatoria').html('');
			$('#motivos_solicitud').hide();
			$('#historial').html('');
		}
	}else{
			mensaje = "No has entrado al cuestionario de Estudio Socioeconomico";
			tipo = 'error';
	}
	mensajeLobibox(tipo,mensaje);
});

$('#btn_mostrar_historial').click(function(){
	var dire_historial = "<?=base_url()?>"+"index.php/Convocatoria/listarHistorialSolicitudes/";
	var matricula = $("#matricula_alumno").val();

	listado_historial_mostrado = listado_historial_mostrado?false:true;
	if (listado_historial_mostrado){
		$.post(dire_historial,{matricula:matricula},function(resp){
			$('#historial').html(resp);
		});
	}else{
		$('#historial').html('');
	}

});

$('#btn_mostrar_asignadas').click(function(){
	var dire_asignadas = "<?=base_url()?>"+"index.php/Convocatoria/listarAsignadas/";
	var matricula = $("#matricula_alumno").val();

	listado_asignadas_mostrado = listado_asignadas_mostrado?false:true;
	if (listado_asignadas_mostrado){
		$.post(dire_asignadas,{matricula:matricula},function(resp){
			$('#asignadas').html(resp);
		});
	}else{
		$('#asignadas').html('');
	}
});

</script>
