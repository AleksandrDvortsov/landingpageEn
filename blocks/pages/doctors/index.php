<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>
<section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1><?php echo dictionary('DOCTOR_PG_1');?></h1>
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
                            <li class="active"><?php echo dictionary('HEADER_TEAM_PAGE');?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="team-area doctor doctor-page-area">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <ul class="nav nav-tabs tab-menu">
                    <?php
                    $get_departaments = $db
                        ->where('active', 1)
                        ->orderBy('sort','asc')
                        ->get('departaments');

                    if (count($get_departaments) > 0)
                    {
                        ?>
                        <li class="jsa_get_doctors" data-dep-id="0">
                            <a>
                                <div class="icon_dep"></div>
                                <?php echo dictionary('DOC_PG_VIEW_ALL');?>
                            </a>
                        </li>

                        <li class="jsa_get_doctors" data-dep-id="-1">
                            <a>
                                <div class="icon_dep">
                                    <img src="/images/icon/internet.png" alt="">
                                </div>
                                <?php echo dictionary('ISONLINE');?>
                            </a>
                        </li>
                        <?php
                        foreach ($get_departaments as $departament) {

                            $departament_icon = $db
                                ->where('parent_id', $departament['id'])
                                ->getOne('departaments_icons');
                            $thumb_image = @newthumbs($departament_icon['image'], 'departaments_icons');

                            ?>
                            <li class="jsa_get_doctors" data-dep-id="<?php echo $departament['id']; ?>">
                                <a>
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
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="row" id="ajax_get_doctors_container">
                        
                        <?php 
                        
                        if(isset($_GET['isOnline']) && !empty($_GET['isOnline'])){
                            $get_table_info = $db
                                ->orderBy('sort','asc')
                                ->where('active', 1)
                                ->where('isOnline', 1)
                                ->get('doctors');?>
                            <div class="sp_dv7">
                                <div class="sp_dv7T">
                                    <?php echo dictionary('ISONLINE');?>
                                </div>
                            </div>
                        <?php
                        }else{
                            $get_table_info = $db
                                ->orderBy('sort','asc')
                                ->where('active', 1)
                                ->get('doctors');
                                ?>
                            <div class="sp_dv7">
                                <div class="sp_dv7T">
                                    <?php echo dictionary('DOC_PG_VIEW_ALL');?>
                                </div>
                            </div>
                        <?php
                        }
                            
                            
                        foreach ($get_table_info as $table_info)
                        {
                            $rw_id = $table_info['id'];
                            $doctor_image = $db
                                ->where('parent_id', $table_info['id'])
                                ->getOne('doctors_images');
                            $thumb_image = $Functions->image_thumb($doctor_image['image'], 'doctors_images','270','270','2','1');
                            if(empty($thumb_image))
                            {
                                $thumb_image = '/css/images/no-photo.jpg';
                            }

                            $userialized_dep_elem_array = unserialize($table_info['d_id']);
                            $get_doctor_departament = $db
                                ->where('id', $userialized_dep_elem_array, 'IN')
                                ->get('departaments', null, 'title_'.$lang.' as title'); 
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <div class="single-team-member">
                                    <div class="img-holder">

                                        <?php 
                                            if($table_info['isOnline']){
                                                ?><img class="icon-is-online" src="/images/icon/online.png" alt="" title="<?php echo dictionary('DOCTORACCEPTSONLINE');?>"><?php
                                            }else{
                                                ?><img class="icon-is-online" src="/images/icon/offline.png" alt="" title="<?php echo dictionary('DOCTORNOACCEPTSONLINE');?>"><?php
                                            }
                                        ?>
                                        
                                        <img src="<?php echo $thumb_image; ?>" alt="<?php echo $table_info['title_'.$lang];?>">
                                        <div class="overlay-style">
                                            <div class="box">
                                                <div class="content">
                                                    <div class="top">
                                                        <h3><?php echo $table_info['title_'.$lang];?></h3>
                                                        <span>
                                                            <?php 
                                                                echo  preview_text($table_info['text_2_'.$lang]).'<br/>';
                                                            ?>
                                                        </span>
                                                    </div>
                                                    <span class="border"></span>
                                                    <div class="bottom">
                                                        <ul>
                                                            <li>
                                                                <a class="link-btn-doctor" style="<?php if($table_info['isOnline']) echo "position: inherit;" ?>" href="<?php echo $Cpu->getURL('703', $table_info['id'])?>">
                                                                    <?php echo dictionary('FRONT_DETAILS');?>
                                                                </a>
                                                            </li>
                                                            <?php 
                                                            if($table_info['isOnline']){
                                                                ?>
                                                                <li>
                                                                    <a class="link-btn-doctor" href="#">
                                                                        <?php echo dictionary('DOCTORACCEPTSONLINE');?>
                                                                    </a>
                                                                </li>
                                                            <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-holder">
                                            <h3><?php echo $table_info['title_'.$lang];?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End team area--> 
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>
