<?php
include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/header.php';
include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/left-sidebar.php';
?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div style="clear:both;height: 25px;"></div>
            <div style='color: #f16e48;'><?php echo dictionary('ERRORS_IN_URL_ADDRESS');?></div>
            <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/right-sidebar.php'; ?>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/footer.php'; ?>
    </div>
    </div>
