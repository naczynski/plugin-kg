<?php
  $kg_transaction = $this->get_transaction_obj();
?>
<div id="minor-publishing">
   <div id="misc-publishing-actions">
       <div class="misc-pub-section curtime misc-pub-curtime">
         <span>
         Numer: <b><?= $kg_transaction->get_number_for_user(); ?></b></span>
      </div>
      <div class="misc-pub-section misc-pub-post-status"><label for="post_status">Stan:</label>
         <span id="post-status-display">
            <span class="spinner"></span>

                  <?php if ($kg_transaction->is_payment_complete() ): ?>
                     <span class="yes">Zapłacono</span>
                  <?php elseif($kg_transaction->is_canceled()) : ?>
                     <span class="no">Anulowana</span>
                  <?php else: ?>
                     <span style="color: orange">Oczekiwanie na wpłatę</span>
                     <span class="spinner spinner-transactions"></span>
                     <a data-ajax-params='<?= json_encode(array(
                        'action' => 'transaction_pay',
                        'transaction_id' => $kg_transaction->get_ID(),
                        'security' => wp_create_nonce()
                     )); ?>' class="button button-pay gree-text">Zapłać</a>
                     <div class="clear"></div>
                  <?php endif; ?>  
               </form>
         </span>
      </div>
      <div class="misc-pub-section curtime misc-pub-curtime">
         <span id="timestamp">
         Data transackcji: <b><?= $kg_transaction->get_date(); ?></b></span>
      </div>

      <div class="misc-pub-section curtime misc-pub-curtime">
         <span id="user-trans">
            Użytkownik: <b><a href="<?=$kg_transaction->get_user()->get_edit_page();?>"> <?=$kg_transaction->get_user()->get_name_and_surname(); ?> </a></b>
         </span>
      </div>

       <div class="misc-pub-section curtime misc-pub-curtime">
         <span id="timestamp">
            Identyfikator PayU: <b><?= $kg_transaction->get_payu_transaction_id(); ?></b>
         </span>
      </div>
      
      <?php if ($kg_transaction->is_payment_complete() ): ?>
          <div class="misc-pub-section curtime misc-pub-curtime">
               <a style="margin: 0 auto;" target="_blank" class="button" href="/pobierz?type=invoice&id=<?=$kg_transaction->get_ID();?>">Pobierz fakturę</a>
         </div>
       <?php endif; ?>   

   </div>
   <div class="clear"></div>
</div>