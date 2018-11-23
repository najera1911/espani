<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Orden de Corte";
$data['css'] = array(
    "toastr.min.css",
    "zebra.css",
    "../datatables/datatables.min.css"
);
$this->load->view("plantilla/encabezado", $data);
?>

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
                    <label for="txtModelo">Modelo</label>
                    <input type="text" class="form-control" id="txtModelo" name="txtModelo" required>
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
            <div class="form-row justify-content-center" id="tblBultos">
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
            txtNumBultos = $("#txtNumBultos"),
            tblBultos = $("#tblBultos")
        ;

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
                                        <th><input type="number" min="1" id="nb1" name="nb1"></th>
                                        <td><input type="number" min="1" id="tall1" name="nb1"></td>
                                        <td><input type="number" min="1" id="cant1" name="nb1"></td>
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


    }); // end document ready

</script>
<?php
$data['scripts'] = array(
    "jqw/localized-es.js",
    "toastr.min.js",
    "zebra_datepicker.src.js",
    "../datatables/datatables.min.js",
    "../datatables/Buttons/js/dataTables.buttons.min.js",
    "js1/moment.min.js"
);
$this->load->view("plantilla/pie", $data);
?>
