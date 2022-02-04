<div class="container-fluid">

	<h1 id="form_space"><strong>Cancelacion de Becas</strong> <?php echo $usuario ?></h1>

	<h2 class="verde">&Uacute;nicamente se cancelar&aacute;n becas del periodo actual <strong id="datos_periodo"></strong></h2>
	<h3 class="gris">Alumno: <strong id="nombre_alumno"> </strong></h3>
	<form id="cancelacion_de_becas" name="cancelacion_de_becas" method="post" action="#" role="form">
		<h2>
			<div class="input-group">
				<label for="data_matricula"></label>Matr&iacute;cula: 
				<input id="data_matricula" name="data_matricula" value="" class="form-control">
			</div>
		</h2>

		<span class="input-group-btn">
			<!-- BOTON PARA VERIFICAR (Que sea alumno becado y realmente quiera cancelar su beca) -->  
			<a href="#" class="btn btn-success btn-md" id="btn_verificar_beca" name="btn_verificar_beca">Verificar <i class="fa fa-check-circle" aria-hidden="true"></i></a>

			<!-- BOTON PARA CANCELAR (Ya habiendo verificado que si es alumno, acepta la advertencia de cancelar) -->  
			<a href="#" class="btn btn-danger btn-md margen_derecho" id="btn_cancelar_beca" name="btn_cancelar_beca">Eliminar <i class="fa fa-trash" aria-hidden="true"></i></a>

			<!-- BOTON PARA RESETEAR (Recarga la pagina) -->  
			<a href="#" class="btn btn-primary btn-md" id="btn_resetear" name="btn_resetear">Regresar <i class="fa fa-rotate-left" aria-hidden="true"></i></a>
		</span>
	</form>
</div>
<div id="mensaje"></div>
<script type="text/javascript">
var matricula = 0;
var mensaje_no_becado = 'La matricula proporcionada NO es de un alumno becado en el periodo';
var mensaje_becado = 'Se proceder&aacute; a cancelar esta beca';


$(document).ready(function(){
	$('#btn_cancelar_beca').hide();
	$('#btn_resetear').hide();
	
	// Funcion para sacar el periodo actual en texto 
	$.post("<?=base_url()?>"+"index.php/Cancelacion/datosPeriodo/",function(resp){
		$('#datos_periodo').html(resp);
	}); 

	
	// VERIFICAR QUE ES ALUMNO Y ESTA BECADO
		$('#btn_verificar_beca').on('click',function(){
		matricula = $('#data_matricula').val();
		verificar_beca(matricula);
		obtener_nombre_alumno(matricula);
	});


	// CANCELAR BECA
	$('#btn_cancelar_beca').on('click',function(){
		matricula = $('#data_matricula').val();
		cancelar_beca(matricula);
	});

	// RESETEAR DATOS
	$('#btn_resetear').on('click',function(){		
		location.reload(true);
	});


	// ACCION SI SE DA ENTER (Checa que ya se haya verificado la matricula)
	$("#data_matricula").on("keydown",function(e){
		matricula = $('#data_matricula').val();
		if(e.keyCode == 13){
			e.preventDefault();
			e.stopImmediatePropagation();
			verificar_beca(matricula);
			obtener_nombre_alumno(matricula);
		}
	});


	function verificar_beca(matricula){
		$.post("<?=base_url()?>"+"index.php/Cancelacion/verificarBeca/",{matricula:matricula},function(resp){
			if (resp){
				mensajeLobibox('error',mensaje_becado);
				$('#btn_verificar_beca').hide();
				$('#btn_cancelar_beca').show();
				$('#btn_resetear').show();
				$('#data_matricula').prop("disabled",true);
			}else{
				mensajeLobibox('warning',mensaje_no_becado);
			}
		}); 
/*
success
info
error
warning
default
*/
	}

	function obtener_nombre_alumno(matricula){
		
		$.post("<?=base_url()?>"+"index.php/Cancelacion/obtenerNombreAlumno/",{matricula:matricula},function(resp){
			//poner aqui el nombre
			$('#nombre_alumno').html(resp);
		}); 
		

	}	

	function cancelar_beca(matricula){		
		$.post("<?=base_url()?>"+"index.php/Cancelacion/cancelarBeca/",{matricula:matricula},function(resp){
			mensajeLobibox('success',resp);			
		}); 
		$('#btn_cancelar_beca').hide();
	}

});

//mensajeLobibox(tipo,mensaje)
//mensajeHtml0k(mensaje)
</script>

