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
                                    <div class="form-group col-lg-4">
                                        <label for="txtName">Nombre</label>
                                        <input type="text" class="form-control text-uppercase" id="txtName" name="txtName" required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="txtAPaterno">Apellido Paterno</label>
                                        <input type="text" class="form-control text-uppercase" id="txtAPaterno" name="txtAPaterno"
                                               required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="txtAMaterno">Apellido Materno</label>
                                        <input type="text" class="form-control text-uppercase" id="txtAMaterno" name="txtAMaterno"
                                               required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-4">
                                        <label for="txtNombreCorto">Nombre corto</label>
                                        <input type="text" class="form-control text-uppercase" id="txtNombreCorto" name="txtNombreCorto" required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="txtRFC">RFC</label>
                                        <input type="text" class="form-control text-uppercase" id="txtRFC" name="txtRFC" required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="txtEmail">Correo Electronio</label>
                                        <input type="email" class="form-control" id="txtEmail" name="txtEmail" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-4">
                                        <label for="txtFon">Telefono</label>
                                        <input type="text" class="form-control" id="txtFon" name="txtFon" required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="txtCalleNum">Calle / Num</label>
                                        <input type="text" class="form-control text-uppercase" id="txtCalleNum" name="txtCalleNum"
                                               required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="txtColonia">Colonia</label>
                                        <input type="text" class="form-control text-uppercase" id="txtColonia" name="txtColonia" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-4">
                                        <label for="cmbEntidad custom-select">Estado</label>
                                        <select class="form-control" id="cmbEntidad" name="cmbEntidad" required>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="cmbMunicipio">Municipio</label>
                                        <select class="form-control" id="cmbMunicipio" name="cmbMunicipio" required>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="cmbLocalidad">Localidad</label>
                                        <select class="form-control" id="cmbLocalidad" name="cmbLocalidad" required>
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
                $cmbEntidad = $('#cmbEntidad'),
                $cmbMunicipio = $('#cmbMunicipio'),
                $cmbLocalidad = $('#cmbLocalidad'),
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
            cargar_catalogo_select('<?php echo site_url("/empleados/get/catEntidad")?>', {}, $cmbEntidad, 'Estado');
            $cmbEntidad.change(function () {
                $cmbMunicipio.html('');
                $cmbLocalidad.html('');
                cargar_catalogo_select('<?php echo site_url("/empleados/get/catMunicipio")?>', {cat_estado_id: $cmbEntidad.val()}, $cmbMunicipio, 'Municipio');
            });

            $cmbMunicipio.change(function () {
                $cmbLocalidad.html('');
                cargar_catalogo_select('<?php echo site_url("/empleados/get/catLocalidad")?>', {
                    cat_estado_id: $cmbEntidad.val(),
                    cat_municipio: $cmbMunicipio.val()
                }, $cmbLocalidad, 'Localidad');
            });

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

            $btnGuardarCliente.click(function () {
                if ($btnGuardarCliente.hasClass('loading')) { return false; }
                $btnGuardarCliente.addClass('loading');
                $frmClientes.addClass('loading');
                setCliente();
            });

            function setCliente() {
                let data = new FormData($frmClientes.get(0));
                if (_currEmpleado.hasOwnProperty('tbl_clientes_id')) {
                    data.append('_id_', _currEmpleado.tbl_clientes_id);
                }

                _gridState = $tblDatos.jqxGrid('savestate');

                $.ajax({
                    type: 'post',
                    url: '<?php echo site_url("/clientes/set/clientes")?>',
                    xhr: function () {  // Custom XMLHttpRequest
                        const myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) { // Check if upload property exists
                            myXhr.upload.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
                                }
                            }, false); // For handling the progress of the upload
                        }
                        return myXhr;
                    },
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (e) {
                        if (e.length) {
                            if (e.length) {
                                let obj = JSON.parse(e);
                                if (obj.hasOwnProperty('status') && obj.status === "Ok") {
                                    $frmClientes.get(0).reset();
                                    $wClientesEdit.modal('hide');
                                    swal("Correcto", "Datos del cliente guardados exitosamente", "success");
                                    //$tblDatos.jqxGrid({source: getEmpleados()});
                                }
                            } else {
                                swal("Error", e , "error");
                                $frmClientes.get(0).reset();
                            }
                        }
                    },
                    error: function (e) {
                        toastr.error("Error al procesar la petición " + e.responseText);
                    },
                    complete: function () {
                        $btnGuardarCliente.removeClass('loading');
                        $frmClientes.removeClass('loading');
                    }
                });
            }

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