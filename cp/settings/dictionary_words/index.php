<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
if($User->check_cp_authorization()) {


                            $totalObjects=0;
                            $start=0;
                            $perPage = 25;
                            if(!isset($_GET['page']) || !is_numeric($_GET['page'])){$page = 1;}else{$page = (int)$_GET['page'];}

                            if(!$User->access_control($developer_access))
                            {
                                $get_totalObjects = $db
                                    ->where("edit_by_user", 1)
                                    ->get("dictionary");
                            }
                            else
                            {
                                $get_totalObjects = $db
                                    ->get("dictionary");
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


        if(!$User->access_control($developer_access))
        {
            $get_settings_code = $db
                ->where("edit_by_user", 1)
                ->get("dictionary", Array($start, $perPage));
        }
        else
        {
            $get_settings_code = $db
                ->get("dictionary", Array($start, $perPage));
        }


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
                                        <input type="text" class="form-control form-control-line"  onkeyup="search_dictionary_word(this.value)" value="">
                                    </div>
                                </div>

                            </form>


							<div style="clear:both; width: 100%; margin-bottom: 30px;"></div>

                            <?php
                            if($User->access_control($developer_access))
                            {
                                ?>
                                <div class="label label-info label-rounded" style="float: right;">
                                    <a style="color:white;font-size: 14px;" href="<?php echo $Cpu->getURL(26);?>"><?php echo dictionary('ADD');?></a>
                                </div>
                                <?php
                            }
                            ?>
                            <div style="clear:both; height: 25px;"></div>
                            <p class="text-muted"><?php echo dictionary('CLICK_WORD_CHANGE_ENTER');?></p>
                            <div class="wrapper">
                                <div class="table_wrap">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><?php echo dictionary('CODE');?></th>
                                            <th><?php echo dictionary('LANG');?></th>
                                            <th><?php echo dictionary('DESCRIPTION');?></th>
                                            <?php
                                            if($User->access_control($developer_access))
                                            {
                                                ?>
                                                <th></th>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($get_settings_code as $setting_code)
                                        {
                                            ?>
                                            <tr>
                                                <td data-label="<?php echo dictionary('CODE');?>">
                                                    <?php echo $setting_code['code'];?>
                                                </td>
                                                <td data-label="<?php echo dictionary('LANG');?>">
                                                    <?php
                                                    foreach ( $list_of_site_langs as $site_langs)
                                                    {
                                                        echo mb_ucfirst($site_langs) . ': <br>';
                                                    }
                                                    ?>
                                                </td>
                                                <td data-label="<?php echo dictionary('DESCRIPTION');?>">
                                                    <?php
                                                    foreach ( $list_of_site_langs as $site_langs)
                                                    {
                                                        ?>
                                                        <input class="input_focusof" type="text"
                                                               data-language = "<?php echo $site_langs;?>"
                                                               value="<?php echo $setting_code['title_'.$site_langs];?>"
                                                               onchange="change_dictionary_input_value('<?php echo $setting_code['id']; ?>',$(this).data('language'),$(this).val());"
                                                               onpaste="this.onchange();">
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                                if($User->access_control($developer_access))
                                                {
                                                    ?>
                                                    <td class="no_background">
                                                        <a href="<?php echo $Cpu->getURL(27);?>?id=<?php echo $setting_code['id'] ?>"
                                                           onclick="return confirm('<?php echo dictionary('CONFIRM_DELETE_ELEMENT');?>');">
                                                            <button class="delete_button" type="button"
                                                                    title="Delete"></button>
                                                        </a>
                                                    </td>
                                                    <?php
                                                }
                                                ?>
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
            function search_dictionary_word(search_value)
            {
                var data = {};
                data['task'] = 'search_dictionary_word';
                data['search_value'] = search_value.trim();

                console.log(data);
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
    header("location: ".$Cpu->getURL(5));
}