<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Reporte Diario";
$data['css'] = array(
    "toastr.min.css",
    "zebra.css",
    "../select2/css/select2.min.css"
);
$this->load->view("plantilla/encabezado", $data);
?>

<section class="ml-5 mr-5" id="Operaciones">
    <div class="row mt-5 mb-5">
        <div class="col text-center text-uppercase">
            <h3 class="txt-Subtitulos">Reporte Diario de Producción</h3>
        </div>
    </div>
    <div class="row mb-3">
        <div class="form-group col-md-6 col-12">
            <label for="cmbEmpleado">Empleado</label>
            <select class="form-control js-example-basic-single" id="cmbEmpleado" name="cmbEmpleado" required></select>
        </div>
        <div class="form-group col-md-2 col-6 text-uppercase">
            <label for="txtFchaInicio">Fecha Reporte</label>
            <input type="text" class="form-control" id="txtFchaInicio" name="txtFchaInicio" required>
        </div>
<!--        <div class="form-group col-md-2 col-6 text-uppercase">-->
<!--            <label for="txtFchaFin">Fecha Final Reporte</label>-->
<!--            <input type="text" class="form-control" id="txtFchaFin" name="txtFchaFin" required>-->
<!--        </div>-->
        <div class="form-group col-md-2 col-6 text-uppercase">
            <br>
            <button type="button" class="btn btn-secondary pl-2" id="buscarReporte"><i class="fas fa-search"></i>  Buscar</button>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <button class="btn btn-success float-right" id="btnNuevoReporte">
                <i class="fa fa-user-plus" aria-hidden="true"></i>Nuevo Reporte
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-uppercase">
            <table id="tblDatos2" class="table table-sm table-striped table-bordered" cellspacing="0" width="100%">
                <thead class="table-info text-center"></thead>
            </table>
        </div>
    </div>
</section>


<div class="modal fade bd-example-modal-lg" id="wHorasEEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-fluid modal-full-height modal-top modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Horas Extras - <span></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="row justify-content-center">
                    <div class="col-6">
                        <form id="frmHE" role="form" autocomplete="off">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label for="txtHE">Total de Horas Extras</label>
                                    <input type="number" class="form-control" id="txtHE" name="txtHE"
                                            required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" class="btn btn-success" id="btnGuardarHE">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    let MY = {};

    $(document).ready(function (){
        let cmbEmpleado = $("#cmbEmpleado"),
            txtFchaInicio = $("#txtFchaInicio"),
            //txtFchaFin = $("#txtFchaFin"),
            buscarReporte = $("#buscarReporte"),
            $tblDatos2 = $("#tblDatos2"),
            $tblDatos3 = $("#tblDatos3"),
            wRegistro = $("#wRegistro"),
            btnNuevoReporte = $("#btnNuevoReporte"),
            $wHorasEEdit = $("#wHorasEEdit"),
            $frmHE = $("#frmHE"),
            $btnGuardarHE = $("#btnGuardarHE"),
            $nameTrabajador = '',
            $txtHE = 0,
            tbl_reporte = 0
        ;

        cmbEmpleado.select2();
        txtFchaInicio.Zebra_DatePicker({
            show_icon: true,
            format: 'Y/m/d'
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
                $obj.addClass("js-example-basic-single");
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
        cargar_catalogo_select('<?php echo site_url("/nomina/get/getEmpleados")?>', {}, cmbEmpleado, 'Empleado');


        getReportesDiarios();
        function getReportesDiarios() {
            MY.table = $tblDatos2.DataTable({
                processing: true,
                scrollY: 400,
                searching: false,
                serverSide: true,
                ordering: true,
                info: false,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                ajax: {
                    "url": "<?php echo site_url('/nomina/get/getReporteDiarios')?>",
                    "type": "POST",
                    "data": { "idEmpleado": cmbEmpleado.val(), "fecha_i": txtFchaInicio.val()}
                },
                columns: [
                    {"title": "Nombre Empleado", "data": "NombreC", "className": "text-center"},
                    {"title": "Piso", "data": "departamento", "className": "text-center"},
                    {"title": "Puesto", "data": "puesto", "className": "text-center"},
                    {"title": "Fecha reporte", "data": "fecha_reporte_i", "className": "text-center"},
                    { "title": "Ver", data:null,
                        render:function(data, type,row){
                            return '<button class="btn btn-info btn-sm">Ver</button>';
                        }
                    },
                    { "title": "Editar", data:null,
                        render:function(data, type,row){
                            return '<button class="btn btn-success btn-sm">Editar</button>';
                        }
                    },
                    { "title": "HorasE", data:null,
                        render:function(data, type,row){
                            return '<button class="btn btn-primary btn-sm">H. E.</button>';
                        }
                    },
                    { "title": "Recibo", data:null,
                        render:function(data, type,row){
                            return '<button class="btn btn-secondary btn-sm">Recibo</button>';
                        }
                    }
                ],
                order: [],
                language: {
                    "url": "<?php echo base_url();?>/assets/js/lang-es.lang"
                }
            });
        } // end

        $wHorasEEdit.on('hide.bs.modal', function () {
            $frmHE.get(0).reset();
            $btnGuardarHE.removeClass("loading");
            $frmHE.removeClass('loading');
            $nameTrabajador = '';
            tbl_reporte = 0;
        });

        $wHorasEEdit.on('shown.bs.modal', function () {
            const $head = $wHorasEEdit.find('.modal-title span');
            $head.html(' ' + $nameTrabajador);
        });

        $btnGuardarHE.click(function () {
            if ($btnGuardarHE.hasClass('loading')) {
                return false;
            }
            $btnGuardarHE.addClass('loading');
            $frmHE.addClass('loading');

            let dataSet = new FormData($frmHE.get(0));

            dataSet.append('tbl_reporteDiario_id', tbl_reporte);

            $.ajax({
                type: 'post',
                url: '<?php echo site_url("/nomina/set/horasExtras")?>',
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
                data: dataSet,
                cache: false,
                contentType: false,
                processData: false,
                success: function (e) {
                    if (e.length) {
                        if (e.length) {
                            let obj = JSON.parse(e);
                            if (obj.hasOwnProperty('status') && obj.status === "Ok") {
                                $frmHE.get(0).reset();
                                $wHorasEEdit.modal('hide');
                                tbl_reporte=0;
                                swal("Correcto", "Datos se guardados exitosamente", "success");
                            }
                        } else {
                            swal("Error", e, "error");
                            $frmHE.get(0).reset();
                            $wHorasEEdit.modal('hide');
                            tbl_reporte=0;
                        }
                    }
                },
                error: function (e) {
                    toastr.error("Error al procesar la petición " + e.responseText);
                },
                complete: function () {
                    $btnGuardarHE.removeClass('loading');
                    $frmHE.removeClass('loading');
                }
            });

        });

        $("#tblDatos2 tbody").on('click','td .btn-secondary',function(){
            let data = MY.table.rows($(this).closest("tr")).data();
            data = data[0];
            console.log(data);
            window.open("<?php echo site_url('/nomina/set/reciboPDF?idReporte=')?>"+data.tbl_reporteDiario_id, '_blank');
        });


        $("#tblDatos2 tbody").on('click','td .btn-primary',function(){
            let data = MY.table.rows($(this).closest("tr")).data();
            data = data[0];
            console.log(data);
            $nameTrabajador = data.NombreC+ ' F. Reporte: '+ data.fecha_reporte_i;
            tbl_reporte = data.tbl_reporteDiario_id;

            $.ajax({
                url: '<?php echo base_url("nomina/get/horasExtras")?>',
                type: "POST",
                data: {id: data.tbl_reporteDiario_id},
                dataType: "html",
                success: function (e) {
                    let obj = JSON.parse(e);
                    console.log(obj[0].he);
                    $('input[name="txtHE"]').val(obj[0].he);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal("Error", "Error al eliminar usuario", "error");
                }
            });

            $wHorasEEdit.modal("show");

        });

        $("#tblDatos2 tbody").on('click','td .btn-info',function(){
            let data = MY.table.rows($(this).closest("tr")).data();
            data = data[0];
            console.log(data.tbl_OrdenCorte_id);
            window.open("<?php echo site_url('/nomina/set/reporteDiarioPDF?idReporte=')?>"+data.tbl_reporteDiario_id, '_blank');
        });

        $("#tblDatos2 tbody").on('click','td .btn-success',function(){
            let data = MY.table.rows($(this).closest("tr")).data();
            data = data[0];
            console.log(data.tbl_OrdenCorte_id);
            location.href = '<?php echo site_url("/nomina/index2/reporteDiarioEdit/")?>'+data.tbl_reporteDiario_id;
        });

        btnNuevoReporte.hide();
        buscarReporte.click(function(){
            // if(cmbEmpleado.val()===''){
            //     toastr.error("Debe de seleccionar un empleado");
            // }else if (txtFchaInicio.val()===''){
            //     toastr.error("Debe ingresar una fecha inicial");
            // }else if (txtFchaFin.val()==='') {
            //     toastr.error("Debe ingresar una fecha final");
            // }else {
            //
            // }

            btnNuevoReporte.show();
            $tblDatos2.dataTable().fnDestroy();
            getReportesDiarios();
        });

        btnNuevoReporte.click(function(){
            if(cmbEmpleado.val()===''){
                toastr.error("Debe de seleccionar un empleado");
            }else {
                location.href = '<?php echo site_url("/nomina/index2/reporteDiarioNew/")?>'+cmbEmpleado.val();
            }
        });

        



        function getReporteDetalle() {
            //MY.table2 = $tblDatos3.DataTable({
            //    processing: true,
            //    scrollY: 400,
            //    serverSide: true,
            //    ordering: true,
            //    info: false,
            //    searching: false,
            //    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            //    ajax: {
            //        "url": "<?php //echo site_url('/nomina/get/getReporteDetalle')?>//",
            //        "type": "POST",
            //        "data": { "idModel": cmbModelo.val(), "deleteRow": deleteRow }
            //    },
            //    columns: [
            //        {"title": "Nombre Modelo", "data": "modeloCorte", "className": "text-center"},
            //        {"title": "Filtro Corte", "data": "tipoCorte", "className": "text-center"},
            //        {"title": "Clave", "data": "operacion", "className": "text-center"},
            //        {"title": "Operación", "data": "nombreOperacion", "className": "text-center"},
            //        {
            //            "title": "Eliminar", data: null,
            //            render: function (data, type, row) {
            //                return '<button class="btn btn-danger btn-sm">Eliminar</button>';
            //            }, "className": "text-center"
            //        }
            //    ],
            //    order: [],
            //    language: {
            //        "url": "<?php //echo base_url();?>///assets/js/lang-es.lang"
            //    }
            //});

        }
    });
</script>

<?php
$data['scripts'] = array(
    "jqw/localized-es.js",
    "toastr.min.js",
    "zebra_datepicker.src.js",
    "js1/moment.min.js",
    "../select2/js/select2.min.js"
);
$this->load->view("plantilla/pie", $data);
?>
