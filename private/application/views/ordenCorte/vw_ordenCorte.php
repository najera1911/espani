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
                <div class="form-group col-md-4">
                    <label for="cmbCliente">Cliente</label>
                    <select class="form-control" id="cmbCliente" name="cmbCliente" required></select>
                </div>
                <div class="form-group col-md-6">
                    <label for="txtFchaNac">Fecha Nacimiento</label>
                    <input type="text" class="form-control" id="txtFchaNac" name="txtFchaNac" required>
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress">Address</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div>
            <div class="form-group">
                <label for="inputAddress2">Address 2</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCity">City</label>
                    <input type="text" class="form-control" id="inputCity">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputState">State</label>
                    <select id="inputState" class="form-control">
                        <option selected>Choose...</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputZip">Zip</label>
                    <input type="text" class="form-control" id="inputZip">
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Check me out
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
        </div>
    </div>
</section>


<script>
    let MY = {};

    $(document).ready(function (){

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
