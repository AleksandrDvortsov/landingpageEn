<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>
<section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1><?php echo dictionary('HEADER_OUR_GALLERY');?></h1>
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
                            <li class="active"><?php echo dictionary('HEADER_OUR_GALLERY');?></li>
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
<!--Start project with text area-->
<section class="tab">
    <div class="container">

            <div class="post-tab">
                <span class="item-tab item-tab-active"><?php echo dictionary('GAL_K1');?></span>
                <span class="item-tab"><?php echo dictionary('GAL_K2');?></span>
            </div>
     
    </div>
</section>
<section class="main-project-area main-project-area-active">
    <div class="container"> 
        <div class="row">
            <?php
            $get_gallery_data_info = $db
                ->where('active', 1)
                ->orderBy('sort', 'asc')
                ->get('our_gallery');
            if($get_gallery_data_info && count($get_gallery_data_info)>0)
            {
                foreach ($get_gallery_data_info as $gallery_element)
                {
                    $gallery_element_cpu = $Cpu->getURL(755, $gallery_element['id']);
                    ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="single-project-item" onclick="location.href = '<?php echo $gallery_element_cpu;?>'">
                            <div class="img-holder">
                                <?php
                                $main_image_of_dropzone = $db
                                    ->where('parent_id',$gallery_element['id'])
                                    ->orderBy('sort', 'asc')
                                    ->getOne('our_gallery_dropzone_1_images');
                                if($main_image_of_dropzone)
                                {
                                    $gallery_element_thumb_image = @newthumbs($main_image_of_dropzone['image'], 'our_gallery_dropzone_1_images', 790,535,537,1);
                                }
                                ?>
                                <img src="<?php echo $gallery_element_thumb_image;?>" alt="<?php echo $main_image_of_dropzone['original_file_name'];?>" >
                                <div class="overlay-style-one">
                                    <div class="box">
                                        <div class="content">
                                            <a href="<?php echo $gallery_element_cpu;?>">
                                                <?php echo $gallery_element['title_'.$lang];?>
                                            </a>
                                            <span class="border"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                }
            }
            else
            { 
                ?>
                <div class="nothing_founded">
                    <?php echo dictionary('NOTHING_FOUNDED');?>
                </div>
                <?php
            }
            ?>
            
        </div>
    </div>
</section>
<section class="main-project-area">
    <div class="container"> 
        <div class="row">
            <?php
            $get_video_gallery_data_info = $db
                ->where('active', 1)
                ->orderBy('sort', 'asc')
                ->get('video_gallery');
            if($get_video_gallery_data_info && count($get_video_gallery_data_info) >0)
            {
                foreach ($get_video_gallery_data_info as $video_gallery_data_info)
                {
                    $youbute_link = $Functions->youtube_link($video_gallery_data_info['video']);
                    if($youbute_link)
                    {
                        ?>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="single-project-item">
                                <iframe src="<?php echo $youbute_link;?>" allowfullscreen></iframe>
                            </div>
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


