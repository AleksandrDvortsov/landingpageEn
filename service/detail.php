<?php
$element = $db
    ->where('active', 1)
    ->where('id', $page_data['elem_id'])
    ->getOne('service');
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
                        <h1><?php echo dictionary('HEADER_SERVICE_DETAIL_KEY_0');?></h1>
                        <div class="text-desc">
                            <p><?php echo dictionary('HEADER_SERVICE_DETAIL_KEY_1');?></p>
                        </div>
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
                                <li><a href="<?php echo $Cpu->getURL('780'); ?>"><?php echo dictionary('HEADER_SERVICES'); ?></a></li>
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
    <!--Start faq content area-->
    <section class="faq-content-area services-detaills">
        <div class="container">
            <div class="row">
                <!--Start single box-->
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-detail">
                    <?php echo db_text($element['text_'.$lang]);?>
                </div>
                <!--End single box-->
            </div>


            <?php
            $get_departent_doctor_data_info = $db
                ->where('active', 1)
                ->where('d_id', $element['dep_id'])
                ->orderBy('sort', 'asc')
                ->get('doctors');
            if($get_departent_doctor_data_info && count($get_departent_doctor_data_info) >0)
            {
                ?>
                <div class="service-plan team-area">
                    <div class="sec-title">
                        <h1><?php echo dictionary('FRONT_SERVICE_DETAIL_KEY_10');?></h1>
                        <span class="border"></span>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($get_departent_doctor_data_info as $departent_doctor_data_info)
                        {
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
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>

            <?php
            require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/form_doctor_k1.php';
            ?>
        </div>

    </section>





<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>