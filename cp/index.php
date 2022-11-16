<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';

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
                <div class="col-md-12 col-lg-12 col-sm-12"></div>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/right-sidebar.php'; ?>
            </div>



            <?php
            $day_data = array();
            $limit_date_statistic = 30;
            $limit_date_statistic_QUERY = '';

            for($st_date = 0; $st_date <= $limit_date_statistic; $st_date++)
            {
                if($st_date == $limit_date_statistic)
                {
                    $limit_date_statistic_QUERY .= "
                                                SUM(date = CURDATE() - INTERVAL ".$st_date." DAY) as last_".$st_date."_days,
                                                (CURDATE() - INTERVAL ".$st_date." DAY) as last_".$st_date."_days_date
                                                ";
                }
                else
                {
                    $limit_date_statistic_QUERY .= "
                                                SUM(date = CURDATE() - INTERVAL ".$st_date." DAY) as last_".$st_date."_days,
                                                (CURDATE() - INTERVAL ".$st_date." DAY) as last_".$st_date."_days_date,
                                                ";
                }

            }

            if( $limit_date_statistic_QUERY != '' )
            {
                $get_visit_statistics = $db->rawQuery('
                                                       SELECT

                                                          '.$limit_date_statistic_QUERY.'
                                                  
                                                    FROM 
                                                          '.$db::$prefix.'visit_statistics 
                                                                                                                                                  
                                            ');
            }



            if($get_visit_statistics)
            {
                for($st_date = 0; $st_date <= $limit_date_statistic; $st_date++)
                {
                    $day_data[$st_date]['period'] = $get_visit_statistics[0]['last_'.$st_date.'_days_date'];
                    $day_data[$st_date]['vizitari'] = $get_visit_statistics[0]['last_'.$st_date.'_days'];
                }
            }
            else
            {
                $day_data[0]['period']="0";
                $day_data[0]['vizitari']=0;
            }

            ?>




            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><?php echo dictionary('CP_VISITOR_STATISTICS');?></h3>

                    <div id="graph"></div>
                </div>
            </div>

            <!-- /.container-fluid -->
            <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/footer.php'; ?>
        </div>
    <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    </body>

    <script src="/cp/plugins/bower_components/raphael/raphael-min.js"></script>
    <script src="/cp/plugins/bower_components/morris.js-0.5.1/morris.js"></script>
    <script src="/cp/plugins/bower_components/prettify/prettify.min.js"></script>
    <link rel="stylesheet" href="/cp/plugins/bower_components/prettify/prettify.min.css">
    <link rel="stylesheet" href="/cp/plugins/bower_components/morris.js-0.5.1/morris.css">
    <script type="text/javascript">

        var day_data = <?php echo json_encode($day_data); ?>;

        Morris.Area({
            element: 'graph',
            data: day_data,
            xkey: 'period',
            ykeys: ['vizitari'],
            labels: ['Vizitari']
        });

    </script>
    </html>
<?php
}
else
{
    header("location: ".$Cpu->getURL(5));
}