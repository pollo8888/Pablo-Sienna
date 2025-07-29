<?php
  session_start();
  include "../../app/config.php";
  //include "../../app/debug.php";
  include "../../app/WebController.php";
  $controller = new WebController();
  
  // Verificar si la sesión del usuario está activa
  if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    // Si no hay sesión activa, destruir la sesión
    session_destroy();
    // Redirigir a la página de inicio de sesión
    header("Location: ../../login.php");
    exit(); // Es importante salir después de redirigir para evitar que el código siguiente se ejecute innecesariamente
  }
  
  // Obtener la lista de carpetas mediante el método getFolders del controlador, pasando el status como parámetro (1-> ACTIVO, 2-> INACTIVO)
  $folders = $controller->getFolders(1);
  // Contar el número total de carpetas obtenidas en la variable $folders.
  $totalFolders = count($folders);

  // Obtener la lista de los usuarios del departamento de ventas y que esten activos (3 -> tipo de usuario ventas, 1 -> activos)
  $customersList = $controller->getCustomersList(3, 1);

  //FUNCIÓN PARA CREAR UNA NUEVA CARPETA
  // Verifica si se ha dado clic en algun boton a traves del action
  if(!empty($_POST['action'])){
    // Si la acción es 'create', se intenta crear una carpeta nueva
    if($_POST['action'] == 'create'){
      // Llama al método para crear una carpeta y obtiene el ID de la carpeta creada
      $folderId = $controller->createFolder($_POST['folder']);
      // Si se crea la carpeta correctamente, redirecciona a la página de carpetas
      if($folderId){
        header('location: folders.php');
      }
    }
    // Si la acción es 'update', se intenta actualizar el nombre de una carpeta existente
    else if($_POST['action'] == 'update'){
      // Llama al método para actualizar el nombre de la carpeta y obtiene el ID de la carpeta actualizada
      $idFolder = $controller->updateNameFolder($_POST['updateFolder']);
      // Si se actualiza el nombre correctamente, redirecciona a la página de carpetas
      if($idFolder){
        header('location: folders.php');
      }
    }
    // Si la acción es 'delete', se intenta eliminar una carpeta existente
    else if($_POST['action'] == 'delete'){
      // Llama al método para eliminar la carpeta y obtiene el ID de la carpeta eliminada
      $idFolder = $controller->deleteFolder($_POST['delFolder']);
      // Si se elimina la carpeta correctamente, redirecciona a la página de carpetas
      if($idFolder){
        header('location: folders.php');
      }
    }
  }
  
  //FUNCIÓN PARA GENERAR UNA CLAVE PARA LA CARPETA
  // Cadena de caracteres permitidos para generar la clave
  $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  // Genera una clave aleatoria tomando una subcadena de longitud 6 de la cadena de caracteres permitidos
  $clave = substr(str_shuffle($permitted_chars), 0, 6);

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SIENNA MX</title>
    <link rel="stylesheet" href="../../resources/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../resources/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../../resources/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../resources/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../resources/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    
    <link rel="icon" href="../../resources/img/icono.png">
    <script src="../../resources/js/jquery-3.5.1.min.js"></script>
    <!--SCRIPT PARA MANEJAR EL MOSTRAR Y OCULTAR DE LA FECHA DE ORIGINAL RECIBIDO AL REGISTRAR-->
    <script>
      $(document).ready(function(){
        // Inicialmente ocultar el div de la fecha y remover el atributo required
        $('#fecha-original-recibido').hide();
        $('input[name="folder[fech_orig_recib_folder]"]').removeAttr('required');
        // Mostrar/ocultar el div y agregar/quitar el atributo required según el estado del checkbox
        $('#opcion3').change(function(){
          if ($(this).is(':checked')) {
            $('#fecha-original-recibido').show();
            $('input[name="folder[fech_orig_recib_folder]"]').attr('required', 'required');
          } else {
            $('#fecha-original-recibido').hide();
            $('input[name="folder[fech_orig_recib_folder]"]').removeAttr('required');
          }
        });
      });
    </script>
    <!--SCRIPT PARA MANEJAR EL MOSTRAR Y OCULTAR DE LA FECHA DE ORIGINAL RECIBIDO AL ACTUALIZAR-->
    <script>
      $(document).ready(function(){
        // Mostrar/ocultar el div y agregar/quitar el atributo required según el estado del checkbox
        $('#edit_chk_orig_recib_folder').change(function(){
          if ($(this).is(':checked')) {
            $('#edit-fecha-original-recibido').show();
            $('input[name="updateFolder[fech_orig_recib_folder]"]').attr('required', 'required');
          } else {
            $('#edit-fecha-original-recibido').hide();
            $('input[name="updateFolder[fech_orig_recib_folder]"]').removeAttr('required');
          }
        });
      });
    </script>
    <style>
      .title {
        font-size: 15px;
        font-weight: bold;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 5px 5px 5px 5px;
        margin-bottom:-10px;
      }
      .status-bar-checks {
        text-align: right;
        padding-top: 5px;
        margin-right: 10px;
      }
      .status-bar-checks .status-item {
        display: inline-block;
        margin-left: 10px;
      }
      .status-bar-checks i {
        font-size: 16px; /* Tamaño del icono */
        color: #000000;
      }
      .status-bar-checks .status-item span {
        font-weight: bold;
        font-size: 14px;
      }
    </style>
  </head>
  
  <body class="hold-transition sidebar-mini">
    <div class="wrapper" style="padding-top: 57px;">
      <?php include "../templates/navbar.php"; ?>
      <div class="content-wrapper">
        <div class="content-header" style="margin-bottom:-20px;">
          <div class="container-fluid">
            <div class="row justify-content-between mb-2">
              <div class="col-lg-6 col-sm-6">
                <h1 class="m-0 text-dark">Lista completa de clientes</h1>
              </div>
              
              <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1) O VENTAS (3)-->
              <?php if($_SESSION['user']['id_type_user'] == 1 || $_SESSION['user']['id_type_user'] == 3){ ?>
                <div class="col-sm-4 text-right">
                  <!-- Botón para abrir el modal -->
                  <a href="#" class="btn btn-block" style="background-color: #FF5800; color: #ffffff;" role="button" aria-pressed="true" data-toggle="modal" data-target="#modalAgregarCarpeta">
                    <i class="fas fa-plus pr-2"></i>Agregar nuevo cliente
                  </a>
                </div>
              <?php } ?>
            </div>
            <hr>
          </div>
        </div>
        
        <!--CONSULTA GENERAL DE TODAS LAS CARPETAS-->
        <div class="content">
          <div class="container-fluid">
            <strong>Total de clientes: <?php echo $totalFolders; ?></strong>
            <div class="row">
              <div class="col-lg-4 col-md-6 col-sm-12">
                <input type="text" class="form-control" style="margin-bottom:10px;" id="searchInputFolders" placeholder="Buscar cliente...">
              </div>
            </div>
            
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <?php if(empty($folders)) { ?>
                      <div class="alert alert-info" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>&nbsp;¡No se hallaron registros de clientes!
                      </div>
                    <?php } else { ?>
                      <div class="row">
                        <?php foreach ($folders as $folder) : ?>
                          <div class="col-lg-3 col-md-6 col-sm-12" id="myFolders">
                            <div class="folder">
                              <div class="title-bar" style="background-color: #f5f5f5; color: #000000; border-radius: 10px; padding: 5px; display: flex; flex-direction: column; align-items: stretch;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                  <div class="title">
                                    <a href="subfolder.php?id=<?php echo $folder['id_folder']; ?>&key=<?php echo $folder['key_folder']; ?>" style="text-decoration: none; color: inherit;">
                                      <i class="fas fa-folder fa-lg"></i>
                                      &nbsp;&nbsp;
                                      <?php echo $folder['name_folder']; ?>
                                    </a>
                                  </div>
                                  <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1)-->
                                  <?php if ($_SESSION['user']['id_type_user'] == 1) { ?>
                                    <div class="dropdown" style="margin-top:5px;">
                                      <button class="btn btn-secondary" type="button" id="dropdownMenuButton_<?php echo $folder['id_folder']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent; border: none;">
                                        <i class="fas fa-ellipsis-v" style="color: black; background-color: transparent;"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton_<?php echo $folder['id_folder']; ?>">
                                        <a class="dropdown-item" href="#" data-folder-id="<?php echo $folder['id_folder']; ?>">
                                          <i class="fas fa-pen"></i> Editar cliente
                                        </a>
                                        <?php if ($_SESSION['user']['id_type_user'] == 1) { ?>
                                          <hr>
                                          <form action="folders.php" method="POST">
                                            <input name="delFolder[idFolder]" type="text" class="form-control form-control-sm" id="id_folder" value="<?php echo $folder['id_folder']; ?>" readonly hidden style="display: none;">
                                            <button class="dropdown-item" type="submit" name="action" value="delete" onclick="return confirm('¿Estás seguro de eliminar el cliente?');">
                                              <i class="fas fa-trash"></i> Mover a la papelera
                                            </button>
                                          </form>
                                        <?php } ?>
                                      </div>
                                    </div>
                                  <?php } ?>
                                </div>
                                
                                <div class="status-bar" style="text-align: right; padding-top: 5px; margin-right:10px;">
                                  <?php 
                                    if ($folder['dias'] === null) {
                                      echo '<span style="color: #0000FF; font-weight: bold; font-size:14px;">- - -</span>';
                                    } else if ($folder['dias'] >= 1) {
                                      echo '<span style="color: #FF0000; font-weight: bold; font-size:14px;">Cliente vencido <i class="fas fa-times"></i></span>';
                                    } else if ($folder['dias'] >= -60) {
                                      echo '<span style="color: #FFA500; font-weight: bold; font-size:14px;">Cerca de vencimiento <i class="fas fa-exclamation-triangle"></i></span>';
                                    } else {
                                      echo '<span style="color: #008000; font-weight: bold; font-size:14px;">Cliente vigente <i class="fas fa-check"></i></span>';
                                    }
                                  ?>
                                </div>
                                
                                <div class="status-bar-checks">
                                  <?php
                                    if($folder['chk_alta_fact_folder'] === "Si" || $folder['chk_lib_folder'] === 'Si' || $folder['chk_orig_recib_folder'] === 'Si'){
                                      if ($folder['chk_alta_fact_folder'] === "Si") {
                                        echo '<div class="status-item" data-toggle="tooltip" title="Vo. Bo. Alta Facturación"><span><i class="fas fa-file-alt"></i></span></div>';
                                      }
                                      if ($folder['chk_lib_folder'] === 'Si') {
                                        echo '<div class="status-item" data-toggle="tooltip" title="Vo. Bo. Liberación"><span><i class="fas fa-truck"></i></span></div>';
                                      }
                                      if ($folder['chk_orig_recib_folder'] === 'Si') {
                                        // Convertir la fecha al formato día, mes y año
                                        $fechaOriginal = new DateTime($folder['fech_orig_recib_folder']);
                                        $fechaFormateada = $fechaOriginal->format('d/m/Y');
                                        echo '<div class="status-item" data-toggle="tooltip" title="Original Recibido - ' . htmlspecialchars($fechaFormateada, ENT_QUOTES, 'UTF-8') . '"><span><i class="fas fa-user-check"></i></span></div>';
                                      }
                                    } else {
                                      echo '<div class="status-item"><span>- - -</span></div>';
                                    }
                                  ?>
                                </div>
                              
                              </div>
                            </div>&nbsp;
                          </div>
                        <?php endforeach; ?>

                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal para agregar una nueva carpeta -->
    <div class="modal fade" id="modalAgregarCarpeta" tabindex="-1" aria-labelledby="modalAgregarCarpetaLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalAgregarCarpetaLabel">Agregar nuevo cliente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Formulario para agregar una nueva carpeta -->
            <form id="formAgregarCarpeta" action="folders.php" method="POST">
              <input name="folder[id_user_folder]" type="text" class="form-control" id="id_user_folder" required value="<?php echo $_SESSION['user']['id_user']; ?>" readonly style="display:none;" hidden>
              <input name="folder[fk_folder]" type="text" class="form-control" id="fk_folder" required value="0" readonly style="display:none;" hidden>
              <input name="folder[key_folder]" type="text" class="form-control" id="key_folder" required value="CARP-<?php echo $clave; ?>" readonly style="display:none;" hidden>

              <div class="form-group">
                <label for="name_folder">Nombre del cliente:</label>
                <input type="text" name="folder[name_folder]" class="form-control" id="name_folder" required autocomplete="off">
              </div>

              <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1)-->
              <?php if($_SESSION['user']['id_type_user'] == 1){ ?>

                <div class="row">
                  <div class="col-12">
                    <label>Plazo de vigencia <small style="color:red;">(*Plazo opcional)</small></label>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                      <input type="date" class="form-control" name="folder[first_fech_folder]">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                      <input type="date" class="form-control" name="folder[second_fech_folder]">                  
                    </div>
                  </div>
                </div>
              
                <!-- Checkboxes organizados en dos filas -->
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="opcion1" value="Si" name="folder[chk_alta_fact_folder]">
                      <label class="form-check-label" for="opcion1">Vo.Bo. Alta Facturación</label>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="opcion2" value="Si" name="folder[chk_lib_folder]">
                      <label class="form-check-label" for="opcion2">Vo.Bo. Liberación</label>
                    </div>
                  </div>
                </div>
              
                <div class="row mt-2">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="opcion3" value="Si" name="folder[chk_orig_recib_folder]">
                      <label class="form-check-label" for="opcion3">Original Recibido</label>
                    </div>
                  </div>
                </div>
              
                <div id="fecha-original-recibido" class="form-group" style="margin-top:15px;">
                  <label>Fecha de original recibido:</label>
                  <input type="date" class="form-control" name="folder[fech_orig_recib_folder]">
                </div>
                
              <?php } ?>

              <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1)-->
              <?php if($_SESSION['user']['id_type_user'] == 1){ ?>
                <div class="form-group" style="margin-top:10px;">
                  <label for="id_customer_folder">Asesor comercial <small style="color:red;">(*Opcional)</small></label>
                  <select name="folder[id_customer_folder]" id="id_customer_folder" class="form-control selectAddCustomer">
                    <option value="">--</option>
                    <?php foreach($customersList as $key => $value){ ?>
                      <option value="<?php echo $value['id_user']; ?>">
                        <?php echo $value['name_user']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              <?php } else { ?>
                <div class="form-group" style="margin-top:10px;">
                  <input name="folder[id_customer_folder]" type="text" class="form-control" required value="<?php echo $_SESSION['user']['id_user']; ?>" readonly style="display:none;" hidden>
                </div>
              <?php } ?>
              
              <button type="submit" class="btn btn-lg btn-block" style="background-color: #37424A; color: #ffffff;" name="action" value="create">Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal para editar una carpeta -->
    <div class="modal fade" id="modalEditarCarpeta" tabindex="-1" aria-labelledby="modalEditarCarpetaLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditarCarpetaLabel">Editar cliente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body">
            <!-- Formulario para editar una carpeta -->
            <form id="formEditarCarpeta" action="folders.php" method="POST">
              <input type="hidden" name="updateFolder[id_folder]" id="edit_folder_id">
              <div class="form-group">
                <label for="edit_folder_name">Nombre del cliente:</label>
                <input type="text" name="updateFolder[name_folder]" class="form-control" id="edit_folder_name" required autocomplete="off">
              </div>

              <div class="row">
                <div class="col-12">
                  <label>Plazo de vigencia <small style="color:red;">(*Plazo opcional)</small></label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="form-group">
                    <input type="date" class="form-control" name="updateFolder[first_fech_folder]" id="edit_first_fech_folder">
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="form-group">
                    <input type="date" class="form-control" name="updateFolder[second_fech_folder]" id="edit_second_fech_folder">                  
                  </div>
                </div>
              </div>
              
              <!-- Checkboxes organizados en dos filas -->
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="edit_chk_alta_fact_folder" value="Si" name="updateFolder[chk_alta_fact_folder]">
                    <label class="form-check-label" for="edit_chk_alta_fact_folder">Vo.Bo. Alta Facturación</label>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="edit_chk_lib_folder" value="Si" name="updateFolder[chk_lib_folder]">
                    <label class="form-check-label" for="edit_chk_lib_folder">Vo.Bo. Liberación</label>
                  </div>
                </div>
              </div>
              
              <div class="row mt-2">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="edit_chk_orig_recib_folder" value="Si" name="updateFolder[chk_orig_recib_folder]">
                    <label class="form-check-label" for="edit_chk_orig_recib_folder">Original Recibido</label>
                  </div>
                </div>
              </div>
              
              <div id="edit-fecha-original-recibido" class="form-group" style="margin-top:15px;">
                <label for="edit_fech_orig_recib_folder">Fecha de original recibido:</label>
                <input type="date" class="form-control" name="updateFolder[fech_orig_recib_folder]" id="edit_fech_orig_recib_folder">
              </div>
              
              <div class="form-group" style="margin-top:10px;">
                <label for="edit_id_customer_folder">Asesor comercial <small style="color:red;">(*Opcional)</small></label>
                <select name="updateFolder[id_customer_folder]" id="edit_id_customer_folder" class="form-control selectEditCustomer">
                  <option value="">--</option>
                  <?php foreach($customersList as $key => $value){ ?>
                    <option value="<?php echo $value['id_user']; ?>">
                      <?php echo $value['name_user']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              
              <button type="submit" class="btn btn-lg btn-block" style="background-color: #37424A; color: #ffffff;" name="action" value="update">Actualizar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="../../resources/plugins/jquery/jquery.min.js"></script>
    <script src="../../resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../resources/dist/js/adminlte.min.js"></script>
    <script src="../../resources/plugins/select2/js/select2.full.min.js"></script>
    <script src="../../resources/js/notifications.js"></script>
    <script src="../../resources/js/tracings.js"></script>
    <script src="../../resources/js/notify_folders.js"></script>
    
    <script>
      $(document).ready(function(){
        $('.selectAddCustomer, .selectEditCustomer').select2({
          theme: 'bootstrap4'
        });
      });
    </script>
    
    <script>
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
          delay: { "show": 0, "hide": 0 } // Hacer que el tooltip aparezca y desaparezca inmediatamente
        });   
      });
    </script>
    
    <script>
      $(document).ready(function () {
        // Acción de clic en editar carpeta
        $('.dropdown-item[data-folder-id]').click(function (e) {
          e.preventDefault();
          var folderId = $(this).data('folder-id');
          // Obtener el nombre de la carpeta directamente de la consulta
          //var folderName = $(this).closest('.folder').find('.title').text().trim();
          $.ajax({
            type: "GET",
            url: "../../app/webservice.php",
            data: {
              action: "getFolderDetail",
              idFolder: folderId
            }
          }).done(function (response) {
            var parsedResponse = JSON.parse(response);
            //console.log(parsedResponse);
            // Llenar el formulario de edición con los datos de la carpeta
            $('#edit_folder_id').val(parsedResponse.id_folder);
            $('#edit_folder_name').val(parsedResponse.name_folder);
            $('#edit_first_fech_folder').val(parsedResponse.first_fech_folder);
            $('#edit_second_fech_folder').val(parsedResponse.second_fech_folder);
            // Marcar los checkboxes si el valor es "Si" o diferente de null
            $('#edit_chk_alta_fact_folder').prop('checked', parsedResponse.chk_alta_fact_folder === "Si");
            $('#edit_chk_lib_folder').prop('checked', parsedResponse.chk_lib_folder === "Si");
            $('#edit_chk_orig_recib_folder').prop('checked', parsedResponse.chk_orig_recib_folder === "Si");
            // Mostrar/ocultar el div y agregar/quitar el atributo required según el estado del checkbox de "Original Recibido"
            if (parsedResponse.chk_orig_recib_folder === "Si") {
              $('#edit-fecha-original-recibido').show();
              $('input[name="updateFolder[fech_orig_recib_folder]"]').attr('required', 'required').val(parsedResponse.fech_orig_recib_folder);
            } else {
              $('#edit-fecha-original-recibido').hide();
              $('input[name="updateFolder[fech_orig_recib_folder]"]').removeAttr('required').val('');
            }
            
            // Configurar el select del asesor comercial usando Select2
            var idCustomerFolder = parsedResponse.id_customer_folder;
            if (idCustomerFolder && idCustomerFolder !== "0") {
              $('#edit_id_customer_folder').val(idCustomerFolder).trigger('change'); // Actualiza Select2
            } else {
              $('#edit_id_customer_folder').val("").trigger('change'); // Limpia la selección
            }

            // SI ES UN SELECT NORMAL QUEDA DE LA SIGUIENTE FORMA SIN EL TRIGGER, SI ES CON Select2 se usa la forma de arriba
            /*
            if (idCustomerFolder && idCustomerFolder !== "0") {
              $('#edit_id_customer_folder').val(idCustomerFolder); // Seleccionar la opción correspondiente
            } else {
              $('#edit_id_customer_folder').val(""); // Dejar sin selección
            }
            */

            // Mostrar el modal de edición de carpetas
            $('#modalEditarCarpeta').modal('show');
          });
        });
        
        // Acción de búsqueda de carpetas
        $("#searchInputFolders").on("keyup", function() {
          var searchText = $(this).val().toLowerCase();
          $("#myFolders .title-bar").each(function() {
            var titleText = $(this).find('.title').text().toLowerCase();
            var documentContainer = $(this).closest(".col-lg-3");
            if (titleText.indexOf(searchText) === -1) {
              documentContainer.hide();
            } else {
              documentContainer.show();
            }
          });
        });
      });
    </script>
    
  </body>
</html>