<?php 

namespace Controllers;

use Model\ActiveRecord;
use MVC\Router;

class RegistradosController extends ActiveRecord{
    public static function index(Router $router){
        $router->render('admin/registrados/index', [
            'titulo' => 'Usuarios registrados'
        ]);
    }
}
?>