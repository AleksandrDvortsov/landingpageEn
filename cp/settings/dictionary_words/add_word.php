<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';

if($User->check_cp_authorization()) {
    if($User->access_control($developer_access))
    {
        $status_info = array();

        if(isset($_POST['submit']))
        {
            $ar_post_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = array();
            $code = strtoupper($db->escape($ar_post_clean['code']));
            $data['code'] =  slugify_special($code);

            // Проверка на уникальности 'code'
            $db->where ("code", $data['code']);
            $check_code_info = $db->getOne ("dictionary");
            if($check_code_info)
            {
                $status_info['error'][] = $data['code'].' '.dictionary('CODE_ALREADY_EXISTS');;
            }
            else
            {
                foreach ($list_of_site_langs as $site_langs)
                {
                    $data['title_'.$site_langs] = $db->escape($ar_post_clean['title_'.$site_langs]);
                }
                $id = $db->insert ('dictionary', $data);
                if ($id)
                {
                    $status_info['success'][] = dictionary('SUCCESSFULLY_ADDED');
                }
                else
                {
                    $status_info['error'][] = $db->getLastError();
                }
            }
        }


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
                            <h3 class="page-title"><?php echo dictionary('ADD');?></h3>
                            <?php
                                show_status_info($status_info);
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="check_required_fields" class="form-material form-horizontal" method="post"
                                          action="">
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo dictionary('SECTION_DICTIONARY_CODE');?> <span class="red_star">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" name="code" class="form-control required">
                                            </div>
                                        </div>
                                        <div style="clear:both;height: 50px;"></div>

                                        <?php
                                        foreach ($list_of_site_langs as $site_langs) {
                                            ?>
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo dictionary('VALUE');?> <?php echo mb_ucfirst($site_langs); ?>
                                                     <span class="red_star">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" name="title_<?php echo $site_langs;?>"
                                                    class="form-control required" placeholder="">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
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
        exit();
    }
}
else
{
    header("location: ".$Cpu->getURL(5));
}