/****************************************
スライダー
****************************************/
$('.slider').slick({
  autoplay:true,
  autoplaySpeed:5500,
  fade: true,
  speed: 2500,
  arrows:false,
});


/****************************************
モーダル
****************************************/
$(function() {
  $('.modal-open').click(function(){
   $('#Modal').fadeIn();
   $('html').addClass('modalset');
  });
  $('.modal .modal-bg,.modal .modal-close').click(function(){
   $('#Modal').fadeOut();
   $('html').removeClass('modalset');
  });
 });

 $(function() {
  $('.modal2-open').click(function(){
   $('#Modal2').fadeIn();
   $('html').addClass('modalset2');
  });
  $('.modal2 .modal2-bg,.modal2 .modal2-close').click(function(){
   $('#Modal2').fadeOut();
   $('html').removeClass('modalset2');
  });
 });



/****************************************
アコーディオン
****************************************/
$(function(){
  //.accordion_oneの中の.accordion_headerがクリックされたら
  $('.s_02 .accordion_one .accordion_header').click(function(){
    //クリックされた.accordion_oneの中の.accordion_headerに隣接する.accordion_innerが開いたり閉じたりする。
    $(this).next('.accordion_inner').slideToggle();
    $(this).toggleClass("open");

    //クリックされた.accordion_oneの中の.accordion_header以外の.accordion_oneの中の.accordion_headerに隣接する.accordion_oneの中の.accordion_innerを閉じる
    $('.s_02 .accordion_one .accordion_header').not($(this)).next('.accordion_one .accordion_inner').slideUp();
    $('.s_02 .accordion_one .accordion_header').not($(this)).removeClass("open");
  });
});



