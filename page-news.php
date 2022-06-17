<?php get_header(); ?>

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/common.css">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/post.css">


</head>

<body>
<?php get_template_part('parts_header'); ?>

<div class="tit_wrap">
  <h1 class="section_title">
    <span>ニュース</span>
    <div>NEWS</div>
  </h1>
</div>



<div id="main">
  <ul class="post_list">
  <?php
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;
  $args = array(
    'post_type' => array('post'),
    'post_status' => array('publish'),
    'order'=>'desc',
    'orderby'=>'post_date',
    'paged' => $paged,
    'posts_per_page' => 10
  );

  $query = new WP_Query($args);

  if ( $query->have_posts() ) :
  while ( $query->have_posts() ) : $query->the_post();
  ?>

  <li>
    <a href="<?php the_permalink() ?>">
      <div class="date"><?php the_time("Y.m.d"); ?></div>
      <h2><?php the_title(); ?></h2>
    </a>
  </li>


  <?php
  endwhile;
  endif; ?>


  </ul>


  <?php
  $big = 999999999;

  echo paginate_links(array(
    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
    'show_all' => true,
    'type' => 'list',
    'format' => '?paged=%#%',
    'current' => max(1, get_query_var('paged')),
    'total' => $query->max_num_pages,
    'prev_text' => '',
    'next_text' => '',
  ));
?>

</div>
<?php wp_reset_postdata(); ?>

<!--コンタクトエリア-->
<?php get_template_part('parts_contact'); ?>

<?php get_template_part('parts_footer'); ?>
<?php get_footer(); ?>