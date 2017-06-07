<h1>Odpowiedź do zadania</h1>

<?php if( !empty($_POST['action-response']) && $_POST['action-response']=='update' ): 
$kg_task_response->update($_POST['response']);
?>
	<p class="update-nag" style="margin-top: 0px">Poprawnie zaaktualizowano odpowiedź</p>
<?php elseif( !empty($_POST['action-response']) && $_POST['action-response']=='delete-response' ): 
    $kg_task_response->remove();
?>
	<p class="update-nag" style="margin-top: 0px">Usunięto odpowiedź</p>
	<?php exit; ?>
<?php endif; ?>

<hr />

<p><strong>Zadania</strong>: <a target="_blank" href="<?=$kg_task_response->get_task_obj()->get_admin_edit_link(); ?>"><?=$kg_task_response->get_task_obj()->get_name(); ?></a></p>
<p><strong>Data rozwiązania</strong>: <?=$kg_task_response->get_date();?></p>
<p><strong>Użytkownik</strong>: <a target="_blank" href="<?=$kg_task_response->get_user()->get_edit_page(); ?>"><?=$kg_task_response->get_user()->get_name_and_surname(); ?></a></p>
<p><strong>Ilość polubień</strong>: <?=$kg_task_response->get_number_likes(); ?></p>


	<?php if ($kg_task_response->is_get_prize()): ?>
		<p><strong>Nagroda</strong>:

			<?php if ($kg_task_response->is_user_choose_award()): ?>
				<span> <a target="_blank" href="<?=$kg_task_response->get_award_resource()->get_admin_edit_link();?>"><?=$kg_task_response->get_award_resource()->get_name_with_subtype();?></a> </span>
			<?php else: ?>
				<span>Użytkownik jeszcze nie wybrał swojej nagrody</span>
			<?php endif ?>

		</p>
	<?php else: ?>
		<p> Odpowiedź nie uzyskała wymaganej ilości polubień (<?=$kg_task_response->get_task_obj()->get_number_of_likes_to_win() ; ?>)</p>
	<?php endif; ?>
 </p>

<hr />

<h2>Treść</h2>
 
<form action="<?=$kg_task_response->get_admin_edit_url(); ?>" method="POST" >
	<input type="hidden" name="action-response" value="update">
	<div style="width: 100%">
		<textarea name="response" style="width: 500px;height: 200px" cols="50"><?=$kg_task_response->get_content_plain(); ?></textarea>
	</div>

	<button class="float-left button">Aktualizuj</button>

</form>

<form action="<?=$kg_task_response->get_admin_edit_url(); ?>" method="POST">
	<input type="hidden" name="action-response" value="delete-response">
	<button style="margin-left: 10px" class="float-left button delete-but">Usuń</button>
</form>
	