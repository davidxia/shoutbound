$(function() {
  String.prototype.trim = function() {return this.replace(/^([\s\t\n]|\&nbsp\;|<br>)+|([\s\t\n]|\&nbsp\;|<br>)+$/g, '');}

  var sbEditor = new nicEditor({
    fullPanel:false,
    buttonList:['bold','italic','underline','ol','ul','link','unlink','image','upload'],
    iconsPath: baseUrl+'static/images/nicEditorIcons.gif',
    uploadURI : 'http://yourdomain.com/nicUpload.php'
  }).panelInstance('post-input');
  
  sbEditor.addEvent('focus', function() {
    $('#add-to-trip-main').show();
    $('#save-post-button').show();
  });

  $('#save-post-button').click(function() {
    if (convertNewlines(nicEditors.findEditor('post-input').getContent()).trim().length > 0) {
      if (typeof tripId == 'undefined' || loginSignup.getStatus()) {
        savePost();        
      } else {
        loginSignup.showDialog('save post');
      }
    }
  });
});


convertNewlines = function(content) {
  var ce = $('<pre />').html(content);
  if ($.browser.webkit)
    ce.find('div').replaceWith(function() { return '\n' + this.innerHTML; });
  if ($.browser.msie)
    ce.find('p').replaceWith(function() { return this.innerHTML + '<br>'; });
  if ($.browser.mozilla || $.browser.opera || $.browser.msie)
    ce.find('br').replaceWith('\n');
  return ce.html();
}


/*
wall.savePost = function() {
  var text = wall.convertNewlines('post-input').trim();
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
};
*/

savePost = function() {
  var content = convertNewlines(nicEditors.findEditor('post-input').getContent()).trim();
  if (typeof tripId == 'number') {
    var tripIds = [tripId];
  } else {
    var tripIds = $('#trip-selection').multiselect('getChecked').map(function(){
       return this.value;
    }).get();
  }
  console.log(content);
      
  $.post(baseUrl+'posts/ajax_save', {content:content, tripIds:tripIds},
    function (d) {
      $('#post-input').text('');
      var r = $.parseJSON(d);
      $('#trip-selection').multiselect('uncheckAll');
      console.log(r);
    });
}