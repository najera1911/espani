<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$data['title'] = ":: RRHH - Plantilla";
$data['css'] = array(
    "jw/jqx.base.css",
    "jw/jqx.espani.css",
    "toastr.min.css",
    "zebra.css"
);

$this->load->view("plantilla/encabezado", $data);
?>

<section class="ml-5 mr-5" id="empleados">
    <div class="row mt-5 mb-5">
        <div class="col text-center text-uppercase">
            <h3 class="txt-Subtitulos"> Administración de Empleados </h3>
        </div>
    </div>
    <div class="row justify-content-end mb-3">
        <div class="col-1">
            <button type="button" class="btn btn-success" id="btnNuevoEmpleado">Nuevo</button>
        </div>
        <div class="col-1">
            <button type="button" class="btn btn-secondary" id="btndelete">Eliminar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="tblDatos"></div>
        </div>
    </div>
</section>

<div class="modal fade" id="wEmpleadoEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-fluid modal-full-height modal-top modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Usuarios - Datos Generales <span></span></h4>
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
                                <div class="form-group col-md-4">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control text-uppercase" id="txtName" name="txtName" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtAPaterno">Apellido Paterno</label>
                                    <input type="text" class="form-control text-uppercase" id="txtAPaterno" name="txtAPaterno"
                                           required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtAMaterno">Apellido Materno</label>
                                    <input type="text" class="form-control text-uppercase" id="txtAMaterno" name="txtAMaterno"
                                           required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="txtCURP">CURP</label>
                                    <input type="text" class="form-control text-uppercase" id="txtCURP" name="txtCURP" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtRFC">RFC</label>
                                    <input type="text" class="form-control text-uppercase" id="txtRFC" name="txtRFC" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbSexo">Sexo</label>
                                    <select class="form-control custom-select" id="cmbSexo" name="cmbSexo" required>
                                        <option value="">Sexo</option>
                                        <option value="M">MUJER</option>
                                        <option value="H">HOMBRE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="txtFchaNac">Fecha Nacimiento</label>
                                    <input type="text" class="form-control" id="txtFchaNac" name="txtFchaNac" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtEmail">Correo Electronio</label>
                                    <input type="email" class="form-control" id="txtEmail" name="txtEmail" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtFon">Telefono</label>
                                    <input type="text" class="form-control" id="txtFon" name="txtFon" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="txtNSS">NSS</label>
                                    <input type="text" class="form-control" id="txtNSS" name="txtNSS" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtCalleNum">Calle / Num</label>
                                    <input type="text" class="form-control text-uppercase" id="txtCalleNum" name="txtCalleNum"
                                           required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtColonia">Colonia</label>
                                    <input type="text" class="form-control text-uppercase" id="txtColonia" name="txtColonia" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="cmbEntidad custom-select">Estado</label>
                                    <select class="form-control" id="cmbEntidad" name="cmbEntidad" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbMunicipio">Municipio</label>
                                    <select class="form-control" id="cmbMunicipio" name="cmbMunicipio" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbLocalidad">Localidad</label>
                                    <select class="form-control" id="cmbLocalidad" name="cmbLocalidad" required>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="cmbDep">Departamento</label>
                                    <select class="form-control" id="cmbDep" name="cmbDep" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbPuesto">Puesto</label>
                                    <select class="form-control" id="cmbPuesto" name="cmbPuesto" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtFchaIngreso">Fecha Ingreso</label>
                                    <input type="txt" class="form-control" id="txtFchaIngreso" name="txtFchaIngreso"
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
    $(document).ready(function () {
        let $tblDatos = $("#tblDatos"),
            $btnNuevoEmpleado = $("#btnNuevoEmpleado"),
            $btndelete              =  $("#btndelete"),
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
            _gridState = null,
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

        function getEmpleados() {
            let source =
                {
                    datatype: "json",
                    datafields: [
                        {name: 'cat_rh_empleado_id', type: 'int'},
                        {name: 'cat_rh_departamento', type: 'int'},
                        {name: 'cat_rh_puesto', type: 'int'},
                        {name: 'apellido_p', type: 'string'},
                        {name: 'apellido_m', type: 'string'},
                        {name: 'nombre', type: 'string'},
                        {name: 'fcha_nac', type: 'date'},
                        {name: 'sexo', type: 'string'},
                        {name: 'rfc', type: 'string'},
                        {name: 'curp', type: 'string'},
                        {name: 'nss', type: 'string'},
                        {name: 'telefono', type: 'string'},
                        {name: 'email', type: 'string'},
                        {name: 'calle_num', type: 'string'},
                        {name: 'colonia', type: 'string'},
                        {name: 'localidad', type: 'string'},
                        {name: 'municipio', type: 'string'},
                        {name: 'entidad', type: 'int'},
                        {name: 'dirC', type: 'string'},
                        {name: 'cat_localidad', type: 'int'},
                        {name: 'cat_municipio', type: 'int'},
                        {name: 'cat_entidad', type: 'int'},
                        {name: 'fcha_ingreso', type: 'date'},
                        {name: 'departamento', type: 'string'},
                        {name: 'puesto', type: 'string'},
                        {name: 'NombreC', type: 'string'}
                    ],
                    url: '<?php echo site_url("/empleados/get/empleados")?>',
                    type: 'post',
                    id: 'cat_rh_empleado_id'
                };
            return new $.jqx.dataAdapter(source);
        } // END getEmpleado

        let photorenderer = function (row, column, value) {
            let id = $tblDatos.jqxGrid('getrowdata', row).cat_rh_empleado_id;
            let imgurl = '<?php echo base_url("empleados/get/foto?csid=")?>' + id;
            let img = '<div style="background: white;"><img style="margin:2px; margin-left: 10px;" width="32" height="32" src="' + imgurl + '"></div>';
            return img;
        };

        $tblDatos.jqxGrid({
            width: '100%',
            height: '600px',
            theme: "espani",
            localization: lang_es(),
            sortable: true,
            pageable: true,
            autoheight: true,
            columnsresize: true,
            enabletooltips: true,
            filterable: true,
            showfilterrow: true,
            selectionmode: 'multiplerowsextended',
            columns: [
                { text: 'Image', width: 60, cellsrenderer: photorenderer },
                {text: 'Nombre', dataField: 'NombreC', width: "22%"},
                {text: 'Fh Nacimiento', dataField: 'fcha_nac', cellsformat: 'dd/MM/yyyy', width: "8%"},
                {text: 'Sexo', dataField: 'sexo', width: "3%"},
                {text: 'NSS', dataField: 'nss', width: "9%"},
                {text: 'CURP', dataField: 'curp', width: "15%"},
                {text: 'RFC', dataField: 'rfc', width: "10%"},
                {text: 'Domicilio', dataField: 'dirC', width: "30%"},
                {text: 'Departamento', dataField: 'departamento', filtertype: 'checkedlist', width: "10%"},
                {text: 'Puesto', dataField: 'puesto', filtertype: 'checkedlist', width: "10%"}
            ],
            source: getEmpleados()
        }).on('rowdoubleclick', function (e) {
            _currEmpleado = e.args.row.bounddata;
            _currEmpleado._currRow = e.args.row;


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
            $txtFchaNac.data('Zebra_DatePicker').set_date(_currEmpleado.fcha_nac);
            $txtFchaIngreso.data('Zebra_DatePicker').set_date(_currEmpleado.fcha_ingreso);

            $wEmpleadoEdit.modal('show');
        }); //end

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


            _gridState = $tblDatos.jqxGrid('savestate');

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
                                toastr.success("Datos de empleado guardados. <br> No. Empleado: " + (obj.numEmpleado || '??'));
                                $tblDatos.jqxGrid({source: getEmpleados()});

                            }
                        } else {
                            toastr.info(e);
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

        function exportarExcel(nombre, strData) {
            nombre = nombre || 'PV-DATA';

            var contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            var extension   = ".xls";

            var blob = new Blob([strData], {
                type: contentType
            });

            var nombreArchivo = nombre  + extension;
            if (isIE()) {
                window.navigator.msSaveOrOpenBlob(blob, nombreArchivo);
            } else {
                var link      = document.createElement("a");
                link.href     = window.URL.createObjectURL(blob);
                link.style    = "visibility:hidden";
                link.download = nombreArchivo;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        $btndelete.click(function (e) {
            e.preventDefault();
            let data = $tblDatos.jqxGrid('getrowdata', $tblDatos.jqxGrid('getselectedrowindex'));
            if (data) {
                //obtiene00 los datos seleccionados
                let ids = $tblDatos.jqxGrid('getselectedrowindexes');
                let datos = [];

                if(ids.length == 1) {
                    $wPersonalDelete.modal({
                        closable : false,
                        onDeny   : function () {
                            return true;
                        },
                        onApprove: function () {
                            PersonalDelete();
                        }
                    }).modal('show');
                } else if (ids.length < 1) {
                    toastr.error('Seleccione a un empleado', {timeOut: 0});
                } else {
                    toastr.error('Seleccione solo a un Empleado', {timeOut: 0});
                }
            }else{
                toastr.error('Seleccione a un empleado', {timeOut: 0});
            }
        });

//         $btnExportar.click(function () {
//             let data = $tblDatos.jqxGrid("exportdata",'xls');
// //                console.log(data);
//             if(data){
//                 exportarExcel("Plantilla",data);
//             }
//         });


    });  //end document ready
</script>
<?php
$data['scripts'] = array(
    "jqw/jqxcore.js",
    "jqw/jqxdata.js",
    "jqw/jqxcheckbox.js",
    "jqw/jqxbuttons.js",
    "jqw/jqxscrollbar.js",
    "jqw/jqxmenu.js",
    "jqw/jqxlistbox.js",
    "jqw/jqxdropdownlist.js",
    "jqw/jqxgrid.js",
    "jqw/jqxgrid.pager.js",
    "jqw/jqxgrid.columnsresize.js",
    "jqw/jqxdata.export.js",
    "jqw/jqxgrid.export.js",
    "jqw/jqxgrid.grouping.js",
    "jqw/jqxgrid.selection.js",
    "jqw/jqxgrid.sort.js",
    "jqw/jqxgrid.filter.js",
    "jqw/jqxgrid.storage.js",
    "jqw/jqxpanel.js",
    "jqw/localized-es.js",
    "toastr.min.js",
    "zebra_datepicker.src.js"

);
$this->load->view("plantilla/pie", $data);
?>
