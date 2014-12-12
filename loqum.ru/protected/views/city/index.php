<h1>Все города</h1>
<?php /** @var $cities array */
$this->pageTitle = 'Все города. Геи в городах России.';
$numrows = 3;
$i = 0;
$per_row = (int)(count($cities) + 2) / 3;
echo "<div style='margin-left:50px; width:30%; float:left;'>";
foreach ($cities as $city) {
    if (++$i >= $per_row)
        if (!$i = 0)
            print("</div><div style='width:30%; float:left;'>");
    echo CHtml::link($city->name, $city->link), '<br>';
}
echo "</div>";
echo "<br clear='all'><br><br>";