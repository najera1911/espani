<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$data['title'] = ":: Clientes";
$data['css'] = array(
    "toastr.min.css",
    "zebra.css",
    "../datatables/datatables.min.css"
);

$this->load->view("plantilla/encabezado", $data);
?>

    <section class="ml-5 mr-5" id="Clientes">
        <div class="row mt-5 mb-5">
            <div class="col text-center text-uppercase">
                <h3 class="txt-Subtitulos"> Administración de Clientes</h3>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <button type="button" class="btn btn-warning btn-circle float-right ml-2" id="btnExportExcel"><i
                            class="fas fa-file-excel"></i></button>
                <button class="btn btn-success float-right" id="btnNuevoCliente">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Agregar Cliente
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-uppercase">
                <table id="tblDatos2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="table-info"></thead>
                </table>
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
                                        <label for="cmbEntidad">Estado</label>
                                        <select class="form-control" id="cmbEntidad" name="cmbEntidad" required>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="cmbMunicipio">Municipio</label>
                                        <select class="form-control" id="cmbMunicipio" name="cmbMunicipio" required>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="cmbLocalidad">LocalidaD</label>
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
        let MY = {
        };
        $(document).ready(function (){
            let $btnNuevoCliente = $("#btnNuevoCliente"),
                $tblDatos2 = $("#tblDatos2"),
                $wClientesEdit = $("#wClientesEdit"),
                $frmClientes = $("#frmClientes"),
                $btnGuardarCliente = $("#btnGuardarCliente"),
                $cmbEntidad = $('#cmbEntidad'),
                $cmbMunicipio = $('#cmbMunicipio'),
                $cmbLocalidad = $('#cmbLocalidad'),
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

            getEmpleados2();

            function getEmpleados2() {
                MY.table = $tblDatos2.DataTable( {
                    processing: true,
                    serverSide: true,
                    ordering: true,
                    info: false,
                    ajax: {
                        "url": "<?php echo site_url('/clientes/get/clientes')?>",
                        "type": "POST"
                    },
                    columns: [
                        { "title": "Nombre", "data":"NombreC" },
                        { "title": "Nombre Corto", "data": "nombre_corto"},
                        { "title": "RFC", "data": "rfc" },
                        { "title": "Dirección", "data": "dirC" },
                        { "title": "E-mail", "data":"email" },
                        { "title": "Telefono", "data":"telefono" },
                        { "title": "Editar", data:null,
                            render:function(data, type,row){
                                return '<button class="btn btn-success btn-sm">Editar</button>';
                            }
                        },
                        { "title": "Eliminar", data:null,
                            render:function(data, type,row){
                                return '<button class="btn btn-warning btn-sm">Eliminar</button>';
                            }
                        }
                    ],
                    order: [],
                    language: {
                        "url": "<?php echo base_url();?>/assets/js/lang-es.lang"
                    }
                } );
            }

            $("#tblDatos2 tbody").on('click','td .btn-success',function(){
                let data = MY.table.rows($(this).closest("tr")).data();
                _currEmpleado = data[0];

                $('input[name="txtName"]').val(_currEmpleado.nombre);
                $('input[name="txtAPaterno"]').val(_currEmpleado.apellido_p);
                $('input[name="txtAMaterno"]').val(_currEmpleado.apellido_m);
                $('input[name="txtNombreCorto"]').val(_currEmpleado.nombre_corto);
                $('input[name="txtRFC"]').val(_currEmpleado.rfc);
                $('input[name="txtEmail"]').val(_currEmpleado.email);
                $('input[name="txtFon"]').val(_currEmpleado.telefono);
                $('input[name="txtNSS"]').val(_currEmpleado.nss);
                $('input[name="txtCalleNum"]').val(_currEmpleado.calle_num);
                $('input[name="txtColonia"]').val(_currEmpleado.colonia);
                $('select[name="cmbEntidad"]').val(_currEmpleado.cat_entidad_id).change();

                setTimeout(function () {
                    $('select[name="cmbMunicipio"]').val(_currEmpleado.cat_municipio_id).change();
                }, 100);

                setTimeout(function () {
                    $('select[name="cmbLocalidad"]').val(_currEmpleado.cat_localidad_id).change();
                }, 200);

                $wClientesEdit.modal('show');
            });

            $("#tblDatos2 tbody").on('click','td .btn-warning',function(){
                let data = MY.table.rows($(this).closest("tr")).data();
                data = data[0];
                PersonalDelete(data);
            });

            function setCliente() {
                let data = new FormData($frmClientes.get(0));
                if (_currEmpleado.hasOwnProperty('tbl_clientes_id')) {
                    data.append('_id_', _currEmpleado.tbl_clientes_id);
                }

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
                                    MY.table.ajax.reload();
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

            function PersonalDelete(data){
                swal({
                        title: "Eliminar un cliente",
                        text: "Desea eliminar a: "+ data.NombreC +"",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Eliminar",
                        cancelButtonText: "Cancelar",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: '<?php echo base_url("clientes/set/deleteCliente")?>',
                                type: "POST",
                                data: {datos: data.cat_usuario_id},
                                dataType: "html",
                                success: function (e) {
                                    if (e === 'OK') {
                                        swal("Bien", "El cliente se ha eliminado correctamente", "success");
                                        MY.table.ajax.reload();
                                    }
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    swal("Error", "Error al eliminar usuario", "error");
                                }
                            });
                        } else {
                            swal("Cancelado", data.nombreC + " no se elimino", "error");
                        }
                    });
            }

        }); // end document ready
    </script>
<?php
$data['scripts'] = array(
    "jqw/localized-es.js",
    "toastr.min.js",
    "zebra_datepicker.src.js",
    "../datatables/datatables.min.js",
    "js1/moment.min.js"
);
$this->load->view("plantilla/pie", $data);
?>