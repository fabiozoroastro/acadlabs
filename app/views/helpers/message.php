<?php
/**
 *
 * Helper para trabalhar com mensagens Flash
 * @author fabiozoroastro
 *
 */
class MessageHelper extends Helper
{
	var $helpers = array('Session');
	var $msgs = 'msgs';
	var $warnings = 'warnings';
	var $errors = 'errors';
	
	
	function displayMessages(){
		$arr = $this->Session->read($this->msgs);
		$this->Session->delete($this->msgs);
		
		if (isset($arr)){
			$result = $this->prepareMessage($arr, $this->msgs);
			echo ($result);
		}
	}

	function displayWarnings(){
		$arr = $this->Session->read($this->warnings);
		$this->Session->delete($this->warnings);

		if (isset($arr)){
			$result = $this->prepareMessage($arr, $this->warnings);
			echo ($result);
		}
	}

	function displayErrors(){
		$arr = $this->Session->read($this->errors);
		$this->Session->delete($this->errors);

		if (isset($arr)){
			$result = $this->prepareMessage($arr, $this->errors);
			echo ($result);
		}
	}

	private function prepareMessage($arr, $type){
		$show = "var notice = '<div class=\\\"notice\\\">";

		$show.= " <div class=\\\"$type\\\">";
		//$show.= " <h4>Atenção</h4>";
		foreach ($arr as $msg){
			$show.= " <p>";
			$show.= $msg;
			$show.= "</p>";
		}
			
		$show.= " </div>";
		$show.= " <div class=\\\"".$type."_bottom\\\">";
		$show.= " </div>";
		$show.= " </div>';";
		$show.= " $( notice ).purr({removeTimer: 4000, usingTransparentPNG: true});";


		$result = "<script>";
		$result .= "eval(\"$show\")";
		$result .= "</script>";
		return $result;
	}
}

?>