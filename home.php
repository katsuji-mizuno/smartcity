<?php get_header(); ?>
<!-- for Meta -->
<meta name="description" content='東京大学大学院　新領域創成科学研究科　スマートシティスクール'>
<meta name="keywords" content="東京大学大学院,新領域創成科学研究科,スマートシティスクール">

<!-- for Page -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/js/slick/slick-theme.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/js/slick/slick.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/common.css">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/home.css">

</head>


<body>
<?php get_template_part('parts_header'); ?>


<!--メイン画像-->
<div id="heat-map">
  <div class="main_visual">
    <div class="logo_wrap">
      <h1><img class="change" src="<?php bloginfo('template_directory'); ?>/assets/images/top/mv_pc.png" alt="東京大学大学院　新領域創成科学研究科　スマートシティスクール"></h1>
    </div>
  </div>
</div>

<div class="content">

  <!-- コース -->
  <section id="course">
    <div class="course_wrap">
      <div class="course_image">
        <img src="<?php bloginfo('template_directory'); ?>/assets/images/top/course_image.png" alt="">
      </div>
      <div class="course_links">
        <h2 class="section_title">
          <span>コース</span>
          <div>COURSE</div>
        </h2>
        <div class="top_line_wrap_wrap">
          <div class="top_line_wrap">
            <div class="top_line">
            </div>
          </div>
        </div>


        <div class="course_text">
        現在、開催中または募集中のコースです。<br />
        ご応募はコースの詳細からご覧下さい。
        </div>

        <div class="post_content_wrap">

          <ul class="post_list course">
            <?php
              $paged = get_query_var('paged') ? get_query_var('paged') : 1;
              $args = array(
                'post_type' => array('course'),
                'post_status' => array('publish'),
                'orderby' => array( 'meta_value' => 'DESC', 'date' => 'DESC' ),
                'paged' => $paged,
                'meta_key' => 'course_open',//ACFのフィールド名
                'posts_per_page' => -1
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

              <?php endif; ?>

              <?php endwhile; else: ?>
              <?php endif; ?>
          </ul>

          <div class="link_more">
            <a href="<?php echo home_url(); ?>/course/">READ MORE</a>
          </div>
        </div>
      </div>
  </section>

  <!--お知らせ-->
  <section id="news">
    <div class="news_wrap">
      <h2 class="section_title">
        <span>ニュース</span>
        <div>NEWS</div>
      </h2>
      <div class="top_line_wrap full">
        <div class="top_line"></div>
      </div>

      <div class="post_news_wrap">
        <ul class="post_list">
          <?php
          $paged = get_query_var('paged') ? get_query_var('paged') : 1;
          $args = array(
            'post_type' => array('post'),
            'post_status' => array('publish'),
            'order'=>'desc',
            'orderby'=>'post_date',
            'paged' => $paged,
            'posts_per_page' => 3
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
        <div class="link_more">
          <a href="<?php echo home_url(); ?>/news/">READ MORE</a>
        </div>
      </div>
    </div>
  </section>

  <!--ご挨拶-->
  <section id="greeting">
    <h2 class="section_title">
      <span>ご挨拶</span>
      <div>GREETING</div>
    </h2>
    <div class="top_line_wrap full">
      <div class="top_line"></div>
    </div>

    <div class="greeting_wrap">
      <div class="greeting_set">
        <div class="greeting_image"><img src="<?php bloginfo('template_directory'); ?>/assets/images/top/photo_fujii.jpg" alt="藤井 輝夫"></div>
        <div class="greeting_text">
          <div class="greeting_job">
            <span>東京大学 総長</span>
            <p>藤井 輝夫</p>
          </div>
          <div class="modal_open_btn"><a class="modal-open">READ MORE</a></div>

          <div id="Modal" class="modal">
            <div class="modal-wrap">
              <div class="modal-bg"></div>
              <div class="modal-box">
                <div class="inner">
                  <p>東京大学では、大学院新領域創成科学研究科による新しい社会人教育プログラム「スマートシティスクール」を立ち上げることになりました。<br />
                  昨今の新型コロナウイルス感染症拡大をはじめ、気候変動問題など、人類社会はいま地球規模の課題に直面しており、世界各所で社会の分断や格差の問題が露わになってきています。このような時代にあればこそ、私達は、人々の間の様々な差異を乗り越えて、一人一人のwell-beingを実現しうるような未来社会を創ることが求められています。<br />
                  スマートシティの推進は、そのために我々がとるべき最も重要なテーマの一つであり、それを担う人材の育成は急務です。「スマートシティスクール」は、学位プログラムや教養を身に着ける講座といったこれまでの東京大学でのリカレント教育とは異なる、スマートシティ構築のために必要なものの考え方や仕事の進め方に焦点を絞ったプログラムです。<br />
                  このスクールで学んだ社会人の中から、スマートシティ構築を通して未来の日本をけん引し、DXあるいはGXを引き起こしていく卓越した人材が輩出されることを願っています。また同時に、こうした新しい社会人リカレント教育の場が、受講生の皆さんとともに社会課題解決に取り組むことができるような双方向の交流の場となることを期待しています。</p>
                  <div class="modal_sign">
                    <div class="modal_sign_inner">
                      <span>東京大学 総長</span>
                      <h3>藤井 輝夫</h3>
                    </div>
                  </div>
                  <div class="modal-close">
                    <span><img src="<?php bloginfo('template_directory'); ?>/assets/images/top/btn_close.png" alt="Close"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="greeting_set">
        <div class="greeting_image"><img src="<?php bloginfo('template_directory'); ?>/assets/images/top/photo_deguchi.jpg" alt="出口 敦"></div>
        <div class="greeting_text">
          <div class="greeting_job">
            <span>東京大学大学院 新領域創成科学研究科長</span>
            <p>出口 敦</p>
          </div>

          <div class="modal_open_btn"><a class="modal2-open">READ MORE</a></div>

          <div id="Modal2" class="modal2">
            <div class="modal2-wrap">
              <div class="modal2-bg"></div>
              <div class="modal2-box">
                <div class="inner">
                  <p>都市・地域のデジタルトランスフォーメーション（DX）を進め、地域が抱える課題解決や新たな価値創造につなげていくスマートシティの取組は、世界的な潮流となっていますが、自治体・企業・地域団体等によるスマートシティを推進し、進化させる担い手の育成が喫緊の課題となっています。<br />
                  本スクールはそうした社会的ニーズを背景とし、都市・地域のDXやまちづくりのイノベーションの担い手を育成することを狙いとしており、当研究科による企画・運営のもと、東京大学の関連専門分野の第一線で活躍する講師陣による最新技術や新たなまちづくりの方法に係る講義と討論、先端研究の現場における技術体験、先進例である柏の葉スマートシティ（千葉県柏市）等の現地視察を通じ、スマートシティのエッセンスを集中的に学び、DXの担い手としての考え方や知識を修得して頂くためのカリキュラム提供を目指しております。<br />
                  また、スマートシティの計画づくりや実践には、関連する多様な分野の専門知と実践知が求められます。異分野の融合と知の冒険を目指してきた当研究科では、学術と実践を融合させた社会人向けのリカレント教育プログラムの提供を通じて、DXやGXに貢献して参りたいと考えております。<br />
                  受講生の方々には、スマートシティをメインテーマとしながら、都市・地域のDXに係る技術や方法、考え方を幅広く学んで頂くことに加え、新たなまちづくり関連事業の開拓やビジネスモデルの創出に繋げて頂くために自らの思考を洗練させる機会として、本スクールを活用して頂くことを期待しております。</p>
                  <div class="modal_sign">
                    <div class="modal_sign_inner">
                      <span>東京大学大学院新領域創成科学研究科長</span>
                      <h3>出口 敦</h3>
                    </div>
                  </div>
                  <div class="modal2-close">
                    <span><img src="<?php bloginfo('template_directory'); ?>/assets/images/top/btn_close.png" alt="Close"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



  </section>

  <!--本スクールについて-->
  <section id="about">
    <h2 class="section_title">
      <span>本スクールについて</span>
      <div>ABOUT</div>
    </h2>
    <div class="top_line_wrap full">
      <div class="top_line"></div>
    </div>
    <div class="about_image_wrap">
      <div class="about_image">
      <ul class="slider">
    <li><img class="change" src="<?php bloginfo('template_directory'); ?>/assets/images/top/about_1_pc.png" alt=""></li>
    <li><img class="change" src="<?php bloginfo('template_directory'); ?>/assets/images/top/about_2_pc.png" alt=""></li>
    <li><img class="change" src="<?php bloginfo('template_directory'); ?>/assets/images/top/about_3_pc.png" alt=""></li>
  </ul>

      </div>
    </div>
    <div class="about_text">
      <h3>スマートシティの構築と<br />推進に寄与する人材を育てます。</h3>
      <p>本スクールは、都市の課題を読み解き、データ活用と新技術の社会実装を通じて課題解決と価値創造を担うスマートシティの実現や都市・地域のDX（デジタルトランスフォーメーション）の担い手の育成を目指す、若手から中堅の社会人を対象とした教育プログラムです。<br />
      関連分野の第一線で活躍する講師陣による講義と討論、先進事例の現地視察、演習課題に対するグループ作業を通じて、現状を俯瞰的に捉えて見直す思考力、スマートシティの関連技術や技術の社会実装に係る専門知識、都市・地域の課題を読み解き、デジタル技術やデータ活用による将来計画を立案する構想力の修得を目指して頂きます。</p>
    </div>
    <div class="about_acordion">
    <section id="product">
  <div class="genre">
    <div class="section s_02">
      <div class="accordion_one">
        <div class="accordion_header">
          <div class="accord_tit"><span class="num01">01</span>スクールが対象とする受講生</div>
          <div class="i_box"><i class="one_i"></i></div>
        </div>
        <div class="accordion_inner">
          <div class="box_one">
            <p class="txt_a_ac">本スクールは、スマートシティをテーマとした関連分野の知識や技術、考え方の修得を通じて、デジタルトランスフォーメーション（ＤＸ）に寄与する事業や活動に自ら取組む意欲を持つ社会人の方を対象とします。民間企業、行政機関、研究機関、 コンサルタントなど様々な組織から、また、政策・経営、まちづくりや建設、ICT、製造業からサービス業に至る様々な業種からの参加を想定しています。</p>
          </div>
        </div>
      </div>
      <div class="accordion_one">
        <div class="accordion_header">
          <div class="accord_tit"><span class="num02">02</span>スクールで育成を目指す人材像</div>
          <div class="i_box"><i class="one_i"></i></div>
        </div>
        <div class="accordion_inner">
          <div class="box_one">
            <p class="txt_a_ac">本スクールでは、政策立案やコーディネートを行うジェネラリスト型人材、プロジェクトの企画・推進や運営を担うプラクティショナー型人材の育成を視野に入れています。それぞれの人材育成を目的としたコースを設置し、以下の力の修得を目指して頂きます。</p>
            <dl>
              <dt>思考力・企画力</dt>
              <dd>現状を俯瞰的に捉え、見直す思考とデジタル技術やデータ活用により転換する方策を企画する力</dd>
              <dt>先端技術と実装方法に係る知識</dt>
              <dd>スマートシティの実現に資する先端的な要素技術とその社会実装の方法に係る知識</dd>
              <dt>都市・地域の課題分析力・構想力</dt>
              <dd>都市・地域の課題を読み解いた上で、デジタル技術やデータ活用による将来計画を構想する力</dd>
            </dl>
          </div>
        </div>
      </div>
      <div class="accordion_one">
        <div class="accordion_header">
          <div class="accord_tit"><span class="num03">03</span>スクールの特色</div>
          <div class="i_box"><i class="one_i"></i></div>
        </div>
        <div class="accordion_inner">
          <div class="box_one">
            <p class="txt_a_ac">本スクールは東京大学の人材、研究、フィールドを最大限に生かし、以下の特色のあるカリキュラムを提供します。</p>
          </div>
          <ul>
            <li>東京大学の教員を中心に、スマートシティ関連分野の第一線で活躍する専門家や実務家からなる講師陣による講義と講義後の討論。</li>
            <li>講義、ラウンドテーブル討論、現地視察・技術体験、グループワーク演習を組み合わせた双方向の授業を原則対面型で実施。</li>
            <li>都市計画分野や理工系分野はもとより、人文系分野や社会科学系分野も含めた多彩な分野構成により、スマートシティに係る包括的・体系的な学びを提供。</li>
            <li>柏の葉スマートシティにおける先進例や東京大学柏キャンパスでの最新研究開発について、現地においてこれらを主導する実務者や研究者から学ぶ体験型授業を提供。</li>
            <li>学位取得を目的としたものではなく、スマートシティに関する実務家の育成を目的とした社会人リカレント教育プログラムとして、本コースを修了された方には「コース修了証書」を授与。</li>
           </ul>
        </div>
      </div>
    </div>
  </div>

</section>
    </div>



  </section>

</div>

<!--コンタクトエリア-->
<?php get_template_part('parts_contact'); ?>

<?php get_template_part('parts_footer'); ?>
<?php get_footer(); ?>
