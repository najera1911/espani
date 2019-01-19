<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Orden de Corte";
$data['css'] = array(
    "toastr.min.css",
    "zebra.css"
);
$this->load->view("plantilla/encabezado", $data);
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

<style>
    #tblBultos input {
        border: 1px solid #ebebebc4 !important;
        width: 98% !important;
    }
</style>

<section class="ml-5 mr-5" id="Operaciones">
    <div class="row mt-5 mb-5">
        <div class="col text-center text-uppercase">
            <h3 class="txt-Subtitulos">Editar Ordenes de Corte <span></span></h3>
        </div>
    </div>
</section>

<section class="container">
    <div class="row mb-5">
        <div class="col-12">
            <form id="frmOrdenCorte" role="form" autocomplete="off">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="cmbCliente">Cliente</label>
                        <select class="form-control" id="cmbCliente" name="cmbCliente" required></select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtFch">Fecha de Solicitud</label>
                        <input type="text" class="form-control" id="txtFch" name="txtFch" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtNombreModelo">Nombre Modelo</label>
                        <input type="text" class="form-control" id="txtNombreModelo" name="txtNombreModelo" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtTela">Tela</label>
                        <input type="text" class="form-control" id="txtTela" name="txtTela" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="txtNunOrdenEspani">Núm. O. de Corte ESPANI</label>
                        <input type="text" class="form-control" id="txtNunOrdenEspani" name="txtNunOrdenEspani" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtNunOrdenCliente">Núm. O. de Corte Cliente</label>
                        <input type="text" class="form-control" id="txtNunOrdenCliente" name="txtNunOrdenCliente" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtMetrosTela">Mts. de tela Cortada</label>
                        <input type="number" class="form-control" id="txtMetrosTela" name="txtMetrosTela" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtColores">Colores</label>
                        <input type="text" class="form-control" id="txtColores" name="txtColores" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtNumBultos">Núm. de bultos</label>
                        <input type="number" min="1" class="form-control" id="txtNumBultos" name="txtNumBultos"
                               required>
                    </div>
                </div>
                <div class="form-row justify-content-center" id="tblBultos"></div>
                <div class="form-row justify-content-end">
                    <div class="col-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-success" type="button" id="button-Total">Total</button>
                            </div>
                            <input type="text" class="form-control" id="resultadoT" name="resultadoT" disabled>
                        </div>
                    </div>
                </div>
                <br>
                <hr style="color: #231a67;" size="10"/>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="txtObserv">Observaciones</label>
                        <textarea class="form-control" id="txtObserv" name="txtObserv" required></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="txtPinzasD">Pinzas delanteras</label>
                        <input type="text" class="form-control" id="txtPinzasD" name="txtPinzasD" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtPinzasT">Pinzas Traseras</label>
                        <input type="text" class="form-control" id="txtPinzasT" name="txtPinzasT" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtBolsasD">Bolsas Delanteras</label>
                        <input type="text" class="form-control" id="txtBolsasD" name="txtBolsasD" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtBolsasT">Bolsas Traseras</label>
                        <input type="text" min="1" class="form-control" id="txtBolsasT" name="txtBolsasT" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="txtTrabas">Trabas</label>
                        <input type="text" class="form-control" id="txtTrabas" name="txtTrabas" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtPretina">Pretina</label>
                        <input type="text" class="form-control" id="txtPretina" name="txtPretina" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtCartera">Cartera</label>
                        <input type="text" class="form-control" id="txtCartera" name="txtCartera" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtSecreta">Secreta</label>
                        <input type="text" min="1" class="form-control" id="txtSecreta" name="txtSecreta" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="txtBoton">Botón</label>
                        <input type="text" class="form-control" id="txtBoton" name="txtBoton" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtCierre">Cierre</label>
                        <input type="text" class="form-control" id="txtCierre" name="txtCierre" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtHilo">Hilo</label>
                        <input type="text" class="form-control" id="txtHilo" name="txtHilo" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtEtiqueta">Etiqueta</label>
                        <input type="text" min="1" class="form-control" id="txtEtiqueta" name="txtEtiqueta" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="txtBoton">Taqueda</label>
                        <input type="text" class="form-control" id="txtTaqueda" name="txtTaqueda" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtCierre">Pase</label>
                        <input type="text" class="form-control" id="txtPase" name="txtPase" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtHilo">Largo</label>
                        <input type="text" class="form-control" id="txtLargo" name="txtLargo" required>
                    </div>
                </div>
            </form>
<!--            <div class="row">-->
<!--                <div class="form-group col-md-6">-->
<!--                    <label for="cmbModelo">Buscar Modelo</label>-->
<!--                    <select class="form-control" id="cmbModelo" name="cmbModelo" required></select>-->
<!--                </div>-->
<!--            </div>-->
            <div class="row pt-5">
                <div class="col-12 text-center pb-3"><h5>Lista de Operaciónes</h5></div>
                <div class="col-1"><label for="cmbFCorte">Filtro Corte</label></div>
                <div class="col-4">
                    <select class="form-control" id="cmbFCorte" name="cmbFCorte"></select>
                </div>
                <div class="col-1"><label for="cmbOpe">Operación</label></div>
                <div class="col-4">
                    <select class="form-control" id="cmbOpe" name="cmbOpe"></select>
                </div>
                <div class="col-2">
                    <label></label>
                    <button type="button" class="btn btn-success" id="btnAddOpera">Agregar</button>
                </div>
                <div class="col-12 text-uppercase pt-3">
                    <table id="tblDatos2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead class="table-info text-center"></thead>
                    </table>
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
        </div>
    </div>
</section>

<script>
    let MY = {};
    let deleteRow = 0;

    $(document).ready(function (){
        let frmOrdenCorte = $("#frmOrdenCorte"),
            cmbCliente = $("#cmbCliente"),
            //cmbModelo = $("#cmbModelo"),
            cmbFCorte = $("#cmbFCorte"),
            cmbOpe = $("#cmbOpe"),
            txtNumBultos = $("#txtNumBultos"),
            tblBultos = $("#tblBultos"),
            txtFch = $("#txtFch"),
            buttonTotal = $("#button-Total"),
            btnAddOpera = $("#btnAddOpera"),
            btnGuadar = $("#btnGuardar"),
            resultadoT = $("#resultadoT"),
            $tblDatos2 = $("#tblDatos2"),
            id_ordenCorte = <?php echo $id ?>
        ;

        $.post('<?php echo site_url("/ordenCorte/get/dataOrden")?>', { idOrden: id_ordenCorte })
            .done(function( data ) {
                let obj = JSON.parse(data);
                let d = obj[0];
                const $head = $("#Operaciones").find('.txt-Subtitulos span');
                $head.html(' - ' + d.numero_corte);
                //cmbCliente.val(obj[0].cat_clientes_id);
                setTimeout(function () {
                    $('select[name="cmbCliente"]').val(d.cat_clientes_id).change();
                }, 500);
                $('input[name="txtNombreModelo"]').val(d.modelo);
                txtFch.data('Zebra_DatePicker').set_date(new Date(d.fecha_orden));
                $('input[name="txtTela"]').val(d.tela);
                $('input[name="txtNunOrdenEspani"]').val(d.numero_corte);
                $('input[name="txtNunOrdenCliente"]').val(d.num_corte_cliente);
                $('input[name="txtMetrosTela"]').val(d.mtros_tela_cortada);
                $('input[name="txtColores"]').val(d.colores);
                $('textarea[name="txtObserv"]').val(d.observaciones);
                $('input[name="txtPinzasD"]').val(d.pinzas_delanteras);
                $('input[name="txtPinzasT"]').val(d.pinzas_traseras);
                $('input[name="txtBolsasD"]').val(d.bolsas_detanteras);
                $('input[name="txtBolsasT"]').val(d.bolsas_traseras);
                $('input[name="txtTrabas"]').val(d.trabas);
                $('input[name="txtPretina"]').val(d.pretina);
                $('input[name="txtCartera"]').val(d.carteras);
                $('input[name="txtSecreta"]').val(d.secreta);
                $('input[name="txtBoton"]').val(d.boton);
                $('input[name="txtCierre"]').val(d.cierre);
                $('input[name="txtHilo"]').val(d.hilo);
                $('input[name="txtEtiqueta"]').val(d.etiqueta);
                $('input[name="txtTaqueda"]').val(d.taqueda);
                $('input[name="txtPase"]').val(d.pase);
                $('input[name="txtLargo"]').val(d.largo);
            });

        $.post('<?php echo site_url("/ordenCorte/get/dataOrdenBultos")?>', { idOrden: id_ordenCorte })
            .done(function( data ) {
                let obj = JSON.parse(data);
                let numBultos = obj.length;
                $('input[name="txtNumBultos"]').val(numBultos);

                tblBultos.empty();
                if(numBultos==="1"){
                    tblBultos.append(`
                        <div class="col-6">
                            <table class="table table-bordered table-sm">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">BULTOS</th>
                                        <th scope="col">TALLAS</th>
                                        <th scope="col">CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th><input type="number" min="1" id="nb0" name="nb0" value="${obj[0].num_bulto}"></th>
                                        <td><input type="number" min="1" id="tall0" name="tall0" value="${obj[0].tallas}"></td>
                                        <td><input type="number" min="1" id="cant0" name="cant0" value="${obj[0].cantidad}"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        `);
                }else{
                    let x = Math.round(numBultos/2);
                    tblBultos.append(`
                    <div class="col-6 pr-3">
                        <table class="table table-bordered table-sm" width="50%">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">BULTOS</th>
                                        <th scope="col">TALLAS</th>
                                        <th scope="col">CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody id="tblR"></tbody>
                        </table>
                    </div>
                    <div class="col-6 pl-3">
                        <table class="table table-bordered table-sm">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">BULTOS</th>
                                        <th scope="col">TALLAS</th>
                                        <th scope="col">CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody id="tblL"></tbody>
                            </table>
                    </div>
                `);

                    for(let i=0;i<x;i++){
                        $("#tblR").append(`
                         <tr>
                         <th><input type="number" min="1" id="nb${i}" name="nb${i}" value="${obj[i].num_bulto}"></th>
                         <td><input type="number" min="1" id="tall${i}" name="tall${i}" value="${obj[i].tallas}"></td>
                         <td><input type="number" min="1" id="cant${i}" name="cant${i}" value="${obj[i].cantidad}"></td>
                         </tr>
                    `);
                    }

                    for(let j=x; j<numBultos;j++){
                        $("#tblL").append(`
                        <tr>
                         <th><input type="number" min="1" id="nb${j}" name="nb${j}" value="${obj[j].num_bulto}"></th>
                         <td><input type="number" min="1" id="tall${j}" name="tall${j}" value="${obj[j].tallas}"></td>
                         <td><input type="number" min="1" id="cant${j}" name="cant${j}" value="${obj[j].cantidad}"></td>
                         </tr>
                    `);
                    }
                }
            });

        buttonTotal.click(function () {
            let sum =0;
            for(let x=0; x<txtNumBultos.val();x++){
                sum = sum + Number($('#cant'+x+'').val());
            }
            resultadoT.val(sum);
        });


        txtFch.Zebra_DatePicker({
            show_icon: true
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
        cargar_catalogo_select('<?php echo site_url("/ordenCorte/get/clientes")?>', {}, cmbCliente, 'Elije');

        cargar_catalogo_select('<?php echo site_url("/ordenCorte/get/filtroCorte")?>', {}, cmbFCorte, 'Elije');
        cmbFCorte.change(function () {
            cmbOpe.html('');
            cargar_catalogo_select('<?php echo site_url("/ordenCorte/get/operac")?>', {id: cmbFCorte.val()}, cmbOpe, 'Elije');
        });


        getModelosDetalle();
        function getModelosDetalle() {
            MY.table = $tblDatos2.DataTable({
                processing: true,
                scrollY: 400,
                serverSide: true,
                ordering: true,
                info: false,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                ajax: {
                    "url": "<?php echo site_url('/ordenCorte/get/getModelosEdit')?>",
                    "type": "POST",
                    "data": { "tbl_ordencorte_id": id_ordenCorte}
                },
                columns: [
                    {"title": "Nombre Modelo", "data": "nombre_modelo", "className": "text-center"},
                    {"title": "Filtro Corte", "data": "filtro_corte", "className": "text-center"},
                    {"title": "Clave", "data": "clave", "className": "text-center"},
                    {"title": "Operación", "data": "operacion", "className": "text-center"},
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


        $("#tblDatos2 tbody").on('click', 'td .btn-danger', function (){
            let data = MY.table.rows($(this).closest("tr")).data();
            data = data[0];
            deleteRow=1;
            OperacionDelete(data);
        } );

        function OperacionDelete(data){
            swal({
                    title: "Eliminar una operación",
                    text: "Desea eliminar a: "+ data.clave +"",
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
                            url: '<?php echo base_url("ordenCorte/set/deleteOrdenOperacionEdit")?>',
                            type: "POST",
                            data: {datos: data.cat_operaciones_id, tbl_ordencorte_id: id_ordenCorte},
                            dataType: "html",
                            success: function (e) {
                                if (e === 'OK') {
                                    swal("Bien", "La operación se ha eliminado correctamente", "success");
                                    $tblDatos2.dataTable().fnDestroy();
                                    getModelosDetalle();
                                    deleteRow = 0;
                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                swal("Error", "Error al eliminar la operación", "error");
                            }
                        });
                    } else {
                        swal("Cancelado", data.nombreOperacion + " no se elimino", "error");
                    }
                });
        }

        btnAddOpera.click(function () {
            if (btnAddOpera.hasClass('loading')) { return false; }
            btnAddOpera.addClass('loading');
            setAddCorte();
        });

        function setAddCorte() {
            $.ajax({
                type: 'post',
                url: '<?php echo site_url("/ordenCorte/set/addOperacionEdit")?>',
                data: {"data": cmbOpe.val(), "tbl_ordencorte_id": id_ordenCorte },
                success: function (e) {
                    if (e === 'OK') {
                        swal("Correcto", "Datos se guardados exitosamente", "success");
                        deleteRow = 1;
                        $tblDatos2.dataTable().fnDestroy();
                        getModelosDetalle();
                        deleteRow = 0;
                    }
                },
                error: function (e) {
                    toastr.error("Error al procesar la petición " + e.responseText);
                },
                complete: function () {
                    btnAddOpera.removeClass('loading');
                }
            });
        }

        btnGuadar.click(function () {

            if($("#cmbCliente").val()===''){
                toastr.error("Debe de seleccionar un cliente");
            }else if ($("#txtFch").val()===''){
                toastr.error("Debe ingresar una fecha");
            }else if($("#txtNombreModelo").val()===''){
                toastr.error("debe ingresar un nombre de modelo");
            }else if($("#txtNunOrdenEspani").val()===''){
                toastr.error("Debe ingresar un numero de orden de ESPANI");
            }else if($("#txtNunOrdenCliente").val()===''){
                toastr.error("Debe ingresar un numero de orden de Cliente");
            }else if(txtNumBultos.val()===''){
                toastr.error("Debe de seleccionar al menos un bulto ");
            }else if($("#nb0").val()==='' || $("#tall0").val()==='' || $("#cant0").val()==='' ){
                toastr.error("Debe de ingresar al menos un dato en bulto ");
            }else{
                if (btnGuadar.hasClass('loading')) {
                    return false;
                }
                btnGuadar.addClass('loading');
                setOrdenCorte();
            }
        });

        function setOrdenCorte() {
            $.ajax({
                type: 'post',
                url: '<?php echo site_url("/ordenCorte/set/ordencorteEdit")?>',
                data: frmOrdenCorte.serialize() + "&idOrden=" + id_ordenCorte,
                success: function (e) {
                    if (e === 'ok') {
                        swal("Correcto", "Datos se guardados exitosamente", "success");
                        frmOrdenCorte.get(0).reset();
                        location.href = '<?php echo site_url("/ordenCorte/index/verOrdenCorte")?>';
                    }
                },
                error: function (e) {
                    toastr.error("Error al procesar la petición " + e.responseText);
                },
                complete: function () {
                    btnGuadar.removeClass('loading');
                }
            });
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
);
$this->load->view("plantilla/pie", $data);
?>
