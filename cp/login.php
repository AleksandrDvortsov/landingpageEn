<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';

if($User->check_cp_authorization())
{
    header("location: ".$Cpu->getURL(1));
}

$errors = array();
if(isset($_POST['log_in']))
{
    $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    if ( $User->cp_check_and_login($ar_post_clean['username'],$ar_post_clean['password'],$ar_post_clean['keystring'],$ar_post_clean['token']) )
    {
        exit();
    }
    else
    {
        $errors = $User->showErrors();
    }
}
?>
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
<link href="/cp/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="/cp/css/style.css" rel="stylesheet">
</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<?php
$login_background_image = "/cp/plugins/images/login-register.jpg";

$get_background_image_name = $db
    ->where('code', 'BACKGROUND_IMAGE')
    ->getOne("settings");
if($get_background_image_name)
{
    $thumb_image = @newthumbs($get_background_image_name['value'], 'settings');
    if($thumb_image)
    {
        $login_background_image = $thumb_image;
    }
}

?>
<section id="wrapper" class="login-register" style="background: url(<?php echo $login_background_image;?>) center center/cover no-repeat!important;">
  <div class="login-box login-sidebar" style="width: 300px;">
    <div class="white-box">
      <form class="form-horizontal form-material" id="loginform" action="" method="post">
        <a href="javascript:void(0)" class="text-center db">
            <img src="/cp/css/img/cp_logo.png" alt="Home" />
        </a>
        <div class="form-group m-t-40">
          <div class="col-xs-12">
            <input class="form-control" name="username" type="text" required="" placeholder="<?php echo dictionary('USERNAME');?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control" name="password" type="password" required="" placeholder="<?php echo dictionary('PASSWORD');?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12" style="text-align: center;">
              <?php require_once $_SERVER['DOCUMENT_ROOT'].'/libraries/captcha/index.php';?>
              <img id="captcha_code" src="<?php echo $_SESSION['captcha']['image_src']?>">
              <div id="refresh_button">
                  <img onclick="refreshCaptcha()" src="/cp/css/img/refresh_b1.png" style="cursor:pointer;" />
              </div>
              <input class="form-control" type="text" id="key" name="keystring" autocomplete="off" required="" placeholder="<?php echo dictionary('ENTER_CAPTCHA');?>">
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <input type="hidden" name="token" value="<?php echo $User->generate_token();?>">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"  value="submit" name="log_in" type="submit"><?php echo dictionary('LOG_IN');?></button>
          </div>
        </div>
      </form>
        <?php
        foreach($errors as $error)
        {
            echo "<div style='color: red;font-size: 11px;'>*".$error."</div>";
        }
        ?>
    </div>
  </div>
</section>
<!-- jQuery -->
<script src="/cp/plugins/bower_components/jquery/dist/jquery.min.js"></script>

<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/cp/js/scripts.php';
?>

</body>
</html>
