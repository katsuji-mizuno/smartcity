<?php get_header(); ?>
<!-- for Meta -->
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/common.css">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/post.css">


<!-- for Page -->
</head>

<body>
<?php get_template_part('parts_header'); ?>

<div class="tit_wrap">
  <h1 class="section_title">
    <span>コース</span>
    <div>COURSE</div>
  </h1>
</div>


<div id="main">
  <ul class="post_list course">
      <?php
      $paged = get_query_var('paged') ? get_query_var('paged') : 1;
      $args = array(
        'post_type' => array('course'),
        'post_status' => array('publish'),
        'orderby' => array( 'meta_value' => 'DESC', 'date' => 'DESC' ),
        'paged' => $paged,
        'meta_key' => 'course_open',//ACFのフィールド名
        'posts_per_page' => 10
      );

      $query = new WP_Query($args);

      if ( $query->have_posts() ) :
      while ( $query->have_posts() ) : $query->the_post();
      ?>

      <?php $checkbox = get_field('course_open'); ?>
      <?php if ($checkbox && in_array('3', $checkbox)) : ?>

        <li>
          <a href="<?php the_permalink() ?>">
            <div class="status open">
              <?php
                // フィールドの設定と値をロード
                $field = get_field_object('course_open');
                $courses = $field['value'];

                // ラベルを表示
                if( $courses ): ?>
                <ul>
                <?php foreach( $courses as $course ): ?>
                <li class="<?php echo $field['choices'][ $course ]; ?>"><?php echo $field['choices'][ $course ]; ?></li>
                <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
            <h2><?php the_title(); ?></h2>
          </a>
        </li>
      <?php elseif ($checkbox && in_array('2', $checkbox)) : ?>
        <li>
          <a href="<?php the_permalink() ?>">
            <div class="status invite">
              <?php
                // フィールドの設定と値をロード
                $field = get_field_object('course_open');
                $courses = $field['value'];

                // ラベルを表示
                if( $courses ): ?>
                <ul>
                <?php foreach( $courses as $course ): ?>
                <li class="<?php echo $field['choices'][ $course ]; ?>"><?php echo $field['choices'][ $course ]; ?></li>
                <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
            <h2><?php the_title(); ?></h2>
          </a>
        </li>
      <?php elseif ($checkbox && in_array('1', $checkbox)) : ?>
        <li>
          <a href="<?php the_permalink() ?>">
            <div class="status end">
              <?php
                // フィールドの設定と値をロード
                $field = get_field_object('course_open');
                $courses = $field['value'];

                // ラベルを表示
                if( $courses ): ?>
                <ul>
                <?php foreach( $courses as $course ): ?>
                <li class="<?php echo $field['choices'][ $course ]; ?>"><?php echo $field['choices'][ $course ]; ?></li>
                <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
            <h2><?php the_title(); ?></h2>
          </a>
        </li>

      <?php endif; ?>
      <?php
  endwhile;
  endif; ?>

  </ul>


  <!-- ページネーション　----------------->
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