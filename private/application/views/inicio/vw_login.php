<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Inicio";
$data['css'] = array(
    "font-awesome.css",
    "styleLogin.css"
);

$this->load->view("plantilla/encabezado",$data);



//    echo password_hash('53RVr3ps$123',PASSWORD_BCRYPT, ['cost' => 11] );
?>


    <meta name="keywords"
          content="Trendy Flat Login Form Responsive Widget,Login form widgets, Sign up Web forms , Login signup Responsive web form,Flat Pricing table,Flat Drop downs,Registration Forms,News letter Forms,Elements"/>
    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>
    <link href="//fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900iSlabo+27px&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
          rel="stylesheet">


    <div class="agileheader mt-5">
        <h1>LOGIN NOREL</h1>
    </div>

    <section class="main-w3l mb-5 mt-5">
        <div class="w3layouts-main">
            <h2>Iniciar Sesión</h2>
            <div class="w3ls-form" style="padding-bottom: 20px">
                <form action="<?php echo base_url() ?>inicio/iniciar_sesion" method="post" accept-charset="utf-8"
                      autocomplete="off">
                    <div class="email-w3ls">
                        <input type="text" name="txtUsuario" id="txtUsuario" placeholder="Usuario" required="">
                        <span class="icon1"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    </div>
                    <div class="w3ls-password">
                        <input type="password" name="txtClave" id="txtClave" placeholder="Password" required="">
                        <span class="icon3"><i class="fa fa-lock" aria-hidden="true"></i></span>
                    </div>


                    <div class="clear"></div>
                    <button>Aceptar</button>
                </form>
            </div>

        </div>
    </section>
    <br><br><br><br><br>
    <script>
    </script>


<?php
$data['scripts'] = array(
);
$this->load->view("plantilla/pie",$data);