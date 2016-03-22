<?php


/**
 * Class Pagination
 * 
 * By Jacob DeHart - Modified By Pablo Diaz
 * 
 * 
 * Sample Usage
 * 
 * $paging = new Pagination();
 * $paging->set('urlPattern','site.php?page=%page%');
 * $paging->set('itemsPerPage',10);
 * $paging->set('page',max(1,intval($_GET['page'])));
 * $paging->set('total',3000);
 * $paging->set('nextLabel','Next Page');
 * $paging->set('prevLabel','Previous Page');
 * $paging->set('activeClass','selected');
 * $paging->set('delimiter','');
 * $paging->set('numLinks',9);
 *
 */

class Pager {
	var $output = '';    
	var $options = array(
		'urlPattern' => '',
		'urlPatternFirstPage' => '',
		'itemsPerPage' => '',
		'page' => '',
		'total' => '',
		'numLinks' => '',
		'nextLabel' => 'Siguiente',
		'prevLabel' => 'Anterior',
		'prevClass' => 'prev',
		'nextClass' => 'next',
		'activeClass' => 'selected'
		);

	function set($who,$what){
		$this->output = '';
		$this->options[$who] = $what;
	}

	function checkValues(){
		$errors = array();
		if($this->options['itemsPerPage']=='') $errors[] = 'Invalid itemsPerPage value';
		if($this->options['page']=='') $errors[] = 'Invalid page value';
		if($this->options['total']=='') $errors[] = 'Invalid total value';
		if($this->options['numLinks']=='') $errors[] = 'Invalid numLinks value';
	}
	function display($return = false){
		$this->checkValues();
		if($this->output=='') $this->generateOutput();
		if(!$return) echo $this->output;
		else return $this->output;
	}
	function generateOutput(){
		$elements = array();
		$num_pages = ceil($this->options['total']/$this->options['itemsPerPage']);
		$front_links = ceil($this->options['numLinks']/2);
		$end_links = floor($this->options['numLinks']/2);
		
		if($this->options['page'] > $num_pages){ $this->set('page',1); }

		$start_page = max(1,($this->options['page']-$front_links+1));
		$end_page = min($this->options['numLinks'] + $start_page-1,$num_pages);

		if($this->options['page'] > 1){
			$elements[] = $this->generate_link($this->options['page']-1,$this->options['prevLabel'], $this->options['prevClass']);
		}

		for($i=$start_page;$i<=$end_page;$i++){
			$elements[] = $this->generate_link($i);
		}

		if($this->options['page'] < $num_pages){
			$elements[] = $this->generate_link($this->options['page']+1,$this->options['nextLabel'],  $this->options['nextClass']);
		}

		if (count($elements) == 1) return "";
		$this->output = "<ul>" . implode('', $elements) . "</ul>";
	}
	function generate_link($page, $label='', $class=''){

		if ($page != 1)
			$url = str_replace('{{page}}',$page,$this->options['urlPattern']);
		else 
			$url = $this->options['urlPatternFirstPage'];

		if($label=='') $label=$page;
		$html = "<li".($class!='' ? " class=\"$class\"" : "")." ".(($this->options['activeClass']!='' && $page == $this->options['page'])?"class=\"{$this->options['activeClass']}\" ":"")."><a href=\"{$url}\">{$label}</a></li>";
		return $html;
	}
}