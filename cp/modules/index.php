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
                <div class="col-md-12 col-lg-12 col-sm-12 z1">
                    <div class="bx_wrapp">

                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('695'); ?>">
                                <div class="box_cirlce s1">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Doctori</div>
                            </a>
                        </div>

                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('696'); ?>">
                                <div class="box_cirlce s2">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Departamente</div>
                            </a>
                        </div>

              

                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL(760); ?>">
                                <div class="box_cirlce s3">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Preturi</div>
                            </a>
                        </div>

                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL(764); ?>">
                                <div class="box_cirlce s4">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Categorii Preturi</div>
                            </a>
                        </div>

                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('730'); ?>">
                                <div class="box_cirlce s5">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Recenzii</div>
                            </a>
                        </div>

                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('746'); ?>">
                                <div class="box_cirlce s6">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Faq</div>
                            </a>
                        </div>

                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('742'); ?>">
                                <div class="box_cirlce s7">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Faq Sectiuni</div>
                            </a>
                        </div>


                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('738'); ?>">
                                <div class="box_cirlce s8">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Premii și Recunoaștere</div>
                            </a>
                        </div>



                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL(756); ?>">
                                <div class="box_cirlce s9">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Galerie</div>
                            </a>
                        </div>

                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL(786); ?>">
                                <div class="box_cirlce s9">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">VIDEO Galerie</div>
                            </a>
                        </div>



                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL(233);?>?id=770">
                                <div class="box_cirlce s10">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Politica de confidențialitate</div>
                            </a>
                        </div>
                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL(233);?>?id=771">
                                <div class="box_cirlce s10">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Termeni de utilizare</div>
                            </a>
                        </div>
                        <?php /*
                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('462'); ?>">
                                <div class="box_cirlce s10">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Consultatii</div>
                            </a>
                        </div>

                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('462'); ?>">
                                <div class="box_cirlce s11">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Reduceri</div>
                            </a>
                        </div>

                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('462'); ?>">
                                <div class="box_cirlce s12">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Cadouri</div>
                            </a>
                        </div>

                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('462'); ?>">
                                <div class="box_cirlce s13">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Carduri de reducere</div>
                            </a>
                        </div>


                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('462'); ?>">
                                <div class="box_cirlce s14">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Blog</div>
                            </a>
                        </div>


                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('462'); ?>">
                                <div class="box_cirlce s15">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Blog Categorii</div>
                            </a>
                        </div>
                        */ ?>


                        <div class="box_module">
                            <a href="<?php echo $Cpu->getURL('707'); ?>">
                                <div class="box_cirlce s16">
                                    <div class="box_icon"></div>
                                </div>
                                <div class="box_title">Slider</div>
                            </a>
                        </div>





                    </div>

                </div>

                <?php include $_SERVER['DOCUMENT_ROOT'].'/cp/php/templates/right-sidebar.php'; ?>
            </div>
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