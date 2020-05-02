<div class="container">
    <div class="row">
        <div class="col-lg-4">
        <table class="table">
        <thead>
        <tr>
             <th scope="col">#</th>
             <th scope="col">idRubro</th>
             <th scope="col">Descripcion</th>
        </tr>
        </thead>
        <tbody>
          <tr>

          <?php foreach($rubro->getSubRubros() as $row) {?>
          <th scope="row">1</th>
            <td><?php echo $row->getIdSubRubro(); ?></td>
            <td><?php echo $row->getDescripcion(); ?></td>
          </tr>          

          <?php } ?>

        </tbody>
     </table>
     </div>
    </div>
</div>

