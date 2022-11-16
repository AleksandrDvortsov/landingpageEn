<?php
$page_data_element_id = 0;
if(isset($page_data['elem_id'])) {$page_data_element_id = $page_data['elem_id'];}
?>
<input type="hidden" name="ref_element_type" value="<?php echo $page_data['cat_id'];?>" />
<input type="hidden" name="ref_element_id" value="<?php echo $page_data_element_id;?>" />