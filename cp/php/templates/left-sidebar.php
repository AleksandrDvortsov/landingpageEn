 <!-- Left navbar-header -->
 <?php
 $userInfo = $User->getUser($User->getId());
 ?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <div class="user-profile">
            <div class="dropdown user-pro-body">
                <div>
                    <?php
                    $user_profile_image  =  $_SERVER['DOCUMENT_ROOT'].'/uploads/cp_user_photo/'.$userInfo['image'];
                    if(isset($userInfo['image']) && trim($userInfo['image'])!="" && is_file($user_profile_image))
                    {
                        $user_profile_image_thumg = newthumbs( $userInfo['image'] , 'cp_user_photo', 100, 100, 10, 0);
                        ?>
                            <img src="<?php echo $user_profile_image_thumg;?>" alt="user-img" class="img-circle">
                        <?php
                    }
                    else
                    {
                        ?>
                            <img src="/cp/plugins/images/users/varun.jpg" alt="user-img" class="img-circle">
                        <?php
                    }
                    ?>

                </div>
                <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button"
                   aria-haspopup="true" aria-expanded="false"><?php echo $userInfo['first_name'].' '.$userInfo['last_name'];?><span class="caret"></span></a>
                <ul class="dropdown-menu animated flipInY">
                    <li><a href="<?php echo $Cpu->getURL(32);?>"><i class="ti-user"></i><span style="padding-left: 5px;"><?php echo dictionary('MY_PROFILE');?></span></a></li>
                    <?php
                    /*
                    <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                    <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                    <li role="separator" class="divider"></li>
                    */
                    ?>
                    <li><a href="<?php echo $Cpu->getURL(7);?>"><i class="fa fa-power-off"></i> <?php echo dictionary('LOG_OUT');?></a></li>
                </ul>
            </div>
        </div>
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
        <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
        </span></div>
                <!-- /input-group -->
            </li>

            <li class="nav-small-cap"><?php echo dictionary('MAIN_MENU');?></li>
            <?php
            $get_left_menu = $db->rawQuery ('
                                      Select 
                                              * 
                                      from 
                                      
                                            '.$db::$prefix.'pages  
                                                                                                                          
                                      where 
                                                show_on_left_menu = 1
                                            AND access <> ""
                                            AND cpu_parrent = 1
                                            
                                            AND
                                                  ( type = 0 OR type = 10 )
                                          
                                          ORDER BY sort desc
                                     ');

            if( $get_left_menu && count($get_left_menu)>0)
            {
                foreach ($get_left_menu as $left_menu)
                {
                    //show(array($left_menu['page'],$left_menu['sort'],$left_menu['cpu_parrent']));
                    //controlam daca e parinte, adica daca are subcategorii
                    // ca sa stim ce tip de meniu trebuie de afisat
                    $check_if_root_menu_have_children = $db
                        ->where("show_on_left_menu", 1)
                        ->where("cpu_parrent", $left_menu['id'])
                        ->where("access", "", "<>")
                        ->orderBy('sort', 'desc')
                        ->get("pages");

                    $group_menu_access_array = array();
                    $group_menu_access_array = explode(',', $left_menu['access']);

                    if($User->access_control($group_menu_access_array))
                    {
                        if (count($check_if_root_menu_have_children) > 0) {
                            ?>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="linea-icon linea-basic fa-fw" data-page_id="<?php echo $left_menu['id'];?>" data-icon="<?php echo @$left_menu['data_icon'];?>"></i>
                                    <span class="hide-menu">
                                        <?php echo $left_menu['title_' . $Main->lang]; ?>
                                    </span>
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo $Cpu->getURL($left_menu['id']); ?>">
                                            <?php echo $left_menu['title_' . $Main->lang]; ?>
                                        </a>
                                    </li>
                                    <?php
                                    foreach ($check_if_root_menu_have_children as $menu_children) {
                                        ?>
                                        <li>
                                            <a href="<?php echo $Cpu->getURL($menu_children['id']); ?>">
                                                <?php echo $menu_children['title_' . $Main->lang]; ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li>
                                <a href="<?php echo $Cpu->getURL($left_menu['id']); ?>" class="waves-effect">
                                    <i class="linea-icon linea-basic fa-fw" data-page_id="<?php echo $left_menu['id'];?>" data-icon="<?php echo @$left_menu['data_icon'];?>">

                                    </i>
                                    <span class="hide-menu"><?php echo $left_menu['title_' . $Main->lang]; ?></span>
                                </a>
                            </li>
                            <?php
                        }
                    }
                }
            }
            ?>



            <?php
            if($User->access_control( $client_access ) )
            {
                ?>
                <li>
                    <a href="<?php echo $Cpu->getURL(694); ?>" class="waves-effect">
                        <i class="  fa-fw ti-settings" data-icon=""></i>
                        <span class="hide-menu"><?php echo dictionary('MODULES_LEFT_MENU');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $Cpu->getURL(231); ?>" class="waves-effect">
                        <i class="linea-icon linea-basic fa-fw" data-icon=""></i>
                        <span class="hide-menu"><?php echo dictionary('FRONT_TEXT_PAGES');?></span>
                    </a>
                </li>
                <li class="nav-small-cap"><?php echo dictionary('SETTINGS');?></li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="linea-icon linea-basic fa-fw" data-icon="P"></i>
                        <span class="hide-menu">
                            <?php echo dictionary('GENERAL_SETTINGS');?>
                        </span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo $Cpu->getURL(9); ?>">
                                <?php echo dictionary('SITE_SETTINGS');?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $Cpu->getURL(3); ?>">
                                <span class="hide-menu"><?php echo dictionary('CONTROL_PANEL_DICTIONARY');?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php
            }
            ?>

            <li>
                <a href="<?php echo $Cpu->getURL(7);?>" class="waves-effect">
                    <i class="icon-logout fa-fw"></i>
                    <span class="hide-menu">
                        <?php echo dictionary('LOG_OUT');?>
                    </span>
                </a>
            </li>

        </ul>
    </div>
</div>
<!-- Left navbar-header end -->
