<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by REPSS Hidalgo.
 * User: Ulises Darío Martínez Salinas
 * Contact: ulises[dot]salinas[at]gmail[dot]com
 * Date: 16/05/2017
 * Time: 10:57 AM
 */

$anio=2018;
?>


</div> <!--end container-fluid-->

<!-- Pie de página -->
<!--<script src="--><?php //echo base_url('assets/js/')?><!--semantic.min.js?v=2.11"></script>-->
<script src="<?php echo base_url('assets/js/')?>datepicker.min.js?v=1"></script>
<script src="<?php echo base_url('assets/js/i18n/')?>datepicker.es.js?v=1"></script>
<script src="<?php echo base_url('assets/js/')?>bootstrap.js?v=4.1.3"></script>
<script src="<?php echo base_url('assets/js/')?>bootstrap.min.js?v=4.1.3"></script>

<script>

    if (!String.prototype.format) {
        String.prototype.format = function() {
            var str = this.toString();
            if (!arguments.length)
                return str;
            var args = typeof arguments[0],
                args = (("string" == args || "number" == args) ? arguments : arguments[0]);
            for (arg in args)
                str = str.replace(RegExp("\\{" + arg + "\\}", "gi"), args[arg]);
            return str;
        }
    }

    $(document).ready(function () {

    });
</script>


<?php if(isset($scripts)){
    for($i=0;$i<count($scripts);$i++){
        echo '<script src="' . base_url("assets/js/" . $scripts[$i] . '?v=1"></script>');
    }
}?>
</body>
<footer id="footer" class="pb-4 pt-4">
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-12">
                <h5> ©<?php echo $anio ?> All rights reserved | Maquiladora ESPANI S.A. de C.V </h5>
                <p>Centro, Fco González Bocanegra 110, Maestranza, 42002 Pachuca de Soto, Hgo.</p>
            </div>
        </div>
    </div>
</footer>
</html>