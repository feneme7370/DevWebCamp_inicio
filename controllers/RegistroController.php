<?php 

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Model\Categoria;
use Model\EventoRegistro;
use Model\Regalo;

class RegistroController{
    public static function crear(Router $router){
        if(!is_auth()){
            header('Location: /');
        }

        //verificar si esta registrado
        $registro = Registro::where('usuario_id', $_SESSION['id']);

        if(isset($registro) && ($registro->paquete_id === '3' || $registro->paquete_id === '2')){
            header('Location: /boleto?id=' . urlencode($registro->token));//redireccionar al boleto
        }
      
        if(isset($registro) && $registro->paquete_id === '1'){
            header('Location: /finalizar-registro/conferencias');
        }

        $router->render('registro/crear', [
            'titulo' => 'Finalizar registro'
        ]);
    }

    public static function gratis(Router $router){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_auth()){
                header('Location: /login');
            }

            if(isset($registro) && $registro->paquete_id === '3'){
                header('Location: /boleto?id=' . urlencode($registro->token));//redireccionar al boleto
            }

            $token = substr(md5(uniqid( rand(), true)), 0, 8);//cortar cadena de 32 a solo 8 caracteres;

            $datos = [
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            ];

            $registro = new Registro($datos);
            $resultado = $registro->guardar();

            if($resultado){
                header('Location: /boleto?id=' . urlencode($registro->token));//redireccionar al boleto
            }
        };
    }

    public static function boleto(Router $router){

        //validar URL
        $id = $_GET['id'];
        if(!$id || !strlen($id) === 8){
            header('Location: /');
        }
        
        $registro = Registro::where('token', $id);
        if(!$registro){
            header('Location: /');
        }
        
        //llenar tablas de referencia
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);
        
        //debuguear($registro);

        $router->render('registro/boleto', [
            'titulo' => 'Asistencia a DevWebCamp',
            'registro' => $registro
        ]);
    }

    public static function pagar(Router $router){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_auth()){
                header('Location: /login');
            }

            //validar que post no venga vacio
            if(empty($_POST)){
                echo json_encode([]);
                return;
            }

            //crear registro

            $datos = $_POST;
            $datos['token'] = substr(md5(uniqid( rand(), true)), 0, 8);//cortar cadena de 32 a solo 8 caracteres;
            $datos['usuario_id'] = $_SESSION['id'];

            
            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode($resultado);
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }
        };
    }

    public static function conferencias(Router $router){
        if(!is_auth()){
            header('Location: /login');
        }

        //validar que tenga plan presencial
        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);

        if(isset($registro) && $registro->paquete_id === '2'){
            header('Location: /boleto?id=' . urlencode($registro->token));//redireccionar al boleto
        }

        if($registro->paquete_id !== '1'){
            header('Location: /');
        }

        //redireccionar en caso de que ya completo registro
        if(isset($registro->regalo_id) && $registro->paquete_id === '1'){
            header('Location: /boleto?id=' . urlencode($registro->token));//redireccionar al boleto
        }

        $eventos = Evento::ordenar('hora_id', 'ASC');
        $eventos_formateados = [];
        foreach($eventos as $evento){
            //traer demas datos
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
            
            //poner en cada parte del arreglo
            if($evento->dia_id === '1' && $evento->categoria_id === '1'){
                $eventos_formateados['conferencias_v'][] = $evento;
            }
            if($evento->dia_id === '2' && $evento->categoria_id === '1'){
                $eventos_formateados['conferencias_s'][] = $evento;
            }
            if($evento->dia_id === '1' && $evento->categoria_id === '2'){
                $eventos_formateados['workshops_v'][] = $evento;
            }
            if($evento->dia_id === '2' && $evento->categoria_id === '2'){
                $eventos_formateados['workshops_s'][] = $evento;
            }
        }

        $regalos = Regalo::all('ASC');

        //manejar registro con POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //revisar usuario autenticado
            if(!is_auth()){
                header('Location: /login');
            }
            //pasar string a array
            $eventos = explode(',', $_POST['eventos']);
            if(empty($eventos)){
                echo json_encode(['resultado' => false]);
                return;
            }
            
            //obtener registro de usuario
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            
            //validar usuario y paquete
            if(!isset($registro) || $registro->paquete_id !== '1'){
                echo json_encode(['resultado' => false]);
                return;
            }

            $eventosArray = [];//para no consultar dos veces la db
            //validar disponibilidad, array solo con id
            foreach($eventos as $evento_id){
                $evento = Evento::find($evento_id);
                //comprobar que el evento exista
                if(!isset($evento) || $evento->disponibles === '0'){
                    echo json_encode(['resultado' => false]);
                    return;               
                }

                $eventosArray[] = $evento;
            }
            //validar disponibilidad, array solo con id
            foreach($eventosArray as $evento){
                $evento->disponibles -=1;
                $evento->guardar();

                //almacenar el registro
                $datos = [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id
                ];

                $registro_usuario = new EventoRegistro($datos);
                $registro_usuario->guardar();
            }

            //almacenar regalo
            $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
            $resultado = $registro->guardar();

            if($resultado){
                echo json_encode(['resultado' => $resultado, 'token' => $registro->token]);
            }else{
                echo json_encode(['resultado' => false]);
            }
            return;


        };

        $router->render('registro/conferencias', [
            'titulo' => 'Elige WorkShops y Conferencias',
            'eventos' => $eventos_formateados,
            'regalos' => $regalos

        ]);
    }
}
?>