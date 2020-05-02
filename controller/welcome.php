<?php 

require_once ('../model/UsuarioClass.php');

$user = new Usuario();
echo "user: ".$_SESSION['usuario_id'];
//$user->registrarSesion();
// foreach($_POST as $campo => $valor) 
// echo "$campo -> $valor <br>"; 
// include_once '../model/PaisClass.php';
// include_once '../model/ProvinciaClass.php';
// include_once '../model/LocalidadClass.php';
// include_once '../model/DireccionClass.php';
// include_once ('../model/RubroClass.php');
// include_once ('../model/SubRubroClass.php');



// $rubro = new Rubro();
// $rubro->consultarRubro(7);
// echo "asd: ".$rubro->getDescripcion();
// echo "<br>id: ".$rubro->getIdRubro();

// foreach($rubro->getSubRubros() as $row){
//     echo "<br>idSubrubro: ".$row->getIdSubRubro();
//     echo "<br>Descripcion: ".$row->getDescripcion();
//     echo "<br>fkRubro:".$row->getFkrubro();
// }






// $pais = new Pais();
// $pais->consultarPais(1);
// echo "<br>nom pais: ".$pais->getNombre();

// foreach($pais->getProvincias() as $row){
// echo "<br>nombre: ".$row->getNombre();
// echo "<br>id: ".$row->getIdProvincia();
// echo "<br> Localidad: ";
//     foreach($row->getLocalidades() as $row2){
//         echo "<br>nombre: ".$row2->getNombre();
//         echo "<br> codigo posta: ".$row2->getCodigoPostal();
//     }

// }


// $localidad = new Localidad("San Miguel de Tucuman",4000);
// $localidad2 = new Localidad("Aguilares",5142);

// $provincia = new Provincia("tucuman");
// $provincia->addLocalidad($localidad);
// $provincia->addLocalidad($localidad2);


// $numLocalidades = count($provincia->getLocalidades());

// foreach($provincia->getLocalidades() as $row)
// {
//     echo "<br>Nombre: ".$row->getNombre();
//     echo "<br>Codigo Postal: ".$row->getCodigoPostal();
// }

// $pais = new Pais("argentina");
// echo "pais: ".$pais->getNombre();
 
// $direccion = new Direccion($localidad, "Balcarce",395);
// echo "<br>--------------------------------------<br>";
// echo "<br>Calle: ".$direccion->getCalle();
// echo "<br>Numero: ".$direccion->getNumero();
// $auxlocalidad = $direccion->getLocalidad();
// echo "<br>Ciudad: ".$auxlocalidad->getNombre();
// echo "<br>Codigo: ".$auxlocalidad->getCodigoPostal();


?>

