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
    <span>コース</span>
    <div>COURSE</div>
  </div>
</div>

<div id="main">
  <div class="course_menu">
    <ul>
      <li><a href="#theme">テーマ<span>THEME</span></a></li>
      <li><a href="#lecturers">講師陣<span>LECTURERS</span></a></li>
      <li><a href="#schedule">スケジュール<span>SCHEDULE</span></a></li>
      <li><a href="#guidelines">募集要項<span>GUIDELINES</span></a></li>
      <li><a href="#member">メンバー専用ページ<span>MEMBER PAGE</span></a></li>
    </ul>
  </div>

  <?php the_content(); ?>
  </div>
</div>

<?php get_template_part('parts_footer'); ?>
<?php get_footer(); ?>