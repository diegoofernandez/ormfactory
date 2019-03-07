<?php 
	namespace CreatorUpdate\Run;
	use \PDO;
	use CreatorUpdate\Read\Json\ReadJson as read;
    use CreatorUpdate\Write\Entitys\WriteEntity as write;
	
	class CreatorUpdate{

		private static $run; //Instance class
		private static $db; //Object PDO
		private static $user; 
		private static $password;
		private static $host;
        private static $db_name;
		public static $result_create_db; //true or false - result operation create DB
        public static $result_create_all_tables; // true or false - result operation create tables
        public static $result_create_driver; //true or false - resulte operation end records

		/**
         * @param 'host -> usually: localhost', 'user -> user to access to DB', 'passowrd -> password access to DB'
         * 
         * @return 'Instance CreatorUpdate' this follow pattern Singleton
         */
		public static function prender($host, $user, $password){

			if(!isset(self::$run)){
				$string_host    = "mysql:host=".$host.";";
				self::$user     = $user;
				self::$password = $password;
				self::$host     = $host;
				self::$db       = new PDO($string_host, $user, $password);
				$saveInstance   = __CLASS__;
				self::$run      = new $saveInstance;
			}
			return self::$run;

		}#fin de función que instancia la clase

		###########################################
		# Toma de decisiones (crear, actualizar) #
		##########################################
		public static function accion($data, $action){

			switch ($action) {
				case 'create':
					forward_static_call(array('CreatorUpdate\Run\CreatorUpdate', 'creandoDatabase'), $data);
					break;
				case 'update':

					break;
			}

		}#fin de función que toma accion

		#########################
		# creando base de datos #
		#########################
		public static function creandoDatabase($dataBase){

			if(!empty($dataBase)){
				$stringDatabase    = "CREATE DATABASE IF NOT EXISTS ".$dataBase;
				$preCreacion       = self::$db->prepare($stringDatabase);
				if($preCreacion->execute()){
					$reConexion = "mysql:host=".self::$host.";dbname=".$dataBase.";";
                                        self::$db_name = $dataBase;
					self::$db   = null;
					self::$db   = new PDO($reConexion, self::$user, self::$password);
					echo "Base de datos creada correctamente. Creando tablas...<br>";
					self::$result_create_db = true;
				}else{
					echo "Error al crear base de datos.";
				}
			}

		}#fin de función creación database	

		#####################
		# creando tablas db #
		#####################
		public static function creandoTablas($tablas){

			$objRead = new read($tablas);
			$runRead = $objRead->constructStringSql();

			$resultRead = $objRead->estadoConsulta();

			if($resultRead){

				$stringCraft = $objRead->retornoConsulta();
                                
                for($i=0; $i<= count($stringCraft)-1; $i++){
                    $runTables = self::$db->prepare($stringCraft[$i]);
                    if($runTables->execute()){
                        echo "Tabla creada correctamente...<br>";
                        self::$result_create_all_tables = true;
                    }else{
                        echo "Error al crear tabla.<br>";
                    }
                }

			}else{
				echo "Ha fallado la creacion de la consulta para crear las tablas";
			}


		}#fin de función creación de tablas


		#####################################
		# Función return result creación db #
		#####################################
		public static function resultCreateDb(){

			return self::$result_create_db;

		}#fin funcion retorno resultado
                
                #######################################################
                # Función que crea el driver de conexión de entidades #
                #######################################################
                public static function createDriverEntitys(){
                    
                    $creando_carpeta_padre = mkdir('../Entitys', 0777);
                    if($creando_carpeta_padre){
                        
                        $carpeta_requeriments = mkdir('../Entitys/requeriments', 0777);
                        $carpeta_model = mkdir('../Entitys/model', 0777);
                        if($carpeta_requeriments && $carpeta_model){
                            
                            $template_connect_driver = "<?php \n"
                                    . "Class Connection extends PDO{ \n"
                                        . "\tpublic static function handler_error(\$exception){\n\n"
                                            . "\t\tdie('Error de excepción: \$exception->getMessage()');\n\n"
                                        . "\t}\n"
                                        . "\tpublic function __construct(\$host = '".self::$host."', \$basedatos='".self::$db_name."', \$user='".self::$user."', \$pass='".self::$password."'){\n\n"
                                        . "\t\tset_exception_handler(array(__CLASS__, 'handler_error'));\n"
                                        . "\t\tparent::__construct('mysql:host=".self::$host.";dbname=".self::$db_name.";', \$user, \$pass);\n"
                                        . "\t\trestore_exception_handler();\n\n"
                                        . "\t}\n"
                                    . "}\n"
                                    . "?>";
                            
                            if(file_put_contents("../Entitys/model/Connection.php", $template_connect_driver)){
                                echo "<br>Carpetas y archivo driver Connect.php se ha creado correctamente.<br>";
                                self::$result_create_driver = true;
                            }
                            
                        }else{
                            
                            echo "<br>No se pudo crear carpeta 'requeriments' y/o 'model'.<br>";
                            
                        }
                        
                    }else{
                        echo "<br>No se pudo crear la carpeta 'Entitys'<br>";
                    }
                    
                }#fin de create driver entity

                ############################################################
                # Función que crea las entidades, queries y requerimientos #
                ############################################################
                public static function createEntitysAndMore(){
                    
                    $stringAllTables = "SHOW TABLES FROM ".self::$db_name;
                    $trayendoTablas = self::$db->prepare($stringAllTables);
                    
                    //traemos todas las tablas y comprobamos el resultado
                    if($trayendoTablas->execute()){
                        
                        $objetoEscritor = new write();
                        $tablasTotales = $trayendoTablas->fetchAll(PDO::FETCH_COLUMN);
                        
                        //creando loader de clases
                        $rutaRequeriments = "../Entitys/requeriments/load.php";
                        $firstStringLoaderFile = "<?php\n"
                                        . "\n"
                                        . "\tspl_autoload_register(function(){\n\n"
                                        . "\t\trequire_once 'Entitys/model/Connection'.'.php';\n"
                                        . "\t\trequire_once 'Entitys/requeriments/Guardian'.'.php';\n\n";
                        $creando_load = file_put_contents($rutaRequeriments, $firstStringLoaderFile);
                        
                        //iteramos sobre las tablas obtenidas
                        for($i=0; $i <= count($tablasTotales)-1; $i++){
                            //guardamos el nombre de la tabla
                            $objetoEscritor->nameEntity($tablasTotales[$i]);
                            
                            $consultaCampos = "SELECT * FROM ".$tablasTotales[$i];
                            $runConsultaCampos = self::$db->prepare($consultaCampos);
                            $runConsultaCampos->execute();
                            $nombresCamposTabla = array();
                            for($z= 0; $z <= $runConsultaCampos->columnCount()-1; $z++){
                                
                                $camposActuales = $runConsultaCampos->getColumnMeta($z);
                                if(!(isset($camposActuales["flags"][1]) && $camposActuales["flags"][1] == "primary_key") || !isset($camposActuales["flags"][1])){
                                    array_push($nombresCamposTabla, $camposActuales["name"]);
                                }
                                
                            }
                            $objetoEscritor->nameFields($nombresCamposTabla);
                            
                            //ejecutamos el creador de entidad
                            $resultOperation = $objetoEscritor->infoReady();
                            if($resultOperation){
                                
                                if($creando_load != false || $creando_load != null){
                                    $objetoEscritor->factoryEntity($rutaRequeriments);
                                }
                                
                            } else {
                                echo "<br>Ha ocurrido un error y no puede procederse a crear las entidades<br>";
                            }
                            
                        }#fin de for iteracion de tablas
                        
                        //cerrando archivo load.php
                        $stringLoadClose = "\t\t\t});\n?>";
                        file_put_contents($rutaRequeriments, $stringLoadClose, FILE_APPEND);
                        
                        //copiando guardian a directorio entity
                        copy('Guardian.php', "../Entitys/requeriments/Guardian.php");
                    }else{
                        
                        echo "<br>No se pueden traer tablas<br>";
                        
                    }#fin de if/else que trae la totalidad de tablas en db
                    
                }#fin de funcion create entitys and more
                
	}#fin de clase

?>