<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Recibos de Pago";
$data['css'] = array(
    "toastr.min.css",
    "zebra.css",
    "../select2/css/select2.min.css"
);
$this->load->view("plantilla/encabezado", $data);
?>
<section class="ml-5 mr-5" id="Operaciones">
    <div class="row mt-5 mb-5">
        <div class="col text-center text-uppercase">
            <h3 class="txt-Subtitulos">Generar Recibos de Pago</h3>
        </div>
    </div>
    <div class="row mb-3 justify-content-center">
        <div class="form-group col-md-3 col-6 text-uppercase">
            <label for="cmbFchaInicio">Fecha Reporte</label>
            <select class="form-control js-example-basic-single" id="cmbFchaInicio" name="cmbFchaInicio" required></select>
        </div>
        <div class="form-group col-md-3 col-12">
            <label for="cmbPiso">Piso</label>
            <select class="form-control js-example-basic-single" id="cmbPiso" name="cmbPiso" required></select>
        </div>
        <div class="form-group col-md-3 col-6 text-uppercase">
            <br>
            <button type="button" class="btn btn-secondary pl-2" id="buscarReporte"><i class="fas fa-search"></i>  Generar</button>
        </div>
    </div>
</section>

<script>
    let MY = {};

    $(document).ready(function (){

        let cmbFchaInicio = $("#cmbFchaInicio"),
            cmbPiso = $("#cmbPiso"),
            buscarReporte = $("#buscarReporte")
        ;

        cmbPiso.select2();
        cmbFchaInicio.select2();

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
                $obj.addClass("js-example-basic-single");
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
        cargar_catalogo_select('<?php echo site_url("/nomina/get/getFecha")?>', {}, cmbFchaInicio, 'Fecha');

        cmbFchaInicio.change(function () {
            cmbPiso.html('');
            cargar_catalogo_select('<?php echo site_url("/nomina/get/getPisoF")?>', {fecha: cmbFchaInicio.val()}, cmbPiso, 'Piso');
        });

        buscarReporte.click(function () {
            if(cmbPiso.val()===''){
                toastr.error("Debe de seleccionar un Piso");
            }else {
                window.open("<?php echo site_url('/nomina/set/ReciboPisoPDF?idPiso=')?>"+cmbPiso.val()+"&fecha="+cmbFchaInicio.val(), '_blank');
            }
        });

    });
</script>

<?php
$data['scripts'] = array(
    "jqw/localized-es.js",
    "toastr.min.js",
    "zebra_datepicker.src.js",
    "js1/moment.min.js",
    "../select2/js/select2.min.js"
);
$this->load->view("plantilla/pie", $data);
?>
