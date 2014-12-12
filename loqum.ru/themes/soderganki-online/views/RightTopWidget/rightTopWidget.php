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
        $account_end_time = "(часов:".ceil($account_end_time/3600).")";
    else
        $account_end_time = "(дней:".ceil($account_end_time/3600/24).")";
}
?>

<ul class="user-mnu">
    <li class="li-1 nuclear">
        <?php if ($anketa->getAccountType() == Anketa::ACCOUNT_PREMIUM): ?>
        <span><?=$anketa->getAccountTypeText()?> аккаунт:  <b><?=$account_end_time;?></b></span> <a class="naw-but" href="/profile/premium">Продлить премиум</a>
        <?php elseif ($anketa->gender == Anketa::GENDER_MAN && $anketa->getAccountType() == Anketa::ACCOUNT_TRIAL): ?>
        <span><?=$anketa->getAccountTypeText()?> аккаунт: <b><?=$account_end_time;?></b></span> <a class="naw-but" href="/profile/premium">Купить премиум</a>
        <?php elseif ($anketa->gender == Anketa::GENDER_MAN): ?>
        <span><?=$anketa->getAccountTypeText()?>: <b>(ограничения)</b></span> <a class="naw-but" href="/profile/premium">Купить премиум</a>
        <?php endif; ?>
    </li>
    <li class="li-2 nuclear">
        <span>Осталось контактов: <b><?=$anketa->contact_count?></b></span>
        <a class="naw-but" href="/profile/contacts">Купить контакты</a>
    </li>
<?php if ($anketa->getTop()): ?>
    <li class="li-3 nuclear">
        <? if ($anketa->top_end->time_task - time() > 48 * 3600) { ?>
        <span>ТОП: до<b><?=date('d.m.Y', $anketa->top_end->time_task);?></b></span>
        <? } else { ?>
        <span>ТОП: <b>(часов:<?=ceil(($anketa->top_end->time_task-time())/3600);?>);?></b></span>
        <? } ?>
        <a class="naw-but" href="/profile/top">Продлить ТОП</a>
    </li>
<?php else: ?>
    <li class="li-3 nuclear">
        <span> Ваша позиция в поиске:&nbsp;<b><?=$anketa->place?></b></span>
    <a class="naw-but" href="/profile/up">ПОДНЯТЬ АНКЕТУ</a>
    </li>
<?php endif; ?>
    <li class="li-4 nuclear">
        <span>Кошелек:<b><?=$anketa->balance?> руб.</b></span>
        <a class="naw-but" href="/profile/wallet">Пополнить кошелек</a>
    </li>
</ul>