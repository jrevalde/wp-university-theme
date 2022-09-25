<h1><?php get_header(); ?></h1>

<?php while(have_posts()) {
        the_post();
?>
       
       <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg'); ?>)"></div>
                <div class="page-banner__content container container--narrow">
                <h1 class="page-banner__title"><?php the_title(); ?></h1>
                <div class="page-banner__intro">
                <p>Replace this later with custom field.</p>
                </div>
                </div>
        </div>

      <div class="container container--narrow page-section">

        <div class="metabox metabox--position-up metabox--with-home-link">
          <p>
            <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to Blogs list</a> 
            <span class="metabox__main">posted by <?php the_author_posts_link( ); ?> on <?php the_time('n.j.y' ); ?> in <?php echo get_the_category_list(', ') ?></span>
          </p>
        </div>
        
        <div class="generic-content"><?php the_content(); ?></div>
        
      </div>

<?php 
    }
?>

<?php get_footer();?>