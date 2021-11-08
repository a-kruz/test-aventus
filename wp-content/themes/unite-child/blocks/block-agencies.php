<?php

$terms = get_terms( [
    'taxonomy' => 'agency',
    'number' => 10,
    'orderby' => 'name'
] );

if( $terms ) {

    echo '<ul class="nav flex-column">';
    foreach ($terms as $term) {
        echo '<li class="nav-item"><a class="nav-link nav-link__property" href="#" data-term-id="' . $term->term_id . '">' . $term->name . '</a></li>';
    }
    echo '</ul>';
}
