<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Modelos Cortes";
$data['css'] = array(
    "toastr.min.css",
    "zebra.css",
    "../datatables/datatables.min.css"
);
$this->load->view("plantilla/encabezado", $data);
?>

<section class="ml-5 mr-5" id="modelosCortes">
    <div class="row mt-5 mb-5">
        <div class="col text-center text-uppercase">
            <h3 class="txt-Subtitulos">Modelos Cortes</h3>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <button type="button" class="btn btn-warning btn-circle float-right ml-2" id="btnExportExcel"><i
                    class="fas fa-file-excel"></i></button>
            <button class="btn btn-success float-right" id="btnNuevaModelo">
                <i class="fa fa-user-plus" aria-hidden="true"></i> Agregar un nuevo modelo
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

<div class="modal fade" id="wOperacionesEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-fluid modal-full-height modal-top modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Operaciones<span></span> - Datos Generales </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="row">
                    <div class="col-12">
                        <form id="frmOperaciones" role="form" autocomplete="off">
                            <div class="form-row">
                                <div class="form-group col-lg-4">
                                    <label for="cmbTipoCorte">Tipo de Corte</label>
                                    <select class="form-control" id="cmbTipoCorte" name="cmbTipoCorte"
                                            required></select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="txtOperacion">Clave operacion</label>
                                    <input type="text" class="form-control text-uppercase" id="txtOperacion"
                                           name="txtOperacion" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="txtDescripcion">Descripcion</label>
                                    <input type="text" class="form-control text-uppercase" id="txtDescripcion"
                                           name="txtDescripcion" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label class="sr-only" for="txtTarifa_sin">Tarifa sin 7o</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">$</div>
                                        </div>
                                        <input type="number" class="form-control" id="txtTarifa_sin"
                                               name="txtTarifa_sin" placeholder="Tarifa sin 7o">
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label class="sr-only" for="txtTarifa_con">Tarifa con 7o</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">$</div>
                                        </div>
                                        <input type="number" class="form-control" id="txtTarifa_con"
                                               name="txtTarifa_con" placeholder="Tarifa con 7o">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" class="btn btn-success" id="btnGuardarOperacion">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<script>
    let MY = {};

    $(document).ready(function (){
        let $btnNuevaModelo = $("#btnNuevaModelo")
        ;

    }); // end document ready
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
