<?php

	class KG_Date_Formatter_To_Time_Ago{

		private function get_minutes($minutes){ 
	        switch($minutes){
	            case 0: return 0; break;
	            case 1: return 1; break;
	            case ($minutes >= 2 && $minutes <= 4):
	            case ($minutes >= 22 && $minutes <= 24):
	            case ($minutes >= 32 && $minutes <= 34):
	            case ($minutes >= 42 && $minutes <= 44): 
	            case ($minutes >= 52 && $minutes <= 54): return "$minutes minut temu"; break;
	            default: return "$minutes minut temu"; break;
	        }
	        return -1;
		}

		public function format($input_date){

	       	 $timestamp = strtotime($input_date);
	       	 $now = time();

		     if ($timestamp > $now) {
		          return 'Podana data nie może być większa od obecnej.';
		     }

		        $diff = $now - $timestamp;

		        $minut = floor($diff/60);
		        $hours = floor($minut/60);
		        $dni = floor($hours/24);       

		        if ($minut <= 60) {
		          $res = $this->get_minutes($minut);
		          switch($res)
		          {
		                case 0: return "przed chwilą";
		                case 1: return "minutę temu";
		                default: return $res;
		          }     
		        }

		        $timestamp_yesterday = $now-(60*60*24);
		        $timestamp_before_day_yestarday = $now-(60*60*24*2);

		        if ($hours > 0 && $hours <= 6) {

		          $restMinutes = ($minut-(60*$hours));
		          $res = $this->get_minutes($restMinutes);
		          if ($hours == 1) {
		                return "godzinę temu";//.$res
		          } else {
		          if ($hours >1 && $hours<5) return "$hours godzin temu ";
		          if ($hours >4)return "$hours godzin temu";
		          }

		        } else if (date("Y-m-d", $timestamp) == date("Y-m-d", $now)) {//jesli dzisiaj
		          return "Dzisiaj";
		        } else if (date("Y-m-d", $timestamp_yesterday) == date("Y-m-d", $timestamp)) {//jesli wczoraj
		          return "Wczoraj";
		        } else if (date("Y-m-d", $timestamp_before_day_yestarday) == date("Y-m-d", $timestamp)) {//jesli wczoraj
		          return "Przedwczoraj";
		        }

		        switch($dni){
		          case ($dni < 7): return "$dni dni temu"; break;
		          case 7: return "Tydzień temu"; break;
		          case ($dni > 7 && $dni < 14): return "Ponad tydzień temu"; break;
		          case 14: return "Dwa tygodznie temu"; break;
		          case ($dni > 14 && $dni < 30): return "Ponad 2 tygodnie temu"; break;
		          case 30: case 31: return "Miesiąc temu"; break;       
		          case ($dni > 31): return date("Y-m-d H:i", $timestamp); break;        
		        }
		        return date("Y-m-d", $timestamp);                 
			}

	}