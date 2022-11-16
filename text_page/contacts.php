<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>

    <section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <h1><?php echo dictionary('HEADER_CONTACT_US');?></h1>
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
                                <li class="active"><?php echo dictionary('HEADER_CONTACT_US');?></li>
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
    <!--Start contact form area-->
    <section class="contact-form-area">
        <div class="container">
            <div class="sec-title">
                <div class="dev_g"><?php echo dictionary('FRONT_CONTACT_US_KEY_1');?></div>
                <span class="border"></span>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    <div class="contact-form">
                        <form id="contact-form" method="post" data-form_type='2' data-form_task='form_contact_us'>
                            <?php echo $Token->generateHiddenField();?>
                            <h2><?php echo dictionary('FRONT_CONTACT_US_KEY_2');?></h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="fio" class="required" value="" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_FIO');?>"
                                           required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="required" name="email" value="" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_EMAIL');?>" autocomplete="off" required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="required" name="phone" value="" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_PHONE_NUMBER');?>" required="" maxlength="20">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="required" name="subject" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_SUBJECT');?>" required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea name="question" class="required" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_YOU_QUESTION');?>" required=""></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="thm-btn bgclr-1 get_btn" type="submit">
                                       <?php echo dictionary('FRONT_CONTACT_FORM_SEND_MESSAGE');?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="quick-contact">
                        <div class="title">
                            <h2><?php echo dictionary('FRONT_CONTACT_US_PAGE_KEY_0');?></h2>
                            <p><?php echo dictionary('FRONT_CONTACT_US_PAGE_KEY_1');?></p>
                        </div>
                        <ul class="contact-info">
                            <li>
                                <div class="icon-holder">
                                    <span class="flaticon-pin"></span>
                                </div>
                                <div class="text-holder">
                                    <h5><span><?php echo dictionary('FRONT_CONTACT_US_PAGE_KEY_2');?></span>
                                        <?php echo dictionary('FRONT_CONTACT_US_ADDRESS_DESCRIPTION');?>
                                    </h5>
                                </div>
                            </li>
                            <li>
                                <div class="icon-holder">
                                    <span class="flaticon-technology"></span>
                                </div>
                                <div class="text-holder">
                                    <h5><span><?php echo dictionary('FRONT_CONTACT_US_PAGE_KEY_3');?></span>
                                        <?php echo dictionary('FRONT_CONTACT_PHONE_1');?>
                                    </h5>
                                </div>
                            </li>
                            <li>
                                <div class="icon-holder">
                                    <span class="flaticon-interface"></span>
                                </div>
                                <div class="text-holder">
                                    <h5><span><?php echo dictionary('FRONT_CONTACT_US_PAGE_KEY_4');?></span>
                                        <?php echo dictionary('FRONT_CONTACT_US_EMAIL');?>
                                    </h5>
                                </div>
                            </li>
                        </ul>
                        <ul class="social-links">
                            <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['FACEBOOK_LINK'];?>"><i class="fa fa-facebook"></i></a></li>
                            <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['TWITTER_LINK'];?>"><i class="fa fa-twitter"></i></a></li>
                            <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['GOOGLE_PLUS'];?>"><i class="fa fa-google-plus"></i></a></li>
                            <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['PINTEREST'];?>"><i class="fa fa-pinterest-p"></i></a></li>
                            <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['YOUTUBE'];?>"><i class="fa fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End contact form area-->
    <!--Start contact map area-->
    <section class="contact-map-area">
        <div class="container-fluid">
            <iframe width="100%" height="550" frameborder="0" src="<?php echo $GLOBALS['ar_define_settings']['POINT_CODE_MAP'];?>"></iframe>
        </div>
    </section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>