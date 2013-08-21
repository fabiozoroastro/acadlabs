<?php

/**
 *  Classe responsável por representar a tabela 'period' através de ORM.
 *  @author fabiozoroastro
 *
 */
class Period extends AppModel {

	var $name = 'Period';
	var $useTable = 'period';
	var $primaryKey = 'id';

	var $displayField = "begin";
	/**
	 *
	 * Retorna o codigo agrupando o turno, dia e horario
	 */
	public function getCode() {

		return $result;
	}

}

?>
