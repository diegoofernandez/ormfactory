<?php

namespace CreatorUpdate\Read\Json;

class ReadJson {

    private $recipe = array();
    private $recipeClean = array();
    
    private $stringSql;
    private $tablesSql = array();
    private $resultSql;

    public function __construct($recipe) {
        $this->recipe = $recipe;

        $capa1Temporal = explode("|", $this->recipe);
        array_push($this->recipeClean, $capa1Temporal);
    }

    public function constructStringSql() {


        if ($this->recipeClean != null) {
            
            $cantidad_tablas = count($this->recipeClean[0]);
            $tabla_actual = 1;
            
            //for capa 1
            for ($i = 0; $i <= count($this->recipeClean[0])-1; $i++) {
                
                $capaTemporal = explode("$", $this->recipeClean[0][$i]);
                $nombreTabla = $capaTemporal[0];
                //$this->stringSql = $this->stringSql."CREATE TABLE " . $nombreTabla . " (";
                $this->stringSql = "CREATE TABLE " . $nombreTabla . " (";
                unset($capaTemporal[0]);
                $capas_totales = count($capaTemporal);
                $capas_actual_totales = 1;
                
                
                //capa acceso fila individual
                for ($x = 0; $x < count($capaTemporal); $x++) {

                    //$textoTemporal = implode($capaTemporal[$x]);
                    $capa_acceso_fila = explode("-", $capaTemporal[$x+1]);
                    $longitud_fila = count($capa_acceso_fila);
                    $dato_actual_array = 1;

                    //capa acceso campos de valores
                    for ($z = 0; $z < count($capa_acceso_fila); $z++) {

                        if ($capa_acceso_fila[$z] != "primary_key" && $capa_acceso_fila[$z] != "foreign_key") {

                            //validacion si es el ultimo dato de la fila
                            if ($longitud_fila != $dato_actual_array) {#si no es el último dato entramos a este if

                                switch ($capa_acceso_fila[$z]) {
                                    
                                    case 'tinyint':
                                        $longitud_personalizada = ($capa_acceso_fila[$z + 1] != "auto") ? " TINYINT (" : null;
                                        $response_string = ($longitud_personalizada != null) ? $longitud_personalizada : " TINYINT ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'smallint':
                                        $longitud_personalizada = ($capa_acceso_fila[$z + 1] != "auto") ? " SMALLINT (" : null;
                                        $response_string = ($longitud_personalizada != null) ? $longitud_personalizada : " SMALLINT ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'mediumint':
                                        $longitud_personalizada = ($capa_acceso_fila[$z + 1] != "auto") ? " MEDIUMINT (" : NULL;
                                        $response_string = ($longitud_personalizada != null) ? $longitud_personalizada : " MEDIUMINT ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'int':
                                        $longitud_personalizada = ($capa_acceso_fila[$z + 1] != "auto") ? " INT (" : NULL;
                                        $response_string = ($longitud_personalizada != null) ? $longitud_personalizada : " INT ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'integer':
                                        $longitud_personalizada = ($capa_acceso_fila[$z + 1] != "auto") ? " INTEGER (" : NULL;
                                        $response_string = ($longitud_personalizada != null) ? $longitud_personalizada : " INTEGER ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'bigint':
                                        $longitud_personalizada = ($capa_acceso_fila[$z + 1] != "auto") ? " BIGINT (" : NULL;
                                        $response_string = ($longitud_personalizada != null) ? $longitud_personalizada : " BIGINT ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'float':
                                        $longitud_personalizada = ($capa_acceso_fila[$z + 1] != "auto") ? " FLOAT (" : NULL;
                                        $response_string = ($longitud_personalizada != null) ? $longitud_personalizada : " FLOAT ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'double':
                                        $longitud_personalizada = ($capa_acceso_fila[$z + 1] != "auto") ? " DOUBLE (" : NULL;
                                        $response_string = ($longitud_personalizada != null) ? $longitud_personalizada : " DOUBLRE ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'date':
                                        $response_string = " DATE ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'datetime':
                                        $response_string = " DATETIME ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'timestamp':
                                        $response_string = " TIMESTAMP ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'time':
                                        $response_string = " TIME ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'year':
                                        $response_string = " YEAR ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'char':
                                        $longitud_personalizada = ($capa_acceso_fila[$z + 1] != "auto") ? " CHAR (" : null;
                                        $response_string = ($longitud_personalizada != null) ? $longitud_personalizada : " CHAR ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'varchar':
                                        $longitud_personalizada = ($capa_acceso_fila[$z + 1] != "auto") ? "VARCHAR (" : null;
                                        $response_string = ($longitud_personalizada != NULL) ? $longitud_personalizada : " VARCHAR ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'tinyblob':
                                        $response_string = " TINYBLOB ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'tinytext':
                                        $response_string = " TINYTEXT ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'blob':
                                        $response_string = " BLOB ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'text':
                                        $longitud_personalizada = ($capa_acceso_fila[$z + 1] != "auto") ? " TEXT (" : null;
                                        $response_string = ($longitud_personalizada != null) ? $longitud_personalizada : " TEXT ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'mediumblob':
                                        $response_string = " MEDIUMBLOB ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'mediumtext':
                                        $response_string = " MEDIUMTEXT ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'longblob':
                                        $response_string = " LONGBLOB ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case 'longtext':
                                        $response_string = " LONGTEXT ";
                                        $this->stringSql = $this->stringSql . $response_string;
                                        break;
                                    case ctype_digit($capa_acceso_fila[$z]):
                                        $response_string = $capa_acceso_fila[$z].") ";
                                        $this->stringSql = $this->stringSql.$response_string;
                                        break;
                                    case 'auto': 
                                        $a = 1;
                                        break;
                                    case 'auto_increment':
                                        $response_string = " AUTO_INCREMENT ";
                                        $this->stringSql = $this->stringSql.$response_string;
                                        break;
                                    default: 
                                        $datos_anteriores = ((isset($capa_acceso_fila[$z-1]) && $capa_acceso_fila[$z-1] == "primary_key") || (isset($capa_acceso_fila[$z-1]) && $capa_acceso_fila[$z-1] == "foreign_key") || (isset($capa_acceso_fila[$z-2]) && $capa_acceso_fila[$z-2] == "foreign_key") || (isset($capa_acceso_fila[$z-3]) && $capa_acceso_fila[$z-3] == "foreign_key") ) ? null : $capa_acceso_fila[$z];
                                        $response_string = ($datos_anteriores != null) ? " ".$capa_acceso_fila[$z]." " : 1;
                                        if($response_string != 1):
                                            $this->stringSql = $this->stringSql.$response_string;
                                        endif;
                                        break;
                                }
                                
                            } else {#si es el último dato entramos a este else
                                
                                if($capas_actual_totales == $capas_totales){
                                    
                                    switch ($capa_acceso_fila[$z]) {
                                        case 'tinyint':
                                            $response_string = " TINYINT) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'smallint':
                                            $response_string = " SMALLINT) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'mediumint':
                                            $response_string = " MEDIUMINT) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'int':
                                            $response_string = " INT) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'integer':
                                            $response_string = " INTEGER) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'bigint':
                                            $response_string = " BIGINT) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'float':
                                            $response_string = " FLOAT) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'double':
                                            $response_string = " DOUBLE) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'date':
                                            $response_string = " DATE) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'datetime':
                                            $response_string = " DATETIME) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'timestamp':
                                            $response_string = " TIMESTAMP) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'time':
                                            $response_string = " TIME) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'year':
                                            $response_string = " YEAR) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'char':
                                            $response_string = " CHAR) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'varchar':
                                            $response_string = " VARCHAR) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'tinyblob':
                                            $response_string = " TINYBLOB) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'tinytext':
                                            $response_string = " TINYTEXT) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'blob':
                                            $response_string = " BLOB) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'text':
                                            $response_string = " TEXT) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'mediumblob':
                                            $response_string = " MEDIUMBLOB) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'mediumtext':
                                            $response_string = " MEDIUMTEXT) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'longblob':
                                            $response_string = " LONGBLOB) ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'longtext':
                                            $response_string = " LONGTEXT), ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case ctype_digit($capa_acceso_fila[$z]):
                                            $response_string = $capa_acceso_fila[$z].")) ";
                                            $this->stringSql = $this->stringSql.$response_string;
                                            break;
                                        case "auto":
                                            $a = 1;
                                            break;
                                        case 'auto_increment':
                                            $response_string = " AUTO_INCREMENT) ";
                                            $this->stringSql = $this->stringSql.$response_string;
                                            break;
                                        default: 
                                            $datos_anteriores = ((isset($capa_acceso_fila[$z-1]) && $capa_acceso_fila[$z-1] == "primary_key") || (isset($capa_acceso_fila[$z-1]) && $capa_acceso_fila[$z-1] == "foreign_key") || (isset($capa_acceso_fila[$z-2]) && $capa_acceso_fila[$z-2] == "foreign_key") || (isset($capa_acceso_fila[$z-3]) && $capa_acceso_fila[$z-3] == "foreign_key") ) ? null : $capa_acceso_fila[$z];
                                            $response_string = ($datos_anteriores != null) ? " ".$capa_acceso_fila[$z].") " : 1;
                                            if($response_string != 1):
                                                $this->stringSql = $this->stringSql.$response_string.",";
                                            endif;
                                            break;
                                    }
                                    
                                }else{
                                    
                                    switch ($capa_acceso_fila[$z]) {
                                        case 'tinyint':
                                            $response_string = " TINYINT, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'smallint':
                                            $response_string = " SMALLINT, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'mediumint':
                                            $response_string = " MEDIUMINT, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'int':
                                            $response_string = " INT, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'integer':
                                            $response_string = " INTEGER, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'bigint':
                                            $response_string = " BIGINT, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'float':
                                            $response_string = " FLOAT, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'double':
                                            $response_string = " DOUBLE, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'date':
                                            $response_string = " DATE, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'datetime':
                                            $response_string = " DATETIME, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'timestamp':
                                            $response_string = " TIMESTAMP, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'time':
                                            $response_string = " TIME, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'year':
                                            $response_string = " YEAR, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'char':
                                            $response_string = " CHAR, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'varchar':
                                            $response_string = " VARCHAR, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'tinyblob':
                                            $response_string = " TINYBLOB, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'tinytext':
                                            $response_string = " TINYTEXT, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'blob':
                                            $response_string = " BLOB, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'text':
                                            $response_string = " TEXT, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'mediumblob':
                                            $response_string = " MEDIUMBLOB, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'mediumtext':
                                            $response_string = " MEDIUMTEXT, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'longblob':
                                            $response_string = " LONGBLOB, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case 'longtext':
                                            $response_string = " LONGTEXT, ";
                                            $this->stringSql = $this->stringSql . $response_string;
                                            break;
                                        case ctype_digit($capa_acceso_fila[$z]):
                                            $response_string = $capa_acceso_fila[$z]."), ";
                                            $this->stringSql = $this->stringSql.$response_string;
                                            break;
                                        case "auto":
                                            $a = 1;
                                            break;
                                        case 'auto_increment':
                                            $response_string = " AUTO_INCREMENT, ";
                                            $this->stringSql = $this->stringSql.$response_string;
                                            break;
                                        default: 
                                            $datos_anteriores = ((isset($capa_acceso_fila[$z-1]) && $capa_acceso_fila[$z-1] == "primary_key") || (isset($capa_acceso_fila[$z-1]) && $capa_acceso_fila[$z-1] == "foreign_key") || (isset($capa_acceso_fila[$z-2]) && $capa_acceso_fila[$z-2] == "foreign_key") || (isset($capa_acceso_fila[$z-3]) && $capa_acceso_fila[$z-3] == "foreign_key") ) ? null : $capa_acceso_fila[$z];
                                            $response_string = ($datos_anteriores != null) ? " ".$capa_acceso_fila[$z]." " : 1;
                                            if($response_string != 1):
                                                $this->stringSql = $this->stringSql.$response_string.",";
                                            endif;
                                            break;
                                    }
                                    
                                }
                                
                            }#fin de if/else comprobacion dato final
                            
                        } else {#comienzo de transformación de datos si es "primary_key" o "foreign_key"
                            
                            if($capas_actual_totales == $capas_totales){
                                if($capa_acceso_fila[$z] == "primary_key"){
                                    $response_string = " PRIMARY KEY (".$capa_acceso_fila[$z+1].")) ";
                                    $this->stringSql = $this->stringSql.$response_string;
                                }else{
                                    echo "Creando propiedades de tabla...<br>";
                                }

                                if($capa_acceso_fila[$z] == "foreign_key"){
                                    $response_string = " FOREIGN KEY (".$capa_acceso_fila[$z+1].") REFERENCES ".$capa_acceso_fila[$z+2]."(".$capa_acceso_fila[$z+3]."))";
                                    $this->stringSql = $this->stringSql.$response_string;
                                }else{
                                    echo "Creando propiedades de tabla...<br>";
                                }
                            }else{
                                if($capa_acceso_fila[$z] == "primary_key"){
                                $response_string = " PRIMARY KEY (".$capa_acceso_fila[$z+1]."), ";
                                $this->stringSql = $this->stringSql.$response_string;
                                }else{
                                    echo "Creando propiedades de tabla...<br>";
                                }

                                if($capa_acceso_fila[$z] == "foreign_key"){
                                    $response_string = " FOREIGN KEY (".$capa_acceso_fila[$z+1].") REFERENCES ".$capa_acceso_fila[$z+2]."(".$capa_acceso_fila[$z+3]."))";
                                    $this->stringSql = $this->stringSql.$response_string;
                                }else{
                                    echo "Creando propiedades de tabla...<br>";
                                }
                            }
                            
                        }#fin de if/else comprobacion de campo

                        $dato_actual_array++;
                    }#fin de for 2
                    $capas_actual_totales++;
                }#fin de for 3
                
                /*if($tabla_actual == $cantidad_tablas){
                    $this->stringSql = $this->stringSql.")";
                }*/
                array_push($this->tablesSql, $this->stringSql);
                $tabla_actual++;
            }#fin de for capa 1
        } else {
            //codigo si no existe nombre en recipe	
            $this->resultSql = false;
        }#fin de if/else comprobacion nombre en recipe
        
        $this->resultSql = "true";
        
    }#fin de funcion que construye string

#fin de funcion que crea la consulta

    public function retornoConsulta() {
        return $this->tablesSql;
    }

    public function estadoConsulta() {
        return $this->resultSql;
    }

}

#fin de clase
?> 