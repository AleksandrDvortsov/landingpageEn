<?php
// $CATALOG_TREE -> Este permisa redactarea doar initia cind se creaza catalogul, este posibila alegerea nivelelor
$CATALOG_TREE = 1; // Cite nivele va avea catalogul
$num_page = 15; // PAGINAREA. Cite elemente vor fi afisate pe o pagina

$db_catalog_table = 'special_offers';
$db_catalog_elements_table = 'special_offers_elements';

$db_front_cpu_table = 'cpu';

$CPU_CATEGORY_ID = 728;
$CPU_ELEM_ID = 729;


$elements_catID_with_price = array(3,4); // 3 - catalogul cu reduceri; 4 - catalogul cu cadouri
$elements_catID_NO_DELETING = array(3,4,5); // cataloagele fixe, care nu trebuies sterse
?>