<?php

/**
 *  Classe responsável por representar a tabela 'laboratory' através de ORM.
 *  @author fabiozoroastro
 *
 */
class Laboratory extends AppModel {

	var $name = 'Laboratory';
	var $useTable = 'laboratory';
	var $primaryKey = 'id';

	var $validate = array(
 	'name' => array(
 					'alphanumeric' => array(
 											'rule' => 'alphaNumeric',
 											'required' => true,
 											'message' => 'Nome: Letras e números somente'
 											),
 					'between' => array(
 										'rule' => array('between', 1, 10),
 										'message' => 'Nome: Entre 1 e 10 caracteres'
 										),
 					/* validacao de tipo duplicidade */					
 					),
 	'number_computers' => array(
 					'numeric' => array(
 											'rule' => 'numeric',
 											'required' => true,
 											'message' => 'Nº de Computadores: Somente números'
 											)
 					)				
 	);
}

?>
