<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';

//show($page_data);

$db_table = $page_data['db_table'];
$detail_page_id = $page_data['detail_page_id']; // id-ul la pagina detaliata pentru elementele care for fi afisate /$db_table/detail.

?>
<style>
    #main_block
    {
        width: 1000px;
        margin: 0 auto;
        padding: 0 15px;
    }
    .news_block
    {
        width: 230px;
        height: 300px;
        background: #f2f5f7;
        float: left;
        padding: 15px;
        margin-right: 12px;
        overflow: hidden;
    }

    .news_block .preview
    {
        margin-top: 10px;
        color: gray;
        font-size: 10px;
    }

</style>











<div id="main_block">
    <div style="clear:both; margin-bottom: 50px;text-align: center;">
        <?php // LANG
        foreach ($list_of_site_langs as $site_lang)
        {
            if($site_lang!=$Main->lang)
            {
                ?>
                <a style="color: red; margin-right: 10px;" href="<?php echo $Cpu->getURLbyLang($page_data['cat_id'],$page_data['elem_id'], $site_lang);?>">
                    <?php echo mb_ucfirst($site_lang);?>
                </a>
                <?php
            }
        }
        ?>
    </div>

    <?php
    $get_table_info = $db
        ->where('active', 1)
        ->orderBy('date', 'desc')
        ->get($db_table);

    foreach ($get_table_info as $table_info)
    {
        /* show parent elements */
        ?>
        <div class="news_block">
            <a href="<?php echo $Cpu->getURL($detail_page_id, $table_info['id']);?>">
                <div class="image">
                    <?php
                    $thumb_image = @newthumbs($table_info['image'], $db_table, 200,150,9,1);
                    if($thumb_image)
                    {
                        ?>
                        <img src = "<?php echo $thumb_image; ?>" alt="<?php echo $table_info['title_'.$Main->lang];?>" title="<?php echo $table_info['title_'.$Main->lang];?>">
                        <?php
                    }
                    ?>
                </div>
                <div class="date"><?php echo $table_info['date'];?></div>
                <div class="title"><?php echo $table_info['title_'.$Main->lang];?></div>
                <div class="preview"><?php echo limiter(preview_text($table_info['preview_'.$Main->lang]), 150);?></div>
            </a>
        </div>

        <?php
    }
    ?>

</div>









<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>


