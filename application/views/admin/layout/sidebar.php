<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?php echo base_url('public/admin_assets/dist/img/AdminLTELogo.png');?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
        <span class="brand-text font-weight-light">Moms Supper | Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="<?php echo base_url('public/admin_assets/dist/img/user2-160x160.jpg');?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="#" class="d-block"><?php echo $this->session->userdata['logged_admin_session']['logged_username'];?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="<?php echo base_url('Msa-Dashboard');?>" class="nav-link active">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="#Moms" class="nav-link change_" data-url ="<?php //echo base_url('Msa-Moms');?>">
                        <i class="nav-icon fa fa-th"></i>
                        <p>Moms</p>
                    </a>
                </li> -->
                <li class="nav-item has-treeview">
                    <a href="javascript:void(0);" class="nav-link change_"><i class="fa fa-users"></i>
                        <p>Moms<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#Moms" class="nav-link change_sub_link" data-url ="<?php echo base_url('Msa-Moms');?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>All Moms</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#Active-moms" class="nav-link change_sub_link" data-url ="<?php echo base_url('Msa-Moms/Active');?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Active Moms</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#Inctive-moms" class="nav-link change_sub_link" data-url ="<?php echo base_url('Msa-Moms/Inactive');?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Inactive Moms</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#Moms_menu" class="nav-link change_link" data-url ="<?php echo base_url('Msa-moms_menu');?>">
                        <i class="nav-icon fa fa-th"></i>
                        <p>Moms Menu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#Items" class="nav-link change_link" data-url ="<?php echo base_url('Msa-Items');?>">
                        <i class="nav-icon fa fa-th"></i>
                        <p>Items</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('Msa-Users');?>" class="nav-link">
                        <i class="nav-icon fa fa-th"></i>
                        <p>User's</p>
                    </a>
                </li> 
                <!-- <li class="nav-item has-treeview">
                    <a href="#" class="nav-link"><i class="nav-icon fa fa-pie-chart"></i>
                        <p>Member<i class="right fa fa-users"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p></p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/flot.html" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>Flot</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/inline.html" class="nav-link">
                          <i class="fa fa-circle-o nav-icon"></i>
                          <p>Inline</p>
                        </a>
                      </li>
                    </ul>
                </li> -->
            </ul>
        </nav><!-- /.sidebar-menu -->
    </div>
</aside><!-- /.sidebar -->