<?php 

namespace Controllers;

use Model\ActiveRecord;
use MVC\Router;

class RegalosController extends ActiveRecord{
    public static function index(Router $router){
        $router->render('admin/regalos/index', [
            'titulo' => 'Regalos'
        ]);
    }
}
?>