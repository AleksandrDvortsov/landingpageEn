<?php 
$element = $db
    ->where('active', 1)
    ->where('id', $page_data['elem_id'])
    ->getOne('blog_elements');
if(!$element)
{
    $Cpu->page404();
    exit;
}


$blog_curent_catalog_info = $db
    ->where('active', 1)
    ->where('id',$element['section_id'])
    ->getOne('blog', 'id, title_'.$lang.' as title');
if(!$blog_curent_catalog_info)
{
    $Cpu->page404();
    exit;
}
// update viewed page
$increment_viewed = $element['viewed']+1;
$update_viewed_elemet_info = $db
    ->where ('id', $element['id'])
    ->update ('blog_elements', Array('viewed' =>  $increment_viewed), 1);

require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>

<!-- Start breadcrumb area -->
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
                                <a href="<?php echo $Cpu->getURL(524);?>">
                                    <?php echo dictionary('HEADER_JURNAL_PAGE'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $Cpu->getURL(525, $blog_curent_catalog_info['id']);?>">
                                    <?php echo $blog_curent_catalog_info['title']; ?>
                                </a>
                            </li>

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
<!--End breadcrumb area-->
<!--Start blog Single area-->
<section id="blog-area" class="blog-single-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="blog-post">
                    <div class="single-blog-item">
                        <div class="img-holder">
                            <?php
                            $blog_element_image_thumb = $Functions->image_thumb($element['image'], 'blog_elements', 730, 420, 500, 0);
                            ?>
                            <img src="<?php echo $blog_element_image_thumb;?>" alt="<?php echo $element['image'];?>">
                        </div>
                        <div class="text-holder">
                            <h3 class="blog-title"><?php echo $element['title_'.$lang];?></h3>
                            <div class="text dev__editor">
                                <p><?php echo db_text($element['text_'.$lang]);?></p>
                            </div>
                        </div>
                    </div>

                    <!--Start tag and social share box-->
                    <div class="tag-social-share-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="blog-share-icon text-left text-md-right">
                                    <script type="text/javascript">(function () {
                                            if (window.pluso) if (typeof window.pluso.start == "function") return;
                                            if (window.ifpluso == undefined) {
                                                window.ifpluso = 1;
                                                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                                                s.type = 'text/javascript';
                                                s.charset = 'UTF-8';
                                                s.async = true;
                                                s.src = ('https:' == window.location.protocol ? 'https' : 'http') + '://share.pluso.ru/pluso-like.js';
                                                var h = d[g]('body')[0];
                                                h.appendChild(s);
                                            }
                                        })();
                                    </script>

                                    <div class="pluso" data-background="transparent"
                                         data-options="big,square,line,horizontal,counter,theme=08"
                                         data-services="facebook,vkontakte,twitter,google"
                                         data-url="<?php echo $actual_link;?>"
                                         data-title="<?php echo preview_text($element['title_'.$lang]);?>" data-description="<?php echo preview_text($element['preview_'.$lang]);?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End tag and social share box-->
                </div>
            </div>

            <?php
            require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/jurnal_right_sidebar.php';
            ?>
        </div>
    </div>
</section>


<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>
