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
    if($page>3){

         $Firstpart = '<li><a href="'.$pageData['cpu'].$special_generated_page_url.'">1</a></li><li><a>...</a></li>';
    }

    // 3 block
    $Endpart = '';
    if( ($Pages - $page) > 2  ){
        $Endpart = '<li><a>...</a></li><li><a href="'.$generated_page_url.$Pages.$idCond.'">'.$Pages.'</a></li>';
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

    <div class="clear"></div>
    <div class="row">
        <div class="col-md-12">
            <ul class="post-pagination text-center">
                <?php if($page!=1)
                {
                    if($pagePrev>1)
                    {
                        ?>
                        <li>
                            <a href="<?php echo $generated_page_url.$pagePrev.$idCond;?>">
                                <i class="fa fa-caret-left" aria-hidden="true"></i>
                            </a>
                        </li>

                        <?php
                    }
                    else
                    {
                        ?>
                        <li>
                            <a href="<?php echo $pageData['cpu'].$special_generated_page_url;?>">
                                <i class="fa fa-caret-left" aria-hidden="true"></i>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>


                <?php
                echo $Firstpart;
                for($i=$begin_row;($i<$begin_row+5 && $i <= $Pages);$i++)
                {
                    if($i==1)
                    {
                        ?>
                        <li class="<?php if($page==$i){ ?> active <?php } ?>">
                            <a <?php if($page!=$i){ ?> href="<?php echo $pageData['cpu'].$special_generated_page_url; ?>" <?php } ?>>
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php
                    }
                    else
                    {
                        ?>
                        <li class="<?php if($page==$i){ ?> active <?php } ?>">
                            <a <?php if($page!=$i){ ?> href="<?php echo $generated_page_url.$i.$idCond; ?>" <?php } ?>>
                                <?php echo $i;?>
                            </a>
                        </li>
                        <?php
                    }
                }
                echo $Endpart; ?>

                <?php
                if($page < $pageNext)
                {
                    ?>
                    <li>
                        <a href="<?php echo $generated_page_url.$pageNext.$idCond; ?>">
                            <i class="fa fa-caret-right" aria-hidden="true"></i>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
<?php } ?>
