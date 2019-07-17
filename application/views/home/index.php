<?php $this->load->view('home/header.php'); ?>    
    <div class="sidebar">
        <div class="main-menu">
            <div class="scroll">
                <ul class="list-unstyled">

                    <?php
                        $ci = & get_instance();
                        $userdata = $ci->session->userdata;
                        $ci->load->model('admin/menus');
                        $table = $ci->menus;
                        $items = $table->getRoleMenu($userdata['user_id']);

                        $no = 1;
                    ?>
                    <?php foreach($items as $item):?>

                    <?php if($no == 1){ ?>
                    <li class="<?php echo $item['menu_url'];?> active">
                        <a href="<?php echo '#'.$item['menu_url'];?>">
                            <i class="<?php echo $item['menu_icon'];?>"></i> <?php echo $item['menu_title'];?>
                        </a>                        
                    </li>
                    <?php $no++; }else{ ?>
                    <li class="<?php echo $item['menu_url'];?>">
                        <a href="<?php echo '#'.$item['menu_url'];?>">
                            <i class="<?php echo $item['menu_icon'];?>"></i> <?php echo $item['menu_title'];?>
                        </a>                        
                    </li>
                    <?php } ?>
                    <?php endforeach; ?>   
                </ul>
            </div>
        </div>

        <div class="sub-menu">
            <div class="scroll">
                <?php foreach($items as $item):?>

                <ul class="list-unstyled" data-link="<?php echo $item['menu_url'];?>">

                    <?php
                        $ci = & get_instance();
                        $userdata = $ci->session->userdata;

                        $ci->load->model('admin/sub_menus');
                        $table2 = $ci->sub_menus;
                        $subitems = $table2->getRoleSubMenu($item['menu_id'], $userdata['user_id']);

                    ?>

                    <?php foreach($subitems as $subitem):?> 

                        <li class="nav-item" data-source="<?php echo $subitem['sub_data_source'];?>">
                            <a href="javascript:;">
                                <i class="<?php echo $subitem['sub_menu_icon'];?>"></i> <?php echo $subitem['sub_menu_title'];?>
                            </a>
                        </li>

                    <?php endforeach; ?>  

                </ul>

                <?php endforeach; ?>  

            </div>
        </div>
    </div>

    <main>
        <div class="container-fluid">       
            
            <div id="main-content"></div>

        </div>
    </main>

<?php $this->load->view('home/footer.php'); ?>
