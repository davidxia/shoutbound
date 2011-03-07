var Wall = {};

/*
Wall.loadWall = function() {
  $('.show_reply_button').click(function() {
      var replyid = $(this).attr('postid');
      
      $(this).parent().append('<textarea class="reply_box" id="reply_box_'+replyid+'"></textarea>'+
          '<div class="reply-container">' +
          '<button class="reply_submit" parentid="'+replyid+'">reply</button>' +
          '</div>');
      $(this).hide();
      $('#reply_box_'+replyid).focus();
  
      $('.reply_submit[parentid="'+replyid+'"]').click(function() {
          // if the reply box isn't empty
          if($('#reply_box_'+replyid).val()){
              // then posts the reply
              $.ajax({
                  type: 'POST',
                  url: baseUrl + 'trip/ajax_wall_post',
                  data: {
                      tripId: tripId,
                      body: $('#reply_box_'+replyid).val(),
                      replyid: replyid,
                      created: Math.round(new Date().getTime()/1000)
                  },
                  success: Wall.show_post
              });
  
              $('.show_reply_button[postid="'+replyid+'"]').show();
          }
          $('#reply_box_'+replyid).remove();
          $(this).remove();
          $('.show_reply_button').show();
      });
      return false;
  });
  

}

Wall.show_post = function(responseText){
  var response = $.parseJSON(responseText);
  
  // display: none creates sliding effect when comment is posted
  if(response.replyid == 0) {
      var commentHTML = '<div id="wall-item-'+response.itemid+'" class="wall-item" style="display:none">';
  } else {
      var commentHTML = '<div class="wall-comment wall-reply" style="display:none">';
  }
  commentHTML += '<div class="nn-fb-img left">';
  commentHTML += '<img class="square-50" src="http://graph.facebook.com/'+response.fid+'/picture?type=square"/>';
  commentHTML += '</div>';
  
  commentHTML += '<div class=remove-wall-item" itemid="'+response.itemid+'"></div>';
  
  commentHTML += '<span class="wall-comment-username">'+response.name+'</span>';
  commentHTML += '<span class="wall-comment-text">';
  if(response.islocation){
      commentHTML += 'dropped a pin on '+response.marker_name+'<br/>';
  }
  commentHTML += response.body+'</span>';
  
  commentHTML += '<br/><span class="wall-timestamp">a second ago</span><br/>';
  commentHTML += '<div class="clear"></div>';
  commentHTML += '</div>';
  
  if(response.replyid == 0) {
      commentHTML += '<div id="replies_'+response.itemid+'"></div>';
      commentHTML += '<div class="reply-box"><a href="#" class="show_reply_button" postid="'+response.itemid+'" style="display: inline;">this reply button doesnt work!</a>';
      commentHTML += '<div class="reply-container"></div></div>';
  }
  
  if(response.replyid == 0) {
      $(commentHTML).prependTo('#trip-wall-content').slideDown('slow');
  } else {
      $(commentHTML).appendTo('#replies_'+response.replyid).slideDown('slow');
  }
  
  if(response.replyid == 0)
      $('#wall-text-input').val('');
}


Wall.show_location_based_post = function(responseText) {
        var response = $.parseJSON(responseText);
        
        // display: none creates sliding effect when comment is posted
        var html = '<div id="wall-item-'+response.itemid+'" class="wall-item location_based" style="display:none">';
        html += '<span class="wall_location_name">'+response.marker_name+'</span><br/>';
        html += 'Suggested by '+response.name+'<br/>';
        html += 'Accomodation, landmark, restaurant<br/>Good for: seeing new york like a local, food, burgers<br/>';
        html += '<div class="rating_panel">Like Dislike<br/></div>';
        
        html += '<div class=remove-wall-item" itemid="'+response.itemid+'"></div>';
        
        html += '<br/><span class="wall-timestamp">a second ago</span><br/>';
        html += '<div class="clear"></div>';
        html += '</div>';

        html += '<div id="replies_'+response.itemid+'"></div>';
        html += '<div class="reply-box"><a href="#" class="show_reply_button" postid="'+response.itemid+'" style="display: inline;">this reply button doesnt work!</a>';
        html += '<div class="reply-container"></div></div>';

        $(html).prependTo('#trip-wall-content').slideDown('slow');
        
        if(response.replyid == 0)
            $('#wall-text-input').val('');
}





$(document).ready(function(){
  Wall.loadWall();
  $('#comment_input').focus(function(){
    if($(this).val() == 'write a comment...'){
      $(this).animate({
        color: '#fff'
        // your input background color.
      }, 300, 'linear', function(){
        $(this).val('').css('color','#000'); 
        // change color back to black so typing shows up
      });
      $('#submit-wall').toggle();
    }
  }).blur(function(){
    if($(this).val() == ''){
      $(this).val('write a comment...').css('color','#fff');
      $(this).animate({
          color: '#000'
      }, 300, 'linear');
      $('#submit-wall').toggle();
    }
  });
});
*/