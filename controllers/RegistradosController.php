<?php 

namespace Controllers;

use MVC\Router;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Classes\Paginacion;
use Model\ActiveRecord;

class RegistradosController extends ActiveRecord{
    public static function index(Router $router){
            if(!is_admin()){ header('Location: /login'); }
            //paginacion - pagina actual
            $pagina_actual = $_GET['page'];
            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
            
            //poner siempre page en la url
            if(!$pagina_actual || $pagina_actual < 1){ header('Location: /admin/registrados?page=1'); }
            
            //paginacion - registros por paginas
            $registros_por_pagina = 5;
            
            //paginacion - total registros
            $total_registros = Registro::total();
    
            $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
    
            //validar paginas no existentes
            if($paginacion->total_paginas() < $pagina_actual){
                header('Location: /admin/registrados?page=1');
            }
            
            $registros = Registro::paginar($registros_por_pagina, $paginacion->offset());
            foreach($registros as $registro){
                $registro->usuario = Usuario::find($registro->usuario_id);
                $registro->paquete = Paquete::find($registro->paquete_id);
            }

        $router->render('admin/registrados/index', [
            'titulo' => 'Usuarios registrados',
            'registros' => $registros,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
}
?>