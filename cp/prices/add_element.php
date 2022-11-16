<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
require_once 'settings.php';

if($User->check_cp_authorization())
{
    if($User->access_control($Form->page_access($page_data['id'])))
    {
        $status_info = array();
        if(isset($_POST['submit']))
        {
            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            //show($ar_post_clean);
            $sort = $db->escape($ar_post_clean['sort']);

            $data_list = Array (
                    'cat_id' => (int)$ar_post_clean['cat_id'],
                    'price' => (float)$ar_post_clean['price'],
                    "sort"  => $sort
            );

            foreach ($list_of_site_langs as $site_langs)
            {
                $data_list['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
            }

            $inserted_id_result = $db->insert ($db_table, $data_list);
            if ($inserted_id_result)
            {
                $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');
            }
            else
            {
                $status_info['error'][] = $db->getLastError();
            }

        }
        ?>

        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/header.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/left-sidebar.php';
        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <?php $Cpu->top_block_info($cutpageinfo);?>
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <?php
                            show_status_info($status_info);
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="check_required_fields" class="form-material form-horizontal" method="post" action="" enctype="multipart/form-data">
                                        <div id="item_description">
                                            <ul class="tabs tabs1">
                                                <li class="t1 tab-current"><a><?php echo dictionary('COMMON_DATA');?></a></li>
                                                <?php
                                                $cur_tab = 2;
                                                foreach( $list_of_site_langs as $tab_name )
                                                {
                                                    ?>
                                                    <li class="t<?php echo $cur_tab?>"><a><?php echo mb_ucfirst($tab_name)?></a></li>
                                                    <?php
                                                    $cur_tab++;
                                                }
                                                ?>
                                            </ul>
                                            <!-- Первая вкладка -->
                                            <div class="t1 tab_content" style="display: block;">
                                                <div class="sp_tab_indent"></div>
                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo dictionary('TYPE');?> </label>
                                                    <div class="col-md-12">
                                                        <select class="form-control" name="cat_id">
                                                            <?php
                                                            $get_category_section_data_info = $db
                                                                ->where('active', 1)
                                                                ->orderBy('sort', 'asc')
                                                                ->get('categories_prices');
                                                            if($get_category_section_data_info && count($get_category_section_data_info) > 0)
                                                            {
                                                                foreach ($get_category_section_data_info as $category_section_data_info)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $category_section_data_info['id'];?>">
                                                                        <?php echo $category_section_data_info['title_'.$lang];?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo dictionary('PRICE');?>
                                                        <span style="color: red;">*</span>
                                                    </label>
                                                    <div class="col-md-12">
                                                        <input type="number" name="price" value="0" min="0" class="form-control required">
                                                    </div>
                                                </div>

                                                <?php
                                                    $Form->add_sort('sort');
                                                ?>
                                            </div>

                                            <?php
                                            $c_tab = 2;
                                            foreach( $list_of_site_langs as $lang_index )
                                            {
                                                ?>
                                                <div class="t<?php echo $c_tab++?> tab_content">
                                                    <div class="sp_tab_indent"></div>
                                                    <?php
                                                    $Form->add_title('title_'.$lang_index, 1);
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <button style="float:right;" type="submit" name="submit"
                                                class="btn btn-success waves-effect waves-light m-r-10"><?php echo dictionary('SUBMIT');?>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/right-sidebar.php'; ?>
            </div>
            <!-- /.container-fluid -->
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/cp/php/templates/footer.php'; ?>
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