
<div class="container-fluid">

	<h1 id="form_space"><strong><i class="fa fa-upload verde"></i> Importaci&oacute;n de Becas</strong></h1>
	<h2 class="verde">&Uacute;nicamente se importar&aacute;n becas al periodo actual: <strong id="datos_periodo"></strong></h2>
	<!-- El periodo esta basado en el campo ACTIVO de la tabla periodo -->  
	<hr />
	
	<form id="importacion_de_becas" name="importacion_de_becas" method="post" 
	action="<?php echo base_url().'index.php/Importacion/checarArchivo/';?>" enctype="multipart/form-data" role="form">
		<h4><i class="fa fa-check-square-o verde" aria-hidden="true"></i> El contenido solo debe ser de <strong>n&uacute;meros</strong> separados por comas</h4>
		<h4><i class="fa fa-check-square-o verde" aria-hidden="true"></i> El archivo debe ser con extensi&oacute;n  <strong>.csv</strong></h4>
		<h4><i class="fa fa-check-square-o verde" aria-hidden="true"></i> Primero debe ir la <strong>matr&iacute;cula</strong> y despu&eacute;s la clave de la beca a aplicar</h4>
		<hr />

		<h2 id="seleccion_de_tipo"></h2>
		<label for="archivo">Selecciona</label>
		<input type="file" id="archivo" name="archivo" required accept=".csv">
		<br />
		<button type="submit" class="btn btn-primary btn-md" id="btn_verificar_beca" name="btn_verificar_beca">Verificar <i class="fa fa-cloud-upload" aria-hidden="true"></i></button>
		<h4><i class="fa fa-check-square-o gris" aria-hidden="true"></i> Se verificar&aacute; que la informaci&oacute;n del archivo sea correcta</h4>
	</form>
</div>
<script type="text/javascript">

var la_direccion_para_ver_el_periodo_actual = "<?php echo base_url()?>"+"index.php/Cancelacion/datosPeriodo/";

$(document).ready(function(){
	// Funcion para sacar el periodo actual en texto 
	// Esta funcion viene del Controlador CANCELACION y se basa en el periodo real
	$.post(la_direccion_para_ver_el_periodo_actual,function(resp){
		$('#datos_periodo').html(resp);
    }); 
});
</script>