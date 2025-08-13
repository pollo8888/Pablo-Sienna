<?php
// =================================================================
// CONTROLADOR PARA OPERACIONES VULNERABLES
// Archivo: app/OperationController.php
// =================================================================

require_once 'Connector.php';

class OperationController
{
    private $connection;

    public function __construct()
    {
        $connector = new Connector();
        $this->connection = $connector->connection();
    }

    /**
     * Crear nueva operación vulnerable
     */
    public function createOperation($operationData)
    {
        try {
            $this->connection->beginTransaction();

            // 1. INSERTAR OPERACIÓN PRINCIPAL
            $operationId = $this->insertMainOperation($operationData);

            // 2. INSERTAR DATOS ESPECÍFICOS SEGÚN TIPO DE CLIENTE
            switch ($operationData['tipo_cliente']) {
                case 'Persona Física':
                    $this->insertPersonaFisica($operationId, $operationData);
                    break;
                case 'Persona Moral':
                    $pmId = $this->insertPersonaMoral($operationId, $operationData);
                    $this->insertBeneficiarios($pmId, $operationData);
                    break;
                case 'Fideicomiso':
                    $fidId = $this->insertFideicomiso($operationId, $operationData);
                    $this->insertFideicomisoRoles($fidId, $operationData);
                    break;
            }

            $this->connection->commit();
            return ['success' => true, 'operation_id' => $operationId];

        } catch (Exception $e) {
            $this->connection->rollback();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Insertar operación principal
     */

    /**
     * Insertar operación principal (VERSIÓN CORREGIDA)
     */
    private function insertMainOperation($data)
    {
        $sql = "INSERT INTO vulnerable_operations (
            id_user_operation, id_company_operation, id_client_operation, key_operation,
            tipo_cliente, tipo_operacion, fecha_operacion, monto_operacion, moneda, moneda_otra,
            forma_pago, monto_efectivo, tipo_propiedad, uso_inmueble, direccion_inmueble,
            codigo_postal, folio_escritura, propietario_anterior, requiere_aviso_sat,
            umbral_superado, observaciones, status_operation, created_at_operation, updated_at_operation
        ) VALUES (
            :id_user, :id_company, :id_client, :key_operation,
            :tipo_cliente, :tipo_operacion, :fecha_operacion, :monto_operacion, :moneda, :moneda_otra,
            :forma_pago, :monto_efectivo, :tipo_propiedad, :uso_inmueble, :direccion_inmueble,
            :codigo_postal, :folio_escritura, :propietario_anterior, :requiere_aviso_sat,
            :umbral_superado, :observaciones, 1, NOW(), NOW()
        )";

        $stmt = $this->connection->prepare($sql);

        // Calcular si requiere aviso SAT
        $requiereAviso = $this->calcularAvisoSAT($data['tipo_operacion'], $data['monto_operacion']);

        // ✅ FUNCIÓN PARA LIMPIAR VALORES DECIMALES
        $cleanDecimal = function ($value) {
            if (empty($value) || $value === '' || $value === null) {
                return null;
            }
            return floatval($value);
        };

        // ✅ FUNCIÓN PARA LIMPIAR STRINGS
        $cleanString = function ($value) {
            if (empty($value) || $value === '') {
                return null;
            }
            return trim($value);
        };

        $stmt->execute([
            ':id_user' => $_SESSION['user']['id_user'],
            ':id_company' => $this->getCompanyId($data),
            ':id_client' => $this->getClientId($data),
            ':key_operation' => $data['key_operation'],
            ':tipo_cliente' => $this->mapTipoCliente($data['tipo_cliente']),
            ':tipo_operacion' => $data['tipo_operacion'],
            ':fecha_operacion' => $data['fecha_operacion'],
            ':monto_operacion' => $cleanDecimal($data['monto_operacion']), // ✅ Limpiar decimal
            ':moneda' => $data['moneda'],
            ':moneda_otra' => $cleanString($data['moneda_otra']), // ✅ Limpiar string
            ':forma_pago' => $data['forma_pago'],
            ':monto_efectivo' => $cleanDecimal($data['monto_efectivo']), // ✅ AQUÍ ESTABA EL PROBLEMA
            ':tipo_propiedad' => $data['tipo_propiedad'],
            ':uso_inmueble' => $cleanString($data['uso_inmueble']),
            ':direccion_inmueble' => $cleanString($data['direccion_inmueble']),
            ':codigo_postal' => $cleanString($data['codigo_postal']),
            ':folio_escritura' => $cleanString($data['folio_escritura']),
            ':propietario_anterior' => $cleanString($data['propietario_anterior']),
            ':requiere_aviso_sat' => $requiereAviso['requiere'],
            ':umbral_superado' => $requiereAviso['umbral_superado'],
            ':observaciones' => $cleanString($data['observaciones'])
        ]);

        return $this->connection->lastInsertId();
    }

    /**
     * Insertar datos de Persona Física
     */
    private function insertPersonaFisica($operationId, $data)
    {
        $sql = "INSERT INTO operation_persona_fisica (
            id_operation, pf_nombre, pf_apellido_paterno, pf_apellido_materno, pf_rfc, pf_curp,
            pf_fecha_nacimiento, pf_nacionalidad, pf_telefono, pf_email, pf_pais, pf_estado,
            pf_ciudad, pf_colonia, pf_calle, pf_num_exterior, pf_num_interior, pf_codigo_postal,
            pf_tiene_domicilio_extranjero, pf_pais_extranjero, pf_estado_extranjero,
            pf_ciudad_extranjero, pf_direccion_extranjero, pf_codigo_postal_extranjero
        ) VALUES (
            :id_operation, :nombre, :paterno, :materno, :rfc, :curp,
            :fecha_nacimiento, :nacionalidad, :telefono, :email, :pais, :estado,
            :ciudad, :colonia, :calle, :num_exterior, :num_interior, :codigo_postal,
            :tiene_extranjero, :pais_ext, :estado_ext, :ciudad_ext, :direccion_ext, :cp_ext
        )";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':id_operation' => $operationId,
            ':nombre' => $data['pf_nombre'],
            ':paterno' => $data['pf_apellido_paterno'],
            ':materno' => $data['pf_apellido_materno'] ?? null,
            ':rfc' => $data['pf_rfc'],
            ':curp' => $data['pf_curp'] ?? null,
            ':fecha_nacimiento' => $this->cleanDate($data['pf_fecha_nacimiento']),
            ':nacionalidad' => 'Mexicana',
            ':telefono' => $data['pf_telefono'] ?? null,
            ':email' => $data['pf_correo'] ?? null,
            ':pais' => 'México',
            ':estado' => $data['pf_estado'] ?? null,
            ':ciudad' => $data['pf_ciudad'] ?? null,
            ':colonia' => $data['pf_colonia'] ?? null,
            ':calle' => $data['pf_calle'] ?? null,
            ':num_exterior' => $data['pf_num_exterior'] ?? null,
            ':num_interior' => $data['pf_num_interior'] ?? null,
            ':codigo_postal' => $data['pf_codigo_postal'] ?? null,
            ':tiene_extranjero' => isset($data['pf_pais_origen']) ? 1 : 0,
            ':pais_ext' => $data['pf_pais_origen'] ?? null,
            ':estado_ext' => $data['pf_estado_provincia_ext'] ?? null,
            ':ciudad_ext' => $data['pf_ciudad_poblacion_ext'] ?? null,
            ':direccion_ext' => $this->buildDireccionExtranjero($data, 'pf'),
            ':cp_ext' => $data['pf_codigo_postal_ext'] ?? null
        ]);
    }

    /**
     * Insertar datos de Persona Moral (VERSIÓN COMPLETA)
     */
    private function insertPersonaMoral($operationId, $data)
    {
        $sql = "INSERT INTO operation_persona_moral (
            id_operation, pm_razon_social, pm_rfc, pm_fecha_constitucion, pm_pais_constitucion,
            pm_giro_mercantil, pm_pais, pm_estado, pm_ciudad, pm_colonia, pm_calle,
            pm_num_exterior, pm_num_interior, pm_codigo_postal, pm_tiene_domicilio_extranjero,
            pm_pais_extranjero, pm_estado_extranjero, pm_ciudad_extranjero, pm_direccion_extranjero,
            pm_codigo_postal_extranjero, pm_representante_nombre, pm_representante_paterno,
            pm_representante_materno, pm_representante_rfc, pm_representante_curp, pm_telefono, pm_email
        ) VALUES (
            :id_operation, :razon_social, :rfc, :fecha_constitucion, :pais_constitucion,
            :giro, :pais, :estado, :ciudad, :colonia, :calle, :num_ext, :num_int, :cp,
            :tiene_extranjero, :pais_ext, :estado_ext, :ciudad_ext, :direccion_ext, :cp_ext,
            :rep_nombre, :rep_paterno, :rep_materno, :rep_rfc, :rep_curp, :telefono, :email
        )";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':id_operation' => $operationId,
            ':razon_social' => $data['pm_razon_social'],
            ':rfc' => $data['pm_rfc'],
            ':fecha_constitucion' => $data['pm_fecha_constitucion'] ?? null,
            ':pais_constitucion' => 'México',
            ':giro' => null,
            ':pais' => 'México',
            ':estado' => $data['pm_estado'] ?? null,
            ':ciudad' => $data['pm_ciudad'] ?? null,
            ':colonia' => $data['pm_colonia'] ?? null,
            ':calle' => $data['pm_calle'] ?? null,
            ':num_ext' => $data['pm_num_exterior'] ?? null,
            ':num_int' => $data['pm_num_interior'] ?? null,
            ':cp' => $data['pm_codigo_postal'] ?? null,
            ':tiene_extranjero' => isset($data['pm_pais_origen']) ? 1 : 0,
            ':pais_ext' => $data['pm_pais_origen'] ?? null,
            ':estado_ext' => $data['pm_estado_provincia_ext'] ?? null,
            ':ciudad_ext' => $data['pm_ciudad_poblacion_ext'] ?? null,
            ':direccion_ext' => $this->buildDireccionExtranjero($data, 'pm'),
            ':cp_ext' => $data['pm_codigo_postal_ext'] ?? null,
            ':rep_nombre' => $data['pm_apoderado_nombre'] ?? null,
            ':rep_paterno' => $data['pm_apoderado_paterno'] ?? null,
            ':rep_materno' => $data['pm_apoderado_materno'] ?? null,
            ':rep_rfc' => $data['pm_apoderado_rfc'] ?? null,
            ':rep_curp' => $data['pm_apoderado_curp'] ?? null,
            ':telefono' => $data['pm_telefono'] ?? null,
            ':email' => $data['pm_correo'] ?? null
        ]);

        return $this->connection->lastInsertId();
    }

    /**
     * Insertar beneficiarios controladores
     */
    private function insertBeneficiarios($pmId, $data)
    {
        // Buscar todos los beneficiarios en los datos
        foreach ($data as $key => $value) {
            if (strpos($key, 'pm_bc_') === 0 && strpos($key, '_nombre') !== false) {
                $prefix = str_replace('_nombre', '', $key);

                if (!empty($value)) {
                    $sql = "INSERT INTO operation_beneficiarios (
                        id_pm, beneficiario_nombre, beneficiario_paterno, beneficiario_materno,
                        beneficiario_rfc, beneficiario_curp, beneficiario_fecha_nacimiento,
                        beneficiario_nacionalidad, beneficiario_pais_nacimiento, beneficiario_tipo_participacion,
                        beneficiario_porcentaje, beneficiario_fecha_bc, beneficiario_es_directo,
                        cadena_titularidad, descripcion_cadena, beneficiario_estado, beneficiario_ciudad,
                        beneficiario_colonia, beneficiario_calle, beneficiario_num_exterior,
                        beneficiario_num_interior, beneficiario_cp, beneficiario_correo, beneficiario_telefono
                    ) VALUES (
                        :id_pm, :nombre, :paterno, :materno, :rfc, :curp, :fecha_nacimiento,
                        :nacionalidad, :pais_nacimiento, :tipo_participacion, :porcentaje, :fecha_bc, :es_directo,
                        :cadena, :descripcion, :estado, :ciudad, :colonia, :calle, :num_ext, :num_int, :cp, :correo, :telefono
                    )";

                    $stmt = $this->connection->prepare($sql);
                    $stmt->execute([
                        ':id_pm' => $pmId,
                        ':nombre' => $data[$prefix . '_nombre'],
                        ':paterno' => $data[$prefix . '_apellido_paterno'] ?? '',
                        ':materno' => $data[$prefix . '_apellido_materno'] ?? null,
                        ':rfc' => $data[$prefix . '_rfc'] ?? '',
                        ':curp' => $data[$prefix . '_curp'] ?? null,
                        ':fecha_nacimiento' => $this->cleanDate($data['pf_fecha_nacimiento']),
                        ':nacionalidad' => $data[$prefix . '_nacionalidad'] ?? 'Mexicana',
                        ':pais_nacimiento' => $data[$prefix . '_pais_nacimiento'] ?? 'México',
                        ':tipo_participacion' => $data[$prefix . '_tipo_participacion'] ?? null,
                        ':porcentaje' => $data[$prefix . '_porcentaje'] ?? null,
                        ':fecha_bc' => $data[$prefix . '_fecha_bc'] ?? null,
                        ':es_directo' => $data[$prefix . '_es_directo'] ?? 'si',
                        ':cadena' => $data[$prefix . '_cadena_titularidad'] ?? 'no',
                        ':descripcion' => $data[$prefix . '_descripcion_cadena_text'] ?? null,
                        ':estado' => $data[$prefix . '_estado'] ?? null,
                        ':ciudad' => $data[$prefix . '_ciudad'] ?? null,
                        ':colonia' => $data[$prefix . '_colonia'] ?? null,
                        ':calle' => $data[$prefix . '_calle'] ?? null,
                        ':num_ext' => $data[$prefix . '_num_exterior'] ?? null,
                        ':num_int' => $data[$prefix . '_num_interior'] ?? null,
                        ':cp' => $data[$prefix . '_cp'] ?? null,
                        ':correo' => $data[$prefix . '_correo'] ?? null,
                        ':telefono' => $data[$prefix . '_telefono'] ?? null
                    ]);
                }
            }
        }
    }

    /**
     * Agregar método para eliminar operación
     */
    public function deleteOperation($operationId)
    {
        try {
            $sql = "UPDATE vulnerable_operations 
                    SET status_operation = 0, deleted_at_operation = NOW() 
                    WHERE id_operation = :id";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id' => $operationId]);

            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Insertar datos de Fideicomiso (VERSIÓN COMPLETA)
     */
    private function insertFideicomiso($operationId, $data)
    {
        $sql = "INSERT INTO operation_fideicomiso (
            id_operation, fid_numero_contrato, fid_fecha_contrato, fid_tipo_fideicomiso,
            fid_proposito, fid_numero_referencia, fid_pais, fid_estado, fid_ciudad,
            fid_colonia, fid_calle, fid_num_exterior, fid_num_interior, fid_codigo_postal,
            fid_tiene_domicilio_extranjero, fid_pais_extranjero, fid_estado_extranjero,
            fid_ciudad_extranjero, fid_direccion_extranjero, fid_codigo_postal_extranjero,
            fid_apoderado_nombre, fid_apoderado_paterno, fid_apoderado_materno,
            fid_telefono, fid_email, fid_razon_social, fid_rfc
        ) VALUES (
            :id_operation, :numero_contrato, :fecha_contrato, :tipo, :proposito, :numero_ref,
            :pais, :estado, :ciudad, :colonia, :calle, :num_ext, :num_int, :cp,
            :tiene_extranjero, :pais_ext, :estado_ext, :ciudad_ext, :direccion_ext, :cp_ext,
            :apod_nombre, :apod_paterno, :apod_materno, :telefono, :email, :razon_social, :rfc
        )";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':id_operation' => $operationId,
            ':numero_contrato' => $data['fid_numero_referencia'] ?? null,
            ':fecha_contrato' => null,
            ':tipo' => 'Inmobiliario',
            ':proposito' => 'Operación inmobiliaria',
            ':numero_ref' => $data['fid_numero_referencia'] ?? null,
            ':pais' => 'México',
            ':estado' => $data['fid_estado'] ?? null,
            ':ciudad' => $data['fid_ciudad'] ?? null,
            ':colonia' => $data['fid_colonia'] ?? null,
            ':calle' => $data['fid_calle'] ?? null,
            ':num_ext' => $data['fid_num_exterior'] ?? null,
            ':num_int' => $data['fid_num_interior'] ?? null,
            ':cp' => $data['fid_codigo_postal'] ?? null,
            ':tiene_extranjero' => isset($data['fid_pais_origen']) ? 1 : 0,
            ':pais_ext' => $data['fid_pais_origen'] ?? null,
            ':estado_ext' => $data['fid_estado_provincia_ext'] ?? null,
            ':ciudad_ext' => $data['fid_ciudad_poblacion_ext'] ?? null,
            ':direccion_ext' => $this->buildDireccionExtranjero($data, 'fid'),
            ':cp_ext' => $data['fid_codigo_postal_ext'] ?? null,
            ':apod_nombre' => $data['fid_apoderado_nombre'] ?? null,
            ':apod_paterno' => $data['fid_apoderado_paterno'] ?? null,
            ':apod_materno' => $data['fid_apoderado_materno'] ?? null,
            ':telefono' => $data['fid_telefono'] ?? null,
            ':email' => $data['fid_correo'] ?? null,
            ':razon_social' => $data['fid_razon_social'] ?? null,
            ':rfc' => $data['fid_rfc'] ?? null
        ]);

        return $this->connection->lastInsertId();
    }

    /**
     * Insertar roles del fideicomiso (VERSIÓN CORREGIDA)
     */
    private function insertFideicomisoRoles($fidId, $data)
    {
        $roles = ['fideicomitente', 'fiduciario', 'fideicomisario', 'control_efectivo'];

        foreach ($roles as $rol) {
            foreach ($data as $key => $value) {
                if (strpos($key, "fid_{$rol}_") === 0 && strpos($key, '_nombre') !== false) {
                    $prefix = str_replace('_nombre', '', $key);

                    if (!empty($value)) {
                        $tableName = "operation_" . ($rol === 'control_efectivo' ? 'control_efectivo' : $rol . 's');
                        $namePrefix = $rol === 'control_efectivo' ? 'control' : $rol;

                        $sql = "INSERT INTO {$tableName} (
                            id_fid, {$namePrefix}_nombre, {$namePrefix}_paterno, {$namePrefix}_materno,
                            {$namePrefix}_rfc, {$namePrefix}_curp, {$namePrefix}_fecha_nacimiento,
                            {$namePrefix}_nacionalidad, {$namePrefix}_pais_nacimiento, {$namePrefix}_tipo_participacion,
                            {$namePrefix}_porcentaje, {$namePrefix}_fecha_bc, {$namePrefix}_es_directo,
                            cadena_titularidad, descripcion_cadena, {$namePrefix}_estado, {$namePrefix}_ciudad,
                            {$namePrefix}_colonia, {$namePrefix}_calle, {$namePrefix}_num_exterior,
                            {$namePrefix}_num_interior, {$namePrefix}_cp, {$namePrefix}_correo, {$namePrefix}_telefono
                        ) VALUES (
                            :id_fid, :nombre, :paterno, :materno, :rfc, :curp, :fecha_nacimiento,
                            :nacionalidad, :pais_nacimiento, :tipo_participacion, :porcentaje, :fecha_bc, :es_directo,
                            :cadena, :descripcion, :estado, :ciudad, :colonia, :calle, :num_ext, :num_int, :cp, :correo, :telefono
                        )";

                        $stmt = $this->connection->prepare($sql);
                        $stmt->execute([
                            ':id_fid' => $fidId,
                            ':nombre' => $data[$prefix . '_nombre'],
                            ':paterno' => $data[$prefix . '_apellido_paterno'] ?? '',
                            ':materno' => $data[$prefix . '_apellido_materno'] ?? null,
                            ':rfc' => $data[$prefix . '_rfc'] ?? '',
                            ':curp' => $data[$prefix . '_curp'] ?? null,
                            ':fecha_nacimiento' => $data[$prefix . '_fecha_nacimiento'] ?? null,
                            ':nacionalidad' => $data[$prefix . '_nacionalidad'] ?? 'Mexicana',
                            ':pais_nacimiento' => $data[$prefix . '_pais_nacimiento'] ?? 'México',
                            ':tipo_participacion' => $data[$prefix . '_tipo_participacion'] ?? null,
                            ':porcentaje' => $data[$prefix . '_porcentaje'] ?? null,
                            ':fecha_bc' => $data[$prefix . '_fecha_bc'] ?? null,
                            ':es_directo' => $data[$prefix . '_es_directo'] ?? 'si',
                            ':cadena' => $data[$prefix . '_cadena_titularidad'] ?? 'no',
                            ':descripcion' => $data[$prefix . '_descripcion_cadena_text'] ?? null,
                            ':estado' => $data[$prefix . '_estado'] ?? null,
                            ':ciudad' => $data[$prefix . '_ciudad'] ?? null,
                            ':colonia' => $data[$prefix . '_colonia'] ?? null,
                            ':calle' => $data[$prefix . '_calle'] ?? null,
                            ':num_ext' => $data[$prefix . '_num_exterior'] ?? null,
                            ':num_int' => $data[$prefix . '_num_interior'] ?? null,
                            ':cp' => $data[$prefix . '_cp'] ?? null,
                            ':correo' => $data[$prefix . '_correo'] ?? null,
                            ':telefono' => $data[$prefix . '_telefono'] ?? null
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Funciones auxiliares
     */
    private function mapTipoCliente($tipo)
    {
        $map = [
            'Persona Física' => 'persona_fisica',
            'Persona Moral' => 'persona_moral',
            'Fideicomiso' => 'fideicomiso'
        ];
        return $map[$tipo] ?? 'persona_fisica';
    }

    private function calcularAvisoSAT($tipoOperacion, $monto)
    {
        // Obtener umbrales de la tabla pld_thresholds
        $sql = "SELECT monto_minimo FROM pld_thresholds WHERE tipo_operacion = :tipo AND activo = 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':tipo' => $tipoOperacion]);
        $umbral = $stmt->fetchColumn();

        if (!$umbral) {
            $umbral = 1605000; // Umbral por defecto
        }

        return [
            'requiere' => $monto >= $umbral ? 1 : 0,
            'umbral_superado' => $monto >= $umbral ? 1 : 0
        ];
    }

    private function buildDireccionExtranjero($data, $prefix)
    {
        $parts = [];
        if (!empty($data[$prefix . '_calle_ext']))
            $parts[] = $data[$prefix . '_calle_ext'];
        if (!empty($data[$prefix . '_num_exterior_ext']))
            $parts[] = $data[$prefix . '_num_exterior_ext'];
        if (!empty($data[$prefix . '_colonia_ext']))
            $parts[] = $data[$prefix . '_colonia_ext'];

        return implode(', ', $parts) ?: null;
    }



    private function getClientId($data)
    {
        // Obtener ID del cliente si existe
        return $_SESSION['client_id'] ?? null;
    }

    /**
     * Obtener operaciones para mostrar en tabla
     */
public function getOperations($filters = [])
{
    $sql = "SELECT 
        vo.id_operation,
        vo.key_operation,
        vo.fecha_operacion,
        vo.tipo_operacion,
        vo.monto_operacion,
        vo.moneda,
        vo.tipo_cliente,
        vo.requiere_aviso_sat,
        vo.umbral_superado,
        c.name_company AS empresa,
        CASE 
            WHEN vo.tipo_cliente = 'persona_fisica' THEN CONCAT(pf.pf_nombre, ' ', pf.pf_apellido_paterno, ' ', IFNULL(pf.pf_apellido_materno, ''))
            WHEN vo.tipo_cliente = 'persona_moral' THEN pm.pm_razon_social
            WHEN vo.tipo_cliente = 'fideicomiso' THEN CONCAT('Fideicomiso - ', fid.fid_numero_referencia)
            ELSE 'Cliente no identificado'
        END AS cliente,
        vo.tipo_propiedad,
        vo.uso_inmueble,           -- 👈 faltaba
        vo.direccion_inmueble,     -- 👈 faltaba
        vo.codigo_postal,
        vo.folio_escritura,
        vo.propietario_anterior    -- 👈 faltaba
    FROM vulnerable_operations vo
    LEFT JOIN companies c ON vo.id_company_operation = c.id_company
    LEFT JOIN operation_persona_fisica pf ON vo.id_operation = pf.id_operation
    LEFT JOIN operation_persona_moral pm ON vo.id_operation = pm.id_operation
    LEFT JOIN operation_fideicomiso fid ON vo.id_operation = fid.id_operation
    WHERE vo.status_operation = 1";

    $params = [];

    // Mapear filtro a formato de BD
    if (!empty($filters['tipo_cliente'])) {
        $sql .= " AND vo.tipo_cliente = :tipo_cliente";
        $params[':tipo_cliente'] = $this->mapTipoCliente($filters['tipo_cliente']);
    }
    if (!empty($filters['year'])) {
        $sql .= " AND YEAR(vo.fecha_operacion) = :year";
        $params[':year'] = $filters['year'];
    }
    if (!empty($filters['month'])) {
        $sql .= " AND MONTH(vo.fecha_operacion) = :month";
        $params[':month'] = $filters['month'];
    }

    $sql .= " ORDER BY vo.fecha_operacion DESC";

    $stmt = $this->connection->prepare($sql);
    $stmt->execute($params);

    $operations = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $semaforo = $row['requiere_aviso_sat'] ? 'rojo' : ($row['monto_operacion'] > 1000000 ? 'amarillo' : 'verde');

        $operations[] = [
            'id' => $row['id_operation'],
            'empresa' => $row['empresa'],
            'cliente' => $row['cliente'],
            'fecha_operacion' => $row['fecha_operacion'],
            'tipo_propiedad' => $row['tipo_propiedad'],
            'uso_inmueble' => $row['uso_inmueble'],
            'direccion_inmueble' => $row['direccion_inmueble'],
            'folio_escritura' => $row['folio_escritura'] ?? 'N/A',
            'codigo_postal' => $row['codigo_postal'],
            'propietario_anterior' => $row['propietario_anterior'],
            'semaforo' => $semaforo,
            'empresa_missing_info' => false,
            'cliente_missing_info' => false
        ];
    }

    return $operations;
}



    /**
     * AGREGAR ESTOS MÉTODOS HELPER AL FINAL DE TU OperationController
     */

    /**
     * Limpiar valores decimales vacíos
     */
    private function cleanDecimal($value)
    {
        if (empty($value) || $value === '' || $value === null || $value === '0') {
            return null;
        }
        return floatval($value);
    }

    /**
     * Limpiar strings vacíos  
     */
    private function cleanString($value)
    {
        if (empty($value) || $value === '' || trim($value) === '') {
            return null;
        }
        return trim($value);
    }

    /**
     * Limpiar fechas vacías
     */
    private function cleanDate($value)
    {
        if (empty($value) || $value === '' || $value === '0000-00-00') {
            return null;
        }
        return $value;
    }

    /**
     * Actualizar getCompanyId para manejar mejor los IDs
     */
    private function getCompanyId($data)
    {
        // Intentar obtener de diferentes fuentes
        if (isset($_SESSION['current_company_id'])) {
            return $_SESSION['current_company_id'];
        }
        if (isset($_SESSION['user']['id_company']) && !empty($_SESSION['user']['id_company'])) {
            return $_SESSION['user']['id_company'];
        }

        // Valor por defecto - obtener la primera empresa disponible
        try {
            $sql = "SELECT id_company FROM companies WHERE status_company = 1 LIMIT 1";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result ?: 1;
        } catch (Exception $e) {
            return 1; // Fallback
        }
    }



    public function getOperationDetail($idOperation)
{
    // Operación + empresa + joins a tablas específicas
    $sql = "SELECT 
              vo.*,
              c.name_company,
              pf.id_operation IS NOT NULL AS has_pf,
              pm.id_operation IS NOT NULL AS has_pm,
              fid.id_operation IS NOT NULL AS has_fid,

              -- PF
              pf.pf_nombre, pf.pf_apellido_paterno, pf.pf_apellido_materno, pf.pf_rfc, pf.pf_curp,
              pf.pf_fecha_nacimiento, pf.pf_telefono, pf.pf_email, pf.pf_estado, pf.pf_ciudad, pf.pf_colonia,
              pf.pf_calle, pf.pf_num_exterior, pf.pf_num_interior, pf.pf_codigo_postal,
              pf.pf_tiene_domicilio_extranjero, pf.pf_pais_extranjero, pf.pf_estado_extranjero,
              pf.pf_ciudad_extranjero, pf.pf_direccion_extranjero, pf.pf_codigo_postal_extranjero,

              -- PM
              pm.pm_razon_social, pm.pm_rfc, pm.pm_fecha_constitucion,
              pm.pm_estado, pm.pm_ciudad, pm.pm_colonia, pm.pm_calle,
              pm.pm_num_exterior, pm.pm_num_interior, pm.pm_codigo_postal,
              pm.pm_tiene_domicilio_extranjero, pm.pm_pais_extranjero, pm.pm_estado_extranjero,
              pm.pm_ciudad_extranjero, pm.pm_direccion_extranjero, pm.pm_codigo_postal_extranjero,
              pm.pm_representante_nombre, pm.pm_representante_paterno, pm.pm_representante_materno,
              pm.pm_representante_rfc, pm.pm_representante_curp, pm.pm_telefono, pm.pm_email,

              -- FID
              fid.fid_numero_contrato, fid.fid_fecha_contrato, fid.fid_tipo_fideicomiso,
              fid.fid_proposito, fid.fid_numero_referencia, fid.fid_estado, fid.fid_ciudad, fid.fid_colonia,
              fid.fid_calle, fid.fid_num_exterior, fid.fid_num_interior, fid.fid_codigo_postal,
              fid.fid_tiene_domicilio_extranjero, fid.fid_pais_extranjero, fid.fid_estado_extranjero,
              fid.fid_ciudad_extranjero, fid.fid_direccion_extranjero, fid.fid_codigo_postal_extranjero,
              fid.fid_apoderado_nombre, fid.fid_apoderado_paterno, fid.fid_apoderado_materno,
              fid.fid_telefono, fid.fid_email, fid.fid_razon_social, fid.fid_rfc

            FROM vulnerable_operations vo
            LEFT JOIN companies c ON vo.id_company_operation = c.id_company
            LEFT JOIN operation_persona_fisica pf ON vo.id_operation = pf.id_operation
            LEFT JOIN operation_persona_moral pm ON vo.id_operation = pm.id_operation
            LEFT JOIN operation_fideicomiso fid ON vo.id_operation = fid.id_operation
            WHERE vo.id_operation = :id AND vo.status_operation = 1";

    $stmt = $this->connection->prepare($sql);
    $stmt->execute([':id' => $idOperation]);
    $main = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$main) {
        throw new Exception('Operación no encontrada.');
    }

    // Beneficiarios (solo si es PM)
    $beneficiarios = [];
    if (!empty($main['has_pm'])) {
        // Obtener id_pm
        $stmtPm = $this->connection->prepare("SELECT id_pm FROM operation_persona_moral WHERE id_operation = :id");
        $stmtPm->execute([':id' => $idOperation]);
        $idPm = $stmtPm->fetchColumn();

        if ($idPm) {
            $stmtB = $this->connection->prepare("SELECT * FROM operation_beneficiarios WHERE id_pm = :id_pm ORDER BY beneficiario_nombre ASC");
            $stmtB->execute([':id_pm' => $idPm]);
            $beneficiarios = $stmtB->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    // Roles de fideicomiso (si aplica)
    $roles = [
        'fideicomitentes' => [],
        'fiduciarios' => [],
        'fideicomisarios' => [],
        'control_efectivo' => []
    ];
    if (!empty($main['has_fid'])) {
        // Obtener id_fid
        $stmtF = $this->connection->prepare("SELECT id_fid FROM operation_fideicomiso WHERE id_operation = :id");
        $stmtF->execute([':id' => $idOperation]);
        $idFid = $stmtF->fetchColumn();

        if ($idFid) {
            foreach (['fideicomitentes','fiduciarios','fideicomisarios','control_efectivo'] as $tabla) {
                $table = $tabla === 'control_efectivo' ? 'operation_control_efectivo' : "operation_{$tabla}";
                $stmtR = $this->connection->prepare("SELECT * FROM {$table} WHERE id_fid = :id_fid ORDER BY 1");
                $stmtR->execute([':id_fid' => $idFid]);
                $roles[$tabla] = $stmtR->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }

    // Normaliza tipo_cliente a etiqueta de UI
    $mapBackToUi = [
        'persona_fisica' => 'Persona Física',
        'persona_moral'  => 'Persona Moral',
        'fideicomiso'    => 'Fideicomiso'
    ];

    $main['tipo_cliente_ui'] = $mapBackToUi[$main['tipo_cliente']] ?? 'Persona Física';

    return [
        'main' => $main,
        'beneficiarios' => $beneficiarios,
        'roles' => $roles
    ];
}

}