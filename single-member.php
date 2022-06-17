<?php get_header(); ?>

<!-- for Page -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/post.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/single.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/course.css">

</head>

<body>
<?php get_template_part('parts_header'); ?>


<div class="tit_wrap">
  <div class="section_title">
    <span>受講生ページ</span>
    <div>MEMBER PAGE</div>
  </div>
</div>

<div id="main" class="member">
  <div class="member_tit">
    <figure class="wp-block-pullquote" id="member"><blockquote><p>MEMBER PAGE</p></blockquote></figure>
  </div>

  <?php the_content(); ?>
  </div>
</div>

<?php get_template_part('parts_footer'); ?>
<?php get_footer(); ?>

