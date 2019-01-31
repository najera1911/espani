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
<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
<style>
    .table-info, .table-info>td, .table-info>th {
        font-size: 12px;
        text-align: center;
    }
</style>

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
<!--                    <label for="txtHE">Horas Extras</label>-->
<!--                    <input type="number" class="form-control" id="txtHE" name="txtHE">-->
<!--                </div>-->
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
                <div class="form-group col-4 text-center">
                    <br>
                    <span id ="TTBultos"></span>
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
        <div class="col-8 text-uppercase">
            <table id="tblDatos2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead class="table-info text-center"></thead>
            </table>
        </div>
        <div class="col-4 text-uppercase" style="height: 400px; overflow-y: auto;">
            <div class="card" style="box-shadow: 4px 4px #c0bebe;">
                <div class="card-header text-center">
                    RECIBO DE PAGO
                </div>
                <div class="card-body" style="font-size: 12px !important;">
                    <div class="row">
                        <table class="table table-sm" id="tblRecibo">
                            <thead>
                            <tr>
                                <th scope="col">Operación</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Tarifa</th>
                                <th scope="col">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <table class="table table-sm" id="tblReciboSab">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-5 pb-5">
        <div class="col-2">
        </div>
        <div class="col-3 text-center">
            <button type="button" class="btn btn-danger" id="btnEliminarT">Eliminar operaciones</button>
        </div>
        <div class="col-3 text-center">
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
            btnFinalizar = $("#btnFinalizar"),
            tblRecibo = $("#tblRecibo tbody"),
            tblReciboSab = $("#tblReciboSab tbody"),
            $he = 0,
            $TTBultos = $("#TTBultos"),
            $btnEliminarT = $("#btnEliminarT"),
            cat_rh_departamento = 0,
            idEmpleado=0
        ;

        let selected = [];

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
                txtFchaInicio.val(d.fecha_reporte_i).data('Zebra_DatePicker');
                //txtFchaInicio.data('Zebra_DatePicker').set_date(new Date(d.fecha_reporte_i));
                if(d.he===null){
                    $he=0;
                }else{
                    $he = parseFloat(d.he);
                }
                cat_rh_departamento = d.cat_rh_departamento;
                idEmpleado = d.cat_rh_empleado_id;
                console.log($he);
            });

        cmbBulto.change(function () {
            $.post('<?php echo site_url("/nomina/get/getTTBultos")?>', { cmbBulto: cmbBulto.val() })
                .done(function( data ) {
                    $TTBultos.text('Suma Bultos: '+ data);
                });
        });

        getDataRecibo();

        function getDataRecibo(){
            tblRecibo.empty();
            tblReciboSab.empty();
            let sum = 0;
            $.ajax({
                url: '<?php echo base_url("/nomina/get/dataRecibo")?>',
                type: "POST",
                data: {datos: idReporte},
                dataType: "html",
                success: function (e) {
                    let obj = JSON.parse(e);
                    console.log(obj);

                    let s= 0;

                    for(let x=0; x < obj.length; x++){
                        if(obj[x].operacion!='S01'){
                            let total = parseFloat(obj[x].cantidad) * parseFloat(obj[x].tarifa_con);
                            let tarifa = parseFloat(obj[x].tarifa_con).toFixed(5);
                            total = parseFloat(total.toFixed(2));
                            sum = sum + total;
                            tblRecibo.append(`
                            <tr>
                                <th align="center">${obj[x].operacion}</th>
                                <td align="center">${obj[x].cantidad}</td>
                                <td align="right">$ ${tarifa}</td>
                                <td align="right">$ ${total.toFixed(2)}</td>
                            </tr>
                        `);
                        }else{
                            let totalS = parseFloat(obj[x].cantidad) * parseFloat(obj[x].tarifa_con);
                            let tarifaS = parseFloat(obj[x].tarifa_con).toFixed(2);
                            s= parseFloat(obj[x].tarifa_con);
                            tblReciboSab.append(`
                            <tr>
                                <th align="center">${obj[x].operacion}</th>
                                <td align="center">${obj[x].cantidad}</td>
                                <td align="right">$ ${tarifaS}</td>
                                <td align="right">$ ${totalS.toFixed(2)}</td>
                            </tr>
                        `);
                        }
                    }

                    tblRecibo.append(`
                            <tr class="table-dark">
                                <th align="right" colspan="3">IMPORTE</th>
                                <td align="right">$ ${sum}</td>
                            </tr>
                        `);

                    let $totalHE = ((sum / 7)/9)*$he;
                    $totalHE = $totalHE * 2;

                    tblReciboSab.append(`
                            <tr>
                                <th align="center">H.E.</th>
                                <td align="center">${$he}</td>
                                <td align="right">H.E.</td>
                                <td align="right">$ ${$totalHE.toFixed(2)}</td>
                            </tr>
                        `);

                    let totalR = sum + $totalHE + s;

                    tblReciboSab.append(`
                            <tr class="table-dark">
                                <th  colspan="3" align="right">TOTAL</th>
                                <td align="right">$ ${totalR.toFixed(2)}</td>
                            </tr>
                        `);

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal("Error", "Error al eliminar la operación", "error");
                }
            });
        }

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

        $('#tblDatos2 tbody').on('click', 'tr', function () {
            selected = [];
            $(this).toggleClass('selected');
            let data = MY.table.rows('.selected').data();
            for (let i=0; i<data.length;i++){
                selected.push(data[i]);
            }
        } );

        $btnEliminarT.click(function () {
            if(selected.length===0){
                swal("Error", "Debe de seleccionar un registro", "error");
            }else{
                console.log(selected);
                $.ajax({
                    type: 'post',
                    url: '<?php echo site_url("/nomina/set/deleteOperacionesGroup")?>',
                    data: {data : selected},
                    success: function (e) {
                        if (e === 'OK') {
                            swal("Bien", "La operación se ha eliminado correctamente", "success");
                            MY.table.ajax.reload();
                            cargar_catalogo_select('<?php echo site_url("/nomina/get/getCortes")?>', {}, cmbCorte, 'Corte');
                            getDataRecibo();
                            selected=[];
                        }
                    },
                    error: function (e) {
                        toastr.error("Error al procesar la petición " + e.responseText);
                        selected=[];
                    },
                    complete: function () {
                        selected=[];
                    }
                });
            }
        });

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
                                    swal("Bien", "La operación se ha eliminado correctamente", "success");
                                    MY.table.ajax.reload();
                                    cargar_catalogo_select('<?php echo site_url("/nomina/get/getCortes")?>', {}, cmbCorte, 'Corte');
                                    getDataRecibo();
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
            }else if (cmbOper.val()===''){
                toastr.error("Debe seleccionar un número de operación");
            }else if (cmbBulto.val().length===0 && cmbOper.val()!=0){
                toastr.error("Debe seleccionar un número de bulto");
            }else if (txtCantidad.val()==='') {
                toastr.error("Debe ingresar cantidad");
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
                    getDataRecibo();

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
            location.href = '<?php echo site_url("/nomina/index3/reporteDiario/")?>'+cat_rh_departamento+'/'+idEmpleado;
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
