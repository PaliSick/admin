<?php
class indexController extends BaseController {

	public function index()
	{
		$this->nuevas();
	}


	public function nuevas(){
		if ((int)$_SESSION['s_user']['Id']==0 && $this->checkCookie()==false  ) {
			header("Location: /seedbox/index/login");
		}
		$r = Router::getInstance();
		

		$Peliculas= DBManager::customQuery('Peliculas', "SELECT P.* FROM Peliculas P WHERE NOT EXISTS (SELECT id_usuario FROM Rel_pelicula_usuario R WHERE P.id=R.id_pelicula AND R.id_usuario=:id_usuario AND R.Tipo=0 ) ", array('id_usuario'=>$_SESSION['s_user']['Id']), false);	
		
		$this->tpl->assign('peliculas', $Peliculas);
		$this->tpl->assign('mostrar', 'info');
		echo $this->renderAction("index");
	
	}

	public function todas() {
		
		if ((int)$_SESSION['s_user']['Id']==0 && $this->checkCookie()==false  ) {
			header("Location: /seedbox/index/login");
			return true;
		}
		$this->tpl->assign('menu', array("5"=>' class="active"'));
		$r = Router::getInstance();
		$this->tpl->assign('action', $r->getAction());

		$params = Router::getParams();

		for($i = 0, $l = count($params); $i<$l; $i = $i + 2) {
			$pa[$params[$i]] = urldecode($params[$i+1]);
		}
		$p = max(1,(int)$r->getParam(1));		


		$offset = ($p-1) * 20;

		if($pa['q']){
			
			if($pa['descripcion']==1){
				$rt = DBManager::customQuery("", "SELECT count(*) as totalRows FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.id_pelicula=P.Id AND R.id_usuario=:id_usuario AND ( P.Pelicula LIKE :texto OR  P.Descripcion LIKE :texto )", array('id_usuario'=>$_SESSION['s_user']['Id'], 'texto'=>'%'.$pa['q'].'%'), false);
				$totalRows = $rt[0]['totalRows'];
				$Peliculas= DBManager::customQuery('Peliculas', "SELECT P.Id, P.Pelicula, R.estado FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.id_pelicula=P.Id AND R.id_usuario=:id_usuario AND ( P.Pelicula LIKE :texto OR  P.Descripcion LIKE :texto )", array('id_usuario'=>$_SESSION['s_user']['Id'], 'texto'=>'%'.$pa['q'].'%'), false);

			}else{
				$rt = DBManager::customQuery("", "SELECT count(*) as totalRows FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.id_pelicula=P.Id AND R.id_usuario=:id_usuario AND  P.Pelicula LIKE :texto ", array('id_usuario'=>$_SESSION['s_user']['Id'], 'texto'=>'%'.$pa['q'].'%'), false);
				$totalRows = $rt[0]['totalRows'];
				$Peliculas= DBManager::customQuery('Peliculas', "SELECT P.Id, P.Pelicula, R.estado FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.id_pelicula=P.Id AND R.id_usuario=:id_usuario AND  P.Pelicula LIKE :texto ", array('id_usuario'=>$_SESSION['s_user']['Id'], 'texto'=>'%'.$pa['q'].'%'), false);
			}
		}else{
			$rt = DBManager::customQuery("", "SELECT count(*) as totalRows FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.id_pelicula=P.Id AND R.id_usuario=:id_usuario", array('id_usuario'=>$_SESSION['s_user']['Id']), false);	
			$totalRows = $rt[0]['totalRows'];
			
			$Peliculas= DBManager::customQuery('Peliculas', "SELECT P.Id, P.Pelicula, R.estado FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.id_pelicula=P.Id AND R.id_usuario=:id_usuario ORDER BY P.Id DESC LIMIT $offset, 20;", array('id_usuario'=>$_SESSION['s_user']['Id']), false);	
		}
		
		
		
		$pg = new Pager();
		$pg->set('urlPattern', '/seedbox'.preg_replace('%/p/[0-9]+%i', '', $r->getPath()). '/p/{{page}}' );
		$pg->set('urlPatternFirstPage', '/seedbox'.preg_replace('%/p/[0-9]+%i', '', $r->getPath()));
		$pg->set('itemsPerPage', 20);
		$pg->set('page', $p);
		$pg->set('total', $totalRows);
		$pg->set('numLinks', 9);

		$this->tpl->assign('paginado', $pg->display(true));

		foreach ($Peliculas as $key => $value) {
			switch ($value['estado']) {
				case 0:
					$Peliculas[$key]['info']='danger';
					break;
				
				case 1:
					$Peliculas[$key]['info']='warning';
					break;
				case 5:
					$Peliculas[$key]['info']='success';
					break;
			}
			
		}
		
		$this->tpl->assign('peliculas', $Peliculas);
		
		echo $this->renderAction("index");
	}

	public function quiero() {
		if ((int)$_SESSION['s_user']['Id']==0 && $this->checkCookie()==false  ) {
			header("Location: /seedbox/index/login");
			return true;
		}
		$this->tpl->assign('menu', array("2"=>' class="active"'));

		$r = Router::getInstance();
		$this->tpl->assign('action', $r->getAction());

		$params = Router::getParams();

		for($i = 0, $l = count($params); $i<$l; $i = $i + 2) {
			$pa[$params[$i]] = urldecode($params[$i+1]);
		}	
		$p = max(1,(int)$r->getParam(1));
		$offset = ($p-1) * 20;
		if(count($params)>0){
			
			if($pa['descripcion']==1){
				$rt = DBManager::customQuery("", "SELECT count(*) as totalRows FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=1 AND R.Id_usuario=:id_usuario AND ( P.Pelicula LIKE :texto OR  P.Descripcion LIKE :texto ) ", array('id_usuario'=>$_SESSION['s_user']['Id'], 'texto'=>'%'.$pa['q'].'%'), false);
				$totalRows = $rt[0]['totalRows'];
				$Peliculas= DBManager::customQuery('Peliculas', "SELECT P.*, IF( (SELECT 1 FROM Rel_pelicula_usuario R2 WHERE R2.Id_pelicula =P.Id AND R2.Id_usuario !=:id_usuario AND R2.Estado=1 LIMIT 1)=1,0,1) as Borrar FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=1 AND R.Id_usuario=:id_usuario AND ( P.Pelicula LIKE :texto OR  P.Descripcion LIKE :texto ) ORDER BY P.Id DESC LIMIT $offset, 20;", array('id_usuario'=>$_SESSION['s_user']['Id'], 'texto'=>'%'.$pa['q'].'%'), false);
			}
			else{
				$rt = DBManager::customQuery("", "SELECT count(*) as totalRows FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=1 AND R.Id_usuario=:id_usuario AND P.Pelicula LIKE :texto ", array('id_usuario'=>$_SESSION['s_user']['Id'], 'texto'=>'%'.$pa['q'].'%'), false);
				$totalRows = $rt[0]['totalRows'];
				$Peliculas= DBManager::customQuery('Peliculas', "SELECT P.*, IF( (SELECT 1 FROM Rel_pelicula_usuario R2 WHERE R2.Id_pelicula =P.Id AND R2.Id_usuario !=:id_usuario AND R2.Estado=1 LIMIT 1)=1,0,1) as Borrar FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=1 AND R.Id_usuario=:id_usuario AND P.Pelicula LIKE :texto ORDER BY P.Id DESC LIMIT $offset, 20;", array('id_usuario'=>$_SESSION['s_user']['Id'], 'texto'=>'%'.$pa['q'].'%'), false);
			}
		}else{
			$rt = DBManager::customQuery("", "SELECT count(*) as totalRows FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=1 AND R.Id_usuario=:id_usuario",array('id_usuario'=>$_SESSION['s_user']['Id']) , false);	
			$totalRows = $rt[0]['totalRows'];
			
			$Peliculas= DBManager::customQuery('Peliculas', "SELECT P.*, IF( (SELECT 1 FROM Rel_pelicula_usuario R2 WHERE R2.Id_pelicula =P.Id AND R2.Id_usuario !=:id_usuario AND R2.Estado=1 LIMIT 1)=1,0,1) as Borrar FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=1 AND R.Id_usuario=:id_usuario ORDER BY P.Id DESC LIMIT $offset, 20;",array('id_usuario'=>$_SESSION['s_user']['Id']) , false);	
		}
		
		
		
		$pg = new Pager();
		$pg->set('urlPattern', '/seedbox'.preg_replace('%/p/[0-9]+%i', '', $r->getPath()). '/p/{{page}}' );

		$pg->set('urlPatternFirstPage', '/seedbox'.preg_replace('%/p/[0-9]+%i', '', $r->getPath()));
		$pg->set('itemsPerPage', 20);
		$pg->set('page', $p);
		$pg->set('total', $totalRows);
		$pg->set('numLinks', 9);

		$this->tpl->assign('paginado', $pg->display(true));

		$this->tpl->assign('peliculas', $Peliculas);

	
		echo $this->renderAction("quiero");
	}
	public function pasadas() {
		if ((int)$_SESSION['s_user']['Id']==0 && $this->checkCookie()==false  ) {
			header("Location: /seedbox/index/login");
			return true;
		}
		$this->tpl->assign('menu', array("4"=>' class="active"'));


		$r = Router::getInstance();
		$this->tpl->assign('action', $r->getAction());

		$params = Router::getParams();

		for($i = 0, $l = count($params); $i<$l; $i = $i + 2) {
			$pa[$params[$i]] = urldecode($params[$i+1]);
		}	
		$p = max(1,(int)$r->getParam(1));
		$offset = ($p-1) * 20;
		if(count($params)>0){
			
			if($pa['descripcion']==1){
				$rt = DBManager::customQuery("", "SELECT count(*) as totalRows FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=0 AND R.Id_usuario=:id_usuario AND ( P.Pelicula LIKE :texto OR  P.Descripcion LIKE :texto )", array('id_usuario'=>$_SESSION['s_user']['Id'], 'texto'=>'%'.$pa['q'].'%'), false);	
				$totalRows = $rt[0]['totalRows'];
				$Peliculas= DBManager::customQuery('Peliculas', "SELECT P.* FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=0 AND R.Id_usuario=:id_usuario AND ( P.Pelicula LIKE :texto OR  P.Descripcion LIKE :texto ) ORDER BY P.Id DESC LIMIT $offset, 20;", array('id_usuario'=>$_SESSION['s_user']['Id'], 'texto'=>'%'.$pa['q'].'%'), false);
			}
			else{
				$rt = DBManager::customQuery("", "SELECT count(*) as totalRows FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=0 AND R.Id_usuario=:id_usuario AND P.Pelicula LIKE :texto ", array('id_usuario'=>$_SESSION['s_user']['Id'], 'texto'=>'%'.$pa['q'].'%'), false);
				$totalRows = $rt[0]['totalRows'];
				$Peliculas= DBManager::customQuery('Peliculas', "SELECT P.* FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=0 AND R.Id_usuario=:id_usuario AND P.Pelicula LIKE :texto ORDER BY P.Id DESC LIMIT $offset, 20;", array('id_usuario'=>$_SESSION['s_user']['Id'], 'texto'=>'%'.$pa['q'].'%'), false);
			}
		}else{
				$rt = DBManager::customQuery("", "SELECT count(*) as totalRows FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=0 AND R.Id_usuario=:id_usuario",array('id_usuario'=>$_SESSION['s_user']['Id']) , false);	
				$totalRows = $rt[0]['totalRows'];
			$Peliculas= DBManager::customQuery('Peliculas', "SELECT P.* FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=0 AND R.Id_usuario=:id_usuario ORDER BY P.Id DESC LIMIT $offset, 20;",array('id_usuario'=>$_SESSION['s_user']['Id']) , false);	
		}
		
		
		$pg = new Pager();

		$pg->set('urlPattern', '/seedbox'.preg_replace('%/p/[0-9]+%i', '', $r->getPath()). '/p/{{page}}' );
		$pg->set('urlPatternFirstPage', '/seedbox'.preg_replace('%/p/[0-9]+%i', '', $r->getPath()));
		$pg->set('itemsPerPage', 20);
		$pg->set('page', $p);
		$pg->set('total', $totalRows);
		$pg->set('numLinks', 9);
		$this->tpl->assign('paginado', $pg->display(true));

		$this->tpl->assign('peliculas', $Peliculas);
		


		echo $this->renderAction("pasadas");
	}
	public function bajadas() {
		if ((int)$_SESSION['s_user']['Id']==0 && $this->checkCookie()==false  ) {
			header("Location: /seedbox/index/login");
			return true;
		}
		$this->tpl->assign('menu', array("6"=>' class="active"'));
		$r = Router::getInstance();
		$this->tpl->assign('action', $r->getAction());		
		$params = Router::getParams();

		for($i = 0, $l = count($params); $i<$l; $i = $i + 2) {
			$pa[$params[$i]] = urldecode($params[$i+1]);
		}	
		$p = max(1,(int)$r->getParam(1));
		$offset = ($p-1) * 20;

		$rt = DBManager::customQuery("", "SELECT count(*) as totalRows FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=5 AND R.Id_usuario=:id_usuario",array('id_usuario'=>$_SESSION['s_user']['Id']) , false);		
		$totalRows = $rt[0]['totalRows'];
		$Peliculas= DBManager::customQuery('Peliculas', "SELECT P.* FROM Peliculas P INNER JOIN Rel_pelicula_usuario R WHERE R.Id_pelicula=P.id AND  R.Estado=5 AND R.Id_usuario=:id_usuario ORDER BY P.Id DESC LIMIT $offset, 20;",array('id_usuario'=>$_SESSION['s_user']['Id']) , false);	
		
		$pg = new Pager();
		$pg->set('urlPattern', '/seedbox'.preg_replace('%/p/[0-9]+%i', '', $r->getPath()). '/p/{{page}}' );
		$pg->set('urlPatternFirstPage', '/seedbox'.preg_replace('%/p/[0-9]+%i', '', $r->getPath()));
		$pg->set('itemsPerPage', 20);
		$pg->set('page', $p);
		$pg->set('total', $totalRows);
		$pg->set('numLinks', 9);
		$this->tpl->assign('paginado', $pg->display(true));

		$this->tpl->assign('peliculas', $Peliculas);
		
		echo $this->renderAction("bajadas");
	}
	public function login()
	{
		return $this->renderAction("login");
	}
	public function logout()
	{
		session_destroy();
		header("Location: /seedbox/index/login");
	}	
	public function login_submit() 
	{
		if ((int)$_SESSION['s_user']['Id']==0 && $this->checkCookie()==false  ) {
			header("Location: /seedbox/index/login");
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
			header("Location: /seedbox/index/nuevas");
		} else {
			header("Location: /seedbox/index/login/error");
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
			header("Location: /seedbox/index/login/error");
		}		
	}	


	public function ver()
	{
		if ((int)$_SESSION['s_user']['Id']==0 && $this->checkCookie()==false  ) {
			header("Location: /seedbox/index/login");
		}
		$this->tpl->assign('menu', array("8"=>' class="active"'));
		$r = Router::getInstance();
		$id=$r->getParam(0);
		$Pelicula = DBManager::customQuery('Peliculas', "SELECT P.Id, P.Pelicula, P.Descripcion, P.Tipo, DATE_FORMAT(P.Fecha, '%d/%m/%Y   %k:%m:%s') as Fecha , U.Nombre FROM Peliculas P LEFT JOIN Usuarios U ON U.id=P.id_usuario WHERE P.Id = :id LIMIT 1" , array('id'=> $id), false);	
		$Pelicula=array_pop($Pelicula);		
		$this->tpl->assign( $Pelicula);

		//Busco los comentarios

		$comentarios = DBManager::customQuery('Comentarios', "SELECT C.Id, C.Comentario,  DATE_FORMAT(C.Fecha, '%d/%m/%Y   %k:%m:%s') as Fecha, U.Nombre FROM Comentarios C LEFT JOIN Usuarios U ON U.id=C.id_usuario WHERE C.id_pelicula=:id ", array('id'=>$id), false);
		$this->tpl->assign('comentarios', $comentarios);

		//Si es la primera vez lo inserto en la tabla

		$Relacion=DBManager::selectClassByParam('Rel_pelicula_usuario',  array('id_pelicula' =>$id, 'Id_usuario'=>$_SESSION['s_user']['Id']), false);

		if(!count($Relacion)>0){
		
			$Relacion = new Rel_pelicula_usuario();
			$Relacion->setId_usuario((int)$_SESSION['s_user']['Id']);
			$Relacion->setId_pelicula($id);
			$Relacion->setEstado(0);
			$Relacion->setTipo(0);
			DBManager::Insert($Relacion);
		}else{

			$Relacion=array_pop($Relacion);	
			if($Relacion['Tipo']==1){
				$RelUpdate= DBManager::selectClassById('Rel_pelicula_usuario', $Relacion['Id'], true);
				$RelUpdate->setTipo(0);
				DBManager::Update($RelUpdate);
			}
		}

		return $this->renderAction("ver");
	}

	public function setEstado()
	{
		$router= Router::getInstance();	
		$id_pelicula = (int)$router->getParam(0);
		$estado = (int)$router->getParam(1);

		$Relacion=DBManager::selectClassByParam('Rel_pelicula_usuario',  array('id_pelicula' =>$id_pelicula, 'Id_usuario'=>$_SESSION['s_user']['Id']), false);
		$Relacion=array_pop($Relacion);	
		if(!count($Relacion)>0){	
				
			$Relacion = new Rel_pelicula_usuario();
			$Relacion->setId_usuario($_SESSION['s_user']['Id']);
			$Relacion->setId_pelicula($id_pelicula);
			$Relacion->setEstado($estado);
			$Relacion->setTipo(0);
			DBManager::Insert($Relacion);
		}else{
			$RelUpdate= DBManager::selectClassById('Rel_pelicula_usuario', $Relacion['Id'], true);
			$RelUpdate->setEstado($estado);
			$RelUpdate->setTipo(0);
			DBManager::Update($RelUpdate);
		}
		$r = array('status' => 'ok');
		echo json_encode($r);
		return false;		
	}

	public function agregar()
	{
		if ((int)$_SESSION['s_user']['Id']==0 && $this->checkCookie()==false  ) {
			header("Location: /seedbox/index/login");
		}
		$this->tpl->assign('menu', array("3"=>' class="active"'));

		$r = Router::getInstance();
		$id=$r->getParam(0);
		if($id>0){
			$Pelicula = DBManager::customQuery('Peliculas', "SELECT P.Id, P.Pelicula, P.Descripcion, DATE_FORMAT(P.Fecha, '%d/%m/%Y   %k:%m:%s') as Fecha , U.Nombre FROM Peliculas P LEFT JOIN Usuarios U ON U.id=P.id_usuario WHERE P.Id = :id LIMIT 1" , array('id'=> $id), false);	
			$Pelicula=array_pop($Pelicula);			
			$this->tpl->assign( $Pelicula);
		}

	
		return $this->renderAction("nueva");		
	}

	public function submit_pelicula()
	{
		if ((int)$_SESSION['s_user']['Id']==0 && $this->checkCookie()==false  ) {
			header("Location: /seedbox/index/login");
		}
		$update = isset($_POST['Id']) && (int)$_POST['Id'] != 0;

		
		if ($update) {

			$Pelicula = DBManager::selectClassById('Peliculas', (int)$_POST['Id'], true);
		} else {
			
			$Pelicula = new Peliculas();
			$Pelicula->setFecha(date("Y-m-d H:i:s"));
			$Pelicula->setId_usuario($_SESSION['s_user']['Id']);
			
		}

		$Pelicula->setPelicula($_POST['Pelicula']);
		$Pelicula->setDescripcion($_POST['Descripcion']);
		$Pelicula->setTipo((int)$_POST['Tipo']);

		try{			
			if ($update) {
				DBManager::Update($Pelicula);
			}else{
				$id_pelicula=DBManager::Insert($Pelicula);
				//si es nueva la agrego en la tabla relaciones

				$Relacion = new Rel_pelicula_usuario();
				$Relacion->setId_usuario($_SESSION['s_user']['Id']);
				$Relacion->setId_pelicula($id_pelicula);
				$Relacion->setEstado(1);
				$Relacion->setTipo(0);
				DBManager::Insert($Relacion);
			}
					
		} catch (Exception $e) {
			
			$r = array('status' => 'error','info'=> 'Error, al insertar la pelicula'.$e->getMessage());
			echo json_encode($r);
			
		}
		$r = array('status' => 'ok','info'=> 'La película se dío de alta correctamente');
		echo json_encode($r);		
	}


	public function submit_comentario()
	{
		DBManager::beginTransaction();

		$Comentario = new Comentarios();
		$Comentario->setFecha(date("Y-m-d H:i:s"));
		$Comentario->setId_usuario($_SESSION['s_user']['Id']);	
		$Comentario->setId_pelicula($_POST['ID_pelicula']);
		$Comentario->setComentario($_POST['Comentario']);
		$Comentario->setTipo($_POST['Tipo']);
		try{
			DBManager::Insert($Comentario);			
					
		} catch (Exception $e) {
			
			$r = array('status' => 'error','info'=> 'Error, al insertar el Comentario'.$e->getMessage());
			echo json_encode($r);
			
		}

		if($_POST['Tipo']==1){
			//elimino para que vean como nueva los que la querían
			
			$RelDelete= DBManager::customQuery('Rel_pelicula_usuario', "SELECT R.Id FROM Rel_pelicula_usuario R WHERE R.Id_pelicula=:id_pelicula AND (R.Estado=1 OR R.Estado=5)", array('id_pelicula'=>$_POST['ID_pelicula']), false);
			
			if(count($RelDelete)>0){
				foreach ($RelDelete as $key => $value) {
					try{
						$t = DBManager::selectClassById('Rel_pelicula_usuario', intval($value['Id']), true);
						$t->setTipo(1);
						DBManager::Update($t);
					} catch (Exception $e) {
						DBManager::rollback();
						$r = array('status' => 'error','info'=> 'Error, al eliminar las relaciones'.$e->getMessage());
						echo json_encode($r);
						
					}
				}
			}else{
				echo 'no hay nada';
			}

		}
		DBManager::commit();
		$r = array('status' => 'ok','info'=> 'El comentario se dío de alta correctamente');
		echo json_encode($r);		
	}


	public function pasoTodo()
	{
		if ((int)$_SESSION['s_user']['Id']>0 ) {
			$Peliculas= DBManager::customQuery('Peliculas', "SELECT P.* FROM Peliculas P WHERE NOT EXISTS (SELECT id_usuario FROM Rel_pelicula_usuario R WHERE P.id=R.id_pelicula AND R.id_usuario=:id_usuario AND R.Tipo=0 ) ", array('id_usuario'=>$_SESSION['s_user']['Id']), false);	
			foreach ($Peliculas as $key => $value) {
				$Relacion = new Rel_pelicula_usuario();
				$Relacion->setId_usuario($_SESSION['s_user']['Id']);
				$Relacion->setId_pelicula($value['Id']);
				$Relacion->setEstado(0);
				$Relacion->setTipo(0);
				DBManager::Insert($Relacion);				
			}
			$r = array('status' => 'ok');
			echo json_encode($r);
			return false;

		}
	}

	public function perfil()
	{
		if ((int)$_SESSION['s_user']['Id']==0 && $this->checkCookie()==false  ) {
			header("Location: /seedbox/index/login");
		}

		$Usuario = DBManager::selectClassById('Usuarios', (int)$_SESSION['s_user']['Id'], false);	
		

		$this->tpl->assign( $Usuario);
		return $this->renderAction("perfil");
	}


	public function submit_perfil()
	{
		if ((int)$_SESSION['s_user']['Id']==0 && $this->checkCookie()==false  ) {
			header("Location: /seedbox/index/login");
		}
		$update = isset($_SESSION['s_user']['Id']) && (int)$_SESSION['s_user']['Id'] != 0;

		
		if ($update) {

			$Usuario = DBManager::selectClassById('Usuarios', (int)$_SESSION['s_user']['Id'], true);	
			$Usuario->setNombre($_POST['Nombre']);
			$Usuario->setEmail($_POST['Email']);
			$Usuario->setPassword($_POST['Password']);
			DBManager::Update($Usuario);
			$r = array('status' => 'ok');
			echo json_encode($r);
			return false;			

		}else	
			header("Location: /seedbox/index/login");
	}	
}