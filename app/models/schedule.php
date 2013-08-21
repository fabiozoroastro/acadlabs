<?php

/**
 *  Classe responsável por representar a tabela 'schedule' através de ORM.
 *  @author fabiozoroastro
 *
 */
class Schedule extends AppModel {

	var $name = 'Schedule';
	var $useTable = 'schedule';
	var $primaryKey = 'id';

	/**
	 *
	 * Retorna os horarios por turno
	 * @param unknown_type $turn ID do Turno
	 * @param unknown_type $daysOfWeek array() - Dias da semana. 2 - Segunda; 3 - Terca ... 7 - Sabado
	 */
	public function findSchedules($turn){

		$sql = "select Schedule.* from schedule Schedule";
		$sql .= " where Schedule.turn = $turn";

		return $this->query($sql);

	}

	/**
	 *
	 * Retorna lista de tempos com distinct em TURNO
	 * @param unknown_type $turn ID do Turno
	 */
	public function findSchedulesDistinctTurn($turn){

		$sql = "select distinct( Schedule.time ) from schedule Schedule";
		$sql .= " where Schedule.turn = $turn";

		return $this->query($sql);
	}

	/**
	 *
	 * Retorna o objeto completo em forma de array do tipo Schedule.
	 *
	 * @param long $time Campo TIME(Numerico)
	 * @param timestamp $dateTime time
	 * @param long $turn Campo TURN(Numerico)
	 */
	public function findScheduleByCompositeKey($time,$dateTime,$turn){

		$dayOfWeek = (date('N', $dateTime ) + 1) ;
		$scheduleConditions = array('conditions' => array('Schedule.turn' => $turn, 'Schedule.time' => $time, 'Schedule.day' => $dayOfWeek));
		$result = $this->find('all', $scheduleConditions);

		if($result != null && count($result) > 0){
			$result = $result[0];
		}else{
			$result = null;
		}
		return $result;

	}
}

?>
