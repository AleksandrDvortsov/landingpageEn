<?php
// $CATALOG_TREE -> Este permisa redactarea doar initia cind se creaza catalogul, este posibila alegerea nivelelor
$CATALOG_TREE = 2; // Cite nivele va avea catalogul ( Dupa SEO -> sfat maxim 2 subcategorii 'maximum' )
$num_page = 15; // PAGINAREA. Cite elemente vor fi afisate pe o pagina


// !!!!!!!!!!!REDACTAREA ESTE INTERSIZA!!!!!!!!!!
$db_catalog_table = 'catalog';
$db_catalog_elements_table = 'catalog_elements';
$db_catalog_elements_parameters_table = 'catalog_elements_parameters';
$db_catalog_elements_images = 'catalog_elements_images';

$db_filter_options_table = 'filter_options';
$db_filter_options_values_table = 'filter_options_values';

$db_front_cpu_table = 'cpu';

$CPU_CATEGORY_ID = 94; // cimpul ID pentru catalog, din tabelul 'pages'
$CPU_ELEM_ID = 95; // cimpul ID pentru elementele catalogului , din tabelul 'pages' /catalog/pruduct_detail.php



?>