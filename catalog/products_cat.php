<?php
$catalog_info = $db
    ->where('id', $pageData['elem_id'])
    ->getOne('catalog');
if(!$catalog_info)
{
    $Cpu->page404();
    exit;
}

$curent_catalog_children = $Functions->getDirectoryChildren( $page_data['elem_id'], 'catalog');
array_unshift($curent_catalog_children, $page_data['elem_id']);

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
                    ->where('section_id', $curent_catalog_children, 'IN')
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
                    ->where('section_id', $curent_catalog_children, 'IN')
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
<div class="container-fluid">
    <div class="row row-fluid">
        <div class="col-sm-12">
            <section class="your-money yourmoney-one">
                <div class="container">
                    <div class="money-icon">
                        <span><img width="70" height="72" src="/css/images/phone-icon.png" alt="icon_money"></span>
                    </div>
                    <div class="money-content">
                        <h3 class="money-title">Оставьте заявку и мы свяжемся с Вами</h3>
                        <div class="money-entry-content">
                            или позвоните по телефону +7 495 269 09 10
                        </div>
                        <a class="noo-button trigger-form" href="#">Trimite cerere</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
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


