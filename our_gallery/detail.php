<?php
$element = $db
    ->where('active', 1)
    ->where('id',$page_data['elem_id'])
    ->getOne('our_gallery');
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
                            <li><a href="<?php echo $Cpu->getURL(754);?>"><?php echo dictionary('HEADER_OUR_GALLERY'); ?></a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li class="active"><?php echo $element['title_'.$lang];?></li>
                        </ul>
                    </div>
                    <div class="right pull-right">
                        <a href="#">

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="project-single-area">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="project-single-carousel">
                    <div class="single-project-item">
                        <div class="img-holder">
                            <?php
                            $element_thumb_image = $Functions->image_thumb($element['image'], 'our_gallery', 720, 500, 850, 0);
                            ?>
                            <img src="<?php echo $element_thumb_image;?>" alt="<?php echo $element['title_'.$lang];?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="project-info">
                    <div class="inner-content">
                        <h2><?php echo $element['title_'.$lang];?></h2>
                        <br>
                        <p><?php echo db_text($element['text_'.$lang]);?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="container main-project-area dev_show"> 
        <div class="row">
            <div class="row">
                <?php
                $get_dropzone_images = $db
                    ->where('parent_id', $element['id'])
                    ->orderBy('sort', 'asc')
                    ->get('our_gallery_dropzone_1_images');

                if($get_dropzone_images && count($get_dropzone_images)>0)
                {
                    ?>
                    <p class="imglist">
                        <?php
                        foreach($get_dropzone_images as $dropzone_images)
                        {
                            $thumb_image = @newthumbs($dropzone_images['image'], 'our_gallery_dropzone_1_images', 300,200,741,1);
                            $thumb_image_BIGSIZE = @newthumbs($dropzone_images['image'], 'our_gallery_dropzone_1_images');
                            if($thumb_image)
                            {
                                ?>
                                <a href="<?php echo $thumb_image_BIGSIZE;?>"
                                   data-fancybox="/images">
                                    <img src="<?php echo $thumb_image;?>"/>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </p>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>


