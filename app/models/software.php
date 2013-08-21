<?php

/**
 *  Classe responsável por representar a tabela 'software' através de ORM.
 *  @author fabiozoroastro
 *
 */
class Software extends AppModel {

	var $name = 'Software';
	var $useTable = 'software';
	var $primaryKey = 'id';

	var $validate = array(
 	'name' => array( 					
 					'between' => array(
 										'rule' => array('between', 1, 30),
 										'message' => 'Nome: Entre 1 e 30 caracteres'
 										),
 					/* validacao de tipo duplicidade */					
 					)				
 	);
 	
 	/**
 	 * 
 	 * Retorna os registros de Software para o laboratorio informado
 	 * @param Long $id do Laboratorio
 	 */
 	public function findByLaboratory($id){
 		$sql = " select Software.* from software Software";
 		$sql .= " inner join labsoft Labsoft on";
 		$sql .= "    labsoft.software_id = Software.id";
 		$sql .= "    and labsoft.laboratory_id = $id";
 		return $this->query($sql);
 	}
}

?>
