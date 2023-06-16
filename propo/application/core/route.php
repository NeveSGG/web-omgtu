<?php

/*
Класс-маршрутизатор для определения запрашиваемой страницы.
> цепляет классы контроллеров и моделей;
> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
*/
class Route
{

	static function start()
	{
		// контроллер и действие по умолчанию
		$controller_name = 'Main';
		$action_name = 'index';
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);
                $routes = array_slice($routes, 2);
                

		// получаем имя контроллера
		if ( !empty($routes[0]) )
		{	
			$controller_name = $routes[0];
		}

		// добавляем префиксы
		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		
		

		// подцепляем файл с классом модели (файла модели может и не быть)
		$model_file = strtolower($model_name).'.php';
		$model_path = "application/models/".$model_file;
		if(file_exists($model_path))
		{
                    include "application/models/".$model_file;
		}

		// подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;
		if(file_exists($controller_path))
		{
                    include "application/controllers/".$controller_file;
		}
		else
		{
                    Route::ErrorPage404();
                    return;
		}
		
		// создаем контроллер
		$controller = new $controller_name;
                
                // получаем имя экшена
		if ( array_key_exists(1, $routes) && !empty($routes[1]) )
		{
			$action_name = $routes[1];
		}
                $action = strtolower('action_'.$action_name);
		
                if (strtolower($controller_name) == "controller_product" && $action_name != "index") {
                    $controller->slug = strtolower($action_name);
                    $controller->action_index();
                } 
                else if (strtolower($controller_name) == "controller_search")
                {
                    $controller->query = $_GET['query'] ?? "";
                    $controller->page = $_GET['page'] ?? "1";
                    $controller->action_index();
                }
                else if (strtolower($controller_name) == "controller_category")
                {
                    $controller->slug = strtolower($action_name);
                    $controller->action_index();
                }
                else if(method_exists($controller, $action))
		{
                    // вызываем действие контроллера
                    $controller->$action();   
		}
                else
		{
                    Route::ErrorPage404();
                    print_r($routes."\n");
                    print_r($controller."\n");
                    print_r($controller_name."\n");
                    print_r($action_name);
		}
	
	}

	static function ErrorPage404()
        {
            http_response_code(404);
            include "application/controllers/controller_404.php";
            $controller = new Controller_404;
            $controller -> action_index();
        }
    
}
