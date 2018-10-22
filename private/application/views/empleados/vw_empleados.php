<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$data['title'] = ":: RRHH - Plantilla";
$data['css'] = array(
    "jw/jqx.base.css",
    "jw/jqx.espani.css",
    "toastr.min.css",
    "zebra.css"
);

$this->load->view("plantilla/encabezado",$data);
?>

<section class="ml-5 mr-5" id="empleados">
    <div class="row mt-5 mb-5">
        <div class="col text-center text-uppercase">
            <h3 class="txt-Subtitulos"> Administración de Empleados  </h3>
        </div>
    </div>
    <div class="row justify-content-end mb-3">
        <div class="col-1">
            <button type="button" class="btn btn-success" id="btnNuevoEmpleado">Nuevo</button>
        </div>
        <div class="col-1">
            <button type="button" class="btn btn-secondary">Eliminar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="tblDatos"></div>
        </div>
    </div>
</section>

<div class="modal fade" id="wEmpleadoEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                            <img src="" id="imgFoto" class="img-thumbnail">
                        </div>
                    </div>
                    <div class="col-9">
                        <form id="frmPersonal" action="#" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="txtName">Nombre</label>
                                    <input type="text" class="form-control" id="txtName" placeholder="Nombre" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtAPaterno">Apellido Paterno</label>
                                    <input type="text" class="form-control" id="txtAPaterno" placeholder="Apellido Paterno" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtAMaterno">Apellido  Materno</label>
                                    <input type="text" class="form-control" id="txtAMaterno" placeholder="Apellido Materno" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="cmbSexo">Sexo</label>
                                    <select class="form-control" id="cmbSexo" required>
                                        <option value="">Sexo</option>
                                        <option value="F">Femenino</option>
                                        <option value="M">Masculino</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtCURP">CURP</label>
                                    <input type="text" class="form-control" id="" placeholder="CURP" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtRFC">RFC</label>
                                    <input type="text" class="form-control" id="txtRFC" placeholder="RFC" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="txtFchaNac">Fecha Nacimiento</label>
                                    <input type="text" class="form-control" id="txtFchaNac"  required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtEmail">Correo Electronio</label>
                                    <input type="email" class="form-control" id="txtEmail"  required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtFon">Telefono</label>
                                    <input type="text" class="form-control" id="txtFon"  required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="txtNSS">NSS</label>
                                    <input type="text" class="form-control" id="txtNSS" placeholder="NSS" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtCalleNum">Calle / Num</label>
                                    <input type="text" class="form-control" id="txtCalleNum" placeholder="Calle / Num" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtColonia">Colonia</label>
                                    <input type="text" class="form-control" id="txtColonia" placeholder="Colonia" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="cmbEntidad">Estado</label>
                                    <select class="form-control" id="cmbEntidad" required>
                                        <option value="">-Elije-</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbMunicipio">Municipio</label>
                                    <select class="form-control" id="cmbMunicipio" required>
                                        <option value="">-Elije-</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbLocalidad">Localidad</label>
                                    <select class="form-control" id="cmbLocalidad" required>
                                        <option value="">-Elije-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="cmbDep">Departamento</label>
                                    <select class="form-control" id="cmbDep" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbPuesto">Puesto</label>
                                    <select class="form-control" id="cmbPuesto" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cmbFchaIngreso">Fecha Ingreso</label>
                                    <input type="text" class="form-control" id="cmbFchaIngreso"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtImagenUsuario">Imágen</label>
                                <input type="file" accept="image/*"  name="txtImagenUsuario" id="txtImagenUsuario">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnGuardarEmpleado">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (){
        let $tblDatos = $("#tblDatos"),
            $btnNuevoEmpleado = $("#btnNuevoEmpleado"),
            $wEmpleadoEdit = $("#wEmpleadoEdit"),
            $frmPersonal = $('#frmPersonal'),
            $btnGuardarEmpleado = $('#btnGuardarEmpleado'),
            $cmbDep = $('#cmbDep'),
            $cmbPuesto = $('#cmbPuesto'),
            $cmbEntidad = $('#cmbEntidad'),
            _currEmpleado           = {}
        ;

        function cargar_catalogo (url, data) {
            return $.getJSON(url, data, function (e) {
                if(window._debug){
                    console.groupCollapsed('Request');
                    console.log('Catalog URL: ', url);
                    console.log('Catalog Data: ', data);
                    console.log('Catalog returned: ', e);
                    console.groupEnd();
                }
            });
        }

        function show_cat_select ($items, $obj, placeholder) {
            if(typeof $obj !== 'object'){
                return;
            }
            placeholder = placeholder || 'Elige';
            $obj.html('<option value="">'+placeholder+'</option>');
            $.each($items, function (ix, item) {
                let $el = $('<option/>');
                $el.val(item.id).html(item.nombre);
                $obj.append($el);
            });

        }

        function cargar_catalogo_select (url,data, $obj, placeholder) {
            if(typeof $obj !== 'object'){
                return;
            }
            let xhr  = cargar_catalogo(url, data);
            xhr.done(function (e) {
                show_cat_select(e, $obj, placeholder);
            });
            return xhr;
        }

        // cargar catalogos
        cargar_catalogo_select('<?php echo site_url("/empleados/get/catEntidad")?>', {}, $cmbEntidad, 'Estado');
        cargar_catalogo_select('<?php echo site_url("/empleados/get/catDepartamento")?>', {}, $cmbDep, 'Departamento');
        cargar_catalogo_select('<?php echo site_url("/empleados/get/catPuesto")?>', {}, $cmbPuesto, 'Puesto');

        function getEmpleados(){
            let source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'cat_rh_empleado_id', type: 'int' },
                        { name: 'cat_rh_departamento', type: 'int' },
                        { name: 'cat_rh_puesto', type: 'int' },
                        { name: 'apellido_p', type: 'string' },
                        { name: 'apellido_m', type: 'string' },
                        { name: 'nombre', type: 'string' },
                        { name: 'fcha_nac', type: 'date' },
                        { name: 'sexo', type: 'string' },
                        { name: 'rfc', type: 'string' },
                        { name: 'curp', type: 'string' },
                        { name: 'nss', type: 'string' },
                        { name: 'telefono', type: 'string' },
                        { name: 'email', type: 'string' },
                        { name: 'calle_num', type: 'string' },
                        { name: 'colonia', type: 'string' },
                        { name: 'localidad', type: 'string' },
                        { name: 'municipio', type: 'string' },
                        { name: 'entidad', type: 'int' },
                        { name: 'dirC', type: 'string' },
                        { name: 'cat_localidad', type: 'int' },
                        { name: 'cat_municipio', type: 'int' },
                        { name: 'cat_entidad', type: 'int' },
                        { name: 'fcha_ingreso', type: 'date' },
                        { name: 'departamento', type: 'string' },
                        { name: 'puesto', type: 'string' },
                        { name: 'NombreC', type: 'string' }
                    ],
                    url: '<?php echo site_url("/empleados/get/empleados")?>',
                    type: 'post',
                    id: 'cat_rh_empleado_id'
                };
            return new $.jqx.dataAdapter(source);
        } // END getEmpleado

        $tblDatos.jqxGrid({
            width: '100%',
            height: '600px',
            theme : "espani",
            localization : lang_es(),
            sortable: true,
            pageable: true,
            autoheight: true,
            columnsresize: true,
            enabletooltips: true,
            filterable: true,
            showfilterrow: true,
            selectionmode: 'multiplerowsextended',
            columns: [
                { text: 'Nombre', dataField: 'NombreC', width: "22%" },
                { text: 'Fh Nacimiento', dataField: 'fcha_nac',cellsformat: 'dd/MM/yyyy', width: "8%"},
                { text: 'Sexo', dataField: 'sexo', width: "3%" },
                { text: 'NSS', dataField: 'nss', width: "9%"  },
                { text: 'CURP', dataField: 'curp', width: "15%"},
                { text: 'RFC', dataField: 'rfc', width: "10%" },
                { text: 'Domicilio', dataField: 'dirC', width: "30%"  },
                { text: 'Departamento', dataField: 'departamento', filtertype: 'checkedlist', width: "10%"},
                { text: 'Puesto', dataField: 'puesto', filtertype: 'checkedlist', width: "10%"}
            ],
            source : getEmpleados()
        });
            // .on('rowdoubleclick',function(e){
            //     _currEmpleado = e.args.row.bounddata;
            //     _currEmpleado._currRow = e.args.row;
            //
            //     $frmPersonal.form('set values', {
            //         txtapaterno: _currEmpleado.paterno,
            //         txtamaterno: _currEmpleado.materno,
            //         txtnombre        : _currEmpleado.nombre,
            //         cmbSexo          : _currEmpleado.sexo,
            //         cmbPerfil        : _currEmpleado.idPerfil,
            //         cmbJuris         : _currEmpleado.idJuris,
            //         txtUsuario       : _currEmpleado.usuario
            //     });
            //     $txtFhNacimiento.data('Zebra_DatePicker').set_date(_currEmpleado.fhNacimiento);
            //
            //     $wPersonalEdit.modal('show');
            // }); //end

        $btnNuevoEmpleado.click(function(){
            $wEmpleadoEdit.modal("show");
        });

        $wEmpleadoEdit.on('hide.bs.modal', function () {
            _currEmpleado = {};
            $frmPersonal.get(0).reset();
            $btnGuardarEmpleado.removeClass("loading");
            $frmPersonal.removeClass('loading');
        });

        $wEmpleadoEdit.on('shown.bs.modal', function() {
            const $head = $wEmpleadoEdit.find('.modal-title span');
            if(_currEmpleado.hasOwnProperty('cat_rh_empleado_id')){
                $head.html(' - ' + _currEmpleado.cat_rh_empleado_id) ;
            }else{
                $head.html(' - Nuevo');
            }
        });


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
$this->load->view("plantilla/pie",$data);
?>
