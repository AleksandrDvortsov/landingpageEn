<!DOCTYPE html>
<html lang="<?php echo $Main->lang;?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/cp/css/img/favicon.png" type="image/x-icon"/>
    <title><?php echo $page_data['title'];?></title>

    <!-- Bootstrap Core CSS -->
    <link href="/cp/bootstrap/dist/css/bootstrap.min.css?v=<?php echo $css_version;?>" rel="stylesheet">
    <!-- bootstrap-datetimepicker css -->

    <link rel="stylesheet" href="/libraries/bootstrap_datetimepicker/css/bootstrap-datetimepicker.css?v=<?php echo $css_version;?>" />

    <!-- Menu CSS -->
    <link href="/cp/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css?v=<?php echo $css_version;?>" rel="stylesheet">
    <link href="/cp/plugins/bower_components/tablesaw-master/dist/tablesaw.css" rel="stylesheet">
    <!-- Dropzone css -->
    <link href="/cp/plugins/bower_components/dropzone-master/dist/dropzone.css?v=<?php echo $css_version;?>" rel="stylesheet" type="text/css" />
    <!-- toastr CSS -->
    <link href="/libraries/toastr/toastr.css" rel="stylesheet"/>
    <!-- animation CSS -->
    <link href="/cp/css/animate.css?v=<?php echo $css_version;?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/cp/css/style.css?v=<?php echo $css_version;?>" rel="stylesheet">
    <!-- color CSS -->
    <link href="/cp/css/colors/default.css?v=<?php echo $css_version;?>" id="theme" rel="stylesheet">
    <!-- adaptive table -->
    <link href="/cp/css/adaptive_table.css?v=<?php echo $css_version;?>" id="theme" rel="stylesheet">
</head>
<body>
<div class="popUpBackground" onclick="close_popUpGal()"></div>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <div class="top-left-part" style="text-align: center;">
                    <a class="logo" href="<?php echo $Cpu->getURL(1);?>"><b><!--This is dark logo icon-->
                            <img src="/cp/css/img/cp_logo.png" alt="home" class="light-logo"/>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li style="display:none;" class="right-side-toggle"> <a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
                    <li class="dropdown" style="width: 95px;">
                        <?php
                        $current_time =  new DateTime();
                        ?>
                        <a id="cp_clock" href="javascript:void(0)">
                            <?php echo $current_time->format("H:i:s");?>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
