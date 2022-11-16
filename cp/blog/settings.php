<?php
// $CATALOG_TREE -> Este permisa redactarea doar initia cind se creaza catalogul, este posibila alegerea nivelelor
$CATALOG_TREE = 1; // Cite nivele va avea catalogul
$num_page = 15; // PAGINAREA. Cite elemente vor fi afisate pe o pagina

// !!!!!!!!!!!REDACTAREA ESTE INTERSIZA!!!!!!!!!!
$db_catalog_table = 'blog';
$db_catalog_elements_table = 'blog_elements';

$db_front_cpu_table = 'cpu';

$CPU_CATEGORY_ID = 525; // cimpul ID pentru catalog, din tabelul 'pages'
$CPU_ELEM_ID = 526; // cimpul ID pentru elementele catalogului , din tabelul 'pages' /catalog/pruduct_detail.php

?>