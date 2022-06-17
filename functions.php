<?php
/* マイナーアップグレードのみ有効化、開発版、メジャーアップグレードは無効化 */
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* バージョンアップ通知を非表示にする */
function update_nag_hide() {
    remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action( 'admin_init', 'update_nag_hide' );
/* WordPressの自動更新チェックを停止する */
add_filter ('pre_site_transient_update_core','__return_zero');
remove_action ('wp_version_check','wp_version_check');
remove_action ('admin_init','_maybe_update_core');
/* 管理メニューから「更新」を消す */
function remove_admin_menu_items() {
    remove_submenu_page('index.php','update-core.php');
}
add_action('admin_menu','remove_admin_menu_items');
/* srcset　無効化 */
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
add_filter( 'wp_calculate_image_srcset', '__return_false' );
remove_filter( 'the_content', 'wp_make_content_images_responsive' );
/* タイトルタグ */
add_theme_support( 'title-tag' );
/* アイキャッチ */
add_theme_support('post-thumbnails');
/* canonical出力 */
remove_action('wp_head', 'rel_canonical');
add_action( 'wp_head', 'add_canonical' );
function add_canonical() {
  $canonical = null;
  if( is_home() || is_front_page() ) {
    $canonical = home_url();
  } elseif ( is_category() ) {
    $canonical = get_category_link( get_query_var('cat') );
  } else if(is_tag()){
    $canonical = get_tag_link(get_queried_object()->term_id);
  } elseif ( is_search() ) {
    $canonical = get_search_link();
  } elseif ( is_page() || is_single() ) {
    $canonical = get_permalink();
  } else{
    $canonical = home_url();
  }
  echo '<link rel="canonical" href="'.$canonical.'">'."\n";
}
/* 固定ページにカテゴリーを紐付 */
add_action('init','add_categories_for_pages');
function add_categories_for_pages(){
register_taxonomy_for_object_type('category', 'page');
}

//管理画面CSS
function admin_css() {
  echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo("template_directory").'/admin.css">';
}
add_action('admin_head', 'admin_css');

//ダッシュボードタイトル
function adminTxtReplace(){
  echo'
<script type="text/javascript">
//<![CDATA[
window.onload=adminTxtReplace
function adminTxtReplace(){
  document.body.innerHTML = document.body.innerHTML.replace(/\<h1\>ダッシュボード\<\/h1\>/g, "\<h1\ style\=\"background\:\#000000\;\ text\-align\:center\; color\:\#fff\; padding\:200px 10px\;\"\>ダッシュボード\<br\>\<span style\=\"font-size\:12px\;\"\>content management system</span>\<\/h1\>");
}
//]]>
</script>';
}

//  ----------------------------------------------------------------------------------
//  新規定義
//  ----------------------------------------------------------------------------------
// 検索機能の追加
function set_redirect_template() {
  if (isset($_GET['s']) && empty($_GET['s'])) {
      include(TEMPLATEPATH . '/search.php');
      exit;
  }
}
add_action('template_redirect', 'set_redirect_template');
function my_excerpt_more($more) {
   return '…';
}
add_filter('excerpt_more', 'my_excerpt_more');





/* -------------------------- OGP出力 ------------------------- */
function my_meta_ogp() {
  if (is_front_page() || is_home() || is_singular()) {
    $ogp_image = 'http://smartcity-school.k.u-tokyo.ac.jp/wp-content/themes/smartcity/assets/images/ogp.png';
    $twitter_site = '';
    $twitter_card = 'summary_large_image';
    $facebook_app_id = '';
    global $post;
    $ogp_title = 'スマートシティスクール';
    $ogp_description = '東京大学大学院 新領域創成科学研究科 スマートシティスクール';
    $ogp_url = '';
    $html = '';
    if (is_singular()) {
      setup_postdata($post);
      $ogp_title = $post->post_title;
      $ogp_description = mb_substr(get_the_excerpt(), 0, 100);
      $ogp_url = get_permalink();
      wp_reset_postdata();
    } elseif (is_front_page() || is_home()) {
      $ogp_title = get_bloginfo('name');
      $ogp_description = get_bloginfo('description');
      $ogp_url = home_url();
    }
    $ogp_type = (is_front_page() || is_home()) ? 'website' : 'article';
    if (is_singular() && has_post_thumbnail()) {
      $ps_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
      $ogp_image = $ps_thumb[0];
    }
    $html = "\n";
    $html .= '<title>' . esc_attr($ogp_title) . '</title>' . "\n";
    $html .= '<meta name="description" content="' . esc_attr($ogp_description) . '">' . "\n";
    $html .= '<meta property="og:title" content="' . esc_attr($ogp_title) . '" />' . "\n";
    $html .= '<meta property="og:description" content="' . esc_attr($ogp_description) . '" />' . "\n";
    $html .= '<meta property="og:type" content="' . $ogp_type . '" />' . "\n";
    $html .= '<meta property="og:url" content="' . esc_url($ogp_url) . '" />' . "\n";
    $html .= '<meta property="og:image" content="' . esc_url($ogp_image) . '" />' . "\n";
    $html .= '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '" />' . "\n";
    $html .= '<meta name="twitter:card" content="' . $twitter_card . '" />' . "\n";
    $html .= '<meta name="twitter:site" content="' . $twitter_site . '" />' . "\n";
    $html .= '<meta name="twitter:title" content="' . esc_attr($ogp_title) . '" />' . "\n";
    $html .= '<meta name="twitter:url" content="' . esc_url($ogp_url) . '" />' . "\n";
    $html .= '<meta name="twitter:description" content="' . esc_attr($ogp_description) . '">' . "\n";
    $html .= '<meta name="twitter:image" content="' . esc_url($ogp_image) . '" />' . "\n";
    $html .= '<meta property="og:locale" content="ja_JP" />' . "\n";
    $html .= '<meta property="article:publisher" content="https://www.facebook.com/@@@">' . "\n";
    if ($facebook_app_id != "") {
      $html .= '<meta property="fb:app_id" content="' . $facebook_app_id . '">' . "\n";
    }
    echo $html;
  }
}
add_action('wp_head', 'my_meta_ogp');


add_action('admin_head-index.php', 'adminTxtReplace', 20);
// 管理画面非表示
function remove_admin_menus() {
    // level10以外のユーザーの場合
        global $menu;
        // unsetで非表示にするメニューを指定
        // unset($menu[2]);        // ダッシュボード
        // unset($menu[5]);        // 投稿
        // unset($menu[10]);       // メディア
        unset($menu[15]);       // リンク
       unset($menu[20]);       // 固定ページ
        unset($menu[25]);       // コメント
         unset($menu[60]);       // 外観
         unset($menu[65]);       // プラグイン
        // unset($menu[70]);       // ユーザー
         unset($menu[75]);       // ツール
        // unset($menu[80]);       // 設定
        remove_menu_page('cptui_main_menu');//CPT
        remove_menu_page('edit.php?post_type=acf');//ACF
      //  remove_menu_page ('toolset-dashboard');//Types
      remove_menu_page( 'edit.php?post_type=acf-field-group' ); // Advanced Custom Fields.

}
add_action('admin_menu', 'remove_admin_menus', 11);



add_action('wp_dashboard_setup', function() {
  $tmp = [
        //  'wp_welcome_panel',//WordPressへようこそ！
        //  'dashboard_activity',//アクティビティ
        //  'dashboard_recent_comments',//最近のコメント
        //  'dashboard_incoming_links',//被リンク
        //  'dashboard_plugins',//プラグイン
          'dashboard_quick_press',//クイック投稿
       //   'dashboard_recent_drafts',//最近の下書き
          'dashboard_primary',//WordPressブログ
          'dashboard_secondary',//WordPressフォーラム
          'dashboard_site_health',//サイトヘルスステータス
  ];
  foreach ($tmp as $v) {
      if ( $v == 'wp_welcome_panel' ) {
          remove_action('welcome_panel', 'wp_welcome_panel');
      } else {
          global $wp_meta_boxes;
          unset($wp_meta_boxes['dashboard']['normal']['core'][$v]);
          unset($wp_meta_boxes['dashboard']['side']['core'][$v]);
      }
  }
});

//  ----------------------------------------------------------------------------------
//  パスワードの文言変更
//  ----------------------------------------------------------------------------------
function my_password_form() {
  return
    '<p>受講生専用のパスワードをご入力下さい。<p>
    <form class="post_password" action="' . home_url() . '/wp-login.php?action=postpass" method="post">
    <input name="post_password" type="password" size="24" placeholder="PASSWORD（パスワード）" />
    <input type="submit" name="Submit" value="' . esc_attr__("LOGIN") . '" />
    </form>';
}
add_filter('the_password_form', 'my_password_form');

//  ----------------------------------------------------------------------------------
//  /***** エディタで再利用ブロックの編集を禁止する *****/
//  ----------------------------------------------------------------------------------

if ( !function_exists( 'habone_disable_reuse_block_edit' ) ){
	function habone_disable_reuse_block_edit(){
?>
<style>
.block-library-block__reusable-block-container {
	border: 4px solid #FF0000;
	pointer-events: none;
}

.block-library-block__reusable-block-container:before {
	content: "再利用ブロックのためここでは編集できません";
	font-size:0.8em;
	color:#FF0000;
}
/* テーブルブロックの制御 */
.block-editor-block-list__layout {
    user-select: none;
}
</style>
<?php
}
}
add_action( 'admin_head', 'habone_disable_reuse_block_edit');