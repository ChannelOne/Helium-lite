<?php
foreach ($sidebar_list as $each_menu) {
    $menu_active = '';
    if (isset($choose) && $choose === $each_menu['id']) {
        $menu_active = 'active';
    }

    $menu_treeview = '';
    if (isset($each_menu['child'])) {
        $menu_treeview = 'treeview';
    }

    echo "<li class=\"{$menu_treeview} {$menu_active}\">";
    echo "<a href=\"{$each_menu['link']}\">";
    echo "<i class=\"fa {$each_menu['icon']}\"></i> ";
    echo "<span>{$each_menu['name']}</span>";

    echo '<span class="pull-right-container">';
    if (isset($each_menu['child'])) {
        echo '<i class="fa fa-angle-left pull-right"></i>';
    }
    if (isset($sidebar_count[$each_menu['id']]) && (int)$sidebar_count[$each_menu['id']] !== 0) {
        echo "<small class=\"label pull-right bg-blue\">{$sidebar_count[$each_menu['id']]}</small>";
    }
    echo '</span>';

    echo '</a>';

    if (isset($each_menu['child'])) {
         echo '<ul class="treeview-menu">';
        foreach ($each_menu['child'] as $each_child) {
            $sub_menu_active = '';
            if (isset($choose_sub) && $choose_sub === $each_child['id']) {
                $sub_menu_active = 'active';
            }

            echo "<li class=\"{$sub_menu_active}\">";
            echo "<a href=\"{$each_child['link']}\"><i class=\"fa {$each_child['icon']}\"></i>{$each_child['name']}</a>";
            echo "</li>";
        }
        echo '</ul>';
    }

    echo '</li>';
}
?>
