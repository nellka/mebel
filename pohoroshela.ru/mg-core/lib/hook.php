<?php

/**
 * Интерфейс Hook - используется для обработчки событий. Задает
 * объект содержащий информаццию о привязке пользовательской функции к событию, которое может произойти. 
 *
 * @author Авдеев Марк <mark-avdeev@mail.ru>
 * @package moguta.cms
 * @subpackage Libraries
 */
interface Hook {
  /**
   * Запускает пользовательскую функцию, передав в нее полученные параметры
   * @param type $arg - параметры переданные при инициализации события.
   */
  function run($arg);
}