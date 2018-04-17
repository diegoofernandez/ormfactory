# ormfactory
Creador de ORM para PHP. Independiente y sin necesidad de instalación

# Bienvenido. Objetivo y descripción
**OrmFactory** se encarga de crear la base de datos, tablas de la misma y todo el código php que mapea las tablas brindando un modelo orientado a objetos; agregando de esta manera una capa de abstracción para conectarte a la base de datos y ahorrándote cientos de líneas de código. <br>
Veamos de manera ilustrativa lo que hace ormfactory:
![Proceso de trabajo ormfactory](https://serdig.com/imagenes_ormfactory/imagen-orm-2.png)
Todo esto lo logra leyendo el archivo 'config_db.json'. Para tener una idea más 'gráfica' de lo que logra veamos el valor 'tables' del config_db.json:
![Demo tabla creación](https://serdig.com/imagenes_ormfactory/imagen-orm-1.png)

# El archivo config_db.json
![Archivo config_db.json](https://serdig.com/imagenes_ormfactory/imagen-orm-3.png)

Tú lo único que tienes que configurar es el archivo json de configuración, el mismo contendrá los datos de acceso al servidor, el nombre de la base de datos a crear y el string especial que ormfactory leerá para crear la base de datos, las tablas y las clases ORM php. <br>
Para entender como crear el string ve a la pestaña 'Creación de string sql'. 

# Directorio que genera el ormfactory
Este directorio se generará luego de ejecutado el ormfactory, y siempre se llamara 'Entitys'. Este directorio podremos moverlo/copiarlo directamente a nuestro proyecto sin ningún tipo de problema.
Supongamos que creamos una base de datos en las cual hay 2 tablas llamadas 'utiles' y 'ventas':
![Directorio creado](https://serdig.com/imagenes_ormfactory/imagen-orm-4.png)

# Ejecución de ormfactory
Primero hay que descargar la carpeta 'ormfactory' y guardarla en nuestro localhost o server.
Correr el script que nos generará todo lo nombrado anteriormente es tan simple como ir a nuestro navegador y escribir lo siguiente: 

localhost/ormfactory/creator-update/InitORM.php

Por supuesto deberá cambiar si es necesario la dirección 'localhost' por la que se encuentre en su maquina o server. 
