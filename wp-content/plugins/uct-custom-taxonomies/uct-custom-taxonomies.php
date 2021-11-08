<?php
/**
 * Plugin Name: UCT Custom Taxonomies
 * Description: Добавляет новую таксономию - Агентства
 * Author:      Alex Kruz
 * Version:     1.0
 *
 * Requires at least: 5.8
 * Requires PHP: 7.0
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */


/** 
 * Add new custom taxonomy: Агентства.
 */
add_action( 'init', 'uct_register_my_taxes_agency' );
function uct_register_my_taxes_agency() {

	$labels = [
		"name" => __( "Агентства", "unitechild" ),
		"singular_name" => __( "Агентство", "unitechild" ),
		"all_items" => __( "Все Агентства", "unitechild" ),
		"add_new_item" => __( "Добавить новое Агентство", "unitechild" ),
	];

	$args = [
		"label" => __( "Агентства", "unitechild" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'agency', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "agency",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "agency", [ "property" ], $args );
}