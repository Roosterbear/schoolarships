<div class="container">
	<div class="row text-center">
		<?=$ejecutado?'<h1>Convocatoria Agregada con &eacute;xito <i class="fa fa-check"></i></h1>':'<small class="red">Hubo un error <i class="fa fa-ban"></i></small>'?>
	</div>
	<div class="row">
		<div class="col-lg-3">
	        <h5><small><span>Tipo de Beca: </span></small></h5>            
	        <h2><?=$tipo_beca?></h2>
	    </div>
	    <div class="col-lg-6">
	        <h5><small><span>Descripcion: </span></small></h5>           
	        <h2><?=$descripcion?></h2>
		</div>
		<div class="col-lg-3">
	        <h5><small><span>Fecha L&iacute;mite de Inscripci&oacute;n: </span></small></h5>            
	        <h2><?=$fecha_limite_inscripcion?></h2>
	    </div>
	</div>

	<div class="row">
	    <div class="col-lg-6">
	    	<h5><small><span>Periodo publicaci&oacute;n: </span></small></h5>
	    	<h2>[<?=$periodo_publicacion?>] <?=$texto_periodo_publicacion?></h2>         
	    </div>
	    <div class="col-lg-6">
	    	<h5><small><span>Periodo resultados: </span></small></h5>
	    	<h2>[<?=$periodo_aplicacion?>] <?=$texto_periodo_aplicacion?></h2>        
	    </div>
	</div>

	<div class="row text-center">
		<div class="col-lg-4">
	        <h5><small><span>Fecha publicaci&oacute;n: </span></small></h5>         
	        <h2><?=$fecha_publicacion?></h2>
	    </div>
	    <div class="col-lg-4">
	        <h5><small><span>Fecha vencimiento: </span></small></h5>           
	        <h2><?=$fecha_vencimiento?></h2>
	    </div>
	    <div class="col-lg-4">
	        <h5><small><span>Fecha resultados: </span></small></h5>            
	        <h2><?=$fecha_resultados?></h2>
	    </div>
	</div>

	<div class="row text-center">
	    <div class="col-lg-4 text-center">
	    </div> 
	    <div class="col-lg-4 text-center">
	    	<br>
	    	<a href="#" id="regresar" class="btn btn-success btn-lg">Regresar</a>
	    </div> 
	    <div class="col-lg-4 text-center">
	    </div> 
	</div>
</div>	
<script type="text/javascript">
$("#regresar").click(function(){
	document.location.href = "http://sito-misc.app.utags.edu.mx/becas_plus/index.php/Convocatoria";
});
</script>