<?php 
	
	Class Guardian{

		###########################
		# Función setter datos #
		###########################
		public static function runSetSql($data, $info){

			$stringSql = "UPDATE ".$info[3]." SET ".$info[0]."=? WHERE ".$info[2]."=?";
			$dbObj = new Connection();
			$updateSet = $dbObj->prepare($stringSql);
			$updateSet->bindParam(1, $data);
			$updateSet->bindParam(2, $info[1]);
			$updateSet->execute();
			if($updateSet->rowCount() > 0){
				echo "<br>Dato ".$info[0]."<br>";
			}
			
		}#fin de setter
		###############

		##################
		# Función delete #
		##################
		public static function runDelSql($data, $info){

			$stringSql = "DELETE FROM ".$info[0]." WHERE ".$info[1]."=?";
			$dbObj = new Connection();
			$deleteSet = $dbObj->prepare($stringSql);
			$deleteSet->bindParam(1, $data);
			$deleteSet->execute();
			if($deleteSet->rowCount() > 0){
				echo "<br>Campo con el id ".$info[1]." borrado correctamente.<br>";
			}

		}#fin de funcion runDelSql
		##########################



		##################################################
		# Función que inserta un nuevo valor en la tabla #
		##################################################
		public static function newInsertSql(){

			//argumnetos recibidos
			$args = func_get_args();

			//obtenemos el array de informacion de consulta (en la última posición se encuentran los campos a insertarse y el nombre de la tabla)
			$metaDataInsert = array_pop($args);
			//extraemos el nombre de la tabla
			$nombreTabla = strtolower(array_pop($metaDataInsert));
			$stringSql = "INSERT INTO ".$nombreTabla."(";

			//variable a rellenar con los campos a insertarse
			$valToval = "";
			$valTovalActual = 1;

			$dataToInsert = " VALUES(";
			$dataToInsertActual = 1;

			//preparamos el string de los campos a insertarse
			for($i=0; $i <= count($metaDataInsert)-1; $i++){

				if($valTovalActual != count($metaDataInsert)){
					$valToval = $valToval.$metaDataInsert[$i].",";
				}else{
					$valToval = $valToval.$metaDataInsert[$i].")";
				}
				$valTovalActual++;

			}//fin de for

			//agregando parametros a la cadena sql
			if($valToval != null || !empty($valToval)){

				for($x = 0; $x <= count($metaDataInsert)-1; $x++){
					if($dataToInsertActual != count($metaDataInsert)){
						$dataToInsert = $dataToInsert."?,";
					}else{
						$dataToInsert = $dataToInsert."?)";
					}
					$dataToInsertActual++;
				}

			}else{

				echo "<br>Error. No se pueden configurar los campos de la tabla</br>";

			}//fin de if/else que agrega parametros

			$stringSql = $stringSql.$valToval.$dataToInsert;
			
			$dbObj = new Connection();
			$insertSql = $dbObj->prepare($stringSql);
			$paramIndex = 1;

			for ($i=0; $i <= count($args)-1; $i++) { 
				$insertSql->bindParam($paramIndex, $args[$i]);
				$paramIndex++;
			}
			
			$dataReturn;//variable to return

			if($insertSql->execute()){
				
				$idLastInsert = $dbObj->lastInsertId();
				$recoveryData = $dbObj->prepare("SELECT * FROM ".$nombreTabla." WHERE id=?");
				$recoveryData->bindParam(1, $idLastInsert);

				if($recoveryData->execute()){
					$dataReturn = $recoveryData->fetch(PDO::FETCH_ASSOC);
				}else{
					echo "<br>No se pudo recuperar la última consulta de la base de datos<br>";
				}

			}

			return $dataReturn;


		}#fin de funcion newInsertSql
		#############################

		###############################################
		# Función que devuelve todos los datos juntos #
		###############################################
		public function runGetAll($info){

			$stringSql = "SELECT * FROM ".$info[0]." WHERE ".$info[2]."=?";

			$dbObj = new Connection();
			$getAllData = $dbObj->prepare($stringSql);
			$getAllData->bindParam(1, $info[1]);

			$valueToReturn;
			if($getAllData->execute()){
				$valueToReturn = $getAllData->fetch(PDO::FETCH_ASSOC);
			}else{
				$valueToReturn = null;
			}

			return $valueToReturn;

		}
		
	}

?>