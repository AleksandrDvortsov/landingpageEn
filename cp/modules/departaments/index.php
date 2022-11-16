<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
require_once 'settings.php'; 

if($User->check_cp_authorization())
{

    include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/header.php';
    include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/left-sidebar.php';
    ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <?php $Cpu->top_block_info($cutpageinfo);?>

            <div class="row">
                <div class="col-md-9 col-lg-9 col-sm-9">
                    <div class="white-box">
                        <h3 class="box-title" style="float: left">Lista de departamente</h3>
                        <div class="label label-info label-rounded" style="float: right;">
                            <a style="color:white;font-size: 14px;" href="<?php echo $Cpu->getURL($ADD_ELEMENT_PAGE_ID);?>">
                                <?php echo dictionary('ADD');?>
                            </a>
                        </div>
                        <?php
                        $totalObjects=0;
                        $start=0;
                        $perPage = $num_page;
                        if(!isset($_GET['page']) || !is_numeric($_GET['page'])){$page = 1;}else{$page = (int)$_GET['page'];}


                        $get_totalObjects = $db
                            ->get($db_table);


                        if(count($get_totalObjects)>0)
                        {
                            $totalObjects = count($get_totalObjects);
                        }

                        $Count = $totalObjects;
                        $Pages = ceil($Count/$perPage); if($page>$Pages){$page = $Pages;}
                        $start = $page * $perPage - $perPage;
                        if($start<0) {$start = 0;}


                        ?>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Sort</th>
                                <th>Icon</th>
                                <th>Titlul</th>
                                <th>Adaugat pe data</th>
                                <th>Modificat pe data</th>
                                <th>Optiuni</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $get_table_info = $db
                                ->orderBy('sort','asc')
                                ->get($db_table,Array ($start, $perPage));
                            foreach ($get_table_info as $table_info)
                            {
                                $rw_id = $table_info['id'];



                                if ($table_info['updatedAt'] == null) {
                                    $updated_date = 'Nu a fost redactat';
                                }else {
                                    $updated_date = $table_info['updatedAt'];
                                }

                                $imagethumg = '';
                                $table_info_img = $db
                                    ->where('parent_id', $rw_id)
                                    ->getOne($db_table_icons, "id, image");

                               // show(array($rw_id,$table_info_img));

                                $image_path =  $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$db_table_icons.'/'.$table_info_img['image'];
                                if(isset($table_info_img['image']) && $table_info_img['image']!="" && is_file($image_path))
                                {
                                    $imagethumg = newthumbs( $table_info_img['image'] , $db_table_icons);
                                }
                                ?>

                                <tr>
                                    <td><?php echo $table_info['sort'];?></td>
                                    <td><img src="<?php echo $imagethumg; ?>" style="max-width: 30px;" alt=""></td>
                                    <td><?php echo $table_info['title_'.$lang];?></td>
                                    <td><?php echo $table_info['createdAt'];?></td>
                                    <td><?php echo $updated_date;?></td>
                                    <td class="table_td_a_button">
                                        <a href="<?php echo $Cpu->getURL($EDIT_ELEMENT_PAGE_ID);?>?id=<?php echo $table_info['id'] ?>">
                                            <button class="edit_button" type="button" title="Edit"></button>
                                        </a>
                                        <a href="<?php echo $Cpu->getURL($DELETE_ELEMENT_PAGE_ID);?>?id=<?php echo $table_info['id'] ?>" onclick="return confirm('<?php echo dictionary('CONFIRM_DELETE_ELEMENT');?>');">
                                            <button class="delete_button" type="button" title="Delete"></button>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="white-box">
                        <h5 class="text-center">
                            Departamente
                            (
                            <?php
                            $getstat = $db
                                ->get($db_table);
                            if(count($getstat) > 0 )
                            {
                                echo count($getstat);
                            }else{
                                echo  '0';
                            }
                            ?>
                            )
                        </h5>

                        <hr/>
                        <h5 class="text-center">
                            Departamente Active
                            (
                            <?php
                            $getstat = $db
                                ->where('active','1')
                                ->get($db_table);
                            if(count($getstat) > 0 )
                            {
                                echo count($getstat);
                            }else{
                                echo  '0';
                            }
                            ?>
                            )
                        </h5>

                        <hr/>
                        <h5 class="text-center">
                            Departamente Inactive
                            (
                            <?php
                            $getstat = $db
                                ->where('active','0')
                                ->get($db_table);
                            if(count($getstat) > 0 )
                            {
                                echo count($getstat);
                            }else{
                                echo  '0';
                            }
                            ?>
                            )
                        </h5>


                    </div>

                </div>
                <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/right-sidebar.php'; ?>
            </div>

            <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/include/pagination.php'; ?>
            <!-- /.container-fluid -->
            <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/footer.php'; ?>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    </body>

    </html>
    <?php
}
else
{
    header("location: ".$Cpu->getURL(5));
}
