<?php
class indexController extends BaseController {



	public function index() {
		
		
		echo $this->renderAction("index");
	}


	public function login()
	{
		return $this->renderAction("login");
	}
	public function logout()
	{
		session_destroy();
		header("Location: /admin/index/login");
	}	
	public function login_submit() 
	{
		if ((int)$_SESSION['s_user']['Id']==0 && $this->checkCookie()==false  ) {
			header("Location: /admin/index/login");
		}		
		
		$Usuario = DBManager::customQuery('Usuarios', "SELECT * FROM Usuarios WHERE Email = :email AND Password=:clave   LIMIT 1" , array('email'=> $_POST['usuario'], 'clave'=>$_POST['password']), false);	
		$Usuario=array_pop($Usuario);
	
		
		if (is_array($Usuario) && array_key_exists('Id',$Usuario)){	
			$_SESSION['s_user']=$Usuario;	
			$_SESSION['autorized'] =1;
			if($_POST['remember']==1){

				setcookie("C_email_cookie", $_SESSION['s_user']['Email'] , time()+(60*60*24*365),  '/');	
				setcookie("C_id_usuario", $_SESSION['s_user']['Id'] , time()+(60*60*24*365),  '/');				
			}
			header("Location: /admin/index/nuevas");
		} else {
			header("Location: /admin/index/login/error");
		}
		
	}

	public function checkCookie()
	{		

		$Usuario = DBManager::customQuery('Usuarios', "SELECT * FROM Usuarios WHERE Email = :email AND Id=:id_usuario   LIMIT 1" , array('email'=> $_COOKIE["C_email_cookie"], 'id_usuario'=>$_COOKIE["C_id_usuario"]), false);	
		$Usuario=array_pop($Usuario);
		if (is_array($Usuario) && array_key_exists('Id',$Usuario)){	
			$_SESSION['s_user']=$Usuario;	
			$_SESSION['autorized'] =1;			

			setcookie("C_email_cookie", $_SESSION['s_user']['Email'] , time()+(60*60*24*365),  '/');	
			setcookie("C_id_usuario", $_SESSION['s_user']['Id'] , time()+(60*60*24*365),  '/');				
			
			return true;
		} else {
			return false;
			header("Location: /admin/index/login/error");
		}		
	}	




}