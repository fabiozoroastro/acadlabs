<?php
/**
 *
 * Helper para exibicao dos horarios
 * @author fabiozoroastro
 *
 */
class ScheduleHelper extends Helper
{
	var $helpers = array('Session');

	function getId($schedule){
		$arrSche = explode("-", $schedule);
		return $arrSche[3];
	}

	/**
	 *
	 * Exibe os horarios de acordo com o turno informado
	 * @param $turn
	 * @param $time
	 */
	function showTime($turn, $time){

		$resultado = '???';
		switch($turn){
			//manha
			case 1:
				switch ($time) {
					case 1:$resultado = '07h00 - 07h50'; break;
					case 2:$resultado = '07h50 - 08h40'; break;
					case 3:$resultado = '08h50 - 09h40'; break;
					case 4:$resultado = '09h40 - 10h30'; break;
					case 5:$resultado = '10h40 - 11h30'; break;
					case 6:$resultado = '11h30 - 12h20'; break;
				}
				break;
				//tarde
			case 2:
				switch ($time) {
					case 1:$resultado = '13h30 - 14h20'; break;
					case 2:$resultado = '14h20 - 15h10'; break;
					case 3:$resultado = '15h20 - 16h10'; break;
					case 4:$resultado = '16h10 - 17h00'; break;
					case 5:$resultado = '17h10 - 18h00'; break;
					case 6:$resultado = '18h00 - 18h50'; break;
				}
				break;
				//noite
			case 3:
				switch ($time) {
					case 1:$resultado = '19h00 - 19h50'; break;
					case 2:$resultado = '19h50 - 20h40'; break;
					case 3:$resultado = '20h50 - 21h40'; break;
					case 4:$resultado = '21h40 - 22h30'; break;
				}
				break;
		}

		return $resultado;
	}

	/**
	 *
	 * Exibe os horarios de sabado
	 * @param $turn
	 * @param $time
	 */
	function showTimeSaturday($turn, $time){

		$resutado = '???';
		switch($turn){
			//manha
			case 1:
				switch ($time) {
					case 1:$resultado = '07h40 - 08h30'; break;
					case 2:$resultado = '08h30 - 09h20'; break;
					case 3:$resultado = '09h30 - 10h20'; break;
					case 4:$resultado = '10h20 - 11h10'; break;
					case 5:$resultado = '11h20 - 12h10'; break;
					case 6:$resultado = '12h10 - 13h00'; break;
				}
				break;
				/* Sabado a tarde eh a mesma coisa dos outros dias da semana
			case 2:
				switch ($time) {
					case 1:$resultado = '13h30 - 14h20'; break;
					case 2:$resultado = '14h20 - 15h10'; break;
					case 3:$resultado = '15h20 - 16h10'; break;
					case 4:$resultado = '16h10 - 17h00'; break;
					case 5:$resultado = '17h10 - 18h00'; break;
					case 6:$resultado = '18h00 - 18h50'; break;
				}
				break;
				*/
		}

		return $resultado;
	}
}

?>