<?php

function removeVarFromQueryString($varToRemove, $originalQs=null) {
    if (!$originalQs) {
        $originalQs = $_SERVER['QUERY_STRING'];
    }

    $params = [];
    parse_str($originalQs, $params);

    unset($params[$varToRemove]);
    return http_build_query($params);
}

$get_full_query_url = parse_url($_SERVER['REQUEST_URI']);

if(isset($_GET['page']))
{
    $cleand_query = removeVarFromQueryString("page", $get_full_query_url['query']);
}
else
    if(isset($get_full_query_url['query']))
    {
        $cleand_query = $get_full_query_url['query'];
    }
    else
    {
        $cleand_query = '';
    }


$generated_page_url = "";
if(empty($cleand_query))
{
    if($Pages>1)
    {
        $generated_page_url = "?page=";
    }
}
else
{
    if($Pages>1)
    {
        $generated_page_url = "?".$cleand_query."&page=";
    }
    else
    {
        $generated_page_url = "?".$cleand_query;
    }
}

$special_generated_page_url = '';
if(!empty($cleand_query))
{
    $special_generated_page_url = "?".$cleand_query;
}


//show($generated_page_url);

// paginator
if($Pages>1)
{
    if(isset($_GET['id'])){$idCond = "&id=".$id;}	else{$idCond = '';}
    $pagePrev = $page-1;
    if($pagePrev<1){$pagePrev = 1;}
    $pageNext = $page+1;
    if($pageNext>$Pages){$pageNext = $Pages;}


    // 1 block
    $Firstpart = '';
    if($page>4){
        $Firstpart = '<span><a href="'.$pageData['cpu'].$special_generated_page_url.'">1</a> <a class="nav_defaultStyle">...</a></span>';
    }

    // 3 block
    $Endpart = '';
    if( ($Pages - $page) > 3  ){
        $Endpart = ' <span><a class="nav_defaultStyle">...</a> <a href="'.$generated_page_url.$Pages.$idCond.'">'.$Pages.'</a></span>';
    }

    // 2 block
    $begin_row = $page - 2;
    if($Pages<5){$begin_row = 1;}
    if($begin_row < 1){
        $begin_row = 1;

        if($Pages - ($begin_row+4)<1){
            $Endpart = '';
        }
    }
    ?>

    <div class="bg-light-gray">
        <div class="wrapper">

            <nav class="nav-pagination">
                <?php if($page!=1){ ?>
                    <?php
                    if($pagePrev>1){
                        ?>
                        <a href="<?php echo $generated_page_url.$pagePrev.$idCond; ?>">Previous</a>
                        <?php
                    }else{
                        ?>
                        <a href="<?php echo $pageData['cpu'].$special_generated_page_url; ?>">Previous</a>
                    <?php } ?>

                <?php } ?>
                <span class="numbers">
                                        <?php echo $Firstpart; ?>
                    <?php for($i=$begin_row;($i<$begin_row+5 && $i <= $Pages);$i++) {

                        if($i==1){
                            ?>
                            <span <?php if($page==$i){ ?> class="current" <?php } ?>><a href="<?php echo $pageData['cpu'].$special_generated_page_url; ?>"><?php echo $i; ?></a></span>
                            <?php
                        }else{
                            ?>
                            <span <?php if($page==$i){ ?> class="current" <?php } ?>><a href="<?php echo $generated_page_url.$i.$idCond; ?>"><?php echo $i; ?></a></span>
                        <?php }
                    }?>
                    <?php echo $Endpart; ?>
                                    </span>
                <?php if($page < $pageNext){ ?>

                    <a class="pagtext" href="<?php echo $generated_page_url.$pageNext.$idCond; ?>">Next</a>

                <?php } ?>
            </nav>
        </div>
    </div>
<?php } ?>
