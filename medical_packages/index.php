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
                    <h1><?php echo dictionary('HEADER_MEDICAL_PACKAGE');?></h1>
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
                            <li class="active"><?php echo dictionary('HEADER_MEDICAL_PACKAGE');?></li>
                        </ul>
                    </div>
                </div>
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
    <section class="medical-departments-area departments-page medic-package">
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
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>