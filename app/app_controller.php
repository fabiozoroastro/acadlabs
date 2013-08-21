<?php

/**
 * Classe genérica para todas as classes de controle do sistema.
 * @author fabiozoroastro
 */
class AppController extends Controller {

	/**
	 * Declaração de componentes que serão utilizados por esse controle
	 * @var <type>
	 * @author fabiozoroastro
	 */
	var $components = array('Session', 'RequestHandler', 'Message');
	var $helpers = array('Html', 'Form', 'Javascript', 'Message');

	protected function isLogged() {
		return $this->Session->check("user");
	}

	/*
	 function isAdmin() {
	 return $this->Session->check("admin");
	 }
	 */

	protected function getUser() {
		return $this->Session->read("user");
	}

	/**
	 * Verifica se há uma sessão registrada. Caso não haja, redireciona para a tela de login
	 */
	protected function checkSession() {
		if (!$this->isLogged()) {
			$this->redirect("/login");
			exit;
		}
	}

	/**
	 * Checa a sessão do usuário para cada ação executada, com exceção da tela de login.
	 */
	public function beforeFilter() {
		if ($this->params['controller'] != 'users' && $this->params['action'] != 'login') {
			$this->checkSession();
			$this->showButtonList();
			$this->set('useFind', $this->useFind() );
		}
	}

	/**
	 * Metodo invocado após a execução de métodos de controle.
	 * Este método será chamado antes da fase de renderização
	 * @author fabiozoroastro
	 */
	public function afterFilter() {
		//FIXME - Verificar porque nao entra no afterFilter;
		//$this->showButtonList();
	}

	/**
	 * Este metodo define quais botões serão exibidos na barra direita(Botões verdes).
	 * Quando uma funcionalidade desejar exibir os botões, este método deverá ser sobreescrito.
	 *
	 * O css padrão é: green button.
	 * Exemplo de implementação:
	 * $buttonList = array(
	 array('id'=>'addLab', 'text' => "Add Laboratory", 'method' => 'add')
	 );
	 $this->set('buttonList', $buttonList);
	 $this->set('buttonList', $buttons);
	 * @author fabiozoroastro
	 */
	protected function showButtonList() {

	}

	/**
	 * Este método deve ser sobreescrito para os casos de uso que utilizam
	 * a pesquisa na barra direita(vertical).
	 * Para estes casos, sobreescreva o método e retorne true.
	 *
	 * Quando houver a sobreescrita e o retorno for true, um parâmetro também deverá
	 * ser setado na request: nameFilter.
	 * Ex.: $this->set('nameFilter', 'Laboratório');
	 * @author fabiozoroastro
	 */
	protected function useFind() {
		return false;
	}

}

?>