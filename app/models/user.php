<?php

/**
 *  Classe responsável por representar a tabela 'user' através de ORM.
 *  @author fabiozoroastro
 *
 */
class User extends AppModel {

   var $name = 'User';
   var $useTable = 'user';
   var $primaryKey = 'id';

   function isSamePassword($dbPass, $entryPass) {
    return ($dbPass == md5($entryPass)) ;
   }

}

?>
