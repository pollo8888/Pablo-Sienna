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
  
  // COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMIN (1)
  if($_SESSION['user']['id_type_user'] != 1) { // Comprueba si el tipo de usuario almacenado en la sesión no es igual a 1 (tipo de usuario "admin")
    header('location: ../../index.php'); // Redirecciona a la página "index.php" si el usuario no es de tipo administrador
  }
  
  //ACCIÓN PARA ELIMINAR USUARIOS
  // Comprueba si se ha enviado alguna acción a través del método POST
  if(!empty($_POST['action'])){
    // Comprueba si la acción es eliminar
    if($_POST['action'] == 'delete'){
      // Obtiene el ID del usuario a eliminar desde el formulario
      $userId = $controller->deleteUser($_POST['empl']);
      // Si se pudo eliminar correctamente el usuario
      if($userId){
        // Redirige al usuario a la página de usuarios después de eliminar
        header('location: users.php');
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
    <link rel="icon" href="../../resources/img/icono.png">
    <script src="../../resources/js/jquery-3.5.1.min.js"></script>
    <style>
      /* Ocultar las flechas de ordenamiento en la primera columna */
      #tblUsers th:first-child {
        cursor: default;
      }
      /* Forzar la eliminación de las flechas que quedan */
      #tblUsers th:first-child::before,
      #tblUsers th:first-child::after {
        content: none !important;
      }
    </style>
  </head>
  
  <body class="hold-transition sidebar-mini">
    <div class="wrapper" style="padding-top: 57px;">
      <?php include "../templates/navbar.php"; ?>
      
        <div class="content-wrapper">
          <div class="content-header">
            <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1)-->
            <?php if($_SESSION['user']['id_type_user'] == 1){ ?>
              <div class="container-fluid">
                <div class="row justify-content-between mb-2">
                  <div class="col-sm-8">
                    <h1 class="m-0 text-dark">Lista completa de usuarios</h1>
                  </div>
                  <div class="col-sm-4 text-right">
                    <a href="create-user.php" class="btn btn-block" style="background-color: #FF5800; color: #ffffff;" role="button" aria-pressed="true"><i class="fas fa-plus pr-2"></i>Agregar nuevo usuario</a>
                  </div>
                </div>
                <hr>
                
                <!--FILTRO DE BUSQUEDA DE ESTATUS DE LOS EMPLEADOS (1->Activo / 2 Inactivo)-->
                <form class="row mb-2" action="#" method="get">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="input-group col-sm-6 col-md-4">
                        <select id="statusDDL" name="status" class="form-control form-control filtrosDDL">
                          <option value="1">Usuarios Activos</option>
                          <option value="2">Usuarios Inactivos</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </form>
              
              </div>
            <?php } ?>
          </div>
          
          <div class="content">
            <div class="container-fluid">
              <strong>Total de usuarios: &nbsp;<b id="numTotalsUsers"></b></strong>
              
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered" id="tblUsers">
                          <thead>
                            <th></th>
                            <th>Fotografía</th>
                            <!--<th>RFC</th>-->
                            <th>Nombre</th>
                            <th>Correo electrónico</th>
                            <th>Tipo</th>
                            <th>Fecha de registro</th>
                            <th>Acciones</th>
                          </thead>
                          <tbody id="dataUsers"></tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
    <script src="../../resources/plugins/datatables/jquery.dataTables.js"></script>
    <script src="../../resources/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="../../resources/dist/js/adminlte.min.js"></script>
    <script src="../../resources/js/notifications.js"></script>
    <script src="../../resources/js/tracings.js"></script>
    <script src="../../resources/js/notify_folders.js"></script>
    <script>
      // Asignar valores de la variable de sesión a variables JavaScript
      var userId = <?php echo json_encode($_SESSION['user']['id_user']); ?>;
    </script>

    <script>
      $(function () {
        loadUsers(1);
      });
      $(document).ready(function(){
        $('.filtrosDDL').on('change', function() {
          var statusSelect = $("#statusDDL").val();
          loadUsers(statusSelect);
        });
      });
      function loadUsers(statusSelect) {
        var table = $('#tblUsers').DataTable({
          language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
              "first": "Primero",
              "last": "Ultimo",
              "next": "Siguiente",
              "previous": "Anterior"
            }
          },
          "columnDefs": [
            { "targets": 0, "orderable": false }, // Deshabilitar orden en la primera columna
            { "targets": 1, "orderable": false }, // Deshabilitar orden en la segunda columna
            { "targets": 4, "orderable": false }, // Deshabilitar orden en la quinta columna
            { "targets": 6, "orderable": false }  // Deshabilitar orden en la septima columna
          ],
          "destroy": true
        });
        //var table = $('#tblUsers').DataTable();
        table.clear().draw();
        
        $.ajax({
          type: "GET",
          url: "../../app/webservice.php",
          data: { 
            action: "getUsers",
            status: statusSelect
          }
        }).done(function(response) {
          var parsedResponse = JSON.parse(response);
          $("#numTotalsUsers").html(parsedResponse.length);
          $("#dataUsers").empty();
          parsedResponse.forEach(function(item) {
            var date = new Date(item.created_at_user);
            // Obtener componentes de la fecha
            var day = ("0" + date.getDate()).slice(-2); // Día con dos dígitos
            var month = ("0" + (date.getMonth() + 1)).slice(-2); // Mes con dos dígitos
            var year = date.getFullYear();
            var hours = ("0" + date.getHours()).slice(-2); // Horas con dos dígitos
            var minutes = ("0" + date.getMinutes()).slice(-2); // Minutos con dos dígitos
            var seconds = ("0" + date.getSeconds()).slice(-2); // Segundos con dos dígitos
            // Formatear la fecha como "d/m/Y h:i:s"
            var formattedDate = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
            
            var actionsLink = '';
            //COMPROBAMOS QUE EL TIPO DE USUARIO SEA DIFERENTE PARA QUITAR LOS BOTONES DE EDITAR Y ELIMINAR DE LA VISTA
            if (userId != item.id_user) {
              actionsLink = "<a href='update-user.php?id=" + item.id_user + "&key=" + item.key_user + "' class='btn btn-sm btn-primary'><i class='fas fa-pen'></i></a>" + 
              "<form action='users.php' method='POST'>" +
                "<input name='empl[idUser]' type='text' class='form-control form-control-sm' id='id_user' value='" + item.id_user + "' readonly hidden>" +
                "<input name='empl[keyUser]' type='text' class='form-control form-control-sm' id='key_user' value='" + item.key_user + "' readonly hidden>" +
                "<button class='btn btn-raised btn-danger btn-sm' name='action' value='delete' onclick='if(!confirm(\"¿Estas seguro de eliminar el usuario?\")) return false;'><i class='fas fa-trash'></i></button>" +
              "</form>";
            }
            
            var newRow =
            "<tr>" +
              "<td style='text-align:center;'><a href='detail-user.php?id=" + item.id_user + "&key=" + item.key_user + "' class='btn btn-sm btn-success'><i class='fas fa-eye'></i></a></td>" +
              "<td style='text-align:center;'>" +
                (item.photo_user != null ?
                  "<img width='70' height='70' style='border-radius: 50%; object-fit: cover;' src='../../uploads/users/" + item.photo_user + "'>" :
                  //"<img width='70' height='70' style='border-radius: 50%; object-fit: cover; border: 1px solid black;' src='../../uploads/users/sin-foto.jpeg'><p style='color: red; font-weight:bold; font-size:13px;'>Sin foto de perfil</p>"
                  "<img width='70' height='70' style='border-radius: 50%; object-fit: cover;' src='../../uploads/users/sin-foto.jpeg'>"
                ) +
              "</td>" +
              // "<td style='text-align:center;'>" + item.rfc_user + "</td>" +
              "<td style='text-align:center;'>" + item.name_user + "</td>" +
              "<td style='text-align:center;'>" + item.email_user + "</td>" +
              "<td style='text-align:center;'>" + item.name_type + "</td>" +
              "<td style='text-align:center;'>" + formattedDate + "</td>" +
              "<td style='text-align:center;'>" + actionsLink + "</td>" + 
            "</tr>";
            // Agregar la nueva fila al cuerpo de la tabla
            table.row.add($(newRow)[0]);
          });
          // Redibujar la tabla después de agregar nuevas filas
          table.draw();
        });
      }
    </script>
  </body>
</html>