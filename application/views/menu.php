
<div id="abc">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-4"></div>
				<div class="col-lg-4">
					<p><h1 class="titular text-center">&#1052;&#1069;&#1053;&#1059; &#1041;&#1069;&#1050;&#1040;&#1067;  </h1></p>
					<br />
					<table class="table table-bordered table-condensed">
						<tr><td>					
						<h3 id="abc_convocatorias">&#1040;&#1041;&#1050; &#1050;&#1086;&#1085;&#1074;&#1086;&#1082;&#1072;&#1090;&#1098;&#1086;&#1088;&#1080;&#1072;&#1099;</h3>
						</td></tr>
						<tr><td>
						<h3 id="abc_validadores">&#1040;&#1041;&#1050; &#1042;&#1072;&#1083;&#1080;&#1076;&#1072;&#1076;&#1086;&#1088;&#1101;&#1099;</h3>
						</td></tr>
						<tr><td>
						<h3 id="solicitudes">&#1057;&#1086;&#1083;&#1080;&#1089;&#1080;&#1090;&#1091;&#1076; &#1076;&#1101; &#1041;&#1101;&#1082;&#1072;</h3>
						</td></tr>
						<tr><td>
						<h3 id="restricciones">&#1056;&#1101;&#1089;&#1090;&#1088;&#1080;&#1082;&#1089;&#1080;&#1086;&#1085;&#1101;&#1099;</h3>
						</td></tr>
						<tr><td>
						<h3 id="reportes">&#1056;&#1101;&#1087;&#1086;&#1088;&#1090;&#1101;&#1099;</h3>
						</td></tr>
						<tr><td>
						<h3 id="asignacion">&#1040;&#1089;&#1080;&#1075;&#1085;&#1072;&#1089;&#1080;&oacute;&#1085; &#1076;&#1101; &#1041;&#1101;&#1082;&#1072;&#1099;</h3>
						</td></tr>
						<tr><td>
						<h3 id="creacion">&#1050;&#1088;&#1101;&#1072;&#1089;&#1080;&#1086;&#1085;</h3>
						</td></tr>
						<tr><td>
						<h3 id="cancelacion"><a href="<?=base_url()?>"+"index.php/Cancelacion" class="cancelacion">
							&#1050;&#1072;&#1085;&#1089;&#1101;&#1083;&#1072;&#1089;&#1080;&oacute;&#1085; &#1076;&#1101; &#1041;&#1101;&#1082;&#1072;&#1099;</a></h3>
						</td></tr>
						<tr><td class="text-center	"><h3>
						<input type="text" id="matricula">
						</h3>
						</td></tr>
					</table>
				</div>
				<div class="col-lg-4"></div>
			</div>
		</div>	
	</div>
</div>
<script type="text/javascript">
let dire_abc_convocatorias = "<?=base_url()?>"+"index.php/Convocatoria";
let dire_abc_validadores = "<?=base_url()?>"+"index.php/Validador";
let dire_solicitudes = "<?=base_url()?>"+"index.php/Solitude?uid=";
let dire_restricciones = "<?=base_url()?>"+"index.php/Restriccion?uid=8453";
let dire_reportes = "<?=base_url()?>"+"index.php/Reportes";
let dire_asignacion = "<?=base_url()?>"+"index.php/Asignacion";
let dire_creacion = "<?=base_url()?>"+"index.php/Creacion";
let dire_cancelacion = "<?=base_url()?>"+"index.php/Cancelacion";
let matricula = 0;

$('#abc_convocatorias').click(function(){
	$.post(dire_abc_convocatorias,function(resp){
		$('#abc').html(resp);
	});	
});

$('#abc_validadores').click(function(){
	$.post(dire_abc_validadores,function(resp){
		$('#abc').html(resp);
	});	
});

$('#solicitudes').click(function(){
	matricula = $('#matricula').val();
	matricula = matricula > 1?matricula:0;
	dire_solicitudes = dire_solicitudes + matricula;
	$.post(dire_solicitudes,function(resp){
		$('#abc').html(resp);
	});	
});

$('#restricciones').click(function(){
	$.post(dire_restricciones,function(resp){
		$('#abc').html(resp);
	});	
});

$('#reportes').click(function(){
	$.post(dire_reportes,function(resp){
		$('#abc').html(resp);
	});	
});

$('#asignacion').click(function(){
	$.post(dire_asignacion,function(resp){
		$('#abc').html(resp);
	});	
});

$('#creacion').click(function(){
	$.post(dire_creacion,function(resp){
		$('#abc').html(resp);
	});	
});

$('#cancelacion').click(function(){
	$.post(dire_cancelacion,function(resp){
		$('#abc').html(resp);
	});	
});
</script>