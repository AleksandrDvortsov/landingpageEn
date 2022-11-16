<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() {
        (function($) {
            $(document).ready(function()
            {
                var total_dropted_files = parseInt( $("#<?php echo $dropzone_id?> .dz-image-preview").length );
                $("div#<?php echo $dropzone_id?>").dropzone({
                    addRemoveLinks: true,
                    url: "<?php echo $this->_Cpu->getURL(41);?>",
                    paramName:"file",
                    init: function() {
                        var thisDropzone = this;
                    },
                    success: function( file, response )
                    {
                        if(file.status = "success")
                        {
                            file_name = JSON.parse(response);
                            if(file_name != "")
                            {
                                total_dropted_files++;
                                $(file.previewTemplate).attr("data-position", total_dropted_files);
                                $(file.previewTemplate).append("<div class='dz-file_name'></div>");
                                original_file_name = $(file.previewTemplate).find('.dz-details').find('.dz-filename span').html();
                                $(file.previewTemplate).find('.dz-file_name').append('<input data-helper_file_name ="'+file_name+'" type="hidden" name="dropzone_files[<?php echo $dropzone_id?>][]" value="'+file_name+'|'+total_dropted_files+'|'+original_file_name+'" />');
                                $(file.previewTemplate).append("<div class='dz-db_table_name'></div>");
                                $(file.previewTemplate).find('.dz-db_table_name').append('<input type="hidden" name="dropzone_files[<?php echo $dropzone_id?>][db_table]" value="<?php echo $db_table_name;?>" />');
                                file.name = file_name;
                                $(file.previewTemplate).find('.dz-remove').attr("href", "javascript:void(0);");
                                $(file.previewTemplate).find('.dz-remove').attr("data-file_path", file_name);
                            }
                        }
                    },
                    removedfile: function(file)
                    {
                        x = confirm('Do you want to delete?');
                        if (!x)  return false;
                        var file_path = $(file.previewTemplate).find('.dz-remove').attr("data-file_path");

                        // alert(file_path);
                        var data = {};
                        data['task'] = 'delete_dropzone_temp_file';
                        data['file_path'] = file_path;

                        $.ajax({
                            type: "POST",
                            url: "/cp_ajax_<?php echo $lang;?>/",
                            data: data,
                            dataType: "json",
                            success: function (msg)
                            {
                                //console.log(msg);
                                $(file.previewTemplate).remove();
                            }
                        });
                    }

                });


                $( document ).on( "mousemove", function( event ) {
                    var parentOffset;
                    if(event.target.id == "<?php echo $dropzone_id?>")
                    {
                        parentOffset = $("#<?php echo $dropzone_id?>").offset();
                        window.x = event.pageX - parentOffset.left;
                        window.y = event.pageY - parentOffset.top;
                    }
                });


                $('#<?php echo $dropzone_id?>').sortable({
                    start : function(event, ui) {
                        // var start_pos = ui.item.index();
                        // ui.item.data('start_pos', start_pos);

                        var start_pos = ui.item.index();
                        ui.item.data('start_pos', start_pos);
                    },
                    sort: function(event, ui)
                    {
                        ui.helper.css("top",window.y - 70);
                        //console.log("block: " + ui.helper.css("top"));
                        //console.log("cursor: " + window.y);
                    },
                    update: function(event, ui) {

                        var index = ui.item.index();
                        var start_pos = ui.item.data('start_pos');
                        var position_number = 1;
                        var a_helper_file_name = "";
                        //console.log(index);
                        //console.log(start_pos);

                        $('#<?php echo $dropzone_id?> div.dz-preview').each(function() {
                            a_helper_file_name = $(this).find('.dz-file_name input').attr("data-helper_file_name");
                            original_file_name = $(this).find('.dz-details').find('.dz-filename span').html();
                            $(this).attr("data-position", position_number);
                            $(this).find('.dz-file_name input').attr("value", a_helper_file_name +'|'+ position_number+'|'+ original_file_name);
                            position_number++;
                        });
                    }
                });


                $( "#<?php echo $dropzone_id?>" ).disableSelection();

            });
        })(jQuery);
    });
</script>