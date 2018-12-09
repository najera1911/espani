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
            <h3 class="txt-Subtitulos">Generar Ordenes de Corte</h3>
        </div>
    </div>
</section>

<section class="container">
    <div class="row mb-5">
        <div class="col-12">
        <form id="frmOrdenCorte">
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
                    <label for="cmbModelo">Modelo</label>
                    <select class="form-control" id="cmbModelo" name="cmbModelo" required></select>
                </div>
                <div class="form-group col-md-3">
                    <label for="txtTela">Tela</label>
                    <input type="text" class="form-control" id="txtTela" name="txtTela" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="txtNunOrden">Número de Orden de Corte</label>
                    <input type="number" class="form-control" id="txtNunOrden" name="txtNunOrden" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="txtMetrosTela">Metros de tela Cortada</label>
                    <input type="number" class="form-control" id="txtMetrosTela" name="txtMetrosTela" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="txtColores">Colores</label>
                    <input type="text" class="form-control" id="txtColores" name="txtColores" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="txtNumBultos">Número de bultos</label>
                    <input type="number" min="1" class="form-control" id="txtNumBultos" name="txtNumBultos" required>
                </div>
            </div>
            <div class="form-row justify-content-center" id="tblBultos"></div>
            <div class="form-row justify-content-end">
                <div class="col-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-success" type="button" id="button-Total">Total</button>
                        </div>
                        <input type="text" class="form-control" id="resultadoT" disabled>
                    </div>
                </div>
            </div>
            <br>
            <hr style="color: #231a67;" size="10" />
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
                    <label for="txtBolsasD">Bolsas Delenteras</label>
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
            <div class="form-row pt-5">
                <div class="col-12 text-center"><h5>Lista de Operaciónes</h5></div>
                <div class="col-12 text-uppercase">
                    <table id="tblDatos2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead class="table-info text-center"></thead>
                    </table>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
        </div>
    </div>
</section>




<script>
    let MY = {};

    $(document).ready(function (){
        let frmOrdenCorte = $("#frmOrdenCorte"),
            cmbCliente = $("#cmbCliente"),
            cmbModelo = $("#cmbModelo"),
            txtNumBultos = $("#txtNumBultos"),
            tblBultos = $("#tblBultos"),
            txtFch = $("#txtFch"),
            buttonTotal = $("#button-Total"),
            resultadoT = $("#resultadoT"),
            $tblDatos2 = $("#tblDatos2")
        ;

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
        cargar_catalogo_select('<?php echo site_url("/ordenCorte/get/modeloCorte")?>', {}, cmbModelo, 'Elije');

        txtNumBultos.change(function() {
            let numBultos = txtNumBultos.val();
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
                                        <th><input type="number" min="1" id="nb0" name="nb1"></th>
                                        <td><input type="number" min="1" id="tall0" name="nb1"></td>
                                        <td><input type="number" min="1" id="cant0" name="nb1"></td>
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
                         <th><input type="number" min="1" id="nb${i}" name="nb${i}"></th>
                         <td><input type="number" min="1" id="tall${i}" name="tall${i}"></td>
                         <td><input type="number" min="1" id="cant${i}" name="cant${i}"></td>
                         </tr>
                    `);
                }

                for(let j=x; j<numBultos;j++){
                    $("#tblL").append(`
                        <tr>
                         <th><input type="number" min="1" id="nb${j}" name="nb${j}"></th>
                         <td><input type="number" min="1" id="tall${j}" name="tall${j}"></td>
                         <td><input type="number" min="1" id="cant${j}" name="cant${j}"></td>
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

        cmbModelo.change(function () {
            $tblDatos2.dataTable().fnDestroy();
            getModelosDetalle();
        });

        getModelosDetalle();
        function getModelosDetalle() {
            console.log(cmbModelo.val());
            MY.table = $tblDatos2.DataTable({
                processsing: true,
                serverSide: true,
                ordering: true,
                info: false,
                ajax: {
                    "url": "<?php echo site_url('/operaciones/get/datosModelosCortesDetalle')?>",
                    "type": "POST",
                    "data": { "idModel": cmbModelo.val() }
                },
                columns: [
                    {"title": "Nombre Modelo", "data": "modeloCorte", "className": "text-center"},
                    {"title": "Filtro Corte", "data": "tipoCorte", "className": "text-center"},
                    {"title": "Clave", "data": "operacion", "className": "text-center"},
                    {"title": "Operación", "data": "nombreOperacion", "className": "text-center"},
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

        $("#tblDatos2 tbody").on('click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                MY.table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $("#tblDatos2 tbody").on('click', 'td .btn-danger', function (){
            MY.table.row('.selected').remove().draw( false );
        } );


    }); // end document ready

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