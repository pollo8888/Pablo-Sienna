<?php
session_start();
include "../../app/config.php";
//include "../../app/debug.php";
include "../../app/WebController.php";
include "../../app/ExcelController.php";
require '../../vendor/autoload.php';
$controller = new WebController();

// Verificar si la sesión del usuario está activa
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    // Si no hay sesión activa, destruir la sesión
    session_destroy();
    // Redirigir a la página de inicio de sesión
    header("Location: ../../login.php");
    exit(); // Es importante salir después de redirigir para evitar que el código siguiente se ejecute innecesariamente
}

// Verificar que solo administradores puedan acceder
if ($_SESSION['user']['id_type_user'] != 1) {
    header("Location: ../../index.php");
    exit();
}

// Obtener la lista de los usuarios del departamento de ventas y que estén activos (3 -> Tipo de Usuario Ventas, 1 -> Activos)
$customersList = $controller->getCustomersList(3, 1);

// FUNCIÓN PARA CREAR UNA NUEVA OPERACIÓN VULNERABLE
// Verifica si se ha dado clic en algún botón a través del action
if (!empty($_POST['action'])) {
    // Si la acción es 'createOperation', se intenta crear una operación nueva
    if ($_POST['action'] == 'createOperation') {
        // Aquí iría la lógica para crear una nueva operación
        // $operationId = $controller->createOperation($_POST['operation']);
        // if ($operationId) {
        //     header('location: vulnerabilities.php');
        // }
    }
    // Si la acción es 'deleteOperation', se intenta eliminar una operación existente
    else if ($_POST['action'] == 'deleteOperation') {
        // Aquí iría la lógica para eliminar la operación
        // $idOperation = $controller->deleteOperation($_POST['delOperation']);
        // if ($idOperation) {
        //     header('location: vulnerabilities.php');
        // }
    }
    // Si la acción es 'reportOperations', se intenta generar un reporte
    else if ($_POST['action'] == 'reportOperations') {
        $excelController = new ExcelController();
        $statusSelect = $_POST['statusSelect'];
        $customerSelect = $_POST['customerSelect'];
        
        // Verificar si se ha seleccionado el filtro de 'Año y Mes'
        if (isset($_POST['check']) && $_POST['check'] == 1) {
            $year_select = $_POST['year_select'];
            $monthSelect = $_POST['monthSelect'];
            
            if ($monthSelect == 'all') {
                $fecha1 = $year_select . "-01-01 00:00:00";
                $fecha2 = $year_select . "-12-31 23:59:59";
            } else {
                $fecha1 = $year_select . "-" . $monthSelect . "-01 00:00:00";
                $fecha2 = $year_select . "-" . $monthSelect . "-31 23:59:59";
            }
        }
        // Verificar si se han establecido las fechas de inicio y fin directamente
        elseif (isset($_POST['startFetch']) && isset($_POST['finishFetch'])) {
            $startFetch = $_POST['startFetch'];
            $finishFetch = $_POST['finishFetch'];
            $fecha1 = $startFetch . " 00:00:00";
            $fecha2 = $finishFetch . " 23:59:59";
        } else {
            $fecha1 = null;
            $fecha2 = null;
        }
        
        // Aquí iría la lógica para filtrar operaciones
        // $filterOperations = $controller->ws_getOperations($fecha1, $fecha2, $statusSelect, $customerSelect);
        // if (!empty($filterOperations)) {
        //     $mssg = null;
        //     $excelController->reportOperations($filterOperations);
        // } else {
        //     $mssg = "¡NO HAY INFORMACIÓN DE OPERACIONES PARA GENERAR EL REPORTE!";
        // }
    }
}

// FUNCIÓN PARA GENERAR UNA CLAVE PARA LA OPERACIÓN
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
    <title>FULTRA MX</title>
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
    <style>
        /* Estilos para los semáforos */
        .semaforo-verde { color: #28a745; font-size: 1.2rem; }
        .semaforo-amarillo { color: #ffc107; font-size: 1.2rem; }
        .semaforo-rojo { color: #dc3545; font-size: 1.2rem; }
        
        /* Estilo para pestañas tipo Google */
        .google-tabs {
            display: flex;
            border-bottom: 1px solid #dadce0;
            margin-bottom: 0;
            background-color: #ffffff;
            padding: 0;
        }
        
        .google-tab {
            background: none;
            border: none;
            padding: 12px 24px;
            color: #5f6368;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            position: relative;
            border-radius: 8px 8px 0 0;
            margin-right: 4px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .google-tab:hover {
            background-color: #f8f9fa;
            color: #202124;
        }
        
        .google-tab.active {
            color: #1a73e8;
            background-color: #ffffff;
            border-bottom: 2px solid #1a73e8;
        }
        
        .google-tab i {
            font-size: 16px;
        }
        
        /* Estilos para la tabla */
        .custom-table-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            margin: 0;
        }
        
        .custom-table thead th {
            background-color: #ffffff;
            color: #202124;
            font-weight: bold;
            text-align: center;
            padding: 16px 12px;
            border-bottom: 2px solid #e8eaed;
            font-size: 14px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .custom-table tbody td {
            padding: 12px;
            border-bottom: 1px solid #e8eaed;
            font-size: 14px;
            vertical-align: middle;
        }
        
        .custom-table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        /* Estilos para campos clickeables */
        .clickeable-field {
            cursor: pointer;
            text-decoration: underline;
            color: #1a73e8;
        }
        
        .clickeable-field:hover {
            color: #1557b0;
        }
        
        /* Indicador de información faltante */
        .missing-info {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .missing-info::after {
            content: '';
            width: 8px;
            height: 8px;
            background-color: #ff9500;
            border-radius: 50%;
            display: inline-block;
        }
        
        /* Estilos para el buscador */
        .search-container {
            padding: 16px;
            background-color: #ffffff;
            border-bottom: 1px solid #e8eaed;
        }
        
        .search-input {
            width: 100%;
            max-width: 400px;
            padding: 10px 16px;
            border: 1px solid #dadce0;
            border-radius: 24px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s ease;
        }
        
        .search-input:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
        }
        
        /* Contador de operaciones */
        .operations-counter {
            padding: 16px;
            background-color: #ffffff;
            font-weight: 500;
            color: #202124;
            border-bottom: 1px solid #e8eaed;
        }
        
        /* Ocultar contenedores de tabla */
        .tabla-container {
            display: none;
        }
        .tabla-container.active {
            display: block;
        }
        
        /* Estilos responsive */
        @media (max-width: 768px) {
            .google-tabs {
                flex-wrap: wrap;
                padding: 0 8px;
            }
            
            .google-tab {
                font-size: 12px;
                padding: 10px 16px;
            }
            
            .custom-table {
                font-size: 12px;
            }
            
            .custom-table thead th,
            .custom-table tbody td {
                padding: 8px;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" style="padding-top: 57px;">
        <?php include "../templates/navbar.php"; ?>
        
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row justify-content-between mb-2">
                        <div class="col-lg-6 col-sm-6">
                            <h1 class="m-0 text-dark">Operaciones Vulnerables</h1>
                        </div>
                        
                        <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1) -->
                        <?php if ($_SESSION['user']['id_type_user'] == 1) { ?>
                            <div class="col-sm-4 text-right">
                                <!-- Botón para abrir el modal -->
                                <a href="#" class="btn btn-block" style="background-color: #FF5800; color: #ffffff;" role="button" aria-pressed="true" data-toggle="modal" data-target="#modalAgregarOperacion">
                                    <i class="fas fa-plus pr-2"></i>Registrar nueva operación
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <hr>
                    
                    <!-- FILTROS DE BUSQUEDA DE OPERACIONES POR INTERVALO DE FECHAS, POR ESTATUS Y POR ASESOR COMERCIAL -->
                    <form class="row mb-3" action="vulnerabilities.php" method="post">
                        <div class="col-lg-10 col-sm-12">
                            <strong>Filtro de fecha de operación</strong>
                            
                            <div class="row">
                                <div class="input-group col-lg-2">
                                    <select class="form-control filtrosDDL" id="yearSelect" name="year_select">
                                        <!-- Se llenará dinámicamente con JavaScript -->
                                    </select>
                                </div>
                                
                                <div class="input-group col-lg-3">
                                    <select class="form-control filtrosDDL" id="month_select" name="monthSelect">
                                        <option value="all">Todos los meses</option>
                                        <option value="01">Enero</option>
                                        <option value="02">Febrero</option>
                                        <option value="03">Marzo</option>
                                        <option value="04">Abril</option>
                                        <option value="05">Mayo</option>
                                        <option value="06">Junio</option>
                                        <option value="07">Julio</option>
                                        <option value="08">Agosto</option>
                                        <option value="09">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                </div>
                                
                                <div class="input-group col-lg-3">
                                    <select class="form-control filtrosDDL" id="status_select" name="statusSelect">
                                        <option value="all">Todos los riesgos</option>
                                        <option value="verde">Bajo Riesgo</option>
                                        <option value="amarillo">Riesgo Medio</option>
                                        <option value="rojo">Alto Riesgo</option>
                                    </select>
                                </div>
                                
                                <div class="input-group col-lg-4">
                                    <select class="form-control filtrosDDL" id="customer_select" name="customerSelect">
                                        <option value="">Todas las empresas</option>
                                        <?php if (!empty($customersList)) { 
                                            foreach ($customersList as $customer) { ?>
                                            <option value="<?php echo $customer['id_user']; ?>"><?php echo $customer['name_user']; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!--BOTÓN PARA GENERAR EL REPORTE DE OPERACIONES-->
                        <div class="col-lg-2 col-sm-12">
                            <button name="action" value="reportOperations" type="submit" class="btn btn-md btn-outline-success float-sm-right"> 
                                <i class="fas fa-file-alt mr-1"></i> Generar reporte
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!--CONSULTA GENERAL DE TODAS LAS OPERACIONES-->
            <div class="content">
                <div class="container-fluid">
                    
                    <!-- Pestañas estilo Google -->
                    <div class="google-tabs">
                        <button type="button" class="google-tab active" id="btn-personas-fisicas" onclick="cambiarTab('personas-fisicas')">
                            <i class="fas fa-user"></i>Personas Físicas
                        </button>
                        <button type="button" class="google-tab" id="btn-personas-morales" onclick="cambiarTab('personas-morales')">
                            <i class="fas fa-building"></i>Personas Morales
                        </button>
                        <button type="button" class="google-tab" id="btn-fideicomisos" onclick="cambiarTab('fideicomisos')">
                            <i class="fas fa-handshake"></i>Fideicomisos
                        </button>
                    </div>
                    
                    <div class="custom-table-container">
                        <!-- Contador de operaciones -->
                        <div class="operations-counter">
                            <strong>Total de operaciones: <span id="totalOperaciones">0</span></strong>
                        </div>
                        
                        <!-- Buscador -->
                        <div class="search-container">
                            <input type="text" class="search-input" id="searchInputOperations" placeholder="Buscar operación...">
                        </div>
                        
                        <!-- Tabla Personas Físicas -->
                        <div id="tabla-personas-fisicas" class="tabla-container active">
                            <table class="custom-table" id="tblPersonasFisicas">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Empresa</th>
                                        <th>Cliente</th>
                                        <th>Fecha Operación</th>
                                        <th>Tipo Propiedad</th>
                                        <th>Folio Escritura</th>
                                        <th>Código Postal</th>
                                        <th>Semáforo</th>
                                        <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1) -->
                                        <?php if ($_SESSION['user']['id_type_user'] == 1) { ?>
                                            <th>Acciones</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody id="dataPersonasFisicas"></tbody>
                            </table>
                        </div>
                        
                        <!-- Tabla Personas Morales -->
                        <div id="tabla-personas-morales" class="tabla-container">
                            <table class="custom-table" id="tblPersonasMorales">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Empresa</th>
                                        <th>Cliente</th>
                                        <th>Fecha Operación</th>
                                        <th>Tipo Propiedad</th>
                                        <th>Folio Escritura</th>
                                        <th>Código Postal</th>
                                        <th>Semáforo</th>
                                        <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1) -->
                                        <?php if ($_SESSION['user']['id_type_user'] == 1) { ?>
                                            <th>Acciones</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody id="dataPersonasMorales"></tbody>
                            </table>
                        </div>
                        
                        <!-- Tabla Fideicomisos -->
                        <div id="tabla-fideicomisos" class="tabla-container">
                            <table class="custom-table" id="tblFideicomisos">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Empresa</th>
                                        <th>Cliente</th>
                                        <th>Fecha Operación</th>
                                        <th>Tipo Propiedad</th>
                                        <th>Folio Escritura</th>
                                        <th>Código Postal</th>
                                        <th>Semáforo</th>
                                        <!-- COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1) -->
                                        <?php if ($_SESSION['user']['id_type_user'] == 1) { ?>
                                            <th>Acciones</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody id="dataFideicomisos"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal para agregar nueva operación -->
        <div class="modal fade" id="modalAgregarOperacion" tabindex="-1" aria-labelledby="modalAgregarOperacionLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarOperacionLabel">Registrar nueva operación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <!-- Formulario para agregar una nueva operación -->
                        <form id="formAgregarOperacion" action="vulnerabilities.php" method="POST">
                            <input name="operation[key_operation]" type="text" class="form-control" id="key_operation" required value="<?php echo $clave; ?>" readonly style="display:none;" hidden>
                            
                            <div class="form-group">
                                <label for="empresa">Empresa</label>
                                <input name="operation[empresa]" type="text" class="form-control" id="empresa" placeholder="Nombre de la empresa" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="tipoCliente">Tipo de Cliente</label>
                                <select name="operation[tipo_cliente]" class="form-control" id="tipoCliente" required>
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="Persona Física">Persona Física</option>
                                    <option value="Persona Moral">Persona Moral</option>
                                    <option value="Fideicomiso">Fideicomiso</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="cliente">Cliente</label>
                                <input name="operation[cliente]" type="text" class="form-control" id="cliente" placeholder="Nombre del cliente" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="fechaOperacion">Fecha de Operación</label>
                                <input name="operation[fecha_operacion]" type="date" class="form-control" id="fechaOperacion" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="tipoPropiedad">Tipo de Propiedad</label>
                                <select name="operation[tipo_propiedad]" class="form-control" id="tipoPropiedad" required>
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="Casa Residencial">Casa Residencial</option>
                                    <option value="Departamento">Departamento</option>
                                    <option value="Terreno">Terreno</option>
                                    <option value="Local Comercial">Local Comercial</option>
                                    <option value="Oficina">Oficina</option>
                                    <option value="Bodega">Bodega</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="folioEscritura">Folio de Escritura</label>
                                <input name="operation[folio_escritura]" type="text" class="form-control" id="folioEscritura" placeholder="Folio de escritura" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="codigoPostal">Código Postal</label>
                                <input name="operation[codigo_postal]" type="text" class="form-control" id="codigoPostal" placeholder="Código postal" maxlength="5" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="semaforo">Estado de Riesgo</label>
                                <select name="operation[semaforo]" class="form-control" id="semaforo" required>
                                    <option value="">Seleccionar estado...</option>
                                    <option value="verde">Bajo Riesgo (Verde)</option>
                                    <option value="amarillo">Riesgo Medio (Amarillo)</option>
                                    <option value="rojo">Alto Riesgo (Rojo)</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-lg btn-block" style="background-color: #37424A; color: #ffffff;" name="action" value="createOperation">Guardar operación</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../resources/plugins/jquery/jquery.min.js"></script>
    <script src="../../resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../resources/plugins/datatables/jquery.dataTables.js"></script>
    <script src="../../resources/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="../../resources/dist/js/adminlte.min.js"></script>
    <script src="../../resources/js/notifications.js"></script>
    <script src="../../resources/js/tracings.js"></script>
    <script src="../../resources/js/notify_folders.js"></script>
    
    <script>
        // Datos simulados para las operaciones vulnerables con fechas más variadas para testing
        var operacionesData = {
            "personas-fisicas": [
                {
                    id: 1,
                    empresa: "Inmobiliaria del Centro",
                    cliente: "Juan Pérez González",
                    fecha_operacion: "2024-01-15",
                    tipo_propiedad: "Casa Residencial",
                    folio_escritura: "ESC-2024-001",
                    codigo_postal: "29000",
                    semaforo: "verde",
                    empresa_missing_info: false, // Tiene toda la información completa
                    cliente_missing_info: true   // Le falta domicilio o teléfono
                },
                {
                    id: 2,
                    empresa: "Bienes Raíces Premium",
                    cliente: "María Elena Rodríguez",
                    fecha_operacion: "2024-07-08",
                    tipo_propiedad: "Departamento",
                    folio_escritura: "ESC-2024-002",
                    codigo_postal: "29040",
                    semaforo: "amarillo",
                    empresa_missing_info: true,  // Le falta dirección de la empresa
                    cliente_missing_info: false
                },
                {
                    id: 3,
                    empresa: "Propiedades del Sur",
                    cliente: "Carlos Alberto Mendoza",
                    fecha_operacion: "2025-03-22",
                    tipo_propiedad: "Terreno Comercial",
                    folio_escritura: "ESC-2024-003",
                    codigo_postal: "29050",
                    semaforo: "rojo",
                    empresa_missing_info: false,
                    cliente_missing_info: false
                },
                {
                    id: 8,
                    empresa: "Bienes Raíces Premium",
                    cliente: "Ana García López",
                    fecha_operacion: "2025-07-15",
                    tipo_propiedad: "Casa",
                    folio_escritura: "ESC-2025-008",
                    codigo_postal: "29070",
                    semaforo: "verde",
                    empresa_missing_info: true,  // Le faltan datos fiscales
                    cliente_missing_info: true   // Le falta número de teléfono
                }
            ],
            "personas-morales": [
                {
                    id: 4,
                    empresa: "Desarrollos Inmobiliarios SA",
                    cliente: "Constructora del Pacífico SA de CV",
                    fecha_operacion: "2024-01-20",
                    tipo_propiedad: "Complejo Comercial",
                    folio_escritura: "ESC-2024-004",
                    codigo_postal: "29030",
                    semaforo: "amarillo",
                    empresa_missing_info: false,
                    cliente_missing_info: true  // Le falta RFC o representante legal
                },
                {
                    id: 5,
                    empresa: "Inmobiliaria Chiapas",
                    cliente: "Desarrollos Chiapas SC",
                    fecha_operacion: "2025-07-14",
                    tipo_propiedad: "Torre Corporativa",
                    folio_escritura: "ESC-2024-005",
                    codigo_postal: "29020",
                    semaforo: "verde",
                    empresa_missing_info: true,  // Le falta información de contacto
                    cliente_missing_info: false
                }
            ],
            "fideicomisos": [
                {
                    id: 6,
                    empresa: "Fideicomiso Inmobiliario",
                    cliente: "Fideicomiso Desarrollo Habitacional",
                    fecha_operacion: "2024-01-10",
                    tipo_propiedad: "Fraccionamiento Residencial",
                    folio_escritura: "ESC-2024-006",
                    codigo_postal: "29010",
                    semaforo: "verde",
                    empresa_missing_info: false,
                    cliente_missing_info: true  // Le falta información del fideicomitente
                },
                {
                    id: 7,
                    empresa: "Trust Inmobiliario",
                    cliente: "Fideicomiso Inversión Inmobiliaria",
                    fecha_operacion: "2025-07-05",
                    tipo_propiedad: "Centro Comercial",
                    folio_escritura: "ESC-2024-007",
                    codigo_postal: "29060",
                    semaforo: "amarillo",
                    empresa_missing_info: false,
                    cliente_missing_info: false
                }
            ]
        };
        
        // Variable para saber qué pestaña está activa
        var tabActiva = "personas-fisicas";
        var userType = <?php echo $_SESSION['user']['id_type_user']; ?>;
        
        $(document).ready(function(){
            // Cargar la primera tabla por defecto
            cargarTabla('personas-fisicas');
            
            // Funcionalidad del buscador
            $('#searchInputOperations').on('keyup', function() {
                var searchValue = this.value.toLowerCase();
                $('.tabla-container.active tbody tr').each(function() {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchValue) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
            
            // Validación de código postal (solo números)
            $('#codigoPostal').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            
            // Funcionalidad de los filtros
            $('.filtrosDDL').on('change', function() {
                aplicarFiltros();
            });
        });
        
        // Función para generar el select de años
        function generarAnios() {
            var yearSelect = document.getElementById("yearSelect");
            var currentYear = new Date().getFullYear();
            var endYear = currentYear + 5;
            
            for (var year = 2020; year <= endYear; year++) {
                var option = document.createElement("option");
                option.value = year;
                option.text = year;
                yearSelect.appendChild(option);
                
                if (year === currentYear) {
                    option.selected = true;
                }
            }
        }
        
        // Función para establecer el mes actual
        function establecerMesActual() {
            var monthSelect = document.getElementById('month_select');
            var currentMonth = new Date().getMonth() + 1;
            var formattedMonth = currentMonth < 10 ? '0' + currentMonth : currentMonth.toString();
            monthSelect.value = formattedMonth;
        }
        
        // Inicializar los selectores al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            generarAnios();
            establecerMesActual();
        });
        
        // Función para aplicar filtros
        function aplicarFiltros() {
            var yearSelect = $("#yearSelect").val();
            var monthSelect = $("#month_select").val();
            var statusSelect = $("#status_select").val();
            var customerSelect = $("#customer_select").val();
            
            // Crear rango de fechas basado en año y mes
            var fecha1, fecha2;
            if (monthSelect === 'all') {
                fecha1 = yearSelect + "-01-01";
                fecha2 = yearSelect + "-12-31";
            } else {
                fecha1 = yearSelect + "-" + monthSelect + "-01";
                fecha2 = yearSelect + "-" + monthSelect + "-31";
            }
            
            // Filtrar datos para cada categoría
            var datosFiltrados = {};
            
            for (var categoria in operacionesData) {
                datosFiltrados[categoria] = operacionesData[categoria].filter(function(item) {
                    var fechaOperacion = item.fecha_operacion;
                    var cumpleFecha = fechaOperacion >= fecha1 && fechaOperacion <= fecha2;
                    var cumpleStatus = statusSelect === 'all' || item.semaforo === statusSelect;
                    
                    return cumpleFecha && cumpleStatus;
                });
            }
            
            // Recargar la tabla con datos filtrados
            cargarTablaConDatos(tabActiva, datosFiltrados[tabActiva]);
        }
        
        // Función para cargar tabla con datos específicos
        function cargarTablaConDatos(tipoCliente, data) {
            var tbody = '';
            var tableId = '';
            
            switch(tipoCliente) {
                case 'personas-fisicas':
                    tableId = '#dataPersonasFisicas';
                    break;
                case 'personas-morales':
                    tableId = '#dataPersonasMorales';
                    break;
                case 'fideicomisos':
                    tableId = '#dataFideicomisos';
                    break;
            }
            
            if (data && data.length > 0) {
                for (var i = 0; i < data.length; i++) {
                    var item = data[i];
                    var semaforoClass = 'semaforo-' + item.semaforo;
                    var fechaFormateada = formatDate(item.fecha_operacion);
                    
                    // Determinar si los campos son clickeables y tienen información faltante
                    var empresaClass = item.empresa_missing_info ? 'missing-info clickeable-field' : 'clickeable-field';
                    var clienteClass = item.cliente_missing_info ? 'missing-info clickeable-field' : 'clickeable-field';
                    
                    tbody += "<tr>";
                    tbody += "<td style='text-align:center;'>" + (i + 1) + "</td>";
                    tbody += "<td style='text-align:left;'><span class='" + empresaClass + "' onclick='editarCampo(" + item.id + ", \"empresa\")'>" + item.empresa + "</span></td>";
                    tbody += "<td style='text-align:left;'><span class='" + clienteClass + "' onclick='editarCampo(" + item.id + ", \"cliente\")'>" + item.cliente + "</span></td>";
                    tbody += "<td style='text-align:center;'>" + fechaFormateada + "</td>";
                    tbody += "<td style='text-align:left;'>" + item.tipo_propiedad + "</td>";
                    tbody += "<td style='text-align:center;'>" + item.folio_escritura + "</td>";
                    tbody += "<td style='text-align:center;'>" + item.codigo_postal + "</td>";
                    tbody += "<td style='text-align:center;'><i class='fas fa-circle " + semaforoClass + "'></i></td>";
                    
                    // COMPROBAMOS QUE EL TIPO DE USUARIO SEA DE TIPO ADMINISTRADOR (1)
                    if (userType == 1) {
                        tbody += "<td style='text-align:center;'>" + 
                            "<div class='dropdown'>" + 
                                "<button class='btn btn-primary dropdown-toggle btn-sm' type='button' id='dropdownMenuButton_" + item.id + "' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" + 
                                    "Acciones" + 
                                "</button>" + 
                                "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton_" + item.id + "'>" + 
                                    "<a class='dropdown-item' href='#' onclick='verDetalle(" + item.id + ")'>" + 
                                        "<i class='fas fa-eye'></i> Ver detalle" + 
                                    "</a>" +
                                    "<a class='dropdown-item' href='#' data-operation-id='" + item.id + "'>" + 
                                        "<i class='fas fa-pen'></i> Editar operación" + 
                                    "</a>" +
                                    "<hr>" + 
                                    "<form action='#' method='POST'>" + 
                                        "<input name='delOperation[idOperation]' type='text' class='form-control form-control-sm' value='" + item.id + "' readonly hidden style='display: none;'>" + 
                                        "<button class='dropdown-item' type='submit' name='action' value='deleteOperation' onclick='return confirm(\"¿Estás seguro de eliminar la operación?\");'>" + 
                                            "<i class='fas fa-trash'></i> Mover a la papelera" + 
                                        "</button>" + 
                                    "</form>" + 
                                "</div>" + 
                            "</div>" + 
                        "</td>";
                    }
                    tbody += "</tr>";
                }
            } else {
                var colspan = userType == 1 ? 9 : 8;
                tbody = "<tr><td colspan='" + colspan + "' class='text-center'>No hay operaciones que coincidan con los filtros seleccionados</td></tr>";
            }
            
            $(tableId).html(tbody);
            
            // Actualizar total
            var total = data ? data.length : 0;
            $('#totalOperaciones').text(total);
        }
        
        // Función para cambiar entre pestañas
        function cambiarTab(tipoCliente) {
            // Actualizar botones
            $('.google-tab').removeClass('active');
            $('#btn-' + tipoCliente).addClass('active');
            
            // Ocultar todas las tablas
            $('.tabla-container').removeClass('active');
            
            // Mostrar la tabla seleccionada
            $('#tabla-' + tipoCliente).addClass('active');
            
            // Limpiar búsqueda
            $('#searchInputOperations').val('');
            
            tabActiva = tipoCliente;
            
            // Aplicar filtros a la nueva pestaña
            aplicarFiltros();
        }
        
        // Función para cargar datos en la tabla (versión original)
        function cargarTabla(tipoCliente) {
            var data = operacionesData[tipoCliente];
            cargarTablaConDatos(tipoCliente, data);
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            var date = new Date(dateString);
            var day = String(date.getDate()).padStart(2, '0');
            var month = String(date.getMonth() + 1).padStart(2, '0');
            var year = date.getFullYear();
            return day + '/' + month + '/' + year;
        }
        
        // Función para ver detalle (placeholder)
        function verDetalle(id) {
            alert('Ver detalle de operación ID: ' + id + ' (función a implementar)');
        }
        
        // Función para editar campo clickeable
        function editarCampo(id, campo) {
            var tipoInfo = '';
            if (campo === 'empresa') {
                tipoInfo = 'información de la empresa (dirección, teléfono, contacto, etc.)';
            } else if (campo === 'cliente') {
                tipoInfo = 'información del cliente (domicilio, teléfono, RFC, etc.)';
            }
            
            var confirmar = confirm('¿Desea agregar/completar ' + tipoInfo + '?');
            if (confirmar) {
                // Aquí iría la lógica para abrir un modal o formulario más completo
                // Por ahora simulamos que se completó la información
                
                // Buscar la operación en todas las categorías
                for (var categoria in operacionesData) {
                    var operaciones = operacionesData[categoria];
                    for (var i = 0; i < operaciones.length; i++) {
                        if (operaciones[i].id === id) {
                            // Marcar como información completa
                            operaciones[i][campo + '_missing_info'] = false;
                            break;
                        }
                    }
                }
                
                // Recargar la tabla actual
                aplicarFiltros();
                
                alert('Información completada correctamente. El círculo naranja se ha removido.');
            }
        }
    </script>
</body>
</html>


























