<?php

namespace CreatorUpdate\Read\Json;

class ReadJson {

    private $recipe = array();
    private $recipeClean = array();
    
    private $stringSql;
    private $tablesSql = array();
    private $resultSql;

    public function __construct($recipe) {
        
        for($i = 0; $i < count($recipe); $i++){
            array_push($this->recipe, $recipe[$i]); 
        }

    }

    public function constructStringSql() {

        /**
         * Counter to know number of tables and iterate the same
         */
        for($i = 0; $i < count($this->recipe); $i++){
            
            //Catch table name
            $nameThisTable = $this->recipe[$i]->name_table; 
            $this->stringSql = "CREATE TABLE ". $nameThisTable ." (";

            /**
             * Counter to know number of fields and iterate the same
             */
            for($x = 0; $x < count($this->recipe[$i]->fields); $x++){

                //explode string field to prepare sql
                $thisField = explode("|", $this->recipe[$i]->fields[$x]); 
                if($thisField[0] != "primary_key" && $thisField[0] != "foreign_key"){
                    $field_name = array_shift($thisField);
                    $this->stringSql = $this->stringSql.$field_name." ";
                }


                /**
                 * Counter to know number of propertys the field single and iterate the same
                 */
                for($z = 0; $z < count($thisField); $z++){

                    //verify if the is special property
                    if ($thisField[$z] != "primary_key" && $thisField[$z] != "foreign_key") {

                        //verify if the property is the last
                        if(end($thisField) != $thisField[$z]){
                            switch($thisField[$z]){
                                    
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
                        }else{//else if the last property
                            if(end($thisField) == $thisField[$z] && end($this->recipe[$i]->fields) == $this->recipe[$i]->fields[$x]){
                                switch ($thisField[$z]) {
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
                        }

                    }else{//if the special property

                        if(end($thisField) == $thisField[$z] && end($this->recipe[$i]->fields) == $this->recipe[$i]->fields[$x]){
                            if($thisField[$z] == "primary_key"){
                                $response_string = " PRIMARY KEY (".$thisField[$z+1].")) ";
                                $this->stringSql = $this->stringSql.$response_string;
                            }else{
                                echo "Creando propiedades de tabla...<br>";
                            }

                            if($thisField[$z] == "foreign_key"){
                                $response_string = " FOREIGN KEY (".$thisField[$z+1].") REFERENCES ".$thisField[$z+2]."(".$thisField[$z+3]."))";
                                $this->stringSql = $this->stringSql.$response_string;
                            }else{
                                echo "Creando propiedades de tabla...<br>";
                            }
                        }else{
                            if($thisField[$z] == "primary_key"){
                                $response_string = " PRIMARY KEY (".$thisField[$z+1]."), ";
                                $this->stringSql = $this->stringSql.$response_string;
                            }else{
                                    echo "Creando propiedades de tabla...<br>";
                            }

                            if($thisField[$z] == "foreign_key"){
                                    $response_string = " FOREIGN KEY (".$thisField[$z+1].") REFERENCES ".$thisField[$z+2]."(".$thisField[$z+3]."))";
                                    $this->stringSql = $this->stringSql.$response_string;
                            }else{
                                    echo "Creando propiedades de tabla...<br>";
                            }
                        }

                    }// 

                }// End propertys field single

            }// End Counter fields
            
            //add coding sql for create table
            array_push($this->tablesSql, $this->stringSql);

        }// End Counter Tables

        //verifying if all the tables were traversed
        if(count($this->tablesSql) == count($this->recipe)){
            $this->resultSql = true;
        }

        //testing
        var_dump($this->stringSql);
        
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