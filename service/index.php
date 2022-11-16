<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>

    <section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <h1><?php echo dictionary('HEADER_SERVICES');?></h1>
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
                                <li class="active"><?php echo dictionary('HEADER_SERVICES');?></li>
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
    <section class="services-all">
        <div class="container">
            <div class="row grid">
                <?php
                $get_department_data_info = $db
                    ->where('active',1)
                    ->orderBy('sort', 'asc')
                    ->get('departaments');
                if($get_department_data_info && count($get_department_data_info)>0)
                {
                    foreach ($get_department_data_info as $department_data_info)
                    {
                        $get_service_data_info = $db
                            ->where('active',1)
                            ->where('dep_id', $department_data_info['id'])
                            ->orderBy('sort', 'asc')
                            ->get('service');
                        if($get_service_data_info && count($get_service_data_info)>0)
                        {
                            ?>
                            <div class="grid-item col-md-6 col-lg-3 col-sm-12 col-xs-12">
                                <h2 class="service__column_title">
                                    <a href="<?php echo $Cpu->getUrl( 701,$department_data_info['id']);?>">
                                        <?php echo $department_data_info['title_'.$lang];?>
                                    </a>
                                </h2>
                                <ul class="service__list">
                                    <?php
                                    foreach ($get_service_data_info as $service_data_info)
                                    {
                                        ?>
                                        <li class="service__item">
                                            <a class="service__link" href="<?php echo $Cpu->getUrl( 781,$service_data_info['id']);?>"><?php echo $service_data_info['title_'.$lang];?></a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>