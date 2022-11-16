<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>
<?php
$get_slider_data_info = $db
    ->where('active',1)
    ->orderBy('sort','asc')
    ->get('slider');
if($get_slider_data_info && count($get_slider_data_info)> 0)
{
    ?>
    <!--Start rev slider wrapper-->
    <section class="rev_slider_wrapper">
        <div id="slider1" class="rev_slider" data-version="5.0">
            <ul>
            <?php
            foreach ($get_slider_data_info as $slider_data_info)
            {
                $slider_imagethumb = $Functions->image_thumb($slider_data_info['image'], 'slider', 1920, 750, 25, 0);
                ?>
                    <li data-transition="rs-20">
                        <img src="<?php echo $slider_imagethumb;?>" alt="" width="1920" height="750" data-bgposition="top center"
                             data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="1">
                        <div class="tp-caption tp-resizeme"
                             data-x="left" data-hoffset="0"
                             data-y="top" data-voffset="220"
                             data-transform_idle="o:1;"
                             data-transform_in="x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;"
                             data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
                             data-mask_in="x:[100%];y:0;s:inherit;e:inherit;"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             data-start="1500">
                            <div class="slide-content-box mar-lft">
                                <div class="dev_f"><?php echo db_text($slider_data_info['title_'.$lang]);?></div>
                                <p><?php echo db_text($slider_data_info['text_'.$lang]);?></p>

                            </div>
                             <div class="wrap">
                               <ul class="social-links">
                            <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['FACEBOOK_LINK'];?>"><i class="fa fa-facebook"></i></a></li>
                            <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['LINKEDIN'];?>"><i class="fa fa-instagram"></i></a></li>
                            <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['YOUTUBE'];?>"><i class="fa fa-youtube"></i></a></li>
                        </ul>
                               </div>
                        </div>
                    </li>
                <?php
            }
            ?>
                </ul>
        </div>
    </section>
    <!--End rev slider wrapper-->
    <?php
}
?>
        <!--Start Medical Departments area-->
        <section class="medical-departments-area">
            <div class="container">
                <div class="sec-title mar0auto text-center">
                    <h1><?php echo dictionary('HEADER_DEPARTAMENTS_PAGE'); ?></h1>
                    <span class="border"></span>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php
                        $get_departaments = $db
                            ->where('active', 1)
                            ->orderBy('sort','asc')
                            ->get('departaments');

                        if (count($get_departaments) > 0)
                        {
                            foreach ($get_departaments as $departament) {

                                $departament_icon = $db
                                    ->where('parent_id', $departament['id'])
                                    ->getOne('departaments_icons');
                                $thumb_image = @newthumbs($departament_icon['image'], 'departaments_icons');

                                ?>
                                <div class="single-item text-center col-sm-6 col-md-4 col-lg-2">
                                    <a href="<?php echo $Cpu->getURL('701',$departament['id']); ?>">
                                        <div class="iocn-holder">
                                            <div class="icon_dep">
                                                <img src="<?php echo $thumb_image; ?>" alt="">
                                            </div>
                                            <span class="btn-opens"> 
                                                <button onclick="<?php echo $Cpu->getURL('701',$departament['id']); ?>">
                                                    <?php echo dictionary('FRONT_UNIVERSAL_WORD_KEY_OPEN');?>
                                                </button>
                                            </span>
                                        </div>
                                        <div class="text-holder">
                                            <h3><?php echo $departament['title_'.$lang]; ?></h3>
                                        </div>
                                    </a>
                                </div>


                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

<?php

// get medical_packages only for selected departents
$get_used_dep_medical_packages_data_info = $db
    ->where('active', 1)
    ->get('medical_packages', null,'distinct dep_id');
if($get_used_dep_medical_packages_data_info && count($get_used_dep_medical_packages_data_info) > 0)
{
    $distinced_mp_data = array();
    foreach ($get_used_dep_medical_packages_data_info as $used_dep_medical_packages_data_info)
    {
        $distinced_mp_data[] = $used_dep_medical_packages_data_info['dep_id'];
    }
    ?>
    <section class="medical-departments-area departments-page">
        <div class="container">
            <div class="row">
                <div class="sec-title mar0auto text-center">
                    <div class="dev_g"><?php echo dictionary('FRONT_MEDICAL_PACKAGES_O_KEY_1');?></div>
                    <span class="border"></span>
                </div>
                <div class="row">
                    <div class="select-wrap">
                        <select name="sources" id="sources" class="custom-select sources" placeholder="<?php echo dictionary('FRONT_MEDICAL_PACKAGES_O_KEY_2');?>">
                            <?php
                            $get_mp_department_data_info = $db
                                ->where('active', 1)
                                ->where('id', $distinced_mp_data, 'IN')
                                ->get('departaments');
                            if($get_mp_department_data_info && count($get_mp_department_data_info) >0)
                            {
                                ?>
                                <option value="0"><?php echo dictionary('FRONT_SHOW_ALL_MEDICAL_PACKAGES_KL1');?></option>
                                <?php
                                foreach ($get_mp_department_data_info as $mp_department_data_info)
                                {
                                    ?>
                                    <option value="<?php echo $mp_department_data_info['id'];?>"><?php echo $mp_department_data_info['title_'.$lang];?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="ajax_dinamic_packets">
                    <div class="pakets-medikal owl-carousel">
                        <?php
                        $get_medical_packages_data_info = $db
                            ->where('active', 1)
                            ->orderBy('sort', 'asc')
                            ->get('medical_packages');
                        if($get_medical_packages_data_info && count($get_medical_packages_data_info))
                        {
                            foreach ($get_medical_packages_data_info as $medical_packages_data_info)
                            {
                                $medical_packages_cpu = $Cpu->getURL(773, $medical_packages_data_info['id']);
                                ?>
                                <div class="pakets-item">
                                    <div class="pakets-img">
                                        <?php
                                        $medical_packages_thumb_image = $Functions->image_thumb($medical_packages_data_info['image'], 'medical_packages', 700, 400, 741, 1);
                                        ?>
                                        <a href="<?php echo $medical_packages_cpu;?>" class="link-img" style="background-image: url(<?php echo $medical_packages_thumb_image;?>);"></a>
                                    </div>
                                    <div class="pakets-content">
                                        <div class="pakets-content--header">
                                            <h3><a href="<?php echo $medical_packages_cpu;?>"><?php echo $medical_packages_data_info['title_'.$lang];?></a></h3>
                                        </div>
                                        <div class="pakets-content--body">
                                            <ul>
                                                <?php
                                                if(isset($medical_packages_data_info['design_for_'.$lang]) && trim($medical_packages_data_info['design_for_'.$lang])!='')
                                                {
                                                    ?>
                                                    <li><div><?php echo dictionary('FRONT_CP_DESIGN_FOR').' '.$medical_packages_data_info['design_for_'.$lang];?></div></li>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if(isset($medical_packages_data_info['duration_'.$lang]) && trim($medical_packages_data_info['duration_'.$lang])!='')
                                                {
                                                    ?>
                                                    <li><div><?php echo dictionary('FRONT_CP_DURATION').' '.$medical_packages_data_info['duration_'.$lang];?></div></li>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if(isset($medical_packages_data_info['price']) && $medical_packages_data_info['price']>0)
                                                {
                                                    ?>
                                                    <li><div><?php echo dictionary('FRONT_PRICE_KEY_741').' '.$medical_packages_data_info['price'].' '.dictionary('LEI');?></div></li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="pakets-content--footer">
                                            <a href="<?php echo $medical_packages_cpu;?>" class="btn button-sl">
                                                <?php echo dictionary('FRONT_JOIN_TODAY');?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
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
// get doctors only for selected departents
$get_used_doctors_data_info = $db
    ->where('active', 1)
    ->where('show_on_main_page', 1)
    ->get('doctors', null,'d_id');
if($get_used_doctors_data_info && count($get_used_doctors_data_info) > 0)
{
    $distinced_dc_data = array();





    foreach ($get_used_doctors_data_info as $used_doctors_data_info)
    {
        $unserialized_d_id_data_array = unserialize($used_doctors_data_info['d_id']);
        if(is_array($unserialized_d_id_data_array) && count($unserialized_d_id_data_array) > 0)
        {
            foreach ($unserialized_d_id_data_array as $unserialized_d_id)
            {
                $distinced_dc_data[] = $unserialized_d_id;
            }
        }
    }
    $unique_distinced_dc_data = array_unique($distinced_dc_data);
    $distinced_dc_data = $unique_distinced_dc_data;

    ?>
    <section class="medical-departments-area departments-page">
        <div class="container">
            <div class="row">
                <div class="sec-title mar0auto text-center">
                    <div class="dev_g"><?php echo dictionary('FRONT_DOCTOR_BLOCK_O_KEY_1');?></div>
                    <span class="border"></span>
                </div>
                <div class="row">
                    <div class="select-wrap">
                        <select name="sources" id="doctor_sources" class="custom-select sources" placeholder="<?php echo dictionary('FRONT_DOCTOR_BLOCK_O_KEY_2');?>">
                            <option value="0"><?php echo dictionary('FRONT_DOCTOR_BLOCK_O_KEY_2');?></option>
                            <?php
                            $get_dc_department_data_info = $db
                                ->where('active', 1)
                                ->where('id', $distinced_dc_data, 'IN')
                                ->get('departaments');
                            if($get_dc_department_data_info && count($get_dc_department_data_info) >0)
                            {
                                foreach ($get_dc_department_data_info as $dc_department_data_info)
                                {
                                    ?>
                                    <option value="<?php echo $dc_department_data_info['id'];?>"><?php echo $dc_department_data_info['title_'.$lang];?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div id="ajax_dinamic_doctors">
                    <div class="doktors-block owl-carousel">
                        <?php
                        $get_doctors_data_info = $db
                            ->where('active', 1)
                            ->where('show_on_main_page', 1)
                            ->orderBy('sort', 'asc')
                            ->get('doctors');
                        if($get_doctors_data_info && count($get_doctors_data_info))
                        {
                            foreach ($get_doctors_data_info as $doctors_data_info)
                            {
                                $doctors_data_info_cpu = $Cpu->getURL(703, $doctors_data_info['id']);
                                ?>
                                <div class="pakets-item">
                                    <div class="pakets-img">
                                        <?php 
                                        $doctor_image = $db
                                            ->where('parent_id', $doctors_data_info['id'])
                                            ->orderBy('sort', 'asc')
                                            ->getOne('doctors_images');
                                        $doctors_data_info_thumb_image = $Functions->image_thumb($doctor_image['image'], 'doctors_images', 712, 330, 749, 0);
                                        ?>
                                        <a href="<?php echo $doctors_data_info_cpu;?>" class="link-img" style="background-image: url(<?php echo $doctors_data_info_thumb_image;?>); -webkit-background-size: contain;background-size: contain;"></a>
                                    </div>
                                    <div class="pakets-content">
                                        <div class="pakets-content--header">
                                            <h3><a href="<?php echo $doctors_data_info_cpu;?>"><?php echo $doctors_data_info['title_'.$lang];?></a></h3>
                                            <h6 class="subtitle">
                                                <?php echo preview_text($doctors_data_info['text_3_'.$lang], 100);?></h6>
                                        </div>
                                        <div class="pakets-content--body">
                                            <p><?php echo preview_text($doctors_data_info['text_2_'.$lang], 100);?></p>
                                        </div>
                                        <div class="pakets-content--footer">
                                            <a href="<?php echo $doctors_data_info_cpu;?>" class="btn btn-default button-sl">
                                                <?php echo dictionary('FRONT_JOIN_TODAY2');?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
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












        <section class="fact-counter-area" style="background-image:url(/images/resources/fact-counter-bg.jpg);">
            <div class="container">
                <div class="sec-title text-center">
                    <div class="dev_h"><?php echo dictionary('FRONT_FACT_COUNTER_KEY_0');?></div>
                    <p><?php echo dictionary('FRONT_FACT_COUNTER_KEY_1');?></p>
                </div>
                <div class="row">
                    <!--Start single item-->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul>
                            <li>
                                <div class="single-item text-center">
                                    <div class="icon-holder">
                                        <span class="flaticon-medical"></span>
                                    </div>
                                    <div class="dev_i"><span class="timer" data-from="1" data-to="<?php echo (int)dictionary('FRONT_FACT_COUNTER_KEY_2');?>" data-speed="5000"
                                              data-refresh-interval="50"><?php echo dictionary('FRONT_FACT_COUNTER_KEY_2');?></span></div>
                                    <?php
                                        if($User->check_cp_authorization()) { echo dictionary('FRONT_FACT_COUNTER_KEY_2');}
                                    ?>
                                    <h3><?php echo dictionary('FRONT_FACT_COUNTER_KEY_3');?></h3>
                                </div>
                            </li>
                            <li>
                                <div class="single-item text-center">
                                    <div class="icon-holder">
                                        <span class="flaticon-smile"></span>
                                    </div>
                                    <div class="dev_i"><span class="timer" data-from="1" data-to="<?php echo (int)dictionary('FRONT_FACT_COUNTER_KEY_4');?>" data-speed="5000"
                                              data-refresh-interval="50"><?php echo dictionary('FRONT_FACT_COUNTER_KEY_4');?></span></div>
                                    <?php
                                        if($User->check_cp_authorization()) { echo dictionary('FRONT_FACT_COUNTER_KEY_4');}
                                    ?>
                                    <h3><?php echo dictionary('FRONT_FACT_COUNTER_KEY_5');?></h3>
                                </div>
                            </li>
                            <li>
                                <div class="single-item text-center">
                                    <div class="icon-holder">
                                        <span class="flaticon-medical-1"></span>
                                    </div>
                                    <div class="dev_i"><span class="timer" data-from="1" data-to="<?php echo (int)dictionary('FRONT_FACT_COUNTER_KEY_6');?>" data-speed="5000"
                                              data-refresh-interval="50"><?php echo dictionary('FRONT_FACT_COUNTER_KEY_6');?></span></div>
                                    <?php
                                        if($User->check_cp_authorization()) { echo dictionary('FRONT_FACT_COUNTER_KEY_6');}
                                    ?>
                                    <h3><?php echo dictionary('FRONT_FACT_COUNTER_KEY_7');?></h3>
                                </div>
                            </li>
                            <li>
                                <div class="single-item text-center">
                                    <div class="icon-holder">
                                        <span class="flaticon-ribbon"></span>
                                    </div>
                                    <div class="dev_i"><span class="timer" data-from="1" data-to="<?php echo (int)dictionary('FRONT_FACT_COUNTER_KEY_8');?>" data-speed="5000"
                                              data-refresh-interval="50"><?php echo dictionary('FRONT_FACT_COUNTER_KEY_8');?></span></div>
                                    <?php
                                        if($User->check_cp_authorization()) { echo dictionary('FRONT_FACT_COUNTER_KEY_8');}
                                    ?>
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
$get_rewiews_data_info = $db
    ->where('active', 1)
    ->get('reviews');
if($get_rewiews_data_info && count($get_rewiews_data_info)>0)
{
    ?>
    <section class="testimonial-area">
        <div class="container">
            <div class="sec-title mar0auto text-center">
                <div class="dev_g"><?php echo dictionary('FRONT_WHAT_OUR_CLIENTS_SAY_KEY_0');?></div>
                <span class="border"></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="testimonial-carousel">
                        <?php
                        foreach ($get_rewiews_data_info as $rewiews_data_info)
                        {
                            ?>
                            <div class="single-testimonial-item text-center">
                                <div class="img-box">
                                    <div class="img-holder">
                                        <?php
                                        $wh_cl_say_imagethumb = $Functions->image_thumb($rewiews_data_info['image'], 'reviews', 79, 79, 30, 0);
                                        ?>
                                        <img src="<?php echo $wh_cl_say_imagethumb;?>" alt="<?php echo $rewiews_data_info['fio'];?>">
                                    </div>
                                    <div class="quote-box">
                                        <i class="fa fa-quote-left" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="text-holder">
                                    <p><?php echo preview_text($rewiews_data_info['text_'.$lang]);?></p>
                                </div>
                                <div class="name">
                                    <h3><?php echo $rewiews_data_info['fio'];?></h3>
                                    <span><?php echo $rewiews_data_info['city'];?></span>
                                </div>
                            </div>
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
$get_latest_blog_data_info = $db
    ->where('active', 1)
    ->orderBy('date', 'desc')
    ->get('blog_elements', 3);
if($get_latest_blog_data_info && count($get_latest_blog_data_info)>0)
{
    ?>
    <section class="latest-blog-area">
        <div class="container">
            <div class="sec-title">
                <div class="dev_g"><?php echo dictionary('FRONT_LATEST_FROM_BLOG_BLOCK');?></div>
                <span class="border"></span>
            </div>
            <div class="row">
                <?php
                foreach ($get_latest_blog_data_info as $latest_blog_data_info)
                {
                    $latest_blog_data_info_cpu = $Cpu->getURL(526, $latest_blog_data_info['id']);
                    ?>
                    <div class="col-md-4">
                        <div class="single-blog-item">
                            <div class="img-holder">
                                <?php
                                $latest_blog_elements_image_thumb = $Functions->image_thumb($latest_blog_data_info['image'], 'blog_elements', 363, 220, 200, 1);
                                ?>
                                <img src="<?php echo $latest_blog_elements_image_thumb;?>" alt="<?php echo $latest_blog_data_info['title_'.$lang];?>">
                                <div class="overlay-style-one">
                                    <div class="box">
                                        <div class="content">
                                            <a href="<?php echo $latest_blog_data_info_cpu;?>"><span class="flaticon-plus-symbol"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-holder">
                                <a href="<?php echo $latest_blog_data_info_cpu;?>">
                                    <h3 class="blog-title"><?php echo $latest_blog_data_info['title_'.$lang];?></h3>
                                </a>
                                <div class="text">
                                    <p><?php echo limiter(preview_text($latest_blog_data_info['preview_'.$lang]), 200);?></p>
                                </div>
                                <ul class="meta-info">
                                    <li>
                                        <a href="<?php echo $latest_blog_data_info_cpu;?>">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php
                                            $latest_blog_data_date = new DateTime($latest_blog_data_info['date']);
                                            echo $latest_blog_data_date->format('F d, Y')
                                            ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
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

        <section class="facilities-appointment-area">
            <div class="container">
                <div class="row">
                    <?php
                    $get_our_facilities_data_info = $db
                        ->where('active', 1)
                        ->get('our_facilities', null, 'id, image, title_'.$lang.' as title, text_'.$lang.' as text');
                    if($get_our_facilities_data_info && count($get_our_facilities_data_info)>0)
                    {
                        $sp_fac_chunked_array= array_chunk($get_our_facilities_data_info, 4);
                        ?>
                        <div class="col-md-8">
                            <div class="facilities-content-box">
                                <div class="sec-title">
                                    <div class="dev_g"><?php echo dictionary('FRONT_OUR_FACILITIES_KEY_0');?></div>
                                    <span class="border"></span>
                                </div>
                                <div class="<?php if(count($get_our_facilities_data_info)>4){ ?> facilities-carousel <?php } ?>">
                                    <?php
                                    foreach ($sp_fac_chunked_array as $facilities_data_info)
                                    {

                                        ?>
                                        <div class="single-facilities-item">
                                            <div class="row">
                                                <?php
                                                if(isset($facilities_data_info[0]))
                                                {
                                                    ?>
                                                    <div class="col-md-6">
                                                        <div class="single-item">
                                                            <div class="icon-holder">
                                                                <div class="icon-box">
                                                                    <div class="icon">
                                                                        <?php
                                                                        $fac_imagethumb = $Functions->image_thumb($facilities_data_info[0]['image'], 'our_facilities', 60, 60, 60, 0);
                                                                        ?>
                                                                        <img src="<?php echo $fac_imagethumb;?>" alt="<?php echo $facilities_data_info[0]['title'];?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="text-holder">
                                                                <h3><?php echo $facilities_data_info[0]['title'];?></h3>
                                                                <p><?php echo preview_text($facilities_data_info[0]['text']);?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if(isset($facilities_data_info[1]))
                                                {
                                                    ?>
                                                    <div class="col-md-6">
                                                        <div class="single-item">
                                                            <div class="icon-holder">
                                                                <div class="icon-box">
                                                                    <div class="icon">
                                                                        <?php
                                                                        $fac_imagethumb = $Functions->image_thumb($facilities_data_info[1]['image'], 'our_facilities', 60, 60, 60, 0);
                                                                        ?>
                                                                        <img src="<?php echo $fac_imagethumb;?>" alt="<?php echo $facilities_data_info[1]['title'];?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="text-holder">
                                                                <h3><?php echo $facilities_data_info[1]['title'];?></h3>
                                                                <p><?php echo preview_text($facilities_data_info[1]['text']);?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="row">
                                                <?php
                                                if(isset($facilities_data_info[2]))
                                                {
                                                    ?>
                                                    <div class="col-md-6">
                                                        <div class="single-item">
                                                            <div class="icon-holder">
                                                                <div class="icon-box">
                                                                    <div class="icon">
                                                                        <?php
                                                                        $fac_imagethumb = $Functions->image_thumb($facilities_data_info[2]['image'], 'our_facilities', 60, 60, 60, 0);
                                                                        ?>
                                                                        <img src="<?php echo $fac_imagethumb;?>" alt="<?php echo $facilities_data_info[2]['title'];?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="text-holder">
                                                                <h3><?php echo $facilities_data_info[2]['title'];?></h3>
                                                                <p><?php echo preview_text($facilities_data_info[2]['text']);?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if(isset($facilities_data_info[3]))
                                                {
                                                    ?>
                                                    <div class="col-md-6">
                                                        <div class="single-item">
                                                            <div class="icon-holder">
                                                                <div class="icon-box">
                                                                    <div class="icon">
                                                                        <?php
                                                                        $fac_imagethumb = $Functions->image_thumb($facilities_data_info[3]['image'], 'our_facilities', 60, 60, 60, 0);
                                                                        ?>
                                                                        <img src="<?php echo $fac_imagethumb;?>" alt="<?php echo $facilities_data_info[3]['title'];?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="text-holder">
                                                                <h3><?php echo $facilities_data_info[3]['title'];?></h3>
                                                                <p><?php echo preview_text($facilities_data_info[3]['text']);?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>



                    <div class="col-md-4">
                        <div class="appointment">
                            <div class="sec-title">
                                <div class="dev_g"><?php echo dictionary('FRONT_FOOTER_APPOITMENT_RECORDS_KEY_0');?></>
                                <span class="border"></span>
                            </div>
                            <form id="appointment-form" id="appointment" class="clearfix" method="post" data-form_type='2' data-form_task='appointment_records_second_type'>
                                <?php echo $Token->generateHiddenField();?>
                                <?php include $_SERVER['DOCUMENT_ROOT'] . '/blocks/reffer_form_dates.php';?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-box">
                                            <input type="text" name="fio" class="required" value="" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_FIO');?>"
                                                   required="">
                                        </div>
                                        <div class="input-box">
                                            <input type="text" class="required" name="email" value="" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_EMAIL');?>" autocomplete="off" required="">
                                        </div>

                                        <div class="input-box">
                                            <input type="text" class="required" name="date" placeholder="<?php echo dictionary('PLACEHOLDER_SELECT_AP_DATE');?>" id="datepicker2" autocomplete="off" required="">
                                            <div class="icon-box">
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                        </div>

                                        <div class="input-box">
                                            <input type="tel" class="required" name="phone" value="" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_PHONE_NUMBER');?>" required="" maxlength="20">
                                        </div>

                                        <div class="input-box">
                                            <select class="selectmenu" name="department">
                                                <option selected="selected"><?php echo dictionary('FRONT_APR_SELECT_DEPARTMENT');?></option>
                                                <?php
                                                $get_department_data_info = $db
                                                    ->where('active',1)
                                                    ->orderBy('title_'.$lang,'asc')
                                                    ->get('departaments');
                                                if($get_department_data_info && count($get_department_data_info)>0)
                                                {
                                                    foreach ($get_department_data_info as $department_data_info)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $department_data_info['id'];?>"><?php echo $department_data_info['title_'.$lang];?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="input-box" id="doctor_ajax_info2">
                                            <select class="selectmenu required" name="doctor">
                                                <option selected="selected"><?php echo dictionary('FRONT_APR_SELECT_DOCTOR');?></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="thm-btn bgclr-1 get_btn"><?php echo dictionary('FRONT_FOOTER_APPOITMENT_RECORDS_KEY_1');?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>
