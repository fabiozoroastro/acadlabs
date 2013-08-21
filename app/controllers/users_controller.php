<?php

/**
 * Classe responsavel por controlar as requisições da funcionalidade de cadastro de laboratorios.
 * @author fabiozoroastro
 */
class UsersController extends AppController {

	//var $scaffold;
	var $layout = 'login';
	var $helpers = array('Html', 'Form', 'Javascript', 'Time');
	var $name = 'Users';

	/**
	 * Metodo responsavel por registrar o usuário na sessão e conceder acesso às funcionalidades restristas do sistema
	 * @author fabiozoroastro
	 */
	function login() {

		$this->pageTitle = "Login";
			
		if (!empty($this->data)) {

			$firstAccess = $this->Session->read('firstAccess');
			$this->Session->delete('firstAccess');

			if($firstAccess){
				$this->data['User']['name'] = 'undefined';
				$this->data['User']['password'] = md5($this->data['User']['password']);
				$this->User->save($this->data);
				$usr = $this->User->find("first");
				$this->ok($usr);

			}else{
				$someone = $this->User->find("first", array('conditions' => "email = '" . $this->data['User']['email'] . "' and active = 1"));
				if (!empty($someone['User']['email']) && $this->User->isSamePassword($someone['User']['password'], $this->data['User']['password'])) {
					$this->ok($someone);
				} else {
					$this->Session->setFlash(__('Usuário ou senha inválidos!', true));
				}
			}
		}else{
			//se nao for identificado nenhum usuario no primeiro acesso.
			$usr = $this->User->find("first");
			if( $usr == null ){
				$this->Session->write('firstAccess', true);
			}

		}
	}

	/**
	 * Registra o usuario na sessão e redireciona para a tela principal do sistema
	 * @param $someone
	 */
	private function ok($someone){
		$this->Session->write('user', $someone);
		$this->redirect(array('controller' => 'reserves', 'action' => 'calendar'));
	}

	function logout() {
		$this->Session->delete('user');
		$this->Session->setFlash(__('Sessão encerrada!', true));
		$this->redirect(array('controller' => 'users', 'action' => 'login'));
	}

	/**
	 *
	 * Realiza a edicao do registro e redireciona para a tela inicial do UC
	 * @param unknown_type $id
	 */
	public function edit($id = null) {

		$this->layout = 'default';
		// Se dados estiverem preenchidos
		if (!empty($this->data) && $this->data['User']['password'] != null) {
			$this->data['User']['password'] = md5($this->data['User']['password']);
			if ($this->User->save($this->data)) {
				$this->Message->addMsg("Usuário alterado com sucesso.");
				$this->redirect(array('action'=>'edit'));
			} else {
				$this->Message->addError('Ocorreu um erro na gravação do registro.');
			}
		}
		//Se for apenas a entrada
		if (empty($this->data)) {
			$this->data = $this->User->find("first");
		}
	}

}

?>