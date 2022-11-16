<?php  // jQuery v3.1.1  ?>
<script src="/cp/plugins/bower_components/jquery/dist/jquery.min.js"></script>


<?php  // ckeditor  ?>
<script type="text/javascript" src="/cp/ckeditor/ckeditor.js"></script>


<?php  // Bootstrap Core JavaScript  ?>
<script src="/cp/bootstrap/dist/js/bootstrap.min.js"></script>

<?php  // bootstrap-datetimepicker  ?>
<script type="text/javascript" src="/libraries/bootstrap_datetimepicker/js/moment.min.js"></script>
<script type="text/javascript" src="/libraries/bootstrap_datetimepicker/js/bootstrap-datetimepicker.js"></script>

<?php  // Menu Plugin JavaScript  ?>
<script src="/cp/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

<?php  // slimscroll JavaScript  ?>
<script src="/cp/js/jquery.slimscroll.js"></script>

<?php  // Wave Effects  ?>
<script src="/cp/js/waves.js"></script>

<?php  // Dropzone Plugin JavaScript  ?>
<script src="/cp/plugins/bower_components/dropzone-master/dist/dropzone.js"></script>

<?php  // Counter js  ?>
<script src="/cp/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
<script src="/cp/plugins/bower_components/counterup/jquery.counterup.min.js"></script>

<?php  // Custom Theme JavaScript  ?>
<script src="/cp/js/custom.min.js"></script>
<script src="/cp/js/jasny-bootstrap.js"></script>

<?php  // Style Switcher  ?>
<script src="/cp/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

<?php  // jquery-ui 1.12.1  ?>
<script src="/cp/plugins/ui/1.12.1/jquery-ui.js"></script>

<?php  // Wave Effects  ?>
<script src="/cp/js/waves.js"></script>
<script src="/cp/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
<script src="/cp/js/toastr.js"></script>

<?php // color_picker ?>
<script src="/cp/js/jscolor.js"></script>

<script type="text/javascript">

    $('.alphaonly').bind('keyup blur',function(){
        var node = $(this);
        node.val(node.val().replace(/[^a-z_]/g,'') ); }
    );

    $('.first_letter_not_numeric').bind('keyup blur',function(e){
        if ($.isNumeric($(this).val().slice(0, 1))) {
            $(this).val('');
            alert('First letter should not be Numeric.!');
        }
        if (this.value.match(/[^a-zA-Z0-9]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
        }
    });

    function refreshCaptcha()
    {
        var data = {};
        data['task'] = 'refreshCaptcha';

        $.ajax({
            type: "POST",
            url: "/cp_ajax_<?php echo $Main->lang;?>/",
            data: data,
            dataType: "json",
            success: function (image)
            {
                $("#captcha_code").attr('src',image);
            }
        });
    }

    function change_site_options_value(id, value)
    {
        var data = {};
        data['task'] = 'change_site_options_value';
        data['id'] = id;
        data['value'] = value;

        $.ajax({
            type: "POST",
            url: "/cp_ajax_<?php echo $Main->lang;?>/",
            data: data,
            dataType: "json",
            success: function (msg)
            {
                if(msg!="") alert(msg);
            }
        });
    }

    function change_dictionary_input_value(id, field, value)
    {
        var data = {};
        data['task'] = 'change_dictionary_input_value';
        data['id'] = id;
        data['field'] = field;
        data['value'] = value;

        $.ajax({
            type: "POST",
            url: "/cp_ajax_<?php echo $Main->lang;?>/",
            data: data,
            dataType: "json",
            success: function (msg)
            {
                if(msg!="") alert(msg);
            }
        });
    }


    $(function(){

        $('.input_focusof').keyup(function(e){
            if(e.keyCode == 13)
            {
                $(this).blur();
            }
        });

    });


    $('form#check_required_fields').submit(function()
    {
        var go_to_submit = true;

        $( ".form-group label" ).each(function() {
            $(this).css('color', '');
        });

        $( ".required" ).each(function()
        {
            if (!$.trim($(this).val()))
            {
                $(this).closest('.form-group').find('label').css('color', 'red');
                go_to_submit = false;
            }
        });


        $( ".required_ckeditor" ).each(function()
        {
            identificator = $(this).attr('name');

            var description = CKEDITOR.instances[identificator].getData().replace(/<[^>]*>/gi, '').length;
            if (!description)
            {
                $(this).closest('.form-group').find('label').css('color', '#ff460e');
                go_to_submit = false;
            }
        });


        $( ".select_required" ).each(function() {
            var count_selected_options =  $(this).find("option:selected").length;
            if(count_selected_options == 0)
            {
                $(this).closest('.form-group').find('label').css('color', '#ff460e');
                go_to_submit = false;
            }


        });

        if(go_to_submit == false)
        {
            alert("<?php echo dictionary('FILL_REQUIRED_FIELDS');?>");
        }

        return go_to_submit;
    });



    // prevent enter press on form submit
    $(document).ready(function() {
        $("form.disable_submit_form_on_enter_button").keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });

    function close_popUpGal()
    {
        $(".popUpBackground").removeClass("popUpBackground_active");
        $( ".popUpgltop" ).detach();
    }
</script>



<?php
//time and datetimepiker fucntions
/*
https://github.com/Eonasdan/bootstrap-datetimepicker
http://eonasdan.github.io/bootstrap-datetimepicker/#linked-pickers
*/?>
<script type="text/javascript">
    $(function() {

        $('#datetimepicker_default').datetimepicker({
            locale: 'ru',
            defaultDate: 'moment'
        });

        $('.datetimepicker_default').datetimepicker({
            locale: 'ru',
            defaultDate: 'moment'
        });


        $('#datetimepicker1').datetimepicker({
            locale: 'ru',
            minDate: 'moment'
        });

        $('#timepicker').datetimepicker({
            locale: 'ru',
            format: 'LT',
            pick12HourFormat: false
        });

        $('.timepicker').datetimepicker({
            locale: 'ru',
            format: 'LT'
        });

    });
</script>

<?php
// In caz de dorim sa folosim doar data in calendar, fara ora
?>
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function(){
        (function($) {
            $(document).ready(function() {
                $('.datetimepicker_only_date').datetimepicker({
                    locale: 'ru',
                    defaultDate: 'moment',
                    format: 'DD.MM.YYYY'
                });
            });
        })(jQuery);
    });
</script>



<?php // pentru taburi la adaugarea si editarea datelor ?>
<?php
if(isset($c_tab))
{
    ?>
    <script type="text/javascript">
        var num = parseInt('<?php echo $c_tab;?>') - 1;
        $(document).ready(function()
        {
            $('ul.tabs.tabs1 li').click(function(){
                if(!$(this).hasClass('tab-current'))
                {
                    var thisClass = this.className.slice(0,num);
                    for( c_n=1; c_n<=num; c_n++ ){
                        $('div.t'+c_n).hide();
                    }
                    $('div.' + thisClass).show();
                    $('ul.tabs.tabs1 li').removeClass('tab-current');
                    $(this).addClass('tab-current');
                }
            });
        });
    </script>
    <?php
}
?>



<script type="text/javascript">
    function addZero(i)
    {
        if (i < 10) { i = "0" + i; } return i;
    }
    var current_time, time;
    setInterval(function() {
        current_time = new Date();
        time = addZero(current_time.getHours()) + ":" + addZero(current_time.getMinutes()) + ":" + addZero(current_time.getSeconds());
        $('#cp_clock').text(time);
    }, 1000);
</script>

<script type="text/javascript">
    $( document ).on( "click", "button.element_status", function(){

        var current_form_bloc = $(this);
        var data = {};
        data['task'] = 'change_element_status';
        data['table'] = current_form_bloc.data('element_table');
        data['elem_id'] = parseInt(current_form_bloc.data('element_id'));
        data['current_status'] = parseInt(current_form_bloc.data('element_status'));

        $.ajax({
            type: "POST",
            context: current_form_bloc,
            url: "/cp_ajax_<?php echo $Main->lang;?>/",
            data: data,
            dataType: "json",
            success: function (ajax_data)
            {
                if (ajax_data.hasOwnProperty('status') && ajax_data['status'] == 1 )
                {
                    if (ajax_data.hasOwnProperty('new_element_status'))
                    {
                        if( ajax_data['new_element_status'] == 0 )
                        {
                            current_form_bloc.removeClass('btn-success');
                            current_form_bloc.addClass('btn-danger');
                            current_form_bloc.data('element_status', 0);
                            current_form_bloc.html("<?php echo dictionary('INACTIVE');?>");
                        }
                        else if( ajax_data['new_element_status'] == 1 )
                        {
                            current_form_bloc.removeClass('btn-danger');
                            current_form_bloc.addClass('btn-success');
                            current_form_bloc.data('element_status', 1);
                            current_form_bloc.html("<?php echo dictionary('ACTIVE');?>");
                        }

                    }
                }
                else
                {
                    alert("<?php echo dictionary('CP_ERROR_INSERT_DATA_IN_DB');?>");
                }
            }
        });

    });
</script>

<script type="text/javascript">
    var sp_block_counter = 0;
    function add_element_options_block()
    {
        var block_counter = sp_block_counter++;
        //console.log(block_counter);
        var data = {};
        data['task'] = 'add_element_options_block';
        data['block_counter'] = block_counter;

        $.ajax({
            type: "POST",
            url: "/cp_ajax_<?php echo $Main->lang;?>/",
            data: data,
            dataType: "html",
            success: function (content)
            {
                $("#element_options").prepend(content);
            }
        });
    }

    function remove_element_option_block(obj, id, table)
    {
        if(!confirm("<?php echo dictionary('CONFIRM_DELETE_ELEMENT');?>"))
        {
            return false;
        }

        if(id == 0)
        {
            $(obj).closest('.element_option_block').remove();
            return false;
        }

        var data = {};
        data['task'] = 'remove_element_options_block';
        data['id'] = parseInt(id);
        data['table'] = table;
        $.ajax({
            type: "POST",
            url: "/cp_ajax_<?php echo $Main->lang;?>/",
            data: data,
            context: obj,
            dataType: "json",
            success: function (ajax_data)
            {
                if (ajax_data.hasOwnProperty('status_info') && ajax_data['status_info'] == 1 )
                {
                    $(obj).closest('.element_option_block').remove();
                }
            }
        });
    }
</script>