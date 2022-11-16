<?php
$element = $db
    ->where('active', 1)
    ->where('id', $page_data['elem_id'])
    ->getOne('departaments');
if(!$element)
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
                            <li><a href="<?php echo $Cpu->getURL('700'); ?>"><?php echo dictionary('HEADER_DEPARTAMENTS_PAGE'); ?></a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li class="active"><?php echo $page_data['page_title']; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End breadcrumb area-->
<!--Start departments single area-->
<section id="departments-single-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 pull-right">
                <div class="sec-title mar0auto text-center">
                    <div class="dev_h2"><?php echo $page_data['page_title']; ?></div>
                    <span class="border"></span>
                </div>
                <div class="tab-box">
                    <div class="tab-content">
                        <?php
                        $departament_slider = $db
                            ->where('parent_id', $element['id'])
                            ->get('departaments_images');
                        $count = 0;
                        foreach ($departament_slider as $slider) {
                            $count++;
                            $thumb_image = @newthumbs($slider['image'], 'departaments_images','870','470','2','1');
                            if ($count == '1') {
                                $class_active = 'active';
                            }else{
                                $class_active = '';
                            }
                            ?>

                            <div class="tab-pane <?php echo $class_active; ?>" id="ds<?php echo $slider['id']; ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="img-box">
                                            <img src="<?php echo $thumb_image; ?>" alt="<?php echo $page_data['page_title']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php

                        }
                        ?>
                    </div>
                    <ul class="nav nav-tabs tab-menu">

                        <?php
                        $departament_slider = $db
                            ->where('parent_id', $element['id'])
                            ->get('departaments_images');
                        $count = 0;
                        foreach ($departament_slider as $slider) {
                            $count++;
                            $thumb_image2 = @newthumbs($slider['image'], 'departaments_images','160','110','3','1');
                            if ($count == '1') {
                                $class_active = 'active';
                            }else{
                                $class_active = '';
                            }
                            ?>

                            <li class="<?php echo $class_active; ?>">
                                <a href="#ds<?php echo $slider['id']; ?>" data-toggle="tab">
                                    <div class="img-holder">
                                        <img src="<?php echo $thumb_image2; ?>" alt="<?php echo $page_data['page_title']; ?>">
                                        <div class="overlay-style-one">
                                            <div class="box">
                                                <div class="content">
                                                    <div class="iocn-holder">
                                                        <span class="flaticon-plus-symbol"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>

                <div style="clear:both;height: 35px;"></div>
                <div class="text-box">
                     <?php
                        echo htmlspecialchars_decode($element['text_'.$lang]);
                     ?>
                </div>


                <?php
                $get_service_data_info = $db
                    ->where('active', 1)
                    ->where('dep_id', $element['id'])
                    ->orderBy('sort', 'asc')
                    ->get('service');
                if($get_service_data_info && count($get_service_data_info)>0)
                {
                    ?>
                    <div class="service-list-all">
                        <div class="sec-title mar0auto text-center">
                            <div class="dev_h2"><?php echo dictionary('FRONT_DEPARTMENT_SERVICE_LIST');?></div>
                            <span class="border"></span>
                        </div>
                        <div class="container" style="width: 100%;">
                            <?php
                            $chunked_get_service_data_info_array = array_chunk($get_service_data_info,3);
                            foreach ($chunked_get_service_data_info_array as $service_data_info)
                            {
                                ?>
                            <div class="row">
                                <?php
                                if(isset($service_data_info[0]['id']))
                                {
                                    ?>
                                        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                            <ul class="service__list ">
                                                <li class="service__item">
                                                    <a class="service__link" href="<?php echo $Cpu->getURL( 781,$service_data_info[0]['id']);?>"><?php echo $service_data_info[0]['title_'.$lang];?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if(isset($service_data_info[1]['id']))
                                {
                                    ?>
                                        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                            <ul class="service__list">
                                                <li class="service__item">
                                                    <a class="service__link" href="<?php echo $Cpu->getURL( 781,$service_data_info[1]['id']);?>"><?php echo $service_data_info[1]['title_'.$lang];?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php
                                }
                                ?>

                                <?php 
                                if(isset($service_data_info[2]['id']))
                                {
                                    ?>
                                        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                            <ul class="service__list">
                                                <li class="service__item">
                                                    <a class="service__link" href="<?php echo $Cpu->getURL( 781,$service_data_info[2]['id']);?>"><?php echo $service_data_info[2]['title_'.$lang];?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php
                                }
                                ?>
                            </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <?php
                $get_department_offers_data_info = $db
                    ->where('active', 1)
                    ->where('dep_id', $element['id'])
                    ->orderBy('sort', 'asc')
                    ->get('medical_packages');
                if($get_department_offers_data_info && count($get_department_offers_data_info) > 0)
                {
                    ?>
                      <div class="service-plan medc-oferte">
                        <div class="sec-title mar0auto text-center">
                            <div class="dev_h2"><?php echo dictionary('FRONT_DEPARTMENT_DETAIL_KEY_0');?></div>
                            <span class="border"></span>
                         </div>
                         <div class="row">
                             <?php
                             foreach ($get_department_offers_data_info as $medical_packages_data_info)
                             {
                                 $medical_packages_cpu = $Cpu->getURL(773, $medical_packages_data_info['id']);
                                 ?>
                                 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
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
                                 </div>
                                 <?php
                             }
                             ?>
                         </div>
                      </div>
                    <?php
                }
                ?>



                <?php
                $get_departent_doctor_data_info = $db
                    ->where('active', 1)
                   /// ->where('d_id', $element['id'])
                    ->orderBy('sort', 'asc')
                    ->get('doctors');
                if($get_departent_doctor_data_info && count($get_departent_doctor_data_info) >0)
                {
                    ?>
                    <div class="service-plan team-area" id="dv_area_e7">
                        <div class="sec-title">
                            <div class="dev_h2"><?php echo dictionary('FRONT_DEPARTMENT_DETAIL_KEY_1');?></div>
                            <span class="border"></span>
                        </div>
                        <div class="row">
                            <?php
                            $departent_doctor_data_info_counter = 0;
                            foreach ($get_departent_doctor_data_info as $departent_doctor_data_info)
                            {
                                $userialized_dep_elem_array = unserialize($departent_doctor_data_info['d_id']);

                                if( is_array($userialized_dep_elem_array) && in_array($element['id'], $userialized_dep_elem_array) )
                                {
                                    $departent_doctor_data_info_counter++;
                                    $departent_doctor_cpu = $Cpu->getURL(703,$departent_doctor_data_info['id']);
                                    ?>
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                        <div class="single-team-member">
                                            <div class="img-holder">
                                                <?php
                                                $doctor_image = $db
                                                    ->where('parent_id', $departent_doctor_data_info['id'])
                                                    ->orderBy('sort', 'asc')
                                                    ->getOne('doctors_images');
                                                $departent_doctor_image_thumb = $Functions->image_thumb($doctor_image['image'], 'doctors_images', 720, 720, 721, 1);
                                                if(empty($departent_doctor_image_thumb))
                                                {
                                                    $departent_doctor_image_thumb = '/css/images/no-photo.jpg'; 
                                                }
                                                ?>
                                                <img src="<?php echo $departent_doctor_image_thumb;?>" alt="<?php echo $departent_doctor_data_info['title_'.$lang];?>">
                                                <div class="overlay-style">
                                                    <div class="box">
                                                        <div class="content">
                                                            <div class="top">
                                                                <h3><?php echo $departent_doctor_data_info['title_'.$lang];?></h3>
                                                                <span><?php echo $element['title_'.$lang];?></span>
                                                            </div>
                                                            <span class="border"></span>
                                                            <div class="bottom">
                                                                <ul>
                                                                    <li>
                                                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                                                        <a class="link-btn-doctor" href="<?php echo $departent_doctor_cpu;?>">
                                                                            <?php echo dictionary('FRONT_DETAILS');?>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-holder">
                                                    <h3><?php echo $departent_doctor_data_info['title_'.$lang];?></h3>
                                                    <span><?php echo $element['title_'.$lang];?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }

                            if($departent_doctor_data_info_counter == 0)
                            {
                                ?>
                                <style>
                                    #dv_area_e7
                                    {
                                        display:none;
                                    }
                                </style>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>



            </div>
            <div class="col-lg-3 col-md-4 col-sm-7 col-xs-12 pull-left">
                <div class="departments-sidebar">
                    <!--Start single sidebar-->
                    <div class="single-sidebar doctor-page-area">
                        <div class="title">
                            <h3><?php echo dictionary('HEADER_DEPARTAMENTS_PAGE'); ?></h3>
                        </div>

                        <ul class="nav nav-tabs tab-menu">
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
                                    <li>
                                        <a href="<?php echo $Cpu->getURL('701',$departament['id']); ?>">
                                            <div class="icon_dep">
                                                <img src="<?php echo $thumb_image; ?>" alt="">
                                            </div>
                                            <?php echo $departament['title_'.$lang]; ?>
                                        </a>
                                    </li>



                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="single-sidebar">
                        <div class="title">
                            <h3><?php echo dictionary('FRONT_DEPARTMENT_DETAIL_KEY_2');?></h3>
                        </div>
                        <ul class="opening-time">
                            <li><?php echo dictionary('FRONT_DEPARTMENT_DETAIL_KEY_3');?> <span><?php echo dictionary('FRONT_DEPARTMENT_DETAIL_KEY_4');?></span></li>
                            <li><?php echo dictionary('FRONT_DEPARTMENT_DETAIL_KEY_5');?> <span><?php echo dictionary('FRONT_DEPARTMENT_DETAIL_KEY_6');?></span></li>
                            <li><?php echo dictionary('FRONT_DEPARTMENT_DETAIL_KEY_7');?> <span><?php echo dictionary('FRONT_DEPARTMENT_DETAIL_KEY_8');?></span></li>
                        </ul>
                    </div>
                    <div class="single-sidebar">
                        <div class="title">
                            <h3><?php echo dictionary('FRONT_DEPARTMENT_DETAIL_KEY_9');?></h3>
                        </div>
                        <div class="contact-us">
                            <ul class="contact-info">
                                <li>
                                    <div class="icon-holder">
                                        <span class="flaticon-pin"></span>
                                    </div>
                                    <div class="text-holder">
                                        <h5><?php echo dictionary('FRONT_CONTACT_US_ADDRESS_DESCRIPTION');?></h5>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon-holder">
                                        <span class="flaticon-technology"></span>
                                    </div>
                                    <div class="text-holder">
                                        <h5><?php echo dictionary('FRONT_CONTACT_US_EMAIL');?></h5>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon-holder">
                                        <span class="flaticon-technology-1"></span>
                                    </div>
                                    <div class="text-holder">
                                        <h5><?php echo dictionary('FRONT_CONTACT_PHONE_1');?></h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--Ens single sidebar-->
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
