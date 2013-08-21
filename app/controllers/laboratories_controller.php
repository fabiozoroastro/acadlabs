<?php

App::import('Controller', 'CrudController', false);
/**
 * Classe responsavel por controlar as requisições da funcionalidade de cadastro de laboratorios.
 * @author fabiozoroastro
 */
class LaboratoriesController extends CrudController {

	var $name = 'Laboratories';
	var $paginate = array('order' => array('Laboratory.name'), 'limit' => '10');


	/**
	 * (non-PHPdoc)
	 * @see app/CrudController::getModel()
	 * @author fabiozoroastro
	 */
	protected function getModel(){
		return $this->Laboratory;
	}


	protected function getMsgSucess(){
		return 'Laboratório salvo com sucesso';
	}

	/**
	 * (non-PHPdoc)
	 * @see app/CrudController::beforeCreateForm()
	 * @author fabiozoroastro
	 */
	protected function beforeSave( $id = null ){
		if(isset($this->data) && $this->data != null){
			$this->data['Laboratory']['name'] = strtoupper($this->data['Laboratory']['name']);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see app/CrudController::findExecute()
	 */
	protected function findExecute($q){
		$q = strtoupper($q);
		$this->paginate = array('order' => array('Laboratory.name'), 'limit' => '10', 'conditions' => array('Laboratory.name LIKE' => "$q%"));
	}

	
	/**
	 * Sobreescrito para exibir os botões:
	 * - New Laboratorio
	 * @author fabiozoroastro
	 * @override
	 */
	protected function showButtonList() {
		parent::showButtonList();
		$buttonList = array(
					array('id' => 'addLab', 'text' => "Novo Laboratório", 'method' => $this->base.'/laboratories/add'),
					array('id' => 'labsoft', 'text' => "Associar Softwares", 'method' => $this->base.'/labsofts/add')
					);
				
		$this->set('buttonList', $buttonList);
	}

	/**
	 * Sobreescrito para utilizar o mecanismo de pesquisa
	 * @author fabiozoroastro
	 * @override
	 */
	protected function useFind() {
		$this->set('nameFilter', 'Laboratório');
		return true;
	}

}

?>