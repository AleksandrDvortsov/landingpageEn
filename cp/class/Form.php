<?php

class Form
{

    private $_db;
    private $_Cpu;
    private $_lang;
    private $_errors;

    public function __construct()
    {
        global $db,$Cpu, $lang;
        $this->_db = $db;
        $this->_Cpu = $Cpu;
        $this->_lang = $lang;
        $this->_errors = array();
    }


    // standart methods //
    public function add_active($db_field_name)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo dictionary('ACTIVE');?></label>
            <div class="col-md-12">
                <input type="checkbox" name="<?php echo $db_field_name;?>" checked
                       class="form-control" placeholder="" style="float: left; width: 50px;">
            </div>
        </div>
        <?php
    }

    public function edit_active($value, $db_field_name)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo dictionary('ACTIVE');?></label>
            <div class="col-md-12">
                <input type="checkbox" name="<?php echo $db_field_name;?>"
                    <?php if($value == 1) { ?> checked <?php } ?>
                       class="form-control" placeholder="" style="float: left; width: 50px;">
            </div>
        </div>
        <?php
    }

    public function add_datetimepicker($db_field_name, $required = 0, $form_label_title = '')
    {
        ?>
        <div class="form-group datetimepicker_block">
            <label class="col-md-12">
                <?php
                if(empty($form_label_title))
                {
                    $form_label_title = dictionary('ADDED_DATE');
                }

                echo $form_label_title;

                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class='input-group date datetimepicker_default'>
                <input type='text' name="<?php echo $db_field_name;?>" class="form-control <?php if($required == 1) { ?> required <?php } ?>" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <?php
    }

    public function edit_datetimepicker($value = "", $db_field_name, $required = 0, $form_label_title = '')
    {
        // Atentie la id-blocului, el este dinamic din cauza tipului de lucru a bibliotecii datetimepicker
        $date_time_uniq_id = uniqid("datetimepicker_");
        ?>
        <div class="form-group datetimepicker_block">
            <label class="col-md-12">
                <?php
                if(empty($form_label_title))
                {
                    $form_label_title = dictionary('ADDED_DATE');
                }

                echo $form_label_title;

                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class='input-group date' id='<?php echo $date_time_uniq_id;?>'>
                <input type='text' name="<?php echo $db_field_name;?>" class="form-control <?php if($required == 1) { ?> required <?php } ?>" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', function() {
                (function($) {
                    $(document).ready(function() {
                        $('#<?php echo $date_time_uniq_id;?>').datetimepicker({
                            locale: 'ru',
                            defaultDate: "<?php echo $value;?>"
                        });
                    });
                })(jQuery);
            });
        </script>
        <?php
    }


    public function add_timepicker($db_field_name, $required = 0, $form_label_title = '')
    {
        ?>
        <div class="form-group datetimepicker_block">
            <label class="col-md-12">
                <?php
                if(empty($form_label_title))
                {
                    $form_label_title = dictionary('TIME');
                }

                echo $form_label_title;

                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class='input-group date timepicker'>
                <input type='text' name="<?php echo $db_field_name;?>" class="form-control <?php if($required == 1) { ?> required <?php } ?>" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
        <?php
    }

    public function edit_timepicker($value = "", $db_field_name, $required = 0, $form_label_title = '')
    {
        $conver_time_without_seconds = new DateTime($value);
        $value = $conver_time_without_seconds->format("H:i");

        // Atentie la id-blocului, el este dinamic din cauza tipului de lucru a bibliotecii datetimepicker
        $date_time_uniq_id = uniqid("datetimepicker_");
        ?>
        <div class="form-group datetimepicker_block">
            <label class="col-md-12">
                <?php
                if(empty($form_label_title))
                {
                    $form_label_title = dictionary('TIME');
                }

                echo $form_label_title;

                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class='input-group date' id='<?php echo $date_time_uniq_id;?>'>
                <input type='text' name="<?php echo $db_field_name;?>" class="form-control <?php if($required == 1) { ?> required <?php } ?>" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', function() {
                (function($) {
                    $(document).ready(function() {
                        $('#<?php echo $date_time_uniq_id;?>').datetimepicker({
                            locale: 'ru',
                            format: 'LT'
                        });
                        $('#<?php echo $date_time_uniq_id;?> input').val("<?php echo $value;?>");
                    });
                })(jQuery);
            });
        </script>
        <?php
    }


    public function add_datepicker($db_field_name, $required = 0, $form_label_title = '')
    {
        ?>
        <div class="form-group datetimepicker_block">
            <label class="col-md-12">
                <?php
                if(empty($form_label_title))
                {
                    $form_label_title = dictionary('ADDED_DATE');
                }

                echo $form_label_title;

                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class='input-group date datetimepicker_only_date'>
                <input type='text' name="<?php echo $db_field_name;?>" class="form-control <?php if($required == 1) { ?> required <?php } ?>" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
        <?php
    }

    public function edit_datepicker($value = "", $db_field_name, $required = 0, $form_label_title = '')
    {
        $conver_date_withous_time = new DateTime($value);
        $value = $conver_date_withous_time->format("d.m.Y");

        // Atentie la id-blocului, el este dinamic din cauza tipului de lucru a bibliotecii datetimepicker
        $date_time_uniq_id = uniqid("datetimepicker_");
        ?>
        <div class="form-group datetimepicker_block">
            <label class="col-md-12">
                <?php
                if(empty($form_label_title))
                {
                    $form_label_title = dictionary('ADDED_DATE');
                }

                echo $form_label_title;

                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class='input-group date' id='<?php echo $date_time_uniq_id;?>'>
                <input type='text' name="<?php echo $db_field_name;?>" class="form-control <?php if($required == 1) { ?> required <?php } ?>" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', function() {
                (function($) {
                    $(document).ready(function() {
                        $('#<?php echo $date_time_uniq_id;?>').datetimepicker({
                            locale: 'ru',
                            format: 'DD.MM.YYYY'
                        });
                        $('#<?php echo $date_time_uniq_id;?> input').val("<?php echo $value;?>");
                    });
                })(jQuery);
            });
        </script>
        <?php
    }





    public function add_image($db_field_name, $required = 0, $form_label_title = "")
    {
        if(empty($form_label_title))
        {
            $form_label_title = dictionary('IMAGE');
        }
        ?>
        <div class="form-group">
            <label class="col-sm-12"><?php echo $form_label_title; ?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-sm-12">
                <div class="fileinput fileinput-new input-group"
                     data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">Select file</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" <?php if($required == 1) { ?> class="required" <?php } ?> name="<?php echo $db_field_name;?>" accept="image/x-png,image/gif,image/jpeg">
                    </span>
                    <a href="#"
                       class="input-group-addon btn btn-default fileinput-exists"
                       data-dismiss="fileinput">Remove</a>
                </div>
            </div>
        </div>
        <?php
    }

    //----------------------------------------------------------------------------------------------------------------//
    //insert images post info
    function post_insert_simple_image($db_catalog_table, $db_field_name, $post_files)
    {
        $uploaded_images_info = array();

        if($this->check_image_error($post_files[$db_field_name]['error']))
        {
            if (isset($post_files[$db_field_name]['tmp_name']) && $post_files[$db_field_name]['tmp_name'] != '')
            {
                $uploaded_images_info = $this->post_add_image($db_catalog_table,$post_files, $db_field_name);
            }
            else
            {
                $uploaded_images_info[$db_field_name] = '';
            }
        }
        else
        {
            $uploaded_images_info[$db_field_name] = '';
        }

        return $uploaded_images_info[$db_field_name];
    }
    //----------------------------------------------------------------------------------------------------------------//

    public function edit_image($value, $db_table, $db_field_name, $required = 0, $form_label_title = "")
    {
        if(empty($form_label_title))
        {
            $form_label_title = dictionary('IMAGE');
        }
        ?>
        <div class="form-group">
            <label class="col-sm-12"><?php echo $form_label_title; ?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <?php
            $image_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'.$db_table.'/' . $value;
            if (isset($value) && $value != "" && is_file($image_path)) {
                $imagethumg = $this-> newthumbs($value, $db_table, 200, 200, 2, 0);
                ?>
                <div class="col-md-12" style="text-align: center;">
                    <img style="max-width: 200px; max-height: 200px; background: #eaeaea;" src="<?php echo $imagethumg; ?>">
                </div>
                <?php
            }
            ?>
            <div class="col-sm-12">
                <div class="fileinput fileinput-new input-group"
                     data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                                                        <span class="fileinput-new">Select file</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="hidden" name="old_<?php echo $db_field_name;?>"
                                                               value="<?php echo $value; ?>">
                        <?php
                        if ( isset($value) && $value!="" && is_file($image_path) ) {
                            ?>
                            <input type="file" name="<?php echo $db_field_name;?>" accept="image/x-png,image/gif,image/jpeg">
                            <?php
                        } else {
                            ?>
                            <input type="file" class="<?php if($required == 1) { ?> required <?php } ?>" name="<?php echo $db_field_name;?>" accept="image/x-png,image/gif,image/jpeg">
                            <?php
                        }
                        ?>
                                                    </span>
                    <a href="#"
                       class="input-group-addon btn btn-default fileinput-exists"
                       data-dismiss="fileinput">Remove</a>
                </div>
            </div>

        </div>
        <?php
    }

    //----------------------------------------------------------------------------------------------------------------//


    public function add_pdf($db_field_name, $required = 0, $form_label_title = "")
    {
        if(empty($form_label_title))
        {
            $form_label_title = dictionary('PDF');
        }
        ?>
        <div class="form-group">
            <label class="col-sm-12"><?php echo $form_label_title; ?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-sm-12">
                <div class="fileinput fileinput-new input-group"
                     data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">Select file</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" <?php if($required == 1) { ?> class="required" <?php } ?> name="<?php echo $db_field_name;?>" accept="application/pdf">
                    </span>
                    <a href="#"
                       class="input-group-addon btn btn-default fileinput-exists"
                       data-dismiss="fileinput">Remove</a>
                </div>
            </div>
        </div>
        <?php
    }
    //================================================================================================================//
    public function edit_pdf($value, $db_table, $db_field_name, $required = 0, $form_label_title = "")
    {
        if(empty($form_label_title))
        {
            $form_label_title = dictionary('PDF');
        }
        ?>
        <div class="form-group">
            <?php
            $image_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'.$db_table.'/' . $value;
            $image_path_for_href = '/uploads/'.$db_table.'/' . $value;
            if (isset($value) && $value != "" && is_file($image_path)) {
                ?>
                <div class="col-md-12" style="text-align: left; margin-bottom: 25px;">
                    <a href="<?php echo $image_path_for_href;?>" target="_blank">
                        <?php echo dictionary('FRONT_DOWNLOAD_PDF_PRESENTATION');?>
                    </a>

                </div>
                <?php
            }
            ?>

            <label class="col-sm-12"><?php echo $form_label_title; ?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>

            <div class="col-sm-12">
                <div class="fileinput fileinput-new input-group"
                     data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                                                        <span class="fileinput-new">Select file</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="hidden" name="old_<?php echo $db_field_name;?>"
                                                               value="<?php echo $value; ?>">
                        <?php
                        if ( isset($value) && $value!="" && is_file($image_path) ) {
                            ?>
                            <input type="file" name="<?php echo $db_field_name;?>" accept="application/pdf">
                            <?php
                        } else {
                            ?>
                            <input type="file" class="<?php if($required == 1) { ?> required <?php } ?>" name="<?php echo $db_field_name;?>" accept="application/pdf">
                            <?php
                        }
                        ?>
                                                    </span>
                    <a href="#"
                       class="input-group-addon btn btn-default fileinput-exists"
                       data-dismiss="fileinput">Remove</a>
                </div>
            </div>

        </div>
        <?php
    }


    function check_image_error($file_error_status)
    {
        if($file_error_status != 0 )
        {
            if($file_error_status == 1 )
            {
                ?>
                <script type="text/javascript">
                    alert('The uploaded file exceeds the upload_max_filesize directive in php.ini')
                </script>
                <?php

            }
            else
                if($file_error_status == 2 )
                {
                    ?>
                    <script type="text/javascript">
                        alert('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.')
                    </script>
                    <?php
                }
                else
                    if($file_error_status == 3 )
                    {
                        ?>
                        <script type="text/javascript">
                            alert('The uploaded file was only partially uploaded.')
                        </script>
                        <?php
                    }

            return false;
        }
        else
        {
            return true;
        }
    }

    //----------------------------------------------------------------------------------------------------------------//
    //update images post info
    function post_edit_simple_image($db_catalog_table, $db_field_name, $old_image = "", $post_files)
    {
        $uploaded_images_info = array();

        if($this->check_image_error($post_files[$db_field_name]['error']))
        {
            if (isset($post_files[$db_field_name]['tmp_name']) && $post_files[$db_field_name]['tmp_name'] != '')
            {
                $uploaded_images_info = $this->post_add_image($db_catalog_table,$post_files, $db_field_name);
                if(count($uploaded_images_info) == 0)
                {
                    //  $status_info['error'][] = dictionary('ERROR_LOADING_IMAGE');
                    show(dictionary('ERROR_LOADING_IMAGE'));
                }
                //remove all old images
                if(!remove_image($db_catalog_table, $old_image ))
                {
                    // $status_info['error'][] = dictionary('COULD_NOT_DELETE_OLD_IMAGES');
                    show(dictionary('COULD_NOT_DELETE_OLD_IMAGES'));
                }
            }
            else
            {
                $uploaded_images_info[$db_field_name] = $old_image;
            }
        }
        else
        {
            $uploaded_images_info[$db_field_name] = $old_image;
        }

        return $uploaded_images_info[$db_field_name];
    }
    //----------------------------------------------------------------------------------------------------------------//







    //----------------------------------------------------------------------------------------------------------------//
    //insert images post info
    function post_insert_simple_file($db_catalog_table, $db_field_name, $post_files)
    {
        $uploaded_images_info = array();

        if($this->check_image_error($post_files[$db_field_name]['error']))
        {
            if (isset($post_files[$db_field_name]['tmp_name']) && $post_files[$db_field_name]['tmp_name'] != '')
            {
                $uploaded_images_info = $this->post_add_file($db_catalog_table,$post_files, $db_field_name);
            }
            else
            {
                $uploaded_images_info[$db_field_name] = '';
            }
        }
        else
        {
            $uploaded_images_info[$db_field_name] = '';
        }

        return $uploaded_images_info[$db_field_name];
    }
    //----------------------------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------------------------//
    //update file post info
    function post_edit_simple_file($db_catalog_table, $db_field_name, $old_image = "", $post_files)
    {
        $uploaded_images_info = array();

        if (isset($post_files[$db_field_name]['tmp_name']) && $post_files[$db_field_name]['tmp_name'] != '')
        {
            $uploaded_images_info = $this->post_add_file($db_catalog_table,$post_files, $db_field_name);
            if(count($uploaded_images_info) == 0)
            {
                //  $status_info['error'][] = dictionary('ERROR_LOADING_IMAGE');
                show(dictionary('ERROR_LOADING_IMAGE'));
            }

            //remove all old images
            if(!remove_image($db_catalog_table, $old_image ))
            {
                // $status_info['error'][] = dictionary('COULD_NOT_DELETE_OLD_IMAGES');
                show(dictionary('COULD_NOT_DELETE_OLD_IMAGES'));
            }

        }
        else
        {
            $uploaded_images_info[$db_field_name] = $old_image;
        }


        return $uploaded_images_info[$db_field_name];

    }
    //----------------------------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------------------------//

    public function add_sort($db_field_name, $required = 0)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo dictionary('SORT');?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <input type="number" name="<?php echo $db_field_name;?>" value="0"
                       class="form-control <?php if($required == 1) { ?> required <?php } ?>" placeholder="">
            </div>
        </div>
        <?php
    }

    public function edit_sort($value, $db_field_name, $required = 0)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo dictionary('SORT');?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <input type="number" name="<?php echo $db_field_name;?>" value="<?php echo $value;?>"
                       class="form-control <?php if($required == 1) { ?> required <?php } ?>" placeholder="">
            </div>
        </div>
        <?php
    }

    public function add_title($db_field_name, $required = 0, $form_label_title = "")
    {
        if(empty($form_label_title))
        {
            $form_label_title = dictionary('TITLE');
        }
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo $form_label_title;?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <input type="text" name="<?php echo $db_field_name;?>" value=""
                       class="form-control <?php if($required == 1) { ?> required <?php } ?>" placeholder="">
            </div>
        </div>
        <?php
    }

    public function edit_title($value, $db_field_name, $required = 0, $form_label_title = "")
    {
        if(empty($form_label_title))
        {
            $form_label_title = dictionary('TITLE');
        }
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo $form_label_title;?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <input type="text" name="<?php echo $db_field_name;?>" value="<?php echo $value;?>"
                       class="form-control <?php if($required == 1) { ?> required <?php } ?>" placeholder="">
            </div>
        </div>
        <?php
    }

    public function show_field($value, $form_label_title, $href = false)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12">
                <?php echo $form_label_title;?>
            </label>
            <div class="col-md-12 sp_form_request_color">
                <?php
                if($href == false)
                {
                    echo $value;
                }
                else
                {
                    ?>
                    <a target="_blank" href="<?php echo $value;?>"><?php echo $value;?></a>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }

    public function add_cpu($db_field_name, $required = 0)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo dictionary('CPU');?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <input type="text" name="<?php echo $db_field_name;?>" value=""
                       class="form-control <?php if($required == 1) { ?> required <?php } ?>" placeholder="">
            </div>
        </div>
        <?php
    }

    public function edit_cpu($value, $db_field_name, $required = 0)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo dictionary('CPU');?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <input type="text" name="<?php echo $db_field_name;?>" value="<?php echo $value;?>"
                       class="form-control <?php if($required == 1) { ?> required <?php } ?>" placeholder="">
            </div>
        </div>
        <?php
    }

    public function add_meta_keywords($db_field_name, $required = 0)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo dictionary('SEO_META_KEY');?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <input type="text" name="<?php echo $db_field_name;?>" value=""
                       class="form-control <?php if($required == 1) { ?> required <?php } ?>" placeholder="">
            </div>
        </div>
        <?php
    }

    public function edit_meta_keywords($value, $db_field_name, $required = 0)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo dictionary('SEO_META_KEY');?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <input type="text" name="<?php echo $db_field_name;?>" value="<?php echo $value;?>"
                       class="form-control <?php if($required == 1) { ?> required <?php } ?>" placeholder="">
            </div>
        </div>
        <?php
    }

    public function add_meta_description($db_field_name, $required = 0)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo dictionary('SEO_META_DESCRIPTION');?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <input type="text" name="<?php echo $db_field_name;?>" value=""
                       class="form-control <?php if($required == 1) { ?> required <?php } ?>" placeholder="">
            </div>
        </div>
        <?php
    }

    public function edit_meta_description($value, $db_field_name, $required = 0)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo dictionary('SEO_META_DESCRIPTION');?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <input type="text" name="<?php echo $db_field_name;?>" value="<?php echo $value;?>"
                       class="form-control <?php if($required == 1) { ?> required <?php } ?>" placeholder="">
            </div>
        </div>
        <?php
    }

    public function add_preview($db_field_name, $required = 0, $form_label_title = "")
    {
        if(empty($form_label_title))
        {
            $form_label_title = dictionary('PREVIEW');
        }
        ?>
        <div class="form-group">
            <label class="col-md-12">
                <?php echo $form_label_title;?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <textarea class="form-control <?php if($required == 1) { ?> required_ckeditor <?php } ?>" name="<?php echo $db_field_name;?>" cols="70" rows="5"></textarea>
            </div>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', function() {
                (function($) {
                    $(document).ready(function() {

                        CKEDITOR.replace( '<?php echo $db_field_name;?>',
                            {
                                uiColor: '#ffffff',
                                filebrowserBrowseUrl : '/cp/ckeditor/ckfinder/ckfinder.html',
                                filebrowserImageBrowseUrl : '/cp/ckeditor/ckfinder/ckfinder.html?Type=Images',
                                filebrowserFlashBrowseUrl : '/cp/ckeditor/ckfinder/ckfinder.html?Type=Flash',
                                filebrowserUploadUrl : '/cp/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                filebrowserImageUploadUrl : '/cp/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                filebrowserFlashUploadUrl : '/cp/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                            }
                        );

                    });
                })(jQuery);
            });
        </script>
        <?php
    }

    public function edit_preview($value, $db_field_name, $required = 0, $form_label_title = "")
    {
        if(empty($form_label_title))
        {
            $form_label_title = dictionary('PREVIEW');
        }
        ?>
        <div class="form-group">
            <label class="col-md-12">
                <?php echo $form_label_title;?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <textarea class="form-control <?php if($required == 1) { ?> required_ckeditor <?php } ?>" name="<?php echo $db_field_name;?>" cols="70" rows="5">
                    <?php echo $value;?>
                </textarea>
            </div>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', function() {
                (function($) {
                    $(document).ready(function() {

                        CKEDITOR.replace( '<?php echo $db_field_name;?>',
                            {
                                uiColor: '#ffffff',
                                filebrowserBrowseUrl : '/cp/ckeditor/ckfinder/ckfinder.html',
                                filebrowserImageBrowseUrl : '/cp/ckeditor/ckfinder/ckfinder.html?Type=Images',
                                filebrowserFlashBrowseUrl : '/cp/ckeditor/ckfinder/ckfinder.html?Type=Flash',
                                filebrowserUploadUrl : '/cp/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                filebrowserImageUploadUrl : '/cp/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                filebrowserFlashUploadUrl : '/cp/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                            }
                        );

                    });
                })(jQuery);
            });
        </script>
        <?php
    }

    public function add_description($db_field_name, $required = 0, $form_label_title = '')
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"> <?php
                if(empty($form_label_title))
                {
                    $form_label_title = dictionary('DESCRIPTION');
                }
                echo $form_label_title;
                ?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <textarea class="form-control <?php if($required == 1) { ?> required_ckeditor <?php } ?>" name="<?php echo $db_field_name;?>" cols="70" rows="5"></textarea>
            </div>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', function() {
                (function($) {
                    $(document).ready(function() {

                        CKEDITOR.replace( '<?php echo $db_field_name;?>',
                            {
                                uiColor: '#ffffff',
                                filebrowserBrowseUrl : '/cp/ckeditor/ckfinder/ckfinder.html',
                                filebrowserImageBrowseUrl : '/cp/ckeditor/ckfinder/ckfinder.html?Type=Images',
                                filebrowserFlashBrowseUrl : '/cp/ckeditor/ckfinder/ckfinder.html?Type=Flash',
                                filebrowserUploadUrl : '/cp/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                filebrowserImageUploadUrl : '/cp/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                filebrowserFlashUploadUrl : '/cp/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                            }
                        );

                    });
                })(jQuery);
            });
        </script>
        <?php
    }

    public function edit_description($value, $db_field_name, $required = 0, $form_label_title = '')
    {
        ?>
        <div class="form-group">
            <label class="col-md-12">
                <?php
                if(empty($form_label_title))
                {
                    $form_label_title = dictionary('DESCRIPTION');
                }

                echo $form_label_title;
                ?>
                <?php
                if($required == 1)
                {
                    ?>
                    <span style="color: red;">*</span>
                    <?php
                }
                ?>
            </label>
            <div class="col-md-12">
                <textarea class="form-control <?php if($required == 1) { ?> required_ckeditor <?php } ?>" name="<?php echo $db_field_name;?>" cols="70" rows="5">
                    <?php echo $value;?>
                </textarea>
            </div>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', function() {
                (function($) {
                    $(document).ready(function() {

                        CKEDITOR.replace( '<?php echo $db_field_name;?>',
                            {
                                uiColor: '#ffffff',
                                filebrowserBrowseUrl : '/cp/ckeditor/ckfinder/ckfinder.html',
                                filebrowserImageBrowseUrl : '/cp/ckeditor/ckfinder/ckfinder.html?Type=Images',
                                filebrowserFlashBrowseUrl : '/cp/ckeditor/ckfinder/ckfinder.html?Type=Flash',
                                filebrowserUploadUrl : '/cp/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                filebrowserImageUploadUrl : '/cp/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                filebrowserFlashUploadUrl : '/cp/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                            }
                        );

                    });
                })(jQuery);
            });
        </script>
        <?php
    }


// universal methods

    public function add_checkbox($db_field_name, $form_name)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo $form_name;?></label>
            <div class="col-md-12">
                <input type="checkbox" name="<?php echo $db_field_name;?>"
                       class="form-control" placeholder="" style="float: left; width: 50px;">
            </div>
        </div>
        <?php
    }

    public function edit_checkbox($value, $db_field_name, $form_name)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo $form_name;?></label>
            <div class="col-md-12">
                <input type="checkbox" name="<?php echo $db_field_name;?>"
                    <?php if($value == 1) { ?> checked <?php } ?>
                       class="form-control" placeholder="" style="float: left; width: 50px;">
            </div>
        </div>
        <?php
    }

    public function checkbox($value, $db_field_name, $form_name)
    {
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo $form_name;?></label>
            <div class="col-md-12">
                <input type="checkbox" name="<?php echo $db_field_name;?>"
                    <?php if($value == 1) { ?> checked <?php } ?>
                       class="form-control" placeholder="" style="float: left; width: 50px;">
            </div>
        </div>
        <?php
    }
//END: universal methods


    public function page_access($page_id)
    {
        $access_info = array();
        $get_access = $this->_db
            ->where('id', $page_id)
            ->getOne('pages', "access");

        if($get_access)
        {
            $access_info = explode(',', $get_access['access']);
        }

        return $access_info;
    }


    public function post_add_image($dir, $images, $input_field = "")
    {
        if(count($images)==0)
        {
            return 'No images to upload!';
        }

        $path_target = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
        $created_file_names = array();
        $result = is_dir($path_target . $dir );
        if ($result)
        {
            $FileDirecotry = $path_target . $dir;
        }
        else
        {
            if (mkdir( $path_target . $dir ))
            {
                $FileDirecotry = $path_target . $dir;
            }
            else
            {
                return 'Ошибка создание директории для нового изображения!';
            }
        }

        if ( isset($input_field) && $input_field!="" )
        {
            //array is unidimensional

            $explodeCurentFile = explode('.', $images[$input_field]['name']);
            $end_file = end($explodeCurentFile);
            $file_name = uniqid() . "." . $end_file; // генерируем имя файла
            $targetPath = $FileDirecotry . "/" . $file_name;  // Target path where file is to be stored

            if($end_file != 'svg')
            {
                $IMG_DATA = getimagesize($images[$input_field]['tmp_name']);
                if ($IMG_DATA === FALSE)
                {
                    return "Unable to determine image type of uploaded file";
                }
            }

            if(move_uploaded_file($images[$input_field]['tmp_name'], $targetPath))
            {
                $created_file_names[$input_field] = $file_name;
            }
            else
            {
                $created_file_names[$input_field] = 'error_file_name';
            }

        }
        else
        {
            //array is multidimensional
            foreach ($images as $key => $image)
            {
                $explodeCurentFile = explode('.', $image['name']);
                $end_file = end($explodeCurentFile);
                $file_name = uniqid() . "." . $end_file; // генерируем имя файла
                $targetPath = $FileDirecotry . "/" . $file_name;  // Target path where file is to be stored

                if($end_file != 'svg')
                {
                    $IMG_DATA = getimagesize($image['tmp_name']);
                    if ($IMG_DATA === FALSE) {
                        return "Unable to determine image type of uploaded file";
                    }
                }

                if(move_uploaded_file($image['tmp_name'], $targetPath))
                {
                    $created_file_names[$key] = $file_name;
                }
                else
                {
                    $created_file_names[$key] = 'error_file_name';
                }
            }
        }

        return $created_file_names;

    }




    /* --------------------------------------- DROPZONE --------------------------------------------------------------*/
    // functia de adaugare a blocului dropzone, cu posibilitatea de adaugarea titlului '$form_label_title' --- LA ADAUGARE
    public function add_dropzone_files($db_table_name = '', $form_label_title = '')
    {
        global $lang;

        $dropzone_id = uniqid("awesome-dropzone_");
        if(empty($form_label_title))
        {
            $form_label_title = dictionary('DROPZONE_IMAGE');
        }
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo $form_label_title;?></label>
            <div class="col-md-12">
                <div class="dropzone dropzone-previews" id="<?php echo $dropzone_id;?>"></div>
            </div>
        </div>

        <?php
        include $_SERVER['DOCUMENT_ROOT'].'/cp/js/dropzone_Form_class_include.php';
        ?>

        <?php
    }
    // functia de adaugare a blocului dropzone, cu posibilitatea de adaugarea titlului '$form_label_title' --- LA REDACTARE
    public function edit_dropzone_files($db_table_name, $edit_elem_id, $form_label_title = "")
    {
        global $lang;

        $dropzone_id = uniqid("awesome-dropzone_");

        if(empty($form_label_title))
        {
            $form_label_title = dictionary('DROPZONE_IMAGE');
        }
        ?>
        <div class="form-group">
            <label class="col-md-12"><?php echo $form_label_title;?></label>
            <div class="col-md-12">
                <div class="dropzone dropzone-previews" id="<?php echo $dropzone_id;?>">
                    <?php
                    $sp_dz_image_position = 1;
                    $Dropzone_Element_Images = $this->_db
                        ->where('parent_id', $edit_elem_id)
                        ->orderBy("sort","asc")
                        ->get($db_table_name);

                    if (count($Dropzone_Element_Images) > 0)
                    {
                        foreach ($Dropzone_Element_Images as $dropzone_images)
                        {
                            ?>
                            <div class="dz-preview dz-processing dz-image-preview dz-complete" data-position="<?php echo $sp_dz_image_position;?>">
                                <div class="dz-image">
                                    <?php
                                    $dropzone_path_image_thumb = @newthumbs( $dropzone_images['image'] , $db_table_name, 120, 120, 20, 1);
                                    if(!$dropzone_path_image_thumb)
                                    {
                                        ?>
                                        <img data-dz-thumbnail=""  src="/css/img/default.png">
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <img data-dz-thumbnail="" alt="" src="<?php echo $dropzone_path_image_thumb;?>">
                                        <?php
                                    }

                                    ?>
                                </div>
                                <div class="dz-details">
                                    <div class="dz-size">
                                        <span data-dz-size=""><strong><?php echo round(filesize($_SERVER['DOCUMENT_ROOT']. '/uploads/'.$db_table_name.'/' .$dropzone_images['image'])/1048576, 2 );?></strong> MB</span>
                                    </div>
                                    <div class="dz-filename">
                                        <span data-dz-name=""><?php echo $dropzone_images['original_file_name'];?></span>
                                    </div>
                                </div>
                                <a class="dz-remove" href="javascript:void(0);" onclick = "remove_loaded_element_dropzone_image(this)" data-file_path="">Remove file</a>
                                <div class="dz-file_name">
                                    <input data-helper_file_name="<?php echo $dropzone_images['image'];?>" type="hidden" name="dropzone_files[<?php echo $dropzone_id?>][]" value="<?php echo $dropzone_images['image'];?>|<?php echo $sp_dz_image_position;?>|<?php echo $dropzone_images['original_file_name'];?>">
                                </div>


                            </div>
                            <?php
                            $sp_dz_image_position++;
                        }
                        ?>
                        <style>
                            .dropzone.dz-started .dz-message
                            {
                                display: none!important;
                            }
                        </style>
                        <?php
                    }
                    ?>

                    <div class="dz-db_table_name">
                        <input type="hidden" name="dropzone_files[<?php echo $dropzone_id?>][db_table]" value="<?php echo $db_table_name;?>" />
                    </div>

                </div>
            </div>
        </div>

        <?php
        include $_SERVER['DOCUMENT_ROOT'].'/cp/js/dropzone_Form_class_include.php';
        ?>

        <?php
    }

    // functia de prelucrarea datelor din blocul dropzone    --- POST, LA ADAUGARE
    public function post_dropzone_adding($inserted_id_result, $ar_post_clean__dropzone_files)
    {
        if( isset($ar_post_clean__dropzone_files) && count($ar_post_clean__dropzone_files)>0 )
        {
            foreach ( $ar_post_clean__dropzone_files as $parent_dropzone => $dropzone_block )
            {
                if(isset($dropzone_files_array))
                {
                    unset($dropzone_files_array);
                }
                $dropzone_files_array = array();
                $dropzone_db_field_name = '';
                foreach ( $dropzone_block as $key => $dropzone_block_images )
                {
                    if( strcmp($key , 'db_table') )
                    {
                        $dropzone_files_array[] = $dropzone_block_images;
                    }
                    else
                    {
                        $dropzone_db_field_name = $dropzone_block_images;
                    }
                }

                if( isset($parent_dropzone,$dropzone_files_array,$dropzone_db_field_name) && trim($dropzone_db_field_name)!='' && trim($parent_dropzone)!='' && count($dropzone_files_array)>0)
                {
                    $this->post_add_dropzone_files($inserted_id_result, $dropzone_db_field_name, $dropzone_files_array);
                }
            }
        }
    }
    // functia de prelucrarea datelor din blocul dropzone    --- POST, LA REDACTARE
    public function post_dropzone_editing($edit_elem_id, $ar_post_clean__dropzone_files)
    {
        if( isset($ar_post_clean__dropzone_files) && count($ar_post_clean__dropzone_files)>0 )
        {
            foreach ( $ar_post_clean__dropzone_files as $parent_dropzone => $dropzone_block )
            {
                if(isset($dropzone_files_array))
                {
                    unset($dropzone_files_array);
                }
                $dropzone_files_array = array();
                $dropzone_db_field_name = '';
                foreach ( $dropzone_block as $key => $dropzone_block_images )
                {
                    if( strcmp($key , 'db_table') )
                    {
                        $dropzone_files_array[] = $dropzone_block_images;
                    }
                    else
                    {
                        $dropzone_db_field_name = $dropzone_block_images;
                    }
                }

                if( isset($parent_dropzone,$dropzone_files_array,$dropzone_db_field_name) && trim($dropzone_db_field_name)!='' && trim($parent_dropzone)!='' && count($dropzone_files_array)>=0)
                {
                    $this->post_edit_dropzone_files($edit_elem_id, $dropzone_db_field_name, $dropzone_files_array);
                }
            }
        }
    }

    // FUNCTIA PRIVATA DE PRELUCRARE A DATELOR DROPZONE
    private function post_add_dropzone_files($inserted_id_result, $dropzone_table_name, $dropzone_files_array)
    {
        $status_info['error'] = array();

        // $dropzone_table_name --- Tabelul in care va fi inserata informatia
        // $copy_to_dir --- directoriul din mapa 'uploads/'
        // $dropzone_files_array --- continutul dropzone

        $copy_to_dir = $dropzone_table_name;
        $path_target = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
        $result = is_dir($path_target . $copy_to_dir );
        if ($result)
        {
            $FileDirecotry = $path_target . $copy_to_dir;
        }
        else
        {
            if (mkdir( $path_target . $copy_to_dir ))
            {
                $FileDirecotry = $path_target . $copy_to_dir;
            }
            else
            {
                $status_info['error'][] = 'Ошибка создание директории для нового изображения!';
            }
        }


        if(empty($status_info['error']))
        {
            $data_images = Array();
            foreach($dropzone_files_array as $dropzone_files)
            {
                list($file_name, $file_sort, $original_file_name) = explode('|', $dropzone_files);
                $file_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/dropzone/temp_files/'.$file_name;

                if (is_file($file_path))
                {
                    $data_images[] = Array($inserted_id_result, $file_name, $file_sort, $original_file_name);
                    if(copy($file_path, $FileDirecotry.'/'.$file_name))
                    {
                        unlink($file_path);
                    }
                    else
                    {
                        $status_info['error'][] =  $file_path. 'copy ERROR!!!';
                    }
                }
            }

            $keys = Array("parent_id", "image", "sort", "original_file_name");

            $file_image_ids = $this->_db->insertMulti($dropzone_table_name, $data_images, $keys);
            if(!$file_image_ids)
            {
                $status_info['error'][] = $this->_db->getLastError();
            }
        }

        return $status_info['error'];
    }
    // FUNCTIA PRIVATA DE PRELUCRARE A DATELOR DROPZONE
    private function post_edit_dropzone_files($edit_element_id, $dropzone_table_name, $dropzone_files_array)
    {
        $status_info['error'] = array();
        // $dropzone_files_array --- continutul dropzone

        // PASUL 1
        //Masivul cu toate imaginile primite din post, curatsat de parametru sort
        $copy_to_dir = $dropzone_table_name; // directoriul din mapa uploads/
        $path_target = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
        $result = is_dir($path_target . $copy_to_dir );
        if ($result)
        {
            $FileDirecotry = $path_target . $copy_to_dir;
        }
        else
        {
            if (mkdir( $path_target . $copy_to_dir ))
            {
                $FileDirecotry = $path_target . $copy_to_dir;
            }
            else
            {
                $status_info['error'][] = 'Ошибка создание директории для нового изображения!';
            }
        }

        if(empty($status_info['error']))
        {
            $Post_Dropzone_Element_Images = array();
            if( isset($dropzone_files_array) && count($dropzone_files_array)>0)
            {
                foreach ($dropzone_files_array as $post_dropzone_files)
                {
                    list($file_name, $file_sort, $original_file_name) = explode('|', $post_dropzone_files);
                    $Post_Dropzone_Element_Images[] = $file_name;
                }
                //show($Post_Dropzone_Element_Images);
            }

            // PASUL 2
            // Ne uitam ce imagini au fost initial incarcate pentru elementul curent
            $Initial_Drompzone_DB_Element_Images = array();
            $Initial_Drompzone_DB_Element_Array_trash = $this->_db
                ->where('parent_id', $edit_element_id)
                ->get($dropzone_table_name, null, "image");
            foreach ($Initial_Drompzone_DB_Element_Array_trash as $db_element_image)
            {
                $Initial_Drompzone_DB_Element_Images[] = $db_element_image['image'];
            }
            //show($Initial_Drompzone_DB_Element_Images);


            // PASUL 3
            // Aflam imaginile comunte dintre imaginile initiale din baza de date cu cele primite din post
            // In asa mod vom sti care elemente sunt din initial din baza de date
            $Commnon_element_images = array_intersect($Initial_Drompzone_DB_Element_Images, $Post_Dropzone_Element_Images);
            //show($Commnon_element_images);

            // PASUL 4
            // Aflam diferentsa dintre imaginile initiale din baza de date cu cele comune, primite de mai sus
            // ca sa aflam care imagini au fost sterse
            $get_deleted_element_images = array_merge(array_diff($Initial_Drompzone_DB_Element_Images, $Commnon_element_images), array_diff($Commnon_element_images, $Initial_Drompzone_DB_Element_Images));
            //show($get_deleted_element_images);
            // Apoi stergem elementele din baza de date si directoriu, care au fost sterse la modificarea elementului
            if( count($get_deleted_element_images) > 0 )
            {
                foreach ($get_deleted_element_images as $deleted_image)
                {
                    $get_deleted_image_info = $this->_db
                        ->where('parent_id', $edit_element_id)
                        ->where('image', $deleted_image)
                        ->getOne($dropzone_table_name, "id");
                    if ($get_deleted_image_info)
                    {
                        $this->_db->where('id', $get_deleted_image_info['id']);
                        if ($this->_db->delete($dropzone_table_name, 1)) {
                            if(!remove_image($copy_to_dir, $this->_db->escape($deleted_image)))
                            {
                                $status_info['error'][] = dictionary('COULD_NOT_DELETE_OLD_IMAGES');
                            }
                        }
                    }
                }
            }

            // PASUL 5
            // Separam imaginile din masivul primit din POST
            // Vom primi 2 masive. Unul cu imaginile care erau initial si altu cu imaginile noi incarcate
            $OLD_DROPZONE_IMAGE_ARRAY = $Commnon_element_images;
            $NEW_DROPZONE_IMAGE_ARRAY = array();
            $NEW_DROPZONE_IMAGE_ARRAY = array_merge(array_diff($Post_Dropzone_Element_Images, $Commnon_element_images), array_diff($Commnon_element_images, $Post_Dropzone_Element_Images));
            //show($OLD_DROPZONE_IMAGE_ARRAY);
            //show($NEW_DROPZONE_IMAGE_ARRAY);

            // PASUL 6
            // Analizam masivul cu imagini si sortari, initial primit prin POST
            // Controlam daca imaginea se afla in masivul $OLD_DROPZONE_IMAGE_ARRAY, atunci innoim informatia(cimpul 'sort') despre aceasta imagine
            // Sau daca imaginea se afla in masivul $NEW_DROPZONE_IMAGE_ARRAY, atunci adaugam informatia in baza de date
            if( isset($dropzone_files_array) && count($dropzone_files_array)>0)
            {
                foreach ($dropzone_files_array as $dropzone_files) {
                    list($file_name, $file_sort, $original_file_name) = explode('|', $dropzone_files);

                    if (in_array($file_name, $OLD_DROPZONE_IMAGE_ARRAY)) {
                        $get_image_info = $this->_db
                            ->where('parent_id', $edit_element_id)
                            ->where('image', $file_name)
                            ->getOne($dropzone_table_name, "id");
                        if ($get_image_info) {
                            $data_update_image_info = Array(
                                'sort' => $file_sort
                            );
                            $this->_db->where('id', $get_image_info['id']);
                            if (!$this->_db->update($dropzone_table_name, $data_update_image_info, 1)) {
                                $status_info['error'][] = $this->_db->getLastError();
                            }
                        } else {
                            $status_info['error'][] = $this->_db->getLastError();
                        }
                    } elseif (in_array($file_name, $NEW_DROPZONE_IMAGE_ARRAY)) {
                        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/dropzone/temp_files/' . $file_name;
                        if (is_file($file_path)) {
                            if (copy($file_path, $FileDirecotry.'/'.$file_name)) {
                                unlink($file_path);
                                $data_insert_image_info = Array(
                                    "parent_id" => $edit_element_id,
                                    "image" => $file_name,
                                    "sort" => $file_sort,
                                    "original_file_name" => $original_file_name
                                );

                                $last_inserted_image_info_id = $this->_db->insert($dropzone_table_name, $data_insert_image_info);
                                if (!$last_inserted_image_info_id) {
                                    $status_info['error'][] = $this->_db->getLastError();
                                }
                            } else {
                                $status_info['error'][] = $file_path . 'copy ERROR!!!';
                            }
                        }
                    } else {
                        $status_info['error'][] = "eroare la adaugarea/modificarea imaginilor";
                    }
                }
            }
        }

        return $status_info['error'];
    }
    /* --------------------------------------- END DROPZONE --------------------------------------------------------------*/


    public function hide_dates($action, $string)
    {
        //------------------------------------------------------------------------------
        // WARNING  - данная функция будет работать только в одну сторону, так как используется  uniqid()
        // если хотите чтобы работала и декодировка,
        // тогда удалите  '$secret_key = "QPqnR8UCqJGuIggD55PohusaBNviGoOJ".uniqid();' и раскомментируйте '$secret_key = "QPqnR8UCqJGuIggD55PohusaBNviGoOJ";'

        /* -- Пример работы кодировки и декодировки

            $plain_txt = "This is my plain";
            echo "Plain Text = $plain_txt\n";

            $encrypted_txt = encrypt_decrypt('encrypt', $plain_txt);
            echo "Encrypted Text = $encrypted_txt\n";
            echo "<br>lenght: ".strlen($encrypted_txt);?><br><?

            $decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt);
            echo "Decrypted Text = $decrypted_txt\n";

            if( $plain_txt === $decrypted_txt ) echo "SUCCESS";
            else echo "FAILED";
         */

        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = "kWATPuVCXG69sD5XNnmMU2KL56rrV5Wz";
        $secret_iv = "MYq4nMrf77kX3TZP95AmgHF4q4YPnsz9";

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }




    public function newthumbs($image = '', $dir = '', $width = 0, $height = 0, $version = 0, $zc = 0)
    {
        require_once $_SERVER['DOCUMENT_ROOT'].'/libraries/imres/phpthumb.class.php';
        $path_target = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
        $img = '';

        $result = is_dir($path_target . $dir . '/thumbs');
        if ($result) {
            $prevdir = $dir . '/thumbs';
        } else {
            if (mkdir( $path_target . $dir . '/thumbs')) {
                $prevdir = $dir . '/thumbs';
            } else {
                return 'error 1';
            }
        }


        if (!empty($version))
        {
            $result = is_dir( $path_target . $dir . '/thumbs/version_' . $version );
            if ($result) {
                $prevdir = $dir . '/thumbs/version_' . $version;
            } else {
                if ( mkdir( $path_target . $dir . '/thumbs/version_' . $version)) {
                    $prevdir = $dir . '/thumbs/version_' . $version;
                } else {
                    return 'error 1';
                }
            }
        }


        $temp_ext = explode('.', $image);
        $ext = end($temp_ext);

        $timg = $path_target . $dir . '/' . $image;
        $catimg = $path_target . $prevdir . '/' . $image;

        $explodeCurentFile = explode('.', $image);
        $end_file = end($explodeCurentFile);
        ///show($end_file);

        if($end_file == 'svg')
        {
            $img = '/uploads/'.$dir.'/'.$image;
        }
        else
        {
            if (is_file($timg) && !is_file($catimg)) {
                $opath1 = $path_target . $dir . '/';
                $opath2 = $path_target . $prevdir . '/';
                $dest = $opath2 . $image;
                $source = $opath1 . $image;
                $phpThumb = new phpThumb();
                $phpThumb->setSourceFilename($source);
                if (!empty($width)) $phpThumb->setParameter('w', $width);
                if (!empty($height)) $phpThumb->setParameter('h', $height);
                if ($ext == 'png') $phpThumb->setParameter('f', 'png');
                if (!empty($zc)) {
                    $phpThumb->setParameter('zc', '1');
                }
                $phpThumb->setParameter('q', 100);
                if ($phpThumb->GenerateThumbnail()) {
                    if ($phpThumb->RenderToFile($dest)) {
                        $img = '/uploads/' . $prevdir . '/' . $image;
                    } else {
                        return 'error 3';
                    }
                }

            } elseif (is_file($catimg)) {
                $img = '/uploads/' . $prevdir . '/' . $image;
            } else {
                return 'error 2';
            }
        }

        return $img;
    }



    public function remove_image($dir, $image)
    {
        $return_value = true;
        $path_target = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
        $result = is_dir($path_target . $dir );
        if ($result)
        {
            $FileDirecotry = $path_target . $dir;
        }
        else
        {
            return false;
        }

        if($image!="" && is_file($FileDirecotry. "/" . $image)) // очень важное условие, если им пренебречь то при пустом значение файла удалиться все изображения из текущей директории
        {
            $find_all_files_for_detele = getDirContents($FileDirecotry, "/" . $image . "$/");
            if (count($find_all_files_for_detele) > 0)
            {
                foreach ($find_all_files_for_detele as $fined_file_to_delete)
                {
                    if (unlink($fined_file_to_delete))
                    {
                        // echo 'deleted';
                        $return_value = true;
                    }
                    else
                    {
                        $return_value = false;
                    }
                }
            }
            else
            {
                return false;
            }
        }

        return $return_value;
    }


    public function remove_catalog_element($db,$id,$db_catalog_elements_table,$CPU_ELEM_ID,$db_front_cpu_table,$db_catalog_elements_images,$db_catalog_elements_parameters_table)
    {
        $table_info = $db
            ->where('id', $id)
            ->getOne($db_catalog_elements_table, "image");

        $db->where('id', $id);
        if($db->delete($db_catalog_elements_table, 1))
        {
            //remove cpu
            $db->where('page_id', $CPU_ELEM_ID);
            $db->where('elem_id', $id);
            $db->delete($db_front_cpu_table);

            //remove main image
            $this->remove_image($db_catalog_elements_table, $table_info['image']);

            // remove dropzone images ---------------------------------------------------------------//
            $get_table_dropzone_images = $db
                ->where('parent_id', $id)
                ->get($db_catalog_elements_images);
            foreach ( $get_table_dropzone_images as $table_dropzone_image )
            {
                $db->where('id', $table_dropzone_image['id']);
                if ($db->delete($db_catalog_elements_images, 1))
                {
                    $this->remove_image($db_catalog_elements_images, $table_dropzone_image['image']);
                }
            }
            $db->where('parent_id', $id);
            $db->delete($db_catalog_elements_images);
            //--------------------------------------------------------------------------------//

            //--- remove paramenters ----------------------------//
            $remove_current_element_parameters = $db
                ->where('element_id', $id)
                ->delete($db_catalog_elements_parameters_table);
            //--------------------------------------------------//
        }
    }


    //================================================================================================================//
    public function post_add_file($dir, $images, $input_field = "")
    {
        if(count($images)==0)
        {
            return 'No images to upload!';
        }

        $path_target = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
        $created_file_names = array();
        $result = is_dir($path_target . $dir );
        if ($result)
        {
            $FileDirecotry = $path_target . $dir;
        }
        else
        {
            if (mkdir( $path_target . $dir ))
            {
                $FileDirecotry = $path_target . $dir;
            }
            else
            {
                return 'Ошибка создание директории для нового изображения!';
            }
        }

        if ( isset($input_field) && $input_field!="" )
        {
            //array is unidimensional

            $explodeCurentFile = explode('.', $images[$input_field]['name']);
            $end_file = end($explodeCurentFile);
            $file_name = uniqid() . "." . $end_file; // генерируем имя файла
            $targetPath = $FileDirecotry . "/" . $file_name;  // Target path where file is to be stored


            if(move_uploaded_file($images[$input_field]['tmp_name'], $targetPath))
            {
                $created_file_names[$input_field] = $file_name;
            }
            else
            {
                $created_file_names[$input_field] = 'error_file_name';
            }

        }


        return $created_file_names;

    }
    //================================================================================================================//





}