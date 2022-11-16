<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
require_once( __DIR__ . "/../../settings.php");

if($User->check_cp_authorization())
{
    if($User->access_control($Form->page_access($page_data['id'])))
	{
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
                            <div class="label label-info label-rounded" style="float: right;">
                                <a style="color:white;font-size: 14px;" href="<?php echo $Cpu->getURL(84);?>">
                                    <?php echo dictionary('ADD');?>
                                </a>
                            </div>
                            <div style="clear:both; height: 25px;"></div>
                            <p class="text-muted"></p>

                            <div class="wrapper">
                                <div class="table_wrap">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><?php echo dictionary('TITLE');?></th>
                                            <th style="width: 100px;"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $get_table_info = $db
                                            ->orderBy('sort', 'desc')
                                            ->get($db_filter_options_table);
                                        foreach ($get_table_info as $table_info)
                                        {
                                            ?>
                                            <tr>
                                                <td data-label="<?php echo dictionary('TITLE');?>"><?php echo $table_info['title_'.$Main->lang];?></td>

                                                <td class="no_background">
                                                    <a href="<?php echo $Cpu->getURL(87);?>?section_id=<?php echo $table_info['id'] ?>">
                                                        <button class="view_button" type="button" title="View"></button>
                                                    </a>
                                                    <a href="<?php echo $Cpu->getURL(85);?>?section_id=<?php echo $table_info['id'] ?>">
                                                        <button class="edit_button" type="button" title="Edit"></button>
                                                    </a>
                                                    <a href="<?php echo $Cpu->getURL(86);?>?section_id=<?php echo $table_info['id'] ?>"
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


