<?php 
	namespace CreatorUpdate\Init;
	require_once 'requeriments.php';
	use CreatorUpdate\Run as Creator;

	$database_config = file_get_contents("../config_db.json");
	$data_param      = json_decode($database_config);
	$objCreator      = Creator\CreatorUpdate::prender($data_param->host, $data_param->user, $data_param->password);

	$creando_db = $objCreator::accion($data_param->name, 'create');
	
    //validacion creacion db y resultados creacion de tablas
	if($objCreator::resultCreateDb()){
		$creando_tables = $objCreator::creandoTablas($data_param->tables);
	}else{
            echo "<br>¡Primero es obligatorio crear la base de datos antes de poder crear las tablas!<br>";
	}
        
    //validacion de tablas creadas y creacion de driver de conexion final para usuario
    if($objCreator::$result_create_all_tables){
        
        $objCreator::createDriverEntitys();
        
    }else{
        echo "<br>No existen tablas, es necesirio un resultado exitoso al crearlas para poder crear entidades.<br>";
    }
        
    //validacion de creacion de driver y creacion de las entidades, consultas y demas archivos
    if($objCreator::$result_create_driver){
        
        $objCreator::createEntitysAndMore();
        
    }else{
        echo "<br>Fallo la creación de el driver de conexión PDO.<br>";
    }

	//file_put_contents($file, $json_string); -> para escribir.
?>