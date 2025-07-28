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
   
    // Llama a la función getUserTypes() en el controlador para obtener los tipos de usuarios disponibles.
    $userTypes = $controller->getUserTypes();
    $companies = $controller->getActiveCompanies();

   
    function uploadFilePhoto($folio, $filename = null) {
        global $files;
        $filename['imguser'] = $files->upload($folio, $_FILES['file-imguser'],  "ord.imguser");
        return $filename;
    }
   


    if(!empty($_POST['action'])){
        if($_POST['action'] == 'create'){
            // Validaciones existentes...
            $emailUser = $controller->getEmailUser($_POST['user']['email_user']);
            $phoneUser = $controller->getPhoneUser($_POST['user']['phone_user']);
            $rfcUser = $controller->getRFCUser($_POST['user']['rfc_user']);
            
            // NUEVA VALIDACIÓN: Si es cliente empresa, debe tener empresa asignada
            if($_POST['user']['id_type_user'] == 3 && empty($_POST['user']['id_company'])) {
                $mssg = "¡LOS USUARIOS DE TIPO CLIENTE EMPRESA DEBEN TENER UNA EMPRESA ASIGNADA!";
            }
            // Validaciones existentes de email, teléfono, RFC...
            else if(!empty($emailUser)){
                $mssg = "¡EL CORREO ELECTRÓNICO YA ESTÁ EN USO POR UN USUARIO ACTIVO. INTENTA CON OTRO!";
            }
            else if (!empty($phoneUser)){
                $mssg = "¡EL NÚMERO DE TELÉFONO ESTÁ EN USO POR UN USUARIO ACTIVO, INTENTA CON OTRO!";
            }
            else if (!empty($rfcUser)){
                $mssg = "¡EL RFC YA SE ENCUENTRA REGISTRADO, INTENTA CON OTRO!";
            }
            else {
                $userId = $controller->createUser($_POST['user']);
                if($userId){
                    $files = uploadFilePhoto($_POST['user']['key_user']);
                    $idUserNotification = $controller->createNotifications($userId, 0);
                    $idUser = $controller->updatePhotoUser($userId, $files);
                    if($idUser){
                        header('location: users.php');
                    } else {
                        $mssg = "HA HABIDO UN PROBLEMA CON EL REGISTRO, INTENTA DE NUEVO";
                    }
                }
            }
        }
    }
   
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $clave = substr(str_shuffle($permitted_chars), 0, 5);

    $usr_rfc = substr(str_shuffle($permitted_chars), 0, 13);
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
                                <h1 class="m-0 text-dark">Agregar usuario</h1>
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
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card" style="height: 100%">
                                    <div class="card-body">
                                        <form action="#" method="post" enctype="multipart/form-data">
                                            <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1)-->
                                            <?php if($_SESSION['user']['id_type_user'] == 1){ ?>
                                                <div class="col-md-12">
                                                   
                                                    <!--Campo de Clave / key_user-->
                                                    <div class="form-group" style="display: none;" hidden>
                                                        <label for="key_user" style="display: none;" hidden>>Clave de usuario</label>
                                                        <input name="user[key_user]" type="text" class="form-control" id="key_user" required value="USR-<?php echo $clave; ?>" readonly style="display: none;" hidden>>
                                                    </div>
                                                   
                                                    <!--Campo de Nombre / name_user-->
                                                    <div class="form-group">
                                                        <label for="name_user">Nombre del usuario</label>
                                                        <input name="user[name_user]" type="text" class="form-control validate" id="name_user" required title="Utiliza solo letras como mínimo 3 y máximo 40" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ ]{3,40}" maxlength="40" minlength="3" value="<?php echo isset($_POST['user']['name_user']) ? htmlspecialchars($_POST['user']['name_user']) : ''; ?>" autocomplete="off">
                                                        <small class="error-msg" style="color:red; display: none;">*Utiliza solo letras como mínimo 3 y máximo 40 caracteres</small>
                                                    </div>
                                                   
                                                    <!--Campo de RFC / rfc_user - CÓDIGO ANTERIOR -->
                                                    <!--<div class="form-group">
                                                        <label for="rfc_user">RFC del usuario</label>
                                                        <input name="user[rfc_user]" type="text" class="form-control validate" id="rfc_user" required title="Utiliza letras y números. El RFC debe tener 13 caracteres." pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ0-9 ]{13}" maxlength="13" minlength="13" value="<?php echo isset($_POST['user']['rfc_user']) ? htmlspecialchars($_POST['user']['rfc_user']) : ''; ?>" autocomplete="off">
                                                        <small class="error-msg" style="color:red; display: none;">*Utiliza letras y números. El RFC debe tener 13 caracteres</small>
                                                    </div>-->
                                                    
                                                    <!--Campo de RFC / rfc_user - CÓDIGO NUEVO PARA GENERAR DINAMICAMENTE EL RFC-->
                                                    <div class="form-group" style="display: none;" hidden>
                                                        <label for="rfc_user">RFC del usuario</label>
                                                        <input name="user[rfc_user]" type="text" class="form-control" id="rfc_user" required readonly value="<?php echo isset($_POST['user']['rfc_user']) ? htmlspecialchars($_POST['user']['rfc_user']) : $usr_rfc; ?>" autocomplete="off">
                                                        <!--<small class="error-msg" style="color:red; display: none;">*Utiliza letras y números. El RFC debe tener 13 caracteres</small>-->
                                                    </div>
                                                   
                                                    <!--Campo de Tipo de USUARIO / id_type_user -->
                                                    <div class="form-group">
                                                        <label for="id_type_user">Tipo de usuario</label>
                                                        <select name="user[id_type_user]" id="id_type_user" class="form-control form-control-md selectTypeUser" required>
                                                            <option value="">--</option>
                                                            <?php foreach($userTypes as $key => $value){ ?>
                                                                <option value="<?php echo $value['id_type']; ?>" <?php echo isset($_POST['user']['id_type_user']) && $_POST['user']['id_type_user'] == $value['id_type'] ? 'selected' : ''; ?>>
                                                                    <?php echo $value['name_type']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <!--<small class="error-msg" style="color:red; display: none;">*Campo obligatorio</small>-->
                                                    </div>


                                                    <div class="form-group" id="empresa-section" style="display: none;">
                                                        <label for="id_company">Empresa: <span class="text-danger">*</span></label>
                                                        <select name="user[id_company]" class="form-control" id="id_company">
                                                            <option value="">Seleccionar empresa...</option>
                                                            <?php foreach($companies as $company) { ?>
                                                                <option value="<?php echo $company['id_company']; ?>" 
                                                                        <?php echo isset($_POST['user']['id_company']) && $_POST['user']['id_company'] == $company['id_company'] ? 'selected' : ''; ?>>
                                                                    <?php echo $company['name_company'] . ' (' . $company['rfc_company'] . ')'; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <small class="form-text text-muted">Seleccione la empresa a la que pertenece el usuario</small>
                                                    </div>


                                                     <!-- Rol en la Empresa (solo para clientes empresa) -->
                                                    <div class="form-group" id="rol-empresa-section" style="display: none;">
                                                        <label for="company_role">Rol en la Empresa:</label>
                                                        <select name="user[company_role]" class="form-control" id="company_role">
                                                            <option value="operador" <?php echo isset($_POST['user']['company_role']) && $_POST['user']['company_role'] == 'operador' ? 'selected' : ''; ?>>
                                                                Operador
                                                            </option>
                                                            <option value="admin_empresa" <?php echo isset($_POST['user']['company_role']) && $_POST['user']['company_role'] == 'admin_empresa' ? 'selected' : ''; ?>>
                                                                Administrador de Empresa
                                                            </option>
                                                            <option value="consultor" <?php echo isset($_POST['user']['company_role']) && $_POST['user']['company_role'] == 'consultor' ? 'selected' : ''; ?>>
                                                                Consultor
                                                            </option>
                                                        </select>
                                                        <small class="form-text text-muted">
                                                            <strong>Operador:</strong> Registra operaciones PLD<br>
                                                            <strong>Admin Empresa:</strong> Gestiona usuarios de la empresa<br>
                                                            <strong>Consultor:</strong> Solo consulta información
                                                        </small>
                                                    </div>
                                                    
                                                    <!-- Campo de Fotografía -->
                                                    <div class="form-group">
                                                        <label for="photo_user">Fotografía <small>(*Opcional)</small></label>
                                                        <input type="file" class="form-control" name="file-imguser" id="photo_user" accept="image/*">
                                                    </div>
                                                    
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
                                                    
                                                    <!--Campo de Teléfono / phone_user-->
                                                    <div class="form-group">
                                                        <label for="phone_user">Número de teléfono</label>
                                                        <input name="user[phone_user]" type="text" class="form-control validate" id="phone_user" required title="Utiliza solo números. El número de teléfono debe tener 10 caracteres. Ejemplo: 8182597869" pattern="[0-9]{10}" maxlength="10" minlength="10" value="<?php echo isset($_POST['user']['phone_user']) ? htmlspecialchars($_POST['user']['phone_user']) : ''; ?>" autocomplete="off">
                                                        <small class="error-msg" style="color:red; display: none;">*Utiliza solo números. El número de teléfono debe tener 10 caracteres</small>
                                                    </div>
                                                   
                                                    <!--Campo de Correo Eletrónico / email_user-->
                                                    <div class="form-group">
                                                        <label for="email_user">Correo electrónico</label>
                                                        <input name="user[email_user]" type="email" class="form-control validate" id="email_user" required maxlength="40" minlength="5" value="<?php echo isset($_POST['user']['email_user']) ? htmlspecialchars($_POST['user']['email_user']) : ''; ?>" autocomplete="off">
                                                        <small class="error-msg" style="color:red; display: none;">*Ingresa un correo electrónico válido</small>
                                                    </div>
                                                   
                                                    <!--Campo de Password - Contraseña / password-->
                                                    <div class="form-group">
                                                        <label for="password_user">Password / Contraseña</label> (<small style="color:black;">*Para ver la contraseña dar click en el botón de la derecha</small>)
                                                        <div style="position: relative;">
                                                        <input name="user[password_user]" type="password" class="form-control validate" id="password_user" required title="Introduce un password de mínimo 8 y máximo 15 caracteres. Ejemplo: $Contraseña123" maxlength="15" minlength="8" pattern="^(?=.*[!@#$%^&*])(?=.*[A-Z])(?=.*[0-9]).{8,}$" value="<?php echo isset($_POST['user']['password_user']) ? htmlspecialchars($_POST['user']['password_user']) : ''; ?>" autocomplete="off">
                                                        <span class="password-toggle" onclick="togglePassword()">
                                                            <i class="fas fa-eye" id="eyeIconOpen" style="display: none;"></i>
                                                            <i class="fas fa-eye-slash" id="eyeIconClosed"></i>
                                                        </span>
                                                    </div>
                                                    <small class="error-msg" style="color:red; display: none;">*La contraseña debe contener al menos un símbolo especial, una letra mayúscula, un número y tener una longitud mínima de 8 caracteres. (Ejem. $Contraseña1234@)</small>
                                                </div>
                                            <?php } ?>
                                           
                                            <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1)-->
                                            <?php if($_SESSION['user']['id_type_user'] == 1){ ?>
                                                <div class="alert" role="alert" style="text-align:center; font-size:20px; background-color: #37424A; color: #ffffff;">
                                                    ¡Favor de presionar <strong>una vez el botón de "guardar usuario"</strong>, y esperar a que cargue la página!
                                                </div>
                                                <div class="form-group text-center">
                                                    <button class="btn btn-lg" style="background-color: #37424A; color: #ffffff;" name="action" value="create">Guardar usuario</button>
                                                </div>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
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
        
        // NUEVO: Select2 para empresas
        $('#id_company').select2({
            theme: 'bootstrap4',
            placeholder: 'Seleccionar empresa...',
            allowClear: true
        });
    });
</script>

<script>
    // Función para convertir el valor del campo a mayúsculas
    function convertirAMayusculas(inputId) {
        var inputElement = document.getElementById(inputId);
        inputElement.addEventListener("input", function() {
            this.value = this.value.toUpperCase();
        });
    }
    
    // Función para permitir solo números en el campo
    function permitirSoloNumeros(inputId) {
        var inputElement = document.getElementById(inputId);
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
    permitirSoloNumeros("phone_user");
    permitirSoloTexto("name_user");
</script>

<script>
    function togglePassword() {
        var passwordField = document.getElementById('password_user');
        var eyeIconOpen = document.getElementById('eyeIconOpen');
        var eyeIconClosed = document.getElementById('eyeIconClosed');
        passwordField.type = (passwordField.type === 'password') ? 'text' : 'password';
        
        eyeIconOpen.style.display = (passwordField.type === 'password') ? 'none' : 'inline-block';
        eyeIconClosed.style.display = (passwordField.type === 'password') ? 'inline-block' : 'none';
        
        eyeIconOpen.classList.add('clicked');
        eyeIconClosed.classList.add('clicked');
       
        setTimeout(function() {
            eyeIconOpen.classList.remove('clicked');
            eyeIconClosed.classList.remove('clicked');
        }, 200);
    }
</script>

<script>
    // Validación de campos
    const inputs = document.querySelectorAll('.validate');
    const errorMessages = document.querySelectorAll('.error-msg');
    
    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.checkValidity()) {
                errorMessages[index].style.display = 'none';
            } else {
                errorMessages[index].style.display = 'block';
            }
        });
    });
</script>

<!-- NUEVO SCRIPT: Gestión de campos de empresa -->
<script>
$(document).ready(function() {
    // Función para mostrar/ocultar campos de empresa
    function toggleEmpresaFields() {
        var tipoUsuario = $('#id_type_user').val();
        
        if (tipoUsuario == '3') { // Cliente Empresa
            $('#empresa-section').show().addClass('animate-in');
            $('#rol-empresa-section').show().addClass('animate-in');
            $('#id_company').attr('required', true);
            
            // Mostrar información sobre el tipo seleccionado
            showNotification('info', 'Usuario tipo Cliente Empresa: debe asignar una empresa');
        } else { // Admin o Empleado FULTRA
            $('#empresa-section').hide().removeClass('animate-in');
            $('#rol-empresa-section').hide().removeClass('animate-in');
            $('#id_company').removeAttr('required').val('').trigger('change');
            $('#company_role').val('operador');
            
            if (tipoUsuario) {
                var tipoNombre = $('#id_type_user option:selected').text();
                showNotification('success', 'Usuario tipo ' + tipoNombre + ': empleado de FULTRA');
            }
        }
    }
    
    // Ejecutar al cargar la página
    toggleEmpresaFields();
    
    // Ejecutar cuando cambie el tipo de usuario
    $('#id_type_user').change(function() {
        toggleEmpresaFields();
    });
    
    // Validación en tiempo real del RFC de empresa
    $('#id_company').change(function() {
        var companyId = $(this).val();
        if (companyId) {
            var companyName = $(this).find('option:selected').text();
            showNotification('success', 'Empresa seleccionada: ' + companyName);
        }
    });
    
    // Información sobre roles
    $('#company_role').change(function() {
        var role = $(this).val();
        var roleInfo = '';
        
        switch(role) {
            case 'admin_empresa':
                roleInfo = 'Puede gestionar usuarios de su empresa y registrar operaciones PLD';
                break;
            case 'operador':
                roleInfo = 'Puede registrar operaciones PLD de su empresa';
                break;
            case 'consultor':
                roleInfo = 'Solo puede consultar información de su empresa';
                break;
        }
        
        if (roleInfo) {
            showNotification('info', 'Rol seleccionado: ' + roleInfo);
        }
    });
    
    // Validación antes de enviar el formulario
    $('form').on('submit', function(e) {
        var tipoUsuario = $('#id_type_user').val();
        var empresa = $('#id_company').val();
        
        // Validación específica para clientes empresa
        if (tipoUsuario == '3' && !empresa) {
            e.preventDefault();
            showNotification('error', 'Los usuarios de tipo Cliente Empresa deben tener una empresa asignada.');
            $('#id_company').focus();
            return false;
        }
        
        // Confirmación final
        var userName = $('#name_user').val();
        var userType = $('#id_type_user option:selected').text();
        var companyName = empresa ? $('#id_company option:selected').text() : 'Ninguna';
        
        var confirmMsg = '¿Confirmar creación del usuario?\n\n' +
                        'Nombre: ' + userName + '\n' +
                        'Tipo: ' + userType + '\n' +
                        'Empresa: ' + companyName;
        
        if (!confirm(confirmMsg)) {
            e.preventDefault();
            return false;
        }
        
        // Mostrar loading
        showLoading();
    });
    
    // Función para mostrar notificaciones
    function showNotification(type, message) {
        // Remover notificaciones anteriores
        $('.custom-notification').remove();
        
        var bgClass = '';
        var icon = '';
        
        switch(type) {
            case 'success':
                bgClass = 'alert-success';
                icon = 'fas fa-check-circle';
                break;
            case 'error':
                bgClass = 'alert-danger';
                icon = 'fas fa-exclamation-triangle';
                break;
            case 'info':
                bgClass = 'alert-info';
                icon = 'fas fa-info-circle';
                break;
        }
        
        var notification = $('<div class="alert ' + bgClass + ' custom-notification mt-2">' +
                           '<i class="' + icon + '"></i> ' + message +
                           '</div>');
        
        // Insertar después del campo tipo de usuario
        $('#id_type_user').closest('.form-group').after(notification);
        
        // Auto-remover después de 3 segundos
        setTimeout(function() {
            notification.fadeOut(500, function() {
                $(this).remove();
            });
        }, 3000);
    }
    
    // Función para mostrar loading
    function showLoading() {
        $('button[type="submit"]').prop('disabled', true).html(
            '<i class="fas fa-spinner fa-spin"></i> Creando usuario...'
        );
    }
});
</script>

<!-- SCRIPT PARA RECORTAR LA FOTOGRAFÍA Y VER UNA VISTA PREVIA -->
<script>
    let cropper;
    document.getElementById('photo_user').addEventListener('change', function(event) {
        const files = event.target.files;
        if (files && files.length > 0) {
            const file = files[0];
            
            // Validar tipo de archivo
            if (!file.type.startsWith('image/')) {
                alert('Por favor seleccione solo archivos de imagen.');
                this.value = '';
                return;
            }
            
            // Validar tamaño (máximo 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('La imagen debe ser menor a 5MB.');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(event) {
                const image = document.getElementById('imagePreview');
                image.src = event.target.result;
                
                $('#cropperModal').modal('show');
                
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 2,
                    preview: '.preview',
                    responsive: true,
                    restore: false,
                    guides: false,
                    center: false,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                });
            };
            reader.readAsDataURL(file);
        }
    });
    
    document.getElementById('cropImage').addEventListener('click', function () {
        const fileInput = document.getElementById('photo_user');
        const originalFileName = fileInput.files[0]?.name || "cropped-image.png";
        
        cropper.getCroppedCanvas({
            width: 200,
            height: 200,
            imageSmoothingQuality: 'high',
        }).toBlob((blob) => {
            const file = new File([blob], originalFileName, { type: blob.type });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
            
            $('#cropperModal').modal('hide');
            
            // Mostrar notificación de éxito
            $('.custom-notification').remove();
            $('#photo_user').closest('.form-group').after(
                '<div class="alert alert-success custom-notification mt-2">' +
                '<i class="fas fa-check-circle"></i> Imagen procesada correctamente' +
                '</div>'
            );
            
            setTimeout(function() {
                $('.custom-notification').fadeOut();
            }, 2000);
        });
    });
</script>

<script>
    // Código para resetear el input de foto al cancelar o cerrar el modal
    document.addEventListener('DOMContentLoaded', function() {
        // Botón cancelar
        const cancelBtn = document.querySelector('#cropperModal .btn-secondary');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                document.getElementById('photo_user').value = '';
                if (cropper) {
                    cropper.destroy();
                }
            });
        }
        
        // Botón cerrar (X)
        const closeBtn = document.querySelector('#cropperModal .close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                document.getElementById('photo_user').value = '';
                if (cropper) {
                    cropper.destroy();
                }
            });
        }
        
        // Al cerrar el modal por cualquier medio
        $('#cropperModal').on('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
            }
        });
    });
</script>

<!-- ESTILOS ADICIONALES -->
<style>
.animate-in {
    animation: slideIn 0.3s ease-in-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.custom-notification {
    border-radius: 5px;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.custom-notification i {
    margin-right: 8px;
}

#empresa-section, #rol-empresa-section {
    border-left: 4px solid #007bff;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 5px;
    margin: 10px 0;
}

#empresa-section label, #rol-empresa-section label {
    color: #007bff;
    font-weight: 600;
}

/* Mejorar apariencia de Select2 */
.select2-container--bootstrap4 .select2-selection--single {
    height: calc(1.5em + 0.75rem + 2px) !important;
    padding: 0.375rem 0.75rem;
}

.select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
    padding-left: 0;
    padding-right: 0;
    height: auto;
    margin-top: -2px;
}
</style>
        
    </body>
</html>