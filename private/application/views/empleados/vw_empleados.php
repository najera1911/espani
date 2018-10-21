<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$data['title'] = ":: RRHH - Plantilla";
$data['css'] = array(
    "jw/jqx.base.css",
    "jw/jqx.repss.css",
    "toastr.min.css",
    "zebra.css"
);

$this->load->view("plantilla/encabezado",$data);
?>





<script>
    $(document).ready(function (){

    });  //end document ready
</script>
<?php
$data['scripts'] = array(
    "jw/jqxcore.js",
    "jw/jqxdata.js",
    "jw/jqxcheckbox.js",
    "jw/jqxbuttons.js",
    "jw/jqxscrollbar.js",
    "jw/jqxmenu.js",
    "jw/jqxlistbox.js",
    "jw/jqxdropdownlist.js",
    "jw/jqxgrid.js",
    "jw/jqxgrid.pager.js",
    "jw/jqxgrid.columnsresize.js",
    "jw/jqxdata.export.js",
    "jw/jqxgrid.export.js",
    "jw/jqxgrid.grouping.js",
    "jw/jqxgrid.selection.js",
    "jw/jqxgrid.sort.js",
    "jw/jqxgrid.filter.js",
    "jw/jqxgrid.storage.js",
    "jw/jqxpanel.js",
    "jw/localized-es.js",
    "toastr.min.js",
    "zebra_datepicker.src.js",
    "jquery.fileDownload.js"

);
$this->load->view("plantilla/footer",$data);
?>
