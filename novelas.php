<?php

$host="localhost";
$bd="novelas";
$usuario="root";
$contrasenia="";

try {
    $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia); //PDO realiza una conexion con la base de datos
    
} catch (Exception $ex) {
    echo $ex->getMessage(); //getMessage sirve para mostrar el mensaje de error que se produjo
}


$data = json_decode(file_get_contents("php://input"), true);
//parse_str($decoded_input, $putdata);

//header('Content-type: application/json');
//echo json_encode( $decoded_input );
//print_r($data);
//print_r($_SERVER);

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        $productosDb=$conexion->query("select * from novela");
        //echo json_encode($productos);
        //var_dump($productos);//Devaguea la variable, mostrara informacion de la variable.
        $productos=[];
        foreach ($productosDb as $row) {
            $productos[]=$row;
        }
        header('Content-type: application/json');
        echo json_encode($productos);
        break;

    case 'POST':
        $nombre=$data['nombre'];
        $sinopsis=$data['sinopsis'];
        $urlfuente=$data['urlfuente'];
        $imagen=$data['imagen'];
        $id=$data['id'];
        
        //$sentenciaSQL=$conexion->prepare("INSERT INTO libros (Nombre, Imagen) VALUES ($nombre, $imagen)"); 
        //$sentenciaSQL->execute();

        $stmt= $conexion->prepare("INSERT INTO novela ( nombre, sinopsis, imagen, urlfuente) VALUES (?,?,?,?)");
        $stmt->execute([$nombre, $sinopsis, $imagen, $urlfuente ]);
        
        header('Content-type: application/json');
        echo json_encode( ["Mensaje"=>"Insertado correctamente"] );
        break;

    case 'PUT':
        $nombre=$data['nombre'];
        $sinopsis=$data['sinopsis'];
        $urlfuente=$data['urlfuente'];
        $imagen=$data['imagen'];
        $id=$data['id'];

        
        $stmu= $conexion->prepare("UPDATE novela SET nombre = ?, sinopsis = ?, imagen = ?, urlfuente = ? WHERE id = ?");
        $stmu->execute([$nombre, $sinopsis, $imagen, $urlfuente, $id ]);
        
           
        header('Content-type: application/json');
        echo json_encode( ["Mensaje"=>"Actualizado correctamente"] );
        break;

    case 'DELETE':
        $nombre=$data['nombre'];
        //$sinopsis=$data['sinopsis'];
        //$urlfuente=$data['urlfuente'];
        //$imagen=$data['imagen'];
        //$id=$data['id'];
        
        
        $stmd= $conexion->prepare("DELETE FROM novela WHERE nombre=?");
        $stmd->execute([$nombre]);
        
           
        header('Content-type: application/json');
        echo json_encode( ["Mensaje"=>"Eliminado correctamente"] );
        break;


    
    default:
        header('Content-type: application/json');
        echo json_encode( ["Mensaje"=>"Accion invalida"] );
        break;
}


/*switch($accion){
    case "Agregar":

        //INSERT INTO `libros` (`ID`, `Nombre`, `Imagen`) VALUES (NULL, 'Libro de php', 'imagen.jpg');
        $sentenciaSQL=$conexion->prepare("INSERT INTO `libros` (`ID`, `Nombre`, `Imagen`) VALUES (NULL, 'Libro de php', 'imagen.jpg')");
        $sentenciaSQL->execute();
        
        break;
    case "Modificar":
        echo "Boton Modificar:";
        break;
    case "Cancelar":
        echo "Boton Cancelar:";
        break;    
        
}*/



?>