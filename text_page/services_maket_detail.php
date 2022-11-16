<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/cp/class/include.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
?>

    <section class="breadcrumb-area" style="background-image: url(/images/resources/breadcrumb-bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <h1><?php echo dictionary('HEADER_SERVIE_PRICE');?></h1>
                        <div class="text-desc">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus ut aliquam illo sed tempora, unde veniam incidunt consequuntur placeat eligendi animi facere voluptate consectetur alias non impedit tenetur reprehenderit quaerat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="left pull-left">
                            <ul>
                                <li><a href="<?php echo $Cpu->getURL(100);?>"><?php echo dictionary('HEADER_HOME_PAGE'); ?></a></li>
                                <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                                <li class="active"><?php echo dictionary('HEADER_SERVIE_PRICE');?></li>
                            </ul>
                        </div>
                        <div class="right pull-right">
                            <a href="#">

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End breadcrumb area-->
    <!--Start faq content area-->
    <section class="faq-content-area services-detaills">
        <div class="container">
            <div class="row">
                <!--Start single box-->
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-detail">
                    <h2>Описание</h2>
                    <p>Блефаропластика представляет собой вид хирургической операции, в результате которой устраняются жировые и кожные излишки в зоне верхнего либо нижнего века. Стоит отметить, что форму глаз возможно изменить, воспользовавшись макияжем. Избавиться от морщинок можно посредством массажа. Но, когда необходимо кардинально изменить форму глаз, скорректировать разрез и сделать лицо моложе, то сложно обойтись без блефаропластики.</p>
                    <h2>В каких случаях проводится блефаропластика?</h2>
                   <p> Как известно, чем старше становится человек, тем больше кожа теряет эластичные свойства. В дальнейшем это ведет к снижению тонуса, увеличению количества подкожного жира в области век. Подобные процессы отмечаются после 30-летнего возраста. Если имеется генетическая предрасположенность к преждевременному старению, необходимость в проведении блефаропластики может появиться раньше. </p>

<p>Стоит отметить, что помимо возрастных изменений кожи, на ее состояние влияют и такие факторы, как активность мимических мышц, гравитация, пагубные привычки, стрессы, недосыпания.</p>
                </div>
                <!--End single box-->
            </div>
             <div class="service-plan team-area">
                        <div class="sec-title">
                            <h1>Doktors</h1>
                            <span class="border"></span>
                        </div>
                        <div class="row">
             <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="single-team-member">
                           <div class="img-holder">
             <img src="/uploads/doctors_images/thumbs/version_721/5b990886206a1.jpg" alt="Prof. Dr. Carmen Monica Pop">
                                            <div class="overlay-style">
                                                <div class="box">
                                                    <div class="content">
                                                        <div class="top">
                                                            <h3>Prof. Dr. Carmen Monica Pop</h3>
                                                            <span>Obstetrică și Ginecologie</span>
                                                        </div>
                                                        <span class="border"></span>
                                                        <div class="bottom">
                                                            <ul>
                                                                <li>
                                                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                                                    <a class="link-btn-doctor" href="/echipa/prof-dr-carmen-monica-pop/">
                                                                        Detalii                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-holder">
                                                <h3>Prof. Dr. Carmen Monica Pop</h3>
                                                <span>Obstetrică și Ginecologie</span>
                                            </div>
                                        </div>
                                    </div>
                     </div>
             </div>
           </div>
           <?php
            require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/form_doctor_k1.php';
        ?>
   </div>
       
    </section>
  




<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
?>