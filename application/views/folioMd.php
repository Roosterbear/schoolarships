<div class="modal-header no-printable">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <h4 class="modal-title" id="modal_folio">Folio de Beca Solicitada</h4>
</div>

<div class="modal-body">
  <div class="col-12-lg centrado">
	<div class="text-center"><img src="<?=base_url()?>application/assets/images/logo.png"></div>
    <h2 class="text-center"><span class="gris">Matr&iacute;cula del solicitante: </span><strong><?=$matricula?></strong></h2>
    <h2 class="text-center"><span class="gris">Folio Solicitud de Beca:</span> <strong><?=$folio ?></strong></h2>
    <h2 class="text-center"><span class="gris">Tipo de Beca: </span><strong><?=$tipo == 1?'ACADEMICA':($tipo == 2?'DEPORTIVA / CULTURAL':($tipo == 3?'TRANSPORTE':'VULNERABILIDAD')) ?></strong></h2>
    <h2 class="text-center"><span class="gris">Fecha de Resultados: </span><strong><?=$resultados ?></strong></h2>
    <hr>
	<div class="text-center">
	  	<button type="button" class="btn btn-success" onClick="window.print();" value='Imprimir'>
	    	Imprimir
	    </button>
	</div>
  </div>
</div>

<div class="modal-footer">
</div>
