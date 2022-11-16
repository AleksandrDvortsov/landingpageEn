<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
require_once 'settings.php';
if($User->check_cp_authorization())
{
    if($User->access_control($Form->page_access($page_data['id']))) {
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
                    <div class="col-lg-12">
                        <div class="white-box">
                            <div style="clear:both; height: 25px;"></div>
                            <p class="text-muted"></p>
                            <?php
                            $totalObjects=0;
                            $start=0;
                            $perPage = $num_page;
                            if(!isset($_GET['page']) || !is_numeric($_GET['page'])){$page = 1;}else{$page = (int)$_GET['page'];}


                            $get_totalObjects = $db
                                ->get($db_table);


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
                                            <th><?php echo dictionary('ADDED_DATE');?></th>
                                            <th><?php echo dictionary('FIO');?></th>
                                            <th><?php echo dictionary('EMAIL');?></th>
                                            <th><?php echo dictionary('CP_SUBJECT');?></th>
                                            <th><?php echo dictionary('CP_QUESTION');?></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $get_table_info = $db
                                            ->orderBy("id", "desc")
                                            ->get($db_table,Array ($start, $perPage));
                                        foreach ($get_table_info as $table_info)
                                        {
                                            ?>
                                            <tr>
                                                <td data-label="<?php echo dictionary('ADDED_DATE');?>"><?php echo $table_info['created_at'];?></td>
                                                <td data-label="<?php echo dictionary('FIO');?>"><?php echo $table_info['fio'];?></td>
                                                <td data-label="<?php echo dictionary('EMAIL');?>"><?php echo $table_info['email'];?></td>
                                                <td data-label="<?php echo dictionary('CP_SUBJECT');?>"><?php echo $table_info['subject'];?></td>
                                                <td data-label="<?php echo dictionary('CP_QUESTION');?>"><?php echo $table_info['question'];?></td>


                                                <td class="no_background">
                                                    <?php /*
                                                    <a href="<?php echo $Cpu->getURL($EDIT_ELEMENT_PAGE_ID);?>?id=<?php echo $table_info['id'] ?>">
                                                        <button class="view_button" type="button" title="Edit"></button>
                                                    </a>
                                                    */ ?>
                                                    <a href="<?php echo $Cpu->getURL($DELETE_ELEMENT_PAGE_ID);?>?id=<?php echo $table_info['id'] ?>"
                                                       onclick="return confirm('<?php echo dictionary('CONFIRM_DELETE_ELEMENT');?>');">
                                                        <button class="delete_button" type="button"
                                                                title="Delete"></button>
                                                    </a>
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


