<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
if($User->check_cp_authorization())
{
    if($User->access_control($client_access)) {
        $status_info = array();

        include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/header.php';
        include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/left-sidebar.php';
        ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <?php $Cpu->top_block_info($cutpageinfo);?>
                <!-- /row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <form class="form-material form-horizontal">
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo dictionary('SEARCH');?></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line"  onkeyup="search_user(this.value)"   value="">
                                    </div>
                                </div>
                            </form>

                            <div class="label label-info label-rounded" style="float: right;">
                                <a style="color:white;font-size: 14px;" href="<?php echo $Cpu->getURL(34);?>">
                                    <?php echo dictionary('ADD');?>
                                </a>
                            </div>
                            <div style="clear:both; height: 25px;"></div>
                            <p class="text-muted"></p>
                             <?php
                            $totalObjects=0;
                            $start=0;
                            $perPage = 25;
                            if(!isset($_GET['page']) || !is_numeric($_GET['page'])){$page = 1;}else{$page = (int)$_GET['page'];}


                            $get_totalObjects = $db
                                ->get('cp_users');


                            if(count($get_totalObjects)>0)
                            {
                                $totalObjects = count($get_totalObjects);
                            }

                            $Count = $totalObjects;
                            $Pages = ceil($Count/$perPage); if($page>$Pages){$page = $Pages;}
                            $start = $page * $perPage - $perPage;
                            if($start<0) {$start = 0;}

                            //echo "start: ".$start;
                            ?>

                            <div class="wrapper">
                                <div class="table_wrap">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><?php echo dictionary('USER_LOGIN');?></th>
                                            <th><?php echo dictionary('USER_STATUS_ON_SITE');?></th>
                                            <th style="width: 30%;"><?php echo dictionary('IMAGE');?></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $users_list = $db
                                            ->get("cp_users",Array ($start, $perPage));
                                        foreach ($users_list as $user)
                                        {
                                            $user_status = $User->getCpUserStatus($user['id']);
                                            ?>
                                            <tr <?php if($user['active'] == 0) { ?>style="background: #cfd6de;" <?php } ?>>
                                                <td data-label="<?php echo dictionary('USER_LOGIN');?>"><?php echo $user['login'];?></td>
                                                <td data-label="<?php echo dictionary('USER_STATUS_ON_SITE');?>"><?php echo $user_status['title_'.$Main->lang];?></td>
                                                <td data-label="<?php echo dictionary('IMAGE');?>">
                                                    <?php
                                                    $image_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/cp_user_photo/' . $user['image'];
                                                    if (isset($user['image']) && $user['image'] != "" && is_file($image_path)) {
                                                        $imagethumg = newthumbs($user['image'], 'cp_user_photo', 50, 50, 6, 1);
                                                        ?>
                                                        <div class="col-md-12" style="text-align: center;">
                                                            <img style="max-width: 50px; max-height: 50px;" src="<?php echo $imagethumg; ?>">
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="no_background">
                                                    <?php
                                                    if($User->access_control(array(1)))
                                                    {
                                                        ?>
                                                        <a href="<?php echo $Cpu->getURL(35);?>?id=<?php echo $user['id'] ?>">
                                                            <button class="edit_button" type="button" title="Edit"></button>
                                                        </a>
                                                        <?php
                                                    }
                                                    else
                                                        if($User->access_control(array(2)))
                                                        {
                                                            // la client scoatem posibilitatea de redactare a developelor
                                                            $loop_user_info = $User->getUser($user['id']);
                                                            if( $loop_user_info['usergroup'] != 1 )
                                                            {
                                                                ?>
                                                                <a href="<?php echo $Cpu->getURL(35);?>?id=<?php echo $user['id'] ?>">
                                                                    <button class="edit_button" type="button" title="Edit"></button>
                                                                </a>
                                                                <?php
                                                            }
                                                        }
                                                    ?>


                                                    <?php
                                                    /*
                                                    <a href="<?php echo $Cpu->getURL(36);?>?id=<?php echo $user['id'] ?>"
                                                       onclick="return confirm('<?php echo dictionary('CONFIRM_DELETE_ELEMENT');?>');">
                                                        <button class="delete_button" type="button"
                                                                title="Delete"></button>
                                                    </a>
                                                    */
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/include/pagination.php'; ?>

                <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/right-sidebar.php'; ?>
            </div>
            <!-- /.container-fluid -->
            <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/footer.php'; ?>
        </div>
        <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        </body>
        <script>
            function search_user(search_value)
            {
                var data = {};
                data['task'] = 'search_user';
                data['search_value'] = search_value.trim();

                $.ajax({
                    type: "POST",
                    url: "/cp_ajax_<?php echo $Main->lang;?>/",
                    data: data,
                    dataType: "html",
                    success: function (msg)
                    {
                        $("table.table-bordered").find("tbody").html(msg);
                        $('.nav-pagination').css("display","none");
                    }
                });
            }
        </script>
        </html>
        <?php
    }
    else
    {
        include_once $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/not_authorized_to_view_page.php';
    }
}
else
{
    header("location: ".$Cpu->getURL(5));
}

?>


