<div class="col-lg-4 col-md-6 col-sm-7 col-xs-12">
    <div class="sidebar-wrapper">
        <!--Start single sidebar-->
        <div class="single-sidebar wow fadeInUp" data-wow-delay="0s" data-wow-duration="1s"
             data-wow-offset="0">
            <div class="sec-title">
                <h3><?php echo dictionary('FRONT_JURNAL_RIGHT_SIDEBAR_KEY_0');?></h3>
            </div>
            <ul class="categories clearfix">
                <?php
                $get_catalog_rs_data_info = $db
                    ->where('active', 1)
                    ->orderBy('sort', 'asc')
                    ->get('blog');
                if($get_catalog_rs_data_info && count($get_catalog_rs_data_info)>0)
                {
                    foreach ($get_catalog_rs_data_info as $catalog_rs_data_info)
                    {
                        ?>
                        <li <?php if(isset($blog_curent_catalog_info['id']) && $blog_curent_catalog_info['id'] == $catalog_rs_data_info['id']) { ?> class="active_blog_category" <?php } ?> >
                            <a href="<?php echo $Cpu->getURL(525, $catalog_rs_data_info['id']);?>">
                                <?php echo $catalog_rs_data_info['title_'.$lang];?>
                                <?php
                                $get_count_catalog_elemets = $db
                                    ->where('active', 1)
                                    ->where('section_id',$catalog_rs_data_info['id'])
                                    ->get('blog_elements', null, 'id');
                                if($get_count_catalog_elemets && count($get_count_catalog_elemets) > 0)
                                {
                                    ?>
                                    <span>(<?php echo count($get_count_catalog_elemets);?>)</span>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <span>(0)</span>
                                    <?php
                                }
                                ?>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <?php
        $get_popular_blogs = $db
            ->where('active',1)
            ->where('viewed', 0, '>')
            ->orderBy('viewed', 'desc')
            ->get('blog_elements', 5);
        if($get_popular_blogs && count($get_popular_blogs)>0)
        {
            ?>
            <div class="single-sidebar wow fadeInUp" data-wow-delay="0s" data-wow-duration="1s"
                 data-wow-offset="0">
                <div class="sec-title">
                    <h3><?php echo dictionary('FRONT_POPULAR_POSTS');?></h3>
                </div>
                <ul class="popular-post">
                    <?php
                    foreach ($get_popular_blogs as $popular_blog)
                    {
                        $popular_blog_cpu = $Cpu->getURL('526', $popular_blog['id']);
                        ?>
                        <li>
                            <div class="img-holder">
                                <?php
                                $popular_blog_image_thumb = $Functions->image_thumb($popular_blog['image'], 'blog_elements', 70, 70, 571, 1);
                                ?>
                                <img src="<?php echo $popular_blog_image_thumb;?>" alt="<?php echo $popular_blog['title_'.$lang];?>">
                                <div class="overlay-style-one">
                                    <div class="box">
                                        <div class="content">
                                            <a href="<?php echo $popular_blog_cpu;?>"><i class="fa fa-link" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="title-holder">
                                <a href="<?php echo $popular_blog_cpu;?>">
                                    <h5 class="post-title">
                                        <?php echo $popular_blog['title_'.$lang];?>
                                    </h5>
                                </a>
                                <h6 class="post-date">
                                    <?php
                                    $popular_blog_date = new DateTime($popular_blog['date']);
                                    echo $popular_blog_date->format('F d, Y')
                                    ?>
                                </h6>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
        ?>
        <?php /*
        <div class="single-sidebar wow fadeInUp" data-wow-delay="0s" data-wow-duration="1s" data-wow-offset="0">
            <div class="sec-title">
                <h3 class="pull-left"><?php echo dictionary('FRONT_JURNAL_SB_KEY_90');?></h3>
            </div>
            <div class="fb-feed">
                <script src='https://www.powr.io/powr.js?platform=blogger'></script><div class="powr-instagram-feed" id=6e7772b7_1553941253></div>
           </div>
        </div>
        */ ?>
        <!--End single-sidebar-->
        <!--Start single-sidebar-->
        <div class="single-sidebar wow fadeInUp" data-wow-delay="0s" data-wow-duration="1s"
             data-wow-offset="0">
            <div class="sec-title">
                <h3><?php echo dictionary('FRONT_JURNAL_SB_KEY_100');?></h3>
            </div>
            <div class="fb-feed">
                <div class="fb-page" data-href="https://www.facebook.com/americanmedicalcenter/" data-tabs="timeline" data-width="350" data-height="234" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/americanmedicalcenter/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/americanmedicalcenter/">AMC American Medical Center</a></blockquote></div>
            </div>
        </div>
        <!--End single-sidebar-->
    </div>
</div>
<style>
    .powrMark
    {
        display: none !important;
    }
</style>
