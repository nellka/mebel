<?php
/**
 * Для мужских анкет уведомления:
- о типе аккаунта
- количестве свободных контактов
- сроке проплаченного топа (если оплачен)
- остатке в кошельке.

Остаток кошелька из меню (белое по синему) – убираем.
Если нет топа – строку не выводим.

Для женских анкет уведомления
- о типе аккаунта (прем или вообще не выводим)
- сроке проплаченного топа (если оплачен)
- количестве свободных контактов
- остатке в кошельке.
контактов у девушек не будет (пока)

 */
if ($account_end_time = $anketa->accountEndTime) {
    $account_end_time -= time();
    if ($account_end_time <=48*3600)
        $account_end_time = "<span class='pink'>(часов:".ceil($account_end_time/3600).")</span>";
    else
        $account_end_time = "<span class='orange'>(дней:".ceil($account_end_time/3600/24).")</span>";
}
?>
<div id="right_top_widget">
<? /*
    <div class="top_premium">
        <?php if ($anketa->getAccountType() == Anketa::ACCOUNT_PREMIUM): ?>
        <?=$anketa->getAccountTypeText()?> аккаунт:  <?=$account_end_time;?> <a class="blue-button" href="/profile/premium">ПРОДЛИТЬ ПРЕМИУМ</a>
        <?php elseif ($anketa->gender == Anketa::GENDER_MAN && $anketa->getAccountType() == Anketa::ACCOUNT_TRIAL): ?>
        <?=$anketa->getAccountTypeText()?> аккаунт: <?=$account_end_time;?> <a class="blue-button" href="/profile/premium">КУПИТЬ ПРЕМИУМ</a>
        <?php elseif ($anketa->gender == Anketa::GENDER_MAN): ?>
        <?=$anketa->getAccountTypeText()?> аккаунт: <span class="pink">(переписка отключена)</span> <a class="blue-button" href="/profile/premium">КУПИТЬ ПРЕМИУМ</a>
        <?php endif; ?>
    </div>
 */ ?>
<? /*
    <div class="top_contacts">
        Осталось контактов:
        <span class="<?=$anketa->contact_count > 5 ? 'orange' : 'pink'?>"><?=$anketa->contact_count?>
            <?php if ($anketa->contact_count <= 0) echo ' (нельзя начать новую переписку)'; ?>
        </span>
        <a class="blue-button" href="/profile/contacts">КУПИТЬ КОНТАКТЫ</a>
    </div>
*/ ?>
    <div class="top_top">
        <?php if ($anketa->getTop()): ?>
        ТОП: <? if ($anketa->top_end->time_task - time() > 48 * 3600) { ?>
            <span class="orange">до <?=date('d.m.Y', $anketa->top_end->time_task);?></span>
            <? } else { ?>
            <span class="pink">(часов: <?=ceil(($anketa->top_end->time_task-time())/3600);?>)</span>
            <? } ?>
        <a class="blue-button" href="/profile/top">ПРОДЛИТЬ ТОП</a>
        <?php else: ?>
        Ваша позиция в поиске: <span class="orange"><?=$anketa->place?></span>
        <a class="blue-button" href="/profile/up">ПОДНЯТЬ АНКЕТУ</a>
        <?php endif; ?>
    </div>
    <div class="top_wallet">
       <span class="orange">$</span> Кошелек: <span class="orange"><?=$anketa->balance?> руб.</span>
         <a class="blue-button" href="/profile/wallet">ПОПОЛНИТЬ КОШЕЛЕК</a>
    </div>

</div>