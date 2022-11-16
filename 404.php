<?php
global $Main,$db,$Cpu,$Functions,$Form,$User;
global $GLOBALS, $list_of_site_langs,$developer_access,$client_access,$user_access,$manager_access,$only_manager_access;
global $css_version, $http_referer, $actual_link;
//==================================================================================================================//

if( isset($_SESSION['last_lang']) && trim($_SESSION['last_lang']) != '')
{
    $lang = $_SESSION['last_lang'];
}
else
{
    $lang = $Main->lang;
}

?>
<script>
    document.location.href = '<?php echo $Cpu->getUrl(100);?>';
</script>
<?php
exit; 
//=====================================================================//
$pageData = array();
$cpu = $db
    ->where('page_id', 6)
    ->where('lang', $lang)
    ->getOne('cpu');

if(!empty($cpu))
{
    // page_id, lang, elem_id
    $page_data = $db
        ->where('id',$cpu['page_id'])
        ->getOne('pages', 'page');

    if(!empty($page_data))
    {
        $pageData['page_id'] = $cpu['page_id'];
        $pageData['lang'] = $cpu['lang'];
        $pageData['elem_id'] = $cpu['elem_id'];
        $pageData['cpu'] = '';
    }
}
//====================================================================//
$Main->lang = $pageData['lang'];
// Массив словаря для текущего языка
$GLOBALS['ar_define_langterms'] = $Main->GetDefineLangTerms();
$_SESSION['last_lang'] = $pageData['lang'];

$page_data = $Cpu->GetPageData($pageData);


// cutpageinfo - вспомогательный массив для вывода блока с хлебными крошками, названием странице и автоматической генерации кнопки назад
$cutpageinfo = array('cpu' => $pageData['cpu'], 'title' => $page_data['title'], 'lang' => $Main->lang);

$lang = $Main->lang;

require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';

?>


<section id="blog-area" class="blog-single-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="blog-post">
                    <div class="single-blog-item">
                        <div class="text-holder">
                            <h2 class="blog-title text-center"><?php echo dictionary('FRONT_PAGE_404_LINE1');?></h2>
                            <div class="text">
                                <p>
                                    <?php echo db_text($page_data['text']);?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>


