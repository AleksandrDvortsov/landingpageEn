<?php
// dropzone files
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
//show($page_data);
$db_table = $page_data['db_table'];
?>

<style>
    #main_block
    {
        width: 1000px;
        margin: 0 auto;
        padding: 0 15px;
    }
</style>

<div id="main_block">
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
    $dropzone_table_info = $db
        ->where("id", $page_data['parrent'])
        ->getOne("pages", "dropzone_image_table1, dropzone_image_table2, dropzone_image_table3");

    //show($dropzone_table_info);

    $element = $db
        ->where("id", $page_data['id'])
        ->getOne($db_table);

    if($element)
    {
        ?>
        <div><?php echo $element['date'];?></div>
        <div><?php echo preview_text($element['text_'.$Main->lang]);?></div>
        <?php

        // ------------------------- afisam elementele din dropzone_image_table1 -----------------------------
        if(!empty($dropzone_table_info['dropzone_image_table1']))
        {
            $get_dropzone_images = $db
                ->where('parent_id', $element['id'])
                ->orderBy('sort', 'asc')
                ->get($dropzone_table_info['dropzone_image_table1']);

            if( count($get_dropzone_images) > 0 )
            {
                ?>
                <div style="clear:both; width: 100%;"></div>
                <div style="font-size: 18px; color: #fb9678; text-align: center; margin: 50px 0 20px 0;"><?php echo dictionary('DROPZONE_IMAGE1');?></div>
                <?php
                foreach($get_dropzone_images as $dropzone_images)
                {
                    $thumb_image = @newthumbs($dropzone_images['image'], $dropzone_table_info['dropzone_image_table1'], 150,150,15,0);
                    if($thumb_image)
                    {
                        ?>
                        <div style="float: left; margin-right: 25px;">
                            <img src = "<?php echo $thumb_image; ?>" title="<?php echo $dropzone_images['original_file_name'];?>">
                        </div>
                    <?php
                    }
                }
            }
        }
        // END: ------------------------- afisam elementele din dropzone_image_table1 -----------------------------


        // ------------------------- afisam elementele din dropzone_image_table2 -----------------------------
        if(!empty($dropzone_table_info['dropzone_image_table2']))
        {
            $get_dropzone_images = $db
                ->where('parent_id', $element['id'])
                ->orderBy('sort', 'asc')
                ->get($dropzone_table_info['dropzone_image_table2']);

            if( count($get_dropzone_images) > 0 )
            {
                ?>
                <div style="clear:both; width: 100%;"></div>
                <div style="font-size: 18px; color: #fb9678; text-align: center; margin: 75px 0 20px 0;"><?php echo dictionary('DROPZONE_IMAGE2');?></div>
                <?php
                foreach($get_dropzone_images as $dropzone_images)
                {
                    $thumb_image = @newthumbs($dropzone_images['image'], $dropzone_table_info['dropzone_image_table2'], 150,150,15,0);
                    if($thumb_image)
                    {
                        ?>
                        <div style="float: left; margin-right: 25px;">
                            <img src = "<?php echo $thumb_image; ?>" title="<?php echo $dropzone_images['original_file_name'];?>">
                        </div>
                    <?php
                    }
                }
            }
        }
        // END: ------------------------- afisam elementele din dropzone_image_table2 -----------------------------

        // ------------------------- afisam elementele din dropzone_image_table3 -----------------------------
        if(!empty($dropzone_table_info['dropzone_image_table3']))
        {
            $get_dropzone_images = $db
                ->where('parent_id', $element['id'])
                ->orderBy('sort', 'asc')
                ->get($dropzone_table_info['dropzone_image_table3']);

            if( count($get_dropzone_images) > 0 )
            {
                ?>
                <div style="clear:both; width: 100%;"></div>
                <div style="font-size: 18px; color: #fb9678; text-align: center; margin: 75px 0 20px 0;"><?php echo dictionary('DROPZONE_IMAGE3');?></div>
                <?php
                foreach($get_dropzone_images as $dropzone_images)
                {
                    $thumb_image = @newthumbs($dropzone_images['image'], $dropzone_table_info['dropzone_image_table3'], 150,150,15,0);
                    if($thumb_image)
                    {
                        ?>
                        <div style="float: left; margin-right: 25px;">
                            <img src = "<?php echo $thumb_image; ?>" title="<?php echo $dropzone_images['original_file_name'];?>">
                        </div>
                    <?php
                    }
                }
            }
        }
        // END: ------------------------- afisam elementele din dropzone_image_table3 -----------------------------



    }
    ?>

</div>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>


