<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>

    <div style="text-align: center; width: 1000px;  margin: 0 auto;">
        <?php
        foreach ($list_of_site_langs as $site_lang)
        {
            if($site_lang!=$Main->lang)
            {
                ?>
                <a style="color: red; margin-right: 10px;" href="<?php echo $Cpu->getURLbyLang($pageData['page_id'],$pageData['elem_id'], $site_lang);?>">
                    <?php echo mb_ucfirst($site_lang);?>
                </a>
                <?php
            }
        }
        ?>



        <?php echo html_entity_decode($page_data['text']);?>
    </div>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>