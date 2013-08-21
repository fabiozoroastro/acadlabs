<?php

/**
 * Classe responsavel por controlar as requisições da funcionalidade de cadastro de Softwares.
 * @author fabiozoroastro
 */
class LabsoftsController extends AppController {

	var $name = 'Labsofts';

	var $uses = array( 'Labsoft', 'Software', 'Laboratory');

	var $helpers = array('Html', 'Form', 'Javascript', 'Message');

	/**
	 *
	 * Realiza a associacao dos softwares ao laboratorio escolido
	 * @author fabiozoroastro
	 */
	public function add(){

		$laboratories = $this->Laboratory->find('list', array('order' => 'Laboratory.name')) ;
		$this->set('laboratories', $laboratories);

		if (!empty($this->data)) {
			//checkedLab = Laboratorio selecionado
			$checkedLab = $this->data['Labsoft']['laboratory_id'];
			// checkedSofts = Softwares selecionados
			$checkedSofts = isset($this->data['software_id']) ? $this->data['software_id'] : array();
			//labsoftToSave = Auxiliar para armazenar objeto que sera salvo
			$labsoftToSave = null;
			//labExists = Softwares ja associados
			$labsExists = $this->Labsoft->getMySoftwares($checkedLab);


			if( isset($checkedSofts) && $checkedSofts != null && count($checkedSofts) > 0){
				foreach ($checkedSofts as $obj) {
					//associated = false(Pronto para criar associacao)
					$associated = false;
					foreach ($labsExists as $keyLab => $labExist) {
						if($labExist['Labsoft']['software_id'] == $obj){
							//associated = true(Nao faz nada pois continua existindo)
							$associated = true;
							unset($labsExists[$keyLab]);
						}
					}
					if( !$associated ){
						$labsoftToSave = new Labsoft();
						$labsoftToSave->software_id = $obj;
						$labsoftToSave->laboratory_id = $checkedLab;
						$this->Labsoft->save($labsoftToSave);
					}

				}
			}
			$this->removeNoMoreExists($labsExists);
			//se chegou nesse ponto é pq foi salvo com sucesso!
			$this->Message->addMsg("Software(s) associado(s) com sucesso.");
		}

	}

	/**
	 * Remove os itens presentes na lista que nao foram selecionados
	 * @author fabiozoroastro
	 * @param unknown_type $labsExists
	 */
	private function removeNoMoreExists($labsExists){

		if($labsExists != null && count ($labsExists)){
			foreach ($labsExists as $obj){
				$this->Labsoft->delete( $obj['Labsoft']['id'] );
			}
		}
	}
	/**
	 *
	 * Seta na request uma lista de softwares a serem exibidos para o laboratorio informado
	 * @param unknown_type $lab
	 */
	public function softs($lab = null){
		$softwares = array();
		$mySoftwares = array();
		if ($lab != null ){
			$softwares = $this->Software->find('all', array('fields' => array('Software.id','Software.name', 'Software.active'), 'order' => 'Software.name')) ;
			$mySoftwares = $this->Labsoft->getMySoftwares($lab);
		}

		$this->set('softwares', $softwares);
		$this->set('mySoftwares', $mySoftwares);
	}

	
	/**
	 * 
	 * Retorna os registros de Softwares por laboratorio
	 * @param Long $labId Id do laboratorio
	 */
	public function rel($labId){
		$this->layout = 'rel_layout';
		$softwares = $this->Software->findByLaboratory($labId);
		$lab = $this->Laboratory->findById($labId);
		$this->set('lab', $lab);
		$this->set('softwares', $softwares);
	}
}

?>