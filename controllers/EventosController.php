<?php 

namespace Controllers;

use Model\ActiveRecord;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use MVC\Router;

class EventosController{
    public static function index(Router $router){
        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops'
        ]);
    }

    public static function crear(Router $router){
        $alertas = [];
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');

        $eventos = new Evento;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $eventos->sincronizar($_POST);
            $alertas = $eventos->validar();

            if(empty($alertas)){
                $resultado = $eventos->guardar();
                
                if($resultado){
                    header('Location: admin/eventos');
                }
            }
        };

        $router->render('admin/eventos/crear', [
            'titulo' => 'Crear evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'eventos' => $eventos
        ]);
    }
}
?>