<?php get_header(); ?>
<!-- for Meta -->
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/common.css">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/contact.css">


<!-- for Page -->
</head>

<body>
<?php get_template_part('parts_header'); ?>

<div class="tit_wrap">
  <h1 class="section_title">
    <span>コンタクト</span>
    <div>CONTACT</div>
  </h1>
</div>


<div id="contact">
  <div class="message">
  以下の項目に記入の上、「SEND」ボタンをクリックしてください。
  </div>

<?php the_content(); ?>





</div>


<?php get_template_part('parts_footer'); ?>
<?php get_footer(); ?>