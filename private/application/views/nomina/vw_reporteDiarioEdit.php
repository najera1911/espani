<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Reporte Diario Nuevo";
$data['css'] = array(
    "toastr.min.css",
    "zebra.css",
    "../select2/css/select2.min.css"
);
$this->load->view("plantilla/encabezado", $data);
?>

<section class="ml-5 mr-5" id="Operaciones">
    <div class="row mt-5 mb-3">
        <div class="col text-center text-uppercase">
            <h3 class="txt-Subtitulos">Editar Reporte Diario de Producción</h3>
        </div>
    </div>
    <div class="row pb-5 pt-3">
        <div class="col-12 text-uppercase font-weight-bold" id="nombre"></div>
    </div>
    <div class="row">
        <form id="frmReporte" class="container-fluid" role="form" autocomplete="off">
            <div class="row">
                <div class="form-group col-3 text-uppercase">
                    <label for="txtFchaInicio">Fecha Reporte</label>
                    <input type="text" class="form-control" id="txtFchaInicio" name="txtFchaInicio" required>
                </div>
<!--                <div class="form-group col-3 text-uppercase">-->
<!--                    <label for="txtFchaFin">Fecha Final Reporte</label>-->
<!--                    <input type="text" class="form-control" id="txtFchaFin" name="txtFchaFin" required>-->
<!--                </div>-->
                <div class="form-group col-6">
                    <label for="cmbCorte">Corte</label>
                    <select class="form-control js-example-basic-single" id="cmbCorte" name="cmbCorte" required></select>
                </div>
                <div class="form-group col-5">
                    <label for="cmbOper">Operación</label>
                    <select class="form-control js-example-basic-single" id="cmbOper" name="cmbOper" required></select>
                </div>
                <div class="form-group col-5">
                    <label for="cmbBulto">Bulto</label>
                    <select multiple="multiple" class="form-control js-example-basic-single" id="cmbBulto" name="cmbBulto[]" required></select>
                </div>
                <div class="form-group col-2">
                    <div class="custom-control custom-checkbox">
                        <br>
                        <input type="checkbox" class="custom-control-input" id="checkbox" name="checkbox">
                        <label class="custom-control-label" for="checkbox">Seleccionar Todos</label>
                    </div>
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
<!--    <div class="row pb-3">-->
<!--        <div class="col-4">-->
<!--            <button type="button" class="btn btn-secondary pl-2" id="verOperacionDetalle">  Ver Operaciones </button>-->
<!--        </div>-->
<!--    </div>-->
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
        let idReporte = <?php echo $id ?>,
            nombreEmpleado = $("#nombre"),
            $tblDatos2 = $("#tblDatos2"),
            txtFchaInicio = $("#txtFchaInicio"),
            //txtFchaFin = $("#txtFchaFin"),
            btnAdd = $("#btnAdd"),
            frmReporte = $("#frmReporte"),
            cmbCorte = $("#cmbCorte"),
            cmbBulto = $("#cmbBulto"),
            cmbOper = $("#cmbOper"),
            txtCantidad = $("#txtCantidad"),
            id_reporte = 0,
            btnFinalizar = $("#btnFinalizar")
        ;

        cmbBulto.select2({
            allowClear: true,
            minimumResultsForSearch: -1,
            width: 500
        });
        cmbCorte.select2();
        cmbOper.select2();
        txtFchaInicio.Zebra_DatePicker({
            show_icon: true,
            format: 'Y/m/d'
        });

        /*txtFchaFin.Zebra_DatePicker({
            show_icon: true,
            format: 'Y/m/d',
            direction: true // change 0 to true
        });*/

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
            if(placeholder!=''){
                $obj.html('<option value="">' + placeholder + '</option>');
            }

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
            cargar_catalogo_select('<?php echo site_url("/nomina/get/getOperaciones")?>',
                {idCorte : cmbCorte.val()}, cmbOper, 'Operación');
        });

        cmbOper.change(function () {
            cmbBulto.html('');
            cargar_catalogo_select('<?php echo site_url("/nomina/get/getBultos")?>',
                {idCorte : cmbCorte.val(), idOper:cmbOper.val()}, cmbBulto,'');
        });

        $("#checkbox").click(function(){
            if($("#checkbox").is(':checked') ){
                console.log('ok');
                $("#cmbBulto > option").prop("selected","selected");
                $("#cmbBulto").trigger("change");
            }else{
                console.log('ok2');
                cmbBulto.val(null).trigger("change");
            }
        });

        $.post('<?php echo site_url("/nomina/get/dataReporteProd")?>', { idReporte: idReporte })
            .done(function( data ) {
                let obj = JSON.parse(data);
                let d = obj[0];
                nombreEmpleado.html('Nombre: '+ d.NombreC + '   '+ d.departamento +'   Puesto: ' + d.puesto);
                txtFchaInicio.data('Zebra_DatePicker').set_date(new Date(d.fecha_reporte_i));

            });

        getReporte();
        function getReporte() {
            MY.table = $tblDatos2.DataTable({
                processing: true,
                scrollY: '50vh',
                scrollCollapse: true,
                serverSide: true,
                ordering: true,
                info: false,
                searching : false,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                ajax: {
                    "url": "<?php echo site_url('/nomina/get/getReporte')?>",
                    "type": "POST",
                    "data": { "tbl_reportediario_id": idReporte }
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

        $("#tblDatos2 tbody").on('click','td .btn-danger',function(){
            let data = MY.table.rows($(this).closest("tr")).data();
            data = data[0];
            console.log(data.tbl_reportediario_detalle_id);
            OperacionDelete(data);

        });

        function OperacionDelete(data){
            swal({
                    title: "Eliminar una Operación",
                    text: "Desea eliminar la operación: "+ data.operacion +"",
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
                            url: '<?php echo base_url("/nomina/set/deleteOperacion")?>',
                            type: "POST",
                            data: {datos: data},
                            dataType: "html",
                            success: function (e) {
                                if (e === 'OK') {
                                    swal("Bien", "El cliente se ha eliminado correctamente", "success");
                                    MY.table.ajax.reload();
                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                swal("Error", "Error al eliminar la operación", "error");
                            }
                        });
                    } else {
                        swal("Cancelado", data.operacion + " no se elimino", "error");
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
            data.push({name: 'id_reporte', value: idReporte});

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
    "zebra_datepicker.src.js",
    "js1/moment.min.js",
    "../select2/js/select2.min.js"
);
$this->load->view("plantilla/pie", $data);
?>
