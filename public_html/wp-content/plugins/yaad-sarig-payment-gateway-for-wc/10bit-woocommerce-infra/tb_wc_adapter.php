<?php
/**
 * Created by PhpStorm.
 * User: Nurit
 * Date: 23/04/2017
 * Time: 16:06
 */
namespace tb_infra_1_0_11{
//Base classes:
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_object.php');
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_order.php');
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_product.php');
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_item.php');

//Woocommerce 2.X
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_order_v2.php');
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_product_v2.php');
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_item_v2.php');
//Woocommerce 3.X
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_order_v3.php');
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_product_v3.php');
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_item_v3.php');
//Woocommerce 4.X
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_order_v4.php');
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_product_v4.php');
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_item_v4.php');
//Woocommerce 5.X
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_order_v5.php');
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_product_v5.php');
    require_once(plugin_dir_path(__FILE__) . 'class_tb_wc_item_v5.php');
}