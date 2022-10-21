<?php

add_action('rest_api_init','universityRegisterSearch');

function universityRegisterSearch() {
    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE, //this is a wordpress constant that equals the value of 'GET'
        'callback' => 'universitySearchResults'
    )); //we use this to register a new route to WordPress
}

function universitySearchResults($data) {
    $mainQuery = new WP_Query(array(
        'post_type' => array('professor', 'page', 'post', 'program', 'event'), //wordpress makes it easy to query for multiple post types just by adding an array
        's' => sanitize_text_field($data['term']) //'s' stands for search. 'sanitize_text_field() is a function that sanitizes user input as an extra layer of protection.
    ));

    $results = array(       
        'generalInfo' => array(),
        'programs' => array(),
        'professors' => array(),
        'events' => array(),
    );

    while($mainQuery->have_posts()) {
        $mainQuery->the_post();
        if(get_post_type() == 'post' OR get_post_type() == 'page') {
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }
        if(get_post_type() == 'professors') {
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }
        if(get_post_type() == 'program') {
            array_push($results['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }
        if(get_post_type() == 'event') {
            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }
    }

    return $results;
}