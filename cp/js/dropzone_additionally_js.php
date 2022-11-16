<?php // Dropzone - multi upload images ?>
<script type="text/javascript">
    Dropzone.autoDiscover = false;

    function remove_loaded_element_dropzone_image(obj)
    {
        x = confirm('Do you want to delete?');
        if (!x)  return false;
        $(obj).closest('.dz-image-preview').remove();
    }
</script>
