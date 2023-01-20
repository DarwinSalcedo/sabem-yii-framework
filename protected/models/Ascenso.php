<?php

class Ascenso extends CActiveRecord{

	// --------------------------- CALCULO DE PUNTAJE CON AÑOS DE SERVICIO -----------------------------------

	public static function getAnosServicio($funcionario){
		$anos_antiguedad = new Antiguedad;
		$criteria = new CDbCriteria(
					array(
						'select'=>'Fecha_Ingreso',
						'condition'=>'Cedula=:ci',
						'params'=>array(
									':ci'=>$funcionario
								)
					)
		);
		$fecha_ingreso_func = Funcionarios::model()->find($criteria);
		return $anos_antiguedad->calcularAnos($fecha_ingreso_func->Fecha_Ingreso); //Retorna la cantidad de años de servicio

	}

	public static function getPuntajeAnosServicio($cant_anos){
		if ($cant_anos > 20) return 20; //Si es mayor a 20 siempre sera 20 ptos
		else 
			return $cant_anos; //sino retorna la cantidad de años como puntaje (0-20)
	}

	public static function obtenerNotaAnosServicios($funcionario){
		return Ascenso::getPuntajeAnosServicio(Ascenso::getAnosServicio($funcionario));
	}

	// --------------------------- CALCULO DE PUNTAJE NOTAS DESEMPEÑO -----------------------------------

	// ------------------------------------ ESPIRITU BOMBERIL -------------------------------------------

	public static function getnotaEspirituBomberilFinal($funcionario,$conf_asc_fecha){
		$criteria = new CDbCriteria(
					array(
						'select'=>'num_TotEspPorc',
						'condition'=>'id_conf_asc_fecha=:confg_fecha AND Cedula=:ci',
						'params'=>array(
									':confg_fecha'=>$conf_asc_fecha,
									':ci'=>$funcionario
								)
					)
		);
		if (EspirituBomberil::model()->exists($criteria)){
			$nota_final = EspirituBomberil::model()->find($criteria);
			return $nota_final->num_TotEspPorc;			
		}
		return 0.000;
		//return $nota_final;

	}

	// ------------------------------------ COMPETENCIA -------------------------------------------


	public static function getnotaCompetenciaFinal($funcionario,$conf_asc_fecha){
		$criteria = new CDbCriteria(
					array(
						'select'=>'num_TotComPorc',
						'condition'=>'id_conf_asc_fecha=:confg_fecha AND Cedula=:ci',
						'params'=>array(
									':confg_fecha'=>$conf_asc_fecha,
									':ci'=>$funcionario
								)
					)
		);
		if (Competencia::model()->exists($criteria)){
			$nota_final = Competencia::model()->find($criteria);
			return $nota_final->num_TotComPorc;			
		}
		return 0.000;
		//return $nota_final;

	}

	// ------------------------------------ DESEMPEÑO -------------------------------------------


	public static function getnotaDesempenhoFinal($funcionario,$conf_asc_fecha){
		$criteria = new CDbCriteria(
					array(
						'select'=>'num_TotDesemPorc',
						'condition'=>'id_conf_asc_fecha=:confg_fecha AND Cedula=:ci',
						'params'=>array(
									':confg_fecha'=>$conf_asc_fecha,
									':ci'=>$funcionario
								)
					)
		);
		if (Desempenho::model()->exists($criteria)){
			$nota_final = Desempenho::model()->find($criteria);
			return $nota_final->num_TotDesemPorc;			
		}
		return 0.000;
		//return $nota_final;

	}

	// ------------------------------------ APTITUD-ACTITUD---------------------------------------


	public static function getnotaAptitudActitudFinal($funcionario,$conf_asc_fecha){
		$criteria = new CDbCriteria(
					array(
						'select'=>'num_TotApPorc',
						'condition'=>'id_conf_asc_fecha=:confg_fecha AND Cedula=:ci',
						'params'=>array(
									':confg_fecha'=>$conf_asc_fecha,
									':ci'=>$funcionario
								)
					)
		);
		if (AptitudActitud::model()->exists($criteria)){
			$nota_final = AptitudActitud::model()->find($criteria);
			return $nota_final->num_TotApPorc;			
		}
		return 0.000;
		//return $nota_final;

	}

	// ------------------------------------ HABILIDAD---------------------------------------


	public static function getnotaHabilidadFinal($funcionario,$conf_asc_fecha){
		$criteria = new CDbCriteria(
					array(
						'select'=>'num_TotHaPorc',
						'condition'=>'id_conf_asc_fecha=:confg_fecha AND Cedula=:ci',
						'params'=>array(
									':confg_fecha'=>$conf_asc_fecha,
									':ci'=>$funcionario
								)
					)
		);
		if (Habilidad::model()->exists($criteria)){
			$nota_final = Habilidad::model()->find($criteria);
			return $nota_final->num_TotHaPorc;			
		}
		return 0.000;
		//return $nota_final;

	}

	public static function obtenerNotaFinalDesempenho($funcionario,$conf_asc_fecha){
		$acum = 0;
		$acum += Ascenso::getnotaEspirituBomberilFinal($funcionario,$conf_asc_fecha);
		$acum += Ascenso::getnotaCompetenciaFinal($funcionario,$conf_asc_fecha);
		$acum += Ascenso::getnotaDesempenhoFinal($funcionario,$conf_asc_fecha);
		$acum += Ascenso::getnotaAptitudActitudFinal($funcionario,$conf_asc_fecha);
		$acum += Ascenso::getnotaHabilidadFinal($funcionario,$conf_asc_fecha);

		return $acum;

		
		/*return  Ascenso::getnotaEspirituBomberilFinal($funcionario,$conf_asc_fecha)+
				Ascenso::getnotaCompetenciaFinal($funcionario,$conf_asc_fecha)+
				Ascenso::getnotaDesempenhoFinal($funcionario,$conf_asc_fecha)+
				Ascenso::getnotaAptitudActitudFinal($funcionario,$conf_asc_fecha)+
				Ascenso::getnotaHabilidadFinal($funcionario,$conf_asc_fecha);*/

	}

	// ---------------------------------- CALCULAR EQUIVALENTE A NOTA FINAL ----------------------

	public static function obtenerEquivalenteFinal($tipo_evaluacion){
		switch ($tipo_evaluacion){
			case 'academico': 
			case 'antiguedad':
			case 'desempenho':
			case 'mejoramiento_profesional': return 0.20;
			case 'cursos': return 0.16;
			case 'condecoraciones': return 0.04;
		}
	}

	/*
		Este metodo se utiliza para calcular la nota final promediada de todos los aspectos evaluados
		(desempeños, condecoraciones, años de servicio, cursos, nivel academico, etc)
	*/

	public static function obtenerNotaFinalDeAscenso($ci_funcionario,$conf_asc_fecha){
		$acum = 0.000;
		$acum += Ascenso::obtenerNotaAnosServicios($ci_funcionario) * Ascenso::obtenerEquivalenteFinal('antiguedad');
		$acum += Ascenso::obtenerNotaFinalDesempenho($ci_funcionario,$conf_asc_fecha) * Ascenso::obtenerEquivalenteFinal('desempenho');
		$acum += Ascenso::obtenerNotaFinalNivelAcademico($ci_funcionario) * Ascenso::obtenerEquivalenteFinal('academico'); //NIVEL ACADEMICO
		$acum += 20 * Ascenso::obtenerEquivalenteFinal('mejoramiento_profesional'); //MEJORAMIENTO PROFESIONAL
		$acum += 16 * Ascenso::obtenerEquivalenteFinal('cursos'); //DIPLOMADOS Y CURSOS
		$acum += 0.16 * Ascenso::obtenerEquivalenteFinal('condecoraciones'); //CONDECORACIONES
		return $acum;
	}

	// -------------------------------- CALCULAR NOTA FINAL DEL NIVEL ACADEMICO ------------------------------
	
	public static function obtenerNotaFinalNivelAcademico($funcionario){		
		
		$nivel_aca = Funcionarios::getNotaNivelAcademico($funcionario);
		return $nivel_aca;
	}

	// -------------------------------- SABER SI UN FUNCIONARIO ES APTO PARA ASCENDER ------------------------------

	public function isApto($ci_funcionario,$conf_asc_fecha){	

		return 	(Ascenso::mediApto($ci_funcionario,$conf_asc_fecha))
			&&	(Ascenso::fisiApto($ci_funcionario,$conf_asc_fecha)) //Si todo verdadero, es apto (true)
			&&	(Ascenso::dopingApto($ci_funcionario,$conf_asc_fecha)) //A la primera falsa, se corta la busqueda y no es apto (false)
			&&	TRUE; #(Ascenso::psiquiApto($ci_funcionario,$conf_asc_fecha)); 
	}

	public static function mediApto($ci_funcionario,$conf_asc_fecha){

		$criteria_medica = new CDbCriteria(
			array(
				'select'=>'Cedula,des_asist_exa_medico,des_asist_exa_condicion,id_conf_asc_fecha',
				'condition'=>'id_conf_asc_fecha=:conf_fech AND Cedula=:ci',
				'params'=>array(
							':conf_fech'=>$conf_asc_fecha,
							':ci'=>$ci_funcionario
						)
			)
		);
		
		if (!ExamenMedico::model()->exists($criteria_medica))
			return false;
		else{//si existe
			$medica = ExamenMedico::model()->find($criteria_medica); //leer el valor de la bdd
			if ($medica->des_asist_exa_medico == "INASISTENTE")//si inasistente
				return false;
			else{//si asistente
				if ($medica->des_asist_exa_condicion == "NO APTO")
					return false;
			}
		}
		return true;
	}

	public static function fisiApto($ci_funcionario,$conf_asc_fecha){
		$criteria_fisica = new CDbCriteria(
			array(
				'select'=>'Cedula,des_fisica_asistencia,des_fisica_condicion,id_conf_asc_fecha',
				'condition'=>'id_conf_asc_fecha=:conf_fech AND Cedula=:ci',
				'params'=>array(
							':conf_fech'=>$conf_asc_fecha,
							':ci'=>$ci_funcionario
						)
			)
		);
		//$fisica = Fisica::model()->exists($criteria_fisica);//find($criteria_fisica);

		if (!Fisica::model()->exists($criteria_fisica))
			return false;
		else{//si existe
			$fisica = Fisica::model()->find($criteria_fisica); //leer el valor de la bdd
			if ($fisica->des_fisica_asistencia == "INASISTENTE")//si inasistente
				return false;
			else{//si asistente
				if ($fisica->des_fisica_condicion == "NO APTO")
					return false;
			}
		}
		return true;
	}

	public static function dopingApto($ci_funcionario,$conf_asc_fecha){
		$criteria_antidoping = new CDbCriteria(
			array(
				'select'=>'Cedula,des_antid_asistencia,des_antid_condicion,id_conf_asc_fecha',
				'condition'=>'id_conf_asc_fecha=:conf_fech AND Cedula=:ci',
				'params'=>array(
							':conf_fech'=>$conf_asc_fecha,
							':ci'=>$ci_funcionario
						)
			)
		);
		//$antidoping = Antidoping::model()->exists($criteria_antidoping); //find($criteria_antidoping);
		if (!Antidoping::model()->exists($criteria_antidoping))
			return false;
		else{//si existe
			$antidoping = Antidoping::model()->find($criteria_antidoping); //leer el valor de la bdd
			if ($antidoping->des_antid_asistencia == "INASISTENTE")//si inasistente
				return false;
			else{//si asistente
				if ($antidoping->des_antid_condicion == "NO APTO")
					return false;
			}
		}
		return true;

	}

	public static function psiquiApto($ci_funcionario,$conf_asc_fecha){
		$criteria_psiquica = new CDbCriteria(
			array(
				'select'=>'Cedula,des_psi_asistencia,des_psi_condicion,id_conf_asc_fecha',
				'condition'=>'id_conf_asc_fecha=:conf_fech AND Cedula=:ci',
				'params'=>array(
							':conf_fech'=>$conf_asc_fecha,
							':ci'=>$ci_funcionario
						)
			)
		);
		//$psiquica = Psiquica::model()->exists($criteria_psiquica);// find($criteria_psiquica);
		if (!Psiquica::model()->exists($criteria_psiquica))
			return false;
		else{//si existe
			$psiquica = Psiquica::model()->find($criteria_psiquica); //leer el valor de la bdd
			if ($psiquica->des_psi_asistencia == "INASISTENTE")//si inasistente
				return false;
			else{//si asistente
				if ($psiquica->des_psi_condicion == "NO APTO")
					return false;
			}
		}
		return true;
	}
	// ----------- METODOS PARA OBTENER LA NOTA MINIMA FINAL PARA ASCENDER SEGUN LA GERARQUIA A LA QUE ASPIRA -------------

	public static function notaMinimaPorJerarquia($jerarquia){
		switch ($jerarquia){		
			case 'CORONEL':
			case 'TENIENTE CORONEL':
			case 'MAYOR':
			case 'CAPITAN':
			case 'TENIENTE':
			case 'SUBTENIENTE': return 14.00;		
			
			case 'SARGENTO AYUDANTE':
			case 'SARGENTO PRIMERO':
			case 'SARGENTO SEGUNDO': return 13.00;

			case 'CABO PRIMERO':
			case 'CABO SEGUNDO':
			case 'DISTINGUIDO': return 12.00;

			case 'BOMBERO':
			case 'ALUMNO':
			case 'CIVIL': return 0.00;

		}
	}
	public static function obtenerNombreJerarquia($Cod_Jerarquia){
		$jerarquia = new Funcionarios;
		return $jerarquia->getNombreJerarquia($Cod_Jerarquia);
	}

	public static function obtenerNotaMinimaPorJerarquia($Cod_Jerarquia){
		return Ascenso::notaMinimaPorJerarquia(Ascenso::obtenerNombreJerarquia($Cod_Jerarquia));
	}

	public static function obtenerPostulados(){
		$criteria = new CDbCriteria(
			array(
				'select'=>'Cedula,id_conf_asc_fecha,Cod_Jerarquia',
				'condition'=>'id_conf_asc_fecha=:id',
				'params'=>array(
							':id'=>FechaAsc::obtenerUltimoId()

						#	':id'=>2//FechaAsc::obtenerUltimoId()

						)
			)
		);
		$postulados=Postulados::model()->findAll($criteria);
		return $postulados;
	}

	

	public static function obtenerPostuladosAAscender(){
		$postulados = array();
		$aprobados = array();

		$j = 0;

		$postulados = Ascenso::obtenerPostulados(); //Obtengo todos los postulados con la ultima configuracion de ascenso

		for ($i=0,$size=count($postulados);$i<$size;$i++){
			$nota_final = 0;
			if (Ascenso::isApto($postulados[$i]->Cedula,$postulados[$i]->id_conf_asc_fecha)){

				$nota_final = Ascenso::obtenerNotaFinalDeAscenso($postulados[$i]->Cedula,$postulados[$i]->id_conf_asc_fecha);

				if ($nota_final >= Ascenso::obtenerNotaMinimaPorJerarquia($postulados[$i]->Cod_Jerarquia)){

					$aprobados[$j]['funcionario'] = $postulados[$i];
					$aprobados[$j++]['nota'] = $nota_final;
				}
			}
			else continue;
		}
		
		if (empty($aprobados)) 
			return null; 
		else{
			$aprobados_ordenados_por_nota = Ascenso::ordenarByNota($aprobados);
			return $aprobados_ordenados_por_nota;			
		} 
	}

	public static function ordenarByNota($array_a_ordenar){
		foreach ($array_a_ordenar as $key => $row) {
   			$aux[$key] = $row['nota'];
   			//print_r($aux);
		}
		array_multisort($aux, SORT_DESC, $array_a_ordenar);
		return $array_a_ordenar;
	}




	/**
	public function obtenerPostulados(){

		$criteria = new CDbCriteria(
			array(
				'select'=>'Cedula,id_conf_asc_fecha',
				'condition'=>'id_conf_asc_fecha=:id',
				'params'=>array(
							':id'=>FechaAsc::obtenerUltimoId()
						)
			)
		);
		$postulados=Postulados::model()->findAll($criteria);
		var_dump($postulados);


	}


	public function actionObtenerPostulados(){
		
		$criteria = new CDbCriteria(
			array(
				'condition'=>'id_conf_asc_fecha=:id',
				'params'=>array(
							':id'=>FechaAsc::obtenerUltimoId()
						)
			)
		);


		$postulados = Postularse::model()->findAll($criteria);
		var_dump($criteria,$postulados);
	}

	public function actionCreate(){
		//$var="asdgljhyasdjkhgjhasdh";
		//var_dump($var);

		$criteria = new CDbCriteria(
			array(
				'select'=>'Cedula,id_conf_asc_fecha',
				'condition'=>'id_conf_asc_fecha=:id',
				'params'=>array(
							':id'=>2//FechaAsc::obtenerUltimoId()
						)
			)
		);
		$postulados=Postulados::model()->findAll($criteria);
		
		foreach($postulados as $row): 
			$apto = AscensoController::isApto($row->Cedula,$row->id_conf_asc_fecha);
 			var_dump($row,$apto);
		endforeach; 
		

	}


		


	
	FUNCION QUE NO SE UTILIZA AUN.

	public static function truncateFloat($number, $digitos){
	    $raiz = 10;
	    $multiplicador = pow ($raiz,$digitos);
	    $resultado = ((int)($number * $multiplicador)) / $multiplicador;
	    return number_format($resultado, $digitos);

	}
	*/

}