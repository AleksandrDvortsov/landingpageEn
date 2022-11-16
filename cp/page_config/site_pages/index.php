<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
require_once( __DIR__ . "/../settings.php");

if($User->check_cp_authorization())
{
    if($User->access_control($client_access)) {
        $ar_get_clean = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
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
                 <?php
                $totalObjects=0;
                $start=0;
                $perPage = $num_page;
                if(!isset($_GET['page']) || !is_numeric($_GET['page'])){$page = 1;}else{$page = (int)$_GET['page'];}


                if(!$User->access_control($developer_access))
                {
                    $get_totalObjects = $db
                        ->where("edit_by_user", 1)
                        ->where("type", 1)
                        ->orWhere("type", 7)
                        ->orderBy ("id","asc")
                        ->get("pages");
                }
                else
                {
                    $get_totalObjects = $db
                        ->where("type", 1)
                        ->orWhere("type", 7)
                        ->orderBy ("id","asc")
                        ->get("pages");
                }

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
                    <div class="col-lg-12">
                        <div class="white-box">
                            <form class="form-material form-horizontal">
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo dictionary('SEARCH');?></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" onkeyup="search_site_pages(this.value)"   value="">
                                    </div>
                                </div>
                            </form>

                            <?php
                            if($User->access_control($developer_access))
                            {
                                ?>
                                <div class="label label-info label-rounded" style="float: right;">
                                    <a style="color:white;font-size: 14px;" href="<?php echo $Cpu->getURL(45);?>">
                                        <?php echo dictionary('ADD');?>
                                    </a>
                                </div>
                                <div style="clear:both; height: 25px;"></div>
                            <?php
                            }
                            ?>
                            <div class="wrapper">
                                <div class="table_wrap">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><?php echo dictionary('ID');?></th>
                                            <th style="width: 30%;"><?php echo dictionary('CODE');?></th>
                                            <th><?php echo dictionary('DESCRIPTION');?></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(!$User->access_control($developer_access))
                                        {
                                            $get_site_pages = $db
                                                ->where("type", 1)
                                                ->orWhere("type", 7)
                                                ->where("edit_by_user", 1)
                                                ->orderBy ("id","asc")
                                                ->get("pages", Array ($start, $perPage));
                                        }
                                        else
                                        {
                                            $get_site_pages = $db
                                                ->where("type", 1)
                                                ->orWhere("type", 7)
                                                ->orderBy ("id","asc")
                                                ->get("pages", Array ($start, $perPage));
                                        }


                                        if (count($get_site_pages) > 0)
                                        {
                                            foreach ($get_site_pages as $site_pages)
                                            {
                                                $exploded_url = array_filter( explode("/", $site_pages['page']), 'strlen' );
                                                ?>
                                                <tr>
                                                    <td data-label="<?php echo dictionary('ID');?>"><?php echo $site_pages['id'];?></td>
                                                    <td data-label="<?php echo dictionary('CODE');?>">
                                                        <?php echo $site_pages['page'];?>
                                                    </td>
                                                    <td data-label="<?php echo dictionary('DESCRIPTION');?>"><?php echo $site_pages['title_'.$Main->lang];?></td>
                                                    <td class="no_background">
                                                        <a href="<?php echo $Cpu->getURL(46)?>?id=<?php echo $site_pages['id']?>">
                                                            <button class="edit_button" type="button" title="Edit"></button>
                                                        </a>
                                                        <?php
                                                        if( $exploded_url['1'] == 'text_page' || in_array('index.php', $exploded_url) && !empty($site_pages['dir_file_name']) )
                                                        {
                                                            ?>
                                                            <a href="<?php echo $Cpu->getURL(209)?>?id=<?php echo $site_pages['id']?>"
                                                               onclick="return confirm('<?php echo dictionary('CONFIRM_DELETE_PAGE');?>');">
                                                                <button class="delete_button" type="button" title="Delete"></button>
                                                            </a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
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
            function search_site_pages(search_value)
            {
                var data = {};
                data['task'] = 'search_site_pages';
                data['search_value'] = search_value.trim();

                $.ajax({
                    type: "POST",
                    url: "/cp_ajax_<?php echo $Main->lang;?>/",
                    data: data,
                    dataType: "html",
                    success: function (msg)
                    {
                        $("table.table").find("tbody").html(msg);
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


