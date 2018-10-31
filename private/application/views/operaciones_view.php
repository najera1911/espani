<?php


defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Operaciones";
$data['css'] = array(
    'espaniMain.css'
);

$this->load->view("plantilla/encabezado",$data);
?>

<link href="<?php echo base_url('assets/assests/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">


<div class="container">
</center>
 <div class="col text-center text-uppercase">
    <h3 class="txt-Subtitulos"> Catalogo de operaciónes </h3>
 </div>
  <br />
  <button class="btn btn-success" onclick="insertar_operacion()"><i class="fa fa-user-plus" aria-hidden="true"></i> Agregar Operacion</button>
  <br />
  <br />
  <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>Id</th>
        <th>Operaciónes</th>
        <th>Descripción</th>
        <th>Tarifa_con</th>
        <th>Tarifa_sin</th>
        <th style="width:125px;">Acción
        </th>
      </tr>
    </thead>
    <tbody>
           <?php foreach($obtner_todos as $operaciones){?>
                   <tr>
                       <td><?php echo $operaciones->cat_operaciones_id;?></td>
                       <td><?php echo $operaciones->operaciones;?></td>
                       <td><?php echo $operaciones->descripcion;?></td>
                       <td><?php echo $operaciones->tarifa_con;?></td>
                       <td><?php echo $operaciones->tarifa_sin;?></td>
                    <td>
                        <button class="btn btn-warning" onclick="editar(<?php echo $puestos->cat_rh_puesto_id;?>)"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                        <button class="btn btn-danger" onclick="eliminar(<?php echo $puestos->cat_rh_puesto_id;?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                    </td >
                    </tr>
           <?php }?>
    </tbody>
    <tfoot>
      <tr>
      <th>Id</th>
      <th>Operaciónes</th>
      <th>Descripción</th>
      <th>Tarifa_con</th>
      <th>Tarifa_sin</th>
      </tr>
    </tfoot>
  </table>

</div>

  <script src="<?php echo base_url('assets/assests/jquery/jquery-3.1.0.min.js')?>"></script>
  <script src="<?php echo base_url('assets/assests/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/assests/datatables/js/jquery.dataTables.min.js')?>"></script>
  
  <script type="text/javascript">
$(document).ready( function () {
$('#table_id').DataTable();
} );
  var save_method; //for save method string
  var table;


  function insertar_operacion()
  {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Insertar operación'); // Set Title to Bootstrap modal title
  }

function save()
  {
    var url;
    if(save_method == 'add')
    {
        url = "<?php echo site_url('operaciones/insertar_operacion')?>";
    }
    else
    {
      url = "<?php echo site_url('catpuesto/actualizar_puesto')?>";
    }

     // ajax adding data to database
        $.ajax({
          url : url,
          type: "POST",
          data: $('#form').serialize(),
          dataType: "JSON",
          success: function(data)
          {
             //if success close modal and reload ajax table
             $('#modal_form').modal('hide');
            location.reload();// for reload a page
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error al insertar la información');
          }
      });
  }

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h3 class="modal-title">Catalogo Operaciónes</h3>
    </div>
    <div class="modal-body">
      <form action="#" id="form" class="form-horizontal">
        <input type="hidden" value="" name="cat_rh_puesto_id"/>
        <div class="form-body">
          <div class="form-group">
            <label class="control-label col-md-3">Operacion</label>
            <div class="col-md-9">
              <input name="operacion" placeholder="Operacion" class="form-control" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">Descripcion</label>
            <div class="col-md-9">
              <input name="descripcion" placeholder="Descripcion" class="form-control" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">Tarifa/con</label>
            <div class="col-md-9">
              <input name="tarifa_con" placeholder="Tarifa/C" class="form-control" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">Tarifa/sin</label>
            <div class="col-md-9">
              <input name="tarifa_sin" placeholder="Tarifa/S" class="form-control" type="text">
            </div>
          </div>
          
        </div>
      </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<!-- End Bootstrap modal -->




    <script>
        $(document).ready(function(){


        });
    </script>

<?php
$data['scripts'] = array(

);
$this->load->view("plantilla/pie",$data);