<?php

App::import('Controller', 'CrudController', false);
/**
 * Classe responsavel por controlar as requisições da funcionalidade de cadastro de Softwares.
 * @author fabiozoroastro
 */
class SoftwaresController extends CrudController {

	var $name = 'Softwares';
	var $paginate = array('order' => array('Software.name'), 'limit' => '10');


	/**
	 * (non-PHPdoc)
	 * @see app/CrudController::getModel()
	 * @author fabiozoroastro
	 */
	protected function getModel(){
		return $this->Software;
	}


	protected function getMsgSucess(){
		return 'Software salvo com sucesso';
	}

	/**
	 * (non-PHPdoc)
	 * @see app/CrudController::findExecute()
	 */
	protected function findExecute($q){
		$this->paginate = array('order' => array('Software.name'), 'limit' => '10', 'conditions' => array('Software.name LIKE' => "$q%"));
	}


	/**
	 * Sobreescrito para exibir os botões:
	 * - New Software
	 * @author fabiozoroastro
	 * @override
	 */
	protected function showButtonList() {
		parent::showButtonList();
		$buttonList = array(
		array('id' => 'addSoft', 'text' => "Novo Software", 'method' => $this->base.'/softwares/add'));
		$this->set('buttonList', $buttonList);
	}

	/**
	 * Sobreescrito para utilizar o mecanismo de pesquisa
	 * @author fabiozoroastro
	 * @override
	 */
	protected function useFind() {
		$this->set('nameFilter', 'Software');
		return true;
	}

}

?>