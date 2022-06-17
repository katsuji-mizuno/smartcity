<div id="pageWrapper">

<div class="js-loader">
  <div class="js-loader-progress">

    <?php if ( is_front_page() ): ?>
    <h1 class="load_logo">
      <img src="<?php bloginfo('template_directory'); ?>/assets/images/load.png" alt="Now Loading">
    </h1>
    <?php else : ?>
    <div class="load_logo">
      <img src="<?php bloginfo('template_directory'); ?>/assets/images/load.png" alt="Now Loading">
    </div>
  	<?php endif; ?>

    <div class="js-loader-progress-bar"></div>
    <div class="js-loader-progress-number"></div>
  </div>
</div>

<header id="siteHead" class="delayScroll">

    <div class="header_logo_wrap">
      <div class="header_logo">
        <a href="<?php echo home_url(); ?>/">
          <img src="<?php bloginfo('template_directory'); ?>/assets/images/header/logo_head.png" alt="スマートシティ">
        </a>
      </div>
    </div>

    <!-- ハンバーガーメニュー-->
    <div class="menu box">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <!-- gNav -->
    <nav id="gNav">
      <div class="gNav_inner">
        <ul>
          <li>
            <a href="<?php echo home_url(); ?>/">
              <span>トップページ</span>
              <div>TOP</div>
            </a>
          </li>
          <li>
            <a href="<?php echo home_url(); ?>/news/">
              <span>ニュース</span>
              <div>NEWS</div>
            </a>
          </li>
          <li>
            <a href="<?php echo home_url(); ?>/course/">
              <span>コース</span>
              <div>COURSE</div>
            </a>
          </li>
          <li>
            <a href="<?php echo home_url(); ?>/contact/">
              <span>コンタクト</span>
              <div>CONTACT</div>
            </a>
          </li>
        </ul>
      </div>
    </nav>


</header>