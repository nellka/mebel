function confirm_delete($m){var result=prompt($m+"\nЧтобы продолжить, введите слово \"delete\".","");if(result!="delete"){if(result>""){alert("Неверное слово! Нужно: \"delete\" (без кавычек).");}}else return true;return false;}