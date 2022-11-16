<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>

<section class="noo-page-heading">
    <div class="container">
        <h1 class="page-title"><?php echo $page_data['title'];?></h1>
    </div><!-- /.container-boxed -->
</section>
<div id="main" class="main-content container shop-container commerce">
    <!-- Begin The loop -->
    <div class="row">
        <?php require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/shop-stdebar-left.php'; ?>
        <div class="noo-main col-md-8">
            <div class="products row">
                <?php
                    $num_page = 12;
                    $totalObjects=0;
                    $start=0;
                    $perPage = $num_page;
                    if(!isset($_GET['page']) || !is_numeric($_GET['page'])){$page = 1;}else{$page = (int)$_GET['page'];}

                    $get_totalObjects = $db
                        ->where('active', 1)
                        ->get('catalog_elements');

                    if(count($get_totalObjects)>0)
                    {
                        $totalObjects = count($get_totalObjects);
                    }

                    $Count = $totalObjects;
                    $Pages = ceil($Count/$perPage); if($page>$Pages){$page = $Pages;}
                    $start = $page * $perPage - $perPage;
                    if($start<0) {$start = 0;}

                $get_all_catalog_elements = $db
                    ->orderBy('sort', 'asc')
                    ->where('active', 1)
                    ->get('catalog_elements',Array ($start, $perPage));
                if($get_all_catalog_elements && count($get_all_catalog_elements)>0)
                {
                    foreach ($get_all_catalog_elements as $element_info)
                    {
                        include $_SERVER['DOCUMENT_ROOT'].'/blocks/element.php';
                    }
                }
                else
                {
                    ?>
                    <div class="nothing_founded">
                        <?php echo dictionary('PRODUCTS_NOTHING_FOUNDED');?>
                    </div>
                    <?php
                }
                ?>
            </div>

            <!-- pagination -->
            <?php include $_SERVER['DOCUMENT_ROOT'].'/blocks/pagination.php'; ?>

        </div>
    </div>
    <!-- End The loop -->
</div> <!-- /.main -->

<?php include $_SERVER['DOCUMENT_ROOT'].'/blocks/contact_form_container.php';?>

<div class="container-fluid">
    <div class="row row-fluid pt-10 pb-2">
    </div>
</div>
<div class="container-fluid">
    <div class="row row-fluid pt-5">
    </div>
</div>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>


