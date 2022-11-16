<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>

    <section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <h1><?php echo dictionary('HEADER_SERVIE_PRICE');?></h1>
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
                                <li class="active"><?php echo dictionary('HEADER_SERVIE_PRICE');?></li>
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
    <section class="faq-content-area">
        <div class="container">
            <div class="row">
                <!--Start single box-->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="single-box">
                        <div class="sec-title mar0auto text-center">
                            <div class="dev_g"><?php echo dictionary('FRONT_SERVICE_PRICE_PAGE_KEY_0');?></div>
                            <span class="border"></span>
                        </div>
                        <div class="accordion-box service-table">
                            <?php
                            $get_service_price_category_data_info = $db
                                ->where('active',1)
                                ->orderBy('sort', 'asc')
                                ->get('categories_prices');
                            if($get_service_price_category_data_info && count($get_service_price_category_data_info) >0)
                            {
                                foreach ($get_service_price_category_data_info as $service_price_category_data_info)
                                {
                                    $get_service_price_data_info = $db
                                        ->where('active', 1)
                                        ->where('cat_id', $service_price_category_data_info['id'])
                                        ->orderBy('sort', 'asc')
                                        ->get('prices');
                                    if($get_service_price_data_info && count($get_service_price_data_info) > 0)
                                    {
                                        ?>
                                        <div class="accordion accordion-block">
                                            <div class="accord-btn">
                                                <h4>
                                                    <?php echo $service_price_category_data_info['title_'.$lang];?>
                                                </h4>
                                            </div>
                                            <div class="accord-content">
                                                <table cellspacing="0" cellpadding="3">
                                                    <colgroup>
                                                        <col width="587">
                                                        <col width="77"> </colgroup>
                                                    <tbody>
                                                    <?php
                                                    foreach ($get_service_price_data_info as $service_price_data_info)
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $service_price_data_info['title_'.$lang];?></td>
                                                            <td>
                                                                <p align="center"><?php echo $service_price_data_info['price'].' '.dictionary('LEI');?></p>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            ?>


                        </div>
                    </div>
                </div>
                <!--End single box-->
            </div>
        </div>
    </section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>