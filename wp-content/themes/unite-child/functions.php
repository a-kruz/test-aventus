<?php

/**
 * Add child theme enqueue styles:
 */
add_action( 'wp_enqueue_scripts', 'uct_enqueue_styles' );
function uct_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}


/**
 * Show Properties post type on Home page:
 */
add_action( 'pre_get_posts', 'uct_properties_to_query' );
function uct_properties_to_query( $query ) {

    if ( is_home() && $query->is_main_query() ) {
        $query->set( 'post_type', [ 'property' ] );
    }
    return $query;
}


/**
 * New ACF block for Gutenberg:
 */
add_action( 'acf/init', 'uct_custom_acf_blocks' );
function uct_custom_acf_blocks() {

    if( function_exists( 'acf_register_block_type' ) ) {

        // Register custom block type.
        acf_register_block_type(array(
            'name'              => 'agencies',
            'title'             => __('Агентства'),
            'description'       => __('Блок со списком агентств'),
            'render_template'   => 'blocks/block-agencies.php',
            'category'          => 'formatting',
        ));
    }
}


/**
 * Get properties by Ajax:
 */
add_action('wp_ajax_myfilter', 'uct_get_properties_by_ajax');
add_action('wp_ajax_nopriv_myfilter', 'uct_get_properties_by_ajax');

function uct_get_properties_by_ajax() {

    if (false !== ($property_list = get_transient( 'property_id_'.$_GET['property_id'] ))) {

        echo $property_list;

    } else {
        
        global $post;
        $args = [
            'post_type'   => 'property',
            'numberposts' => 10,
            'tax_query' => [
                [
                    'taxonomy' => 'agency',
                    'field' => 'term_id', 
                    'terms' => $_GET['property_id'],
                ]
            ]
        ];
        $my_properties = get_posts( $args );

        if ( $my_properties ) :

            foreach ($my_properties as $post) :
                setup_postdata($post);

                ob_start();
                get_template_part( 'content', 'properties' );
                $property_list .= ob_get_clean();

            endforeach;

            echo $property_list;
            set_transient( 'property_id_'.$_GET['property_id'], $property_list, 12 * HOUR_IN_SECONDS );

        else :
            echo 'Объявления в категории отсутствуют.';
        endif;

        wp_reset_postdata();
        
    }

    die();
}


/**
 * Add custom js scripts on Home page:
 */
add_action( 'wp_footer', 'uct_home_custom_js' );
function uct_home_custom_js() {

    if ( is_home() ) {
        ?>
        <script>
            let ajaxUrl = '/wp-admin/admin-ajax.php';
            let propertyLinks = document.querySelectorAll('.nav-link__property');

            [].forEach.call(propertyLinks, function(elem) {
                elem.addEventListener('click', function(e) {
                    
                    event.preventDefault();

                    if ( document.querySelector('.nav-link__property.active') ) {
                        document.querySelector('.nav-link__property.active').classList.remove('active');
                    }
                    elem.classList.add('active');

                    fetch(ajaxUrl + "?property_id=" + elem.getAttribute('data-term-id') + "&action=myfilter", { 
                            method: "GET", 
                            headers: {"content-type":"application/x-www-form-urlencoded"} 
                        })
                        .then( response => {
                            if (response.status !== 200) {
                                return Promise.reject(); 
                            }
                            return response.text();
                        })
                        .then(i => {
                            main.innerHTML = i;
                        })
                        .catch(() => console.log('error'));  

                }, false);
            });
        </script>
        <?php
    }
}