
<table class="widefat">
	<tbody>
		
		<tr class="stat-total-label">
			<td colspan="2">Użytkownicy</td>
		</tr>
		<tr>
			<td>Ilość użytkowników</td>
			<td><?=$this->get_total_users(); ?></td>
		</tr>
		<tr>
			<td>Ilość logowań</td>
			<td><?=$this->get_total_log_in(); ?></td>
		</tr>
		<tr>
			<td>Średni czas przebywania na platformie</td>
			<td><?=$this->get_avg_spent(); ?></td>
		</tr>

		<tr class="stat-total-label">
			<td colspan="2">Networking</td>
		</tr>
		<tr>
			<td>Ilość wysłanych wiadomości na platformie</td>
			<td><?=$this->get_total_sent_messages(); ?></td>
		</tr>

		<tr class="stat-total-label">
			<td colspan="2">Quizy</td>
		</tr>
		<tr>
			<td>Ilość rozwiązanych quizów</td>
			<td><?=$this->get_total_solve_quizes(); ?></td>
		</tr>

		<tr class="stat-total-label">
			<td colspan="2">Transakcje</td>
		</tr>
		<tr>
			<td>Ogólny zysk</td>
			<td><?=$this->get_total(); ?>zł</td>
		</tr>
		<tr>
			<td>Zysk z abonamentów</td>
			<td><?=$this->get_total_subscriptions(); ?>zł</td>
		</tr>
			<tr>
			<td>Zysk z prezentów</td>
			<td><?=$this->get_total_presents(); ?>zł</td>
		</tr>
			<tr>
			<td>Zysk z kupna zasobów</td>
			<td><?=$this->get_total_resources(); ?>zł</td>
		</tr>

	</tbody>
</table>
