
############################## Proyecto de Administración SIENNA ##############################

Este documento proporciona instrucciones detalladas sobre la configuración de la base de datos, los datos de acceso al portal, las características del servidor y los archivos del proyecto que deben ser modificados para su instalación y correcto funcionamiento.


############################## Configuración de la Base de Datos ##############################

Asegúrate de configurar los siguientes detalles en tu archivo de conexión a la base de datos:

```php
DBhost = 'localhost';
DBname = 'adm_sienna';
DBuser = 'adm_sienna';
DBpass = '!1GfTlyk94f7eOdel';

###############################################################################################

Datos de Acceso al Portal
Utiliza las siguientes credenciales para acceder al portal:

Usuario: administracion@sienna.mx
Contraseña: SecretPass01@

###############################################################################################

Características del Servidor
El proyecto fue desarrollado en el siguiente entorno de servidor:

Tipo de servidor: MariaDB
Versión del servidor: 5.5.68-MariaDB - MariaDB Server
Usuario: adm_sienna@localhost
Acerca de esta versión: 5.2.1
Versión de PHP: 7.4.33

###############################################################################################

Dentro del proyecto hay que considerar modificar 6 archivos los cuales se mencionan a continuación:

----------------------------------------------------------------------------------------------

1. app/FileController.php
Modifica las líneas 23 y 24 para definir la ubicación donde se almacenarán las imagenes del sistema (donde "sysop26.com" es nuestro dominio principal "desarrollo.sysop26.com" es un subdominio del dominio principal y "sienna/uploads" es la carpeta del proyecto y en donde se almacenaran los documentos dentro del server):

NOTA: ESTO SOLO SE HACE CUANDO SE VAN A USAR LAS URL's PUBLICAS DEL SERVIDOR, EN CASO CONTRARIO SI SE DESEAN USAR RUTAS RELATIVAS SE DEBERA DEJAR LA SIGUIENTE CONFIGURACIÓN:

--- CONFIGURACIÓN POR DEFECTO // LINEAS 19 Y 20

$server = realpath(__DIR__ . '/../uploads'); // Ruta relativa para almacenamiento en el servidor
$url = "/uploads"; // Esto es la URL relativa que usarás para acceder a los archivos desde la web

--- CONFIGURACIÓN PUBLICA Y (OPCIONAL PARA DESPLIEGUE EN SIENNA)

DESCOMENTAR LINEA 27 Y 28 y comentar las lineas 19 y 20 las cuales son la configuración por defecto

$server = "/var/www/vhosts/sienna.net/pld.sienna.net/uploads";
$url = "https://pld.sienna.net/uploads";

----------------------------------------------------------------------------------------------

2. resources/js/notifications.js
Modifica las siguientes líneas para asegurarte de que las URLs sean correctas para tu servidor:

// Línea 9
url: "/sienna/app/webservice.php",
// sustituir por // Linea 12 (descomentar)
url: "/app/webservice.php",

// Línea 39
url: "/sienna/app/webservice.php",
// sustituir por // Linea 42 (descomentar)
url: "/app/webservice.php",

// Línea 79
var documentUrl = "/sienna/backoffice/folders/extensions/open_pdf.php?folder=" + encodeURIComponent(item.key_folder) + "&file=" + encodeURIComponent(item.file_name_document);
//sustituir por // Linea 91 (descomentar)
var documentUrl = "/backoffice/folders/extensions/open_pdf.php?folder=" + encodeURIComponent(item.key_folder) + "&file=" + encodeURIComponent(item.file_name_document);

// Líneas 85
var folderUrl = "/sienna/backoffice/folders/subfolder.php?id=" + encodeURIComponent(item.id_folder) + "&key=" + encodeURIComponent(item.key_folder);
// sustituir por // Linea 97 (descomentar)
var folderUrl = "/backoffice/folders/subfolder.php?id=" + encodeURIComponent(item.id_folder) + "&key=" + encodeURIComponent(item.key_folder);

// Líneas 141
url: "/sienna/app/webservice.php",
// sustituir por // Linea 144 (descomentar)
url: "/app/webservice.php",

// Líneas 181
url: "/sienna/app/webservice.php",
// sustituir por // línea 184 (descomentar)
url: "/app/webservice.php",

Estas líneas indican:

La URL completa para acceder al archivo de notificaciones y poder importarlo en los demás archivos PHP.
Las variables documentUrl y folderUrl indican la URL para dirigirse a la carpeta y al documento desde la ventana de notificaciones.

----------------------------------------------------------------------------------------------

3. resources/js/notify_folders.js
Modifica las siguientes líneas para asegurarte de que las URLs sean correctas para tu servidor:

// Línea 9
url: "/sienna/app/webservice.php",
// sustituir por // Linea 12 (descomentar)
url: "/app/webservice.php",

// Línea 39
url: "/sienna/app/webservice.php",
// sustituir por // Linea 42 (descomentar)
url: "/app/webservice.php",

// Línea 80
var folderUrl = "/sienna/backoffice/folders/subfolder.php?id=" + encodeURIComponent(item.id_folder) + "&key=" + encodeURIComponent(item.key_folder);
// sustituir por // línea 87 (descomentar)
var folderUrl = "/backoffice/folders/subfolder.php?id=" + encodeURIComponent(item.id_folder) + "&key=" + encodeURIComponent(item.key_folder);

// Línea 82
var userUrl = "/sienna/backoffice/users/detail-user.php?id=" + encodeURIComponent(item.id_user_customer) + "&key=" + encodeURIComponent(item.key_user_customer);
// sustituir por // línea 89 (descomentar)
var userUrl = "/backoffice/users/detail-user.php?id=" + encodeURIComponent(item.id_user_customer) + "&key=" + encodeURIComponent(item.key_user_customer);

// Línea 147
url: "/sienna/app/webservice.php",
// sustituir por // Linea 150 (descomentar)
url: "/app/webservice.php",

// Línea 199
url: "/sienna/app/webservice.php",
//sustituir por // Linea 202 (descomentar)
url: "/app/webservice.php",

----------------------------------------------------------------------------------------------

4. resources/js/tracings.js
Modifica las siguientes líneas para asegurarte de que las URLs sean correctas para tu servidor:

// Línea 9
url: "/sienna/app/webservice.php",
//sustituir por // Linea 12 (descomentar)
url: "/app/webservice.php",

// Línea 39
url: "/sienna/app/webservice.php",
//sustituir por // Linea 42 (descomentar)
url: "/app/webservice.php",

// Línea 77
var folderUrl = "/sienna/backoffice/folders/subfolder.php?id=" + encodeURIComponent(item.id_folder) + "&key=" + encodeURIComponent(item.key_folder);
//sustituir por // Linea 88 (descomentar)
var folderUrl = "/backoffice/folders/subfolder.php?id=" + encodeURIComponent(item.id_folder) + "&key=" + encodeURIComponent(item.key_folder);

// Línea 129
url: "/sienna/app/webservice.php",
//sustituir por // Linea 132 (descomentar)
url: "/app/webservice.php",

// Línea 169
url: "/sienna/app/webservice.php",
//sustituir por // Linea 172 (descomentar)
url: "/app/webservice.php",

----------------------------------------------------------------------------------------------

5. .htaccess
Modifica la siguiente linea para configurar la protección de acceso a los documentos por URL

// LINEA 6
RewriteCond %{REQUEST_URI} ^/sienna/uploads/documents/ [NC]
// sustituir por // linea 7 (descomentar)
RewriteCond %{REQUEST_URI} ^/uploads/documents/ [NC]

// LINEA 9
RewriteCond %{REQUEST_URI} ^/sienna/uploads/material/ [NC]
// sustituir por // linea 10 (descomentar)
RewriteCond %{REQUEST_URI} ^/uploads/material/ [NC]

----------------------------------------------------------------------------------------------

6. app/emailsTemplates/sendNoticeCustomers.php
Estas lineas representan el enlace directo al sistema mediante el envio de notificaciones por correo electrónico

// Líneas 426 a 428
<a href="https://desarrollo.sysop26.com/sienna/backoffice/folders/subfolder.php?id=<?php echo $templateData['id_folder']; ?>&key=<?php echo $templateData['key_folder']; ?>" style="background-color: #FF5800; color: #ffffff; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-size: 16px;">
// Sustituir por // 430 a 432 (descomentar)
<a href="https://pld.sienna.net/backoffice/folders/subfolder.php?id=<?php echo $templateData['id_folder']; ?>&key=<?php echo $templateData['key_folder']; ?>" style="background-color: #FF5800; color: #ffffff; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-size: 16px;">


###############################################################################################

Modificación de Credenciales de la Base de Datos
Si necesitas modificar las credenciales de la base de datos, edita el archivo 

app/Connector.php 

y actualiza los detalles de conexión correspondientes al host, nombre de la base de datos, usuario y contraseña.

$this->DBhost = 'localhost';
$this->DBname = 'adm_sienna';
$this->DBuser = 'adm_sienna';
$this->DBpass = '!1GfTlyk94f7eOdel';

###############################################################################################

Modificación de credenciales en la configuración SMTP para el envio de correos electrónicos
Si necesitas modificar las credenciales o los correos electrónicos no se estan enviando edita el archivo:

app/MailController.php

y actualiza la información correspondiente al servidor de correos electrónicos.

De la linea 30 a la 58

// CONFIGURACIÓN SIENNA //
const SMTP_FROMNAME = 'SIENNA MX';
const SMTP_USERNAME = 'AKIA26BTXSH4GSM2CT67';
const IS_SMTP = true;
const SMTP_HOST = 'email-smtp.us-east-2.amazonaws.com';
const SMTP_PORT = '465';
const SMTP_PASSWORD = 'BBH/Obgv98EBLLfZkayDvVgSr0KDM5q5wCgX8ElCi+qK';

// MODIFICA LA LÍNEA 42 para cambiar el nombre del remitente

$this->mail->From = 'notificaciones@atencionsienna.mx';

###############################################################################################

Modificación en los datos de memoria limite de carga de archivos

Es necesario modificar algunos atributos en el servidor para que la plataforma pueda realizar la carga de documentos y archivos necesarios, a continuación se muestran algunos datos de referencia:

Configuración de seguridad y rendimiento

memory_limit            1024M
max_execution_time      600
max_input_time          600
post_max_size           510M
upload_max_filesize     500M

###############################################################################################

Modificación en la unidad donde se estaran almacenando los documentos tanto el material de apoyo como los documentos de los clientes
----

Es necesario modificar algunos archivos para llevar a cabo el almacenamiento de los documentos en otra unidad
Los archivos a modificar son los siguientes:

----------------------------------------------------------------------------------------------

1. backoffice/folders/subfolder.php || y extensiones

//LINEA 145
EL CÓDIGO QUE SE MUESTRA ES LA CONFIGURACIÓN POR DEFECTO PARA GUARDAR LOS DOCUMENTOS EN EL SERVER Y LA CARPETA DEL PROYECTO
$carpeta = '../../uploads/documents/'.$folder['key_folder'];

SI SE DESEA CAMBIAR PARA GUARDAR LOS DOCUMENTOS EN UNA UNIDAD EXTERNA DEBERA COMENTARSE LA LINEA 145 Y DESCOMENTAR LA LINEA 148
// POR DEFECTO EL ALMACENAMIENTO SE ESTA REALIZANDO INTERNAMENTE EN EL PROYECTO NO EN UNA UNIDAD EXTERNA

// Sustituir la letra E cualquier otra por la nueva
$carpeta = 'E:/uploads/documents/'.$folder['key_folder'];

// IMPORTANTE #################################################################################

// Sustituir la letra "E" cualquier otra por la nueva en los siguientes archivos:

// EN TODOS LOS ARCHIVOS POR DEFECTO ESTA EL ALMACENAMIENTO AL PROYECTO SI SE DESEA CAMBIAR A UNA UNIDAD EXTERNA SE DEBERA HACER LO SIGUIENTE:

backoffice/folders/extensions/
- download_pdf.php
COMENTAR LA LINEA 15 Y DESCOMENTAR LA LINEA 12 // Sustituir la letra E

- open_pdf.php
COMENTAR LA LINEA 17 Y DESCOMENTAR LA LINEA 14 // Sustituir la letra E

- view_pdf.php
COMENTAR LA LINEA 17 Y DESCOMENTAR LA LINEA 14 // Sustituir la letra E

----------------------------------------------------------------------------------------------

2. backoffice/support/resources.php || y extensiones

// LINEA 58
EL CÓDIGO QUE SE MUESTRA ES LA CONFIGURACIÓN POR DEFECTO PARA GUARDAR LOS DOCUMENTOS EN EL SERVER Y LA CARPETA DEL PROYECTO
$carpeta = '../../uploads/material/'.$_POST['saveDocuments']['keySection'];

SI SE DESEA CAMBIAR PARA GUARDAR LOS DOCUMENTOS EN UNA UNIDAD EXTERNA DEBERA COMENTARSE LA LINEA 58 Y DESCOMENTAR LA LINEA 61
// POR DEFECTO EL ALMACENAMIENTO SE ESTA REALIZANDO INTERNAMENTE EN EL PROYECTO NO EN UNA UNIDAD EXTERNA

// Sustituir la letra E cualquier otra por la nueva
$carpeta = 'E:/uploads/material/'.$_POST['saveDocuments']['keySection'];

// IMPORTANTE #################################################################################

//Sustituir la letra E cualquier otra por la nueva en los siguientes archivos

// EN TODOS LOS ARCHIVOS POR DEFECTO ESTA EL ALMACENAMIENTO AL PROYECTO SI SE DESEA CAMBIAR A UNA UNIDAD EXTERNA SE DEBERA HACER LO SIGUIENTE:

backoffice/support/extensions/
- download_archive.php
COMENTAR LA LINEA 15 Y DESCOMENTAR LA LINEA 12 // Sustituir la letra E

- open_file.php
COMENTAR LA LINEA 17 Y DESCOMENTAR LA LINEA 14 // Sustituir la letra E

###############################################################################################

¡IMPORTANTE!

Dentro del proyecto se encuentra un archivo que debe ejecutarse mediante CRON JOBS o tareas programadas a nivel servidor. El archivo en cuestión es el siguiente:

- app/sendNotify.php

Es necesario configurar en el servidor una instrucción que permita ejecutar este script de manera periódica con las siguientes características:

Frecuencia: Diario y semanalmente.
Horario: Especificar el horario en que debe ejecutarse.

Este archivo tiene como función principal:

Enviar notificaciones a los usuarios sobre el vencimiento de sus clientes.
Actualizar el estatus de los clientes como "vencido" o "cerca de vencimiento".