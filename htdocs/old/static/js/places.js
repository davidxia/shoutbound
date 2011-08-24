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
        $('#abstract').shorten();
        $('#abstract-container').show();
        var newImg = new Image();
        newImg.src = r.thumbnail.value;
        var parentWidth = document.getElementById('gallery').clientWidth;
        var calcHeight = parentWidth/newImg.width * newImg.height
        $('#gallery').append('<img src="'+r.thumbnail.value+'" width="'+parentWidth+'" height="'+calcHeight+'"/>');
      }
    });
  return false;
}


$.fn.shorten = function(settings) {
  var config = {
    showChars : 300,
    ellipsesText : '...',
    moreText : 'more',
    lessText : 'less'
  };

  if (settings) {
    $.extend(config, settings);
  }

  $('.morelink').live('click', function() {
    var $this = $(this);
    if ($this.hasClass('less')) {
      $this.removeClass('less');
      $this.html(config.moreText);
    } else {
      $this.addClass('less');
      $this.html(config.lessText);
    }
    $this.parent().prev().toggle();
    $this.prev().toggle();
    return false;
  });

  return this.each(function() {
    var $this = $(this);

    var content = $this.html();
    if (content.length > config.showChars) {
      var c = content.substr(0, config.showChars);
      var h = content.substr(config.showChars , content.length - config.showChars);
      var html = c + '<span class="moreellipses">' + config.ellipsesText + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="javascript://nop/" class="morelink">' + config.moreText + '</a></span>';
      $this.html(html);
      $('.morecontent span').hide();
    }
  });
};