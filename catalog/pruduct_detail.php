<?php
$element = $db
    ->where('active', 1)
    ->where('id', $page_data['elem_id'])
    ->getOne('catalog_elements');
if(!$element)
{
    $Cpu->page404();
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';

$get_dropzone_images = $db
    ->where('parent_id', $element['id'])
    ->orderBy('sort', 'asc')
    ->get('catalog_elements_images');
?>

<section class="noo-page-heading">
    <div class="container">
        <h1 class="page-title"><?php echo $element['title_'.$lang];?></h1>
    </div><!-- /.container-boxed -->
</section>
<div id="main" class="main-content container commerce single-product shop-container">
    <!-- Begin The loop -->
    <div class="row">
        <?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/shop-stdebar-left.php'; ?>
        <div class="noo-main col-md-8">
            <div class="product">
                <div class="noo-product-content">
                    <div class="images">
                        <?php
                        if( $get_dropzone_images && count($get_dropzone_images) > 0 )
                        {
                            $sp_element_counter = 1;
                            foreach($get_dropzone_images as $dropzone_images)
                            {
                                $thumb_image = @newthumbs($dropzone_images['image'], 'catalog_elements_images', 720,940,40,1);
                                $thumb_original_image = @newthumbs($dropzone_images['image'], 'catalog_elements_images');
                                if($thumb_image)
                                {
                                    if($sp_element_counter == 1)
                                    {
                                        ?>
                                        <a href="<?php echo $thumb_original_image; ?>" class="commerce-main-image zoom full-image active-image" data-attr="<?php echo $sp_element_counter;?>" data-rel="prettyPhoto">
                                            <img width="720" height="940" src="<?php echo $thumb_image; ?>" alt="<?php echo $dropzone_images['original_file_name'];?>" />
                                        </a>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <a href="<?php echo $thumb_original_image; ?>" class="commerce-main-image zoom full-image" href="#" data-attr="<?php echo $sp_element_counter;?>" data-rel="prettyPhoto">
                                            <img width="720" height="940" src="<?php echo $thumb_image; ?>" alt="<?php echo $dropzone_images['original_file_name'];?>" />
                                        </a>
                                        <?php
                                    }
                                    $sp_element_counter++;
                                }
                            }
                        }
                        ?>
                        <div class="image-thumb">
                            <?php
                            if( $get_dropzone_images && count($get_dropzone_images) > 0 )
                            {
                                $sp_element_counter = 1;
                                foreach($get_dropzone_images as $dropzone_images)
                                {

                                    $thumb_image = @newthumbs($dropzone_images['image'], 'catalog_elements_images', 352,460,41,1);
                                    if($thumb_image)
                                    {
                                        ?>
                                        <a class="thumb-item" href="#" data-attr="<?php echo $sp_element_counter;?>">
                                            <img width="352" height="460" src="<?php echo $thumb_image; ?>" alt="<?php echo $dropzone_images['original_file_name'];?>" />
                                        </a>
                                        <?php

                                        $sp_element_counter++;
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="summary entry-summary">
                        <h1 class="product_title entry-title">
                            <?php echo $element['title_'.$lang];?>
                            <?php echo element_editor(75, $element['id']);?>
                        </h1>
                        <div class="product-description">
                            <?php echo db_text( $element['text_'.$lang] );?>
                        </div>
                    </div><!-- .summary -->
                </div>
            </div>
        </div>
    </div>

    <?php
    $get_category_elements = $db
        ->where('active', 1)
        ->where('section_id', $element['section_id'])
        ->where('id', $element['id'], '<>')
        ->get('catalog_elements', 4);
    if($get_category_elements && count($get_category_elements)>0)
    {
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="related products">
                    <div class="title-center">
                        <h2><?php echo dictionary('FRONT_PRODUCT_FROM_SAME_CATEGORY');?></h2>
                    </div>
                    <div class="products row">
                        <?php
                            foreach ( $get_category_elements as $element_info )
                            {
                                ?>
                                <div class="col-md-3 col-sm-6 col-xs-6 noo-product-item product">
                                    <div class="noo-product-inner">
                                        <div class="woo-thumbnail">
                                            <div class="bk"></div>
                                            <?php
                                            $product_url = $Cpu->getURL(95, $element_info['id']);
                                            ?>
                                            <a href="<?php echo $product_url;?>">
                                                <?php
                                                $imagethumg = '';
                                                $db_table = 'catalog_elements';
                                                $image_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $db_table . '/' . $element_info['image'];
                                                if (isset($element_info['image']) && $element_info['image'] != "" && is_file($image_path)) {
                                                    $imagethumg = newthumbs($element_info['image'], $db_table, 435, 570, 29, 1);
                                                }
                                                ?>
                                                <img width="270" height="350" src="<?php echo $imagethumg; ?>" alt="<?php echo $element_info['title_'.$lang];?>" />
                                            </a>
                                            <div class="noo-product-meta">
                                                <div class="entry-cart-meta">
                                                    <a href="<?php echo $product_url;?>" class="button add_to_cart_button">
                                                        <?php echo dictionary('FRONT_SEE_PRODUCT');?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="noo-product-footer">
                                            <h3><a href="<?php echo $product_url;?>">
                                                    <?php echo $element_info['title_'.$lang];?>
                                                </a>
                                                <?php echo element_editor(75, $element_info['id']);?>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!-- End The loop -->
</div> <!-- /.main -->


<?php include $_SERVER['DOCUMENT_ROOT'].'/blocks/contact_form_container.php';?>


<div class="container-fluid">
    <div class="row row-fluid pt-10 pb-2">
    </div>
</div>
<div class="container-fluid">
    <div class="row row-fluid pt-5">
    </div>
</div>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>


