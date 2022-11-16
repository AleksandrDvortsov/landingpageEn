<?php
$category_page_info = $db
    ->where('id',$page_data['cat_id'])
    ->getOne('pages');
if(!$category_page_info)
{
    $Cpu->page404();
    exit;
}


$category_data_info = $db
    ->where('active', 1)
    ->where('id',$page_data['id'])
    ->getOne('special_offers');
if(!$category_data_info)
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
                    <h1><?php echo $category_data_info['title_'.$lang];?></h1>
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
                            <li class="active"><?php echo $category_data_info['title_'.$lang];?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Start rev  slider wrapper-->
<section class="medical-departments-area departments-page">
    <div class="container">
        <div class="row">
            <div class="sec-title mar0auto text-center">
                <div class="dev_g"><?php echo dictionary('FRONT_SP_CAT_KEY_0');?></div>
                <span class="border"></span>
            </div>
            <?php
          $get_offers_category_data_info = $db
              ->where('active', 1)
              ->where('section_id',$category_data_info['id'])
              ->orderBy('sort', 'asc')
              ->get('special_offers_elements');
          if($get_offers_category_data_info && count($get_offers_category_data_info)>0)
          {
              foreach ( $get_offers_category_data_info as $offers_category_data_info)
              {
                  $offers_category_cpu = $Cpu->getURL(729, $offers_category_data_info['id']);
                  ?>
                  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                      <a href="<?php echo $offers_category_cpu;?>">
                          <div class="fusion-layout-column fusion_builder_column fusion_builder_column_3_5  fusion-three-fifth fusion-column-last 3_5">
                              <div class="fusion-column-wrapper" style="padding: 20px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                                  <div class="fusion-title title fusion-sep-none fusion-title-center fusion-title-size-one doctor-title fusion-border-below-title dev_a8b" style="margin-top:0px;margin-bottom:0px;">
                                      <div class="title-heading-center dev_ab2" data-fontsize="30" data-lineheight="36">
                                          <span style="color: #fff;"><?php echo $offers_category_data_info['title_'.$lang];?></span>
                                      </div>
                                  </div>
                                  <div class="fusion-title title fusion-sep-none fusion-title-center fusion-title-size-four doctor-subtitle fusion-border-below-title" style="margin-top:0px;margin-bottom:20px;">
                                      <h4 class="title-heading-center" data-fontsize="20" data-lineheight="30"><?php echo $offers_category_data_info['undertitle_ru'];?></h4>
                                  </div>
                                  <div class="imageframe-align-center">
                            <span class="fusion-imageframe imageframe-none imageframe-1 hover-type-none doctor-image">
                                <?php
                                $offers_categor_el_image = $Functions->image_thumb($offers_category_data_info['image'], 'special_offers_elements', 700, 450, 159, 1);
                                ?>
                                <img src="<?php echo $offers_categor_el_image;?>" alt="<?php echo $offers_category_data_info['title_'.$lang];?>">
                            </span>
                                  </div>
                                  <div class="fusion-clearfix"></div>

                              </div>
                          </div>
                          <button class="btn-blocss"><?php echo dictionary('FRONT_READ_MORE_OF8');?></button>
                      </a>
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
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>