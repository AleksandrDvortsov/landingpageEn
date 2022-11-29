<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';

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

    //erp info
    $price = $Erp->GetPrice($get_doctor['id']);
    $schedule = $Erp->GetAdmissionSchedule($get_doctor['id']);
    $scheduleOnline = $schedule[0]['Online'];
    $scheduleOffline = $schedule[0]['Offline'];

    //tab param
    $day = 0;
    $dayToday = date('d.m.Y');
    $lastdate = "";
    $lngMonth = "";
    $lngdays = "";
    
    // Вывод месяца на русском
    $monthesRu = array(1 => 'Янв', 2 => 'Фев', 3 => 'Мар', 4 => 'Апр', 5 => 'Мая', 6 => 'Июн', 7 => 'Июл', 8 => 'Авг', 9 => 'Сен', 10 => 'Окт', 11 => 'Ноя', 12 => 'Дек');
    $daysRuW = array('Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
    
    // Вывод месяца на румынском
    $monthesRo = array(1 => 'ЯнваряRo', 2 => 'ФевраляRo', 3 => 'МартаRo', 4 => 'АпреляRo',5 => 'МаяRo', 6 => 'ИюняRo', 7 => 'ИюляRo', 8 => 'АвгустаRo',9 => 'СентябряRo', 10 => 'ОктябряRo', 11 => 'НоябряRo', 12 => 'ДекабряRo');
    $daysRoW = array('ВоскресеньеRo', 'ПонедельникRo', 'ВторникRo', 'СредаRo','ЧетвергRo', 'ПятницаRo', 'СубботаRo');

}
//echo "<script>console.log('" . $get_doctor['title_'.$lang] . "', ' - test');</script>";

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
                                <li><a href="<?php echo $Cpu->getURL('100'); ?>"><?php echo dictionary('HEADER_HOME_PAGE'); ?></a></li>
                                <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                                <li><a href="<?php echo $Cpu->getURL('702'); ?>"><?php echo dictionary('HEADER_TEAM_PAGE'); ?></a></li>
                                <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                                <li><a href="<?php echo $Cpu->getURL('703', $get_doctor['id'])?>"><?php echo $get_doctor['page_title_'.$lang]; ?></a></li>
                                <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
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
    <section class="contact-form-area">
        <div class="container">
            <div class="row">
            <div>
                    <h1><?php echo dictionary('DOCTORSAPPOINTMENTFORM');?></h1>
                    <div id="multi-step-form-container">
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
                        </ul>
                        <form id="userAccountSetupForm" name="userAccountSetupForm" enctype="multipart/form-data" method="POST">
                            <!-- Step 1 Content -->
                            <section id="step-1" class="form-step">
                                <h2 class="font-normal"><?php echo dictionary('CHOICERECEPTIONMETHOD');?></h2>
                                <div class="mt-3 step1-header" >
                                    <div> 
                                        <?php 
                                            if($get_doctor['isOnline']){
                                                ?>
                                                <div class="reception-type">
                                                    <div class="easy-autocomplete" style=" margin-right: 5px; ">
                                                        <input type="radio" id="onlineregistration" name="online" value="true" required checked>
                                                    </div>
                                                    <label class="main-form__label" for="onlineregistration"><?php echo dictionary('ONLINERECEPTION');?>, <p><?php echo dictionary('FRONT_FILTER_PRICE');?>: <?php echo $price['PriceOnline'] ?> <?php echo dictionary('LEI');?></p></label>
                                                    
                                                    
                                                </div>
                                                <?php
                                            }
                                            if($get_doctor['isOffline']){
                                                ?>
                                                <div class="reception-type"> 
                                                    <div class="easy-autocomplete" style=" margin-right: 5px; ">
                                                        <input type="radio" id="offlineregistration" name="online" value="false">
                                                    </div>
                                                    <label class="main-form__label" for="offlineregistration"><?php echo dictionary('OFFLINERECEPTION');?>, <p><?php echo dictionary('FRONT_FILTER_PRICE');?>: <?php echo $price['PriceOffline'] ?> <?php echo dictionary('LEI');?></p></label>
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

                                <div style=" margin-top: 15px; ">
                                    <label class="main-form__label"><?php echo dictionary('CHOOSECONVENIENTTIMEFORYOU');?> <span>*</span></label>
                                </div>

                                <input name="SelectTime" type="hidden" id="SelectTime">

                                <div class="block-reservation-time-tab" id="onlineTable">

                                        <?php 

                                            if (!empty($scheduleOnline)) {
                                                foreach ($scheduleOnline as &$value) {
                                                    if($lastdate == ""){
                                                        if("ru" == $lang) {
                                                            $lngMonth = $monthesRu[(date('n'))];
                                                            $lngdays = $daysRuW[(date('w'))];
                                                        }
                                                        elseif("ro" == $lang) {
                                                            $lngMonth = $monthesRo[(date('n'))];
                                                            $lngdays = $daysRoW[(date('w'))];
                                                        }
                                                        else {
                                                            $lngMonth = date('M');
                                                            $lngdays = date('D');
                                                        }

                                                        ?><div class="reservation-tab-colum">
                                                            <div class="reservation-tab-head">
                                                                <div>
                                                                    <?php if($day == 0) echo "Сьогодня,<br>".date('d')." ".$lngMonth; else echo $value['VisitDate'];?>
                                                                </div>
                                                            </div>
                                                            <div class="reservation-tab-body">
                                                                <div>
                                                                    <input class="time_new" type="radio" id="time_online_<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>" data-infodata="<?php echo $value['VisitDate'];?>" data-infotime="<?php echo $value['VisitTime'];?>" name="time_new" value="<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>">
                                                                    <label class="" for="time_online_<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>"><?php echo $value['VisitTime'];?></label>
                                                                </div><?php
                                                        $lastdate = $value['VisitDate'];
                                                    }

                                                    elseif($lastdate == $value['VisitDate']){
                                                        ?><div>
                                                            <input class="time_new" type="radio" id="time_online_<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>" data-infodata="<?php echo $value['VisitDate'];?>" data-infotime="<?php echo $value['VisitTime'];?>" name="time_new" value="<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>">
                                                            <label class="" for="time_online_<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>"><?php echo $value['VisitTime'];?></label>
                                                        </div><?php
                                                        $lastdate = $value['VisitDate'];
                                                    }

                                                    if($lastdate != $value['VisitDate']){
                                                        $day++;
                                                        date('d.m.Y', strtotime($value['VisitDate']));  
                                                        if("ru" == $lang) {
                                                            $lngMonth = $monthesRu[(date('n', strtotime($value['VisitDate'])))];
                                                            $lngdays = $daysRuW[(date('w', strtotime($value['VisitDate'])))];
                                                        }
                                                        elseif("ro" == $lang) {
                                                            $lngMonth = $monthesRo[(date('n', strtotime($value['VisitDate'])))];
                                                            $lngdays = $daysRoW[(date('w', strtotime($value['VisitDate'])))];
                                                        }
                                                        else {
                                                            $lngMonth = date('M', strtotime($value['VisitDate'])); 
                                                            $lngdays = date('D', strtotime($value['VisitDate']));
                                                        }

                                                        ?>
                                                        </div>
                                                        </div>
                                                        <div class="reservation-tab-colum">
                                                            <div class="reservation-tab-head">
                                                                <div>
                                                                    <?php if($day == 1) echo "завтра,<br>".date('d', strtotime("+1 day"))." ".$lngMonth; else echo $lngdays.",<br>".date('d', strtotime($value['VisitDate']))." ".$lngMonth;?>
                                                                </div>
                                                            </div>
                                                            <div class="reservation-tab-body">
                                                                <div>
                                                                    <input class="time_new" type="radio" id="time_online_<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>" data-infodata="<?php echo $value['VisitDate'];?>" data-infotime="<?php echo $value['VisitTime'];?>" name="time_new" value="<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>">
                                                                    <label class="" for="time_online_<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>"><?php echo $value['VisitTime'];?></label>
                                                                </div><?php
                                                        $lastdate = $value['VisitDate'];
                                                    }
                                                }
                                                ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                </div>

                                <div class="block-reservation-time-tab" id="offlineTable" style=" display: none; ">
                                    <?php
                                    $day = 0;
                                    $dayToday = date('d.m.Y');
                                    $lastdate = "";

                                    if (!empty($scheduleOffline)) {
                                        foreach ($scheduleOffline as &$value) {
                                            if($lastdate == ""){
                                                if("ru" == $lang) {
                                                    $lngMonth = $monthesRu[(date('n'))];
                                                    $lngdays = $daysRuW[(date('w'))];
                                                }
                                                elseif("ro" == $lang) {
                                                    $lngMonth = $monthesRo[(date('n'))];
                                                    $lngdays = $daysRoW[(date('w'))];
                                                }
                                                else {
                                                    $lngMonth = date('M');
                                                    $lngdays = date('D');
                                                }

                                                ?><div class="reservation-tab-colum">
                                                    <div class="reservation-tab-head">
                                                        <div>
                                                            <?php if($day == 0) echo "Сьогодня,<br>".date('d')." ".$lngMonth; else echo $value['VisitDate'];?>
                                                        </div>
                                                    </div>
                                                    <div class="reservation-tab-body">
                                                        <div>
                                                            <input class="time_new" type="radio" id="time_offline_<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>" data-infodata="<?php echo $value['VisitDate'];?>" data-infotime="<?php echo $value['VisitTime'];?>" name="time_new" value="<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>">
                                                            <label class="" for="time_offline_<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>"><?php echo $value['VisitTime'];?></label>
                                                        </div><?php
                                                $lastdate = $value['VisitDate'];
                                            }

                                            elseif($lastdate == $value['VisitDate']){
                                                ?><div>
                                                    <input class="time_new" type="radio" id="time_offline_<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>" data-infodata="<?php echo $value['VisitDate'];?>" data-infotime="<?php echo $value['VisitTime'];?>" name="time_new" value="<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>">
                                                    <label class="" for="time_offline_<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>"><?php echo $value['VisitTime'];?></label>
                                                </div><?php
                                                $lastdate = $value['VisitDate'];
                                            }

                                            if($lastdate != $value['VisitDate']){
                                                $day++;
                                                date('d.m.Y', strtotime($value['VisitDate']));  
                                                if("ru" == $lang) {
                                                    $lngMonth = $monthesRu[(date('n', strtotime($value['VisitDate'])))];
                                                    $lngdays = $daysRuW[(date('w', strtotime($value['VisitDate'])))];
                                                }
                                                elseif("ro" == $lang) {
                                                    $lngMonth = $monthesRo[(date('n', strtotime($value['VisitDate'])))];
                                                    $lngdays = $daysRoW[(date('w', strtotime($value['VisitDate'])))];
                                                }
                                                else {
                                                    $lngMonth = date('M', strtotime($value['VisitDate'])); 
                                                    $lngdays = date('D', strtotime($value['VisitDate']));
                                                }

                                                ?>
                                                </div>
                                                </div>
                                                <div class="reservation-tab-colum">
                                                    <div class="reservation-tab-head">
                                                        <div>
                                                            <?php if($day == 1) echo "завтра,<br>".date('d', strtotime("+1 day"))." ".$lngMonth; else echo $lngdays.",<br>".date('d', strtotime($value['VisitDate']))." ".$lngMonth;?>
                                                        </div>
                                                    </div>
                                                    <div class="reservation-tab-body">
                                                        <div>
                                                            <input class="time_new" type="radio" id="time_offline_<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>" data-infodata="<?php echo $value['VisitDate'];?>" data-infotime="<?php echo $value['VisitTime'];?>" name="time_new" value="<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>">
                                                            <label class="" for="time_offline_<?php echo $value['VisitDate'];?>_<?php echo $value['VisitTime'];?>"><?php echo $value['VisitTime'];?></label>
                                                        </div><?php
                                                $lastdate = $value['VisitDate'];
                                            }
                                        }
                                        ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                
                                <div class="d-none" id="selectTime-error">
                                    <small class="error__desc"><?php echo dictionary('TIMENOTSELECTED');?></small>
                                </div>

                                <div class="mt-3">
                                    <button class="button btn-navigate-form-step btn" type="button" step_number="2"><?php echo dictionary('FORWARD');?></button>
                                </div>
                            </section>
                            <!-- Step 2 Content, default hidden on page load. -->
                            <section id="step-2" class="form-step d-none">
                                <h2 class="font-normal"><?php echo dictionary('PERSONALDATA');?></h2>
                                <div class="mt-3">
                                    <h3 style="font-size: 24px;font-weight: 400;line-height: 35px;text-align: center;margin: 15px 0 0;"><?php echo dictionary('YOUREQUESTEDAPPOINTMENT');?> <span id="infodata" style=" color: #4789c8; "></span> <?php echo dictionary('ON_THE');?> <span id="infotime" style=" color: #4789c8; "></span>. 
                                        <p><?php echo dictionary('DOCTORSELECTED');?>: <?php echo $get_doctor['title_'.$lang];?>, <?php echo dictionary('SELECT_KONSULTACII_DEPARTAMENT');?>: <?php echo  preview_text($get_doctor['text_2_'.$lang]).'<br/>';?></p>
                                    </h3>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="main-form__field">
                                                <label class="main-form__label" for="FirstAndLastName"><?php echo dictionary('PLACEHOLDER_INPUT_FIELD_FIO');?> <span>*</span></label>
                                                <input class="main-form__input" id="FirstAndLastName" name="FirstAndLastName" type="text" value="">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="main-form__field">
                                                <label class="main-form__label" for="Phone"><?php echo dictionary('PLACEHOLDER_INPUT_FIELD_PHONE_NUMBER');?> <span>*</span></label>
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
                                                <label class="main-form__label" for="Email"><?php echo dictionary('PLACEHOLDER_INPUT_FIELD_EMAIL');?> <span>*</span></label>
                                                <input class="main-form__input" id="Email" name="Email" type="text" value="" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="main-form__field">
                                        <div class="checkbox-label">
                                            <input class="checkbox-label__input" type="checkbox" name="Timereservation" id="Timereservation" value="true">
                                            <label class="checkbox-label__main" for="Timereservation"><?php echo dictionary('RESERVATION_TIME_OCCURS_ONLY_WHEN_PAYING_ONLINE');?></label>
                                        </div>
                                    </div>

                                </div>
                                <div class="mt-3">
                                    <button class="button btn-navigate-form-step btn" type="button" step_number="1"><?php echo dictionary('RETURN_BACK');?></button>
                                    <button class="button btn-navigate-form-step btn" type="button" step_number="3" disabled id="TimereservationSubmit"><?php echo dictionary('SUBMIT_APPLICATION');?></button>
                                    <button class="button btn-navigate-form-step btn" type="button" step_number="3" disabled id="TimereservationSubmitOnline"><?php echo dictionary('PAY_ONLINE');?></button>
                                </div>
                            </section>
                            <!-- Step 3 Content, default hidden on page load. -->
                            
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
                var buttonOffline = $(this).parents("form:first").find("#TimereservationSubmit");
                var buttonOnline = $(this).parents("form:first").find("#TimereservationSubmitOnline");
                if ($(this).is(":checked")) {
                    buttonOffline.removeClass("submit-inactive");
                    buttonOffline.prop("disabled", false);
                    buttonOnline.removeClass("submit-inactive");
                    buttonOnline.prop("disabled", false);
                } else {
                    buttonOffline.addClass("submit-inactive");
                    buttonOffline.prop("disabled", true);
                    buttonOnline.addClass("submit-inactive");
                    buttonOnline.prop("disabled", true);
                }
            });
    
    $('#offlineregistration').change(function() {
        if(this.checked) {
            $("#onlineTable").hide();
            $("#offlineTable").show();
            $("#SelectTime").val('');
            $("input[name='time_new']").each(function( index ) {
                $(this).parent().css('background-color', '#2880dd');
                $(this).parent().css('border-color', '#2880dd');
            });
        }      
    });

    $('#onlineregistration').change(function() {
        if(this.checked) {
            $("#onlineTable").show();
            $("#offlineTable").hide();
            $("#SelectTime").val('');
            $("input[name='time_new']").each(function( index ) {
                $(this).parent().css('background-color', '#2880dd');
                $(this).parent().css('border-color', '#2880dd');
            });
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
        $("#selectTime-error").hide();
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
                errorClass: "error__desc text-right",
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
            $("#selectTime-error").show();
            return;
        }else{
            $("#selectTime-error").hide();
        }

        if(stepNumber == 3 && !$("#userAccountSetupForm").valid()) {
            return;
        }
        if(stepNumber == 3 && $("#userAccountSetupForm").valid()){
            alert("Тут запрос к банку");
        }
        
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