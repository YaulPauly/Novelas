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

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        $productosDb=$conexion->query("select * from episodios");

        $productos=[];
        foreach ($productosDb as $row) {
            $productos[]=$row;
        }
        header('Content-type: application/json');
        echo json_encode($productos);
        break;

    case 'POST':
        $id=$data['id'];
        $nombreEpisodio=$data['nombreEpisodio'];
        $sinopsisEpisodio=$data['sinopsisEpisodio'];
        $numeroEpisodio=$data['numeroEpisodio'];
        $duracionEpisodio=$data['duracionEpisodio'];
        $urlEpisodio=$data['urlEpisodio'];
        $imagenEpisodio=$data['imagenEpisodio'];
        $idNovelas=$data['idNovelas'];


        $stmt= $conexion->prepare("INSERT INTO episodios (id, nombreEpisodio, sinopsisEpisodio, numeroEpisodio, duracionEpisodio, urlEpisodio, idNovelas, imagenEpisodio ) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->execute([$id, $nombreEpisodio, $sinopsisEpisodio, $numeroEpisodio, $duracionEpisodio, $urlEpisodio, $idNovelas, $imagenEpisodio ]);
        
        header('Content-type: application/json');
        echo json_encode( ["Mensaje"=>"Insertado correctamente"] );
        break;

    case 'PUT':
        $nombreEpisodio=$data['nombreEpisodio'];
        $sinopsisEpisodio=$data['sinopsisEpisodio'];
        $numeroEpisodio=$data['numeroEpisodio'];
        $duracionEpisodio=$data['duracionEpisodio'];
        $urlEpisodio=$data['urlEpisodio'];
        $imagenEpisodio=$data['imagenEpisodio'];
        $idNovelas=$data['idNovelas'];
        $id=$data['id'];

        
        $stmu= $conexion->prepare("UPDATE episodios SET nombreEpisodio=?, sinopsisEpisodio=?, numeroEpisodio=?, duracionEpisodio=?, urlEpisodio=?, idNovelas=?, imagenEpisodio=?  WHERE id=?");
        $stmu->execute([$nombreEpisodio, $sinopsisEpisodio, $numeroEpisodio, $duracionEpisodio, $urlEpisodio, $idNovelas, $imagenEpisodio, $id]);
        
           
        header('Content-type: application/json');
        echo json_encode( ["Mensaje"=>"Actualizado correctamente"] );
        break;

    case 'DELETE':
        $nombre=$data['nombreEpisodio'];
        $stmd= $conexion->prepare("DELETE FROM episodios WHERE nombreEpisodio=?");
        $stmd->execute([$nombre]);
        
           
        header('Content-type: application/json');
        echo json_encode( ["Mensaje"=>"Eliminado correctamente"] );
        break;


    
    default:
        header('Content-type: application/json');
        echo json_encode( ["Mensaje"=>"Accion invalida"] );
        break;
}


?>