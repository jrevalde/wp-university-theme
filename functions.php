<?php
    require get_theme_file_path('/includes/search-route.php'); //this is just to organise the file a bit better and not make it too crowded

    function university_custom_rest() { 
        register_rest_field('post', 'authorName', array(
            'get_callback' => function() {
                return get_the_author();
            }
        )); //first argument is post type, the second argument is whatever we want to name the new field, 3rd is an array that describes how we want to manage this field
    }

    //we want to create a new function that modifies the json response that WordPress gives back.
    add_action('rest_api_init', 'university_custom_rest');

    function university_files()
    {
        wp_enqueue_script('main-uni-js', get_theme_file_uri('build/index.js'), array('jquery'), '1.0', true);
        wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i" rel="stylesheet');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
        /* The second argument of this function looks for a file named style.css
        The first argument is the nickname of the style sheet and doesn't matter */

        wp_localize_script('main-uni-js', 'universityData', array(
            'root_url' => get_site_url()
        ));
    }

    function university_features()
    {
        register_nav_menu("footerLocationOne", "Footer Location One");
        register_nav_menu("footerLocationTwo", "Footer Location Two");
       //the second argument is what will actually showup in the wordpress admin screen
        add_theme_support('title-tag'); //this function enables a feature for your theme.
        add_theme_support('post-thumbnails');
        add_image_size('professorLandscape', 400, 260, true); //we adding custom sized image to our site that suits us. 
        add_image_size('professorPortrait', 400, 650, true); //a value of true crops the image towards the center
        add_image_size('pageBanner', 1500, 350, true);
    }

    function university_adjust_queries($query) {
        if(!is_admin( ) AND is_post_type_archive('program' ) AND is_main_query( )) {
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');
            $query->set('posts_per_page', -1);
        }
       
        if(!is_admin() AND is_post_type_archive('event') AND is_main_query( )) { //not adding if conditions applies the query universally which is bad.
            $today = date('Ymd');
            $query->set('meta_key', 'event_date');
            $query->set('orderby', 'meta_num_value');
            $query->set('order', 'ASC');
            $query->set('meta_query', array(
            array( 
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric' 
            )
            ));
        }
        
    }

    add_action('wp_enqueue_scripts', 'university_files');
    /*'wp_enqeue_scripts' tells wordpress we want to load some css or javascript.
    The second argument is the name of a function that we want to run.  */

    add_action('after_setup_theme', 'university_features');

    add_action('pre_get_posts', 'university_adjust_queries');