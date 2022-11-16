<?php
$blog_page_info = $db
    ->where('id',$page_data['cat_id'])
    ->getOne('pages');
if(!$blog_page_info)
{
    $Cpu->page404();
    exit;
}

$blog_curent_catalog_info = $db
    ->where('active', 1)
    ->where('id',$page_data['id'])
    ->getOne('blog', 'id, title_'.$lang.' as title');
if(!$blog_curent_catalog_info)
{
    $Cpu->page404();
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>

<!--Start breadcrumb area-->
<section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1>News Default</h1>
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
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li class="active"><?php echo $blog_curent_catalog_info['title'];?></li>
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
<!--Start blog area-->
<section id="blog-area" class="blog-default-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <?php
                $num_page = 6;
                $totalObjects=0;
                $start=0;
                $perPage = $num_page;
                if(!isset($_GET['page']) || !is_numeric($_GET['page'])){$page = 1;}else{$page = (int)$_GET['page'];}

                $get_totalObjects = $db
                    ->where('active', 1)
                    ->where('section_id', $pageData['elem_id'])
                    ->get('blog_elements');

                if(count($get_totalObjects)>0)
                {
                    $totalObjects = count($get_totalObjects);
                }

                $Count = $totalObjects;
                $Pages = ceil($Count/$perPage); if($page>$Pages){$page = $Pages;}
                $start = $page * $perPage - $perPage;
                if($start<0) {$start = 0;}
                ?>
                <div class="blog-post">
                    <?php
                    $get_blog_category_elements =  $db
                        ->where('active', 1)
                        ->where('section_id', $pageData['elem_id'])
                        ->orderBy('date', 'desc')
                        ->get('blog_elements',Array ($start, $perPage));
                    if($get_blog_category_elements && count($get_blog_category_elements) > 0)
                    {
                        ?>
                        <div class="row">
                            <?php
                            $blog_element_counter = 0;
                            foreach ($get_blog_category_elements as $blog_elements)
                            {
                                $blog_element_cpu = $Cpu->getURL(526, $blog_elements['id']);
                                $blog_element_counter++;
                                ?>
                                <div class="col-md-6">
                                    <div class="single-blog-item wow fadeInUp" data-wow-delay="0s" data-wow-duration="1s"
                                         data-wow-offset="0">
                                        <div class="img-holder">
                                            <?php
                                            $blog_elements_image_thumb = $Functions->image_thumb($blog_elements['image'], 'blog_elements', 363, 220, 200, 1);
                                            ?>
                                            <img src="<?php echo $blog_elements_image_thumb;?>" alt="<?php echo $blog_elements['title_'.$lang];?>">
                                            <div class="overlay-style-one">
                                                <div class="box">
                                                    <div class="content">
                                                        <a href="<?php echo $blog_element_cpu;?>"><span
                                                                    class="flaticon-plus-symbol"></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-holder">
                                            <a href="<?php echo $blog_element_cpu;?>">
                                                <h3 class="blog-title"><?php echo $blog_elements['title_'.$lang];?></h3>
                                            </a>
                                            <div class="text">
                                                <p><?php echo limiter(preview_text($blog_elements['preview_'.$lang]), 200);?></p>
                                            </div>
                                            <ul class="meta-info">
                                                <li>
                                                    <a href="<?php echo $blog_element_cpu;?>"><i class="fa fa-calendar" aria-hidden="true"></i>
                                                        <?php
                                                        $blog_date = new DateTime($blog_elements['date']);
                                                        echo $blog_date->format('F d, Y')
                                                        ?>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if($blog_element_counter%2 == 0)
                                {
                                    ?>
                                    <div class="both"></div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="nothing_founded">
                            <?php echo dictionary('PRODUCTS_NOTHING_FOUNDED');?>
                        </div>
                        <?php
                    }
                    ?>


                    <?php
                    include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/pagination.php';
                    ?>

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





