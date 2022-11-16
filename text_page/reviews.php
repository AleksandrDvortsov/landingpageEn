<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>

    <section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <h1><?php echo dictionary('HEADER_ABOUT_FAQ_REVIEWS');?></h1>
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
                                <li class="active"><?php echo dictionary('HEADER_ABOUT_FAQ_REVIEWS');?></li>
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
    <section class="testimonial-page">
        <div class="container">
            <div class="row masonary-layout">
                <?php
                $get_reviews_data_info = $db
                    ->where('active', 1)
                    ->get('reviews');
                if($get_reviews_data_info && count($get_reviews_data_info) >0)
                {
                    foreach ($get_reviews_data_info as $reviews_data_info)
                    {
                        ?>
                        <div class="col-md-6">
                            <div class="single-testimonial-item text-center">
                                <div class="img-box">
                                    <div class="img-holder">
                                        <?php
                                        $reviews_image_thumb = $Functions->image_thumb($reviews_data_info['image'], 'reviews', 79, 79, 579, 1);
                                        ?>
                                        <img src="<?php echo $reviews_image_thumb;?>" alt="<?php echo $reviews_data_info['fio'];?>">
                                    </div>
                                    <div class="quote-box">
                                        <i class="fa fa-quote-left" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="text-holder">
                                    <p><?php echo preview_text($reviews_data_info['text_'.$lang]);?></p>
                                </div>
                                <div class="name">
                                    <h3><?php echo $reviews_data_info['fio'];?></h3>
                                    <span><?php echo $reviews_data_info['city'];?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <div class="nothing_founded">
                        <?php echo dictionary('NOTHING_FOUNDED');?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>