<?php
require_once ('../view/categoriaNuevo_view.php');
require_once ('../model/grupoFamiliarClass.php');

if(isset($_POST['agregarCategoria'])){
    echo "pasa";
    $gf = new GrupoFamiliar();
    $gf->agregarCategoria($_POST['descripcion'], $_POST['sueldobasico']);
}


?>