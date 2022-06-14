<div class="container-fluid">

	<!-- form-space is the pretty bordered and shadowed header that usually include in my proyects -->
	<h1 id="form_space"><strong class="marked">Descancelacion de Becas</strong> <?php echo $usuario ?></h1>

	<!-- datos_periodo is where we get the most recent period -->
	<h2 class="verde">&Uacute;nicamente se actualizaran becas del periodo actual <strong id="datos_periodo"></strong></h2>

	<!-- nombre_alumno is where we get the student's name -->
	<h3 class="gris">Alumno: <strong id="nombre_alumno"> </strong></h3>

	<form id="descancelacion_de_becas" name="descancelacion_de_becas" method="post" action="#" role="form">
		<h2>
			<div class="input-group">
				<label for="data_matricula"></label>Matr&iacute;cula:
				<input id="data_matricula" name="data_matricula" value="" class="form-control">
			</div>
		</h2>

		<span class="input-group-btn">
			<!-- ======================== -->
			<!-- Quit Cancellation Button -->
			<!-- ======================== -->
			<a href="#" class="btn btn-primary btn-md" id="btn_descancelar" name="btn_descancelar">Descancelar <i class="fa fa-rotate-left" aria-hidden="true"></i></a>
		</span>
	</form>
</div>

<script type="text/javascript">
var matricula = 0;
var mensaje_no_cancelada = 'La matricula proporcionada NO tiene una beca cancelada';

$(document).ready(function(){

	// Function to get current period in text
	$.post("<?=base_url()?>"+"index.php/Cancelacion/datosPeriodo/",function(resp){
		$('#datos_periodo').html(resp);
	});

	// Action when user press the button
	$('#btn_descancelar').on('click',function(){
		matricula = $('#data_matricula').val();
		getStudentName(matricula);
		verify(matricula);
	});


	// Action when user press the Enter Key
	$("#data_matricula").on("keydown",function(e){
		matricula = $('#data_matricula').val();
		if(e.keyCode == 13){
			e.preventDefault();
			e.stopImmediatePropagation();
			getStudentName(matricula);
			verify(matricula);
		}
	});

	function getStudentName(matricula){

		$.post("<?=base_url()?>"+"index.php/Descancelar/obtenerNombreAlumno/",{matricula:matricula},function(resp){
			//write name here
			$('#nombre_alumno').html(resp);
		});
	}

	function verify(matricula){
		$.post("<?=base_url()?>"+"index.php/Descancelar/isCanceled_/",{matricula:matricula},function(resp){
			if (Boolean(resp)){
				quitCancel(matricula);
			}else{
				mensajeLobibox('error',mensaje_no_cancelada);
			}
		});
	}

	function quitCancel(matricula){
		$.post("<?=base_url()?>"+"index.php/Descancelar/descancelarBeca/",{matricula:matricula},function(resp){
			mensajeLobibox('success',resp);
			//console.log(resp);
		});

		// Clear input
		$('#data_matricula').val('');
	}

});

//mensajeLobibox(tipo,mensaje)
//mensajeHtml0k(mensaje)
</script>
