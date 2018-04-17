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

Template entidad generada:
https://gist.github.com/diegoofernandez/f95cd6095d537dcfab90811b8a06a464

Load de clases generado: 
https://gist.github.com/diegoofernandez/b9d81a717f1ef1b8106cf120e42685f6


# Crear el string para generar tablas
Veamos primero como se compone un string sql para que ormfactory lo sepa leer:<br>

`utiles$id-int-auto-auto_increment$tipo-varchar-220$precio-int-25$fecha_creacion-varchar-50$primary_key-id`

Rápidamente notamos los varios usos del signo dolar ($). Este símbolo lo que hace en el string es indicar que termina una acción. 
## Escribir nombre de tabla:
Lo primero que encontramos antes de escribir el signo dolar ($) es el nombre de la tabla:

`utiles$`

Lo primero que tenemos que escribir es el nombre de la tabla y agregarle el signo dolar($), ya que el ormfactory detectara que esa parte del string contiene 1 solo elemento y por lo tanto interpretará que es el nombre de la tabla. 

## Escribir un campo en la tabla:

`id-int-auto-auto_increment$`

El carácter que lee ormfactory para 'partir' el string y crear el campo con las propiedades indicadas es el signo medio '-'. 
Sabiendo esto, podemos interpretar el string escrito arriba como lo siguiente:
1. Tenemos que crear un campo que se llame 'id'.
2. El campo va a ser de tipo entero (int).
3. La longitud del campo va a ser automática. 
4. El campo va a ser auto_inrement.
5. Terminamos la acción con el signo dolar($).

Y así sucesivamente con todos los campos que queramos crear en la tabla. AHORA hay unas reglas claves para que ormfactory entienda el string y son las siguientes: 

1. NO puede haber espacios en blanco.
2. Cada campo recibe como mínimo tres valores: nombre, tipo, longitud. Ej: apellidos-varchar-220
3. Cada vez que queramos terminar un campo debemos agregar el signo dolar($) y a continuación seguir escribiendo el siguiente campo

## Constantes: auto_increment, primary_key y foreign_key:
Si queremos indicar que un campo es auto incrementa-ble, lo tenemos que indicar como **cuarto y último** parámetro en la posición del campo:

`id-int-auto-auto_increment$`

Indicar que un campo va a ser la clave primaria (primary_key) de la tabla: 

`primary_key-id`

Al final de la tabla (más abajo se explica como cerrar y comenzar una nueva tabla) tenemos que indicar la **constante** primary_key y luego el nombre del campo que será la clave primaria: 

Crear claves foráneas para nuestras tablas mediante el string sql:

`foreign_key-articulo_vendido-utiles-id` 

En la última acción de la tabla indicamos al **constante** foreign_key, luego indicamos el nombre del campo que almacenará los valores foráneos; como tercer parámetro de la acción hacemos referencia a el nombre de la tabla desde donde traeremos los datos y por último el campo de esa tabla desde donde tomaremos los valores. 

## Escribir varias tablas en el string:
El carácter para cerrar una tabla y comenzar otra es la barra vertical ( | ), ejemplo: 

`nameTable$campo-tipo-255$campo-tipo-255|nameTable2$campo2-tipo2-255`

Hay que tener cuidado con este carácter, solo debemos indicarlo si vamos a seguir escribiendo más tablas, si no, no es necesario. En el ejemplo vemos que al terminar la segunda tabla no indicamos la barra vertical. 
