<div class="container-fluid" id="principal">
	<h1 id="form_space"><strong><i class="fa fa-upload verde"></i> Importaci&oacute;n de Becas</strong></h1>
	

	<form id="checar_archivo" name="checar_archivo" method="post" 
	action="<?php echo base_url().'index.php/Importacion/checarArchivo/';?>" enctype="multipart/form-data" role="form">
    <br />		

<?php
define('MATRICULA',0);
define('BECA',1);
$cargado = false;
$error_beca =  false;
// --------------------------------------
// Verificar que se haya subido un archivo
// --------------------------------------
if (isset($_POST['btn_verificar_beca'])) {	
	// --------------------------------------
	// Verificar que sea .csv
	// --------------------------------------
	if ($_FILES['archivo']['type'] == 'application/vnd.ms-excel'){
		// ----------------------------------------------
		// verificar que no pase de 900Kb y sea mayor a 0
		// ----------------------------------------------
		if (($_FILES['archivo']['size']<90000)&&($_FILES['archivo']['size']>1)){						
			move_uploaded_file($_FILES['archivo']['tmp_name'],
			'../uploads/becas.csv');

			$archivo = fopen('../uploads/becas.csv','r');
			// Revisa que no este separado por punto y coma
			$patron = '/;/';
			$punto_y_coma = preg_match($patron, file_get_contents('../uploads/becas.csv'));					
			
			$contador = 0;
			if(!$punto_y_coma){
				$cargado = true;
				while(($datos = fgetcsv($archivo,','))==true){				

					if ((trim($datos[MATRICULA]!='')) && (trim($datos[BECA]!=''))){
						// ----------------------------------------
						// Matricula
						// ----------------------------------------
						$informacion[$contador][MATRICULA] = trim($datos[MATRICULA]);
						// ----------------------------------------
						// Tipo de Beca
						// ----------------------------------------
						$informacion[$contador][BECA] = trim($datos[BECA]);

					}else{
						continue;
					}

					//echo '<small>'.$datos[MATRICULA].' - '.$datos[BECA].'</small><br />';
					if(($informacion[$contador][BECA]>20) && (!is_int($informacion[$contador][BECA]))){
	                    echo '<h1 class="marked">Hay un tipo de beca NO v&aacute;lido</h1>';
	                    $cargado = false;	
	                    $error_beca = true;									
						break;
					}
					if(!is_numeric($informacion[$contador][MATRICULA])){
	                    echo '<h1 class="marked">Hay una matricula NO v&aacute;lida</h1>';	
	                    $cargado = false;
	                    $error_beca = true;	
						break;
					}
					//echo '<br>'.$contador.'<br>';
					$contador++;
				}
			}else{
				echo '<h1 class="marked">Error en el contenido del archivo</h1>';
				$cargado = false;
			}
		}else{
            echo '<h1 class="marked">Error en tama&ntilde;o de archivo</h1>';	
            $cargado = false;
		}
	}else{
        echo '<h1 class="marked">Error en tipo de archivo</h1>';
        $cargado = false;
	}

}

if(isset($informacion)&&(!$error_beca)){
	// Estas funciones vienen del Helper
	$contador = 0;
	$repetidas = 0;
	$no_repetidas = 0;
	
	foreach(repetidas($informacion) as $r){
		$repetidas++;
	}

	foreach(unicas($informacion) as $r){
		$no_repetidas++;
	}


	echo $repetidas?'<h2>Estas matr&iacute;culas est&aacute;n repetidas y NO se agregar&aacute;n</h2><h3>':'';
	
	foreach(repetidas($informacion) as $r){
		echo $r[MATRICULA].' - '.$r[BECA].'<br />';
	}
	echo $repetidas?'</h3>':'';

	echo $no_repetidas?'<h2>Estas son las matr&iacute;culas que se guardar&aacute;n en la base de datos:</h2><h3>':'';
	foreach(unicas($informacion) as $r){
		echo $r[MATRICULA].' <i class="fa fa-caret-left" aria-hidden="true"></i> ';
		$unicas[$contador][MATRICULA] = $r[MATRICULA];
		$unicas[$contador][BECA] = $r[BECA];
		$contador++;
	}
	echo $no_repetidas?'</h3>':'';
}

?>

		<!-- Si se carga bien el archivo -->
        <?php if($cargado){ ?>
        <button type="button" class="btn btn-success btn-md" id="btn_guardar" name="btn_guardar">
            Guardar <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
        <button type="button" class="btn btn-danger btn-md" onclick="history.back()">
            Cancelar <i class="fa fa-times-circle-o" aria-hidden="true"></i></button>    

        <!-- Si ocurre un error con el archivo-->
        <?php }else{  ?>
            <button type="button" class="btn btn-danger btn-md" onclick="history.back()">
            Regresar <i class="fa fa-arrow-circle-left" aria-hidden="true"></i></button>                
        <?php } ?>
	</form>
</div>

<h3 id="insertados"></h3>


<script type="text/javascript">

var la_direccion_para_checar_los_datos = "<?php echo base_url()?>"+"index.php/Importacion/csv/";


$(document).ready(function(){

	// Funcion para sacar el periodo actual en texto 
	$.post(la_direccion_para_ver_el_id_periodo_actual,function(resp){		
		periodo_actual = resp;
    }); 
    
  //mensajeLobibox('success','chido');
   //$('#mensaje').html(mensajeHtml0k(mensaje));
	
});


/*
*
  -----GUARDAR-----
*
*/

$('#btn_guardar').click(function(e){
	var informacion = <?php echo json_encode($unicas); ?>;
	e.stopImmediatePropagation();

	$.post(la_direccion_para_checar_los_datos,{informacion:informacion},function(resp){
		
		$('#insertados').html(resp);
		$('#principal').hide();
	
	});



});

//mensajeLobibox(tipo,mensaje)
//mensajeHtml0k(mensaje)
	
/*
success
info
error
warning
default
*/
</script>
