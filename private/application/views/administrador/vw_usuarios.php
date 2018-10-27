<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$data['title'] = ":: Usuarios";
$data['css'] = array(
    "jw/jqx.base.css",
    "jw/jqx.espani.css",
    "toastr.min.css",
    "zebra.css",
);

$this->load->view("plantilla/encabezado", $data);
?>

<section class="ml-5 mr-5" id="Usuarios">
    <div class="row mt-5 mb-5">
        <div class="col text-center text-uppercase">
            <h3 class="txt-Subtitulos"> Administración de Usuarios</h3>
        </div>
    </div>
    <div class="row justify-content-center mb-3">
        <div class="col-8">
            <button type="button" class="btn btn-warning btn-circle float-right ml-2" id="btnExportExcel"><i
                        class="fas fa-file-excel"></i></button>
            <button type="button" class="btn btn-secondary float-right ml-2" id="btndelete">Eliminar</button>
            <button type="button" class="btn btn-success float-right" id="btnNuevoUsuario">Nuevo</button>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-8">
            <div id="tblDatos"></div>
        </div>
    </div>
</section>

<div class="modal fade" id="wUsuariosEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-fluid modal-full-height modal-top modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Usuarios <span></span> - Datos Generales </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="row">
                    <div class="col-12">
                        <form id="frmUsuario" role="form" autocomplete="off">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="txtName">Nombre</label>
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
                                    <label for="cmbSexo">Sexo</label>
                                    <select class="form-control custom-select" id="cmbSexo" name="cmbSexo" required>
                                        <option value="">Sexo</option>
                                        <option value="M">MUJER</option>
                                        <option value="H">HOMBRE</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtUser">Usuario</label>
                                    <input type="text" class="form-control" id="txtUser" name="txtUser"
                                           required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtPass">Contraseña</label>
                                    <input type="text" class="form-control" id="txtPass" name="txtPass"
                                           required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="cmbPerfil">Perfil</label>
                                    <select class="form-control" id="cmbPerfil" name="cmbPerfil" required>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success" id="btnGuardarUsuario">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (){
        let $btnNuevoUsuario = $("#btnNuevoUsuario"),
            $btndelete = $("#btndelete"),
            $btnExportExcel = $("#btnExportExcel"),
            $tblDatos =$("#tblDatos"),
            $wUsuariosEdit = $("#wUsuariosEdit"),
            $frmUsuario = $("#frmUsuario"),
            $btnGuardarUsuario = $("#btnGuardarUsuario"),
            $cmbPerfil = $("#cmbPerfil"),
            _gridState = null,
            _currEmpleado = {}
            ;

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
        cargar_catalogo_select('<?php echo site_url("/administrador/get/catPerfil")?>', {}, $cmbPerfil, 'Perfil');

        $btnNuevoUsuario.click(function () {
            $wUsuariosEdit.modal("show");
        });

        $wUsuariosEdit.on('hide.bs.modal', function () {
            _currEmpleado = {};
            $frmUsuario.get(0).reset();
            $btnGuardarUsuario.removeClass("loading");
            $frmUsuario.removeClass('loading');
        });

        $wUsuariosEdit.on('shown.bs.modal', function () {
            const $head = $wUsuariosEdit.find('.modal-title span');
            if (_currEmpleado.hasOwnProperty('cat_usuario_id')) {
                $head.html(' ' + _currEmpleado.nombre);
            } else {
                $head.html(' Nuevo');
            }
        });

        function getUser() {
            let source =
                {
                    datatype: "json",
                    datafields: [
                        {name: 'cat_usuario_id', type: 'int'},
                        {name: 'cat_perfil_id', type: 'int'},
                        {name: 'apellido_p', type: 'string'},
                        {name: 'apellido_m', type: 'string'},
                        {name: 'nombre', type: 'string'},
                        {name: 'sexo', type: 'string'},
                        {name: 'usuario', type: 'string'},
                        {name: 'descripcion', type: 'string'},
                        {name: 'nombreC', type: 'string'}
                    ],
                    url: '<?php echo site_url("/administrador/get/user")?>',
                    type: 'post',
                    id: 'cat_usuario_id'
                };
            return new $.jqx.dataAdapter(source);
        } // END getUser

        $tblDatos.jqxGrid({
            width: '100%',
            height: 300,
            theme: "espani",
            localization: lang_es(),
            sortable: true,
            pageable: true,
            columnsresize: true,
            enabletooltips: true,
            filterable: true,
            showfilterrow: true,
            selectionmode: 'multiplerowsextended',
            columns: [
                {text: 'Nombre', dataField: 'nombreC', width: "40%"},
                {text: 'Sexo', dataField: 'sexo', width: "20%"},
                {text: 'Usuario', dataField: 'usuario', width: "20%"},
                {text: 'Perfil', dataField: 'descripcion', filtertype: 'checkedlist', width: "20%"}
            ],
            source: getUser()
        }).on('rowdoubleclick', function (e) {
            _currEmpleado = e.args.row.bounddata;
            _currEmpleado._currRow = e.args.row;

            $('input[name="txtName"]').val(_currEmpleado.nombre);
            $('input[name="txtAPaterno"]').val(_currEmpleado.apellido_p);
            $('input[name="txtAMaterno"]').val(_currEmpleado.apellido_m);
            $('select[name="cmbSexo"]').val(_currEmpleado.sexo);
            $('input[name="txtUser"]').val(_currEmpleado.usuario);
            $('input[name="txtPass"]').val("");
            $('input[name="cmbPerfil"]').val(_currEmpleado.cat_perfil_id).change();

            $wUsuariosEdit.modal('show');
        }); //end

        $btnGuardarUsuario.click(function () {

            if ($btnGuardarUsuario.hasClass('loading')) {
                return false;
            }

            $btnGuardarUsuario.addClass('loading');
            $frmUsuario.addClass('loading');
            setUsuario();
        });

        function setUsuario() {

            let data = new FormData($frmUsuario.get(0));

            if (_currEmpleado.hasOwnProperty('cat_usuario_id')) {
                data.append('_id_', _currEmpleado.cat_usuario_id);
            }

            _gridState = $tblDatos.jqxGrid('savestate');

            $.ajax({
                type: 'post',
                url: '<?php echo site_url("/administrador/set/usuario")?>',
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
                                $frmUsuario.get(0).reset();
                                $wUsuariosEdit.modal('hide');
                                swal("Correcto", "Usuario guardado Exitosamente", "success");
                                $tblDatos.jqxGrid({source: getUser()});
                            }
                        } else {
                            toastr.info(e);
                            swal("Error", e , "error");
                            $frmUsuario.get(0).reset();
                        }
                    }
                },
                error: function (e) {
                    toastr.error("Error al procesar la petición " + e.responseText);
                },
                complete: function () {
                    $btnGuardarUsuario.removeClass('loading');
                    $frmUsuario.removeClass('loading');
                }
            });
        }

        function isIE() {
            var ua   = window.navigator.userAgent;
            var msie = ua.indexOf('MSIE ') > 0;
            var ie11 = ua.indexOf('Trident/') > 0;
            var ie12 = ua.indexOf('Edge/') > 0;
            return msie || ie11 || ie12;
        }

        function exportarExcel(nombre, strData) {
            nombre = nombre || 'PV-DATA';

            const contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            const extension   = ".xls";

            const blob = new Blob([strData], {
                type: contentType
            });

            let nombreArchivo = nombre  + extension;
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

        function PersonalDelete(data){
            swal({
                    title: "Eliminar un usuario",
                    text: "Desea eliminar a: "+ data.nombreC +"",
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
                            url: '<?php echo base_url("administrador/set/deleteUsuario")?>',
                            type: "POST",
                            data: {datos: data.cat_usuario_id},
                            dataType: "html",
                            success: function (e) {
                                if (e === 'OK') {
                                    swal("Bien", "El usuario se ha eliminado correctamente", "success");
                                    $tblDatos.jqxGrid({source: getUser()});
                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                swal("Error", "Error al eliminar usuario", "error");
                            }
                        });
                    } else {
                        swal("Cancelado", data.nombreC + " no se elimino", "error");
                    }
                });
        }

        $btndelete.click(function (e) {
            e.preventDefault();
            let data = $tblDatos.jqxGrid('getrowdata', $tblDatos.jqxGrid('getselectedrowindex'));
            if (data) {
                //obtiene00 los datos seleccionados
                let ids = $tblDatos.jqxGrid('getselectedrowindexes');
                let datos = [];

                if(ids.length == 1) {
                    PersonalDelete(data);
                } else if (ids.length < 1) {
                    toastr.error('Seleccione a un empleado', {timeOut: 0});
                } else {
                    toastr.error('Seleccione solo a un Empleado', {timeOut: 0});
                }
            }else{
                toastr.error('Seleccione a un empleado', {timeOut: 0});
            }
        });

        $btnExportExcel.click(function () {
            let data = $tblDatos.jqxGrid("exportdata",'xls');
            if(data){
                exportarExcel("usuarios",data);
            }
        });

    }); // end document ready
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
