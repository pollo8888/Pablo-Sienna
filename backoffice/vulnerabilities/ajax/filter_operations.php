<?php
// =================================================================
// ARCHIVO: backoffice/vulnerabilities/ajax/filter_operations.php
// Handler AJAX para filtrar operaciones
// =================================================================

session_start();
require_once '../../../app/OperationController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operationController = new OperationController();
    
    // Construir filtros
    $filters = [];
    
    // Mapear tipo de cliente
    $tipoClienteMap = [
        'personas-fisicas' => 'persona_fisica',
        'personas-morales' => 'persona_moral',
        'fideicomisos' => 'fideicomiso'
    ];
    
    if (!empty($_POST['tipo_cliente']) && isset($tipoClienteMap[$_POST['tipo_cliente']])) {
        $filters['tipo_cliente'] = $tipoClienteMap[$_POST['tipo_cliente']];
    }
    
    if (!empty($_POST['year'])) {
        $filters['year'] = $_POST['year'];
    }
    
    if (!empty($_POST['month']) && $_POST['month'] !== 'all') {
        $filters['month'] = $_POST['month'];
    }
    
    if (!empty($_POST['status']) && $_POST['status'] !== 'all') {
        $filters['status'] = $_POST['status'];
    }
    
    try {
        $operations = $operationController->getOperations($filters);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $operations,
            'total' => count($operations)
        ]);
        
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>