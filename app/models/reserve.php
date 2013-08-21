<?php

/**
 *  Classe responsável por representar a tabela 'reserve' através de ORM.
 *  @author fabiozoroastro
 *
 */
class Reserve extends AppModel {

	var $name = 'Reserve';
	var $useTable = 'reserve';
	var $primaryKey = 'id';


	/**
	 * Retorna as reservas para os argumentos informados
	 * Ex.: de retorno:
	 * array(1) { [0]=> array(2) { ["Reserve"]=> array(7) { ["id"]=> string(1) "2" ["laboratory_id"]=> string(1) "3"
	 * ["discipline_id"]=> string(1) "1" ["user_id"]=> string(1) "1"
	 * ["period_id"]=> string(1) "1" ["schedule_id"]=> string(1) "1"
	 * ["date"]=> string(10) "2011-01-03" }
	 * ["sche"]=> array(1) { ["time"]=> string(1) "1" } }
	 * @param unknown_type $periodId
	 * @param unknown_type $turn
	 * @param unknown_type $lab
	 * @param unknown_type $begin
	 * @param unknown_type $end
	 */
	public function findReserves($periodId, $turn, $lab, $begin, $end){

		$sql = "select Reserve.*, sche.day, sche.time, Discipline.name, Course.name from reserve Reserve";
		$sql .= " inner join schedule sche on sche.id = Reserve.schedule_id";
		$sql .= " inner join laboratory lab on lab.id = Reserve.laboratory_id";
		$sql .= " inner join period per on per.id = Reserve.period_id";
		$sql .= " inner join discipline Discipline on Discipline.id = Reserve.discipline_id";
		$sql .= " inner join course Course on Course.id = Discipline.course_id";
		$sql .= " where";
		$sql .= " per.id = $periodId";
		$sql .= " and";
		$sql .= " sche.turn = $turn";
		$sql .= " and";
		$sql .= " lab.id = $lab";
		$sql .= " and";
		$sql .= " ( Reserve.date >= '$begin' and Reserve.date <= '$end' )";
		$sql .= " order by sche.day";

		$resultado = $this->query($sql);
		return $resultado;
	}

	/**
	 *
	 * Retorna a reserva pelo dia informado
	 * @param array<Reserve> $reserves Lista de reservas
	 * @param timestamp $day Data da reserva
	 */
	public function getReserveByDay($reserves = array(), $day, $time){
		if(count($reserves)> 0){
			foreach ($reserves as $r){
				if(strtotime($r['Reserve']['date']) == $day && $r['sche']['time'] == $time){
					return $r;
				}
			}
		}
		return null;
	}

	/**
	 *
	 * Realiza a pesquisa da reserva para os filtros informados.
	 * @author fabio.zoroastro
	 * @param unknown_type $strInDays DIAS na clausula IN
	 * @param unknown_type $scheduleId HORARIO
	 * @param unknown_type $periodId PERIODO(SEMESTRE)
	 */
	public function findByDaysAndScheduleAndPeriod($strInDays, $reserve){

		$sql = "select Reserve.*, Discipline.name, Course.name from reserve Reserve";
		$sql .= " inner join discipline Discipline on Discipline.id = Reserve.discipline_id";
		$sql .= " inner join course Course on Course.id = Discipline.course_id";
		$sql .= " where";
		$sql .= " Reserve.schedule_id =".$reserve['Reserve']['schedule_id'];
		$sql .= " and";
		$sql .= " Reserve.period_id =".$reserve['Reserve']['period_id'];
		$sql .= " and";
		$sql .= " Reserve.laboratory_id =".$reserve['Reserve']['laboratory_id'];
		$sql .= " and";
		$sql .= " Reserve.date in ($strInDays)";
		$sql .= " order by Reserve.date";

		$resultado = $this->query($sql);

		return $resultado;
	}


	/**
	 *
	 * Realiza a remocao das reservas para os parametros informados
	 * @param Long $laboratoryId Id do Laboratorio
	 * @param Long $periodId Id do Periodo
	 * @param Long $turn Turno
	 * @param Integer $dayOfWeek Dia da semana (2 - Segunda, 3- Terca ... 7 Sabado)
	 * @param String(d/m/Y) $begin data inicio para remocao
	 * @param String(d/m/Y) $end data fim para removao
	 */
	public function deleteVariousReserves($laboratoryId, $periodId, $turn, $dayOfWeek, $begin, $end, $time){

		$arrTemp = explode("/", $begin);
		$begin = $arrTemp[2]."-".$arrTemp[1]."-".$arrTemp[0];

		$arrTemp = explode("/", $end);
		$end = $arrTemp[2]."-".$arrTemp[1]."-".$arrTemp[0];


		$sql = "delete from reserve";
		$sql .= " where laboratory_id = $laboratoryId";
		$sql .= " and period_id = $periodId";
		$sql .= " and ( date >= '$begin' and date <= '$end' )";
		$sql .= " and schedule_id in ( ";
		$sql .= "       select sche.id from schedule sche";
		$sql .= "           where sche.turn = $turn and sche.day = $dayOfWeek and sche.time = $time";
		$sql .= " )";
		
		return $this->query($sql);

	}
}

?>
