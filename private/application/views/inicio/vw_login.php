<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Inicio";
$data['css'] = array(
    "font-awesome.css",
    "style.css"
);

$this->load->view("plantilla/encabezado",$data);


//    echo password_hash('53RVr3ps$123',PASSWORD_BCRYPT, ['cost' => 11] );

?>
<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>

  <h1>ESPANI</h1>
	<!-- Main-Content -->
	<div class="main-w3layouts-form">
		<h2>Inicio de sesión</h2>
		<!-- main-w3layouts-form -->
		<form action="<?php echo base_url() ?>inicio/iniciar_sesion" method="post" accept-charset="utf-8" autocomplete="off">
			<div class="fields-w3-agileits">
				<span class="fa fa-user" aria-hidden="true"></span>
				<input type="text" name="txtUsuario" id="txtUsuario" required="" placeholder="Usuario" />
			</div>
			<div class="fields-w3-agileits">
				<span class="fa fa-key" aria-hidden="true"></span>
				<input type="password" name="txtClave" id="txtClave" required="" placeholder="Contraseña" />
			</div>
			<div class="remember-section-wthree">
				<ul>
					<li>
						<label class="anim">
							<input type="checkbox" class="checkbox">
							<span> Recordar</span>
						</label>
					</li>

				</ul>
				<div class="clear"> </div>
			</div>
			<input type="submit" value="Login" />
		</form>
		<!--// main-w3layouts-form -->

	</div>




<?php
    $data['scripts'] = array(
    );
    $this->load->view("plantilla/pie",$data);
