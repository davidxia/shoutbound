$(function(){
  if ($('.gallery').length>0){
    $('.gallery').galleria({
      width:638,
      height:384,
      imageCrop: true,
/*       imagePosition: '0px 0px', */
      imageMargin: 0,
      initialTransition: 'none',
      transition: 'fade',
/*       showInfo: false, */
      carouselSpeed: 500,
      showCounter: false,
      extend: function() {
        this.bind('loadfinish', function() {
          if ($('.galleria-info-description').text()){
            $('.photo-caption').html($('.galleria-info-description').text()).fadeIn(500);
          } else {
            $('.photo-caption').fadeOut(300);
          }
        });
      }
    });
  }


  $('#carousel').bxSlider({
    infiniteLoop: false,
    hideControlOnEnd: true,
    pager: true,
    displaySlideQty: 3,
    moveSlideQty: 3
  });


  $('.favorite, .unfavorite').live('click', function(){
    if (loggedin) {
      var ele = $(this);
      var id = $(this).attr('id').match(/^(\w+)-(\d+)$/);
      var type = id[1];
      id = id[2];
      var postData = {articleId:id};
      if ($(this).hasClass('favorite')){
        postData.isFavorite = 1;
      } else {
        postData.isFavorite = 0;
      }
      $.post(baseUrl+'user/ajax_set_favorite', postData,
        function(data){
          if (data.success){
            if (data.isFavorite){
              ele.addClass('unfavorite').removeClass('favorite').text('Remove from wishlist');
            } else {
              ele.addClass('favorite').removeClass('unfavorite').text('Add to wishlist');
            }
          }
        }, 'json');
    }
    return false;
  });
});
