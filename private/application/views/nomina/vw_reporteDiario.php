<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Reporte Diario";
$data['css'] = array(
    "toastr.min.css",
    "zebra.css",
    "../datatables/datatables.min.css",
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
            <label for="txtFchaInicio">Fecha Inicio Reporte</label>
            <input type="text" class="form-control" id="txtFchaInicio" name="txtFchaInicio" required>
        </div>
        <div class="form-group col-md-2 col-6 text-uppercase">
            <label for="txtFchaFin">Fecha Final Reporte</label>
            <input type="text" class="form-control" id="txtFchaFin" name="txtFchaFin" required>
        </div>
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
            <table id="tblDatos2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead class="table-info text-center"></thead>
            </table>
        </div>
    </div>
</section>


<script>
    let MY = {};

    $(document).ready(function (){
        let cmbEmpleado = $("#cmbEmpleado"),
            txtFchaInicio = $("#txtFchaInicio"),
            txtFchaFin = $("#txtFchaFin"),
            buscarReporte = $("#buscarReporte"),
            $tblDatos2 = $("#tblDatos2"),
            $tblDatos3 = $("#tblDatos3"),
            wRegistro = $("#wRegistro"),
            btnNuevoReporte = $("#btnNuevoReporte")
        ;

        cmbEmpleado.select2();
        txtFchaInicio.Zebra_DatePicker({
            show_icon: true,
            format: 'Y/m/d',
            inline: true,
            pair: $('#txtFchaFin'),
            firstDay: 1
        });

        txtFchaFin.Zebra_DatePicker({
            show_icon: true,
            format: 'Y/m/d',
            direction: true // change 0 to true
        });

        txtFchaInicio.on('blur change',function () {
            let mydate = new Date(txtFchaInicio.val());
            console.log(txtFchaInicio.val());
            txtFchaFin.data('Zebra_DatePicker').set_date(txtFchaInicio.val());
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
                    "data": { "idEmpleado": cmbEmpleado.val(), "fecha_i": txtFchaInicio.val(), "fecha_f": txtFchaFin.val() }
                },
                columns: [
                    {"title": "Nombre Empleado", "data": "NombreC", "className": "text-center"},
                    {"title": "Piso", "data": "departamento", "className": "text-center"},
                    {"title": "Puesto", "data": "puesto", "className": "text-center"},
                    {"title": "Fecha reporte inicial", "data": "fecha_reporte_i", "className": "text-center"},
                    {"title": "Fecha reporte final", "data": "fecha_reporte_f", "className": "text-center"},
                    {
                        "title": "Editar", data: null,
                        render: function (data, type, row) {
                            return '<button class="btn btn-danger btn-sm">Editar</button>';
                        }, "className": "text-center"
                    }
                ],
                order: [],
                language: {
                    "url": "<?php echo base_url();?>/assets/js/lang-es.lang"
                }
            });
        } // end

        btnNuevoReporte.hide();
        buscarReporte.click(function(){
            if(cmbEmpleado.val()===''){
                toastr.error("Debe de seleccionar un empleado");
            }else if (txtFchaInicio.val()===''){
                toastr.error("Debe ingresar una fecha inicial");
            }else if (txtFchaFin.val()==='') {
                toastr.error("Debe ingresar una fecha final");
            }else {
                btnNuevoReporte.show();
                $tblDatos2.dataTable().fnDestroy();
                getReportesDiarios();
            }
        });

        btnNuevoReporte.click(function(){
            if(cmbEmpleado.val()===''){
                toastr.error("Debe de seleccionar un empleado");
            }else if (txtFchaInicio.val()===''){
                toastr.error("Debe ingresar una fecha inicial");
            }else if (txtFchaFin.val()==='') {
                toastr.error("Debe ingresar una fecha final");
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
    "../datatables/datatables.min.js",
    "zebra_datepicker.src.js",
    "js1/moment.min.js",
    "../select2/js/select2.min.js"
);
$this->load->view("plantilla/pie", $data);
?>
