<?php
abstract class BaseController {


	protected $tpl = null;

	protected $baseDir;
	protected $baseUrl;

	protected $model;

	public final function __construct($baseDir) {
		$controllerName = $this->getControllerName();

		
		#Determinate protocol	
		if (isset($_SERVER['REQUEST_SCHEME']))
			$protocol = $_SERVER['REQUEST_SCHEME'];
		elseif (isset($_SERVER['HTTPS']))
			$protocol = ($_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
		else 
			$protocol = 'http';


		$this->baseDir = $baseDir;
		$this->baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $this->baseDir .'/';

		
		#Template Instance
		$this->tpl = new RainTPL();
		$this->tpl->configure( 'base_url', $this->baseUrl);

		# Set Global Template Variables
		$this->tpl->assign(array(
			'titulo' 		=> ucwords(str_replace('-', ' ', Router::getControllerSeo())),
			'controller'	=> Router::getControllerSeo(),
			'action'		=> Router::getActionSeo(),
			'base_path'		=> $this->baseDir,
			'base_url'		=> $protocol . '://' . $_SERVER['HTTP_HOST'] . $this->baseDir .'/'
		));
	}

	public function getControllerName()
	{
		return str_replace('Controller', '', get_class($this));
	}
	
	public function renderAction($action)
	{
		return $this->tpl->draw($action, true);
	}

	public function mysql2date($fecha){ // de aaaa-mm-dd a dd/mm/aaaa 
	    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
	    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
	    return $lafecha;
	}

	private function evalConditionals($varName, $value, $template)
	{

		if (preg_match('/<%\?'.$varName.'\?(.*?)<%\?else\?%>(.*?)\?%>/s', $template, $regs)) {
			if ($value === true)
				$template = str_replace($regs[0], $regs[1], $template);
			 else
				$template = str_replace($regs[0], $regs[2], $template);
		}

		return $template;
	}

	public function evaluateArray($array_replace, $template) {
		if (!is_array($array_replace)) return false;

		#iterate all Array values
		foreach($array_replace as $varName => $value) {
			if (is_array($value)) {				

				$template = $this->evalArray($varName, $value, $template);				
			}
		}

		#iterate all Bool values
		foreach($array_replace as $varName => $value) {
			if (is_bool($value)) $template = $this->evalConditionals($varName, $value, $template);
		}

		#Then the single values
		foreach($array_replace as $varName => $value) {
			$template = str_replace('#{'.$varName.'}', $value, $template);
		}

		return $template;
	}

	private function evalArray($arrayName, $data, $template) {

		if (preg_match(
			'/\('.$arrayName.'(\|([0-9]+))?%(
			        (
			            ([^()]+)
			        |
			            (
			             \([\w]+(\|([0-9]+))?%([^()]+)\)
			            )
			        )*
			)\)
			/sx',
			$template, $regs)) {

			//echo $arrayName;
			$miniTemplate = $regs[3];
			$limitTemplate = (!empty($regs[2])) ? $regs[2] : false;
			$template = preg_replace('/\('.$arrayName.'(\|([0-9]+))?%(
			        (
			            ([^()]+)
			        |
			            (
			             \([\w]+(\|([0-9]+))?%([^()]+)\)
			            )
			        )*
			)\)
			/sx', '#{'.$arrayName.'Result}', $template);
		} else {
			#if couldn't parse the array on the template the return it untouched
			return $template;
		}

		$arrayResult = '';
		$i = 0;
		foreach($data as $key => $value) {
			if ($limitTemplate  && ($limitTemplate == $i++)) break;
			$arrayResult.= $this->evaluateArray($value, $miniTemplate);
		}

		$res = $this->evaluateArray(array($arrayName.'Result' => $arrayResult), $template);
		return $res;
	}	

	public function utf8_encode_deep(&$input) {
		if (is_string($input)) {
			$input = utf8_encode($input);
		} else if (is_array($input)) {
			foreach ($input as &$value) {
				$this->utf8_encode_deep($value);
			}
			
			unset($value);
		} else if (is_object($input)) {
			$vars = array_keys(get_object_vars($input));
			
			foreach ($vars as $var) {
				$this->utf8_encode_deep($input->$var);
			}
		}
	}


}