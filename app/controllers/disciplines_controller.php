<?php

App::import('Controller', 'CrudController', false);
/**
 * Classe responsavel por controlar as requisições da funcionalidade de cadastro de disciplinas.
 * @author fabiozoroastro
 */
class DisciplinesController extends CrudController {

	var $name = 'Disciplines';
	var $paginate = array('order' => array('Discipline.name'), 'limit' => '10');

	var $uses = array( 'Discipline', 'Course');

	/**
	 * (non-PHPdoc)
	 * @see app/CrudController::beforeCreateForm()
	 * @author fabiozoroastro
	 */
	protected function beforeSave( $id = null ){

		$this->set('courses', $this->Course->find('list', array('order' => 'Course.name')) );
	}

	/**
	 * (non-PHPdoc)
	 * @see app/CrudController::findExecute()
	 */
	protected function findExecute($q){
		$this->paginate = array('order' => array('Discipline.name'), 'limit' => '10', 'conditions' => array('Discipline.name LIKE' => "$q%"));
	}


	/**
	 * (non-PHPdoc)
	 * @see app/CrudController::getModel()
	 * @author fabiozoroastro
	 */
	protected function getModel(){
		return $this->Discipline;
	}


	protected function getMsgSucess(){
		return 'Disciplina salva com sucesso';
	}

	/**
	 * Sobreescrito para exibir os botões:
	 * - Nova Disciplina
	 * @author fabiozoroastro
	 * @override
	 */
	protected function showButtonList() {
		parent::showButtonList();
		$buttonList = array(
		array('id' => 'addLab', 'text' => "Nova Disciplina", 'method' => $this->base.'/disciplines/add'));
		$this->set('buttonList', $buttonList);
	}

	/**
	 * Sobreescrito para utilizar o mecanismo de pesquisa
	 * @author fabiozoroastro
	 * @override
	 */
	protected function useFind() {
		$this->set('nameFilter', 'Disciplina');
		return true;
	}

}

?>