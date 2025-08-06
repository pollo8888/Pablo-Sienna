  <!-- Modal para agregar nuevo cliente -->
  <div class="modal fade" id="modalAgregarCliente" tabindex="-1" aria-labelledby="modalAgregarClienteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAgregarClienteLabel">Agregar nuevo cliente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- Formulario para agregar cliente -->
          <form id="formAgregarCliente" action="subfolder.php" method="POST">
            <input name="folder[id_user_folder]" type="hidden" value="<?php echo $_SESSION['user']['id_user']; ?>">
            <input name="folder[key_folder]" type="hidden" value="CLI-<?php echo $clave; ?>">
            <input name="folder[fk_folder]" type="hidden" value="<?php echo $folder['id_folder']; ?>">

            <!-- Select para tipo de persona -->
            <div class="form-group">
              <label for="tipo_persona">Tipo de persona: <span style="color: red;">*</span></label>
              <select name="folder[tipo_persona]" id="tipo_persona" class="form-control" required>
                <option value="">-- Seleccionar tipo --</option>
                <option value="fisica">Persona Física</option>
                <option value="moral">Persona Moral</option>
                <option value="fideicomiso">Fideicomiso</option>
              </select>
            </div>

            <!-- SECCIÓN PERSONA FÍSICA -->
            <div id="seccion_fisica" style="display: none;">
              <div class="form-section">
                <h6><i class="fas fa-user"></i> Información de la Persona Física</h6>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="pf_nombre">Nombre: <span style="color: red;">*</span></label>
                      <input type="text" name="folder[pf_nombre]" class="form-control" id="pf_nombre"
                        placeholder="Ej. Juan">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="pf_apellido_paterno">Apellido Paterno: <span style="color: red;">*</span></label>
                      <input type="text" name="folder[pf_apellido_paterno]" class="form-control"
                        id="pf_apellido_paterno" placeholder="Ej. Pérez">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="pf_apellido_materno">Apellido Materno:</label>
                      <input type="text" name="folder[pf_apellido_materno]" class="form-control"
                        id="pf_apellido_materno" placeholder="Ej. López">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="pf_rfc">RFC: <span style="color: red;">*</span></label>
                      <input type="text" name="folder[pf_rfc]" class="form-control" id="pf_rfc" maxlength="13"
                        placeholder="PEPJ850525AB1">
                      <small class="text-muted">Formato: 4 letras + 6 números + 3 caracteres</small>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="pf_curp">CURP:</label>
                      <input type="text" name="folder[pf_curp]" class="form-control" id="pf_curp" maxlength="18"
                        placeholder="PEPJ850525HDFRNS05">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="pf_fecha_nacimiento">Fecha de Nacimiento:</label>
                      <input type="date" name="folder[pf_fecha_nacimiento]" class="form-control"
                        id="pf_fecha_nacimiento">
                    </div>
                  </div>
                </div>

                <h6><i class="fas fa-home"></i> Domicilio Nacional</h6>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pf_estado">Estado:</label>
                      <input type="text" name="folder[pf_estado]" class="form-control" id="pf_estado"
                        placeholder="Ej. Tabasco">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pf_ciudad">Ciudad o Población:</label>
                      <input type="text" name="folder[pf_ciudad]" class="form-control" id="pf_ciudad"
                        placeholder="Ej. Villahermosa">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pf_colonia">Colonia:</label>
                      <input type="text" name="folder[pf_colonia]" class="form-control" id="pf_colonia"
                        placeholder="Ej. Centro">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pf_codigo_postal">Código Postal:</label>
                      <input type="text" name="folder[pf_codigo_postal]" class="form-control" id="pf_codigo_postal"
                        maxlength="5" placeholder="86000">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="pf_calle">Calle:</label>
                      <input type="text" name="folder[pf_calle]" class="form-control" id="pf_calle"
                        placeholder="Ej. Av. Siempre Viva">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="pf_num_exterior">Núm. Exterior:</label>
                      <input type="text" name="folder[pf_num_exterior]" class="form-control" id="pf_num_exterior"
                        placeholder="123">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="pf_num_interior">Núm. Interior:</label>
                      <input type="text" name="folder[pf_num_interior]" class="form-control" id="pf_num_interior"
                        placeholder="A">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="pf_telefono">Teléfono:</label>
                      <input type="tel" name="folder[pf_telefono]" class="form-control" id="pf_telefono"
                        placeholder="9931234567">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="pf_email">Correo Electrónico:</label>
                      <input type="email" name="folder[pf_email]" class="form-control" id="pf_email"
                        placeholder="correo@ejemplo.com">
                    </div>
                  </div>
                </div>

                <div class="checkbox-section">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="pf_tiene_domicilio_extranjero"
                      name="folder[pf_tiene_domicilio_extranjero]" value="1">
                    <label class="form-check-label" for="pf_tiene_domicilio_extranjero">
                      ¿Tiene domicilio extranjero?
                    </label>
                  </div>
                </div>

                <!-- Domicilio Extranjero PF -->
                <div id="pf_domicilio_extranjero" class="domicilio-extranjero" style="display: none;">
                  <h6><i class="fas fa-globe"></i> Domicilio Extranjero</h6>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="pf_pais_origen">País de Origen:</label>
                        <input type="text" name="folder[pf_pais_origen]" class="form-control" id="pf_pais_origen"
                          placeholder="Ej. Estados Unidos">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="pf_estado_extranjero">Estado o Provincia:</label>
                        <input type="text" name="folder[pf_estado_extranjero]" class="form-control"
                          id="pf_estado_extranjero" placeholder="Ej. Texas">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="pf_ciudad_extranjero">Ciudad o Población:</label>
                        <input type="text" name="folder[pf_ciudad_extranjero]" class="form-control"
                          id="pf_ciudad_extranjero" placeholder="Ej. Houston">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="pf_colonia_extranjero">Colonia del Extranjero:</label>
                        <input type="text" name="folder[pf_colonia_extranjero]" class="form-control"
                          id="pf_colonia_extranjero">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="pf_calle_extranjero">Calle del Extranjero:</label>
                        <input type="text" name="folder[pf_calle_extranjero]" class="form-control"
                          id="pf_calle_extranjero">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="pf_num_exterior_ext">Núm. Exterior (Ext):</label>
                        <input type="text" name="folder[pf_num_exterior_ext]" class="form-control"
                          id="pf_num_exterior_ext">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="pf_num_interior_ext">Núm. Interior (Ext):</label>
                        <input type="text" name="folder[pf_num_interior_ext]" class="form-control"
                          id="pf_num_interior_ext">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="pf_codigo_postal_ext">Código Postal (Ext):</label>
                        <input type="text" name="folder[pf_codigo_postal_ext]" class="form-control"
                          id="pf_codigo_postal_ext">
                      </div>
                    </div>
                  </div>
                </div>


              </div>
            </div>

            <!-- SECCIÓN PERSONA MORAL -->
            <div id="seccion_moral" style="display: none;">
              <div class="form-section">
                <h6><i class="fas fa-building"></i> Información de la Persona Moral</h6>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="pm_razon_social">Razón Social: <span style="color: red;">*</span></label>
                      <input type="text" name="folder[pm_razon_social]" class="form-control" id="pm_razon_social"
                        placeholder="Ej. Empresa SA de CV">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pm_rfc">RFC Persona Moral: <span style="color: red;">*</span></label>
                      <input type="text" name="folder[pm_rfc]" class="form-control" id="pm_rfc" maxlength="12"
                        placeholder="EMP850525ABC">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pm_fecha_constitucion">Fecha de Constitución:</label>
                      <input type="date" name="folder[pm_fecha_constitucion]" class="form-control"
                        id="pm_fecha_constitucion">
                    </div>
                  </div>
                </div>

                <h6><i class="fas fa-user-tie"></i> Apoderado Legal</h6>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pm_apoderado_nombre">Nombre:</label>
                      <input type="text" name="folder[pm_apoderado_nombre]" class="form-control"
                        id="pm_apoderado_nombre">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pm_apoderado_paterno">Apellido Paterno:</label>
                      <input type="text" name="folder[pm_apoderado_paterno]" class="form-control"
                        id="pm_apoderado_paterno">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pm_apoderado_materno">Apellido Materno:</label>
                      <input type="text" name="folder[pm_apoderado_materno]" class="form-control"
                        id="pm_apoderado_materno">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pm_apoderado_fecha_nacimiento">Fecha de nacimiento de representante legal:</label>
                      <input type="date" name="folder[pm_apoderado_fecha_nacimiento]" class="form-control"
                        id="pm_apoderado_fecha_nacimiento">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="pm_apoderado_rfc">RFC Apoderado Legal:</label>
                      <input type="text" name="folder[pm_apoderado_rfc]" class="form-control" id="pm_apoderado_rfc"
                        maxlength="13">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="pm_apoderado_curp">CURP Apoderado Legal:</label>
                      <input type="text" name="folder[pm_apoderado_curp]" class="form-control" id="pm_apoderado_curp"
                        maxlength="18">
                    </div>
                  </div>
                </div>

                <h6><i class="fas fa-home"></i> Domicilio Nacional</h6>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pm_estado">Estado:</label>
                      <input type="text" name="folder[pm_estado]" class="form-control" id="pm_estado">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pm_ciudad">Ciudad o Población:</label>
                      <input type="text" name="folder[pm_ciudad]" class="form-control" id="pm_ciudad">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pm_colonia">Colonia:</label>
                      <input type="text" name="folder[pm_colonia]" class="form-control" id="pm_colonia">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="pm_codigo_postal">Código Postal:</label>
                      <input type="text" name="folder[pm_codigo_postal]" class="form-control" id="pm_codigo_postal"
                        maxlength="5">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="pm_calle">Calle:</label>
                      <input type="text" name="folder[pm_calle]" class="form-control" id="pm_calle">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="pm_num_exterior">Núm. Exterior:</label>
                      <input type="text" name="folder[pm_num_exterior]" class="form-control" id="pm_num_exterior">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="pm_num_interior">Núm. Interior:</label>
                      <input type="text" name="folder[pm_num_interior]" class="form-control" id="pm_num_interior">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="pm_telefono">Teléfono:</label>
                      <input type="tel" name="folder[pm_telefono]" class="form-control" id="pm_telefono">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="pm_email">Correo Electrónico:</label>
                      <input type="email" name="folder[pm_email]" class="form-control" id="pm_email">
                    </div>
                  </div>
                </div>

                <div class="checkbox-section">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="pm_tiene_domicilio_extranjero"
                      name="folder[pm_tiene_domicilio_extranjero]" value="1">
                    <label class="form-check-label" for="pm_tiene_domicilio_extranjero">
                      ¿Tiene domicilio extranjero?
                    </label>
                  </div>
                </div>

                <!-- Domicilio Extranjero PM -->
                <div id="pm_domicilio_extranjero" class="domicilio-extranjero" style="display: none;">
                  <h6><i class="fas fa-globe"></i> Domicilio Extranjero</h6>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="pm_pais_origen">País de Origen:</label>
                        <input type="text" name="folder[pm_pais_origen]" class="form-control" id="pm_pais_origen">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="pm_estado_extranjero">Estado o Provincia:</label>
                        <input type="text" name="folder[pm_estado_extranjero]" class="form-control"
                          id="pm_estado_extranjero">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="pm_ciudad_extranjero">Ciudad o Población:</label>
                        <input type="text" name="folder[pm_ciudad_extranjero]" class="form-control"
                          id="pm_ciudad_extranjero">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="pm_colonia_extranjero">Colonia del Extranjero:</label>
                        <input type="text" name="folder[pm_colonia_extranjero]" class="form-control"
                          id="pm_colonia_extranjero">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="pm_calle_extranjero">Calle del Extranjero:</label>
                        <input type="text" name="folder[pm_calle_extranjero]" class="form-control"
                          id="pm_calle_extranjero">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="pm_num_exterior_ext">Núm. Exterior (Ext):</label>
                        <input type="text" name="folder[pm_num_exterior_ext]" class="form-control"
                          id="pm_num_exterior_ext">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="pm_num_interior_ext">Núm. Interior (Ext):</label>
                        <input type="text" name="folder[pm_num_interior_ext]" class="form-control"
                          id="pm_num_interior_ext">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="pm_codigo_postal_ext">Código Postal Extranjero:</label>
                        <input type="text" name="folder[pm_codigo_postal_ext]" class="form-control"
                          id="pm_codigo_postal_ext">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- SECCIÓN FIDEICOMISO -->
            <div id="seccion_fideicomiso" style="display: none;">
              <div class="form-section">
                <h6><i class="fas fa-handshake"></i> Información del Fideicomiso</h6>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fid_razon_social">Razón Social del Fiduciario: <span
                          style="color: red;">*</span></label>
                      <input type="text" name="folder[fid_razon_social]" class="form-control" id="fid_razon_social"
                        placeholder="Ej. Banco Fiduciario SA">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fid_rfc">RFC del Fiduciario: <span style="color: red;">*</span></label>
                      <input type="text" name="folder[fid_rfc]" class="form-control" id="fid_rfc" maxlength="12"
                        placeholder="BFI850525ABC">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fid_numero_referencia">Número / Referencia de Fideicomiso:</label>
                      <input type="text" name="folder[fid_numero_referencia]" class="form-control"
                        id="fid_numero_referencia" placeholder="FID-12345">
                    </div>
                  </div>
                </div>

                <h6><i class="fas fa-user-tie"></i> Apoderado Legal</h6>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fid_apoderado_nombre">Nombre:</label>
                      <input type="text" name="folder[fid_apoderado_nombre]" class="form-control"
                        id="fid_apoderado_nombre">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fid_apoderado_paterno">Apellido Paterno:</label>
                      <input type="text" name="folder[fid_apoderado_paterno]" class="form-control"
                        id="fid_apoderado_paterno">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fid_apoderado_materno">Apellido Materno:</label>
                      <input type="text" name="folder[fid_apoderado_materno]" class="form-control"
                        id="fid_apoderado_materno">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fid_apoderado_fecha_nacimiento">Fecha de nacimiento de representante legal:</label>
                      <input type="date" name="folder[fid_apoderado_fecha_nacimiento]" class="form-control"
                        id="fid_apoderado_fecha_nacimiento">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fid_apoderado_rfc">RFC Apoderado Legal:</label>
                      <input type="text" name="folder[fid_apoderado_rfc]" class="form-control" id="fid_apoderado_rfc"
                        maxlength="13">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fid_apoderado_curp">CURP Apoderado Legal:</label>
                      <input type="text" name="folder[fid_apoderado_curp]" class="form-control" id="fid_apoderado_curp"
                        maxlength="18">
                    </div>
                  </div>
                </div>

                <h6><i class="fas fa-home"></i> Domicilio Nacional</h6>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fid_estado">Estado:</label>
                      <input type="text" name="folder[fid_estado]" class="form-control" id="fid_estado">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fid_ciudad">Ciudad o Población:</label>
                      <input type="text" name="folder[fid_ciudad]" class="form-control" id="fid_ciudad">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fid_colonia">Colonia:</label>
                      <input type="text" name="folder[fid_colonia]" class="form-control" id="fid_colonia">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fid_codigo_postal">Código Postal:</label>
                      <input type="text" name="folder[fid_codigo_postal]" class="form-control" id="fid_codigo_postal"
                        maxlength="5">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fid_calle">Calle:</label>
                      <input type="text" name="folder[fid_calle]" class="form-control" id="fid_calle">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="fid_num_exterior">Núm. Exterior:</label>
                      <input type="text" name="folder[fid_num_exterior]" class="form-control" id="fid_num_exterior">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="fid_num_interior">Núm. Interior:</label>
                      <input type="text" name="folder[fid_num_interior]" class="form-control" id="fid_num_interior">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="fid_telefono">Teléfono:</label>
                      <input type="tel" name="folder[fid_telefono]" class="form-control" id="fid_telefono">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="fid_email">Correo Electrónico:</label>
                      <input type="email" name="folder[fid_email]" class="form-control" id="fid_email">
                    </div>
                  </div>
                </div>

                <div class="checkbox-section">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="fid_tiene_domicilio_extranjero"
                      name="folder[fid_tiene_domicilio_extranjero]" value="1">
                    <label class="form-check-label" for="fid_tiene_domicilio_extranjero">
                      ¿Tiene domicilio extranjero?
                    </label>
                  </div>
                </div>

                <!-- Domicilio Extranjero Fideicomiso -->
                <div id="fid_domicilio_extranjero" class="domicilio-extranjero" style="display: none;">
                  <h6><i class="fas fa-globe"></i> Domicilio Extranjero</h6>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="fid_pais_origen">País de Origen:</label>
                        <input type="text" name="folder[fid_pais_origen]" class="form-control" id="fid_pais_origen">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="fid_estado_extranjero">Estado o Provincia:</label>
                        <input type="text" name="folder[fid_estado_extranjero]" class="form-control"
                          id="fid_estado_extranjero">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="fid_ciudad_extranjero">Ciudad o Población:</label>
                        <input type="text" name="folder[fid_ciudad_extranjero]" class="form-control"
                          id="fid_ciudad_extranjero">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="fid_colonia_extranjero">Colonia del Extranjero:</label>
                        <input type="text" name="folder[fid_colonia_extranjero]" class="form-control"
                          id="fid_colonia_extranjero">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="fid_calle_extranjero">Calle del Extranjero:</label>
                        <input type="text" name="folder[fid_calle_extranjero]" class="form-control"
                          id="fid_calle_extranjero">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="fid_num_exterior_ext">Núm. Exterior (Ext):</label>
                        <input type="text" name="folder[fid_num_exterior_ext]" class="form-control"
                          id="fid_num_exterior_ext">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="fid_num_interior_ext">Núm. Interior (Ext):</label>
                        <input type="text" name="folder[fid_num_interior_ext]" class="form-control"
                          id="fid_num_interior_ext">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="fid_codigo_postal_ext">Código Postal Extranjero:</label>
                        <input type="text" name="folder[fid_codigo_postal_ext]" class="form-control"
                          id="fid_codigo_postal_ext">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <!-- Sección para Plazo de Vigencia y Checkboxes -->
            <div class="row">
              <div class="col-12">
                <label>Plazo de vigencia <small style="color:red;">(*Plazo opcional)</small></label>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                  <input type="date" class="form-control" name="folder[first_fech_folder]" id="edit_first_fech_folder">
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                  <input type="date" class="form-control" name="folder[second_fech_folder]"
                    id="edit_second_fech_folder">
                </div>
              </div>
            </div>

            <!-- Checkboxes organizados en dos filas -->
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="edit_chk_alta_fact_folder" value="Si"
                    name="folder[chk_alta_fact_folder]">
                  <label class="form-check-label" for="edit_chk_alta_fact_folder">Vo.Bo. Alta Facturación</label>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="edit_chk_lib_folder" value="Si"
                    name="folder[chk_lib_folder]">
                  <label class="form-check-label" for="edit_chk_lib_folder">Vo.Bo. Liberación</label>
                </div>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="edit_chk_orig_recib_folder" value="Si"
                    name="folder[chk_orig_recib_folder]">
                  <label class="form-check-label" for="edit_chk_orig_recib_folder">Original Recibido</label>
                </div>
              </div>
            </div>

            <div id="edit-fecha-original-recibido" style="display: none;" class="form-group" style="margin-top:15px;">
              <label for="edit_fech_orig_recib_folder">Fecha de original recibido:</label>
              <input type="date" class="form-control"  name="folder[fech_orig_recib_folder]"
                id="edit_fech_orig_recib_folder">
            </div>


            <!-- Botones del formulario -->
            <div class="form-group mt-4">
              <button type="submit" name="action" value="add" class="btn btn-primary" id="btnGuardarCliente">
                <i class="fas fa-save"></i> Guardar Cliente
              </button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">
    <script>
        $(document).ready(function () {
            $('#seccion_fisica, #seccion_moral, #seccion_fideicomiso').hide();
            $('#pf_domicilio_extranjero, #pm_domicilio_extranjero, #fid_domicilio_extranjero').hide();

            $('#tipo_persona').change(function () {
                var tipo = $(this).val();
                $('#seccion_fisica, #seccion_moral, #seccion_fideicomiso').hide();
                $('#modalAgregarCliente .form-control').removeAttr('required');

                if (tipo === 'fisica') {
                    $('#seccion_fisica').show();
                    $('#pf_nombre, #pf_apellido_paterno, #pf_rfc').attr('required', true);
                } else if (tipo === 'moral') {
                    $('#seccion_moral').show();
                    $('#pm_razon_social, #pm_rfc').attr('required', true);
                } else if (tipo === 'fideicomiso') {
                    $('#seccion_fideicomiso').show();
                    $('#fid_razon_social, #fid_rfc').attr('required', true);
                }
            });

            $('#pf_tiene_domicilio_extranjero').change(function () {
                $('#pf_domicilio_extranjero').toggle(this.checked);
            });
            $('#pm_tiene_domicilio_extranjero').change(function () {
                $('#pm_domicilio_extranjero').toggle(this.checked);
            });
            $('#fid_tiene_domicilio_extranjero').change(function () {
                $('#fid_domicilio_extranjero').toggle(this.checked);
            });

            $('#pf_rfc, #pm_rfc, #fid_rfc, #pm_apoderado_rfc, #fid_apoderado_rfc').on('input', function () {
                this.value = this.value.toUpperCase();
            });
            $('#pf_curp, #pm_apoderado_curp, #fid_apoderado_curp').on('input', function () {
                this.value = this.value.toUpperCase();
            });

            $('#modalAgregarCliente').on('hidden.bs.modal', function () {
                $('#formAgregarCliente')[0].reset();
                $('#seccion_fisica, #seccion_moral, #seccion_fideicomiso').hide();
                $('#pf_domicilio_extranjero, #pm_domicilio_extranjero, #fid_domicilio_extranjero').hide();
                $('#modalAgregarCliente .form-control').removeAttr('required');
            });

            $('#formAgregarCliente').submit(function (e) {
                if (!$('#tipo_persona').val()) {
                    e.preventDefault();
                    alert('Por favor selecciona el tipo de persona.');
                    $('#tipo_persona').focus();
                    return false;
                }
            });
        });
    </script>
