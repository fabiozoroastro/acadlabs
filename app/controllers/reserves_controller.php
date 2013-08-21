<?php

/**
 * Classe responsavel por controlar as requisições da funcionalidade de cadastro de laboratorios.
 * @author fabiozoroastro
 */
class ReservesController extends AppController {

	//bugfix cakephp to translation
	var $uses = array( 'Reserve','Software', 'Laboratory', 'Period', 'Schedule', 'Discipline' );
	var $layout = 'calendar_layout';
	var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Message', 'Schedule');

	/**
	 *
	 * Monta as informacoes com reservas
	 * @author fabiozoroastro
	 * @param unknown_type $periodId
	 * @param unknown_type $turn
	 * @param unknown_type $labId
	 * @param unknown_type $begin
	 * @param unknown_type $end
	 */
	public function rel($periodId,$turn,$labId,$begin,$end){

		$this->layout = 'rel_layout';

		$arrTmp = explode("-", $begin);
		$begin = $arrTmp[0]."/".$arrTmp[1]."/".$arrTmp[2];

		$arrTmp = explode("-", $end);
		$end = $arrTmp[0]."/".$arrTmp[1]."/".$arrTmp[2];

		$daysOfWeek = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
		$lab = $this->Laboratory->findById($labId);

		if( $turn  == -1 ){

			$data = array('Reserve' => array('period_id' => $periodId, 'turn' => 1, 'laboratory_id' => $labId, 'begin' =>$begin , 'end' => $end));
			$reserves[1] = $this->events($data);

			$data = array('Reserve' => array('period_id' => $periodId, 'turn' => 2, 'laboratory_id' => $labId, 'begin' =>$begin , 'end' => $end));
			$reserves[2] = $this->events($data);

			$data = array('Reserve' => array('period_id' => $periodId, 'turn' => 3, 'laboratory_id' => $labId, 'begin' =>$begin , 'end' => $end));
			$reserves[3] = $this->events($data);
		}else{
			$data = array('Reserve' => array('period_id' => $periodId, 'turn' => $turn, 'laboratory_id' => $labId, 'begin' =>$begin , 'end' => $end));
			$reserves[$turn] = $this->events($data);
		}

		$this->set('reserves', $reserves);
		$this->set('daysOfWeek',$daysOfWeek);
		$this->set('lab', $lab);


	}

	/**
	 *
	 * 1 - Metodo inicial executado ao entrar na tela.
	 * 2 - Este metodo recebe a requisicao POST da realizacao de uma reserva
	 * 2.1 - Apos enviar as informacoes para a realizacao da reserva, este metodo delega as responsabilidades para outros metodos
	 * @author fabio.zoroastro
	 */
	public function calendar(){
		$laboratories = $this->Laboratory->find('list', array('order' => 'Laboratory.name', 'conditions' => array('Laboratory.active = 1'))) ;
		$this->set('laboratories', $laboratories);

		$halfYears = $this->Period->find('all', array('order' => 'Period.begin', 'conditions' => array('Period.active = 1'))) ;

		$this->set('halfYears',$halfYears);

		if(isset( $this->data )  ){

			if($this->data['Reserve']['action'] == 'deleteReserve' ){
				$this->deleteReserve();
			}

			if($this->findFiltersAreValid()){
				//Se for acao de realizar reserva.(Identificado no arquivo modal-calendar.js)
				if($this->data['Reserve']['action'] == 'makeReserve' ){
					$this->makeReserve();
				}
				$this->prepareCalendar();
			}else{
				$this->Message->addWarning('Preencha todos os campos para uma nova pesquisa.');
				$this->set('reserves',null);
			}
		}
	}

	/**
	 *
	 * Inicia o procedimento para a preparacao do calendario
	 * @author fabio.zoroastro
	 */
	private function prepareCalendar(){

		$daysOfWeek = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
		$this->set('reserves', $this->events($this->data));
		$this->set('daysOfWeek',$daysOfWeek);

		$disciplines = $this->Discipline->find('list', array('order' => 'Discipline.name', 'conditions' => array('Discipline.active = 1'))) ;
		$this->set('disciplines',$disciplines);

	}

	/**
	 * Realiza a construcao dos eventos(Caixas de reservas) que serao exibidas para o usuario
	 * @author fabio.zoroastro
	 */
	private function events($form){

		//obrigatorios
		$periodId = $form['Reserve']['period_id'];
		$turn = $form['Reserve']['turn'];
		$lab = $form['Reserve']['laboratory_id'];

		//periodo. Se nao for informado, pegar da tabela de periodo
		if(isset($form['Reserve']['begin']) && $form['Reserve']['begin'] != null ){
			//			$timeT = DateTime::createFromFormat('d/m/Y', $form['Reserve']['begin']);
			$date = explode("/", $form['Reserve']['begin']);
			$begin = strtotime($date[2]."-".$date[1]."-".$date[0]);

		}

		if(isset($form['Reserve']['end']) && $form['Reserve']['end'] != null ){
			$date = explode("/", $form['Reserve']['end']);
			$end = strtotime($date[2]."-".$date[1]."-".$date[0]);
		}

		//periodo selecionado
		$period = $this->Period->findById($periodId);

		//dias que serao exibidos
		$arrayDays = $this->daysByPeriod($begin, $end, $period['Period']['days'], $turn);


		$existsReserves = $this->Reserve->findReserves($periodId, $turn, $lab, date('Y-m-d', $begin), date('Y-m-d', $end));
		$schedules = $this->Schedule->findSchedulesDistinctTurn($turn);

		$reserves = $this->buildReserves($arrayDays, $existsReserves, $schedules);

		return $reserves;

	}

	/**
	 * Monta o quadro de reservas de acordo com os dados de entrada.
	 * Veja o codigo de como seria o retorno de 3 turnos para segunda e terca feira.
	 *  Os arrays que estao com NULL eh pq nao possuem reservas
	 *  [0] - Dia da Semana
	 *  [1] - Horario
	 *  [2] - Dia do ano
	 *  [3] - Objeto reserva ou null
	 * <code>
	 *
		$reserves[1]['01/01/2010'] = null;
		$reserves[1]['02/01/2010'] = null;
		$reserves[2]['01/01/2010'] = array('Reserve' => array('id' => 10));
		$reserves[2]['02/01/2010'] = array('Reserve' => array('id' => 8));
		$reserves[2]['03/01/2010'] = array('Reserve' => array('id' => 2));
	 * </code>
	 * @param $daysOfWeek array com os dias. Ex.? array(2,3,4,5,6,7)
	 * @param $days todos os dias dentro do intervalo do periodo informado
	 * @param $existsReserves Reservjas jah existentes
	 * @param $schedules Horarios cadastrados para os dias e turnos
	 * @author fabio.zoroastro
	 */
	private function buildReserves($days, $existsReserves, $schedules){
		$result = array();

		//diminuo a uma data a outra
		foreach ($schedules as $sche){

			foreach ($days as $day){
				$tempReserve = $this->Reserve->getReserveByDay($existsReserves, $day, $sche['Schedule']['time']);

				if( $tempReserve != null ){
					$newReserve = $tempReserve;
					$this->log("Reserva encontrada. ID : ".$tempReserve['Reserve']['id'], 'debug');
				}else{
					//$this->log("Nao foi encontrada reserva para time:".$sche['Schedule']['time']." e dia: ".date('d/m/Y',$day)."... O id da Reserva é: ".$tempReserve['Reserve']['id'], 'debug');
					$newReserve = null;
				}
				//armazena uma nova reserva
				//$strSched = $sche['Schedule']['turn'].'-'.$sche['Schedule']['day'].'-'.$sche['Schedule']['time'].'-'.$sche['Schedule']['id'];
				$strSched = $sche['Schedule']['time'];

				$result[$strSched][$day] = $newReserve;
			}
		}

		return $result;
	}


	/**

	* Retorna os dias da semana presentes no intervalo do periodo informado
	* 2- Segunda
	* 3 - Terca
	* 4 - Quarta
	* 5 - Quinta
	* 6 - Sexta
	* 7 - Sabado
	* DOMINGO NAO ENTRA
	* @param timestamp $a
	* @param timestamp $b
	*/
	private function daysOfWeek($a, $b){

		$result = array();

		//fica no loop enquanto houver dias da semana
		while($a <= $b){

			// se repetir o dia da semana, sai do loop
			if(in_array(date('N', $a) + 1 , $result)){
				break;
			}else if((date('N', $a) + 1) != 8){
				//Nao adiciona domingos
				$result[] = date('N', $a) + 1 ;
			}
			$a = $a+3600*24*1;
		}

		return $result;

	}

	/**
	 * Valida se todos os dados de entrada foram preenchidos
	 * array(1) { ["Reserve"]=> array(5) { ["period_id"]=> string(1) "1" ["turn"]=> string(1) "1" ["laboratory_id"]=> string(1) "3" ["begin"]=> string(10) "01/01/2011" ["end"]=> string(0) "" } }
	 * @author fabio.zoroastro
	 */
	private function findFiltersAreValid(){

		$result = true;
		$findFields = $this->data['Reserve'];

		if( $findFields['period_id'] == null || $findFields['period_id'] == '' ){
			$result = false;
			$this->Reserve->invalidate('period_id', 'Período é obrigatório');
		}
		if( $findFields['turn'] == null || $findFields['turn'] == '' ){
			$result = false;
			$this->Reserve->invalidate('turn', 'Turno é obrigatório');
		}
		if( $findFields['laboratory_id'] == null || $findFields['laboratory_id'] == '' ){
			$result = false;
			$this->Reserve->invalidate('laboratory_id', 'Laboratório é obrigatório');
		}

		if( $findFields['begin'] == null || $findFields['begin'] == '' ){
			$result = false;
			$this->Reserve->invalidate('begin', 'Data inicial obrigatória');
		}

		if( $findFields['end'] == null || $findFields['end'] == '' ){
			$result = false;
			$this->Reserve->invalidate('end', 'Data final obrigatória');
		}

		return $result;
	}

	/**
	 * Realiza a reserva
	 * @author fabio.zoroastro
	 */
	public function makeReserve(){
		$reserveData = $this->data['Reserve'];
		$reserve = $this->Reserve->create();
		$user = parent::getUser();

		$continuous = $reserveData['continuous'];
		$dateFormatted = $reserveData['reserveDate'];
		$dateFormatted = explode("/", $dateFormatted);

		//data que sera salva no banco. Formato: yyyy-mm-dd
		$dateToSave = $dateFormatted[2].'-'.$dateFormatted[1].'-'.$dateFormatted[0];
		$reserveDateTime = strtotime($dateToSave);


		$tmpArrDate = explode("/", $reserveData['reserveDate']);
		$dateYmd = strtotime($tmpArrDate[2]."-".$tmpArrDate[1]."-".$tmpArrDate[0]);

		$reserveSchedule = $this->Schedule->findScheduleByCompositeKey($reserveData['reserveTime'], $dateYmd, $reserveData['turn']);

		$reserve['Reserve']['discipline_id'] = $reserveData['disciplineSelected'];
		$reserve['Reserve']['laboratory_id'] = $reserveData['laboratory_id'];
		$reserve['Reserve']['period_id'] = $reserveData['period_id'];
		$reserve['Reserve']['user_id'] = $user['User']['id'];
		$reserve['Reserve']['date'] = $dateToSave;
		$reserve['Reserve']['schedule_id'] = $reserveSchedule['Schedule']['id'];

		//armazena um boolean que identifica se a reserva foi salva
		$saved = true;
		$createdReserves = 0;
		//Verificacao como string pois veio no post
		if( $continuous != 'true'){
			//se nao for continuo, salva apenas 1
			$saved &= $this->Reserve->save($reserve);
			$createdReserves++;
		}else{
			// salva as reservas para o mesmo dia da semana no periodo informado
			$date = explode("/", $this->data['Reserve']['end']);
			$end = strtotime($date[2]."-".$date[1]."-".$date[0]);


			//percorre cada dia e armazena o timestamp no array.
			// armazena os dias em um array para futura criacao
			$daysToCreate = array();
			$daysToVerify = '';
			while($reserveDateTime <= $end && $saved){
				$daysToCreate[] = $reserveDateTime;
				$daysToVerify .= "'".date('Y-m-d', $reserveDateTime)."'";
				$daysToVerify .= ',';
				$reserveDateTime = $reserveDateTime+3600*24*7;
			}
			//retira a ultima virgula
			$daysToVerify = substr($daysToVerify, 0,  strlen($daysToVerify) - 1 );
			$resExistsForContDays = $this->Reserve->findByDaysAndScheduleAndPeriod($daysToVerify,$reserve);
			//Somente cria se nao tiver registros para os dias que receberao as reservas
			if( count($resExistsForContDays) == 0 ){
				foreach($daysToCreate as $timeDays){

					$reserve['Reserve']['id'] = null;
					$reserve['Reserve']['date'] = date('Y-m-d', $timeDays);
					$saved &= $this->Reserve->save($reserve);
					$createdReserves++;
				}
					
			}else{
				$this->set('reservesPreExistis',$resExistsForContDays);
				$saved = false;
			}
		}


		if ($saved) {
			$this->Message->addMsg("$createdReserves Reserva(s) foi(ram) criada(s).");
		}else{
			$this->Message->addError('Ocorreu um erro na realização da(s) reserva(s).');
		}

	}


	/**
	 * Remove a(s) reserva(s)
	 * @author fabio.zoroastro
	 * @param Long editReserve - Id da reserva
	 * @param byte deleteAllReserve - Remove todas as reservas daquele horario. Desde a data inicio informada até a fim.
	 */
	private function deleteReserve(){

		$idDelete = $this->data['Reserve']['editReserve'];
		$deleteAll = $this->data['Reserve']['deleteAllReserve'];

		if(0 == $deleteAll){
			$this->Reserve->delete($idDelete);
			$this->Message->addMsg('Reserva excluída com sucesso.');
		}else{
			$reserveData = $this->data['Reserve']['reserveDate'];
			$params = $this->data['Reserve'];

			$convertDate = explode("/", $params['reserveDate']);
			$dateTimeBegin = strtotime($convertDate[2]."-".$convertDate[1]."-".$convertDate[0]);
			$dayOfWeek = date('N', $dateTimeBegin) + 1;
			$resultExecuteDelete = $this->Reserve->deleteVariousReserves( $params['laboratory_id'], $params['period_id'],$params['turn'], $dayOfWeek, $params['reserveDate'], $params['end'], $params['reserveTime']);

			if( $resultExecuteDelete ){
				$this->Message->addMsg("A(s) Reserva(s) foi(ram) excluídas(s) com sucesso.");
			}else{
				$this->Message->addError("Ocorreu um erro ao remover as reservas. Por favor, tente novamente");
			}

		}
	}

	/**
	 * Retorna os dias para o periodo informado em forma de array
	 * Nao retorna os domingos.
	 * Quando o turno for NOITE, nao retorna SABADOS
	 * @param timestamp $a
	 * @param timestamp $b
	 * @param integer $binaryDays - Dias que serao exibidos. Regra Binaria
	 * @param $turn 1 - MANHA, 2 - TARDE, 3 - NOITE
	 */
	private function daysByPeriod($a, $b, $binaryDays, $turn){
		$result = array();
		//percorre cada dia e armazena o timestamp no array
		while($a <= $b){
			//2(segunda);3(terca)...8(domingo)
			$dayOfWeek = (date('N', $a) + 1);
			//nao exibe domingo e sabados a noite
			if( $dayOfWeek == 8 || ( $turn == 3 && $dayOfWeek == 7  )){
				$this->log("Nao exibiu um domingo/sabado. dia:- $dayOfWeek para o turno: $turn", 'debug');
			}else{
				$result[] = $a;
			}
			//soma um dia
			$a = $a+3600*24*1;
		}
		return $result;
	}



} ?>
