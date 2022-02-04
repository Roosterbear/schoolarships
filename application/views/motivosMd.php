<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <h4 class="modal-title" id="modal_motivos">Estudio para otorgar Beca</h4>
  Matricula: <?php echo $matricula ?> | Periodo: <?php echo $periodo ?>
</div>

<div class="modal-body">
  <div class="col-12-lg centrado">	
    <h2>Motivos:<span class="gris"> <?php echo $motivos ?></span></h2>
    <hr> 
    <h3>Encuesta </h3>
    <table class="table table-stripped table-bordered table-hover table-condensed">
    <?php foreach($encuesta as $pregunta => $respuestas){							
 			echo "<tr>";
    		foreach($respuestas as $indice => $valor){
					echo "<td> $valor </td>";
				}		
			echo "</tr>";
    }?>
    </table>       	        
  </div>
</div>

<div class="modal-footer">
	<hr>
</div>
      