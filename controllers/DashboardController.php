<?php 

namespace Controllers;

use Model\ActiveRecord;
use MVC\Router;

class DashboardController extends ActiveRecord{
    public static function index(Router $router){
        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de administracion'
        ]);
    }
}
?>