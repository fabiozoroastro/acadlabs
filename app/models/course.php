<?php

/**
 *  Classe responsável por representar a tabela 'Course' através de ORM.
 *  @author fabiozoroastro
 *
 */
class Course extends AppModel {

	var $name = 'Course';
	var $useTable = 'course';
	var $primaryKey = 'id';

	var $displayField = 'name';

}

?>
