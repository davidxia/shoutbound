$(function(){
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
              ele.addClass('unfavorite').removeClass('favorite').text('Unfavorite');
            } else {
              ele.addClass('favorite').removeClass('unfavorite').text('Favorite');
            }
          }
        }, 'json');
    }
    return false;
  });        
});
