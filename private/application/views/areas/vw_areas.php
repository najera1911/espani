<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Clientes";
$data['css'] = array(
    "toastr.min.css",
    "zebra.css",
    "../datatables/datatables.min.css"
);
$this->load->view("plantilla/encabezado", $data);
?>
<section class="ml-5 mr-5" id="Areas">
        <div class="row mt-5 mb-5">
            <div class="col text-center text-uppercase">
                <h3 class="txt-Subtitulos"> Departamentos</h3>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <button type="button" class="btn btn-warning btn-circle float-right ml-2" id="btnExportExcel"><i
                            class="fas fa-file-excel"></i></button>
                <button class="btn btn-success float-right" id="btnNuevaArea">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Agregar Departamento
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-uppercase">
                <table id="tblDatos2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="table-info"></thead>
                </table>
            </div>
        </div>
    </section>




<script>
let MY = {
};
$(document).ready(function(){
    let $btnNuevaArea = $("#btnNuevaArea"),
        $tblDatos2 = $("#tblDatos2");

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
