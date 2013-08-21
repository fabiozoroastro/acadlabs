<?php

App::import('Controller', 'CrudController', false);
/**
 * Classe responsavel por controlar as requisições da funcionalidade de cadastro de Softwares.
 * @author fabiozoroastro
 */
class PeriodsController extends CrudController {

	var $name = 'Periods';
	var $uses = array( 'Reserve', 'Period');
	var $paginate = array('order' => array('Period.begin'), 'limit' => '10');


	/**
	 * (non-PHPdoc)
	 * @see app/CrudController::getModel()
	 * @author fabiozoroastro
	 */
	protected function getModel(){
		return $this->Period;
	}


	protected function getMsgSucess(){
		return 'Período salvo com sucesso';
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
		array('id' => 'addPeriod', 'text' => "Novo Período", 'method' => $this->base.'/periods/add'));
		$this->set('buttonList', $buttonList);
	}

	/**
	 * Sobreescrito para NAO utilizar o mecanismo de pesquisa
	 * @author fabiozoroastro
	 * @override
	 */
	protected function useFind() {
		return false;
	}

	/**
	 * Ponto de extensao para salvar informacoes submetidas por um formulario
	 * @pattern Template-Method
	 * @param unknown_type $id
	 */
	protected function beforeSave( $id = null ){
		$halfYears = $this->Period->find('all', array('order' => 'Period.begin')) ;
		$this->set('halfYears',$halfYears);

	}

	/**
	 * (non-PHPdoc)
	 * @see app/CrudController::add()
	 */
	public function add() {
		$this->beforeSave();
		if (!empty($this->data)) {
			$ok = true;

			if($this->data['Period']['begin'] == null || $this->data['Period']['end'] == null){
				$this->Period->invalidate('period', 'Período: obrigatório');
				$ok = false;
				$this->Message->addError('Ocorreu um erro na gravação do registro.');
			}

			if( $ok ){
				$date = explode("/", $this->data['Period']['begin']);
				$begin = $date[2]."-".$date[1]."-".$date[0];
				$this->data['Period']['begin'] = $begin;

				$date = explode("/", $this->data['Period']['end']);
				$end = $date[2]."-".$date[1]."-".$date[0];
				$this->data['Period']['end'] = $end;
				$periodImport = $this->data['Period']['import'];
				$this->data['Period']['import'] = null;

				$this->Period->create();
				if ($this->Period->save($this->data)) {
					$this->importReserves($this->Period->id, $periodImport);
					$this->Message->addMsg($this->getMsgSucess());
					$this->redirect(array('action'=>'add'));
				}
			}
		}

	}

	
	/**
	 * 
	 * Realiza a importacao das reservas jah existentes para o novo periodo
	 * @param unknown_type $newPeriod
	 * @param unknown_type $periodImport
	 */
	protected function importReserves($newPeriod, $periodImport){

		$this->log("Importando as reservas do período de id $periodImport para $newPeriod", 'debug');

		$reserves = $this->Reserve->find('all', array('order' => 'Reserve.date', 'conditions' => array("Reserve.period_id = $periodImport")));
		
		$firstReserve = null;
		
		foreach( $reserves as $r){
			
			
			$r['Reserve']['id'] = null;
			$r['Reserve']['period_id'] = $newPeriod;
			//TODO Este é o local onde deverá ser setada a data equivalente no próximo período. Eu não fiz a implementação pois fiquei confuso
			// quanto às reservas avulsas.
			//$r['Reserve']['date'] = $this->nextDay(); 
			
			$this->Reserve->save($r);
		}
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see app/CrudController::edit()
	 */
	public function edit($id = null) {

		$this->beforeSave( $id );

		if (!empty($this->data)) {
			$ok = true;
			if($this->data['Period']['begin'] == null || $this->data['Period']['end'] == null){
				$this->Period->invalidate('period', 'Período: obrigatório');
				$ok = false;
				$this->Message->addError('Ocorreu um erro na gravação do registro.');
			}
			if($ok){
				$date = explode("/", $this->data['Period']['begin']);
				$begin = $date[2]."-".$date[1]."-".$date[0];
				$this->data['Period']['begin'] = $begin;

				$date = explode("/", $this->data['Period']['end']);
				$end = $date[2]."-".$date[1]."-".$date[0];
				$this->data['Period']['end'] = $end;
				parent::edit($id);
			}

		}
	}


}

?>