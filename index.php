<?php
	#session start
	session_start();


	require 'app/core/general_propouse.php';
	
	#Change Include path
	//ini_set('include_path', ini_get('include_path').':../../lib:');
	$base=str_replace($_SERVER['DOCUMENT_ROOT'], '', pathinfo($_SERVER['SCRIPT_FILENAME']));
	DEFINE('BASE_DIR',  rtrim(array_shift($base), '/'));

	// Estos archivos se cargan estáticamente porque se 
	// encuentran en la carpeta lib/
	// todos los demás archivos que se incluyan dinámicamente 
	// en tiempo de ejecución serán cargados por el autoloader
	require 'app/core/autoloader.class.php';

	//Determina el directorio base
	//$baseDir = rtrim(array_shift(str_replace($_SERVER['DOCUMENT_ROOT'], '', pathinfo($_SERVER['SCRIPT_FILENAME']))), '/');
	$base=str_replace($_SERVER['DOCUMENT_ROOT'], '', pathinfo($_SERVER['SCRIPT_FILENAME']));
	//DEFINE('BASE_DIR',  rtrim(array_shift($base), '/'));
	$a = pathinfo($_SERVER['SCRIPT_FILENAME']);
	$b = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
	$c = str_replace($b, '', $a['dirname']);




	$baseDir = $c;

	//Inicializa el Router
	$router = Router::getInstance();


	$router->init($baseDir);
	
	//Determina e instancia el Controller
	$controller = $router->getController();
	
	$controllerFile = './app/controllers/'. $controller . '_controller.php';


	DEFINE('CURRENT_CONTROLLER', $controller);

	if (CURRENT_CONTROLLER != 'index' && $_SESSION['autorized'] != 1 ) {
		
		header("Location: /seedbox/login");
	}	


	//Verifica que el archivo del controller exista
	$error=0;
	if (!is_file($controllerFile)) {
	
		require_once 'app/controllers/error_controller.php';
		//$router->addRule('/error', array('controller' => 'error', 'action' => 'index'));
		$controllerClass = 'errorController';
		#Init the controller

		$controllerInstance = new $controllerClass($baseDir);

		#and call the action... if not action specified call index
		$controllerInstance->index();
		exit();
	}
	
	//Incluye dicho archivo
	require_once $controllerFile;
	$controllerClass = $controller.'Controller';
	
	//Verifica si se definió la clase del controller luego de la inclusión
	if (!class_exists($controllerClass)) {

		require_once 'app/controllers/error_controller.php';
		//$router->addRule('/error', array('controller' => 'error', 'action' => 'index'));
		$controllerClass = 'errorController';
		#Init the controller

		$controllerInstance = new $controllerClass($baseDir);

		#and call the action... if not action specified call index
		$controllerInstance->index();
		exit();
	}
	
	//Insancia el Controller
	try {
		$controllerInstance = new $controllerClass($baseDir);	
	} catch (Exception $e) {
		
		require_once 'app/controllers/error_controller.php';
		//$router->addRule('/error', array('controller' => 'error', 'action' => 'index'));
		$controllerClass = 'errorController';
		#Init the controller

		$controllerInstance = new $controllerClass($baseDir);

		#and call the action... if not action specified call index
		$controllerInstance->index(); 
		exit();
	}
	
	//Determina la Accion
	$action = $router->getAction();
	
	//Verifica que la accion exista
	if (!method_exists($controllerInstance, $action)) {
		
		require_once 'app/controllers/error_controller.php';
		//$router->addRule('/error', array('controller' => 'error', 'action' => 'index'));
		$controllerClass = 'errorController';
		#Init the controller

		$controllerInstance = new $controllerClass($baseDir);

		#and call the action... if not action specified call index
		$controllerInstance->index();
		exit();
	}
	
	//Ejecuta la accion
	
	try {
		$actionHtml = $controllerInstance->$action();
	} catch (Exception $e) {
		echo 'entra 5';
		require_once 'app/controllers/error_controller.php';
		//$router->addRule('/error', array('controller' => 'error', 'action' => 'index'));
		$controllerClass = 'errorController';
		#Init the controller

		$controllerInstance = new $controllerClass($baseDir);

		#and call the action... if not action specified call index
		$controllerInstance->index();
		exit();
	}


	if($actionHtml === false) die();
	else echo $actionHtml;

	?>