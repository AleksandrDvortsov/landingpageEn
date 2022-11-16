<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>
    <!--Start breadcrumb area-->
    <section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <h1><?php echo dictionary('HEADER_ABOUT_US_PAGE');?></h1>
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
                                <li class="active"><?php echo dictionary('HEADER_ABOUT_US_PAGE');?></li>
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
    <!--Start welcome area-->
    <section class="welcome-area">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="img-holder">
                        <img src="/css/images/amc_e2.png" alt="Awesome Image">
                    </div>
                    <div class="inner-content">
                        <p><?php echo dictionary('FRONT_WELCOME_TO_HOSTPITAL_KEY_A0');?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-holder">
                        <div class="title">
                            <div class="dev_d"><?php echo dictionary('FRONT_WELCOME_TO_HOSTPITAL_KEY0');?></div>
                            <p><?php echo dictionary('FRONT_WELCOME_TO_HOSTPITAL_KEY1');?></p>
                        </div>
                        <ul>
                            <li>
                                <div class="single-item">
                                    <div class="iocn-box">
                                        <span class="flaticon-shapes"></span>
                                    </div>
                                    <div class="text-box">
                                        <h3><?php echo dictionary('FRONT_WELCOME_TO_HOSTPITAL_KEY2');?></h3>
                                        <p><?php echo dictionary('FRONT_WELCOME_TO_HOSTPITAL_KEY3');?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="single-item">
                                    <div class="iocn-box">
                                        <span class="flaticon-technology-2"></span>
                                    </div>
                                    <div class="text-box">
                                        <h3><?php echo dictionary('FRONT_WELCOME_TO_HOSTPITAL_KEY4');?></h3>
                                        <p><?php echo dictionary('FRONT_WELCOME_TO_HOSTPITAL_KEY5');?></p>
                                    </div>
                                </div>
                            </li>
                        </ul> 
                        <div class="button">
                            <a class="thm-btn bgclr-1" href="<?php echo $Cpu->getURL('700'); ?>"><?php echo dictionary('FRONT_WELCOME_TO_HOSTPITAL_KEY9');?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="slogan-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title pull-left">
                        <h2><?php echo dictionary('FRONT_FORM_IN_CONTENT_KEY_0');?></h2>
                    </div>
                    <div class="button pull-right">
                        <a class="thm-btn bgclr-1" href="#" data-toggle="modal" data-target="#exampleModal">
                            <?php echo dictionary('FRONT_FORM_IN_CONTENT_KEY_1');?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$get_our_facilities_data_info = $db
    ->where('active', 1)
    ->get('our_facilities', null, 'id, image, title_'.$lang.' as title, text_'.$lang.' as text');
if($get_our_facilities_data_info && count($get_our_facilities_data_info)>0)
{
    ?>
    <section class="special-features-area">
        <div class="container">
            <div class="sec-title mar0auto text-center">
                <div class="dev_d"><?php echo dictionary('FRONT_OUR_FACILITIES_KEY_0');?></div>
            </div>
            <?php
            $facilities_data_info_counter = 0;
            foreach ($get_our_facilities_data_info as $facilities_data_info)
            {
                $facilities_data_info_counter++;
                ?>
                <div class="col-md-4">
                    <div class="single-item">
                        <div class="icon-box">
                            <?php
                            $fac_imagethumb = $Functions->image_thumb($facilities_data_info['image'], 'our_facilities', 60, 60, 60, 0);
                            ?>
                            <img src="<?php echo $fac_imagethumb;?>" alt="<?php echo $facilities_data_info['title'];?>" />
                        </div>
                        <div class="text-box">
                            <h3><?php echo $facilities_data_info['title'];?></h3>
                            <p><?php echo preview_text($facilities_data_info['text']);?></p>
                        </div>
                    </div>
                </div>
                <?php
                if($facilities_data_info_counter%3 == 0)
                {
                    ?>
                    <div class="both"></div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
    <?php
}
?>

    <section class="fact-counter-area black-bg" style="background-image:url(/images/resources/fact-counter-bg-v2.jpg);">
        <div class="container">
            <div class="sec-title text-center">
                <div class="dev_e"><?php echo dictionary('FRONT_FACT_COUNTER_KEY_0');?></div>
                <p><?php echo dictionary('FRONT_FACT_COUNTER_KEY_1');?></p>
            </div>
            <div class="row">
                <!--Start single  item-->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ul>
                        <li>
                            <div class="single-item text-center">
                                <div class="icon-holder">
                                    <span class="flaticon-medical"></span>
                                </div>
                                <div class="dev_e"><span class="timer" data-from="1" data-to="<?php echo (int)dictionary('FRONT_FACT_COUNTER_KEY_2');?>" data-speed="5000"
                                          data-refresh-interval="50"><?php echo dictionary('FRONT_FACT_COUNTER_KEY_2');?></span></div>
                                <h3><?php echo dictionary('FRONT_FACT_COUNTER_KEY_3');?></h3>
                            </div>
                        </li>
                        <li>
                            <div class="single-item text-center">
                                <div class="icon-holder">
                                    <span class="flaticon-smile"></span>
                                </div>
                                <div class="dev_e"><span class="timer" data-from="1" data-to="<?php echo (int)dictionary('FRONT_FACT_COUNTER_KEY_4');?>" data-speed="5000"
                                          data-refresh-interval="50"><?php echo dictionary('FRONT_FACT_COUNTER_KEY_4');?></span></div>
                                <h3><?php echo dictionary('FRONT_FACT_COUNTER_KEY_5');?></h3>
                            </div>
                        </li>
                        <li>
                            <div class="single-item text-center">
                                <div class="icon-holder">
                                    <span class="flaticon-medical-1"></span>
                                </div>
                                <div class="dev_e"><span class="timer" data-from="1" data-to="<?php echo (int)dictionary('FRONT_FACT_COUNTER_KEY_6');?>" data-speed="5000"
                                          data-refresh-interval="50"><?php echo dictionary('FRONT_FACT_COUNTER_KEY_6');?></span></div>
                                <h3><?php echo dictionary('FRONT_FACT_COUNTER_KEY_7');?></h3>
                            </div>
                        </li>
                        <li>
                            <div class="single-item text-center">
                                <div class="icon-holder">
                                    <span class="flaticon-ribbon"></span>
                                </div>
                                <div class="dev_e"><span class="timer" data-from="1" data-to="<?php echo (int)dictionary('FRONT_FACT_COUNTER_KEY_8');?>" data-speed="5000"
                                          data-refresh-interval="50"><?php echo dictionary('FRONT_FACT_COUNTER_KEY_8');?></span></div>
                                <h3><?php echo dictionary('FRONT_FACT_COUNTER_KEY_9');?></h3>
                            </div>
                        </li>
                    </ul>
                </div>
                <!--End single item-->
            </div>
        </div>
    </section>


<?php
$get_certificates_data_info = $db
    ->where('active', 1)
    ->orderBy('sort', 'asc')
    ->get('awards_recognition');
if($get_certificates_data_info && count($get_certificates_data_info) > 0)
{
    ?>
    <section class="certificates-area">
        <div class="container">
            <div class="sec-title">
                <div class="dev_e"><?php echo dictionary('FRONT_AWORDS_RECOGNTION_KEY_0');?></div>
                <span class="border"></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="certificates">
                        <?php
                        foreach ($get_certificates_data_info as $certificates_data_info)
                        {
                            $certificates_image_big = $Functions->image_thumb($certificates_data_info['image'], 'awards_recognition', 1024, 860, 272, 0);
                            $certificates_image_thumb = $Functions->image_thumb($certificates_data_info['image'], 'awards_recognition', 270, 205, 270, 1);
                            ?>
                            <a href="<?php echo $certificates_image_big;?>" data-fancybox="images">
                                <div class="single-item">
                                    <img src="<?php echo $certificates_image_thumb;?>" alt="<?php echo $certificates_data_info['title_'.$lang];?>">
                                </div>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>

<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>