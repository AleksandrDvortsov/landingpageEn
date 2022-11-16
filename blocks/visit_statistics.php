<?php
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $visitor_ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $visitor_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $visitor_ip = $_SERVER['REMOTE_ADDR'];
}
$today = new DateTime('today');

// Initial ne uitam daca acest visitator a mai intrat pe sait
$check_visitator_info = $db
    ->where('ip_address', ip2long($visitor_ip))
    ->where('date', $today->format("y-m-d"))
    ->getOne('visit_statistics');
if($check_visitator_info)
{
    $views = $check_visitator_info['views'] + 1;
    $visitator_data = Array (
        "views" => $views
    );

    $update_visitator_data = $db
        ->where ('id', $check_visitator_info['id'])
        ->update ('visit_statistics', $visitator_data, 1);
}
else
{
    $visitator_data = Array (
        "ip_address" =>  ip2long($visitor_ip),
        "date" => $today->format("y-m-d"),
        "views" => 1
    );

    $insert_visitator_data_info = $db->insert ('visit_statistics', $visitator_data);
}
?>