<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {
    public static function index() {
        $servcios = Servicio::all();
         echo json_encode($servcios);
    }

    public static function guardar() {
      
        //Almacena la Cita y devuelve el Id
     $cita = new Cita($_POST);
     $resultado = $cita->guardar();

     $id = $resultado['id'];
     

     //Almacena los Servicios con el Id de la Cita

     $idServicios = explode(",", $_POST['servicios']);

     foreach ($idServicios as $idServicio) {
        $args = [
            'citaId' => $id,
            'servicioId' => $idServicio
        ];
        $citaServicio = new CitaServicio($args);
        $citaServicio->guardar();
     }

     echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}

