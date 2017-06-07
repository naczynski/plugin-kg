<?php

	function KG_get_label_for_stat_column($column){

		switch($column){
			case 'sum_log_in' : return __( 'Ilość logowań', 'kg' ); break;
			case 'sum_downloads' :return __( 'Ilość pobrań zasobów', 'kg' ); break;
			case 'sum_messages' : return __( 'Ilość wysłanych wiadomości', 'kg' ); break;
			case 'sum_donations' : return __( 'Suma wpłat', 'kg' ); break;
			case 'sum_time_spent' : return __( 'Łączny czas na platformie', 'kg' ); break;
			case 'sum_likes_resources' : return __( 'Ilość polubionych zasobów', 'kg' ); break;
			case 'sum_likes_tasks_responses' : return __( 'Ilość polubionych odpowiedzi do zadań ', 'kg' ); break;
			case 'sum_quiz_results' : return __( 'Ilość rozwiązanych quizów', 'kg' ); break;
			case 'sum_task_responses' : return __( 'Ilość odpowiedzi do zadań', 'kg' ); break;
			case 'sum_presents' : return __( 'Ilość wysłanych prezentów', 'kg' ); break;
			
			case 'quiz_id' : return __( 'Quiz', 'kg' ); break;
			case 'quiz_date_solve' : return __( 'Data rozwiązania', 'kg' ); break;	
			case 'user_id' : return __( 'Użytkownik', 'kg' ); break;	
			case 'is_passed' : return __( 'Zaliczony', 'kg' ); break;
			case 'time_solving' : return __( 'Czas rozwiązania', 'kg' ); break;
			case 'percange_solve' : return __( 'Wynik', 'kg' ); break;
			case 'prize' : return __( 'Nagroda', 'kg' ); break;

			default: return '';
		}

	}

	function KG_polish_month($month, $year){
		$m = date("M", strtotime('01-' . $month . '-1992') );
		$months = array( 
			'Jan' => 'Styczeń ' . $year,
			'Feb' => 'Luty ' . $year,
			'Mar' => 'Marzec'  . $year,
			'Apr' => 'Kwiecień ' . $year,
			'May' => 'Maj ' . $year,
			'Jun' => 'Czerwiec ' . $year,
			'Jul' => 'Lipiec ' . $year,
			'Aug' => 'Sierpień ' . $year,
			'Sep' => 'Wrzesień ' . $year,
			'Oct' => 'Październik ' . $year,
			'Nov' => 'Listopad ' . $year,
			'Dec' => 'Grudzień ' . $year,

			);
		return $months[ $m ];
	}
