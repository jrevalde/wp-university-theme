<h1><?php get_header(); ?></h1>
<?php while(have_posts()) {
        the_post();
?>
        <h2><?php the_title(); ?></h2>
        <p><?php the_content(); ?></p>
<?php 
    }
?>

<?php get_footer();?>