<?php get_header(); ?>


<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/common.css">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/post.css">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/single.css">

</head>

<body>
<?php get_template_part('parts_header'); ?>

<div class="tit_wrap">
  <div class="section_title">
    <span>ニュース</span>
    <div>NEWS</div>
  </div>
</div>

<div id="main">
  <div class="date"><?php the_time("Y.m.d"); ?></div>
  <h1><?php the_title(); ?></h1>
  <?php the_content(); ?>
</div>


<div class="single_pager">
  <div class="to_prev"><?php previous_post_link('%link', 'PREV'); ?></div>
  <div class="to_list"><a href="<?php echo home_url(); ?>/news/">BACK TO LIST</a></div>
  <div class="to_next"><?php next_post_link('%link', 'NEXT'); ?></div>
</div>

<?php get_template_part('parts_footer'); ?>
<?php get_footer(); ?>