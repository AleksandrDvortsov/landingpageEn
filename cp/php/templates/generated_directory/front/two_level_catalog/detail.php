<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
$db_table = $page_data['db_table'];
?>

<div style="text-align: center;margin: 25px auto;">
    <?php
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


$element = $db
    ->where("id", $page_data['id'])
    ->getOne($db_table);

if($element)
{
    ?>

    <div class="clear"></div>
    <?php
    $thumb_image = @newthumbs($element['image'], $db_table, 500,500,10,0);
    if($thumb_image)
    {
        ?>
        <div style="margin: 0 auto; width: 100%; text-align: center;">
            <img src = "<?php echo $thumb_image; ?>" title="<?php echo $element['title_'.$Main->lang];?>">
        </div>
        <?php
    }
    ?>
    <div style="margin: 25px auto; width: 100%; text-align: center;padding: 0 100px;">
        <span><?php echo $element['date'];?></span>
        <div><?php echo $element['title_'.$Main->lang];?></div>
        <div><?php echo preview_text($element['text_'.$Main->lang]);?></div>
    </div>
    <?php

}

require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>


