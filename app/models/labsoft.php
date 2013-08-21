<?php

/**
 *  Classe responsável por representar a tabela 'labsoft' através de ORM.
 *  @author fabiozoroastro
 *
 */
class Labsoft extends AppModel {

	var $name = 'Labsoft';
	var $useTable = 'labsoft';
	var $primaryKey = 'id';



	/**
	 * Realiza a pesquisa em Labsoft pelo id do laboratorio
	 * @author fabiozoroastro
	 */
	public function getMySoftwares($lab){
		return $this->find('all', array('conditions' => array('Labsoft.laboratory_id =' => "$lab"))) ;
	}
}

?>
