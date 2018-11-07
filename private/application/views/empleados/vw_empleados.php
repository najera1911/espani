<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$data['title'] = ":: RRHH - Plantilla";
$data['css'] = array(
    "toastr.min.css",
    "zebra.css",
    "../datatables/datatables.min.css"
);

$this->load->view("plantilla/encabezado", $data);
?>

<section class="ml-5 mr-5" id="empleados">
    <div class="row mt-3 mb-3">
        <div class="col text-center text-uppercase">
            <h3 class="txt-Subtitulos"> Administración de Empleados </h3>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <button type="button" class="btn btn-warning btn-circle float-right ml-2" id="btnExportExcel"><i
                        class="fas fa-file-excel"></i></button>
            <button type="button" class="btn btn-success float-right" id="btnNuevoEmpleado">Nuevo</button>
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

<div class="modal fade" id="wEmpleadoEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-fluid modal-full-height modal-top modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Empleados - Datos Generales <span></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="row">
                    <div class="col-3">
                        <div class="row">
                            <img src="" id="imgFoto" class="img-thumbnail" style="height: 250px;">
                        </div>
                    </div>
                    <div class="col-9">
                        <form id="frmPersonal" role="form" autocomplete="off">
                            <div class="form-row">
                                <div class="form-group col-lg-4">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control text-uppercase" id="txtName" name="txtName" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="txtAPaterno">Apellido Paterno</label>
                                    <input type="text" class="form-control text-uppercase" id="txtAPaterno" name="txtAPaterno"
                                           required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="txtAMaterno">Apellido Materno</label>
                                    <input type="text" class="form-control text-uppercase" id="txtAMaterno" name="txtAMaterno"
                                           required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-4">
                                    <label for="txtCURP">CURP</label>
                                    <input type="text" class="form-control text-uppercase" id="txtCURP" name="txtCURP" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="txtRFC">RFC</label>
                                    <input type="text" class="form-control text-uppercase" id="txtRFC" name="txtRFC" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="cmbSexo">Sexo</label>
                                    <select class="form-control custom-select" id="cmbSexo" name="cmbSexo" required>
                                        <option value="">Sexo</option>
                                        <option value="M">MUJER</option>
                                        <option value="H">HOMBRE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-4">
                                    <label for="txtFchaNac">Fecha Nacimiento</label>
                                    <input type="text" class="form-control" id="txtFchaNac" name="txtFchaNac" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="txtEmail">Correo Electronio</label>
                                    <input type="email" class="form-control" id="txtEmail" name="txtEmail" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="txtFon">Telefono</label>
                                    <input type="text" class="form-control" id="txtFon" name="txtFon" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-4">
                                    <label for="txtNSS">NSS</label>
                                    <input type="text" class="form-control" id="txtNSS" name="txtNSS" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="txtCalleNum">Calle / Num</label>
                                    <input type="text" class="form-control text-uppercase" id="txtCalleNum" name="txtCalleNum"
                                           required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="txtColonia">Colonia</label>
                                    <input type="text" class="form-control text-uppercase" id="txtColonia" name="txtColonia" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-4">
                                    <label for="cmbEntidad custom-select">Estado</label>
                                    <select class="form-control" id="cmbEntidad" name="cmbEntidad" required>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="cmbMunicipio">Municipio</label>
                                    <select class="form-control" id="cmbMunicipio" name="cmbMunicipio" required>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="cmbLocalidad">Localidad</label>
                                    <select class="form-control" id="cmbLocalidad" name="cmbLocalidad" required>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-4">
                                    <label for="cmbDep">Departamento</label>
                                    <select class="form-control" id="cmbDep" name="cmbDep" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbPuesto">Puesto</label>
                                    <select class="form-control" id="cmbPuesto" name="cmbPuesto" required>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="txtFchaIngreso">Fecha Ingreso</label>
                                    <input type="text" class="form-control" id="txtFchaIngreso" name="txtFchaIngreso"
                                           required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtImagenUsuario">Imágen</label>
                                <input type="file" accept="image/*" name="txtImagenUsuario" id="txtImagenUsuario">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success" id="btnGuardarEmpleado">Guardar</button>
            </div>
        </div>
    </div>
</div>


<script>
    let MY = {
    };

    $(document).ready(function () {
        let $tblDatos2 = $("#tblDatos2"),
            $btnNuevoEmpleado = $("#btnNuevoEmpleado"),
            $wEmpleadoEdit = $("#wEmpleadoEdit"),
            $frmPersonal = $('#frmPersonal'),
            $btnGuardarEmpleado = $('#btnGuardarEmpleado'),
            $cmbDep = $('#cmbDep'),
            $cmbPuesto = $('#cmbPuesto'),
            $cmbEntidad = $('#cmbEntidad'),
            $cmbMunicipio = $('#cmbMunicipio'),
            $cmbLocalidad = $('#cmbLocalidad'),
            $imgFoto = $("#imgFoto"),
            $txtImagenUsuario = $("#txtImagenUsuario"),
            $txtFchaNac = $("#txtFchaNac"),
            $txtFchaIngreso = $("#txtFchaIngreso"),
            $txtCURP                = $("#txtCURP"),
            $txtRFC                 = $("#txtRFC"),
            _currEmpleado = {}
        ;

        $txtFchaNac.Zebra_DatePicker({
            show_icon: true
        });

        $txtFchaIngreso.Zebra_DatePicker({
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

        // cargar catalogos
        cargar_catalogo_select('<?php echo site_url("/empleados/get/catEntidad")?>', {}, $cmbEntidad, 'Estado');
        cargar_catalogo_select('<?php echo site_url("/empleados/get/catDepartamento")?>', {}, $cmbDep, 'Departamento');
        cargar_catalogo_select('<?php echo site_url("/empleados/get/catPuesto")?>', {}, $cmbPuesto, 'Puesto');

        $cmbEntidad.change(function () {
            $cmbMunicipio.html('');
            $cmbLocalidad.html('');
            cargar_catalogo_select('<?php echo site_url("/empleados/get/catMunicipio")?>', {cat_estado_id: $cmbEntidad.val()}, $cmbMunicipio, 'Municipio');
        });

        $cmbMunicipio.change(function () {
            $cmbLocalidad.html('');
            cargar_catalogo_select('<?php echo site_url("/empleados/get/catLocalidad")?>', {
                cat_estado_id: $cmbEntidad.val(),
                cat_municipio: $cmbMunicipio.val()
            }, $cmbLocalidad, 'Localidad');
        });

        getEmpleados2();

        function getEmpleados2() {
            MY.table = $tblDatos2.DataTable( {
                processing: true,
                serverSide: true,
                ordering: true,
                info: false,
                ajax: {
                    "url": "<?php echo site_url('/empleados/get/empleados')?>",
                    "type": "POST"
                    },
                columns: [
                    { "title": "Nombre", "data":"NombreC" },
                    { "title": "Fecha Nacim", "data": "fcha_nac",
                        render: function(data, type, row){
                            if(type === "sort" || type === "type"){
                                return data;
                            }
                            return moment(data).format("DD-MM-YYYY");
                        }
                    },
                    { "title": "Sexo", "data":"sexo" },
                    { "title": "NSS", "data": "nss" },
                    { "title": "CURP", "data":"curp" },
                    { "title": "RFC", "data": "rfc" },
                    { "title": "Dirección", "data": "dirC" },
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
            } );
        }

        $("#tblDatos2 tbody").on('click','td .btn-success',function(){
            let data = MY.table.rows($(this).closest("tr")).data();
            _currEmpleado = data[0];

            $('input[name="txtName"]').val(_currEmpleado.nombre);
            $('input[name="txtAPaterno"]').val(_currEmpleado.apellido_p);
            $('input[name="txtAMaterno"]').val(_currEmpleado.apellido_m);
            $('select[name="cmbSexo"]').val(_currEmpleado.sexo);
            $('input[name="txtCURP"]').val(_currEmpleado.curp);
            $('input[name="txtRFC"]').val(_currEmpleado.rfc);
            $('input[name="txtEmail"]').val(_currEmpleado.email);
            $('input[name="txtFon"]').val(_currEmpleado.telefono);
            $('input[name="txtNSS"]').val(_currEmpleado.nss);
            $('input[name="txtCalleNum"]').val(_currEmpleado.calle_num);
            $('input[name="txtColonia"]').val(_currEmpleado.colonia);
            $('select[name="cmbEntidad"]').val(_currEmpleado.cat_entidad).change();

            setTimeout(function () {
                $('select[name="cmbMunicipio"]').val(_currEmpleado.cat_municipio).change();
            }, 100);

            setTimeout(function () {
                $('select[name="cmbLocalidad"]').val(_currEmpleado.cat_localidad).change();
            }, 200);

            $('select[name="cmbDep"]').val(_currEmpleado.cat_rh_departamento);
            $('select[name="cmbPuesto"]').val(_currEmpleado.cat_rh_puesto);

            $txtFchaNac.data('Zebra_DatePicker').set_date(new Date(_currEmpleado.fcha_nac));
            $txtFchaIngreso.data('Zebra_DatePicker').set_date(new Date(_currEmpleado.fcha_ingreso));

            $wEmpleadoEdit.modal('show');
        });

        $("#tblDatos2 tbody").on('click','td .btn-warning',function(){
            let data = MY.table.rows($(this).closest("tr")).data();
            data = data[0];
            PersonalDelete(data);
        });

             let photorenderer = function (row, column, value) {
                let id = $tblDatos.jqxGrid('getrowdata', row).cat_rh_empleado_id;
                let imgurl = '<?php echo base_url("empleados/get/foto?csid=")?>' + id;
                let img = '<div style="background: white;"><img style="margin:2px; margin-left: 10px;" width="32" height="32" src="' + imgurl + '"></div>';
                return img;
            };

            $btnGuardarEmpleado.click(function () {

                if ($btnGuardarEmpleado.hasClass('loading')) {
                    return false;
                }

                // if($frmPersonal.form('is valid')){
                $btnGuardarEmpleado.addClass('loading');
                $frmPersonal.addClass('loading');
                setEmpleado();
                // }else{
                //     $frmPersonal.submit();
                // }
            });

            $txtImagenUsuario.change(function () {
                let el = $(this).get(0);
                let file = el.files[0];

                if (typeof FileReader !== 'undefined' && (/image/i).test(file.type)) {
                    let reader = new FileReader();
                    let img = '';
                    reader.onload = (function (e) {
                        return function (e) {
                            let src = e.target.result;
                            $imgFoto.attr('src', src);
                        };
                    })(img);
                    reader.readAsDataURL(file);
                }
            });

            function setEmpleado() {

                let data = new FormData($frmPersonal.get(0));

                let limit = 5;
                let allowedTypes = ['JPG', 'JPEG', 'GIF', 'PNG'];

                let file = $txtImagenUsuario.get(0);
                if (file.files.length) {
                    file = file.files[0];
                    let format = (file.type.split('/'));
                    format = format[1].toUpperCase();

                    if (!(allowedTypes.indexOf(format) >= 0 && file.size < (limit * 1024 * 1024))) {
                        toastr.error("La imagen no tiene el formato o pesa más de " + limit + "Mb");
                        $btnGuardarEmpleado.removeClass("loading");
                        $frmPersonal.removeClass('loading');
                        return false;
                    }

                }

                if (_currEmpleado.hasOwnProperty('cat_rh_empleado_id')) {
                    data.append('_id_', _currEmpleado.cat_rh_empleado_id);
                }

                $.ajax({
                    type: 'post',
                    url: '<?php echo site_url("/empleados/set/empleado")?>',
                    xhr: function () {  // Custom XMLHttpRequest
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) { // Check if upload property exists
                            myXhr.upload.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
    //                                console.log(e);
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
                            if (e.length) {
                                let obj = JSON.parse(e);
                                if (obj.hasOwnProperty('status') && obj.status === "Ok") {
                                    $frmPersonal.get(0).reset();
                                    $wEmpleadoEdit.modal('hide');
                                    swal("Correcto", "Datos de empleado guardados, No. Empleado:" + (obj.numEmpleado || "??"), "success");
                                    MY.table.ajax.reload();
                                }
                            } else {
                                swal("Error", e , "error");
                                $frmPersonal.get(0).reset();
                            }
                        }
                    },
                    error: function (e) {
                        toastr.error("Error al procesar la petición " + e.responseText);
                    },
                    complete: function () {
                        $btnGuardarEmpleado.removeClass('loading');
                        $frmPersonal.removeClass('loading');
                    }
                });
            }


            $btnNuevoEmpleado.click(function () {
                $wEmpleadoEdit.modal("show");
            });


            $wEmpleadoEdit.on('hide.bs.modal', function () {
                _currEmpleado = {};
                $frmPersonal.get(0).reset();
                $btnGuardarEmpleado.removeClass("loading");
                $frmPersonal.removeClass('loading');
            });

            $wEmpleadoEdit.on('shown.bs.modal', function () {
                const $head = $wEmpleadoEdit.find('.modal-title span');
                if (_currEmpleado.hasOwnProperty('cat_rh_empleado_id')) {
                    $head.html(' - ' + _currEmpleado.cat_rh_empleado_id);
                    $imgFoto.attr('src', '<?php echo base_url("empleados/get/foto?csid=")?>' + _currEmpleado.cat_rh_empleado_id);
                } else {
                    $head.html(' - Nuevo');
                    $imgFoto.attr('src', '<?php echo base_url("assets/img/users/empty.jpg")?>');
                }
            });

            let $ms='';

            $txtCURP.on('keyup', function (e) {
                $txtCURP.val($txtCURP.val().toUpperCase());
                $('select[name="cmbSexo"]').val($txtCURP.val().substr(10,1));
                $ms = $txtCURP.val().substr(4,2) + '-'+ $txtCURP.val().substr(6,2) +'-' +$txtCURP.val().substr(8,2) ;
                $ms = Date.parse($ms);
                let $fecha = new Date($ms);
                $txtFchaNac.data('Zebra_DatePicker').set_date($fecha);
                $txtRFC.val($txtCURP.val().substr(0,10));
            });

            function isIE() {
                var ua   = window.navigator.userAgent;
                var msie = ua.indexOf('MSIE ') > 0;
                var ie11 = ua.indexOf('Trident/') > 0;
                var ie12 = ua.indexOf('Edge/') > 0;
                return msie || ie11 || ie12;
            }

            function PersonalDelete(data){
                swal({
                        title: "Eliminar Empleado",
                        text: "Desea eliminar a: "+ data.NombreC +"",
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
                            swal({
                                title: "",
                                text: "Ingrese fecha de fin de contrato",
                                type: "input",
                                inputType: "date",
                                showCancelButton: true,
                                closeOnConfirm: false
                            }, function(inputValue) {
                                if (inputValue === false) return false;
                                if (inputValue === "") {
                                    swal.showInputError("Ingrese fecha");
                                    return false
                                }

                                $.ajax({
                                    url: '<?php echo base_url("empleados/set/deleteUsuario")?>',
                                    type: "POST",
                                    data: {datos: data.cat_rh_empleado_id, txtFhBjaja: inputValue },
                                    dataType: "html",
                                    success: function (e) {
                                        if (e === 'OK') {
                                            swal("Bien", "El empleado se ha eliminado correctamente", "success");
                                        }
                                        MY.table.ajax.reload();
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        swal("Error deleting!", "Please try again", "error");
                                    }
                                });

                            });
                        } else {
                            swal("Cancelado", data.NombreC + " no se elimino", "error");
                        }
                    });
            }

        });  //end document ready
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
