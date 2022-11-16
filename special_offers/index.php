<?php
$blog_page_info = $db
    ->where('id',$page_data['cat_id'])
    ->getOne('pages');
if(!$blog_page_info)
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
                    <h1><?php echo dictionary('HEADER_SPECIAL_OFFERS_PAGE');?></h1>
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
                            <li class="active"><?php echo dictionary('HEADER_SPECIAL_OFFERS_PAGE');?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$get_special_offers_data_info = $db
    ->where('active', 1)
    ->get('special_offers');
if($get_special_offers_data_info && count($get_special_offers_data_info))
{
    ?>
    <section class="medical-departments-area departments-page special-offers">
        <div class="container">
            <div class="row">
                <div class="sec-title mar0auto text-center">
                    <div class="dev_g"><?php echo dictionary('FRONT_SPECAIL_OFFERS_PAGE_KEY_0');?></div>
                    <span class="border"></span>
                </div>
                <?php
                foreach ($get_special_offers_data_info as $special_offers_data_info)
                {
                    $offert_cpu = $Cpu->getURL(728, $special_offers_data_info['id']);
                    ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <a href="<?php echo $offert_cpu;?>">
                            <div class="single-item text-center">
                                <div class="iocn-holder">
                                    <div class="icon_dep">
                                        <?php
                                        $sp_off_imagethumb = $Functions->image_thumb($special_offers_data_info['image'], 'special_offers', 80, 80, 26, 0);
                                        ?>
                                        <img src="<?php echo $sp_off_imagethumb;?>" alt="<?php echo $special_offers_data_info['title_'.$lang];?>">
                                    </div>
                                    <span class="btn-opens">
                                        <button onclick="location.href='<?php echo $offert_cpu;?>';">
                                            <?php echo dictionary('FRONT_UNIVERSAL_WORD_KEY_OPEN');?>
                                        </button>
                                    </span>
                                </div>
                                <div class="text-holder">
                                    <h3><?php echo $special_offers_data_info['title_'.$lang];?></h3>
                                    <p><?php echo preview_text($special_offers_data_info['text_'.$lang]);?></p>
                                </div>
                                <a class="readmore" href="<?php echo $offert_cpu;?>"><?php echo dictionary('FRONT_DETAILS');?></a>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <?php
}
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>



