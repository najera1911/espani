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
                <h3 class="txt-Subtitulos">Puestos</h3>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <button type="button" class="btn btn-warning btn-circle float-right ml-2" id="btnExportExcel"><i
                            class="fas fa-file-excel"></i></button>
                <button class="btn btn-success float-right" id="btnNuevoPuesto">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Agregar Puesto
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
    </section><!--FIN SECTION-->
    <!--INICIA MODAL-->
    <div class="modal fade" id="wPuestoEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-fluid modal-full-height modal-top modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Puestos <span></span> - Datos Generales </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="row">
                        <div class="col-12">
                            <form id="frmPuesto" role="form" autocomplete="off">
                                <div class="form-row">
                                    <div class="form-group col-lg-12">
                                        <label for="txtName">Descripcion</label>
                                        <input type="text" class="form-control text-uppercase" id="txtDescripcion" name="txtDescripcion" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" id="btnGuardarPuesto">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
let MY = {
};
$(document).ready(function(){
    let $btnNuevoPuesto = $("#btnNuevoPuesto"),
        $tblDatos2 = $("#tblDatos2"),
        $wPuestoEdit = $("#wPuestoEdit"),
        $frmPuesto = $("#frmPuesto"),
        $btnGuardarPuesto =$("#btnGuardarPuesto"),
        $_arregloPuesto = {};

       getPuesto();

       function getPuesto(){
        MY.table = $tblDatos2.DataTable({
            processsing: true,
            serverSide: true,
            ordering: true,
            info: false,
            ajax: {
                "url": "<?php echo site_url('/puestos/get/puestos')?>",
                "type": "POST"
            },
            columns: [
                {"title": "Id", "data":"cat_rh_puesto_id" },
                {"title": "Descripcion", "data":"descripcion"},
                { "title": "Editar", data:null,
                            render:function(data, type,row){
                                return '<button class="btn btn-success btn-sm">Editar</button>';
                            }
                        },
                        { "title": "Eliminar", data:null,
                            render:function(data, type,row){
                                return '<button class="btn btn-warning btn-sm">Eliminar</button>';
                            }
                        }
            ],
            order: [],
            language: {
                        "url": "<?php echo base_url();?>/assets/js/lang-es.lang"
                    }                
        });
    } // end tabled
    $("#tblDatos2 tbody").on('click','td .btn-success',function(){
                let data = MY.table.rows($(this).closest("tr")).data();
                $_arregloPuesto = data[0];

                $('input[name="txtDescripcion"]').val($_arregloPuesto.descripcion);
                
                $wPuestoEdit.modal('show');
            });

            $("#tblDatos2 tbody").on('click','td .btn-warning',function(){
                let data = MY.table.rows($(this).closest("tr")).data();
                data = data[0];
                PuestoDelete(data);
            });

            $wPuestoEdit.on('hide.bs.modal', function () {
                $_arregloPuesto = {};
                $frmPuesto.get(0).reset();
                $btnGuardarPuesto.removeClass("loading");
                $frmPuesto.removeClass('loading');
            });

            $wPuestoEdit.on('shown.bs.modal', function () {
                const $head = $wPuestoEdit.find('.modal-title span');
                if ($_arregloPuesto.hasOwnProperty('cat_rh_puesto_id')) {
                    $head.html(' ' + $_arregloPuesto.descripcion);
                } else {
                    $head.html(' Nuevo');
                }
            });
            $btnNuevoPuesto.click(function () {
                $wPuestoEdit.modal("show");
            });

            $btnGuardarPuesto.click(function () {
                if ($btnGuardarPuesto.hasClass('loading')) { return false; }
                $btnGuardarPuesto.addClass('loading');
                $frmPuesto.addClass('loading');
                setPuesto();
            });

            function setPuesto() {
                let data = new FormData($frmPuesto.get(0));
                if ($_arregloPuesto.hasOwnProperty('cat_rh_puesto_id')) {
                    data.append('_id_', $_arregloPuesto.cat_rh_puesto_id);
                }

                $.ajax({
                    type: 'post',
                    url: '<?php echo site_url("/puestos/set/puestos")?>',
                    xhr: function () {  // Custom XMLHttpRequest
                        const myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) { // Check if upload property exists
                            myXhr.upload.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
                                }
                            }, false); // For handling the progress of the upload
                        }
                        return myXhr;
                    },
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (e) {
                            if (e.length) {
                                let obj = JSON.parse(e);
                                if (obj.hasOwnProperty('status') && obj.status === "Ok") {
                                    $frmPuesto.get(0).reset();
                                    $wPuestoEdit.modal('hide');
                                    swal("Correcto", "Datos del cliente guardados exitosamente", "success");
                                    MY.table.ajax.reload();
                                }
                            } else {
                                swal("Error", e , "error");
                                $frmPuesto.get(0).reset();
                            }
                    },
                    error: function (e) {
                        toastr.error("Error al procesar la petición " + e.responseText);
                    },
                    complete: function () {
                        $btnGuardarPuesto.removeClass('loading');
                        $frmPuesto.removeClass('loading');
                    }
                });
            }

            function PuestoDelete(data){
                swal({
                        title: "Eliminar un departamento",
                        text: "Desea eliminar a: "+ data.descripcion +"",
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
                                url: '<?php echo base_url("puestos/set/deleteArea")?>',
                                type: "POST",
                                data: {datos: data.cat_rh_puesto_id},
                                dataType: "html",
                                success: function (e) {
                                    if (e === 'OK') {
                                        swal("Bien", "El area se ha eliminado correctamente", "success");
                                        MY.table.ajax.reload();
                                    }
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    swal("Error", "Error al eliminar usuario", "error");
                                }
                            });
                        } else {
                            swal("Cancelado", data.descripcion + " no se elimino", "error");
                        }
                    });
            }
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
