<?php 

/*
**
** RECIBE ARRAY DE MATRICULAS Y BECAS
** Y REGRESA SOLO LAS MATRICULAS DE RECHAZADOS
** QUE SON LOS QUE TIENEN BECA CERO
**
*/
function rechazados($informacion){
	foreach($informacion as $i){
		if ($i[BECA]==0) yield $i[MATRICULA];
	}
}

/*
**
** RECIBE ARRAY DE MATRICULAS Y BECAS
** Y REGRESA SOLO LAS MATRICULAS DE ACEPTADOS
** QUE SON LOS QUE TIENEN BECA MAYOR A CERO
**
*/

function aceptados($informacion){
	foreach ($informacion as $i) {
		if ($i[BECA]>0) yield $i[MATRICULA];	
	}
}

/*
**
** RECIBE ARRAY DE MATRICULAS Y BECAS
** Y REGRESA SOLO LAS MATRICULAS 
** QUE NO SE REPITEN
**
*/
function unicas($informacion){
	$registros = count($informacion)-1;
	
	// 
	for($i=0;$i<=$registros;$i++){ 
		$este_registro_esta_repetido = 0;
		//
		for($j=0;$j<=$registros;$j++){
			
			if ($i!=$j){
				if($informacion[$i][MATRICULA] == $informacion[$j][MATRICULA]){
					$este_registro_esta_repetido = 1;
					break;
				}	
			}
			
		}	

		if(!$este_registro_esta_repetido){
			yield [$informacion[$i][MATRICULA],$informacion[$i][BECA]]; 
		}
	}
	
}


/*
 **
 ** RECIBE ARRAY DE MATRICULAS Y BECAS
 ** Y REGRESA LAS REPETIDAS
 **
 */
function repetidas($informacion){
	$registros = count($informacion)-1;	
	
	//
	for($i=0;$i<=$registros;$i++){
		$este_registro_esta_repetido = 0;
		//
		for($j=0;$j<=$registros;$j++){
			if($i!=$j){
				if($informacion[$i][MATRICULA] == $informacion[$j][MATRICULA]){
					$este_registro_esta_repetido = 1;				
					break;
				}
			}			
		}

		if($este_registro_esta_repetido){
			yield [$informacion[$i][MATRICULA],$informacion[$i][BECA]];
		}
		
	}

}
/*
 ** 
 ** FECHA INICIO DE PERIODO 
 ** (Recibe id periodo y regresa fecha de inicio)
 ** 
 */	
function getFechaInicioPeriodo(){
	return true();
}
	
	
	
	
/*
 **
 ** FECHA FIN DE PERIODO
 ** (Recibe id periodo y regresa fecha fin)
 **
 */
function getFechaFinPeriodo(){
	return true;
	
}
	
	
	

 ?>