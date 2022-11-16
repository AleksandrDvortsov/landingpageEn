<!DOCTYPE html>
<html lang="<?php echo $Cpu->lang?>">
<head>
    <meta charset="utf-8">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no" />
    <title>
        <?php
        if( isset($page_data['page_title']) && trim($page_data['page_title']) != '' )
        {
            echo $page_data['page_title'];
        }
        else
        {
            echo $page_data['title'];
        }
        ?>
    </title>
    <meta name="description" content="<?php echo $page_data['meta_d']?>">
    <meta name="keywords" content="<?php echo $page_data['meta_k']?>">
    <?php
    if($page_data['cat_id'] == 526) // blog -> detail page
    {
        $seo_data_element = $db
            ->where('active', 1)
            ->where('id', $page_data['elem_id'])
            ->getOne('blog_elements');
        if($seo_data_element)
        {
            ?>
            <meta property="og:title" content="<?php echo preview_text($seo_data_element['title_'.$lang]);?>"/>
            <meta property="og:description" content="<?php echo preview_text($seo_data_element['preview_'.$lang]);?>"/>
            <?php $imagethumb = $Functions->image_thumb($seo_data_element['image'], 'blog_elements', 250, 250, 555, 1); ?>
            <meta property="og:image" content="<?php echo $host_link.$imagethumb;?>"/>
            <?php
        }
    }
    else
    {
        ?>
        <meta property="og:title" content="AMC - Centru Medical American. Cei mai buni doctori pentru o medicina modernă. "/>
        <meta property="og:description" content=""/>
        <?php $imagethumb = '/css/images/amc_og.jpg'; ?>
        <meta property="og:image" content="<?php echo $host_link.$imagethumb;?>"/>
        <?php
    }
    ?>
 
    <link rel="stylesheet" href="/css/style.css?v=<?php echo $css_version;?>">
    <link rel="stylesheet" href="/css/responsive.css?v=<?php echo $css_version;?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css"/>
    <link href="/css/dev_style.css?v=<?php echo $css_version;?>" rel="stylesheet" type="text/css"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/images/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/images/favicon/favicon-16x16.png" sizes="16x16">
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script src="/js/html5shiv.js"></script>
    <![endif]-->


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131349504-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-131349504-1');
    </script>

 
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1012309955864958');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=1012309955864958&ev=PageView&noscript=1";
        /></noscript>
    <!-- End Facebook Pixel Code -->

</head>
<body class="page_id_<?php echo $page_data['cat_id'];?>">
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v3.2';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>


<div class="popUpBackground" onclick="close_popUpGal()"></div>
<?php
if($User->check_cp_authorization())
{
    ?>
    <input type="button" id="btnEnableDisable" value="Disable links" />
    <?php
}
?>
<div id="cssload-container">
    <div class="cssload-whirlpool"></div>
</div>
<div class="boxed_wrapper">
    <div class="preloader"></div>

    <section class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
                    <div class="logo">
                        <a href="<?php echo $Cpu->getURL('100')?>">
                            <?php
                                $logo_imagethumb = $Functions->image_thumb($GLOBALS['ar_define_settings']['SITE_FRONT_LOGO'], 'settings', 628, 110, 100, 0);
                            ?>
                            <img src="<?php echo $logo_imagethumb;?>" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 hidden-md hidden-sm hidden-xs">
                    <div class="header-right">
                        <ul>
                            <li>
                                <div class="icon-holder">
                                    <!-- <span class="flaticon-technology"></span> -->
                                    <img src="/images/icon/icon-phone.svg" alt="">
                                </div>
                                <div class="text-holder">
                                    <h4><?php echo dictionary('FRONT_HEADER_KEY_100');?></h4>
                                    <span><?php echo dictionary('FRONT_CONTACT_PHONE_1');?></span>
                                </div>
                            </li>
                            <li>
                                <div class="icon-holder">
                                    <!-- <span class="flaticon-pin"></span> -->
                                    <img src="/images/icon/icon-location.svg" alt="">
                                   
                                </div>
                                <div class="text-holder">
                                    <h4><?php echo dictionary('FRONT_HEADER_KEY_101');?></h4>
                                    <span><?php echo dictionary('FRONT_CONTACT_US_ADDRESS_DESCRIPTION');?></span>
                                </div>
                            </li>
                            <li>
                                <div class="icon-holder">
                                    <!-- <span class="flaticon-agenda"></span> -->
                                    <img src="/images/icon/icon-date.svg" alt="">
                                </div>
                                <div class="text-holder">
                                    <h4><?php echo dictionary('FRONT_HEADER_KEY_102');?></h4>
                                    <span><?php echo dictionary('FRONT_HEADER_KEY_103');?></span>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col-lg-1 col-md-9 col-sm-6 col-xs-6">
                    <div class="top-right clearfix">
                        <ul class="header--topbar-lang nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fm fa-language"></i>
                                    <?php echo mb_ucfirst($lang);?>
                                    <i class="fa flm fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php
                                    $last_element_of_list_site_lang_array = array_values(array_slice($list_of_site_langs, -1))[0];
                                    foreach ($list_of_site_langs as $site_lang)
                                    {
                                         ?>
                                        <li class="lang_cahs">
                                            <a href="<?php echo $Cpu->getURLbyLang($pageData['page_id'],$pageData['elem_id'], $site_lang);?>">
                                                <?php echo mb_ucfirst($site_lang);?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </section> 

    <section class="mainmenu-area stricky">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!--Start mainmenu-->
                    <nav class="main-menu pull-left">
                        <div class="navbar-header">
                            <div class="logo logo-mobile">
                                <a href="<?php echo $Cpu->getURL('100');?>">
                                    <!-- <img src="<?php echo $logo_imagethumb;?>" alt="Logo"> -->
                                </a>
                            </div>
                            <div class="mobil-button" style="float: left;">
                                <div class="consultation-button">
                            <a href="#" data-toggle="modal" data-target="#exampleModal"><?php echo dictionary('FRONT_HEADER_KEY_211');?></a>
                        </div>
                            </div>
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                        </div>
                        <div class="navbar-collapse collapse clearfix">
                            <ul class="navigation clearfix">
                                <?php /*
                                <li class="<?php if($page_data['cat_id'] == 100) { ?> active_menu <?php } ?>"><a href="<?php echo $Cpu->getURL(100); ?>"><?php echo dictionary('HEADER_HOME_PAGE');?></a></li>
                                */ ?>
                                <li><a href="<?php echo $Cpu->getURL(100);?>"><i class="fa fa-home"></i></a></li>
                                <li class="dropdown <?php if($page_data['cat_id'] == 711) { ?> active_menu <?php } ?>"><a href="<?php echo $Cpu->getURL(711);?>"><?php echo dictionary('HEADER_ABOUT_US_PAGE');?></a>
                                    <ul>

                                        <li><a href="<?php echo $Cpu->getURL(711);?>"><?php echo dictionary('HEADER_ABOUT_OUR_HOSPITAL_PAGE');?></a></li>
                                        <li><a href="<?php echo $Cpu->getURL(702); ?>"><?php echo dictionary('HEADER_ABOUT_OUR_DOCTORS_PAGE');?></a></li>
                                        <li><a href="<?php echo $Cpu->getURL(750); ?>"><?php echo dictionary('HEADER_ABOUT_FAQ_PAGE');?></a></li>
                                        <li><a href="<?php echo $Cpu->getURL(753);?>"><?php echo dictionary('HEADER_ABOUT_FAQ_REVIEWS');?></a></li>
                                        <li><a href="<?php echo $Cpu->getURL(754);?>"><?php echo dictionary('HEADER_OUR_GALLERY');?></a></li>
                                    </ul>
                                </li>

                                <li class="<?php if($page_data['cat_id'] == 700 || $page_data['cat_id'] == 701) { ?> active_menu <?php } ?>"><a href="<?php echo $Cpu->getURL(700); ?>"><?php echo dictionary('HEADER_DEPARTAMENTS_PAGE');?></a></li>
                                <li class="<?php if($page_data['cat_id'] == 702 || $page_data['cat_id'] == 703) { ?> active_menu <?php } ?>"><a href="<?php echo $Cpu->getURL(702); ?>"><?php echo dictionary('HEADER_TEAM_PAGE'); ?></a></li>
                                   <li class="<?php if($page_data['cat_id'] == 780 || $page_data['cat_id'] == 781) { ?> active_menu <?php } ?>">
                                    <a href="<?php echo $Cpu->getURL(780);?>"><?php echo dictionary('HEADER_SERVICES');?></a>
                                </li>
                                <li class="<?php if($page_data['cat_id'] == 768) { ?> active_menu <?php } ?>"><a href="<?php echo $Cpu->getURL(768);?>"><?php echo dictionary('HEADER_SERVIE_PRICE');?></a></li>
                                <li class="<?php if($page_data['cat_id'] == 773 || $page_data['cat_id'] == 772) { ?> active_menu <?php } ?>"><a href="<?php echo $Cpu->getURL(772);?>"><?php echo dictionary('HEADER_MEDICAL_PACKAGE');?></a></li>

                                <?php
                                $get_special_offers_data_info = $db
                                    ->where('active', 1)
                                    ->orderBy('sort', 'asc')
                                    ->get('special_offers');
                                if($get_special_offers_data_info && count($get_special_offers_data_info)>0)
                                {
                                    ?>
                                    <li class="dropdown <?php if($page_data['cat_id'] == 727) { ?> active_menu <?php } ?>">
                                        <a href="<?php echo $Cpu->getURL(727);?>">
                                            <?php echo dictionary('HEADER_SPECIAL_OFFERS_PAGE');?>
                                        </a>
                                        <ul>
                                            <?php
                                            foreach ($get_special_offers_data_info as $special_offers_data_info)
                                            {
                                                ?>
                                                <li>
                                                    <a href="<?php echo $Cpu->getURL(728, $special_offers_data_info['id']);?>">
                                                        <?php echo $special_offers_data_info['title_'.$lang];?>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                    <?php
                                }
                                ?>
                                <li class="<?php if($page_data['cat_id'] == 524 || $page_data['cat_id'] == 525 || $page_data['cat_id'] == 526) { ?> active_menu <?php } ?>"><a href="<?php echo $Cpu->getURL(524);?>"><?php echo dictionary('HEADER_JURNAL_PAGE'); ?></a></li>

                                <li class="<?php if($page_data['cat_id'] == 769) { ?> active_menu <?php } ?>"><a href="<?php echo $Cpu->getURL(769);?>"><?php echo dictionary('HEADER_CONTACT_US');?></a></li>
                             
                            </ul>
                        </div>
                    </nav>
                    <!--End mainmenu-->
                    <!--Start mainmenu right box-->
                    <div class="mainmenu-right-box pull-right">
                        <div class="consultation-button">
                            <a href="#" data-toggle="modal" data-target="#exampleModal"><?php echo dictionary('FRONT_HEADER_KEY_211');?></a>
                        </div>
                    </div>
                    <!--End mainmenu right box-->
                </div>
            </div>
        </div>
    </section>