<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
header("Content-type: text/xml");
echo'<?xml version=\'1.0\' encoding=\'UTF-8\'?>';
echo'   <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

// sitemap_lang_page_array -> care limbi vor participa la indexare
$sitemap_lang_page_array = array('ru','ro','en');
// exception_page -> masivul unde se poate de introdus paginile exceptsii pentru formarea linkurilor de indexare
$exception_page = array(101);  // 101 -> ajax page

$get_all_front_pages = $db
    ->where('id', $exception_page, 'NOT IN')
    ->where('type', array(1,7), 'IN')
    ->orderBy('id', 'DESC')
    ->groupBy('id')
    ->get('pages', null, 'id');

if($get_all_front_pages)
{
    $url_front_part = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
    foreach($get_all_front_pages as $page)
    {
        $get_all_cpu_part_of_curent_page_id = $db
            ->where('page_id', $page['id'])
            ->where('lang', $sitemap_lang_page_array , 'IN')
            ->orderBy('elem_id', 'ASC')
            ->groupBy('id')
            ->get('cpu');
        //  show($get_all_cpu_part_of_curent_page_id);
        foreach($get_all_cpu_part_of_curent_page_id as $cpu_page)
        {
            // exemplu pentru pagini care trebu de scos din indexare
            if(
                !($cpu_page['page_id'] == 526 && $cpu_page['elem_id'] == 0)
               // exeplu de adaugare a exceptsiei -> && !($cpu_page['page_id'] == 769 && $cpu_page['elem_id'] == 0)
            )
            {
                $url_cpu_part = $Cpu->getURLbyLang($cpu_page['page_id'],$cpu_page['elem_id'],$cpu_page['lang']);
                if($url_cpu_part != false)
                {
                    ?>
                    <url>
                        <loc><?php echo $url_front_part.$url_cpu_part;?></loc>
                        <changefreq>weekly</changefreq>
                        <priority>0.7</priority>
                    </url>
                    <?php
                }
            }


        }
    }
}

?>
</urlset>