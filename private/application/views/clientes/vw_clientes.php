<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$data['title'] = ":: Clientes";
$data['css'] = array(
    "jw/jqx.base.css",
    "jw/jqx.espani.css",
    "toastr.min.css",
    "zebra.css"
);

$this->load->view("plantilla/encabezado", $data);
?>

    <section class="ml-5 mr-5" id="Clientes">
        <div class="row mt-5 mb-5">
            <div class="col text-center text-uppercase">
                <h3 class="txt-Subtitulos"> Administración de Clientes</h3>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-8">
                <button type="button" class="btn btn-warning btn-circle float-right ml-2" id="btnExportExcel"><i
                            class="fas fa-file-excel"></i></button>
                <button type="button" class="btn btn-secondary float-right ml-2" id="btndelete">Eliminar</button>
                <button type="button" class="btn btn-success float-right" id="btnNuevoCliente">Nuevo</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-8">
                <div id="tblDatos"></div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="wClientesEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-fluid modal-full-height modal-top modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Clientes <span></span> - Datos Generales </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="row">
                        <div class="col-12">
                            <form id="frmClientes" role="form" autocomplete="off">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="txtName">Nombre</label>
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
                                        <label for="cmbSexo">Sexo</label>
                                        <select class="form-control custom-select" id="cmbSexo" name="cmbSexo" required>
                                            <option value="">Sexo</option>
                                            <option value="M">MUJER</option>
                                            <option value="H">HOMBRE</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="txtUser">Usuario</label>
                                        <input type="text" class="form-control" id="txtUser" name="txtUser"
                                               required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="txtPass">Contraseña</label>
                                        <input type="text" class="form-control" id="txtPass" name="txtPass"
                                               required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="cmbPerfil">Perfil</label>
                                        <select class="form-control" id="cmbPerfil" name="cmbPerfil" required>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" id="btnGuardarCliente">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function (){
            let $btnNuevoCliente = $("#btnNuevoCliente"),
                $btndelete = $("#btndelete"),
                $btnExportExcel = $("#btnExportExcel"),
                $tblDatos =$("#tblDatos"),
                $wClientesEdit = $("#wClientesEdit"),
                $frmClientes = $("#frmClientes"),
                $btnGuardarCliente = $("#btnGuardarCliente"),
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

            //agregar select
            //cargar_catalogo_select('<?php echo site_url("/administrador/get/catPerfil")?>', {}, $cmbPerfil, 'Perfil');

            $btnNuevoCliente.click(function () {
                $wClientesEdit.modal("show");
            });

            $wClientesEdit.on('hide.bs.modal', function () {
                _currEmpleado = {};
                $frmClientes.get(0).reset();
                $btnGuardarCliente.removeClass("loading");
                $frmClientes.removeClass('loading');
            });

            $wClientesEdit.on('shown.bs.modal', function () {
                const $head = $wClientesEdit.find('.modal-title span');
                if (_currEmpleado.hasOwnProperty('cat_usuario_id')) {
                    $head.html(' ' + _currEmpleado.nombre);
                } else {
                    $head.html(' Nuevo');
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