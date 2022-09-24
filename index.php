<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg'); ?>)"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Welcome to our place</h1>
    <div class="page-banner__intro">
      <p>Keep up with latest news.</p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">

  <?php
    while(have_posts( )) {
      the_post( ); //gets the appropriate data ready for each post
  ?>

    <div class="post-item">
      <h2><a href="<?php the_permalink(); ?>"><?php the_title( ) ;?></a></h2>
    </div>

    <div class="metabox">
      <p>posted by brad on 20.08.2022 in news</p>
    </div>

    <div class="generic-content">
      <p><?php the_excerpt( ); ?></p>
      <p><a class="btn btn--blue" href="<?php the_permalink( ); ?>">Continue reading</a></p>
    </div>
  <?php    
    }
  ?>

</div>

<?php get_footer(); ?>

