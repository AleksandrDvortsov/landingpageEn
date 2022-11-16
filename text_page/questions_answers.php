<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>

    <section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <h1><?php echo dictionary('HEADER_ABOUT_FAQ_PAGE');?></h1>
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
                                <li class="active"><?php echo dictionary('HEADER_ABOUT_FAQ_PAGE');?></li>
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

<?php
$get_faq_sections_data_info = $db
    ->where('active', 1)
    ->orderBy('sort','asc')
    ->get('faq_sections');
if($get_faq_sections_data_info && count($get_faq_sections_data_info)>0)
{
    ?>
    <section class="faq-content-area">
        <div class="container">
            <div class="row">
                <?php
                $faq_sections_data_info_counter = 0;
                foreach ($get_faq_sections_data_info as $faq_sections_data_info)
                {
                    $faq_sections_data_info_counter++;
                    ?>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="single-box">
                            <div class="sec-title mar0auto text-center">
                                <div class="dev_g"><?php echo $faq_sections_data_info['title_'.$lang];?></div>
                                <span class="border"></span>
                            </div>
                            <div class="accordion-box">
                                <?php
                                $get_question_answer_data_info = $db
                                    ->where('active', 1)
                                    ->where('faq_section_id', $faq_sections_data_info['id'])
                                    ->orderBy('sort', 'asc')
                                    ->get('frequent_questions');
                                if($get_question_answer_data_info && count($get_question_answer_data_info)>0)
                                {
                                    $question_answer_data_info_counter = 0;
                                    foreach ($get_question_answer_data_info as $question_answer_data_info)
                                    {
                                        $question_answer_data_info_counter++;
                                        ?>
                                        <div class="accordion accordion-block">
                                            <div class="accord-btn <?php if($question_answer_data_info_counter == 1){ ?> active <?php } ?>"><h4><?php echo $question_answer_data_info['title_'.$lang];?></h4></div>
                                            <div class="accord-content <?php if($question_answer_data_info_counter == 1){ ?> collapsed <?php } ?>">
                                                <p><?php echo preview_text($question_answer_data_info['text_'.$lang]);?></p>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if($faq_sections_data_info_counter%2 == 0)
                    {
                        ?>
                        <div class="both"></div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <?php
}
?>




    <section class="faq-question-form-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="question-form">
                        <div class="sec-title mar0auto text-center">
                            <div class="dev_g"><?php echo dictionary('FRONT_FORM_ASK_YOUR_QUESTION_KEY_0');?></div>
                            <span class="border"></span>
                        </div>
                        <form id="faq-form" method="post" data-form_type='2' data-form_task='question_answer_request'>
                            <?php echo $Token->generateHiddenField();?>
                            <?php include $_SERVER['DOCUMENT_ROOT'] . '/blocks/reffer_form_dates.php';?>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="fio" class="required" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_FIO');?>" required="">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="required" name="email" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_EMAIL');?>" autocomplete="off" required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="required" name="subject" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_SUBJECT');?>" required="">
                                </div>
                                <div class="col-md-6">
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
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea name="question" class="required" placeholder="<?php echo dictionary('PLACEHOLDER_INPUT_FIELD_YOU_QUESTION');?>" required=""></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="thm-btn bgclr-1 get_btn" type="submit"><?php echo dictionary('FRONT_SUBMIT_KEY_45');?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>