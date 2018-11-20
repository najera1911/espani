<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Operaciones";
$data['css'] = array(
    "toastr.min.css",
    "zebra.css",
    "../datatables/datatables.min.css"
);
$this->load->view("plantilla/encabezado", $data);
?>
    <section class="ml-5 mr-5" id="Operaciones">
        <div class="row mt-5 mb-5">
            <div class="col text-center text-uppercase">
                <h3 class="txt-Subtitulos">Operaciones</h3>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <button type="button" class="btn btn-warning btn-circle float-right ml-2" id="btnExportExcel"><i
                            class="fas fa-file-excel"></i></button>
                <button class="btn btn-success float-right" id="btnNuevaOperacion">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Agregar Operación
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-uppercase">
                <table id="tblDatos2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="table-info text-center"></thead>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade" id="wOperacionesEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-fluid modal-full-height modal-top modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Operaciones<span></span> - Datos Generales </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="row">
                        <div class="col-12">
                            <form id="frmOperaciones" role="form" autocomplete="off">
                                <div class="form-row">
                                    <div class="form-group col-lg-4">
                                        <label for="cmbTipoCorte">Tipo de Corte</label>
                                        <select class="form-control" id="cmbTipoCorte" name="cmbTipoCorte"
                                                required></select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="txtOperacion">Clave operacion</label>
                                        <input type="text" class="form-control text-uppercase" id="txtOperacion"
                                               name="txtOperacion" required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="txtDescripcion">Descripcion</label>
                                        <input type="text" class="form-control text-uppercase" id="txtDescripcion"
                                               name="txtDescripcion" required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label class="sr-only" for="txtTarifa_sin">Tarifa sin 7o</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">$</div>
                                            </div>
                                            <input type="number" class="form-control" id="txtTarifa_sin"
                                                   name="txtTarifa_sin" placeholder="Tarifa sin 7o">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label class="sr-only" for="txtTarifa_con">Tarifa con 7o</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">$</div>
                                            </div>
                                            <input type="number" class="form-control" id="txtTarifa_con"
                                                   name="txtTarifa_con" placeholder="Tarifa con 7o">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-success" id="btnGuardarOperacion">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let MY = {};

        $(document).ready(function () {
            let $btnNuevaOperacion = $("#btnNuevaOperacion"),
                $tblDatos2 = $("#tblDatos2"),
                $wOperacionesEdit = $("#wOperacionesEdit"),
                $frmOperaciones = $("#frmOperaciones"),
                $btnGuardarOperacion = $("#btnGuardarOperacion"),
                $cmbTipoCorte = $("#cmbTipoCorte"),
                $txtTarifa_con = $("#txtTarifa_con"),
                $txtTarifa_sin = $("#txtTarifa_sin"),
                $_arregloOperacion = {};

            $txtTarifa_sin.change(function () {
                $txtTarifa_sin.val(parseFloat($txtTarifa_sin.val()).toFixed(5));
                let tcs = ($txtTarifa_sin.val() / 6 ) * 7;
                $txtTarifa_con.val(tcs.toFixed(5));
            });

            $txtTarifa_con.change(function () {
                $txtTarifa_con.val(parseFloat($txtTarifa_con.val()).toFixed(5));
            });


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
            cargar_catalogo_select('<?php echo site_url("/operaciones/get/catTipoCorte")?>', {}, $cmbTipoCorte, 'Tipo Corte');

            $btnNuevaOperacion.click(function () {
                $wOperacionesEdit.modal("show");
            });

            $wOperacionesEdit.on('hide.bs.modal', function () {
                $_arregloOperacion = {};
                $frmOperaciones.get(0).reset();
                $btnGuardarOperacion.removeClass("loading");
                $frmOperaciones.removeClass('loading');
            });

            $wOperacionesEdit.on('shown.bs.modal', function () {
                const $head = $wOperacionesEdit.find('.modal-title span');
                if ($_arregloOperacion.hasOwnProperty('cat_usuario_id')) {
                    $head.html(' ' + $_arregloOperacion.operacion);
                } else {
                    $head.html(' Nuevo');
                }
            });

            $btnGuardarOperacion.click(function () {
                if ($btnGuardarOperacion.hasClass('loading')) {
                    return false;
                }
                $btnGuardarOperacion.addClass('loading');
                $frmOperaciones.addClass('loading');
                setOperacion();
            });


            getOperacion();

            function getOperacion() {
                MY.table = $tblDatos2.DataTable({
                    processsing: true,
                    serverSide: true,
                    ordering: true,
                    info: false,
                    ajax: {
                        "url": "<?php echo site_url('/operaciones/get/operaciones')?>",
                        "type": "POST"
                    },
                    columns: [
                        {"title": "Tipo Corte", "data": "tipoCorte"},
                        {"title": "Operacion", "data": "operacion", "className": "text-center"},
                        {"title": "Descripcion", "data": "descripcion"},
                        {
                            "title": "tarifa sin 7° ", "data": "tarifa_sin",
                            render: function (data, type, row) {
                                data = parseFloat(data).toFixed(5);
                                return '$ ' + data;
                            }, "className": "text-center"
                        },
                        {
                            "title": "tarifa con 7° ", "data": "tarifa_con",
                            render: function (data, type, row) {
                                data = parseFloat(data).toFixed(5);
                                return '$ ' + data;
                            }, "className": "text-center"
                        },
                        {
                            "title": "Editar", data: null,
                            render: function (data, type, row) {
                                return '<button class="btn btn-success btn-sm">Editar</button>';
                            }, "className": "text-center"
                        },
                        {
                            "title": "Eliminar", data: null,
                            render: function (data, type, row) {
                                return '<button class="btn btn-danger btn-sm">Eliminar</button>';
                            }, "className": "text-center"
                        }
                    ],
                    order: [],
                    language: {
                        "url": "<?php echo base_url();?>/assets/js/lang-es.lang"
                    }
                });
            }

            $("#tblDatos2 tbody").on('click', 'td .btn-success', function () {
                let data = MY.table.rows($(this).closest("tr")).data();
                $_arregloOperacion = data[0];

                $('select[name="cmbTipoCorte"]').val($_arregloOperacion.cat_tipo_corte_id).change();
                $('input[name="txtOperacion"]').val($_arregloOperacion.operacion);
                $('input[name="txtDescripcion"]').val($_arregloOperacion.descripcion);
                $('input[name="txtTarifa_con"]').val($_arregloOperacion.tarifa_con);
                $('input[name="txtTarifa_sin"]').val($_arregloOperacion.tarifa_sin);
                $wOperacionesEdit.modal('show');
            });

            $("#tblDatos2 tbody").on('click', 'td .btn-danger', function () {
                let data = MY.table.rows($(this).closest("tr")).data();
                data = data[0];
                PersonalDelete(data);
            })

            function setOperacion() {
                let data = new FormData($frmOperaciones.get(0));
                if ($_arregloOperacion.hasOwnProperty('cat_operaciones_id')) {
                    data.append('_id_', $_arregloOperacion.cat_operaciones_id);
                }

                $.ajax({
                    type: 'post',
                    url: '<?php echo site_url("/operaciones/set/operacion")?>',
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
                                    $frmOperaciones.get(0).reset();
                                    $wOperacionesEdit.modal('hide');
                                    swal("Correcto", "Datos se guardados exitosamente", "success");
                                    MY.table.ajax.reload();
                                }
                            } else {
                                swal("Error", e, "error");
                                $frmOperaciones.get(0).reset();
                            }
                        }
                    },
                    error: function (e) {
                        toastr.error("Error al procesar la petición " + e.responseText);
                    },
                    complete: function () {
                        $btnGuardarOperacion.removeClass('loading');
                        $frmOperaciones.removeClass('loading');
                    }
                });
            }

            function PersonalDelete(data) {
                swal({
                        title: "Eliminar un cliente",
                        text: "Desea eliminar a: " + data.operacion + "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Eliminar",
                        cancelButtonText: "Cancelar",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: '<?php echo base_url("operaciones/set/deleteCliente")?>',
                                type: "POST",
                                data: {datos: data.cat_operaciones_id},
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
                            swal("Cancelado", data.operacion + " no se elimino", "error");
                        }
                    });
            }
        });

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