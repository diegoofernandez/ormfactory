<?php 
    namespace CreatorUpdate\Write\Entitys;
    
    Class WriteEntity{
        
        private $nombre_tabla_actual; 
        private $nombre_campos;
        private $readyForRun; 
        
        ###############################
        //almacenando nombre de Entidad
        public function nameEntity($name){
            
            $this->nombre_tabla_actual = $name;
            echo "<br>Nombre de entidad: ".$this->nombre_tabla_actual."<br>";
        }#fin de name entity
        
        ##############################
        //almacenando nombre de campos
        public function nameFields($fields){
            
            $this->nombre_campos = $fields;
            var_dump($this->nombre_campos);
            
        }#fin de name fields
        
        ####################################
        //funcion que inicializa readyForRun
        public function infoReady(){
            
            if($this->nombre_tabla_actual != null && $this->nombre_campos != null){
                $this->readyForRun = true;
            }else{
                $this->readyForRun = false;
            }
            
            return $this->readyForRun;
            
        }#fin de infoReady
        
        #################################
        //funcion que escribe la entidad
        public function factoryEntity($rutaFileRequeriments){
            
            $addEntityToLoad = "\t\trequire_once 'Entitys/".ucwords($this->nombre_tabla_actual)."'.'.php';\n\n";
            $resultWritingLoad = file_put_contents($rutaFileRequeriments, $addEntityToLoad, FILE_APPEND);
            
            if($resultWritingLoad != false || $resultWritingLoad != null){
                
                $pathEntity = "../Entitys/".$this->nombre_tabla_actual.".php";
                $stringThisEntity = "<?php\n\n"
                        . "\tClass ". ucwords($this->nombre_tabla_actual)."{\n\n"
                        . "\t\t private \$id;\n";
                
                //for que crea las propiedades de la entidad
                for($i=0;$i <= count($this->nombre_campos)-1; $i++){
                    $stringAddProperty = "\t\tprivate \$".$this->nombre_campos[$i].";\n";
                    $stringThisEntity = $stringThisEntity.$stringAddProperty;
                }
                
                //creando los parametros del constructor
                $stringParamConstruct = "";
                $counterParam = 1;
                for($i=0; $i <=count($this->nombre_campos)-1; $i++){
                    
                    if($counterParam == count($this->nombre_campos)){
                        $stringParamConstruct = $stringParamConstruct."\$".$this->nombre_campos[$i]."=null";
                    }else{
                        $stringParamConstruct = $stringParamConstruct."\$".$this->nombre_campos[$i]."=null,";
                        $counterParam++;
                    }
      
                }
                
                //creando el if del constructor
                $stringIfConstructor = "";
                $counterIfCons = 1;
                for($i=0;$i <= count($this->nombre_campos)-1; $i++){
                    if($counterIfCons == count($this->nombre_campos)){
                        $preStringIfCons = "\$".$this->nombre_campos[$i]." !=null ";
                        $stringIfConstructor = $stringIfConstructor.$preStringIfCons;
                    }else{
                        $preStringIfCons = "\$".$this->nombre_campos[$i]." !=null && ";
                        $stringIfConstructor = $stringIfConstructor.$preStringIfCons;
                        $counterIfCons++;
                    }
                }
                
                //agregando constructor a la entidad
                $stringConstructorEntity = "\t\tpublic function __construct(".$stringParamConstruct."){\n\n"
                        . "\t\t\tif(".$stringIfConstructor."):\n";
                for($i=0; $i <= count($this->nombre_campos)-1; $i++){
                    $stringConstructorEntity = $stringConstructorEntity."\t\t\t\t\$this->".$this->nombre_campos[$i]."=\$".$this->nombre_campos[$i].";\n";
                }
                $stringConstructorEntity = $stringConstructorEntity."\t\t\t\t\$this->new".ucwords($this->nombre_tabla_actual)."();\n";
                $stringConstructorEntity = $stringConstructorEntity."\t\t\tendif;\n"
                        . "\t\t}\n\n";
                
                $stringThisEntity = $stringThisEntity.$stringConstructorEntity;
                
                
                //add function get id
                $stringThisEntity = $stringThisEntity."\t\t\tpublic function getId(){\n"
                        . "\t\t\t\treturn \$this->id;\n"
                        . "\t\t}\n\n";
                
                //agregando las funciones setter's y getter's
                for($i=0;$i <=count($this->nombre_campos)-1; $i++){
                    
                    $stringGetter = "\t\tpublic function get".ucwords($this->nombre_campos[$i])."(){\n\n"
                            . "\t\t\treturn \$this->".$this->nombre_campos[$i].";\n"
                            . "\t\t}\n\n";
                    $stringThisEntity = $stringThisEntity.$stringGetter;
                    
                    $stringSetter = "\t\tpublic function set".ucwords($this->nombre_campos[$i])."(\$data){\n\n"
                            . "\t\t\t\$info = array('".$this->nombre_campos[$i]."', \$this->id, 'id', '".$this->nombre_tabla_actual."');\n"
                            . "\t\t\tGuardian::runSetSql(\$data, \$info);\n"
                            . "\t\t\t\$this->".$this->nombre_campos[$i]." = \$data;\n"
                            . "\t\t\treturn \$this->".$this->nombre_campos[$i].";\n"
                            . "\t\t}\n\n";
                    $stringThisEntity = $stringThisEntity.$stringSetter;
                    
                }
                
                //add params for 'getAll'
                $paramsGetAll = "'id' => \$this->id, ";
                $counterParamGetAll = 1;
                for($i = 0; $i <= count($this->nombre_campos)-1; $i++){
                    if($counterParamGetAll == count($this->nombre_campos)){
                        $preStringGetAll = "'".$this->nombre_campos[$i]."' => \$this->".$this->nombre_campos[$i];
                        $paramsGetAll = $paramsGetAll.$preStringGetAll;
                        $counterParamGetAll++;
                    }else{
                        $preStringGetAll = "'".$this->nombre_campos[$i]."' => \$this->".$this->nombre_campos[$i].",";
                        $paramsGetAll = $paramsGetAll.$preStringGetAll; 
                        $counterParamGetAll++;
                    }
                    
                }
                //add function getAll
                $stringGetAll = "\t\tpublic function getAll(){\n\n"
                        . "\t\t\t\$dataAll = array(".$paramsGetAll.");\n"
                        . "\t\t\treturn \$dataAll;\n"
                        . "\t\t}\n\n";
                $stringThisEntity = $stringThisEntity.$stringGetAll;
                
                
                //add function 'recoveryAll'
                $stringRecoveryAll = "\t\tpublic function recoveryAll(\$data){\n\n"
                        . "\t\t\t\$this->id = \$data;\n"
                        . "\t\t\t\$info = array('".$this->nombre_tabla_actual."', \$this->id, 'id');\n"
                        . "\t\t\t\$responseRecovery = Guardian::runGetAll(\$info);\n\n"
                        . "\t\t\tif(\$responseRecovery != null){\n"
                        . "\t\t\t\t\$this->id = \$responseRecovery['id'];\n";
                $moreStringRecovery = "";
                for($i = 0; $i <= count($this->nombre_campos)-1; $i++){
                    $moreStringRecovery = $moreStringRecovery."\t\t\t\t\$this->".$this->nombre_campos[$i]." = \$responseRecovery['".$this->nombre_campos[$i]."'];\n";
                }
                $stringRecoveryAll = $stringRecoveryAll.$moreStringRecovery;
                $endStringRecovery = "\t\t\t}\n"
                        . "\t\t}\n\n";
                $stringRecoveryAll = $stringRecoveryAll.$endStringRecovery;
                $stringThisEntity = $stringThisEntity.$stringRecoveryAll;
                
                
                //add function deleteAll
                $stringDeleteAll = "\t\tpublic function deleteAll(){\n\n"
                        . "\t\t\t\$info = array('".$this->nombre_tabla_actual."', 'id');\n"
                        . "\t\t\tGuardian::runDelSql(\$this->id, \$info);\n"
                        . "\t\t\t\$this->id = null;\n";
                $moreStringDeleteAll = "";
                for($i = 0; $i<=count($this->nombre_campos)-1; $i++){
                    $moreStringDeleteAll = $moreStringDeleteAll."\t\t\t\$this->".$this->nombre_campos[$i]." = null;\n\n";
                }
                $stringDeleteAll = $stringDeleteAll.$moreStringDeleteAll;
                $endStringDeleteAll = "\t\t\treturn 'success delete';\n"
                        . "\t\t}\n\n";
                $stringDeleteAll = $stringDeleteAll.$endStringDeleteAll;
                $stringThisEntity = $stringThisEntity.$stringDeleteAll;
                
                
                //add function new user
                $paramsNewFields = "";
                for($i = 0; $i <= count($this->nombre_campos)-1; $i++){
                    
                    $paramsNewFields = $paramsNewFields."'".$this->nombre_campos[$i]."',";
                    
                }
                $paramsNewFields = $paramsNewFields."'".$this->nombre_tabla_actual."'";
                
                $stringNewField = "\t\tpublic function new".ucwords($this->nombre_tabla_actual)."(\$info = array(".$paramsNewFields.")){\n\n";
                
                $paramsNewInsertSql = "";
                for($i = 0; $i <= count($this->nombre_campos)-1; $i++){
                    $paramsNewInsertSql = $paramsNewInsertSql."\$this->".$this->nombre_campos[$i].", ";
                }
                $paramsNewInsertSql = $paramsNewInsertSql."\$info";
                
                //add dataResponse
                $stringDataResponse = "\t\t\t\$dataResponse = Guardian::newInsertSql(".$paramsNewInsertSql.");\n";
                $stringNewField = $stringNewField.$stringDataResponse;
                
                //add if
                $stringIfNewSql = "\t\t\tif(\$dataResponse != null || !empty(\$dataResponse)){\n\n";
                $stringNewField = $stringNewField.$stringIfNewSql;
                
                //add body if
                $stringBodyIf = "\t\t\t\t\$this->id = \$dataResponse['id'];\n";
                for($i = 0; $i <=count($this->nombre_campos)-1; $i++){
                    $stringBodyIf = $stringBodyIf."\t\t\t\t\$this->".$this->nombre_campos[$i]." = \$dataResponse['".$this->nombre_campos[$i]."'];\n";
                }
                $stringBodyIf = $stringBodyIf."\t\t\t}\n";
                $stringNewField = $stringNewField.$stringBodyIf."\t\t}\n\n";
                $stringThisEntity = $stringThisEntity.$stringNewField."\t}\n?>";
                
                
                
                //ruta y escritura
                $rutaCompletaEntidad = "../Entitys/".ucwords($this->nombre_tabla_actual.".php");
                file_put_contents($rutaCompletaEntidad, $stringThisEntity);
                
            }
            
            
        }//fin de funcion factoryEntity
        
        
        
    }#fin de clase WriteEntity
?>