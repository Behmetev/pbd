<?php
//phpinfo();
// Соединение, выбор базы данных

include_once 'dbconn.php';

$dbconn = pg_connect("host=" . $DBHost . " dbname=" . $DBName . " user=" . $DBUser . " password=" . $DBPass)
or die('Не удалось соединиться: ' . pg_last_error());

// Выполнение SQL-запроса
$query = "SELECT * FROM sales 
WHERE checkdate > now() - interval '1 day'
ORDER BY checkdate DESC";

$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());

// Вывод результатов в HTML
echo "<table>\n";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

// Очистка результата
pg_free_result($result);

// Закрытие соединения
pg_close($dbconn);
