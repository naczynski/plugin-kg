
	<h1>Wynik rozwiązania quizu</h1>
	
	<p><strong>Quiz</strong>: <a target="_blank" href="<?=$kg_quiz_result->get_kg_quiz_item()->get_admin_edit_link(); ?>"><?=$kg_quiz_result->get_kg_quiz_item()->get_name(); ?></a></p>
	<p><strong>Data rozwiązania</strong>: <?=$kg_quiz_result->get_date();?></p>
	<p><strong>Czas rozwiązania</strong>: <?=$kg_quiz_result->get_time_solving() ;?></p>
	<p><strong>Użytkownik</strong>: <a target="_blank" href="<?=$kg_quiz_result->get_user()->get_edit_page(); ?>"><?=$kg_quiz_result->get_user()->get_name_and_surname(); ?></a></p>
	<p><strong>Procent</strong>: <?=$kg_quiz_result->get_result_in_percange() ;?>%</p>
	
		<?php if ($kg_quiz_result->is_user_passed_quiz()): ?>
			<p><strong>Wynik</strong>: <span class="yes">Zaliczył</span></p>
			<p><strong>Nagroda</strong>:

				<?php if ($kg_quiz_result->is_user_choose_award()): ?>
					<span> <a target="_blank" href="<?=$kg_quiz_result->get_award_resource()->get_admin_edit_link();?>"><?=$kg_quiz_result->get_award_resource()->get_name_with_subtype();?></a> </span>
				<?php else: ?>
					<span>Użytkownik jeszcze nie wybrał swojej nagrody</span>
				<?php endif ?>

			</p>
		<?php else: ?>
			<p><strong>Wynik</strong>:<span class="no"> Nie zalizczył</span></p>
		<?php endif; ?>
	 </p>

	<h1 style="padding: 20px 0">Odpowiedzi</h1>

	<?php 
		$answers = $kg_quiz_result->get_questions_with_user_answer();
		foreach ($answers as $i =>$answer): 

		$class_a_correct = ( $answer->check_is_correct_answer('a') ) ? 'correct-answer' : '';
		$class_b_correct = ( $answer->check_is_correct_answer('b') ) ? 'correct-answer' : '';	
		$class_c_correct = ( $answer->check_is_correct_answer('c') ) ? 'correct-answer' : '';
		$class_d_correct = ( $answer->check_is_correct_answer('d') ) ? 'correct-answer' : '';

		$class_a_user_answer = ( $answer->check_is_user_answer('a') ) ? 'user-answer' : '';
		$class_b_user_answer = ( $answer->check_is_user_answer('b') ) ? 'user-answer' : '';	
		$class_c_user_answer = ( $answer->check_is_user_answer('c') ) ? 'user-answer' : '';
		$class_d_user_answer = ( $answer->check_is_user_answer('d') ) ? 'user-answer' : '';

	?>
		
		<h3>Pytanie <?=++$i;?></h3>

		<table class="widefat quiz-result-table">
	   		<tbody>
	    	
		    	<tr class="">
		    		<td colspan="2" class="quiz-result-question"><?= $answer->get_question();?></td>
		    	</tr>
		    	
				<tr>
					<td class="quiz-result-answer" style="width: 50%">
						<table style="width: 100%">
							<tr class="<?=$class_a_correct ;?> <?=$class_a_user_answer ;?>">
								<td class="answer-label">A</td>
								<td><?= $answer->get_answer_a();?></td>
							</tr>
						</table>
					</td>
					<td class="quiz-result-answer" style="width: 50%">
						<table style="width: 100%">
							<tr class="<?=$class_c_correct ;?> <?=$class_c_user_answer ;?>">
								<td class="answer-label">C</td>
								<td><?= $answer->get_answer_b();?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="quiz-result-answer">
					<td class="quiz-result-answer" style="width: 50%">
						<table style="width: 100%">
							<tr class="<?=$class_b_correct ;?> <?=$class_b_user_answer ;?>">
								<td class="answer-label">B</td>
								<td><?= $answer->get_answer_a();?></td>
							</tr>
						</table>
					</td>
					<td class="quiz-result-answer" style="width: 50%">
						<table style="width: 100%">
							<tr class="<?=$class_d_correct ;?> <?=$class_d_user_answer ;?>">
								<td class="answer-label">D</td>
								<td><?= $answer->get_answer_a();?></td>
							</tr>
						</table>
					</td>
				</tr>
		   </tbody>
		</table>	
	<?php endforeach ?>

	