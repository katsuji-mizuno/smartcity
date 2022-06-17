

//ブラウザの判定
var wWidth = 0;
var wHeight = 0;
var headHeight = 0;
var headHeightSp = 0;
var headHeightPc = 0;
var bPoint = 750;
var bPoint2 = 1240;

/* getWidth */
function getWidth() {
  wWidth = window.innerWidth;
  return wWidth;
}

/* getHeight */
function getHeight() {
  wHeight = window.innerHeight;
  return wHeight;
}

/* ReLayout */
function ReLayout() {

  wWidth = getWidth();
  wHeight = getHeight();

  // body padding top
  if(wWidth <= bPoint) {
    headHeight = headHeightSp;
  } else {
    headHeight = headHeightPc;
  }
}
//ReLayout();


$(function () {

  getWidth();
  getHeight();

  /* for IE */
  var agent = navigator.userAgent;
  var userAgent = window.navigator.userAgent.toLowerCase();
  if (userAgent.match(/(msie|MSIE)/) || userAgent.match(/(T|t)rident/)) {
    var isIE = true;
    $("html").addClass('ie');
    var ieVersion = userAgent.match(/((msie|MSIE)\s|rv:)([\d\.]+)/)[3];
    ieVersion = parseInt(ieVersion);
  } else {
    var isIE = false;
    $("html").removeClass('ie');
  }

  /* IEでの fixed カクつき防止 */
  if(navigator.userAgent.match(/MSIE 10/i) || navigator.userAgent.match(/Trident\/7\./) || navigator.userAgent.match(/Edge\/12\./)) {
    $('body').on("mousewheel", function () {
      event.preventDefault();
      var wd = event.wheelDelta;
      var csp = window.pageYOffset;
      window.scrollTo(0, csp - wd);
    });
  }

  var timer = false;
  $(window).resize(function () {
    if (timer !== false) {
      clearTimeout(timer);
    }
    timer = setTimeout(function () {
      var ww = $(window).width();
      if (wWidth != ww) {
        ReLayout();
        changeImage();
        changeImage2();
      }
    }, 200);
  });
});


//ブラウザの判定
$(function() {
　　 /* ユーザーエージェントの文字列を取得 */
      var useragent = window.navigator.userAgent.toLowerCase();

    /* ブラウザごとの条件分岐 */
    if (useragent.indexOf('msie') != -1 ||
          useragent.indexOf('trident') != -1) {
          //Internet Explorerに適応させたい内容
      } else if(useragent.indexOf('edge') != -1) {
          //Edgeに適応させたい内容
  } else if (useragent.indexOf('chrome') != -1) {
          //Chromeに適応させたい内容
  } else if (useragent.indexOf('safari') != -1) {
          //Safariに適応させたい内容
  } else if (useragent.indexOf('firefox') != -1) {
          //FireFoxに適応させたい内容
  } else if (useragent.indexOf('opera') != -1) {
          //Operaに適応させたい内容
  } else {
          //上記以外のブラウザに適応させたい内容
  };
});

// ブラウザバック
window.onpageshow = function(){
  setTimeout(function () {
    ReLayout();
  }, 200);
}

// loaded
$.event.add(window, 'load', function () {
  setTimeout(function () {
    ReLayout();
    changeImage();
    changeImage2();
  }, 2000);
});

// changeImage
function changeImage() {
  if (wWidth <= bPoint) {
    if($('.change')[0]){
      $('.change').each(function(){
        $(this).attr("src",$(this).attr("src").replace('_pc', '_sp'));
      });
    }
  } else {
    if($('.change')[0]){
      $('.change').each(function(){
        $(this).attr("src",$(this).attr("src").replace('_sp', '_pc'));
      });
    }
  }
}
function changeImage2() {
  if (wWidth <= bPoint2) {
    if($('.change2')[0]){
      $('.change2').each(function(){
        $(this).attr("src",$(this).attr("src").replace('_pc', '_sp'));
      });
    }
  } else {
    if($('.change2')[0]){
      $('.change2').each(function(){
        $(this).attr("src",$(this).attr("src").replace('_sp', '_pc'));
      });
    }
  }
}



/*--------------------------------------
  smooth scroll
--------------------------------------*/

jQuery(function($){
  $('a[href^="#"]').not('ul.tab_catalog li a').on('click', function(){
    var offset = 70;

    var href= $(this).attr("href");
    if (href.match('modal') == null) {

      if (window.innerWidth < 1025) {
        //スマホの場合の調整
        if ($('body').hasClass('open')) {
          $('body').removeClass("open");
        }
      }
      var target = $(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top - offset;
      $('body,html').animate({scrollTop:position}, 800, 'swing');
      return false;
    }
  });

});


/****************************************
loading
****************************************/
const progressBar = document.querySelector('.js-loader-progress-bar')
const progressNumber = document.querySelector('.js-loader-progress-number')

const imgLoad = imagesLoaded('body');//body内の画像を監視
const imgTotal = imgLoad.images.length;//画像の総数を取得

let imgLoaded = 0;//ロードした画像カウント
let progressSpeed = 4;//プログレスバーの進むスピード 大きいほど速くなる
let progressCount = 0;//ローディングの進捗状況 0〜100
let progressResult = 0;//ローディングの進捗状況 0〜100

//読み込み状況をアップデート
let progressInit = setInterval(function () {
  updateProgress();
}, 25);

//画像を一つロードするたびにimgLoadedのカウントをアップ
imgLoad.on('progress', function (instance, image) {
  imgLoaded++
})

//読み込み状況アップデート関数
function updateProgress() {

  //ローディング演出用の計算
  progressCount += (imgLoaded / imgTotal) * progressSpeed;

  if(progressCount >= 100 && imgTotal > imgLoaded) {
    //カウントは100以上だが画像の読み込みが終わってない
    progressResult = 99;
  } else if(progressCount > 99.9) {
    //カウントが100以上になった
    progressResult = 100;
  } else {
    //現在のカウント
    progressResult = progressCount;
  }

  //ローディング進捗状況をプログレスバーと数字で表示
  progressBar.style.width = progressResult + '%';
  progressNumber.innerText = Math.floor(progressResult);

  //ローディング完了後 0.8秒待ってページを表示
  if (progressResult >= 100 && imgTotal == imgLoaded) {
    clearInterval(progressInit);
    setTimeout(function () {
      document.querySelector('body').classList.add('is-loaded');
    }, 800);
  }
}


/****************************************
menu open
****************************************/
$(function () {
  $('#siteHead .menu').on('click',function(){
    $(this).toggleClass('open');
    if($(this).hasClass('open')){
      $('#gNav').addClass('open');
    } else {
      $('#gNav').removeClass('open');
    }
  });
  $('#gNav li a').on('click',function(){
    if (window.matchMedia( "(max-width: 750px)" ).matches) {
      /* ウィンドウサイズが 750px以下の場合に有効にしたい処理*/
      setTimeout(function() {
        $('#siteHead .menu').removeClass('open');
        $('#gNav').removeClass('open');
      }, 500);
      }
      else {
        $('#siteHead .menu').removeClass('open');
        $('#gNav').removeClass('open');
      }
  });
  $('#gNav li a').on('click',function(){
    if (window.matchMedia( "(max-width: 750px)" ).matches) {
      /* ウィンドウサイズが 750px以下の場合に有効にしたい処理*/
      setTimeout(function() {
        $('#siteHead .menu').removeClass('open');
        $('#gNav').removeClass('open');
      }, 500);
      }
      else {
        $('#siteHead .menu').removeClass('open');
        $('#gNav').removeClass('open');
      }
  });
});




/****************************************
// スクロールしたらクラス追加してヘッダーロゴを上から出す
****************************************/
$(function(){
  var wWidth = $(window).width();
  $(window).scroll(function() {
    var scrollTop = $(this).scrollTop();
    var scrollHeight = 120;
    if (scrollTop > scrollHeight) {
      $('.header_logo_wrap').addClass('menu_appear');
      } else {
      $('.header_logo_wrap').removeClass('menu_appear');
    }
  });
});


/****************************************
// メニューをタップ後の遷移を少し遅らせる
****************************************/
//ReLayout();
$(".gNav_inner li a").on("click", function() {
  if (window.matchMedia( "(max-width: 750px)" ).matches) {
    /* ウィンドウサイズが 750px以下の場合に有効にしたい処理*/
    event.preventDefault();
    var link = $(this).attr('href');
    setTimeout(function() {
      location.href= link;
    }, 240);
    }
    else {
    }
});



