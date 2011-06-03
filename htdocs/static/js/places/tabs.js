$(function() {
  var rightTabs = $('#right-tabs');
  rightTabs.children('li:first').addClass('active');
  rightTabs.children('li').click(function() {
    var tabName = $(this).children('a').attr('href');
    $(this).parent().children().removeClass('active');
    $(this).addClass('active');
    $('.right-tab-content').hide();
    $(tabName+'-tab').show().css('visibility', 'visible');
    return false;
  });
  
  dbpediaQuery($('#place-name').text(), $('#admin1').text());
});


function dbpediaQuery(placeName, admin1) {
  var query = placeName+' '+admin1;
  var altQuery = placeName;
  $.post(baseUrl+'places/ajax_dbpedia_query', {query:query, altQuery:altQuery},
    function(d) {
      var r = $.parseJSON(d);
      if (r) {
        $('#name').html(r.label.value);
        var abstract = r.abstract.value;
        // add ellipses if abstract doesn't end with period
        if ( ! abstract.match(/\.$/)) {
          abstract += '...';
        }
        $('#abstract').html(abstract);
        //textShorten($('#abstract'));
        $('#gallery-tab').append('<img src="'+r.thumbnail.value+'"/>');
      } else {
        $('#abstract').html('sorry, we couldn\'t find any info on that');
      }
    });
  return false;
}