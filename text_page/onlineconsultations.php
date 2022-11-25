<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>

<style>
    h1 {
        text-align: center;
    }
    
    h2 {
        margin: 0;
    }
    
    #multi-step-form-container {
        margin-top: 5rem;
    }
    
    .text-center {
        text-align: center;
    }
    
    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }
    
    .pl-0 {
        padding-left: 0;
    }
    
    .button {
        padding: 0.7rem 1.5rem;
        border: 1px solid #4789c8;
        background-color: #4789c8;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .submit-btn {
        border: 1px solid #7cbf74;
        background-color: #7cbf74;
    }
    
    .mt-3 {
        margin-top: 2rem;
    }
    
    .d-none {
        display: none;
    }
    
    .form-step {
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        padding: 3rem;
    }
    
    .font-normal {
        font-weight: normal;
    }
    
    ul.form-stepper {
        counter-reset: section;
        margin-bottom: 3rem;
    }
    
    ul.form-stepper .form-stepper-circle {
        position: relative;
    }
    
    ul.form-stepper .form-stepper-circle span {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateY(-50%) translateX(-50%);
    }
    
    .form-stepper-horizontal {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
    }
    
    ul.form-stepper>li:not(:last-of-type) {
        margin-bottom: 0.625rem;
        -webkit-transition: margin-bottom 0.4s;
        -o-transition: margin-bottom 0.4s;
        transition: margin-bottom 0.4s;
    }
    
    .form-stepper-horizontal>li:not(:last-of-type) {
        margin-bottom: 0 !important;
    }
    
    .form-stepper-horizontal li {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: start;
        -webkit-transition: 0.5s;
        transition: 0.5s;
    }
    
    .form-stepper-horizontal li:not(:last-child):after {
        position: relative;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        height: 1px;
        content: "";
        top: 32%;
    }
    
    .form-stepper-horizontal li:after {
        background-color: #dee2e6;
    }
    
    .form-stepper-horizontal li.form-stepper-completed:after {
        background-color: #4da3ff;
    }
    
    .form-stepper-horizontal li:last-child {
        flex: unset;
    }
    
    ul.form-stepper li a .form-stepper-circle {
        display: inline-block;
        width: 40px;
        height: 40px;
        margin-right: 0;
        line-height: 1.7rem;
        text-align: center;
        background: rgba(0, 0, 0, 0.38);
        border-radius: 50%;
    }
    
    .form-stepper .form-stepper-active .form-stepper-circle {
        background-color: #4789c8 !important;
        color: #fff;
    }
    
    .form-stepper .form-stepper-active .label {
        color: #4789c8 !important;
    }
    
    .form-stepper .form-stepper-active .form-stepper-circle:hover {
        background-color: #4789c8 !important;
        color: #fff !important;
    }
    
    .form-stepper .form-stepper-unfinished .form-stepper-circle {
        background-color: #f8f7ff;
    }
    
    .form-stepper .form-stepper-completed .form-stepper-circle {
        background-color: #7cbf74 !important;
        color: #fff;
    }
    
    .form-stepper .form-stepper-completed .label {
        color: #7cbf74 !important;
    }
    
    .form-stepper .form-stepper-completed .form-stepper-circle:hover {
        background-color: #7cbf74 !important;
        color: #fff !important;
    }
    
    .form-stepper .form-stepper-active span.text-muted {
        color: #fff !important;
    }
    
    .form-stepper .form-stepper-completed span.text-muted {
        color: #fff !important;
    }
    
    .form-stepper .label {
        font-size: 1rem;
        margin-top: 0.5rem;
    }
    
    .form-stepper a {
        cursor: default;
    }
    #calendar {
        width: 100%;
        height: 500px;
        border-collapse: collapse;
    }

    #calendar tbody td {
        border: 1px solid black;
        text-align: right;
        vertical-align: top;
        width: 14%;
    }

    #calendar td.empty {
        border: none;
    }

    .block-reservation-time-tab {
        align-items: stretch;
        inline-size: 1600px;
        perspective-origin: 800px 327px;
        transform-origin: 800px 327px;
        width: 1600px;
        display: flex;
        overflow-x: auto;
        max-inline-size: 100%;
        flex: 0 0 auto;
        margin: 0px 1px;
    }

    .reservation-tab-colum {
        align-content: stretch;
        align-items: stretch;
        backface-visibility: hidden;
        display: flex;
        float: left;
        inline-size: 80px;
        justify-content: flex-start;
        min-block-size: 1px;
        min-height: 1px;
        perspective-origin: 40px 327px;
        text-align: center;
        transform-origin: 40px 327px;
        user-select: none;
        width: 80px;
        flex-flow: column nowrap;

    }
    .reservation-tab-head{
        block-size: 60px;
        font-size: 14px;
        height: 60px;
        inline-size: 80px;
        line-height: 22px;
        margin-block-end: 18px;
        min-block-size: auto;
        min-height: auto;
        padding-block-start: 16px;
        perspective-origin: 40px 30px;
        text-align: center;
        transform-origin: 40px 30px;
        width: 80px;
        margin: 0px 0px 18px;
        padding: 16px 0px 0px;
    }

    .reservation-tab-head div{
        block-size: 44px;
        font-size: 14px;
        height: 44px;
        inline-size: 80px;
        line-height: 22px;
        perspective-origin: 40px 22px;
        text-align: center;
        transform-origin: 40px 22px;
        width: 80px;
    }

    .reservation-tab-body div {
        color: white;
        height: 40px;
        line-height: 40px;
        width: 72px;
        background: rgb(40, 128, 221) none repeat scroll 0% 0% / auto padding-box border-box;
        border: 1px solid rgb(40, 128, 221);
        margin: 0px 3.5px 8px;
        border-radius: 10px;
    }

    .time_new[type=radio]{
        visibility: hidden;
        position: absolute;
    }

</style>

<?php 


if(!isset($_GET['doctorID']) && empty($_GET['doctorID'])){
    header('HTTP/1.0 404 Not Found');
    include($_SERVER['DOCUMENT_ROOT']."/404.php");
    exit;
}else{

    $get_doctor_arr = $db
        ->where('id_1c', $_GET['doctorID'])
        ->get('doctors');

    if(empty($get_doctor_arr)){
        header('HTTP/1.0 404 Not Found');
        include($_SERVER['DOCUMENT_ROOT']."/404.php");
        exit;
    }

    $get_doctor = $get_doctor_arr[0];

    $rw_id = $get_doctor['id'];
    $doctor_image = $db
        ->where('parent_id', $get_doctor['id'])
        ->getOne('doctors_images');
    $thumb_image = $Functions->image_thumb($doctor_image['image'], 'doctors_images','270','270','2','1');
    if(empty($thumb_image))
    {
        $thumb_image = '/css/images/no-photo.jpg';
    }

    echo "<script>console.log('" . $get_doctor['title_'.$lang] . "');</script>";
}
echo "<script>console.log('" . $get_doctor['title_'.$lang] . "', ' - test');</script>";

$stringJson="{\"DoctorId\":37,\"Schedule\":[{\"VisitType\":\"Online\",\"VisitDate\":\"01.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"01.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"01.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"01.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"01.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"02.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"02.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"02.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"02.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"02.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"03.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"03.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"03.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"03.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"03.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"08.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"08.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"08.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"08.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"08.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"09.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"09.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"09.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"09.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"09.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"10.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"10.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"10.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"10.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"15.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"15.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"15.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"15.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"15.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"16.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"16.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"16.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"16.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"16.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"17.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"17.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"17.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"17.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"17.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"22.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"22.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"22.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"22.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"22.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"23.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"23.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"23.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"23.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"23.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"24.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"24.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"24.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"24.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"General\",\"VisitDate\":\"24.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"29.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"29.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"29.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"29.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"Online\",\"VisitDate\":\"29.09.2022\",\"VisitTime\":\"13.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"30.09.2022\",\"VisitTime\":\"09.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"30.09.2022\",\"VisitTime\":\"10.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"30.09.2022\",\"VisitTime\":\"11.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"30.09.2022\",\"VisitTime\":\"12.00\"},{\"VisitType\":\"Offline\",\"VisitDate\":\"30.09.2022\",\"VisitTime\":\"13.00\"}]}";
//$test = $Erp->GetAdmissionSchedule($get_doctor['id']);
?>

<section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <h1> <?php echo dictionary('CHOICERECEPTIONMETHOD');?></h1>
                        <!-- <h1><?php echo dictionary('HEADER_CONTACT_US');?></h1> -->
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
                                <!-- <li class="active"><?php echo dictionary('HEADER_CONTACT_US');?></li> -->
                                <li class="active"><?php echo dictionary('CHOICERECEPTIONMETHOD');?></li>
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
            <div class="row">
            <div>
                    <h1><?php echo dictionary('DOCTORSAPPOINTMENTFORM');?></h1>
                    <div id="multi-step-form-container">
                        <!-- Form Steps / Progress Bar -->
                        <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
                            <!-- Step 1 -->
                            <li class="form-stepper-active text-center form-stepper-list" step="1">
                                <a class="mx-2">
                                    <span class="form-stepper-circle">
                                        <span>1</span>
                                    </span>
                                    <div class="label"><?php echo dictionary('CHOICERECEPTIONMETHOD');?></div>
                                </a>
                            </li>
                            <!-- Step 2 -->
                            <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                                <a class="mx-2">
                                    <span class="form-stepper-circle text-muted">
                                        <span>2</span>
                                    </span>
                                    <div class="label text-muted"><?php echo dictionary('PERSONALDATA');?></div>
                                </a>
                            </li>
                            <!-- Step 3 -->
                            <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                                <a class="mx-2">
                                    <span class="form-stepper-circle text-muted">
                                        <span>3</span>
                                    </span>
                                    <div class="label text-muted">Оплатить прием</div>
                                </a>
                            </li>
                        </ul>
                        <!-- Step Wise Form Content -->
                        <form id="userAccountSetupForm" name="userAccountSetupForm" enctype="multipart/form-data" method="POST">
                            <!-- Step 1 Content -->
                            <section id="step-1" class="form-step">
                                <h2 class="font-normal"><?php echo dictionary('CHOICERECEPTIONMETHOD');?></h2>
                                <!-- Step 1 input fields -->
                                <div class="mt-3" style=" display: flex; justify-content: space-between; ">
                                    <div> 
                                        <?php 
                                            if($get_doctor['isOnline']){
                                                echo "<script>console.log('Принимает онлайн');</script>";
                                                ?>
                                                <div style=" display: flex;">
                                                    <div class="easy-autocomplete" style=" margin-right: 5px; ">
                                                        <input type="radio" id="onlineregistration" name="online" value="true" required checked>
                                                        <div class="easy-autocomplete-container" id="eac-container-onlineregistration">
                                                        </div>
                                                    </div>
                                                    <label class="main-form__label" for="onlineregistration"><?php echo dictionary('ONLINERECEPTION');?></label>
                                                    
                                                </div>
                                                <?php
                                            }
                                            if($get_doctor['isOffline']){
                                                ?>
                                                <div style=" display: flex;"> 
                                                    <div class="easy-autocomplete" style=" margin-right: 5px; ">
                                                    <input type="radio" id="offlineregistration" name="online" value="false">
                                                        <div class="easy-autocomplete-container" id="eac-container-onlineregistration">
                                                        </div>
                                                    </div>
                                                    <label class="main-form__label" for="offlineregistration"><?php echo dictionary('OFFLINERECEPTION');?></label>
                                                </div>
                                                <?php
                                            }
                                        ?>

                                    </div>
                                    <div style=" display: flex; "> 
                                        <div style="padding-right: 10px;">
                                            <p><?php echo $get_doctor['title_'.$lang];?></p>

                                            <p><?php echo  preview_text($get_doctor['text_2_'.$lang]).'<br/>';?></p>
                                        </div>

                                        <div class="imageframe-align-center">
                                            <span class="fusion-imageframe imageframe-none imageframe-1 hover-type-none doctor-image">
                                                
                                                <img style="max-height: 100px;width: unset;" src="<?php echo $thumb_image; ?>">
                                            </span>
                                        </div>

                                    </div>
                                    
                                </div>

                                <div class="block-reservation-time-tab">
                                    <input name="SelectTime" type="hidden" id="SelectTime">
                                            <?php 
                                                for ($i = 1; $i <= 20; $i++) {
                                                    
                                                    ?>
                                                        <div class="reservation-tab-colum">
                                                            <div class="reservation-tab-head">
                                                                <div>
                                                                    Сьогодні,<br>2<?php echo $i;?> лист
                                                                </div>
                                                            </div>
                                                            <div class="reservation-tab-body">
                                                                <?php 
                                                                    $maxH = rand(1, 10);
                                                                    $randTime = rand(8, 20);
                                                                    for ($j = 1; $j <= $maxH; $j++) {
                                                                        $randTime++;
                                                                        ?>
                                                                        <div>
                                                                        
                                                                            <input class="time_new" type="radio" id="time_<?php echo $i.$j;?>" data-infodata="29-11-2022_<?php echo $i.$j;?>" data-infotime="8:30_<?php echo $i.$j;?>" name="time_new" value="time_<?php echo $i.$j;?>" >
                                                                            <label class="" for="time_<?php echo $i.$j;?>" ><?php echo $randTime;?>:00</label>
                                                                       
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                ?>
                                                                
                                                            </div>
                                                        </div>
                                                    <?php
                                                }
                                            ?>
                                </div>

                                <div style="display:none;">
                                    <h3 class="card-header" id="monthAndYear">Nov 2022</h3>
                                    <table class="table table-responsive-sm" id="calendar">
                                        <thead>
                                            <tr>
                                                <th>Mon</th>
                                                <th>Tue</th>
                                                <th>Wed</th>
                                                <th>Thu</th>
                                                <th>Fri</th>
                                                <th>Sat</th>
                                                <th>Sun</th>
                                            </tr>
                                        </thead>

                                        <tbody id="calendar-body">
                                            <tr>
                                                <td></td>
                                                <td>01.11.22</td>
                                                <td>02.11.22</td>
                                                <td>03.11.22</td>
                                                <td>04.11.22</td>
                                                <td>05.11.22</td>
                                                <td>06.11.22</td>
                                            </tr>
                                            <tr>
                                                <td>07.11.22</td>
                                                <td>08.11.22</td>
                                                <td>09.11.22</td>
                                                <td>10.11.22</td>
                                                <td>11.11.22</td>
                                                <td>12.11.22</td>
                                                <td>13.11.22</td>
                                            </tr>
                                            <tr>
                                                <td>14.11.22</td><td>15.11.22</td><td>16.11.22</td><td>17.11.22</td><td>18.11.22</td><td>19.11.22</td><td>20.11.22</td>
                                            </tr>
                                            <tr>
                                                <td>21.11.22</td>
                                                <td class="bg-info">
                                                    <div>
                                                        <p>22.11.22</p>
                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >08:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >09:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >09:30</label>

                                                            <input type="radio" id="time-25-8-30" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >10:00</label>
                                                        </div>
                                                        
                                            
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p>23.11.22</p>
                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >08:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >09:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >09:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >10:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >10:30</label>

                                                            <input type="radio" id="time-25-8-30" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >11:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >11:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >12:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >12:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >13:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >13:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >14:00</label>
                                                        </div>
                                                        
                                            
                                                    </div>
                                                </td>
                                                <td>
                                                <div>
                                                        <p>24.11.22</p>
                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >08:30</label>

                                                            <input type="radio" id="time-25-8-30" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >09:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >09:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >10:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >10:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >11:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >11:30</label>

                                                            <input type="radio" id="time-25-8-30" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >12:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >12:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >13:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >13:30</label>

                                                            <input type="radio" id="time-25-8-30" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >14:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >14:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >15:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >15:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >16:00</label>
                                                        </div>
                                                        
                                            
                                                    </div>
                                                </td>
                                                <td>
                                                <div>
                                                        <p>25.11.22</p>
                                                        <div class="block-date">
                                                            <input type="radio" id="time-25-8-30" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >08:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >09:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >09:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >10:00</label>
                                                        </div>
                                                        
                                            
                                                    </div>
                                                </td>
                                                <td>26.11.22</td>
                                                <td>27.11.22</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <div>
                                                        <p>28.11.22</p>
                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >08:30</label>

                                                            <input type="radio" id="time-25-8-30" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >09:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >09:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >10:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >10:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >11:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >11:30</label>

                                                            <input type="radio" id="time-25-8-30" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >12:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >12:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >13:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >13:30</label>

                                                            <input type="radio" id="time-25-8-30" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >14:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >14:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >15:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >15:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >16:00</label>
                                                        </div>
                                                        
                                            
                                                    </div>
                                                </td>
                                                <td>29.11.22</td>
                                                <td>
                                                    <div>
                                                        <p>30.11.22</p>
                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >08:30</label>

                                                            <input type="radio" id="time-25-8-30" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >09:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >09:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >10:00</label>
                                                        </div>


                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >13:30</label>

                                                            <input type="radio" id="time-25-8-30" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >14:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >14:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >15:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >15:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >16:00</label>
                                                        </div>
                                                        
                                            
                                                    </div>
                                                </td>
                                                <td>01.12.22</td>
                                                <td>02.12.22</td>
                                                <td>03.12.22</td>
                                                <td>
                                                    <div>
                                                        <p>04.12.22</p>
                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >14:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >15:00</label>
                                                        </div>

                                                        <div class="block-date">
                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >15:30</label>

                                                            <input type="radio" id="time" name="time" value="" >
                                                            <label class="main-form__label" for="onlineregistration" >16:00</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <button class="button btn-navigate-form-step btn" type="button" step_number="2">Вперед</button>
                                </div>
                            </section>
                            <!-- Step 2 Content, default hidden on page load. -->
                            <section id="step-2" class="form-step d-none">
                                <h2 class="font-normal"><?php echo dictionary('PERSONALDATA');?></h2>
                                <!-- Step 2 input fields -->
                                <div class="mt-3">
                                    <h3 style="font-size: 24px;font-weight: 400;line-height: 35px;text-align: center;margin: 15px 0 0;"> Вы запросили встречу на <span id="infodata" style=" color: #4789c8; ">Не указано</span> в <span id="infotime" style=" color: #4789c8; ">Не указано</span>. 
                                        <p>Специалист: <?php echo $get_doctor['title_'.$lang];?>, <?php echo  preview_text($get_doctor['text_2_'.$lang]).'<br/>';?></p>
                                    </h3>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="main-form__field">
                                                <label class="main-form__label" for="FirstAndLastName">Имя / Фамилия  <span>*</span></label>
                                                <input class="main-form__input" id="FirstAndLastName" name="FirstAndLastName" type="text" value="">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="main-form__field">
                                                <label class="main-form__label" for="Phone" maskvalue="(###) ###-####">Phone  <span>*</span></label>
                                                <input class="main-form__input" id="Phone" name="Phone" type="text" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        

                                        <div class="col-sm-6">
                                            <div class="main-form__field">
                                                <label class="main-form__label" for="IDNP">IDNP  <span>*</span></label>
                                                <input class="main-form__input" id="IDNP" name="Idnp" type="text" value="" >
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="main-form__field">
                                                <label class="main-form__label" for="Email">Email <span>*</span></label>
                                                <input class="main-form__input" id="Email" name="Email" type="text" value="" >
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div style=" display: flex; justify-content: space-between; margin-top: 50px; ">
                                        <div style=" width: 45%; ">
                                            <div class="main-form__field">
                                                <label class="main-form__label" for="FirstAndLastName">Имя  <span>*</span></label>
                                                <input class="main-form__input" id="FirstAndLastName" name="fio" type="text" placeholder="Имя / Фамилия" value="">
                                            </div>

                                            <div class="main-form__field">
                                                <label class="main-form__label" for="IDNP">Имя  <span>*</span></label>
                                                <input class="main-form__input" id="IDNP" name="idnp" type="text" placeholder="IDNP" value="">
                                            </div>
                                        </div>
                                        <div style=" width: 45%; ">
                                            <label class="main-form__label" for="" >Phone <span>*</span></label>
                                            <input type="text" name="phone" class="required" value="" placeholder="phone" required="" aria-required="true" style=" width: 100%; border: 1px solid #ececec; background: #ffffff; color: #000; height: 50px; display: block; padding: 0 15px; font-size: 16px; font-weight: 300; font-family: &quot;Source Sans Pro&quot;, sans-serif; transition: all 500ms ease; margin-bottom: 30px; ">
                                            <label class="main-form__label" for="" >Email <span>*</span></label>
                                            <input type="text" name="email" class="required" value="" placeholder="email" required="" aria-required="true" style=" width: 100%; border: 1px solid #ececec; background: #ffffff; color: #000; height: 50px; display: block; padding: 0 15px; font-size: 16px; font-weight: 300; font-family: &quot;Source Sans Pro&quot;, sans-serif; transition: all 500ms ease; margin-bottom: 30px; ">
                                        </div>

                                       
                                    </div> -->
                                    <div class="main-form__field">
                                        <div class="checkbox-label">
                                            <input class="checkbox-label__input" type="checkbox" name="Timereservation" id="Timereservation" value="true">
                                            <label class="checkbox-label__main" for="Timereservation">резервирование времени происходит только при оплате online</label>
                                        </div>
                                    </div>


                                </div>
                                <div class="mt-3">
                                    <button class="button btn-navigate-form-step btn" type="button" step_number="1">Назад</button>
                                    <button class="button btn-navigate-form-step btn" type="button" step_number="3" disabled id="TimereservationSubmit">Вперед</button>
                                </div>
                            </section>
                            <!-- Step 3 Content, default hidden on page load. -->
                            <section id="step-3" class="form-step d-none">
                                <h2 class="font-normal">Оплатить прием</h2>
                                <!-- Step 3 input fields -->
                                <div class="mt-3">
                                    Оплатить тут ссылка на оплату
                                </div>
                                <div class="mt-3">
                                    <button class="button btn-navigate-form-step btn" type="button" step_number="2">Назад</button>
                                    <button class="button submit-btn btn" type="submit">Оплатить</button>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End contact form area-->
    <!--Start contact map area-->

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>

<script>

    //$("input[name=online]:checked").attr('id')

    $('#Phone').mask("+375-99-999-999");

    $("[name='Timereservation']").on("change", function() {
                var button = $(this).parents("form:first").find("#TimereservationSubmit");
                if ($(this).is(":checked")) {
                    button.removeClass("submit-inactive");
                    button.prop("disabled", false);
                } else {
                    button.addClass("submit-inactive");
                    button.prop("disabled", true);
                }
            });

    $("input[name='time_new']").click(function(){
        console.log($(this).data("infodata"), $(this).data("infotime"))
        $("input[name='time_new']").each(function( index ) {
            $(this).parent().css('background-color', '#2880dd');
            $(this).parent().css('border-color', '#2880dd');
        });
        $(this).parent().css('background-color', '#7cbf74');
        $(this).parent().css('border-color', '#7cbf74');

        $("#SelectTime").val($(this).val());
        $("#infodata").html($(this).data("infodata"));
        $("#infotime").html($(this).data("infotime"));
    })

    function resetIfInvalid(el){
        console.log(el.list.options)
        //just for beeing sure that nothing is done if no value selected
        if (el.value == "")
            return;
        var options = el.list.options;
        for (var i = 0; i< options.length; i++) {
            if (el.value == options[i].value)
                //option matches: work is done
                return;
        }
        //no match was found: reset the value
        el.value = "";
    }

    document.jurValidationRules = {
                errorClass: "error__desc",
                errorElement: "small",
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                    var parent = $(element).parent('.main-form__field');
                    if (!parent.length)
                        parent = $(element).parent().parent('.main-form__field');
                    parent.addClass('error');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                    var parent = $(element).parent('.main-form__field');
                    if (!parent.length)
                        parent = $(element).parent().parent('.main-form__field');
                    parent.removeClass('error');
                },
                rules: {
                    online: {
                        required: true                        
                    }, 
                    SelectTime: {
                        required: true                        
                    }, 
                    FirstAndLastName: {
                        required: true                        
                    }, 
                    Idnp: {
                        required: true                        
                    }, 
                    Phone: {
                        required: true                        
                    }, 
                    Email: {
                        required: true,
                        email: true                        
                    }, 
                    Timereservation: {
                        required: true                        
                    }                   

                },
                messages: {
                    FirstAndLastName: "<?php echo dictionary("EMTY_REQUIRED_INPUT_FIELD_FIO");?>",
                    Idnp: "Тут ошибка по Idnp",
                    Phone: "<?php echo dictionary("EMTY_REQUIRED_INPUT_FIELD_PHONE_NUMBER");?>",
                    Email: "<?php echo dictionary("EMTY_REQUIRED_INPUT_FIELD_EMAIL");?>",
                    Timereservation: "<?php echo dictionary("EMTY_REQUIRED_INPUT_FIELD_TIME_RESERVATION");?>",
                }
            };
    $("#userAccountSetupForm").validate(document.jurValidationRules);

    const navigateToFormStep = (stepNumber) => {

        console.log(stepNumber)
        if(stepNumber == 2 && !($("#SelectTime").val() != '')) {
            return;
        };

        if(stepNumber == 3 && !$("#userAccountSetupForm").valid()) {
            return;
        };
        
        document.querySelectorAll(".form-step").forEach((formStepElement) => {
            formStepElement.classList.add("d-none");
        });
       
        document.querySelectorAll(".form-stepper-list").forEach((formStepHeader) => {
            formStepHeader.classList.add("form-stepper-unfinished");
            formStepHeader.classList.remove("form-stepper-active", "form-stepper-completed");
        });
        
        document.querySelector("#step-" + stepNumber).classList.remove("d-none");
        
        const formStepCircle = document.querySelector('li[step="' + stepNumber + '"]');
        
        formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-completed");
        formStepCircle.classList.add("form-stepper-active");
        
        for (let index = 0; index < stepNumber; index++) {
            
            const formStepCircle = document.querySelector('li[step="' + index + '"]');
            
            if (formStepCircle) {
               
                formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-active");
                formStepCircle.classList.add("form-stepper-completed");
            }
        }
    };
    
    document.querySelectorAll(".btn-navigate-form-step").forEach((formNavigationBtn) => {
        
        formNavigationBtn.addEventListener("click", () => {
            
            const stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));
            
            navigateToFormStep(stepNumber);
        });
    });


</script>