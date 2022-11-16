<?php 
$element = $db
    ->where('active', 1)
    ->where('id', $page_data['elem_id'])
    ->getOne('special_offers_elements');
if(!$element)
{
    $Cpu->page404();
    exit;
}


$offer_curent_catalog_info = $db
    ->where('active', 1)
    ->where('id',$element['section_id'])
    ->getOne('special_offers', 'id, title_'.$lang.' as title');
if(!$offer_curent_catalog_info)
{
    $Cpu->page404();
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>

<section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1><?php echo $element['title_'.$lang];?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="left pull-left">
                        <ul>
                            <li><a href="<?php echo $Cpu->getURL(100);?>"><?php echo dictionary('HEADER_HOME_PAGE'); ?></a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li>
                                <a href="<?php echo $Cpu->getURL(727);?>">
                                    <?php echo dictionary('HEADER_SPECIAL_OFFERS_PAGE'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $Cpu->getURL(728, $offer_curent_catalog_info['id']);?>">
                                    <?php echo $offer_curent_catalog_info['title']; ?>
                                </a>
                            </li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li class="active"><?php echo $element['title_'.$lang];?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Start rev slider wrapper-->
<section id="blog-area" class="blog-single-area">
    <div class="container">
        <div class="row">
            <div class="fusion-layout-column fusion_builder_column fusion_builder_column_3_5  fusion-three-fifth fusion-column-last 3_5">
                <?php
                if(isset($element['price']) && $element['price'] > 0)
                {
                    ?>
                    <div class="fusion-column-wrapper fusion-column-price"
                         style="background-color:#528fd0;padding: 15px 0px 15px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"
                         data-bg-url="">
                        <div class="fusion-column-content-centered">
                            <div class="fusion-column-content">
                                <div class="fusion-title title fusion-sep-none fusion-title-center fusion-title-size-four paket-price fusion-border-below-title"
                                     style="margin-top:2px;margin-bottom:2px;"><h4 class="title-heading-center"
                                                                                   data-fontsize="28"
                                                                                   data-lineheight="22"><?php echo $element['price'].' '.dictionary('LEI');?><br>
                                        <a class="scroll_to_bottom_form"><?php echo dictionary('FRONT_OFFER_DETAIL_KEY_0');?></a></h4></div>
                            </div>
                        </div>

                    </div>
                    <?php
                }
                ?>

                <div class="fusion-column-wrapper fusion-column-price-right"
                     style="padding: 20px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"
                     data-bg-url="">
                    <?php
                    if(isset($element['price']) && $element['price'] > 0)
                    {
                        ?>
                        <div class="fusion-title title fusion-sep-none fusion-title-center fusion-title-size-one doctor-title fusion-border-below-title"
                             style="margin-top:0px;margin-bottom:0px;">
                            <div class="title-heading-center dev_c" data-fontsize="30" data-lineheight="36">
                                <span style="color: #fff;"><?php echo $element['title_'.$lang];?></span>
                            </div>
                        </div>
                        <div class="fusion-title title fusion-sep-none fusion-title-center fusion-title-size-four doctor-subtitle fusion-border-below-title"
                             style="margin-top:0px;margin-bottom:20px;">
                            <h4 class="title-heading-center" data-fontsize="20" data-lineheight="30"><?php echo $element['undertitle_'.$lang];?></h4>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="fusion-title-single-center fusion-title title fusion-sep-none fusion-title-center fusion-title-size-one doctor-title fusion-border-below-title"
                             style="margin-top:0px;margin-bottom:0px;">
                            <div class="title-heading-center dev_h1_c" data-fontsize="30" data-lineheight="36">
                                <span style="color: #fff;"><?php echo $element['title_'.$lang];?></span>
                            </div>
                        </div>
                        <div class="fusion-title-single-center fusion-title title fusion-sep-none fusion-title-center fusion-title-size-four doctor-subtitle fusion-border-below-title"
                             style="margin-top:0px;margin-bottom:20px;">
                            <h4 class="title-heading-center" data-fontsize="20" data-lineheight="30"><?php echo $element['undertitle_'.$lang];?></h4>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="imageframe-align-center">
                            <span class="fusion-imageframe imageframe-none imageframe-1 hover-type-none doctor-image">
                                <?php
                                $elemnt_image_thumb = $Functions->image_thumb($element['image'], 'special_offers_elements', 1200, 770, 112, 0);
                                ?>
                                <img src="<?php echo $elemnt_image_thumb;?>" alt="<?php echo $element['title_'.$lang];?>">
                            </span>
                    </div>

                    <?php
                    if(isset($element['titleunderphoto_'.$lang]) && trim($element['titleunderphoto_'.$lang]) != '')
                    {
                        ?>
                        <div class="fusion-title title fusion-sep-none fusion-title-size-three doctor-sections-title fusion-border-below-title"
                             style="margin-top:10px;margin-bottom:10px;">
                            <h3 class="title-heading-left" data-fontsize="26" data-lineheight="37">
                                <?php echo $element['titleunderphoto_'.$lang];?>
                            </h3>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(isset($element['titleunderphoto2_'.$lang]) && trim($element['titleunderphoto2_'.$lang]) != '')
                    {
                        ?>
                        <div class="fusion-title title fusion-sep-none fusion-title-size-three doctor-sections-title fusion-border-below-title"
                             style="margin-top:10px;margin-bottom:10px;">
                            <h3 class="title-heading-left" data-fontsize="26" data-lineheight="37">
                                <?php echo $element['titleunderphoto2_'.$lang];?>
                            </h3>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="fusion-clearfix"></div>
                </div>
                <div class="fusion-column-text">
                    <p><?php echo db_text($element['text_'.$lang]);?></p>
                </div>
            </div>
        </div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/form_doctor_k1.php';
        ?>
    </div>
</section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>
