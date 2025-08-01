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
                                <a href="#" class="btn btn-block" style="background-color: #FF5800; color: #ffffff;" role="button" aria-pressed="true" onclick="abrirModalOperacion()">
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

        <style>
.modal-xl {
    max-width: 1200px;
}

.card-header h6 {
    margin: 0;
    font-weight: 600;
}

.text-danger {
    color: #dc3545 !important;
}

.alert {
    margin-bottom: 10px;
    padding: 10px 15px;
    border-radius: 5px;
}

.alert:last-child {
    margin-bottom: 0;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
}

.form-check-label {
    font-size: 0.9rem;
}

.card {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.form-check-label strong {
    color: #495057;
}

#pf_domicilio_extranjero,
#pm_domicilio_extranjero,
#fid_domicilio_extranjero {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    border-left: 4px solid #007bff;
}

#pf_domicilio_extranjero h6,
#pm_domicilio_extranjero h6,
#fid_domicilio_extranjero h6 {
    color: #007bff;
    font-weight: 600;
}

.beneficiario-card {
    border: 1px solid #dee2e6;
}

.beneficiario-card .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.beneficiario-card h6.text-primary {
    color: #007bff !important;
    font-weight: 600;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 8px;
}

.nav-tabs .nav-link {
    color: #495057;
    border: 1px solid transparent;
}

.nav-tabs .nav-link.active {
    color: #007bff;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}

.nav-tabs .nav-link:hover {
    border-color: #e9ecef #e9ecef #dee2e6;
}

#moneda_otra {
    border-color: #28a745;
}

@media (max-width: 768px) {
    .modal-xl {
        max-width: 95%;
        margin: 1rem;
    }
    
    .card-body .row .col-lg-4,
    .card-body .row .col-lg-6,
    .card-body .row .col-lg-8 {
        margin-bottom: 1rem;
    }
    
    .beneficiario-card .card-body .row .col-lg-2,
    .beneficiario-card .card-body .row .col-lg-3,
    .beneficiario-card .card-body .row .col-lg-4,
    .beneficiario-card .card-body .row .col-lg-6 {
        margin-bottom: 1rem;
    }
}

#fid_beneficiarios_tabs .nav-link.active {
    background-color: #007bff !important;  /* Azul más agradable */
    color: #ffffff !important;
    border-color: #007bff #007bff #fff !important;
}
</style><!-- Modal dinámico para agregar nueva operación vulnerable - LFPIORPI -->
<div class="modal fade" id="modalAgregarOperacion" tabindex="-1" aria-labelledby="modalAgregarOperacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarOperacionLabel">
                    <i class="fas fa-shield-alt"></i> Registrar nueva operación vulnerable
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <form id="formAgregarOperacion" action="vulnerabilities.php" method="POST">
                    <input name="operation[key_operation]" type="hidden" value="<?php echo $clave; ?>">
                    <input name="operation[tipo_cliente]" type="hidden" id="hidden_tipo_cliente">
                    
                    <!-- Sección 1: Tipo de Cliente -->
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Tipo de Cliente</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tipo de Cliente:</label>
                                <input type="text" class="form-control" id="tipo_cliente_display" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 2: Información de la Operación -->
                    <div class="card mb-3">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0"><i class="fas fa-file-contract"></i> Información de la Operación</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="fecha_operacion">Fecha de Operación: <span class="text-danger">*</span></label>
                                        <input name="operation[fecha_operacion]" type="date" class="form-control" id="fecha_operacion" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tipo_operacion">Tipo de Operación: <span class="text-danger">*</span></label>
                                        <select name="operation[tipo_operacion]" class="form-control" id="tipo_operacion" required onchange="updateThresholdInfo()">
                                            <option value="">Seleccione...</option>
                                            <option value="intermediacion">Intermediación (Fracción I)</option>
                                            <option value="compra_directa">Compra directa</option>
                                            <option value="preventa">Preventa (Fracción XX)</option>
                                            <option value="construccion">Construcción (Fracción XX)</option>
                                            <option value="arrendamiento">Arrendamiento (Fracción XX)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="monto_operacion">Monto de la Operación: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input name="operation[monto_operacion]" type="number" class="form-control" id="monto_operacion" step="0.01" required onchange="validateOperationAmount()">
                                        </div>
                                        <small id="threshold-info" class="form-text text-muted">Seleccione el tipo de operación para ver el umbral</small>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="moneda">Moneda:</label>
                                        <select name="operation[moneda]" class="form-control" id="moneda" onchange="toggleOtraMoneda()">
                                            <option value="MXN">MXN - Peso Mexicano</option>
                                            <option value="USD">USD - Dólar Americano</option>
                                            <option value="EUR">EUR - Euro</option>
                                            <option value="otra">Otra</option>
                                        </select>
                                        <input name="operation[moneda_otra]" type="text" class="form-control mt-2" id="moneda_otra" placeholder="Especifique la moneda" style="display: none;">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="forma_pago">Forma de Pago:</label>
                                        <select name="operation[forma_pago]" class="form-control" id="forma_pago" onchange="toggleCashAmount()">
                                            <option value="transferencia">Transferencia bancaria</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="efectivo">Efectivo</option>
                                            <option value="credito">Crédito</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="cash-amount-section" class="row" style="display: none;">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="monto_efectivo">Monto en Efectivo:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input name="operation[monto_efectivo]" type="number" class="form-control" id="monto_efectivo" step="0.01" onchange="validateCashLimit()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Alertas PLD -->
                            <div id="pld-alerts-container" class="mt-3"></div>
                        </div>
                    </div>

                    <!-- Sección 3: Información del Inmueble -->
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-building"></i> Información del Inmueble</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tipo_propiedad">Tipo de Propiedad: <span class="text-danger">*</span></label>
                                        <select name="operation[tipo_propiedad]" class="form-control" id="tipo_propiedad" required>
                                            <option value="">Seleccionar tipo...</option>
                                            <option value="habitacional">Habitacional</option>
                                            <option value="comercial">Comercial</option>
                                            <option value="industrial">Industrial</option>
                                            <option value="mixto">Mixto</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="uso_inmueble">Uso Específico del Inmueble:</label>
                                        <select name="operation[uso_inmueble]" class="form-control" id="uso_inmueble">
                                            <option value="">Seleccionar uso...</option>
                                            <option value="casa_residencial">Casa Residencial</option>
                                            <option value="departamento">Departamento</option>
                                            <option value="terreno">Terreno</option>
                                            <option value="local_comercial">Local Comercial</option>
                                            <option value="oficina">Oficina</option>
                                            <option value="bodega">Bodega</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="direccion_inmueble">Dirección del Inmueble:</label>
                                        <textarea name="operation[direccion_inmueble]" class="form-control" id="direccion_inmueble" rows="2" placeholder="Calle, número, colonia, ciudad, estado"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="codigo_postal">Código Postal: <span class="text-danger">*</span></label>
                                        <input name="operation[codigo_postal]" type="text" class="form-control" id="codigo_postal" maxlength="6" placeholder="123456" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="folio_escritura">Folio de Escritura:</label>
                                        <input name="operation[folio_escritura]" type="text" class="form-control" id="folio_escritura" placeholder="Folio de escritura">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="propietario_anterior">Propietario Anterior:</label>
                                        <input name="operation[propietario_anterior]" type="text" class="form-control" id="propietario_anterior" placeholder="Nombre del propietario anterior">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 4: Información del Cliente - PERSONA FÍSICA -->
                    <div class="card mb-3" id="seccion-persona-fisica" style="display: none;">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-user"></i> Información de la Persona Física</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pf_nombre">Nombre: <span class="text-danger">*</span></label>
                                        <input name="operation[pf_nombre]" type="text" class="form-control" id="pf_nombre" placeholder="Nombre completo">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pf_apellido_paterno">Apellido Paterno: <span class="text-danger">*</span></label>
                                        <input name="operation[pf_apellido_paterno]" type="text" class="form-control" id="pf_apellido_paterno" placeholder="Apellido paterno">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pf_apellido_materno">Apellido Materno:</label>
                                        <input name="operation[pf_apellido_materno]" type="text" class="form-control" id="pf_apellido_materno" placeholder="Apellido materno">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pf_rfc">RFC: <span class="text-danger">*</span></label>
                                        <input name="operation[pf_rfc]" type="text" class="form-control" id="pf_rfc" maxlength="13" placeholder="ABCD123456ABC">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pf_curp">CURP:</label>
                                        <input name="operation[pf_curp]" type="text" class="form-control" id="pf_curp" maxlength="18" placeholder="ABCD123456ABCDEFGH">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pf_fecha_nacimiento">Fecha de Nacimiento:</label>
                                        <input name="operation[pf_fecha_nacimiento]" type="date" class="form-control" id="pf_fecha_nacimiento">
                                    </div>
                                </div>
                            </div>
                            
                            <h6 class="mt-4 mb-3">Domicilio Nacional</h6>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pf_estado">Estado:</label>
                                        <input name="operation[pf_estado]" type="text" class="form-control" id="pf_estado" placeholder="Estado">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pf_ciudad">Ciudad o Población:</label>
                                        <input name="operation[pf_ciudad]" type="text" class="form-control" id="pf_ciudad" placeholder="Ciudad">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pf_colonia">Colonia:</label>
                                        <input name="operation[pf_colonia]" type="text" class="form-control" id="pf_colonia" placeholder="Colonia">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="pf_calle">Calle:</label>
                                        <input name="operation[pf_calle]" type="text" class="form-control" id="pf_calle" placeholder="Calle">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="pf_num_exterior">Núm. Exterior:</label>
                                        <input name="operation[pf_num_exterior]" type="text" class="form-control" id="pf_num_exterior" placeholder="123">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="pf_num_interior">Núm. Interior:</label>
                                        <input name="operation[pf_num_interior]" type="text" class="form-control" id="pf_num_interior" placeholder="123">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="pf_codigo_postal">Código Postal:</label>
                                        <input name="operation[pf_codigo_postal]" type="text" class="form-control" id="pf_codigo_postal" maxlength="6" placeholder="123456">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="pf_correo">Correo Electrónico:</label>
                                        <input name="operation[pf_correo]" type="email" class="form-control" id="pf_correo" placeholder="correo@ejemplo.com">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="pf_telefono">Teléfono:</label>
                                        <input name="operation[pf_telefono]" type="tel" class="form-control" id="pf_telefono" placeholder="Teléfono">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Domicilio Extranjero (Opcional) -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="pf_tiene_domicilio_extranjero" onchange="toggleDomicilioExtranjero('pf')">
                                        <label class="form-check-label" for="pf_tiene_domicilio_extranjero">
                                            <strong>¿Tiene domicilio extranjero?</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="pf_domicilio_extranjero" class="mt-3" style="display: none;">
                                <h6 class="mb-3">Domicilio Extranjero (Opcional)</h6>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pf_pais_origen">País de Origen:</label>
                                            <input name="operation[pf_pais_origen]" type="text" class="form-control" id="pf_pais_origen" placeholder="País">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pf_estado_provincia_ext">Estado o Provincia:</label>
                                            <input name="operation[pf_estado_provincia_ext]" type="text" class="form-control" id="pf_estado_provincia_ext" placeholder="Estado">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pf_ciudad_poblacion_ext">Ciudad o Población:</label>
                                            <input name="operation[pf_ciudad_poblacion_ext]" type="text" class="form-control" id="pf_ciudad_poblacion_ext" placeholder="Ciudad">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="pf_colonia_ext">Colonia del Extranjero:</label>
                                            <input name="operation[pf_colonia_ext]" type="text" class="form-control" id="pf_colonia_ext" placeholder="Colonia">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="pf_calle_ext">Calle del Extranjero:</label>
                                            <input name="operation[pf_calle_ext]" type="text" class="form-control" id="pf_calle_ext" placeholder="Calle">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pf_num_exterior_ext">Núm. Exterior (Ext):</label>
                                            <input name="operation[pf_num_exterior_ext]" type="text" class="form-control" id="pf_num_exterior_ext" placeholder="123">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pf_num_interior_ext">Núm. Interior (Ext):</label>
                                            <input name="operation[pf_num_interior_ext]" type="text" class="form-control" id="pf_num_interior_ext" placeholder="123">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pf_codigo_postal_ext">Código Postal Extranjero:</label>
                                            <input name="operation[pf_codigo_postal_ext]" type="text" class="form-control" id="pf_codigo_postal_ext" placeholder="123456">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 5: Información del Cliente - PERSONA MORAL -->
                    <div class="card mb-3" id="seccion-persona-moral" style="display: none;">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-building"></i> Información de la Persona Moral</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="pm_razon_social">Razón Social: <span class="text-danger">*</span></label>
                                        <input name="operation[pm_razon_social]" type="text" class="form-control" id="pm_razon_social" placeholder="Razón social">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pm_rfc">RFC Persona Moral: <span class="text-danger">*</span></label>
                                        <input name="operation[pm_rfc]" type="text" class="form-control" id="pm_rfc" maxlength="12" placeholder="ABCD123456ABC">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="pm_fecha_constitucion">Fecha de Constitución:</label>
                                        <input name="operation[pm_fecha_constitucion]" type="date" class="form-control" id="pm_fecha_constitucion">
                                    </div>
                                </div>
                            </div>
                            
                            <h6 class="mt-4 mb-3">Apoderado Legal</h6>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pm_apoderado_nombre">Nombre:</label>
                                        <input name="operation[pm_apoderado_nombre]" type="text" class="form-control" id="pm_apoderado_nombre" placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pm_apoderado_paterno">Apellido Paterno:</label>
                                        <input name="operation[pm_apoderado_paterno]" type="text" class="form-control" id="pm_apoderado_paterno" placeholder="Apellido Paterno">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pm_apoderado_materno">Apellido Materno:</label>
                                        <input name="operation[pm_apoderado_materno]" type="text" class="form-control" id="pm_apoderado_materno" placeholder="Apellido Materno">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pm_apoderado_rfc">RFC Apoderado Legal:</label>
                                        <input name="operation[pm_apoderado_rfc]" type="text" class="form-control" id="pm_apoderado_rfc" maxlength="13" placeholder="ABCD123456ABC">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pm_apoderado_curp">CURP Apoderado Legal:</label>
                                        <input name="operation[pm_apoderado_curp]" type="text" class="form-control" id="pm_apoderado_curp" maxlength="18" placeholder="ABCD123456ABCDEFGH">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pm_fecha_nacimiento_rep">Fecha de nacimiento de representante legal:</label>
                                        <input name="operation[pm_fecha_nacimiento_rep]" type="date" class="form-control" id="pm_fecha_nacimiento_rep">
                                    </div>
                                </div>
                            </div>
                            
                            <h6 class="mt-4 mb-3">Domicilio Nacional</h6>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pm_estado">Estado:</label>
                                        <input name="operation[pm_estado]" type="text" class="form-control" id="pm_estado" placeholder="Estado">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pm_ciudad">Ciudad o Población:</label>
                                        <input name="operation[pm_ciudad]" type="text" class="form-control" id="pm_ciudad" placeholder="Ciudad">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pm_colonia">Colonia:</label>
                                        <input name="operation[pm_colonia]" type="text" class="form-control" id="pm_colonia" placeholder="Colonia">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="pm_calle">Calle:</label>
                                        <input name="operation[pm_calle]" type="text" class="form-control" id="pm_calle" placeholder="Calle">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="pm_num_exterior">Núm. Exterior:</label>
                                        <input name="operation[pm_num_exterior]" type="text" class="form-control" id="pm_num_exterior" placeholder="123">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="pm_num_interior">Núm. Interior:</label>
                                        <input name="operation[pm_num_interior]" type="text" class="form-control" id="pm_num_interior" placeholder="123">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="pm_codigo_postal">Código Postal:</label>
                                        <input name="operation[pm_codigo_postal]" type="text" class="form-control" id="pm_codigo_postal" maxlength="6" placeholder="123456">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="pm_correo">Correo Electrónico:</label>
                                        <input name="operation[pm_correo]" type="email" class="form-control" id="pm_correo" placeholder="correo@ejemplo.com">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="pm_telefono">Teléfono:</label>
                                        <input name="operation[pm_telefono]" type="tel" class="form-control" id="pm_telefono" placeholder="Teléfono">
                                    </div>
                                </div>
                            </div>
                            
                                <!-- Domicilio Extranjero (Opcional) -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="pm_tiene_domicilio_extranjero" onchange="toggleDomicilioExtranjero('pm')">
                                        <label class="form-check-label" for="pm_tiene_domicilio_extranjero">
                                            <strong>¿Tiene domicilio extranjero?</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="pm_domicilio_extranjero" class="mt-3" style="display: none;">
                                <h6 class="mb-3">Domicilio Extranjero (Opcional)</h6>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pm_pais_origen">País de Origen:</label>
                                            <input name="operation[pm_pais_origen]" type="text" class="form-control" id="pm_pais_origen" placeholder="País">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pm_estado_provincia_ext">Estado o Provincia:</label>
                                            <input name="operation[pm_estado_provincia_ext]" type="text" class="form-control" id="pm_estado_provincia_ext" placeholder="Estado">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pm_ciudad_poblacion_ext">Ciudad o Población:</label>
                                            <input name="operation[pm_ciudad_poblacion_ext]" type="text" class="form-control" id="pm_ciudad_poblacion_ext" placeholder="Ciudad">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="pm_colonia_ext">Colonia del Extranjero:</label>
                                            <input name="operation[pm_colonia_ext]" type="text" class="form-control" id="pm_colonia_ext" placeholder="Colonia">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="pm_calle_ext">Calle del Extranjero:</label>
                                            <input name="operation[pm_calle_ext]" type="text" class="form-control" id="pm_calle_ext" placeholder="Calle">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pm_num_exterior_ext">Núm. Exterior (Ext):</label>
                                            <input name="operation[pm_num_exterior_ext]" type="text" class="form-control" id="pm_num_exterior_ext" placeholder="123">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pm_num_interior_ext">Núm. Interior (Ext):</label>
                                            <input name="operation[pm_num_interior_ext]" type="text" class="form-control" id="pm_num_interior_ext" placeholder="123">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pm_codigo_postal_ext">Código Postal Extranjero:</label>
                                            <input name="operation[pm_codigo_postal_ext]" type="text" class="form-control" id="pm_codigo_postal_ext" placeholder="123456">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sección Beneficiarios Controladores -->
                            <div class="mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Beneficiarios Controladores</h6>
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="agregarBeneficiarioControlador('pm')">
                                        <i class="fas fa-plus"></i> Agregar Beneficiario
                                    </button>
                                </div>
                                <div id="pm_beneficiarios_container">
                                    <!-- Los beneficiarios se agregarán dinámicamente aquí -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 6: Información del Cliente - FIDEICOMISO -->
                    <div class="card mb-3" id="seccion-fideicomiso" style="display: none;">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-handshake"></i> Información del Fideicomiso</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="fid_razon_social">Razón Social del Fiduciario: <span class="text-danger">*</span></label>
                                        <input name="operation[fid_razon_social]" type="text" class="form-control" id="fid_razon_social" placeholder="Razón social">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fid_rfc">RFC del Fiduciario: <span class="text-danger">*</span></label>
                                        <input name="operation[fid_rfc]" type="text" class="form-control" id="fid_rfc" maxlength="12" placeholder="ABCD123456ABC">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="fid_numero_referencia">Número / Referencia de Fideicomiso:</label>
                                        <input name="operation[fid_numero_referencia]" type="text" class="form-control" id="fid_numero_referencia" placeholder="Referencia">
                                    </div>
                                </div>
                            </div>
                            
                            <h6 class="mt-4 mb-3">Apoderado Legal</h6>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fid_apoderado_nombre">Nombre:</label>
                                        <input name="operation[fid_apoderado_nombre]" type="text" class="form-control" id="fid_apoderado_nombre" placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fid_apoderado_paterno">Apellido Paterno:</label>
                                        <input name="operation[fid_apoderado_paterno]" type="text" class="form-control" id="fid_apoderado_paterno" placeholder="Apellido Paterno">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fid_apoderado_materno">Apellido Materno:</label>
                                        <input name="operation[fid_apoderado_materno]" type="text" class="form-control" id="fid_apoderado_materno" placeholder="Apellido Materno">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fid_apoderado_rfc">RFC Apoderado Legal:</label>
                                        <input name="operation[fid_apoderado_rfc]" type="text" class="form-control" id="fid_apoderado_rfc" maxlength="13" placeholder="ABCD123456ABC">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fid_apoderado_curp">CURP Apoderado Legal:</label>
                                        <input name="operation[fid_apoderado_curp]" type="text" class="form-control" id="fid_apoderado_curp" maxlength="18" placeholder="ABCD123456ABCDEFGH">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fid_fecha_nacimiento_rep">Fecha de nacimiento de representante legal:</label>
                                        <input name="operation[fid_fecha_nacimiento_rep]" type="date" class="form-control" id="fid_fecha_nacimiento_rep">
                                    </div>
                                </div>
                            </div>
                            
                            <h6 class="mt-4 mb-3">Domicilio Nacional</h6>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fid_estado">Estado:</label>
                                        <input name="operation[fid_estado]" type="text" class="form-control" id="fid_estado" placeholder="Estado">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fid_ciudad">Ciudad o Población:</label>
                                        <input name="operation[fid_ciudad]" type="text" class="form-control" id="fid_ciudad" placeholder="Ciudad">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fid_colonia">Colonia:</label>
                                        <input name="operation[fid_colonia]" type="text" class="form-control" id="fid_colonia" placeholder="Colonia">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="fid_calle">Calle:</label>
                                        <input name="operation[fid_calle]" type="text" class="form-control" id="fid_calle" placeholder="Calle">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="fid_num_exterior">Núm. Exterior:</label>
                                        <input name="operation[fid_num_exterior]" type="text" class="form-control" id="fid_num_exterior" placeholder="123">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="fid_num_interior">Núm. Interior:</label>
                                        <input name="operation[fid_num_interior]" type="text" class="form-control" id="fid_num_interior" placeholder="123">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="fid_codigo_postal">Código Postal:</label>
                                        <input name="operation[fid_codigo_postal]" type="text" class="form-control" id="fid_codigo_postal" maxlength="6" placeholder="123456">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="fid_correo">Correo Electrónico:</label>
                                        <input name="operation[fid_correo]" type="email" class="form-control" id="fid_correo" placeholder="correo@ejemplo.com">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="fid_telefono">Teléfono:</label>
                                        <input name="operation[fid_telefono]" type="tel" class="form-control" id="fid_telefono" placeholder="Teléfono">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Domicilio Extranjero (Opcional) -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="fid_tiene_domicilio_extranjero" onchange="toggleDomicilioExtranjero('fid')">
                                        <label class="form-check-label" for="fid_tiene_domicilio_extranjero">
                                            <strong>¿Tiene domicilio extranjero?</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="fid_domicilio_extranjero" class="mt-3" style="display: none;">
                                <h6 class="mb-3">Domicilio Extranjero (Opcional)</h6>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="fid_pais_origen">País de Origen:</label>
                                            <input name="operation[fid_pais_origen]" type="text" class="form-control" id="fid_pais_origen" placeholder="País">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="fid_estado_provincia_ext">Estado o Provincia:</label>
                                            <input name="operation[fid_estado_provincia_ext]" type="text" class="form-control" id="fid_estado_provincia_ext" placeholder="Estado">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="fid_ciudad_poblacion_ext">Ciudad o Población:</label>
                                            <input name="operation[fid_ciudad_poblacion_ext]" type="text" class="form-control" id="fid_ciudad_poblacion_ext" placeholder="Ciudad">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="fid_colonia_ext">Colonia del Extranjero:</label>
                                            <input name="operation[fid_colonia_ext]" type="text" class="form-control" id="fid_colonia_ext" placeholder="Colonia">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="fid_calle_ext">Calle del Extranjero:</label>
                                            <input name="operation[fid_calle_ext]" type="text" class="form-control" id="fid_calle_ext" placeholder="Calle">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="fid_num_exterior_ext">Núm. Exterior (Ext):</label>
                                            <input name="operation[fid_num_exterior_ext]" type="text" class="form-control" id="fid_num_exterior_ext" placeholder="123">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="fid_num_interior_ext">Núm. Interior (Ext):</label>
                                            <input name="operation[fid_num_interior_ext]" type="text" class="form-control" id="fid_num_interior_ext" placeholder="123">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="fid_codigo_postal_ext">Código Postal Extranjero:</label>
                                            <input name="operation[fid_codigo_postal_ext]" type="text" class="form-control" id="fid_codigo_postal_ext" placeholder="123456">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sección Beneficiarios Controladores para Fideicomiso -->
                            <div class="mt-4">
                                <h6 class="mb-3">Beneficiarios Controladores del Fideicomiso</h6>
                                
                                <!-- Pestañas para diferentes roles -->
                                <ul class="nav nav-tabs" id="fid_beneficiarios_tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="fideicomitente-tab" data-toggle="tab" href="#fideicomitente" role="tab">Fideicomitente(s)</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="fiduciario-tab" data-toggle="tab" href="#fiduciario" role="tab">Fiduciario(s)</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="fideicomisario-tab" data-toggle="tab" href="#fideicomisario" role="tab">Fideicomisario(s)</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="control-efectivo-tab" data-toggle="tab" href="#control-efectivo" role="tab">Control Efectivo</a>
                                    </li>
                                </ul>
                                
                                <div class="tab-content mt-3" id="fid_beneficiarios_content">
                                    <div class="tab-pane fade show active" id="fideicomitente" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>Fideicomitente(s)</span>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="agregarBeneficiarioControlador('fid', 'fideicomitente')">
                                                <i class="fas fa-plus"></i> Agregar Fideicomitente
                                            </button>
                                        </div>
                                        <div id="fid_fideicomitente_container"></div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="fiduciario" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>Fiduciario(s)</span>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="agregarBeneficiarioControlador('fid', 'fiduciario')">
                                                <i class="fas fa-plus"></i> Agregar Fiduciario
                                            </button>
                                        </div>
                                        <div id="fid_fiduciario_container"></div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="fideicomisario" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>Fideicomisario(s)</span>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="agregarBeneficiarioControlador('fid', 'fideicomisario')">
                                                <i class="fas fa-plus"></i> Agregar Fideicomisario
                                            </button>
                                        </div>
                                        <div id="fid_fideicomisario_container"></div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="control-efectivo" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>Personas con Control Efectivo</span>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="agregarBeneficiarioControlador('fid', 'control_efectivo')">
                                                <i class="fas fa-plus"></i> Agregar Persona con Control
                                            </button>
                                        </div>
                                        <div id="fid_control_efectivo_container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="form-group">
                        <label for="observaciones">Observaciones Internas:</label>
                        <textarea name="operation[observaciones]" class="form-control" id="observaciones" rows="3" placeholder="Observaciones adicionales sobre la operación"></textarea>
                    </div>
                    
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" name="action" value="createOperation">
                            <i class="fas fa-save"></i> Guardar Operación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Umbrales LFPIORPI 2025
const UMBRALES_PLD = {
    'intermediacion': 1605000, // Fracción I - 8,025 UMAs
    'preventa': 907948,        // Fracción XX - 4,540 UMAs
    'construccion': 907948,    // Fracción XX - 4,540 UMAs
    'arrendamiento': 907948,   // Fracción XX - 4,540 UMAs
    'compra_directa': 1605000  // Aplicar umbral más alto por seguridad
};

const LIMITE_EFECTIVO_PLD = 719200; // Art. 32 LFPIORPI

// Contadores para beneficiarios controladores
let contadorBeneficiarios = {
    pm: 0,
    fid_fideicomitente: 0,
    fid_fiduciario: 0,
    fid_fideicomisario: 0,
    fid_control_efectivo: 0
};

// Función que se ejecuta cuando se abre el modal
function abrirModalOperacion() {
    var tipoCliente = obtenerTipoClienteActivo();
    console.log('Tipo de cliente detectado:', tipoCliente);
    
    configurarModalSegunTipo(tipoCliente);
    
    var today = new Date().toISOString().split('T')[0];
    $('#fecha_operacion').val(today);
    
    limpiarFormulario();
    
    $('#modalAgregarOperacion').modal('show');
}

// Función para obtener el tipo de cliente activo según la pestaña
function obtenerTipoClienteActivo() {
    if (typeof tabActiva !== 'undefined') {
        return tabActiva;
    }
    
    if ($('#btn-personas-fisicas').hasClass('active')) {
        return 'personas-fisicas';
    } else if ($('#btn-personas-morales').hasClass('active')) {
        return 'personas-morales';
    } else if ($('#btn-fideicomisos').hasClass('active')) {
        return 'fideicomisos';
    }
    return 'personas-fisicas';
}

// Función para configurar el modal según el tipo de cliente
function configurarModalSegunTipo(tipoCliente) {
    console.log('Configurando modal para:', tipoCliente);
    
    $('#seccion-persona-fisica').hide();
    $('#seccion-persona-moral').hide();
    $('#seccion-fideicomiso').hide();
    
    switch(tipoCliente) {
        case 'personas-fisicas':
            $('#tipo_cliente_display').val('Persona Física');
            $('#hidden_tipo_cliente').val('Persona Física');
            $('#seccion-persona-fisica').show();
            $('#pf_nombre, #pf_apellido_paterno, #pf_rfc').attr('required', true);
            break;
            
        case 'personas-morales':
            $('#tipo_cliente_display').val('Persona Moral');
            $('#hidden_tipo_cliente').val('Persona Moral');
            $('#seccion-persona-moral').show();
            $('#pm_razon_social, #pm_rfc').attr('required', true);
            break;
            
        case 'fideicomisos':
            $('#tipo_cliente_display').val('Fideicomiso');
            $('#hidden_tipo_cliente').val('Fideicomiso');
            $('#seccion-fideicomiso').show();
            $('#fid_razon_social, #fid_rfc').attr('required', true);
            break;
            
        default:
            $('#tipo_cliente_display').val('Persona Física');
            $('#hidden_tipo_cliente').val('Persona Física');
            $('#seccion-persona-fisica').show();
            $('#pf_nombre, #pf_apellido_paterno, #pf_rfc').attr('required', true);
            break;
    }
}

// Función para mostrar/ocultar campo de otra moneda
function toggleOtraMoneda() {
    const monedaSelect = $('#moneda');
    const otraMonedaInput = $('#moneda_otra');
    
    if (monedaSelect.val() === 'otra') {
        otraMonedaInput.show().attr('required', true);
    } else {
        otraMonedaInput.hide().removeAttr('required').val('');
    }
}

// Función para agregar beneficiario controlador
function agregarBeneficiarioControlador(tipo, rol = '') {
    let containerId = '';
    let prefijo = '';
    let titulo = '';
    
    if (tipo === 'pm') {
        containerId = 'pm_beneficiarios_container';
        prefijo = 'pm_bc_' + contadorBeneficiarios.pm;
        titulo = 'Beneficiario Controlador #' + (contadorBeneficiarios.pm + 1);
        contadorBeneficiarios.pm++;
    } else if (tipo === 'fid') {
        containerId = 'fid_' + rol + '_container';
        prefijo = 'fid_' + rol + '_' + contadorBeneficiarios['fid_' + rol];
        titulo = rol.charAt(0).toUpperCase() + rol.slice(1) + ' #' + (contadorBeneficiarios['fid_' + rol] + 1);
        contadorBeneficiarios['fid_' + rol]++;
    }
    
    const beneficiarioHTML = `
        <div class="card mb-3 beneficiario-card" id="${prefijo}_card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0 flex-grow-1">${titulo}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger flex-shrink-0" onclick="eliminarBeneficiario('${prefijo}_card')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="card-body">
                <!-- Información Personal -->
                <h6 class="text-primary mb-3">Información Personal</h6>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="${prefijo}_nombre">Nombre(s): <span class="text-danger">*</span></label>
                            <input name="operation[${prefijo}_nombre]" type="text" class="form-control" id="${prefijo}_nombre" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="${prefijo}_apellido_paterno">Apellido Paterno: <span class="text-danger">*</span></label>
                            <input name="operation[${prefijo}_apellido_paterno]" type="text" class="form-control" id="${prefijo}_apellido_paterno" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="${prefijo}_apellido_materno">Apellido Materno:</label>
                            <input name="operation[${prefijo}_apellido_materno]" type="text" class="form-control" id="${prefijo}_apellido_materno">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="${prefijo}_curp">CURP:</label>
                            <input name="operation[${prefijo}_curp]" type="text" class="form-control" id="${prefijo}_curp" maxlength="18">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="${prefijo}_rfc">RFC:</label>
                            <input name="operation[${prefijo}_rfc]" type="text" class="form-control" id="${prefijo}_rfc" maxlength="13">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="${prefijo}_fecha_nacimiento">Fecha de Nacimiento:</label>
                            <input name="operation[${prefijo}_fecha_nacimiento]" type="date" class="form-control" id="${prefijo}_fecha_nacimiento">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="${prefijo}_nacionalidad">Nacionalidad:</label>
                            <select name="operation[${prefijo}_nacionalidad]" class="form-control" id="${prefijo}_nacionalidad">
                                <option value="mexicana">Mexicana</option>
                                <option value="extranjera">Extranjera</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="${prefijo}_pais_nacimiento">País de Nacimiento:</label>
                            <input name="operation[${prefijo}_pais_nacimiento]" type="text" class="form-control" id="${prefijo}_pais_nacimiento" value="México">
                        </div>
                    </div>
                </div>
                
                <!-- Información de Participación -->
                <h6 class="text-primary mb-3 mt-4">Información de Participación</h6>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="${prefijo}_tipo_participacion">Tipo de Participación:</label>
                            <select name="operation[${prefijo}_tipo_participacion]" class="form-control" id="${prefijo}_tipo_participacion">
                                <option value="">Seleccione...</option>
                                <option value="propiedad">Propiedad</option>
                                <option value="control">Control</option>
                                <option value="influencia_significativa">Influencia Significativa</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="${prefijo}_porcentaje">Porcentaje de Participación (%):</label>
                            <input name="operation[${prefijo}_porcentaje]" type="number" class="form-control" id="${prefijo}_porcentaje" min="0" max="100" step="0.01">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="${prefijo}_fecha_bc">Fecha en que adquirió la calidad de BC:</label>
                            <input name="operation[${prefijo}_fecha_bc]" type="date" class="form-control" id="${prefijo}_fecha_bc">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="${prefijo}_es_directo">¿Es directo?</label>
                            <select name="operation[${prefijo}_es_directo]" class="form-control" id="${prefijo}_es_directo">
                                <option value="">Seleccione...</option>
                                <option value="si">Sí</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="${prefijo}_cadena_titularidad">¿Existe cadena de titularidad?</label>
                            <select name="operation[${prefijo}_cadena_titularidad]" class="form-control" id="${prefijo}_cadena_titularidad" onchange="toggleCadenaTitularidad('${prefijo}')">
                                <option value="">Seleccione...</option>
                                <option value="si">Sí</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row" id="${prefijo}_descripcion_cadena" style="display: none;">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="${prefijo}_descripcion_cadena_text">Descripción de la cadena de titularidad o control:</label>
                            <textarea name="operation[${prefijo}_descripcion_cadena_text]" class="form-control" id="${prefijo}_descripcion_cadena_text" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Domicilio -->
                <h6 class="text-primary mb-3 mt-4">Domicilio</h6>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="${prefijo}_estado">Estado:</label>
                            <input name="operation[${prefijo}_estado]" type="text" class="form-control" id="${prefijo}_estado">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="${prefijo}_ciudad">Ciudad:</label>
                            <input name="operation[${prefijo}_ciudad]" type="text" class="form-control" id="${prefijo}_ciudad">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="${prefijo}_colonia">Colonia:</label>
                            <input name="operation[${prefijo}_colonia]" type="text" class="form-control" id="${prefijo}_colonia">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="${prefijo}_calle">Calle:</label>
                            <input name="operation[${prefijo}_calle]" type="text" class="form-control" id="${prefijo}_calle">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="${prefijo}_num_exterior">Núm. Ext.:</label>
                            <input name="operation[${prefijo}_num_exterior]" type="text" class="form-control" id="${prefijo}_num_exterior">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="${prefijo}_num_interior">Núm. Int.:</label>
                            <input name="operation[${prefijo}_num_interior]" type="text" class="form-control" id="${prefijo}_num_interior">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="${prefijo}_cp">C.P.:</label>
                            <input name="operation[${prefijo}_cp]" type="text" class="form-control" id="${prefijo}_cp" maxlength="6">
                        </div>
                    </div>
                </div>
                
                <!-- Contacto -->
                <h6 class="text-primary mb-3 mt-4">Información de Contacto</h6>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="${prefijo}_correo">Correo Electrónico:</label>
                            <input name="operation[${prefijo}_correo]" type="email" class="form-control" id="${prefijo}_correo">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="${prefijo}_telefono">Teléfono:</label>
                            <input name="operation[${prefijo}_telefono]" type="tel" class="form-control" id="${prefijo}_telefono">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#' + containerId).append(beneficiarioHTML);
}

// Función para eliminar beneficiario
function eliminarBeneficiario(cardId) {
    if (confirm('¿Está seguro de eliminar este beneficiario controlador?')) {
        $('#' + cardId).remove();
        
        // AGREGAR ESTAS LÍNEAS PARA REINDEXAR LOS TÍTULOS
        reindexarBeneficiarios();
    }
}


// NUEVA FUNCIÓN PARA REINDEXAR (agregar después de eliminarBeneficiario)
function reindexarBeneficiarios() {
    // Reindexar PM
    $('#pm_beneficiarios_container .beneficiario-card').each(function(index) {
        $(this).find('.card-header h6').text('Beneficiario Controlador #' + (index + 1));
    });
    contadorBeneficiarios.pm = $('#pm_beneficiarios_container .beneficiario-card').length;
    
    // Reindexar Fideicomiso - Fideicomitente
    $('#fid_fideicomitente_container .beneficiario-card').each(function(index) {
        $(this).find('.card-header h6').text('Fideicomitente #' + (index + 1));
    });
    contadorBeneficiarios.fid_fideicomitente = $('#fid_fideicomitente_container .beneficiario-card').length;
    
    // Reindexar Fideicomiso - Fiduciario
    $('#fid_fiduciario_container .beneficiario-card').each(function(index) {
        $(this).find('.card-header h6').text('Fiduciario #' + (index + 1));
    });
    contadorBeneficiarios.fid_fiduciario = $('#fid_fiduciario_container .beneficiario-card').length;
    
    // Reindexar Fideicomiso - Fideicomisario
    $('#fid_fideicomisario_container .beneficiario-card').each(function(index) {
        $(this).find('.card-header h6').text('Fideicomisario #' + (index + 1));
    });
    contadorBeneficiarios.fid_fideicomisario = $('#fid_fideicomisario_container .beneficiario-card').length;
    
    // Reindexar Fideicomiso - Control Efectivo
    $('#fid_control_efectivo_container .beneficiario-card').each(function(index) {
        $(this).find('.card-header h6').text('Persona con Control Efectivo #' + (index + 1));
    });
    contadorBeneficiarios.fid_control_efectivo = $('#fid_control_efectivo_container .beneficiario-card').length;
}

// Función para mostrar/ocultar descripción de cadena de titularidad
function toggleCadenaTitularidad(prefijo) {
    const select = $('#' + prefijo + '_cadena_titularidad');
    const descripcionDiv = $('#' + prefijo + '_descripcion_cadena');
    
    if (select.val() === 'si') {
        descripcionDiv.show();
        $('#' + prefijo + '_descripcion_cadena_text').attr('required', true);
    } else {
        descripcionDiv.hide();
        $('#' + prefijo + '_descripcion_cadena_text').removeAttr('required').val('');
    }
}

// Función para limpiar el formulario
function limpiarFormulario() {
    var tipoClienteDisplay = $('#tipo_cliente_display').val();
    var hiddenTipoCliente = $('#hidden_tipo_cliente').val();
    
    $('#formAgregarOperacion')[0].reset();
    
    $('#tipo_cliente_display').val(tipoClienteDisplay);
    $('#hidden_tipo_cliente').val(hiddenTipoCliente);
    
    $('#pld-alerts-container').html('');
    $('#cash-amount-section').hide();
    $('#moneda_otra').hide();
    
    $('#pf_domicilio_extranjero, #pm_domicilio_extranjero, #fid_domicilio_extranjero').hide();
    $('#pf_tiene_domicilio_extranjero, #pm_tiene_domicilio_extranjero, #fid_tiene_domicilio_extranjero').prop('checked', false);
    
    $('#pm_beneficiarios_container').empty();
    $('#fid_fideicomitente_container, #fid_fiduciario_container, #fid_fideicomisario_container, #fid_control_efectivo_container').empty();
    
    contadorBeneficiarios = {
        pm: 0,
        fid_fideicomitente: 0,
        fid_fiduciario: 0,
        fid_fideicomisario: 0,
        fid_control_efectivo: 0
    };
    
    $('#pf_nombre, #pf_apellido_paterno, #pf_rfc').removeAttr('required');
    $('#pm_razon_social, #pm_rfc').removeAttr('required');
    $('#fid_razon_social, #fid_rfc').removeAttr('required');
}

// Función para actualizar información de umbral
function updateThresholdInfo() {
    const tipoOperacion = $('#tipo_operacion').val();
    const thresholdInfo = $('#threshold-info');
    
    if (tipoOperacion && UMBRALES_PLD[tipoOperacion]) {
        const umbral = UMBRALES_PLD[tipoOperacion].toLocaleString('es-MX');
        thresholdInfo.html(`<strong>Umbral de reportabilidad:</strong> ${umbral} MXN`);
        thresholdInfo.removeClass('text-muted').addClass('text-info');
    } else {
        thresholdInfo.html('Seleccione el tipo de operación para ver el umbral');
        thresholdInfo.removeClass('text-info').addClass('text-muted');
    }
}

// Función para validar el monto de la operación
function validateOperationAmount() {
    const tipoOperacion = $('#tipo_operacion').val();
    const monto = parseFloat($('#monto_operacion').val()) || 0;
    const alertContainer = $('#pld-alerts-container');
    
    if (!tipoOperacion || monto === 0) {
        alertContainer.html('');
        return;
    }
    
    const umbral = UMBRALES_PLD[tipoOperacion];
    let alertHTML = '';
    
    if (monto > umbral) {
        alertHTML += `
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Operación reportable al SAT:</strong> Esta operación supera el umbral de ${umbral.toLocaleString('es-MX')} MXN y debe reportarse mediante XML.
            </div>
        `;
    } else {
        alertHTML += `
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Operación no reportable:</strong> Esta operación está por debajo del umbral pero debe registrarse en bitácora interna.
            </div>
        `;
    }
    
    alertContainer.html(alertHTML);
}

// Función para mostrar/ocultar sección de efectivo
function toggleCashAmount() {
    const formaPago = $('#forma_pago').val();
    const cashSection = $('#cash-amount-section');
    
    if (formaPago === 'efectivo') {
        cashSection.show();
        $('#monto_efectivo').attr('required', true);
    } else {
        cashSection.hide();
        $('#monto_efectivo').removeAttr('required').val('');
        validateCashLimit();
    }
}

// Función para validar límite de efectivo
function validateCashLimit() {
    const montoEfectivo = parseFloat($('#monto_efectivo').val()) || 0;
    const alertContainer = $('#pld-alerts-container');
    let alertsHTML = alertContainer.html();
    
    alertsHTML = alertsHTML.replace(/<div class="alert alert-danger">.*?<\/div>/gs, '');
    
    if (montoEfectivo > LIMITE_EFECTIVO_PLD) {
        const cashAlert = `
            <div class="alert alert-danger">
                <i class="fas fa-ban"></i>
                <strong>¡OPERACIÓN PROHIBIDA!</strong> El monto en efectivo (${montoEfectivo.toLocaleString('es-MX')} MXN) excede el límite legal de ${LIMITE_EFECTIVO_PLD.toLocaleString('es-MX')} MXN establecido en el Art. 32 de la LFPIORPI.
            </div>
        `;
        alertsHTML += cashAlert;
    }
    
    alertContainer.html(alertsHTML);
}

// Función para mostrar/ocultar domicilio extranjero
function toggleDomicilioExtranjero(tipo) {
    const checkbox = $('#' + tipo + '_tiene_domicilio_extranjero');
    const domicilioSection = $('#' + tipo + '_domicilio_extranjero');
    
    if (checkbox.is(':checked')) {
        domicilioSection.show();
    } else {
        domicilioSection.hide();
        domicilioSection.find('input').val('').removeAttr('required');
    }
}

// Validación de código postal (6 dígitos) y otras validaciones
$(document).ready(function() {
    $('#codigo_postal, #pf_codigo_postal, #pm_codigo_postal, #fid_codigo_postal').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    $(document).on('input', '[id$="_cp"]', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    $('a[data-target="#modalAgregarOperacion"]').off('click').on('click', function(e) {
        e.preventDefault();
        abrirModalOperacion();
    });
    
    $('#formAgregarOperacion').on('submit', function(e) {
        const montoEfectivo = parseFloat($('#monto_efectivo').val()) || 0;
        
        if (montoEfectivo > LIMITE_EFECTIVO_PLD) {
            e.preventDefault();
            alert('No se puede registrar la operación. El monto en efectivo excede el límite legal permitido.');
            return false;
        }
        
        const moneda = $('#moneda').val();
        const otraMoneda = $('#moneda_otra').val();
        if (moneda === 'otra' && !otraMoneda.trim()) {
            e.preventDefault();
            alert('Por favor especifique la moneda en el campo correspondiente.');
            $('#moneda_otra').focus();
            return false;
        }
        
        const tipoCliente = $('#hidden_tipo_cliente').val();
        let camposRequeridos = ['fecha_operacion', 'tipo_operacion', 'monto_operacion', 'tipo_propiedad', 'codigo_postal'];
        
        if (tipoCliente === 'Persona Física') {
            camposRequeridos = camposRequeridos.concat(['pf_nombre', 'pf_apellido_paterno', 'pf_rfc']);
        } else if (tipoCliente === 'Persona Moral') {
            camposRequeridos = camposRequeridos.concat(['pm_razon_social', 'pm_rfc']);
        } else if (tipoCliente === 'Fideicomiso') {
            camposRequeridos = camposRequeridos.concat(['fid_razon_social', 'fid_rfc']);
        }
        
        for (let campo of camposRequeridos) {
            const elemento = $('#' + campo);
            if (elemento.length && !elemento.val().trim()) {
                e.preventDefault();
                alert('Por favor complete todos los campos obligatorios marcados con *');
                elemento.focus();
                return false;
            }
        }
        
        if (tipoCliente === 'Persona Moral') {
            const beneficiariosPM = $('#pm_beneficiarios_container .beneficiario-card').length;
            if (beneficiariosPM === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un Beneficiario Controlador para Persona Moral.');
                return false;
            }
        }
        
        if (tipoCliente === 'Fideicomiso') {
            const totalBeneficiarios = $('#fid_fideicomitente_container .beneficiario-card').length +
                                     $('#fid_fiduciario_container .beneficiario-card').length +
                                     $('#fid_fideicomisario_container .beneficiario-card').length +
                                     $('#fid_control_efectivo_container .beneficiario-card').length;
            
            if (totalBeneficiarios === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un Beneficiario Controlador en cualquiera de los roles del Fideicomiso.');
                return false;
            }
        }
    });
});
</script>
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


























