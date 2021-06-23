<?php

/**
 * Created by PhpStorm.
 * User: Nurit
 * Date: 23/04/2017
 * Time: 16:06
 */


/*
 * Class names naming-convention:
 * tb_prefix    ::= "tb_wc_"
 * object_type  ::= "order"/"item"/"product"
 * v            ::= "_v"
 * wc_version   ::= "2"/"3"
 * <tb_prefix><object_type>[<v><wc_version>]
 */
namespace tb_infra_1_0_11 {
	$class_name = __NAMESPACE__ . '\\tb_wc_product_v2';
	if ( ! class_exists ( $class_name ) ) {


		class tb_wc_product_v2 extends tb_wc_product {
			/**
			 * @return mixed
			 */
			public function get_id () {
				return $this->get_WC_product ()->id;
			}

			/**
			 * @param array $args
			 * @return mixed
			 */
			public function get_price_including_tax ( $args = array() ) {

				return $this->get_WC_product ()->get_price_including_tax ();
			}

			/**
			 * @param string $context
			 * @return mixed
			 */
			public function get_description ( $context = 'view' ) {
				return $this->get_WC_product ()->post->post_content;
			}

			/**
			 * @param string $context
			 * @return mixed
			 */
			public function get_short_description ( $context = 'view' ) {
				return $this->get_WC_product ()->post->post_excerpt;//short_description;
			}
		}
	}
}