
<!--Start footer area-->
<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="single-footer-widget pd-bottom50">
                    <div class="title">
                        <h3><?php echo dictionary('FRONT_FOOTER_KEY_1');?></h3>
                        <span class="border"></span>
                    </div>
                    <div class="our-info">
                        <p><?php echo dictionary('FRONT_FOOTER_KEY_2');?></p>
                        <p class="mar-top"><?php echo dictionary('FRONT_FOOTER_KEY_3');?></p>
                        <a href="<?php echo $Cpu->getURL(711);?>"><?php echo dictionary('FRONT_FOOTER_KEY_4');?><i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="single-footer-widget pd-bottom50">
                    <div class="title">
                        <h3><?php echo dictionary('FRONT_FOOTER_KEY_5');?></h3>
                        <span class="border"></span>
                    </div>
                    <ul class="usefull-links fl-lft">
                        <li><a href="<?php echo $Cpu->getURL(711);?>"><?php echo dictionary('HEADER_ABOUT_US_PAGE');?></a></li>
                        <li><a href="<?php echo $Cpu->getURL(524);?>"><?php echo dictionary('HEADER_JURNAL_PAGE');?></a></li>
                        <li><a href="<?php echo $Cpu->getURL(772);?>"><?php echo dictionary('HEADER_MEDICAL_PACKAGE');?></a></li>
                        <li><a href="<?php echo $Cpu->getURL(700);?>"><?php echo dictionary('HEADER_DEPARTAMENTS_PAGE');?></a></li>
                        <li><a href="<?php echo $Cpu->getURL(727);?>"><?php echo dictionary('HEADER_SPECIAL_OFFERS_PAGE');?></a></li>
                        <li><a href="<?php echo $Cpu->getURL(753);?>"><?php echo dictionary('HEADER_ABOUT_FAQ_PAGE');?></a></li>
                        <li><a href="<?php echo $Cpu->getURL(770);?>"><?php echo dictionary('PRIVACY_POLICY_FF0B');?></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="single-footer-widget mar-bottom">
                    <div class="title">
                        <h3><?php echo dictionary('FRONT_FOOTER_KEY_10');?></h3>
                        <span class="border"></span>
                    </div>
                    <ul class="footer-contact-info">
                        <li>
                            <div class="icon-holder">
                                <span class="flaticon-pin"></span>
                            </div>
                            <div class="text-holder">
                                <h5><?php echo dictionary('FRONT_CONTACT_US_ADDRESS_DESCRIPTION');?></h5>
                            </div>
                        </li>
                        <li>
                            <div class="icon-holder">
                                <span class="flaticon-interface"></span>
                            </div>
                            <div class="text-holder">
                                <h5><?php echo dictionary('FRONT_CONTACT_US_EMAIL');?></h5>
                            </div>
                        </li>
                        <li>
                            <div class="icon-holder">
                                <span class="flaticon-technology-1"></span>
                            </div>
                            <div class="text-holder">
                                <h5><?php echo dictionary('FRONT_CONTACT_PHONE_1');?></h5>
                            </div>
                        </li>
                        <li>
                            <div class="icon-holder">
                                <span class="flaticon-clock"></span>
                            </div>
                            <div class="text-holder">
                                <h5><?php echo dictionary('FRONT_FOOTER_KEY_15');?></h5>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!--Start single footer widget-->
            <!--Start single footer widget-->
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="single-footer-widget clearfix">
                    <div class="title">
                        <h3><?php echo dictionary('FRONT_FOOTER_KEY_16');?></h3>
                        <span class="border"></span>
                    </div>
                    <form class="appointment-form" method="post" data-form_type='2' data-form_task='form_contact_us'>
                        <?php echo $Token->generateHiddenField();?>
                        <div class="input-box">
                            <input type="text" name="fio" class="required" value="" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_FIO');?>"
                                   required="">
                            <div class="icon-box">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="input-box">
                            <input type="text" class="required" name="email" value="" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_EMAIL');?>" autocomplete="off" required="">
                            <div class="icon-box">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="input-box">
                            <textarea name="question" class="required" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_YOU_QUESTION');?>" required=""></textarea>
                        </div>
                        <button type="submit" class="get_btn"><?php echo dictionary('FRONT_FOOTER_KEY_17');?></button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="single-footer-widget pd-bottom50">
                    <ul class="usefull-links usefull-links-text-info">
                        <li><a href="<?php echo $Cpu->getURL(770);?>"><?php echo dictionary('FRONT_FOOTER_KEY_100');?></a></li>
                        <li><a href="<?php echo $Cpu->getURL(771);?>"><?php echo dictionary('FRONT_FOOTER_KEY_101');?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<section class="footer-bottom-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="copyright-text">
                    <p><?php echo dictionary('FOOTER_COPYRIGHTS');?> <a href="https://webhouse.md/">Webhouse.</a></p>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="footer-social-links">
                    <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['FACEBOOK_LINK'];?>"><i class="fa fa-facebook"></i></a></li>
                    <?php
                    /*
                    <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['TWITTER_LINK'];?>"><i class="fa fa-twitter"></i></a></li>
                    <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['PINTEREST'];?>"><i class="fa fa-pinterest-p"></i></a></li>
                    */
                    ?>
                    <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['INSTAGRAM'];?>"><i class="fa fa-instagram"></i></a></li>

                    <li><a target="_blank" href="<?php echo $GLOBALS['ar_define_settings']['YOUTUBE'];?>"><i class="fa fa-youtube"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--End footer bottom area-->
 
</div>

<!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="flaticon-triangle-inside-circle"></span></div>

<?php
//show($page_data);
?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body contact-form-area">
                <section class="callto-action-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="inner-content">
                                    <div class="title-box text-center">
                                        <span class="flaticon-calendar"></span>
                                        <div class="dev_h2b"><?php echo dictionary('FRONT_FORM_MAKE_AN_APPOINTMENT');?></div>
                                    </div>
                                    <div class="form-holder clearfix">
                                        <form id="appointment" class="clearfix" method="post" data-form_type='2' data-form_task='appointment_records'>
                                        <?php echo $Token->generateHiddenField();?>
                                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/blocks/reffer_form_dates.php';?>

                                            <div class="single-box mar-right-30">
                                                <div class="input-box">
                                                    <input type="text" name="fio" class="required" value="" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_FIO');?>" required="">
                                                </div>
                                                <div class="input-box" id="doctor_ajax_info">
                                                    <select class="selectmenu required" name="doctor">
                                                        <option selected="selected"><?php echo dictionary('FRONT_APR_SELECT_DOCTOR');?></option>
                                                    </select>
                                                </div>
                                                <div class="input-box">
                                                    <input type="text" class="required" name="email" value="" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_EMAIL');?>" autocomplete="off" required="">
                                                </div>
                                            </div>

                                            <div class="single-box">
                                                <div class="input-box">
                                                    <select class="selectmenu" name="department">
                                                        <option selected="selected required"><?php echo dictionary('FRONT_APR_SELECT_DEPARTMENT');?></option>
                                                        <?php
                                                        $get_department_data_info = $db
                                                            ->where('active',1)
                                                            ->orderBy('title_'.$lang,'asc')
                                                            ->get('departaments');
                                                        if($get_department_data_info && count($get_department_data_info)>0)
                                                        {
                                                            foreach ($get_department_data_info as $department_data_info)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $department_data_info['id'];?>"><?php echo $department_data_info['title_'.$lang];?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="input-box">
                                                    <input type="text" class="required" name="date" placeholder="<?php echo dictionary('PLACEHOLDER_SELECT_AP_DATE');?>" id="datepicker" autocomplete="off" required="">
                                                    <div class="icon-box">
                                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <div class="input-box">
                                                    <input type="tel" class="required" name="phone" value="" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_PHONE_NUMBER');?>" required="" maxlength="20">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="thm-btn bgclr-1 get_btn" ><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                            </div>
                                            <div class="both"></div>
                                            <div id="appointment_records_ajax_messag_info"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/visit_statistics.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/js/scripts.php';
?>

</body>
</html>
