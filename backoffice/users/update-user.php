<?php
  session_start();  
  include "../../app/config.php";
  //include "../../app/debug.php";
  include "../../app/FileController.php";
  include "../../app/WebController.php";
  $controller = new WebController();
  $files = new FileController();
  
  // Verificar si la sesión del usuario está activa
  if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    // Si no hay sesión activa, destruir la sesión
    session_destroy();
    // Redirigir a la página de inicio de sesión
    header("Location: ../../login.php");
    exit(); // Es importante salir después de redirigir para evitar que el código siguiente se ejecute innecesariamente
  }
  
  // COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMIN (1)
  if($_SESSION['user']['id_type_user'] != 1) { // Comprueba si el tipo de usuario almacenado en la sesión no es igual a 1 (tipo de usuario "admin")
    header('location: users.php'); // Redirecciona a la página "users.php" si el usuario no es de tipo administrador
  }
  
  //FUNCIÓN PARA MOSTRAR LOS DETALLES DE UN USUARIO
  // Obtener los detalles de un usuario específico utilizando el controlador.
  // Se pasa el ID del usuario ($_GET['id']) y una clave adicional ($_GET['key'])
  // para autenticación o validación, y se guarda el resultado en la variable $user.
  $user = $controller->getDetailUser($_GET['id'], $_GET['key']);
  
  //Si no se encuentra EL ID DEL USUARIO LO REGRESAMOS A LA CONSULTA PRINCIPAL
  // Verifica si la variable $user está vacía
  if(empty($user)){
    // Si la variable $user está vacía, redirige al usuario a la página 'users.php'
    header("location: users.php");
  }
  //FUNCIÓN PARA MOSTRAR EL TIPO DE USUARIOS
  $userTypes = $controller->getUserTypes();
  
  function uploadFilePhoto($folio, $filename = null) {
    global $files;
    $filename['imguser'] = $files->upload($folio, $_FILES['file-imguser'],  "ord.imguser");
    return $filename;
  }
  
  $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $usr_rfc = substr(str_shuffle($permitted_chars), 0, 13);
  
  if(!empty($_POST['action'])){
    if($_POST['action'] == 'update'){
      //COMPROBAMOS SI EL EMAIL, EL TELEFONO Y EL RFC SON EXACTAMENTE IGUALES Y SE QUEDAN IGUAL
      if($_POST['user']['email_user'] == $user['email_user'] AND $_POST['user']['phone_user'] == $user['phone_user'] AND $_POST['user']['rfc_user'] == $user['rfc_user']) {
        $idUser = $controller->updateUser($_POST['user'], $_GET['id']);
        if($idUser){
          $files = uploadFilePhoto($user['key_user']);
          //COMPROBAMOS SI SE SUBIO UNA FOTOGRAFÍA DEL EMPLEADO / USUARIO
          if($files['imguser']){
            $files = [
              'imguser' => $files['imguser']
            ];
            $userId = $controller->updatePhotoUser($user['id_user'], $files);
          }
          //COMRPOBAMOS SI NO SE SELECCIONO NINGUNA FOTOGRAFÍA DEL EMPLEADO / USUARIO Y SE QUEDA EXACTAMENTE IGUAL
          else{
            $files = [
              'imguser' => $user['photo_user']
            ];
            $userId = $controller->updatePhotoUser($user['id_user'], $files);
          }
          header('location: users.php');
        }
      }
      
      //COMPROBAMOS SI EL CORREO ES DIFERENTE PERO EL TELÉFONO Y EL RFC SON LOS MISMOS
      else if ($_POST['user']['email_user'] != $user['email_user'] AND $_POST['user']['phone_user'] == $user['phone_user'] AND $_POST['user']['rfc_user'] == $user['rfc_user']) {
        $emailClient = $controller->getEmailUser($_POST['user']['email_user']);
        //COMPROBAMOS SI EL CORREO ELECTRÓNICO DEL CLIENTE EXISTE
        if(!empty($emailClient)){
          $mssg = "¡EL CORREO ELECTRÓNICO YA ESTÁ EN USO POR UN USUARIO ACTIVO. INTENTA CON OTRO!";
        }
        else {
          $idUser = $controller->updateUser($_POST['user'], $_GET['id']);
          if($idUser){
            $files = uploadFilePhoto($user['key_user']);
            //COMPROBAMOS SI SE SUBIO UNA FOTOGRAFÍA DEL EMPLEADO / USUARIO
            if($files['imguser']){
              $files = [
                'imguser' => $files['imguser']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            //COMRPOBAMOS SI NO SE SELECCIONO NINGUNA FOTOGRAFÍA DEL EMPLEADO / USUARIO Y SE QUEDA EXACTAMENTE IGUAL
            else{
              $files = [
                'imguser' => $user['photo_user']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            header('location: users.php');
          }
        }
      }
      
      //COMPROBAMOS SI EL CORREO Y EL TELÉFONO SON DIFERENTES Y EL RFC ES EL MISMO
      else if ($_POST['user']['email_user'] != $user['email_user'] AND $_POST['user']['phone_user'] != $user['phone_user'] AND $_POST['user']['rfc_user'] == $user['rfc_user']) {
        $emailClient = $controller->getEmailUser($_POST['user']['email_user']);
        $phoneClient = $controller->getPhoneUser($_POST['user']['phone_user']);
        //COMPROBAMOS SI EL CORREO ELECTRÓNICO DEL CLIENTE EXISTE
        if(!empty($emailClient)){
          $mssg = "¡EL CORREO ELECTRÓNICO YA ESTÁ EN USO POR UN USUARIO ACTIVO. INTENTA CON OTRO!";
        }
        //COMPROBAMOS SI EL NÚMERO DE TELÉFONO DEL CLIENTE EXISTE
        else if (!empty($phoneClient)){
          $mssg = "¡EL NÚMERO DE TELÉFONO ESTÁ EN USO POR UN USUARIO ACTIVO, INTENTA CON OTRO!";
        }
        else {
          $idUser = $controller->updateUser($_POST['user'], $_GET['id']);
          if($idUser){
            $files = uploadFilePhoto($user['key_user']);
            //COMPROBAMOS SI SE SUBIO UNA FOTOGRAFÍA DEL EMPLEADO / USUARIO
            if($files['imguser']){
              $files = [
                'imguser' => $files['imguser']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            //COMRPOBAMOS SI NO SE SELECCIONO NINGUNA FOTOGRAFÍA DEL EMPLEADO / USUARIO Y SE QUEDA EXACTAMENTE IGUAL
            else{
              $files = [
                'imguser' => $user['photo_user']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            header('location: users.php');
          }
        }
      }
      
      //COMPROBAMOS SI EL CORREO Y EL RFC SON DIFERENTES PERO EL NÚMERO DE TELÉFONO ES EL MISMO
      else if ($_POST['user']['email_user'] != $user['email_user'] AND $_POST['user']['phone_user'] == $user['phone_user'] AND $_POST['user']['rfc_user'] != $user['rfc_user']) {
        $emailClient = $controller->getEmailUser($_POST['user']['email_user']);
        $rfcClient = $controller->getRFCUser($_POST['user']['rfc_user']);
        //COMPROBAMOS SI EL CORREO ELECTRÓNICO DEL CLIENTE EXISTE
        if(!empty($emailClient)){
          $mssg = "¡EL CORREO ELECTRÓNICO YA ESTÁ EN USO POR UN USUARIO ACTIVO. INTENTA CON OTRO!";
        }
        //COMPROBAMOS SI EL RFC DEL CLIENTE EXISTE
        else if (!empty($rfcClient)){
          $mssg = "¡EL RFC YA SE ENCUENTRA REGISTRADO, INTENTA CON OTRO!";
        }
        else {
          $idUser = $controller->updateUser($_POST['user'], $_GET['id']);
          if($idUser){
            $files = uploadFilePhoto($user['key_user']);
            //COMPROBAMOS SI SE SUBIO UNA FOTOGRAFÍA DEL EMPLEADO / USUARIO
            if($files['imguser']){
              $files = [
                'imguser' => $files['imguser']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            //COMRPOBAMOS SI NO SE SELECCIONO NINGUNA FOTOGRAFÍA DEL EMPLEADO / USUARIO Y SE QUEDA EXACTAMENTE IGUAL
            else{
              $files = [
                'imguser' => $user['photo_user']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            header('location: users.php');
          }
        }
      }
      
      //COMPROBAMOS SI EL TELEFONO ES DIFERENTE PERO EL CORREO Y EL RFC SON LOS MISMOS
      else if ($_POST['user']['phone_user'] != $user['phone_user'] AND $_POST['user']['email_user'] == $user['email_user'] AND $_POST['user']['rfc_user'] == $user['rfc_user']) {
        $phoneClient = $controller->getPhoneUser($_POST['user']['phone_user']);
        //COMPROBAMOS SI EL NÚMERO DE TELÉFONO DEL CLIENTE EXISTE
        if(!empty($phoneClient)){
          $mssg = "¡EL NÚMERO DE TELÉFONO ESTÁ EN USO POR UN USUARIO ACTIVO, INTENTA CON OTRO!";
        }
        else {
          $idUser = $controller->updateUser($_POST['user'], $_GET['id']);
          if($idUser){
            $files = uploadFilePhoto($user['key_user']);
            //COMPROBAMOS SI SE SUBIO UNA FOTOGRAFÍA DEL EMPLEADO / USUARIO
            if($files['imguser']){
              $files = [
                'imguser' => $files['imguser']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            //COMRPOBAMOS SI NO SE SELECCIONO NINGUNA FOTOGRAFÍA DEL EMPLEADO / USUARIO Y SE QUEDA EXACTAMENTE IGUAL
            else{
              $files = [
                'imguser' => $user['photo_user']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            header('location: users.php');
          }
        }
      }
      
      //COMPROBAMOS SI EL NÚMERO DE TELÉFONO Y EL RFC SON DIFERENTES PERO EL CORREO ES EL MISMO
      else if ($_POST['user']['phone_user'] != $user['phone_user'] AND $_POST['user']['rfc_user'] != $user['rfc_user'] AND $_POST['user']['email_user'] == $user['email_user']) {
        $phoneClient = $controller->getPhoneUser($_POST['user']['phone_user']);
        $rfcClient = $controller->getRFCUser($_POST['user']['rfc_user']);
        //COMPROBAMOS SI EL NÚMERO DE TELÉFONO DEL CLIENTE EXISTE
        if(!empty($phoneClient)){
          $mssg = "¡EL NÚMERO DE TELÉFONO ESTÁ EN USO POR UN USUARIO ACTIVO, INTENTA CON OTRO!";
        }
        //COMPROBAMOS SI EL RFC DEL CLIENTE EXISTE
        else if (!empty($rfcClient)){
          $mssg = "¡EL RFC YA SE ENCUENTRA REGISTRADO, INTENTA CON OTRO!";
        }
        else {
          $idUser = $controller->updateUser($_POST['user'], $_GET['id']);
          if($idUser){
            $files = uploadFilePhoto($user['key_user']);
            //COMPROBAMOS SI SE SUBIO UNA FOTOGRAFÍA DEL EMPLEADO / USUARIO
            if($files['imguser']){
              $files = [
                'imguser' => $files['imguser']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            //COMRPOBAMOS SI NO SE SELECCIONO NINGUNA FOTOGRAFÍA DEL EMPLEADO / USUARIO Y SE QUEDA EXACTAMENTE IGUAL
            else{
              $files = [
                'imguser' => $user['photo_user']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            header('location: users.php');
          }
        }
      }
      
      //COMRPOBAMOS SI EL RFC ES DIFERENTE PERO EL CORREO Y EL TELEFÓNO SON LOS MISMOS
      else if ($_POST['user']['rfc_user'] != $user['rfc_user'] AND $_POST['user']['email_user'] == $user['email_user'] AND $_POST['user']['phone_user'] == $user['phone_user']) {
        $rfcClient = $controller->getRFCUser($_POST['user']['rfc_user']);
        //COMPROBAMOS SI EL RFC DEL CLIENTE EXISTE
        if(!empty($rfcClient)){
          $mssg = "¡EL RFC YA SE ENCUENTRA REGISTRADO, INTENTA CON OTRO!";
        }
        else {
          $idUser = $controller->updateUser($_POST['user'], $_GET['id']);
          if($idUser){
            $files = uploadFilePhoto($user['key_user']);
            //COMPROBAMOS SI SE SUBIO UNA FOTOGRAFÍA DEL EMPLEADO / USUARIO
            if($files['imguser']){
              $files = [
                'imguser' => $files['imguser']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            //COMRPOBAMOS SI NO SE SELECCIONO NINGUNA FOTOGRAFÍA DEL EMPLEADO / USUARIO Y SE QUEDA EXACTAMENTE IGUAL
            else{
              $files = [
                'imguser' => $user['photo_user']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            header('location: users.php');
          }
        }
      }
      
      //EN CASO DE CAMBIAR TODOS SE REALIZA UNA TRIPLE COMPROBACIÓN
      else {
        //CONSULTAMOS LA BASE DE DATOS ENVIANDO EL CORREO ELECTRÓNICO DEL CLIENTE
        $emailClient = $controller->getEmailUser($_POST['user']['email_user']);
        //CONSULTAMOS LA BASE DE DATOS ENVIANDO EL TELÉFONO DEL CLIENTE
        $phoneClient = $controller->getPhoneUser($_POST['user']['phone_user']);
        //CONSULTAMOS LA BASE DE DATOS ENVIANDO EL RFC DEL CLIENTE
        $rfcClient = $controller->getRFCUser($_POST['user']['rfc_user']);
        //COMPROBAMOS SI EL CORREO ELECTRÓNICO DEL CLIENTE EXISTE
        if(!empty($emailClient)){
          $mssg = "¡EL CORREO ELECTRÓNICO YA ESTÁ EN USO POR UN USUARIO ACTIVO. INTENTA CON OTRO!";
        }
        //COMPROBAMOS SI EL NÚMERO DE TELÉFONO DEL CLIENTE EXISTE
        else if (!empty($phoneClient)){
          $mssg = "¡EL NÚMERO DE TELÉFONO ESTÁ EN USO POR UN USUARIO ACTIVO, INTENTA CON OTRO!";
        }
        //COMPROBAMOS SI EL RFC DEL CLIENTE EXISTE
        else if (!empty($rfcClient)){
          $mssg = "¡EL RFC YA SE ENCUENTRA REGISTRADO, INTENTA CON OTRO!";
        } else {
          $idUser = $controller->updateUser($_POST['user'], $_GET['id']);
          if($idUser){
            $files = uploadFilePhoto($user['key_user']);
            //COMPROBAMOS SI SE SUBIO UNA FOTOGRAFÍA DEL EMPLEADO / USUARIO
            if($files['imguser']){
              $files = [
                'imguser' => $files['imguser']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            //COMRPOBAMOS SI NO SE SELECCIONO NINGUNA FOTOGRAFÍA DEL EMPLEADO / USUARIO Y SE QUEDA EXACTAMENTE IGUAL
            else{
              $files = [
                'imguser' => $user['photo_user']
              ];
              $userId = $controller->updatePhotoUser($user['id_user'], $files);
            }
            header('location: users.php');
          }
        }
      }
    }
  }
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>FULTRA MX</title>
    <link rel="stylesheet" href="../../resources/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../resources/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../../resources/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../resources/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../resources/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Cropper.js CSS -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />-->
    <link rel="stylesheet" href="../../resources/css/cropper.min.css" />
    
    <link rel="icon" href="../../resources/img/icono.png">
    <script src="../../resources/js/jquery-3.5.1.min.js"></script>
    <style>
      /* Estilos adicionales para el botón de "ver contraseña" */
      .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        transition: transform 0.2s, font-size 0.2s; /* Agrega una transición a la transformación y al tamaño de la fuente */
      }
      .password-toggle:hover {
        color: #007bff; /* Cambia el color al hacer hover */
      }
      .password-toggle.clicked {
        transform: scale(1.2); /* Cambia la escala al hacer clic */
      }
      /* Ajustes para el campo de contraseña */
      #password {
        padding-right: 30px; /* Ajusta el espacio a la derecha para acomodar el ícono */
      }
    </style>
  </head>
  
  <body class="hold-transition sidebar-mini">
    <div class="wrapper" style="padding-top: 57px;">
      <?php include "../templates/navbar.php"; ?>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-8">
                <h1 class="m-0 text-dark">Actualizar usuario</h1>
              </div>
              <div class="col-sm-4 text-right">
                <!--<a href="<?=$_SERVER["HTTP_REFERER"]?>" class="btn btn-block" style="background-color: #FF5800; color: #ffffff;" role="button" aria-pressed="true">Regresar</a>-->
                <a href="users.php" class="btn btn-block" style="background-color: #FF5800; color: #ffffff;" role="button" aria-pressed="true">Regresar</a>
              </div>
            </div>
            <hr>
            
            <?php if (!empty($mssg)) { ?>
              <div class="row">
                <div class="col-12 pt-3">
                  <div class="alert alert-dismissible alert-danger p-4">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><?php echo $mssg; ?></h5>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        
        <div class="content">
          <form action="#" method="post" enctype="multipart/form-data">
            <div class="container-fluid">
              <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1)-->
              <?php if($_SESSION['user']['id_type_user'] == 1){ ?>
                <div class="row">
                  
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card" style="height: 100%">
                      <div class="card-body">
                        <div class="col-md-12">
                          
                          <!--Campo de Nombre / name_user-->
                          <div class="form-group">
                            <label for="name_user">Nombre del usuario</label>
                            <input name="user[name_user]" type="text" class="form-control validate" id="name_user" required title="Utiliza solo letras como mínimo 3 y máximo 40" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ ]{3,40}" maxlength="40" minlength="3" value="<?php echo $user['name_user']; ?>" autocomplete="off">
                            <small class="error-msg" style="color:red; display: none;">*Utiliza solo letras como mínimo 3 y máximo 40 caracteres</small>
                          </div>
                          
                          <!--ID del tipo de Usuario / id_type_user -->
                          <div class="form-group">
                            <label for="id_type_user">Tipo de usuario</label>
                            <select name="user[id_type_user]" id="id_type_user" class="form-control form-control-md selectTypeUser" required>
                              <?php foreach($userTypes as $key => $value): ?>
                                <?php if($user['id_type_user'] == $value['id_type']): ?>
                                  <option value="<?php echo $user['id_type_user']; ?>" selected>
                                    <?php echo $user['name_type']; ?>
                                  </option>
                                <?php else: ?>
                                  <option value="<?php echo $value['id_type']; ?>">
                                    <?php echo $value['name_type']; ?>
                                  </option>
                                <?php endif; ?>
                              <?php endforeach; ?>
                            </select>
                            <!--<small style="color:red;">*Campo obligatorio</small>-->
                          </div>
                          
                          <!--Campo de RFC / rfc_user-->
                          <!--<div class="form-group">
                            <label for="rfc_user">RFC del usuario</label>
                            <input name="user[rfc_user]" type="text" class="form-control validate" id="rfc_user" required title="Utiliza letras y números. El RFC debe tener 13 caracteres." pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ0-9 ]{13}" maxlength="13" minlength="13" value="<?php echo $user['rfc_user']; ?>" autocomplete="off">
                            <small class="error-msg" style="color:red; display: none;">*Utiliza letras y números. El RFC debe tener 13 caracteres</small>
                          </div>-->

                          <!--Campo de RFC / rfc_user - CÓDIGO NUEVO-->
                        <div class="form-group" style="display: none;" hidden>
                          <label for="rfc_user">RFC del usuario</label>
                          <?php if(empty($user['rfc_user']) || $user['rfc_user'] == NULL || $user['rfc_user'] == ''){ ?>
                            <input name="user[rfc_user]" type="text" class="form-control" id="rfc_user" required readonly value="<?php echo isset($_POST['user']['rfc_user']) ? htmlspecialchars($_POST['user']['rfc_user']) : $usr_rfc; ?>" autocomplete="off">
                          <?php } else { ?>
                            <input name="user[rfc_user]" type="text" class="form-control" id="rfc_user" required readonly value="<?php echo $user['rfc_user']; ?>" autocomplete="off">
                          <?php } ?>
                        </div>
                          
                          <!--Campo de Teléfono / phone_user-->
                          <div class="form-group">
                            <label for="phone_user">Número de teléfono</label>
                            <input name="user[phone_user]" type="text" class="form-control validate" id="phone_user" required title="Utiliza solo números. El número de teléfono debe tener 10 caracteres. Ejemplo: 8182597869" pattern="[0-9]{10}" maxlength="10" minlength="10" value="<?php echo $user['phone_user']; ?>" autocomplete="off">
                            <small class="error-msg" style="color:red; display: none;">*Utiliza solo números. El número de teléfono debe tener 10 caracteres</small>
                          </div>
                          
                          <!--Campo de Correo Eletrónico / email_user-->
                          <div class="form-group">
                            <label for="email_user">Correo electrónico</label>
                            <input name="user[email_user]" type="email" class="form-control validate" id="email_user" required maxlength="40" minlength="5" value="<?php echo $user['email_user']; ?>" autocomplete="off">
                            <small class="error-msg" style="color:red; display: none;">*Ingresa un correo electrónico válido</small>
                          </div>
                          
                          <!--Campo de Password - Contraseña / password-->
                          <div class="alert" role="alert" style="background-color: #F4EACD; color: #000000;">
                            ¡En caso de querer actualizar la contraseña, escriba la nueva contraseña!
                          </div>

                          <div class="form-group">
                            <label for="password_user">Password / Contraseña</label> (<small style="color:black;">*Para ver la contraseña dar click en el botón de la derecha</small>)
                            <div style="position: relative;">
                              <input name="user[password_user]" type="password" class="form-control validate" id="password_user" title="Introduce un password de mínimo 8 y máximo 15 caracteres. Ejemplo: $Contraseña123" maxlength="15" minlength="8" pattern="^(?=.*[!@#$%^&*])(?=.*[A-Z])(?=.*[0-9]).{8,}$" autocomplete="off">
                              <span class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="eyeIconOpen" style="display: none;"></i>
                                <i class="fas fa-eye-slash" id="eyeIconClosed"></i>
                              </span>
                            </div>
                            <small class="error-msg" style="color:red; display: none;">*La contraseña debe contener al menos un símbolo especial, una letra mayúscula, un número y tener una longitud mínima de 8 caracteres. (Ejem. $Contraseña1234@)</small>
                          </div>
                          
                          <!--Campo de ESTATUS / status_user -->
                          <div class="form-group">
                            <label>Estatus</label>
                            <select name="user[status_user]" class="form-control form-control-md">
                              <?php if($user['status_user'] == 1){ ?>
                                <option value="1" selected="selected">Activo</option>
                                <option value="2">Inactivo</option>
                              <?php } else { ?>
                                <option value="1">Activo</option>
                                <option value="2" selected="selected">Inactivo</option>
                              <?php } ?>
                            </select>
                            <!--<small style="color:red;">*Campo obligatorio</small>-->
                          </div>
                        
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card" style="height: 100%">
                      <div class="card-body">
                        <div class="col-md-12">
                          
                          <div class="form-group">
                            <label>Fecha de registro</label>
                            <input type="text" class="form-control" value="<?php echo date_format(date_create($user['created_at_user']), 'd/m/Y h:i a'); ?>" readonly disabled>
                          </div>
                          
                          <div class="form-group">
                            <label>Última modificación</label>
                            <input type="text" class="form-control" value="<?php echo date_format(date_create($user['updated_at_user']), 'd/m/Y h:i a'); ?>" readonly disabled>
                          </div>
                          
                          <!--Campo de FOTOGRAFÍA / photo_user-->
                          <div class="form-group">
                            <label>Fotografía del usuario <small>(*Opcional)</small></label>
                            <input type="file" class="form-control" name="file-imguser" id="photo_user" accept="image/*">
                            <!--<small style="color:red;">*Campo opcional (solo si se desea actualizar la fotografía)</small>-->
                            
                            <!-- Modal para recorte de imagen -->
                            <div id="cropperModal" class="modal" tabindex="-1" role="dialog" data-backdrop="static">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Recortar Fotografía</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body text-center">
                                    <div>
                                      <img id="imagePreview" style="max-width: 100%; max-height: 400px;" />
                                    </div>
                                  </div>
                                  
                                  <div class="modal-footer">
                                    <button type="button" id="cropImage" class="btn btn-primary">Recortar y Guardar</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div style="text-align: center;"><br>
                              <?php if($user['photo_user'] != NULL){ ?>
                                <img width='280' height='280' style="border-radius: 50%; object-fit: cover;" src="<?php echo "../../uploads/users/".$user['photo_user']; ?>">
                              <?php } else { ?>
                                <img width='280' height='280' style="border-radius: 50%; object-fit: cover;" src="<?php echo "../../uploads/users/sin-foto.jpeg"; ?>">
                                <!--<p style="color: red; font-weight:bold;">Sin foto de perfil</p>-->
                              <?php } ?>
                            </div>
                          </div>
                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div><br>
              <?php } ?>

              <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1)-->
              <?php if($_SESSION['user']['id_type_user'] == 1){ ?>
                <div class="alert" role="alert" style="text-align:center; font-size:20px; background-color: #37424A; color: #ffffff;">
                  ¡Favor de presionar <strong>una vez el botón de "actualizar usuario"</strong>, y esperar a que cargue la página!
                </div>
                <div class="form-group text-center">
                  <button class="btn btn-lg" style="background-color: #37424A; color: #ffffff;" name="action" value="update">Actualizar usuario</button>
                </div>
              <?php } ?>
            </div>
          </form>
        </div><br>
      </div>
    </div>
    <script>
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
          delay: { "show": 0, "hide": 0 } // Hacer que el tooltip aparezca y desaparezca inmediatamente
        });
      });
    </script>
    <script src="../../resources/plugins/jquery/jquery.min.js"></script>
    <script src="../../resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../resources/dist/js/adminlte.min.js"></script>
    <script src="../../resources/js/notifications.js"></script>
    <script src="../../resources/js/tracings.js"></script>
    <script src="../../resources/js/notify_folders.js"></script>
    <!-- Cropper.js JS -->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>-->
    <script src="../../resources/js/cropper.min.js"></script>
    <!-- Select2 -->
    <script src="../../resources/plugins/select2/js/select2.full.min.js"></script>
    <script>
      $(document).ready(function(){
        $('.selectTypeUser').select2({
          theme: 'bootstrap4'
        });
      });
    </script>
    <script>
      // Función para convertir el valor del campo a mayúsculas
      function convertirAMayusculas(inputId) {
        // Obtener el campo de entrada por su id
        var inputElement = document.getElementById(inputId);
        // Agregar un evento que se dispare cuando el usuario escriba en el campo
        inputElement.addEventListener("input", function() {
        // Convertir el valor a mayúsculas y establecerlo nuevamente en el campo
          this.value = this.value.toUpperCase();
        });
      }
      // Función para permitir solo números en el campo
      function permitirSoloNumeros(inputId) {
        // Obtener el campo de entrada por su id
        var inputElement = document.getElementById(inputId);
        // Agregar un controlador de eventos para bloquear la entrada no numérica
        inputElement.addEventListener("input", function() {
          this.value = this.value.replace(/[^0-9]/g, "");
        });
      }
      // Función para permitir solo texto (letras) en el campo
      function permitirSoloTexto(inputId) {
        var inputElement = document.getElementById(inputId);
        inputElement.addEventListener("input", function() {
          this.value = this.value.replace(/[^a-zA-ZñÑáÁéÉíÍóÓúÚ ]/g, "");
        });
      }

      // Llamar a las funciones para cada campo de entrada
      convertirAMayusculas("name_user");
      //convertirAMayusculas("rfc_user");
      permitirSoloNumeros("phone_user");
      permitirSoloTexto("name_user");
    </script>
    <script>
      function togglePassword() {
        var passwordField = document.getElementById('password_user');
        var eyeIconOpen = document.getElementById('eyeIconOpen');
        var eyeIconClosed = document.getElementById('eyeIconClosed');
        passwordField.type = (passwordField.type === 'password') ? 'text' : 'password';
        // Alterna la visibilidad de los iconos de ojo abierto y cerrado
        eyeIconOpen.style.display = (passwordField.type === 'password') ? 'none' : 'inline-block';
        eyeIconClosed.style.display = (passwordField.type === 'password') ? 'inline-block' : 'none';
        // Agrega y remueve la clase 'clicked' para la animación de cambio de tamaño
        eyeIconOpen.classList.add('clicked');
        eyeIconClosed.classList.add('clicked');
          
        setTimeout(function() {
          eyeIconOpen.classList.remove('clicked');
          eyeIconClosed.classList.remove('clicked');
        }, 200); // Ajusta el tiempo de la animación según sea necesario
      }
    </script>
    <script>
      // Selecciona todos los campos de entrada y sus mensajes de error correspondientes
      const inputs = document.querySelectorAll('.validate');
      const errorMessages = document.querySelectorAll('.error-msg');
      // Añade un evento para cada campo de entrada que se ejecute cuando cambie el valor
      inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
          if (input.checkValidity()) {
            errorMessages[index].style.display = 'none';  // Oculta el mensaje de error si el valor es válido
          } else {
            errorMessages[index].style.display = 'block';  // Muestra el mensaje de error si el valor es inválido
          }
        });
      });
    </script>
    
    <!--SCRIPT PARA RECORTAR LA FOTOGRAFÍA Y VER UNA VISTA PREVIA-->
    <script>
      let cropper;
      document.getElementById('photo_user').addEventListener('change', function(event) {
        const files = event.target.files;
        if (files && files.length > 0) {
          const file = files[0];
          const reader = new FileReader();
          
          reader.onload = function(event) {
            // Mostrar la imagen en el modal
            const image = document.getElementById('imagePreview');
            image.src = event.target.result;
            // Mostrar el modal
            $('#cropperModal').modal('show');
            // Inicializar Cropper.js
            if (cropper) {
              cropper.destroy(); // Destruir cualquier instancia previa
            }
            cropper = new Cropper(image, {
              aspectRatio: 1, // Relación 1:1 para un recorte circular
              viewMode: 2,
              preview: '.preview', // Opcional: añade un contenedor para previsualización
            });
          };
          reader.readAsDataURL(file);
        }
      });
      
      document.getElementById('cropImage').addEventListener('click', function () {
        // Obtener el nombre original del archivo
        const fileInput = document.getElementById('photo_user');
        const originalFileName = fileInput.files[0]?.name || "cropped-image.png";
        
        cropper.getCroppedCanvas({
          width: 200,
          height: 200,
          imageSmoothingQuality: 'high',
        }).toBlob((blob) => {
          // Crear un archivo con el nombre original y el contenido recortado
          const file = new File([blob], originalFileName, { type: blob.type });
          
          // Asignar el archivo al input de tipo file usando DataTransfer
          const dataTransfer = new DataTransfer();
          dataTransfer.items.add(file);
          fileInput.files = dataTransfer.files;
          
          // Ocultar el modal después de asignar el archivo
          $('#cropperModal').modal('hide');
        });
      });
    </script>
    
    <script>
      // Código para resetear el input de foto al cancelar o cerrar el modal
      document.querySelector('.btn-secondary').addEventListener('click', function() {
        document.getElementById('photo_user').value = '';
      });
      // Agregar evento al botón de cerrar (la 'x')
      document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('photo_user').value = '';
      });
    </script>
    
  </body>
</html>