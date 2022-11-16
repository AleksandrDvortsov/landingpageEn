<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>
<!--Start breadcrumb area-->
<section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1><?php echo dictionary('DEP_PG_1');?></h1>
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
                            <li class="active"><?php echo dictionary('HEADER_DEPARTAMENTS_PAGE');?></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!--End breadcrumb area-->
<!--Start Medical Departments area-->
<section class="medical-departments-area medic-bottom">
    <div class="container">
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
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>
