<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cp/class/include.php';
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
                    <div class="col-lg-12">
                        <div class="white-box">
                            <div style="clear:both; height: 25px;"></div>
                            <p class="text-muted"></p>
                            <div class="wrapper">
                                <div class="table_wrap">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th style="width: 30%;"><?php echo dictionary('ID');?></th>
                                            <th><?php echo dictionary('TITLE');?></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $get_tabel_list_info = $db
                                            ->where('type', 7)
                                            ->get("pages");
                                        foreach ($get_tabel_list_info as $tabel_list_info)
                                        {
                                            ?>
                                            <tr>
                                                <td data-label="<?php echo dictionary('ID');?>"><?php echo $tabel_list_info['id'];?></td>
                                                <td data-label="<?php echo dictionary('TITLE');?>"><?php echo $tabel_list_info['title_'.$Main->lang];?></td>

                                                <td class="no_background">
                                                    <a href="<?php echo $Cpu->getURL(233);?>?id=<?php echo $tabel_list_info['id'] ?>">
                                                        <button class="edit_button" type="button" title="Edit"></button>
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


