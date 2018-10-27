<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$data['title'] = ":: Usuarios";
$data['css'] = array(
    "jw/jqx.base.css",
    "jw/jqx.espani.css",
    "toastr.min.css",
    "zebra.css"
);

$this->load->view("plantilla/encabezado", $data);
?>

<section class="ml-5 mr-5" id="Usuarios">
    <div class="row mt-5 mb-5">
        <div class="col text-center text-uppercase">
            <h3 class="txt-Subtitulos"> Administración de Usuarios de la Plataforma ESPANI </h3>
        </div>
    </div>
    <div class="row justify-content-end mb-3">
        <div class="col-1">
            <button type="button" class="btn btn-success" id="btnNuevoUsuario">Nuevo</button>
        </div>
        <div class="col-1">
            <button type="button" class="btn btn-secondary" id="btndelete">Eliminar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="tblDatos"></div>
        </div>
    </div>
</section>

<div class="modal fade" id="wUsuariosEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-fluid modal-full-height modal-top modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Usuarios - Datos Generales <span></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="row">
                    <div class="col-12">
                        <form id="frmUsuario" role="form" autocomplete="off">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control text-uppercase" id="txtName" name="txtName" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtAPaterno">Apellido Paterno</label>
                                    <input type="text" class="form-control text-uppercase" id="txtAPaterno" name="txtAPaterno"
                                           required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtAMaterno">Apellido Materno</label>
                                    <input type="text" class="form-control text-uppercase" id="txtAMaterno" name="txtAMaterno"
                                           required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="txtCURP">CURP</label>
                                    <input type="text" class="form-control text-uppercase" id="txtCURP" name="txtCURP" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtRFC">RFC</label>
                                    <input type="text" class="form-control text-uppercase" id="txtRFC" name="txtRFC" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbSexo">Sexo</label>
                                    <select class="form-control custom-select" id="cmbSexo" name="cmbSexo" required>
                                        <option value="">Sexo</option>
                                        <option value="M">MUJER</option>
                                        <option value="H">HOMBRE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="txtFchaNac">Fecha Nacimiento</label>
                                    <input type="text" class="form-control" id="txtFchaNac" name="txtFchaNac" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtEmail">Correo Electronio</label>
                                    <input type="email" class="form-control" id="txtEmail" name="txtEmail" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtFon">Telefono</label>
                                    <input type="text" class="form-control" id="txtFon" name="txtFon" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="txtNSS">NSS</label>
                                    <input type="text" class="form-control" id="txtNSS" name="txtNSS" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtCalleNum">Calle / Num</label>
                                    <input type="text" class="form-control text-uppercase" id="txtCalleNum" name="txtCalleNum"
                                           required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtColonia">Colonia</label>
                                    <input type="text" class="form-control text-uppercase" id="txtColonia" name="txtColonia" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="cmbEntidad custom-select">Estado</label>
                                    <select class="form-control" id="cmbEntidad" name="cmbEntidad" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbMunicipio">Municipio</label>
                                    <select class="form-control" id="cmbMunicipio" name="cmbMunicipio" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbLocalidad">Localidad</label>
                                    <select class="form-control" id="cmbLocalidad" name="cmbLocalidad" required>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="cmbDep">Departamento</label>
                                    <select class="form-control" id="cmbDep" name="cmbDep" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbPuesto">Puesto</label>
                                    <select class="form-control" id="cmbPuesto" name="cmbPuesto" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtFchaIngreso">Fecha Ingreso</label>
                                    <input type="txt" class="form-control" id="txtFchaIngreso" name="txtFchaIngreso"
                                           required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success" id="btnGuardarUsuario">Guardar</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function (){
        let $btnNuevoUsuario = $("#btnNuevoUsuario"),
            $btndelete = $("#btndelete"),
            $tblDatos =$("#tblDatos"),
            $wUsuariosEdit = $("#wUsuariosEdit"),
            $frmUsuario = $("#frmUsuario"),
            $btnGuardarUsuario = $("#btnGuardarUsuario"),
            _gridState = null,
            _currEmpleado = {}
            ;

        function cargar_catalogo(url, data) {
            return $.getJSON(url, data, function (e) {
                if (window._debug) {
                    console.groupCollapsed('Request');
                    console.log('Catalog URL: ', url);
                    console.log('Catalog Data: ', data);
                    console.log('Catalog returned: ', e);
                    console.groupEnd();
                }
            });
        }

        function show_cat_select($items, $obj, placeholder) {
            if (typeof $obj !== 'object') {
                return;
            }
            placeholder = placeholder || 'Elige';
            $obj.html('<option value="">' + placeholder + '</option>');
            $.each($items, function (ix, item) {
                let $el = $('<option/>');
                $el.val(item.id).html(item.nombre);
                $obj.append($el);
                $obj.addClass("custom-select");
            });

        }

        function cargar_catalogo_select(url, data, $obj, placeholder) {
            if (typeof $obj !== 'object') {
                return;
            }
            let xhr = cargar_catalogo(url, data);
            xhr.done(function (e) {
                show_cat_select(e, $obj, placeholder);
            });
            return xhr;
        }

        $btnNuevoUsuario.click(function () {
            $wUsuariosEdit.modal("show");
        });

        $wUsuariosEdit.on('hide.bs.modal', function () {
            _currEmpleado = {};
            $frmUsuario.get(0).reset();
            $btnGuardarUsuario.removeClass("loading");
            $frmUsuario.removeClass('loading');
        });

        $wUsuariosEdit.on('shown.bs.modal', function () {
            const $head = $wUsuariosEdit.find('.modal-title span');
            if (_currEmpleado.hasOwnProperty('cat_usuario_id')) {
                $head.html(' - ' + _currEmpleado.cat_rh_empleado_id);
            } else {
                $head.html(' - Nuevo');
            }
        });

    }); // end document ready
</script>
<?php
$data['scripts'] = array(
    "jqw/jqxcore.js",
    "jqw/jqxdata.js",
    "jqw/jqxcheckbox.js",
    "jqw/jqxbuttons.js",
    "jqw/jqxscrollbar.js",
    "jqw/jqxmenu.js",
    "jqw/jqxlistbox.js",
    "jqw/jqxdropdownlist.js",
    "jqw/jqxgrid.js",
    "jqw/jqxgrid.pager.js",
    "jqw/jqxgrid.columnsresize.js",
    "jqw/jqxdata.export.js",
    "jqw/jqxgrid.export.js",
    "jqw/jqxgrid.grouping.js",
    "jqw/jqxgrid.selection.js",
    "jqw/jqxgrid.sort.js",
    "jqw/jqxgrid.filter.js",
    "jqw/jqxgrid.storage.js",
    "jqw/jqxpanel.js",
    "jqw/localized-es.js",
    "toastr.min.js",
    "zebra_datepicker.src.js"

);
$this->load->view("plantilla/pie", $data);
?>
