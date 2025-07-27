<?php
  session_start();
  include "app/config.php";
  //include "app/debug.php";
  include "app/WebController.php";
  
  // Inicializar la variable de mensaje
  $mssg = '';
  
  // Verificar si el usuario ya está autenticado
  if (!empty($_SESSION['user']['login'])) {
    header("location: index.php");
    exit();
  }
  
  // Verificar si se envió el formulario
  if (!empty($_POST)) {
    if (!empty($_POST['email_user']) && !empty($_POST['password_user'])) {
      // Validar credenciales
      $controller = new WebController();
      $user = $controller->loginUser($_POST['email_user'], $_POST['password_user']);
      if ($user) {
        // Almacenar información de usuario en la sesión
        $_SESSION['user']['login'] = true;
        $_SESSION['user']['id_user'] = $user['id_user'];
        $_SESSION['user']['id_type_user'] = $user['id_type_user'];
        $_SESSION['user']['key_user'] = $user['key_user'];
        $_SESSION['user']['name_user'] = $user['name_user'];
        $_SESSION['user']['status_user'] = $user['status_user'];
        // Redirigir al usuario autenticado
        header('location: index.php');
        exit();
      } else {
        $mssg = "El correo electrónico o contraseña es inválida. Verifícala antes de volver a intentarlo";
      }
    } else {
      $mssg = "Ingresa un password";
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
    <link rel="stylesheet" href="resources/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="resources/css/micromodal.css">
    <link rel="stylesheet" type="text/css" href="resources/css/login.css">
    <link rel="icon" href="resources/img/icono.png">
    <style>
      p {
        font-size: 15px;
        font-family: 'Arial', sans-serif;
        color: #333;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        padding: 5px;
        margin-bottom: 0px;
      }
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
      
      /* Estilo para el botón flotante */
      .floating-button {
        position: fixed;
        bottom: 20px; /* Distancia desde la parte inferior */
        left: 20px; /* Distancia desde la parte izquierda */
        z-index: 1000; /* Asegura que esté por encima de todo */
        background-color: transparent;
        border: none;
        cursor: pointer;
        outline: none; /* Elimina el contorno al hacer clic */
      }
      .floating-button img {
        width: 50px; /* Tamaño del ícono */
        height: 50px;
        border-radius: 50%;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }
      .floating-button img:hover {
        transform: scale(1.1); /* Efecto al pasar el mouse */
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3);
      }
      .floating-btn:focus {
        outline: none !important;
      }
      
      /*ESTILO PARA QUITAR EL CONTORNO DE LA IMAGEN AL DAR CLIC*/
      .floating-button:focus,
      .floating-button img:focus {
        outline: none;
        box-shadow: none; /* Elimina cualquier sombra añadida */
      }
      
      .logo-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
      }
      .logo-sienna {
        margin-top: -50px; /* Espaciado del texto "Por" hacia la imagen */
      }
    </style>
  </head>
  
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <h5 class="card-title text-center">
                <img width="85%" src="resources/img/logo.png">
              </h5>
              <div class="text-center logo-container">
                <a href="https://siennadocs.args.mx/siennadocswebsite/" target="_blank">  
                  <img class="logo-sienna" width="35%" src="resources/img/logo-sienna.png">
                </a>
              </div>
              <form class="form-signin" action="#" method="post">
                <div class="form-label-group">
                  <input name="email_user" type="email" id="email_user" class="form-control" placeholder="Usuario" required value="<?php echo isset($_POST['email_user']) ? htmlspecialchars($_POST['email_user']) : ''; ?>">
                  <label for="email_user">Correo electrónico</label>
                </div>
                <div class="form-label-group">
                  <input name="password_user" type="password" id="password_user" class="form-control" placeholder="Contraseña" required value="<?php echo isset($_POST['password_user']) ? htmlspecialchars($_POST['password_user']) : ''; ?>">
                  <label for="password_user">Contraseña</label>
                  <span class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye" style="display: none;"></i>
                    <i class="fas fa-eye-slash"></i>
                  </span>
                </div>
                <hr class="my-4">
                <button class="btn btn-lg btn-block text-uppercase" type="submit">Entrar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
      <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
          <header class="modal__header">
            <h2 class="modal__title" id="modal-1-title">
              <i class="fas fa-info-circle"></i> Aviso
            </h2>
            <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
          </header>
          <main class="modal__content" id="modal-1-content">
            <p><?php echo $mssg; ?></p>
          </main>
          <footer class="modal__footer">
            <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Cerrar</button>
          </footer>
        </div>
      </div>
    </div>

    <!-- Botón flotante -->
    <button class="floating-button" onclick="window.open('https://siennadocs.args.mx/siennadocswebsite/', '_blank')">
      <img src="resources/img/s-sienna.png" alt="SiennaDocs">
    </button>
    
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="resources/js/micromodal.min.js"></script>
    
    <script>
      function togglePassword() {
        var passwordField = document.getElementById('password_user');
        var eyeIconOpen = document.querySelector('.fa-eye');
        var eyeIconClosed = document.querySelector('.fa-eye-slash');
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
      $(document).ready(function(){
        MicroModal.init({
          openTrigger: 'data-custom-open',
          closeTrigger: 'data-custom-close',
          disableScroll: true,
          disableFocus: false,
          awaitCloseAnimation: false,
          debugMode: true
        });
        <?php if ($mssg)  { echo "MicroModal.show('modal-1');"; }?>
      });
    </script>
  </body>
</html>