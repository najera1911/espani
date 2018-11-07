<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Departamentos";
$data['css'] = array(
    'espaniMain.css'
);

$this->load->view("plantilla/encabezado",$data);
?>
<link href="<?php echo base_url('assets/assests/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<!--///////////////////////////////////////////////////////////////////////////////////////////////////////-->
<div class="container">
<!--</center>-->
 <div class="col text-center text-uppercase">
    <h3 class="txt-Subtitulos"> Catalogo de Departamentos </h3>
 </div>
  <br />
  <button class="btn btn-success" onclick="insertar_areas()"><i class="fa fa-user-plus" aria-hidden="true"></i> Agregar Departamento</button>
  <br />
  <br />
  <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>Id</th>
        <th>Descripcion</th>
        <th>Estatus</th>
        <th style="width:125px;">Accion
        </p></th>
      </tr>
    </thead>
    <tbody>
           <?php foreach($obtner_todos as $departamentos){?>
                   <tr>
                       <td><?php echo $departamentos->cat_rh_departamento_id;?></td>
                       <td><?php echo $departamentos->descripcion;?></td>
                       <td><?php echo $departamentos->estatus;?></td>
                            <td>
                                <button class="btn btn-warning" onclick="editar(<?php echo $departamentos->cat_rh_departamento_id;?>)"><i class="fas fa-pencil-alt"  aria-hidden="true"></i></button>
                                <button class="btn btn-danger" onclick="eliminar(<?php echo $departamentos->cat_rh_departamento_id;?>)"><i class="fas fa-ban" aria-hidden="true"></i></button>
                            </td >
                    </tr>
           <?php }?>
    </tbody>
    <tfoot>
      <tr>
        <th>ID</th>
        <th>Descripcion</th>
        <th>Estatus</th>
        <th>Accion</th>
      </tr>
    </tfoot>
  </table>

</div>

  <script src="<?php echo base_url('assets/assests/jquery/jquery-3.1.0.min.js')?>"></script>
  <script src="<?php echo base_url('assets/assests/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/assests/datatables/js/jquery.dataTables.min.js')?>"></script>


<!--///////////////////////////////////////////////////////////////////////////////////////////////////////-->

<script type="text/javascript">
$(document).ready( function () {
$('#table_id').DataTable();
} );
  var save_method; //for save method string
  var table;
  function insertar_areas()
  {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Insertar departamento'); // Set Title to Bootstrap modal title
  }


  function save()
  {
    var url;
    if(save_method == 'add')
    {
        url = "<?php echo site_url('areas/insertar_area')?>";
    }
    else
    {
      url = "<?php echo site_url('areas/actualizar_area')?>";
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

function editar(id)
  {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals

    //Ajax Load data from ajax
    $.ajax({
      url : "<?php echo site_url('areas/ajax_edit/')?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {

          $('[name="descripcion"]').val(data.descripcion);
          $('[name="estatus"]').val(data.estatus);
          $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Editar'); // Set title to Bootstrap modal title

      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
  });
  }

  function eliminar(id)
  {
    if(confirm('Estas seguro de elimiar la informacion'))
    {
      // ajax delete data from database
        $.ajax({
          url : "<?php echo site_url('areas/borrar_area')?>/"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {

             location.reload();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error deleting data');
          }
      });

    }
  }  
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h3 class="modal-title">Catalogo Puestos</h3>
    </div>
    <div class="modal-body">
      <form action="#" id="form" class="form-horizontal">
        <input type="hidden" value="" name="cat_rh_puesto_id"/>
        <div class="form-body">
          <div class="form-group">
            <label class="control-label col-md-3">Descripcion</label>
            <div class="col-md-9">
              <input name="descripcion" placeholder="Descripcion" class="form-control" type="text">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">Estatus</label>
            <div class="col-md-9">
              <input name="estatus" placeholder="Estatus" class="form-control" type="text">
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