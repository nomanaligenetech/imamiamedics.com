<style>
li.active > a.text-yellow{ font-weight:bold !important;} /*color:#ffca1e !important; */
</style>
<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas" style="display:;">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url( $this->functions->_admincms_logged_in_details( "profile_image" ) );?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $this->functions->_admincms_logged_in_details("username");?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form" onsubmit="return false;">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..." autocomplete="off" />
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">

                        <?php
                        if (isset($admin_menus)) {
                            if ($admin_menus->num_rows() > 0) {
                                $html = '';
                                $admin_menus = $admin_menus->result_array();
                            
                                foreach ($admin_menus as $menu) {
                                    if (null != $menu['path']) {
                                        $link = site_url('admincms/'. $menu['path']);
                                    } else {
                                        $link = '#';
                                    }

                                    $html .= '<li class="treeview">';
                                    $html .= '<a href="'.$link.'">';
                                    $html .= $menu['parent'] == 0 ? '<i class="fa fa-bar-chart-o"></i>' : '';
                                    $html .= '<span>'.$menu['menu_title'].'</span>';
                                    $html .= $menu['parent'] == 0 ? '<i class="fa fa-angle-left pull-right"></i>' : '';
                                    $html .= '</a>';

                                    $child_menus = _admin_menu_child($menu['id']);

                                    if ($child_menus->num_rows() > 0) {
                                        $child_menus = $child_menus->result_array();

                                        $html .= '<ul class="treeview-menu">';

                                        foreach ($child_menus as $child_menu) {
                                            if (null != $child_menu['path']) {
                                                $link = site_url('admincms/' . $child_menu['path']);
                                            } else {
                                                $link = '#';
                                            }

                                            $html .= '<li>';
                                            $html .= '<a href="' . $link . '">';
                                            $html .= '<span>' . $child_menu['menu_title'] . '</span>';
                                            $html .= '</a>';
                                            $html .= '</li>';
                                        }

                                        $html .= '</ul>';
                                    }

                                    $html .= '</li>';
                                }
                            }
                        }

                        $html .= '<li>';
                        $html .= '<a href="'.site_url().'">';
                        $html .= '<span>Visit Site</span>';
                        $html .= '</a>';
                        $html .= '</li>';
                        
                        echo $html;
                        ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>