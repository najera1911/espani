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

<style>
    .boxSha{
        border: 1px solid #4f4f4f;
        box-shadow: 5px 4px 5px #868686;
        padding: 2%;
        height: 200px;
        overflow-y: scroll;
        font-size: 14px !important;
    }
    .modal-lg {
        max-width: 95% !important;
    }
</style>

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

<div class="modal fade" id="wModelosCortesEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-fluid modal-full-height modal-top modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Modelos de Corte<span></span> - </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="row pt-5">
                    <div class="col-12">
                        <form id="frmModelosCortes" role="form" autocomplete="off">
                            <div class="form-group col-12 col-md-6">
                                <label for="txtnombreModelo">Nombre del Modelo</label>
                                <input type="text" class="form-control text-uppercase" id="txtnombreModelo" name="txtnombreModelo" required>
                            </div>
                            <div class="form-group col-12 text-center">
                                <h5>SELECCIONE LAS OPERACIONES</h5>
                            </div>
                            <div class="form-row" id="formRowModels"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" class="btn btn-success" id="btnGuardarModelosCortes">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="wModelosCortesView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-fluid modal-full-height modal-top modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Modelos de Corte <span></span> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="row">
                    <div class="col-12 text-uppercase">
                        <table id="tblDatos3" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead class="table-info text-center"></thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    let MY = {};

    $(document).ready(function () {
        let $tblDatos2 = $("#tblDatos2"),
            $tblDatos3 = $("#tblDatos3"),
            $wModelosCortesView = $("#wModelosCortesView"),
            btnNuevaModelo = $("#btnNuevaModelo"),
            wModelosCortesEdit = $("#wModelosCortesEdit"),
            frmModelosCortes = $("#frmModelosCortes"),
            btnGuardarModelosCortes = $("#btnGuardarModelosCortes"),
            formRowModels = $("#formRowModels"),
            _arregloOperacion = {},
            $datosModelosver = {}
        ;

        getOperacion();
        function getOperacion() {
            MY.table = $tblDatos2.DataTable({
                processsing: true,
                serverSide: true,
                ordering: true,
                info: false,
                ajax: {
                    "url": "<?php echo site_url('/operaciones/get/datosModelosCortes')?>",
                    "type": "POST"
                },
                columns: [
                    {"title": "Numero", "data": "cat_modelos_cortes_id", "className": "text-center"},
                    {"title": "Nombre", "data": "descripcion", "className": "text-center"},
                    {
                        "title": "Ver", data: null,
                        render: function (data, type, row) {
                            return '<button class="btn btn-primary btn-sm">Ver</button>';
                        }, "className": "text-center"
                    },
                    {
                        "title": "Editar", data: null,
                        render: function (data, type, row) {
                            return '<button class="btn btn-success btn-sm">Editar</button>';
                        }, "className": "text-center"
                    },
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

        $("#tblDatos2 tbody").on('click', 'td .btn-primary', function () {
            let data = MY.table.rows($(this).closest("tr")).data();
            $datosModelosver = data[0];
            getModelosDetalle();
            $wModelosCortesView.modal('show');
        });

        function getModelosDetalle() {
            console.log($datosModelosver.cat_modelos_cortes_id);
            $tblDatos3.DataTable({
                processsing: true,
                serverSide: true,
                ordering: true,
                info: false,
                ajax: {
                    "url": "<?php echo site_url('/operaciones/get/datosModelosCortesDetalle')?>",
                    "type": "POST",
                    "data": { "idModel": $datosModelosver.cat_modelos_cortes_id }
                },
                columns: [
                    {"title": "Nombre Modelo", "data": "modeloCorte", "className": "text-center"},
                    {"title": "Filtro Corte", "data": "tipoCorte", "className": "text-center"},
                    {"title": "Clave O", "data": "operacion", "className": "text-center"},
                    {"title": "Operación", "data": "nombreOperacion", "className": "text-center"}
                ],
                order: [],
                language: {
                    "url": "<?php echo base_url();?>/assets/js/lang-es.lang"
                }
            });
        }

        $("#tblDatos2 tbody").on('click', 'td .btn-success', function () {
            let data = MY.table.rows($(this).closest("tr")).data();
            _arregloOperacion = data[0];

            $.post('<?php echo site_url("/operaciones/get/datosModelosCortesDetalle")?>',
                { "idModel": _arregloOperacion.cat_modelos_cortes_id },
                function (e) {
                let data = e.data;
                    console.log(data);
                $.each(data, function (j, item) {
                    console.log(item.cat_operaciones_id);
                    document.getElementById(''+item.cat_operaciones_id+'').checked = true;
                    $('#lb'+item.cat_operaciones_id+'').css({'fontWeight': 'bold'});
                });

            }, 'json'); //end getJSON

            $('input[name="txtnombreModelo"]').val(_arregloOperacion.descripcion);

            wModelosCortesEdit.modal('show');
        });

        function getContFilter(e) {
            let cont = 0, ant = 0, array=[];
            for (let i in e) {
                for (let j in e[i]) {
                    let primero = e[i][j].cat_tipo_corte_id;
                    if (ant !== primero) {
                        cont++;
                        array.push(e[i][j].tipoCorte);
                        ant = primero;
                    }
                }
            }
            return array;
        }

        getData();
        function getData(){
            $.getJSON('<?php echo site_url("/operaciones/get/operaciones2")?>', function (e) {
                let cont = getContFilter(e);
                for (let i=0; i<cont.length; i++) {
                    formRowModels.append(`
                        <div class="col-lg-4 pt-2 pb-2 pl-2 pr-2" id="fcheck${i}">
                            <div class="boxSha">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="${cont[i]}">
                                    <label class="form-check-label" for="defaultCheck1">TODOS ${cont[i]}</label>
                                </div>
                                <div id="subItem${i}"></div>
                            </div>
                        </div>
                        `);

                    $.each(e.data, function (j, item) {
                        if(cont[i] === item.tipoCorte){
                            $('#subItem'+i+'').append(`
                            <div class="form-check ml-2">
                                <input class="form-check-input" type="checkbox" id="${item.cat_operaciones_id}" name="${item.cat_operaciones_id}" value="${item.cat_operaciones_id}">
                                <label class="form-check-label" id="lb${item.cat_operaciones_id}" for="defaultCheck1">${item.operacion} - ${item.descripcion}</label>
                            </div>
                        `);
                        }
                    });

                    $('#'+cont[i]+'').click(function () {
                        if ($(this).is(':checked')) {
                            $('#subItem'+i+' input[type=checkbox]').prop('checked', true); //solo los del objeto #diasHabilitados
                        } else {
                            $('#subItem'+i+' input[type=checkbox]').prop('checked', false);//solo los del objeto #diasHabilitados
                        }
                    });
                }
            }); //end getJSON
        } // end function getData

        btnNuevaModelo.click(function () {
            wModelosCortesEdit.modal("show");
        });

        wModelosCortesEdit.on('hide.bs.modal', function () {
            _arregloOperacion = {};
            frmModelosCortes.get(0).reset();
            btnGuardarModelosCortes.removeClass("loading");
            frmModelosCortes.removeClass('loading');
        });

        wModelosCortesEdit.on('shown.bs.modal', function () {
            const $head = wModelosCortesEdit.find('.modal-title span');
            if (_arregloOperacion.hasOwnProperty('cat_modelos_cortes_id')) {
                $head.html(_arregloOperacion.descripcion);
            } else {
                $head.html(' Nuevo');
            }
        });


        $wModelosCortesView.on('shown.bs.modal', function () {
            const $head = $wModelosCortesView.find('.modal-title span');
            if($datosModelosver.hasOwnProperty('cat_modelos_cortes_id')){
                $head.html($datosModelosver.descripcion);
            }else {
                $head.html('');
            }
        });

        $wModelosCortesView.on('hide.bs.modal', function () {
            $datosModelosver = {};
            $tblDatos3.dataTable().fnDestroy();
        });

        btnGuardarModelosCortes.click(function () {
            if (btnGuardarModelosCortes.hasClass('loading')) {
                return false;
            }
            btnGuardarModelosCortes.addClass('loading');
            frmModelosCortes.addClass('loading');
            setOperacion();
        });

        function setOperacion() {
            let _id_ = 0;
            if (_arregloOperacion.hasOwnProperty('cat_modelos_cortes_id')) {
                _id_ = _arregloOperacion.cat_modelos_cortes_id;
            }

            let selected = [];
            $('input[type=checkbox]').each(function(){
                if (this.checked) {
                    if($(this).val()!='on'){
                        selected.push($(this).val());
                    }
                }
            });

            $.ajax({
                type: 'post',
                url: '<?php echo site_url("/operaciones/set/modelosCortes")?>',
                data: {name: $("#txtnombreModelo").val(), arr: selected, _id_: _id_ },
                success: function (e) {
                    if (e.length) {
                        if (e.length) {
                            let obj = JSON.parse(e);
                            if (obj.hasOwnProperty('status') && obj.status === "Ok") {
                                frmModelosCortes.get(0).reset();
                                wModelosCortesEdit.modal('hide');
                                swal("Correcto", "Datos se guardados exitosamente", "success");
                                MY.table.ajax.reload();
                            }
                        } else {
                            swal("Error", e, "error");
                            frmModelosCortes.get(0).reset();
                        }
                    }
                },
                error: function (e) {
                    toastr.error("Error al procesar la petición " + e.responseText);
                },
                complete: function () {
                    btnGuardarModelosCortes.removeClass('loading');
                    frmModelosCortes.removeClass('loading');
                }
            });
        }

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
