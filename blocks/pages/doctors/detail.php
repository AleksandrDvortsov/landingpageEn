<?php
$element = $db
    ->where('active', 1)
    ->where('id', $page_data['elem_id'])
    ->getOne('doctors');
if(!$element)
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
                    <h1><?php echo $page_data['page_title']; ?></h1>
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
                            <li><a href="<?php echo $Cpu->getURL('100'); ?>"><?php echo dictionary('HEADER_HOME_PAGE'); ?></a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li><a href="<?php echo $Cpu->getURL('702'); ?>"><?php echo dictionary('HEADER_TEAM_PAGE'); ?></a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li class="active"><?php echo $page_data['page_title']; ?></li>
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
                <div class="fusion-column-wrapper" style="padding: 20px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                    <div class="col-md-6">

                        <div class="imageframe-align-center">
                                <span class="fusion-imageframe imageframe-none imageframe-1 hover-type-none doctor-image">
                                    <?php
                                    $doctor_image = $db
                                        ->where('parent_id', $element['id'])
                                        ->getOne('doctors_images');
                                    $thumb_image = @newthumbs($doctor_image['image'], 'doctors_images','570','400',230,0);
                                    ?>
                                    <img style="max-height: 400px;width: unset;" src="<?php echo $thumb_image; ?>">
                                </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fusion-title title fusion-sep-none fusion-title-center fusion-title-size-one doctor-title fusion-border-below-title dev_a123" style="margin-top:0px;margin-bottom:0px;">
                            <div class="title-heading-center dev_j" data-fontsize="30" data-lineheight="36">
                                <span style="color: #fff;"><?php echo $element['title_'.$lang]; ?></span>
                            </div>
                        </div>
                        <div class="fusion-title title fusion-sep-none fusion-title-center fusion-title-size-four doctor-subtitle fusion-border-below-title" style="margin-top:0px;margin-bottom:20px;">
                            <h4 class="title-heading-center" data-fontsize="20" data-lineheight="30">
                                <?php echo htmlspecialchars_decode($element['text_2_'.$lang]); ?>
                            </h4>
                        </div>
                        <div class="fusion-title title fusion-sep-none fusion-title-center fusion-title-size-three doctor-regalii fusion-border-below-title" style="margin-top:20px;margin-bottom:30px;">
                            <h3 class="title-heading-center" data-fontsize="22" data-lineheight="31">
                                <div class="regalii-line">
                                    <div class="reg-1 ">
                                        <img class="size-full wp-image-2152" src="https://amcenter.com.ua/wp-content/uploads/2017/04/shapka.png" alt="shapka" width="52" height="45">
                                        <div class="dev__editor"><?php echo db_text($element['text_3_'.$lang]); ?></div>
                                    </div>
                                    <div class="reg-2">
                                        <img class="size-full wp-image-2153" src="https://amcenter.com.ua/wp-content/uploads/2017/04/microskop.png" alt="microskop" width="37" height="47">
                                        <div class="dev__editor"><?php echo db_text($element['text_4_'.$lang]); ?></div>
                                    </div>
                                </div>
                            </h3>
                        </div>
                    </div>
                    <div class="both"></div>
                    <div class="fusion-title title fusion-sep-none fusion-title-size-three doctor-sections-title fusion-border-below-title" style="margin-top:10px;margin-bottom:10px;">
                        <h3 class="title-heading-left" data-fontsize="26" data-lineheight="37">
                            <?php echo htmlspecialchars_decode($element['text_5_'.$lang]); ?>
                        </h3>
                    </div>
                    <div class="fusion-builder-row fusion-builder-row-inner fusion-row ">
                        <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-first fusion-one-half fusion-column-first 1_2" style="margin-top: 0px;margin-bottom: 20px;width:100%;margin-right:4%;">
                            <?php echo htmlspecialchars_decode($element['text_'.$lang]); ?>
                        </div>

                    </div>
 
                    <div class="fusion-clearfix"></div>
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
