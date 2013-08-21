<?php

/**
 *  Classe responsável por representar a tabela 'Disciplina' através de ORM.
 *  @author fabiozoroastro
 *
 */
class Discipline extends AppModel {

	var $name = 'Discipline';
	var $useTable = 'discipline';
	var $primaryKey = 'id';
	var $displayField = 'name';
	
	var $validate = array(
 	'name' => array( 					
 					'between' => array(
 										'rule' => array('between', 1, 30),
 										'message' => 'Nome: Entre 1 e 30 caracteres'
 										)
 										
 					),
 	'course_id' => array(
 					'numeric' => array(
 										'rule' => 'numeric',
 										'required' => true,
 										'message' => 'Curso: obrigatório'
 										)
 					)								
 	);
 	
}

?>
