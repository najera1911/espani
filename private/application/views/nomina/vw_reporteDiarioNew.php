<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Reporte Diario Nuevo";
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
            <h3 class="txt-Subtitulos">Reporte Diario de Producción Nuevo</h3>
        </div>
    </div>
    <div class="row pb-5 pt-3">
        <div class="col-12 text-uppercase font-weight-bold" id="nombre"></div>
    </div>
    <div class="row">
        <form id="frmReporte" class="container-fluid" role="form" autocomplete="off">
            <div class="row">
                <div class="form-group col-3 text-uppercase">
                    <label for="txtFchaInicio">Fecha Inicio Reporte</label>
                    <input type="text" class="form-control" id="txtFchaInicio" name="txtFchaInicio" required>
                </div>
                <div class="form-group col-3 text-uppercase">
                    <label for="txtFchaFin">Fecha Final Reporte</label>
                    <input type="text" class="form-control" id="txtFchaFin" name="txtFchaFin" required>
                </div>
                <div class="form-group col-6">
                    <label for="cmbCorte">Corte</label>
                    <select class="form-control js-example-basic-single" id="cmbCorte" name="cmbCorte" required></select>
                </div>
                <div class="form-group col-4">
                    <label for="cmbBulto">Bulto</label>
                    <select class="form-control js-example-basic-single" id="cmbBulto" name="cmbBulto" required></select>
                </div>
                <div class="form-group col-4">
                    <label for="cmbOper">Operación</label>
                    <select class="form-control js-example-basic-single" id="cmbOper" name="cmbOper" required></select>
                </div>
                <div class="form-group col-2">
                    <label for="txtCantidad">Cantidad</label>
                    <input type="number" class="form-control" id="txtCantidad" name="txtCantidad" required>
                </div>
                <div class="form-group col-2">
                    <br>
                    <button type="button" class="btn btn-secondary pl-2" id="btnAdd">  Agregar </button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-12 text-uppercase">
            <table id="tblDatos2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead class="table-info text-center"></thead>
            </table>
        </div>
    </div>
    <div class="row pt-5 pb-5">
        <div class="col-12 text-center">
            <button type="button" class="btn btn-success" id="btnFinalizar">Finalizar</button>
        </div>
    </div>
</section>

<script>
    let MY = {};

    $(document).ready(function (){
        let idEmpleado = <?php echo $id ?>,
            nombreEmpleado = $("#nombre"),
            $tblDatos2 = $("#tblDatos2"),
            txtFchaInicio = $("#txtFchaInicio"),
            txtFchaFin = $("#txtFchaFin"),
            btnAdd = $("#btnAdd"),
            frmReporte = $("#frmReporte"),
            cmbCorte = $("#cmbCorte"),
            cmbBulto = $("#cmbBulto"),
            cmbOper = $("#cmbOper"),
            txtCantidad = $("#txtCantidad"),
            id_reporte = 0,
            btnFinalizar = $("#btnFinalizar")
        ;

        cmbBulto.select2();
        cmbCorte.select2();
        cmbOper.select2();
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

        cargar_catalogo_select('<?php echo site_url("/nomina/get/getCortes")?>', {}, cmbCorte, 'Corte');
        cmbCorte.change(function(){
            cmbBulto.html('');
            cmbOper.html('');
            cargar_catalogo_select('<?php echo site_url("/nomina/get/getBultos")?>',
                {idCorte : cmbCorte.val()}, cmbBulto, 'Bulto');
        });

        cmbBulto.change(function () {
            cmbOper.html('');
            cargar_catalogo_select('<?php echo site_url("/nomina/get/getOperaciones")?>',
                {idCorte : cmbCorte.val(), idBulto: cmbBulto.val()}, cmbOper, 'Operación');
        });

        $.post('<?php echo site_url("/nomina/get/dataEmpleado")?>', { idEmpleado: idEmpleado })
            .done(function( data ) {
                let obj = JSON.parse(data);
                nombreEmpleado.html('Nombre: '+ obj[0].NombreC + '   '+ obj[0].departamento +'   Puesto: ' + obj[0].puesto);
            });

        getReporte();
        function getReporte() {
            MY.table = $tblDatos2.DataTable({
                processing: true,
                scrollY: 400,
                serverSide: true,
                ordering: true,
                info: false,
                searching : false,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                ajax: {
                    "url": "<?php echo site_url('/nomina/get/getReporte')?>",
                    "type": "POST",
                    "data": { "tbl_reportediario_id": id_reporte }
                },
                columns: [
                    {"title": "Corte", "data": "numero_corte", "className": "text-center"},
                    {"title": "Cliente", "data": "nombre_corto", "className": "text-center"},
                    {"title": "Núm Bulto", "data": "num_bulto", "className": "text-center"},
                    {"title": "Clave Opera", "data": "operacion", "className": "text-center"},
                    {"title": "Descripción", "data": "descripcion", "className": "text-center"},
                    {"title": "Cantidad", "data": "cantidad", "className": "text-center"},
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

        btnAdd.click(function () {
            if(cmbCorte.val()===''){
                toastr.error("Debe de seleccionar un Número de Corte");
            }else if (cmbBulto.val()===''){
                toastr.error("Debe seleccionar un número de bulto");
            }else if (cmbOper.val()==='') {
                toastr.error("Debe seleccionar un número de operación");
            }else if (txtCantidad.val()==='') {
                toastr.error("Debe seleccionar un número de operación");
            }else {
                if (btnAdd.hasClass('loading')) {
                    return false;
                }
                btnAdd.addClass('loading');
                frmReporte.addClass('loading');
                setDatos();
            }
        });

        function setDatos() {
            let data = frmReporte.serializeArray();
            data.push({name: 'idEmpleado', value: idEmpleado});
            data.push({name: 'id_reporte', value: id_reporte});

            $.ajax({
                type: 'post',
                url: '<?php echo site_url("/nomina/set/addDatos")?>',
                data: data,
                success: function (e) {
                    console.log(e);
                        toastr.success("Dato Guardado");
                        cmbCorte.html('');
                        cmbBulto.html('');
                        cmbOper.html('');
                        txtCantidad.val('');
                        cargar_catalogo_select('<?php echo site_url("/nomina/get/getCortes")?>', {}, cmbCorte, 'Corte');
                        id_reporte = e;
                        $tblDatos2.dataTable().fnDestroy();
                        getReporte();

                },
                error: function (e) {
                    toastr.error("Error al procesar la petición " + e.responseText);
                },
                complete: function () {
                    btnAdd.removeClass('loading');
                }
            });
        }

        btnFinalizar.click(function () {
            frmReporte.get(0).reset();
            location.href = '<?php echo site_url("/nomina/index/reporteDiario")?>';
        });

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
