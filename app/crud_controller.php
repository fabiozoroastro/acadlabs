<?php
abstract class CrudController extends AppController {


	/**
	 * Declaração dos 'helpers' que serão utilizados nas 'views'
	 * @var <helpers>
	 * @author fabiozoroastro
	 */
	
	var $helpers = array('Html', 'Form', 'Javascript', 'Time','Message');

	/**
	 * Este método deve ser implementado para que o controller concreto retorne o Model devido.
	 * @return Model
	 * @author fabiozoroastro
	 */
	protected abstract function getModel();

	/**
	 * Este método deve retornar o texto que será exibido quando houver sucesso na gravação.
	 * @return String
	 * @author fabiozoroastro
	 */
	protected abstract function getMsgSucess();

	/**
	 * Funcao disparada ao acessar a funcionalidade inicial(Listagem)
	 * @author fabiozoroastro
	 */
	public function index($q = null) {
		if( $q != null){
			$this->set('query', $q);
		}
	}

	/**
	 * Seta os registros pesquisados na variavel "results
	 * @author fabiozoroastro
	 */
	public function grid($q = null) {
		if($q != null ){
			$this->findExecute($q);
		}
		$this->set('results', $this->paginate());
	}

	/**
	 *
	 * Este método funciona da seguinte forma.
	 * 1. No default.ctp, um parametro é informado e o método find é invocado.
	 * 2. O método find recupera o parametro e redireciona para a tela inicial com o parametro na URL;
	 * 3. O index.ctp do UC corrente chama o método grid passando o parametro como argumento;
	 * 4. O método grid realiza a chamada do findExecute que deverá aplicar uma nova restriçao na variavel paginate
	 *
	 * @param unknown_type $param
	 */
	public function find(){
		if( isset( $this->params['url']['q'] ) ){
			$q = $this->params['url']['q'];

			$this->redirect(array('action'=>'index', $q ));
		}
	}

	/**
	 *
	 * Deve haver a implementacao de pesquisa
	 * @param unknown_type $q
	 */
	protected function findExecute($q){
		//log.sobreescreva para a pesquisa personalizada
	}
	/**
	 *
	 * Realiza a edicao do registro e redireciona para a tela inicial do UC
	 * @param unknown_type $id
	 */
	public function edit($id = null) {

		$this->beforeSave( $id );

		//se nao houver id e dados estiverem vazios
		if (!$id && empty($this->data)) {
			$this->Message->addWarning('Parâmetro(s) inválido(s).');
			$this->redirect(array('action'=>'index'));
		}
		// Se dados estiverem preenchidos
		if (!empty($this->data)) {
			if ($this->getModel()->save($this->data)) {
				$this->Message->addMsg($this->getMsgSucess());
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Message->addError('Ocorreu um erro na gravação do registro.');
			}
		}
		//Se for apenas a entrada
		if (empty($this->data)) {
			//Template-Method para a criacao do formulario

			$this->data = $this->getModel()->read(null, $id);
		}
	}

	/**
	 * Realiza a inclusao de um novo registro e mantem na mesma pagina
	 * @author fabiozoroastro
	 */
	public function add() {

		$this->beforeSave();
		//Se tive submetido o formulario
		if (!empty($this->data)) {
			//Template-Method para a criacao do formulario

			$this->getModel()->create();
			if ($this->getModel()->save($this->data)) {

				$this->Message->addMsg($this->getMsgSucess());
				$this->redirect(array('action'=>'add'));
			} else {
				$this->Message->addError('Ocorreu um erro na gravação do registro.');
			}
		}
	}

	/**
	 * Ponto de extensao para salvar informacoes submetidas por um formulario
	 * @pattern Template-Method
	 * @param unknown_type $id
	 */
	protected function beforeSave( $id = null ){
		//log.info(Deve ser sobreescrito se for necessario)
	}

}