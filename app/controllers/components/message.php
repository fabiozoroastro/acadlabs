<?php
/**
 *
 * Classe de componente de mensagens.
 * @author fabiozoroastro
 *
 */
class MessageComponent extends Object{

	var $components = array('Session');

	/**
	 *
	 * Adiciona mensagem de sucesso
	 * @param unknown_type $message
	 */
	function addMsg($message){
		$this->addMessage('msgs',$message);
	}

	/**
	 *
	 * Adicona uma mensagem de alerta
	 * @param $message
	 */
	function addWarning($message){
		$this->addMessage('warnings',$message);
	}

	/**
	 * Adiciona uma mensagem de erro
	 * @param unknown_type $message
	 */
	function addError($message){
		$this->addMessage('errors',$message);
	}

	private function addMessage($type, $message){
		$arr = $this->Session->read($type);
		$arr[] = $message;
		$this->Session->write($type, $arr);
	}

}
?>