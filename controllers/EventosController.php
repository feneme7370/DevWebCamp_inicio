<?php 

namespace Controllers;

use Classes\Paginacion;
use Model\ActiveRecord;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use Model\Ponente;
use MVC\Router;

class EventosController{
    public static function index(Router $router){
        if(!is_admin()){ header('Location: /login'); }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1){
            header('Location: /admin/eventos?page=1');
        };

        $por_pagina = 10;

        $total = Evento::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);

        //crea un atributo mas de la categoria
        $eventos = Evento::paginar($por_pagina, $paginacion->offset());
        foreach($eventos as $evento){
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
        }
        //debuguear($eventos);

        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops',
            'eventos' => $eventos,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router){
        if(!is_admin()){ header('Location: /login'); }
        $alertas = [];
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');

        $eventos = new Evento;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_admin()){ header('Location: /login'); }
            $eventos->sincronizar($_POST);
            $alertas = $eventos->validar();

            if(empty($alertas)){
                $resultado = $eventos->guardar();
                
                if($resultado){
                    header('Location: /admin/eventos');
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
    public static function editar(Router $router){
        if(!is_admin()){ header('Location: /login'); }
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        
        $alertas = [];

        if(!$id){
            header('Location: /admin/eventos');
        }
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');
        $eventos = Evento::find($id);
        if(!$eventos){
            header('Location: /admin/eventos');
        }
        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_admin()){ header('Location: /login'); }
            $eventos->sincronizar($_POST);
            $alertas = $eventos->validar();

            if(empty($alertas)){
                $resultado = $eventos->guardar();
                
                if($resultado){
                    header('Location: /admin/eventos');
                }
            }
        };

        $router->render('admin/eventos/crear', [
            'titulo' => 'Editar evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'eventos' => $eventos
        ]);
    }

    public static function eliminar(){
        if(!is_admin()){ header('Location: /login'); }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_admin()){ header('Location: /login'); }
            
            $id = $_POST['id'];
            $evento = Evento::find($id);

            if(!isset($evento)){
                header('Location: /admin/eventos');
            }
            $resultado = $evento->eliminar();

            if($resultado){
                header('Location: /admin/eventos');
            }
        };
    }
}
?>