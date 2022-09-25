<?php
    function university_files()
    {
        wp_enqueue_script('main-uni-js', get_theme_file_uri('build/index.js'), array('jquery'), '1.0', true);
        wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i" rel="stylesheet');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
        /* The second argument of this function looks for a file named style.css
        The first argument is the nickname of the style sheet and doesn't matter */
    }

    function university_features()
    {
        register_nav_menu("footerLocationOne", "Footer Location One");
        register_nav_menu("footerLocationTwo", "Footer Location Two");
       //the second argument is what will actually showup in the wordpress admin screen
        add_theme_support('title-tag'); //this function enables a feature for your theme.
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