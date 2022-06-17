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
  <div class="thanks">
   お問い合わせいただきありがとうございます。<br />
   内容を確認して担当者よりご連絡差し上げます。
  </div>

  <div class="back_top">
    <a href="<?php echo home_url(); ?>/">TOP</a>
  </div>


</div>


<?php get_template_part('parts_footer'); ?>
<?php get_footer(); ?>