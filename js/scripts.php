
<script type="text/javascript">
    var amc_root              =  '<?php echo $Cpu->getURL(100); ?>';
    var amc_page_id           =  '<?php echo $pageData["page_id"]; ?>';
    var amc_ajax              =  '/ajax_<?php echo $Main->lang;?>/';
    var amc_lang              =  '<?php echo $Main->lang;?>';
    var amc_hash              =  '';
</script>




<?php if($page_data['cat_id'] == 100)
{
    ?>
    <script type='text/javascript' src='/js/libs.min.js'></script>
    <?php
}
else
{
    ?>
    <script type='text/javascript' src='/js/jquery-1.11.1.min.js'></script>
    <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

    <!-- Wow Script -->
    <script src="/js/wow.js"></script>
    <!-- bootstrap -->
    <script src="/js/bootstrap.min.js"></script>
    <!-- bx slider -->
    <script src="/js/jquery.bxslider.min.js"></script>
    <!-- count to -->
    <script src="/js/jquery.countTo.js"></script>
    <!-- owl carousel -->
    <script src="/js/owl.carousel.min.js"></script>
    <!-- validate -->
    <script src="/js/validation.js"></script>
    <!-- mixit up -->
    <script src="/js/jquery.mixitup.min.js"></script>
    <!-- easing -->
    <script src="/js/jquery.easing.min.js"></script>
    <!-- gmap helper -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHzPSV2jshbjI8fqnC_C4L08ffnj5EN3A"></script>
    <!--gmap script-->
    <script src="/js/gmaps.js"></script>
    <script src="/js/map-helper.js"></script>
    <!-- fancy box -->
    <script src="/js/jquery.appear.js"></script>
    <!-- isotope script-->
    <script src="/js/isotope.js"></script>
    <script src="/js/jquery.prettyPhoto.js"></script>
    <script src="/js/jquery.bootstrap-touchspin.js"></script>
    <!-- jQuery timepicker js -->
    <script src="/assets/timepicker/timePicker.js"></script>
    <!-- Bootstrap select picker js -->
    <script src="/assets/bootstrap-sl-1.12.1/bootstrap-select.js"></script>
    <!-- Bootstrap bootstrap touchspin js -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>


    <!-- Language Switche -->
    <script src="/assets/language-switcher/jquery.polyglot.language.switcher.js"></script>
    <!-- Html 5 light box script-->
    <!-- revolution slider js -->
    <script src="/assets/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="/assets/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script src="/assets/revolution/js/extensions/revolution.extension.actions.min.js"></script>
    <script src="/assets/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
    <script src="/assets/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script src="/assets/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="/assets/revolution/js/extensions/revolution.extension.migration.min.js"></script>
    <script src="/assets/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
    <script src="/assets/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
    <script src="/assets/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="/assets/revolution/js/extensions/revolution.extension.video.min.js"></script>
    <?php
}
?>

<script src="/js/custom.js?v=<?php echo $css_version;?>"></script>

<script>

    $('select#sources').on('change', function() {
        alert( this.value );
    });
</script>

<script>

        $('a.scroll_to_bottom_form').bind('click', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: ($('#make_order_to_current_doctor').offset().top - 150)
            }, 1250, 'easeInOutExpo');
            event.preventDefault();
        });

</script>

<script type="text/javascript">
    function refreshCaptcha()
    {
        var data = {};
        data['task'] = 'refreshCaptcha';

        $.ajax({
            type: "POST",
            url: "/cp_ajax_<?php echo $lang;?>/",
            data: data,
            dataType: "json",
            success: function (image)
            {
                $("#captcha_code").attr('src',image);
            }
        });
    }
</script>

<script type="text/javascript">
    function loader_start()
    {
        $('#cssload-container').css('display', 'block');
    }

    function loader_stop()
    {

        setTimeout(function(){
            $('#cssload-container').css('display', 'none');
        },500)


    }


    function close_popUpGal()
    {
        if (!$('div.popUpgltop_dev').length)
        {
            $('body').css('overflow', 'auto');
            $(".popUpBackground").removeClass("popUpBackground_active");
            $( ".popUpgltop" ).detach();
        }
    }

    function close_popUpGal_with_refresh()
    {
        location.reload();
    }

    function remove_form_status_info(current_form_bloc)
    {
        current_form_bloc.find('.form_status_info').html('');
        current_form_bloc.find('.form_status_info').removeClass('form_status_info_error');
        current_form_bloc.find('.form_status_info').removeClass('form_status_info_success');

        current_form_bloc.find( ".form_status_info_neighbor" ).each(function()
        {
            $(this).remove();
        });
        current_form_bloc.find( ".form_status_info" ).remove();

    }

    function add_form_status_info(current_form_bloc)
    {
        $( "<div class='clear form_status_info_neighbor'></div><div class='form_status_info'></div><div class='clear form_status_info_neighbor'></div>").insertBefore( current_form_bloc.find("button.get_btn") );

    }
    function check_required_input_form(obj)
    {
        var continue_submiting = false;
        var current_form_bloc = $(obj);
        var error_array = [];
        var input_select_type_already_inserted = false;

        remove_form_status_info(current_form_bloc);

        current_form_bloc.find( ".required" ).each(function() {
            if(!$(this).val().trim())
            {
                if($(this).is('select') && input_select_type_already_inserted == false)
                {
                    error_array.push('select_options');
                    input_select_type_already_inserted = true;
                }
                else
                {
                    error_array.push($(this).attr('name'));
                }

            }
        });

        if (error_array.length != 0)
        {
            var data = {};
            data['task'] = 'return_form_required_input_info';
            data['error_array'] = error_array;
            $.ajax({
                type: "POST",
                context: current_form_bloc,
                url: "/ajax_<?php echo $Main->lang;?>/",
                data: data,
                dataType: "html",
                success: function (ajax_data)
                {
                    add_form_status_info(current_form_bloc);
                    current_form_bloc.find('.form_status_info').addClass('form_status_info_error');
                    current_form_bloc.find('.form_status_info').html(ajax_data);
                }
            });
        }
        else
        {
            continue_submiting = true;
        }


        return continue_submiting;
    }


    function check_required_input_form_type2(obj)
    {
        var continue_submiting = false;
        var current_form_bloc = $(obj);
        var error_array = [];


        current_form_bloc.find( ".required_field_info" ).each(function()
        {
            $(this).remove();
        });

        current_form_bloc.find( ".required" ).each(function() {
            if(!$(this).val().trim())
            {
                if($(this).is('select'))
                {
                    error_array.push($(this).attr('name') + ':selection_type');
                }
                else
                {
                    error_array.push($(this).attr('name'));
                }

            }
        });

        if (error_array.length != 0)
        {
            var data = {};
            data['task'] = 'return_form_required_input_info_type2';
            data['error_array'] = error_array;
            $.ajax({
                type: "POST",
                context: current_form_bloc,
                url: "/ajax_<?php echo $lang;?>/",
                data: data,
                dataType: "json",
                success: function (ajax_data)
                {
                    for ( var i = 0; i < ajax_data.length; i++ )
                    {
                        $( ajax_data[i]['html'] ).insertAfter( current_form_bloc.find("[name="+ajax_data[i]['field']+"]") );
                    }
                }
            });
        }
        else
        {
            continue_submiting = true;
        }


        return continue_submiting;
    }


    function remove_input_content(obj)
    {
        var current_form_bloc = $(obj);
        current_form_bloc.find( ":input:not([type=hidden])" ).each(function() {
            $(this).val('');
        })

        current_form_bloc.find(':checkbox').each(function() {
            this.checked = false;
        });
    }



    $(document).on('click','button.get_btn',function(e){
        e.preventDefault();
        var current_form_bloc = $(this).closest('form');
        var form_task = current_form_bloc.data("form_task");
        var form_type = parseInt(current_form_bloc.data("form_type"));
        var processed_field = false;
        if(form_type == 1)
        {
            processed_field = check_required_input_form(current_form_bloc);
        }
        else
        if(form_type == 2)
        {
            processed_field = check_required_input_form_type2(current_form_bloc);
        }
        else
        {
            return false;
        }

        if(processed_field)
        {
            loader_start();
            current_form_bloc.find('.get_btn').attr('disabled',true);
            var data = {};
            data['task'] = form_task;
            data['form_data'] = current_form_bloc.serialize() ;

            $.ajax({
                type: "POST",
                context: current_form_bloc,
                url: "/ajax_<?php echo $lang;?>/",
                data: data,
                dataType: "json",
                success: function (ajax_data)
                {
                    remove_form_status_info(current_form_bloc);
                    add_form_status_info(current_form_bloc);
                    loader_stop();
                    current_form_bloc.find('.get_btn').removeAttr('disabled');

                    if(form_task == 'appointment_records')
                    {
                        $('#appointment_records_ajax_messag_info').removeClass('status_info_error_k1');
                        $('#appointment_records_ajax_messag_info').removeClass('status_info_success_k1');
                    }
                   // current_form_bloc.find('.form_status_info').html(ajax_data);

                    if (ajax_data.hasOwnProperty('error') && ( ajax_data.hasOwnProperty('html') || ajax_data.hasOwnProperty('alert_message') ))
                    {
                        if(ajax_data['error'])
                        {
                            current_form_bloc.find('.form_status_info').addClass('form_status_info_error');
                            if(form_task == 'appointment_records')
                            {
                                $('#appointment_records_ajax_messag_info').addClass('status_info_error_k1');
                                $('#appointment_records_ajax_messag_info').html('');
                                for ( var i = 0; i < ajax_data['html'].length; i++ )
                                {
                                    $('#appointment_records_ajax_messag_info').append('<div>'+ajax_data['html'][i]+'</div>');
                                }
                            }
                            else
                            {
                                for ( var i = 0; i < ajax_data['html'].length; i++ )
                                {
                                    current_form_bloc.find('.form_status_info').append('<div>'+ajax_data['html'][i]+'</div>');
                                }
                            }


                            if(ajax_data.hasOwnProperty('alert_message') && ajax_data['alert_message'] != '')
                            {
                                alert(ajax_data['alert_message']);
                            }
                        }
                        else
                        {
                            current_form_bloc.find('.form_status_info').addClass('form_status_info_success');
                            if(form_task == 'appointment_records')
                            {
                                $('#appointment_records_ajax_messag_info').html('');
                                $('#appointment_records_ajax_messag_info').addClass('status_info_success_k1');
                                for ( var i = 0; i < ajax_data['html'].length; i++ )
                                {
                                    $('#appointment_records_ajax_messag_info').append('<div>'+ajax_data['html'][i]+'</div>');
                                }
                            }
                            else
                            {
                                for ( var i = 0; i < ajax_data['html'].length; i++ )
                                {
                                    current_form_bloc.find('.form_status_info').append('<div>'+ajax_data['html'][i]+'</div>');
                                }
                            }



                            remove_input_content(current_form_bloc);

                            if(ajax_data.hasOwnProperty('alert_message') && ajax_data['alert_message'] != '')
                            {
                                alert(ajax_data['alert_message']);
                            }

                        }
                    }

                    if(ajax_data.hasOwnProperty('reload_location') && ajax_data['reload_location'] === true)
                    {
                        location.reload();
                    }

                    if(ajax_data.hasOwnProperty('new_token_value') && ajax_data['new_token_value'] != '')
                    {
                        current_form_bloc.find('.form_token').val(ajax_data['new_token_value']);
                    }

                    if(ajax_data.hasOwnProperty('reload_location_to_main') && ajax_data['reload_location_to_main'] === true)
                    {
                        // reload_location_to_main to main page
                        document.location.href = "<?php echo $Cpu->getURL(100);?>";
                    }
                }
            });
        }
        return false;
    });


    function pop_up_form()
    {
        var data = {};
        data['task'] = 'pop_up_form';

        $.ajax({
            type: "POST",
            url: "/ajax_<?php echo $lang;?>/",
            data: data,
            dataType: "html",
            success: function (ajax_data)
            {
                $(".popUpBackground").addClass("popUpBackground_active");
                $('body').append(ajax_data);
            }
        });

    }
</script>


<script type="text/javascript">
    function subscribe_to_newsletter()
    {
        var newsletter_email = $('#newsletter_email').val();
        var data = {};
        data['task'] = 'subscribe_to_newsletter';
        data['newsletter_email'] = newsletter_email;

        $.ajax({
            type: "POST",
            url: "/ajax_<?php echo $lang;?>/",
            data: data,
            dataType: "json",
            success: function (ajax_data)
            {
                if (ajax_data.hasOwnProperty('error') && ajax_data['error']!="")
                {
                    alert(ajax_data['error']);
                }
                if (ajax_data.hasOwnProperty('success') && ajax_data['success'] == 1)
                {
                    $('#newsletter_email').val('');
                }
            }
        });
    }
</script>


<script type="text/javascript">
    function GetProductsAjaxfilter()
    {
        loader_start();
        var search_in_catalog = parseInt(<?php echo $pageData['elem_id'];?>);
        var selected_parameters = [];


        $( "input.checkbox_filter_elements:checkbox:checked" ).each(function() {
            selected_parameters.push($( this ).val());
        });

        $( "select.select_filter_elements option:selected" ).each(function() {
            if($(this ).val())
            {
                selected_parameters.push($(this ).val());
            }
        });

        //console.log(selected_parameters);

        var elements_IDS__of_current_tree = '';
        <?php
        if(isset($elements_IDS__of_current_tree))
        {
        ?>
        elements_IDS__of_current_tree = <?php echo json_encode($elements_IDS__of_current_tree)?>;
        <?php
        }
        ?>

        var price_min = $('#amount').val();
        var price_max = $('#amount2').val();

        var data = {};
        data['task'] = 'ajaxgetproductsbyfilter';
        data['elements_IDS__of_current_tree'] = elements_IDS__of_current_tree;
        data['selected_parameters'] = selected_parameters;
        data['price_min'] = price_min;
        data['price_max'] = price_max;

        $.ajax({
            type: "POST",
            url: "/ajax_<?php echo $lang;?>/",
            data: data,
            dataType: "html",
            success: function (ajax_data)
            {
                loader_stop();
                $("#ajax_product_block").html(ajax_data);
            }
        });
    }

</script>

<script type="text/javascript">
    function registration_window()
    {
        var data = {};
        data['task'] = 'registration_window';
        $.ajax({
            type: "POST",
            url: "/ajax_<?php echo $Main->lang;?>/",
            data: data,
            dataType: "html",
            success: function (ajax_data)
            {
                $('body').append(ajax_data);
                input_editor();
            }
        });
    }

    function login_window()
    {
        var data = {};
        data['task'] = 'login_window';
        $.ajax({
            type: "POST",
            url: "/ajax_<?php echo $Main->lang;?>/",
            data: data,
            dataType: "html",
            success: function (ajax_data)
            {
                $('body').append(ajax_data);
                input_editor();
            }
        });
    }

</script>






<script type="text/javascript">
    function uloginXHR(jqXHR)
    {
        $('#reg_error_info').html('');
        var data = {};
        data['task'] = 'UloginRegistration';
        data['jqXHR'] = jqXHR;

        $.ajax({
            type: "POST",
            url: "/ajax_<?=$Main->lang?>/",
            data: data,
            dataType: "json",
            success: function (ajax_data)
            {
                if (ajax_data.hasOwnProperty('success') )
                {
                    if(ajax_data['success'])
                    {
                        location.reload();
                    }
                    else
                    {
                        if (ajax_data.hasOwnProperty('html') && ajax_data['html'].length>0 )
                        {
                            for(i=0; i<ajax_data['html'].length;i++)
                            {
                                $('#reg_error_info').append("<div>" + ajax_data['html'][i] + "</div>");
                            }
                        }

                    }
                }
            }
        });
    }


    function my_ulogin_callback(token)
    {
        $.ajax({
            url: 'http://ulogin.ru/token.php',
            type: 'GET',
            dataType:'jsonp',
            data: {'token': token, 'host': encodeURIComponent(location.toString())},
            success: function (jqXHR,status)
            {
                if(status=="success")
                {
                    var responseText = jQuery.parseJSON(jqXHR);
                    uloginXHR(responseText);
                }
            }
        });
    }
</script>

<script>
    function ajax_dinamic_packets(dep_id)
    {
        var data = {};
        data['task'] = 'ajax_dinamic_packets';
        data['dep_id'] = dep_id;
        $.ajax({
            type: "POST",
            url: "/ajax_<?php echo $Main->lang;?>/",
            data: data,
            dataType: "html",
            success: function (ajax_data)
            {
                $('#ajax_dinamic_packets').html(ajax_data);
                madicalCarousel();
            }
        });
    }

    function ajax_dinamic_doctors(dep_id)
    {
        var data = {};
        data['task'] = 'ajax_dinamic_doctors';
        data['dep_id'] = dep_id;
        $.ajax({
            type: "POST",
            url: "/ajax_<?php echo $Main->lang;?>/",
            data: data,
            dataType: "html",
            success: function (ajax_data)
            {
                $('#ajax_dinamic_doctors').html(ajax_data);
                doktors_block_owlCarousel();
            }
        });
    }

</script>


<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>


























































<?php
if($User->check_cp_authorization())
{
  ?>
    <script type="text/javascript">
        function change_dictionary_input_value(id, field, value)
        {
            var data = {};
            data['task'] = 'change_dictionary_input_value';
            data['id'] = id;
            data['field'] = field;
            data['value'] = value;

            $.ajax({
                type: "POST",
                url: "/cp_ajax_<?php echo $lang;?>/",
                data: data,
                dataType: "json",
                success: function (msg)
                {
                    if(msg!="") alert(msg);
                }
            });
        }

        $(document).on('click', "img.editor_access_block", function (event) {
            if( typeof $(event.target).data('word_change_code') !== 'undefined' )
            {
                var data = {};
                data['task'] = 'content_editor';
                data['type'] = 'dictionary_code';
                data['code'] = $(event.target).data('word_change_code');
                $.ajax({
                    type: "POST",
                    url: "/ajax_<?php echo $Main->lang;?>/",
                    data: data,
                    dataType: "html",
                    success: function (ajax_data)
                    {
                        $(".popUpBackground").addClass("popUpBackground_active");
                        $('body').append(ajax_data);
                    }
                });
            }
        });

        $( document ).ready(function() {
            $('input, textarea, select').each(
                function(){
                    var initial_placeholder_value = $(this).attr('placeholder');
                    console.log(initial_placeholder_value);
                    // For some browsers, `attr` is undefined; for others, `attr` is false.  Check for both.
                    if (typeof initial_placeholder_value !== typeof undefined && initial_placeholder_value !== false)
                    {
                        var hasTagImg = !!$('<div />').html(initial_placeholder_value).find('img').length;
                        if(hasTagImg)
                        {
                            var clone_initial_placeholder_value = initial_placeholder_value;
                            var first_part_text_block =clone_initial_placeholder_value.substring(0,clone_initial_placeholder_value.lastIndexOf("<img") );
                            var last_part_image_block = clone_initial_placeholder_value.substring(clone_initial_placeholder_value.lastIndexOf("<img") );

                            $(this).attr('placeholder',first_part_text_block);
                            console.log(first_part_text_block);
                            $( last_part_image_block ).insertBefore( $(this) );
                        }

                    }

                }
            );

            /*
            $( "img.editor_access_block" ).each(function( index, element ) {
                var current_block = $(this);
                if( current_block.parent('a').length === 1)
                {
                    //$( element ).insertAfter( $(this).parent().parent() );

                }
            });
            */

        });

        $(function () {
            $("#btnEnableDisable").click(function () {
                if ($(this).val() == "Disable links") {
                    $(this).val("Enable links");
                    $("a").each(function () {
                        $(this).attr("rel", $(this).attr("href"));
                        $(this).attr("href", "javascript:;");
                    });
                } else {
                    $(this).val("Disable links");
                    $("a").each(function () {
                        $(this).attr("href", $(this).attr("rel"));
                        $(this).removeAttr("rel");
                    });
                }
            });
        });

    </script>
    <?php
}
?>




