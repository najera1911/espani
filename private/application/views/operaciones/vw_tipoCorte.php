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

<section class="ml-5 mr-5" id="tipoCorte">
    <div class="row mt-5 mb-5">
        <div class="col text-center text-uppercase">
            <h3 class="txt-Subtitulos">Tipo de Cortes</h3>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <button type="button" class="btn btn-warning btn-circle float-right ml-2" id="btnExportExcel"><i
                    class="fas fa-file-excel"></i></button>
            <button class="btn btn-success float-right" id="btnNuevoTipoCorte">
                <i class="fa fa-user-plus" aria-hidden="true"></i> Agregar Tipo Corte
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
<div class="modal fade" id="wTipoCorteEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-fluid modal-full-height modal-top modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Tipo Corte <span></span> - Datos Generales </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="row">
                    <div class="col-12">
                        <form id="frmTipoCorte" role="form" autocomplete="off">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label for="txtName">Descripcion</label>
                                    <input type="text" class="form-control text-uppercase" id="txtDescripcion"
                                           name="txtDescripcion" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success" id="btnGuardarTipoCorte">Guardar</button>
            </div>
        </div>
    </div>
</div>


<script>
    let MY = {
    };
    $(document).ready(function(){
        let $btnNuevoTipoCorte = $("#btnNuevoTipoCorte"),
            $tblDatos2 = $("#tblDatos2"),
            $wTipoCorteEdit = $("#wTipoCorteEdit"),
            $frmTipoCorte = $("#frmTipoCorte"),
            $btnGuardarTipoCorte =$("#btnGuardarTipoCorte"),
            $_arregloTipoCorte = {};

        getTipoCorte();

        function getTipoCorte(){
            MY.table = $tblDatos2.DataTable({
                processsing: true,
                serverSide: true,
                ordering: true,
                info: false,
                ajax: {
                    "url": "<?php echo site_url('/operaciones/get/tipoCorte')?>",
                    "type": "POST"
                },
                columns: [
                    {"title": "Id", "data":"cat_tipo_corte_id" },
                    {"title": "Descripcion", "data":"descripcion"},
                    { "title": "Editar", data:null,
                        render:function(data, type,row){
                            return '<button class="btn btn-success btn-sm">Editar</button>';
                        }
                    },
                    { "title": "Eliminar", data:null,
                        render:function(data, type,row){
                            return '<button class="btn btn-danger btn-sm">Eliminar</button>';
                        }
                    }
                ],
                order: [],
                language: {
                    "url": "<?php echo base_url();?>/assets/js/lang-es.lang"
                }
            });
        } // end tabled

        $wTipoCorteEdit.on('hide.bs.modal', function () {
            $_arregloTipoCorte = {};
            $frmTipoCorte.get(0).reset();
            $btnGuardarTipoCorte.removeClass("loading");
            $frmTipoCorte.removeClass('loading');
        });

        $wTipoCorteEdit.on('shown.bs.modal', function () {
            const $head = $wTipoCorteEdit.find('.modal-title span');
            if ($_arregloTipoCorte.hasOwnProperty('cat_tipo_corte_id')) {
                $head.html(' ' + $_arregloTipoCorte.descripcion);
            } else {
                $head.html(' Nuevo');
            }
        });

        $("#tblDatos2 tbody").on('click','td .btn-success',function(){
            let data = MY.table.rows($(this).closest("tr")).data();
            $_arregloTipoCorte= data[0];
            $('input[name="txtDescripcion"]').val($_arregloTipoCorte.descripcion);
            $wTipoCorteEdit.modal("show");
        });

        $("#tblDatos2 tbody").on('click','td .btn-danger',function(){
            let data = MY.table.rows($(this).closest("tr")).data();
            data = data[0];
            TipoCorteDelete(data);
        });

        $btnNuevoTipoCorte.click(function () {
            $wTipoCorteEdit.modal("show");
        });

        $btnGuardarTipoCorte.click(function () {
            if ($btnGuardarTipoCorte.hasClass('loading')) { return false; }
            $btnGuardarTipoCorte.addClass('loading');
            $frmTipoCorte.addClass('loading');
            setTipoCorte();
        });

        function setTipoCorte() {
            let data = new FormData($frmTipoCorte.get(0));
            if ($_arregloTipoCorte.hasOwnProperty('cat_tipo_corte_id')) {
                data.append('_id_', $_arregloTipoCorte.cat_tipo_corte_id);
            }

            $.ajax({
                type: 'post',
                url: '<?php echo site_url("/operaciones/set/tipoCorte")?>',
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
                            $frmTipoCorte.get(0).reset();
                            $wTipoCorteEdit.modal('hide');
                            swal("Correcto", "Datos se guardados exitosamente", "success");
                            MY.table.ajax.reload();
                        }
                    } else {
                        swal("Error", e , "error");
                        $frmTipoCorte.get(0).reset();
                    }
                },
                error: function (e) {
                    toastr.error("Error al procesar la petición " + e.responseText);
                },
                complete: function () {
                    $btnGuardarTipoCorte.removeClass('loading');
                    $frmTipoCorte.removeClass('loading');
                }
            });
        }

        function TipoCorteDelete(data){
            swal({
                    title: "Eliminar tipo de corte",
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
                            url: '<?php echo base_url("operaciones/set/deleteTipoCorte")?>',
                            type: "POST",
                            data: {datos: data.cat_tipo_corte_id},
                            dataType: "html",
                            success: function (e) {
                                if (e === 'OK') {
                                    swal("Bien", "El tipo de corte se ha eliminado correctamente", "success");
                                    MY.table.ajax.reload();
                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                swal("Error", "Error al eliminar tipo de corte", "error");
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
