$(function() {
  $('#save-post-button').click(function() {
    if (getContentEditableText('post-input').trim().length > 0) {
      if (typeof tripId == 'undefined' || loginSignup.getStatus()) {
        savePost();        
      } else {
        loginSignup.showDialog('save post');
      }
    }
    return false;
  });
});


getContentEditableText = function(id) {
  var ce = $('<pre />').html($('#' + id).html());
  if ($.browser.webkit)
    ce.find('div').replaceWith(function() { return '\n' + this.innerHTML; });
  if ($.browser.msie)
    ce.find('p').replaceWith(function() { return this.innerHTML + '<br>'; });
  if ($.browser.mozilla || $.browser.opera || $.browser.msie)
    ce.find('br').replaceWith('\n');
  return ce.text();
}

/*wall.savePost = function() {
  var text = wall.getContentEditableText('post-input').trim();
  var matches = text.match(/@[\w-']+/g);
  for (i in matches) {
    var name = matches[i].replace(/@/, '');
    var id = $('#autocomplete-results').data(name);
    name = name.replace(/-/g, ' ');
    text = text.replace(matches[i], '<place id="'+id+'">'+name+'</place>');
  }

  $.post(baseUrl+'posts/ajax_save', {tripId:tripId, content:text},
    function(r) {
      var r = $.parseJSON(r);
      wall.displayPost(r);
    });
};*/


savePost = function() {
  var content = getContentEditableText('post-input').trim();
  if (typeof tripId == 'number') {
    var tripIds = [tripId];
  } else {
    var tripIds = $('#trip-selection').multiselect('getChecked').map(function(){
       return this.value;
    }).get();
  }
  
  $.post(baseUrl+'posts/ajax_save', {content:content, tripIds:tripIds},
    function (d) {
      $('#post-input').text('');
      var r = $.parseJSON(d);
      $('#trip-selection').multiselect('uncheckAll');
      console.log(r);
    });
}