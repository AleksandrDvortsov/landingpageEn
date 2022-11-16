<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>
    <!--End header-search area-->
    <section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <h1><?php echo $page_data['title'];?></h1>
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
                                <li class="active"><?php echo $page_data['title'];?></li>
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="blog-post">
                        <div class="single-blog-item">
                            <div class="text-holder">
                                <h2 class="blog-title text-center"><?php echo $page_data['title'];?></h2>
                                <div class="text">
                                    <p>
                                        <?php echo db_text($page_data['text']);?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>