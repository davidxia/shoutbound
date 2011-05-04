Encoder = {
    EncodeType: "entity",
    isEmpty: function (val) {
        if (val) {
            return ((val === null) || val.length == 0 || /^\s+$/.test(val));
        } else {
            return true;
        }
    },
    HTML2Numerical: function (s) {
        var arr1 = new Array('&nbsp;', '&iexcl;', '&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&shy;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&Auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&Ouml;', '&times;', '&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&Uuml;', '&yacute;', '&thorn;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;', '&Oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;', '&quot;', '&amp;', '&lt;', '&gt;', '&oelig;', '&oelig;', '&scaron;', '&scaron;', '&yuml;', '&circ;', '&tilde;', '&ensp;', '&emsp;', '&thinsp;', '&zwnj;', '&zwj;', '&lrm;', '&rlm;', '&ndash;', '&mdash;', '&lsquo;', '&rsquo;', '&sbquo;', '&ldquo;', '&rdquo;', '&bdquo;', '&dagger;', '&dagger;', '&permil;', '&lsaquo;', '&rsaquo;', '&euro;', '&fnof;', '&alpha;', '&beta;', '&gamma;', '&delta;', '&epsilon;', '&zeta;', '&eta;', '&theta;', '&iota;', '&kappa;', '&lambda;', '&mu;', '&nu;', '&xi;', '&omicron;', '&pi;', '&rho;', '&sigma;', '&tau;', '&upsilon;', '&phi;', '&chi;', '&psi;', '&omega;', '&alpha;', '&beta;', '&gamma;', '&delta;', '&epsilon;', '&zeta;', '&eta;', '&theta;', '&iota;', '&kappa;', '&lambda;', '&mu;', '&nu;', '&xi;', '&omicron;', '&pi;', '&rho;', '&sigmaf;', '&sigma;', '&tau;', '&upsilon;', '&phi;', '&chi;', '&psi;', '&omega;', '&thetasym;', '&upsih;', '&piv;', '&bull;', '&hellip;', '&prime;', '&prime;', '&oline;', '&frasl;', '&weierp;', '&image;', '&real;', '&trade;', '&alefsym;', '&larr;', '&uarr;', '&rarr;', '&darr;', '&harr;', '&crarr;', '&larr;', '&uarr;', '&rarr;', '&darr;', '&harr;', '&forall;', '&part;', '&exist;', '&empty;', '&nabla;', '&isin;', '&notin;', '&ni;', '&prod;', '&sum;', '&minus;', '&lowast;', '&radic;', '&prop;', '&infin;', '&ang;', '&and;', '&or;', '&cap;', '&cup;', '&int;', '&there4;', '&sim;', '&cong;', '&asymp;', '&ne;', '&equiv;', '&le;', '&ge;', '&sub;', '&sup;', '&nsub;', '&sube;', '&supe;', '&oplus;', '&otimes;', '&perp;', '&sdot;', '&lceil;', '&rceil;', '&lfloor;', '&rfloor;', '&lang;', '&rang;', '&loz;', '&spades;', '&clubs;', '&hearts;', '&diams;');
        var arr2 = new Array('&#160;', '&#161;', '&#162;', '&#163;', '&#164;', '&#165;', '&#166;', '&#167;', '&#168;', '&#169;', '&#170;', '&#171;', '&#172;', '&#173;', '&#174;', '&#175;', '&#176;', '&#177;', '&#178;', '&#179;', '&#180;', '&#181;', '&#182;', '&#183;', '&#184;', '&#185;', '&#186;', '&#187;', '&#188;', '&#189;', '&#190;', '&#191;', '&#192;', '&#193;', '&#194;', '&#195;', '&#196;', '&#197;', '&#198;', '&#199;', '&#200;', '&#201;', '&#202;', '&#203;', '&#204;', '&#205;', '&#206;', '&#207;', '&#208;', '&#209;', '&#210;', '&#211;', '&#212;', '&#213;', '&#214;', '&#215;', '&#216;', '&#217;', '&#218;', '&#219;', '&#220;', '&#221;', '&#222;', '&#223;', '&#224;', '&#225;', '&#226;', '&#227;', '&#228;', '&#229;', '&#230;', '&#231;', '&#232;', '&#233;', '&#234;', '&#235;', '&#236;', '&#237;', '&#238;', '&#239;', '&#240;', '&#241;', '&#242;', '&#243;', '&#244;', '&#245;', '&#246;', '&#247;', '&#248;', '&#249;', '&#250;', '&#251;', '&#252;', '&#253;', '&#254;', '&#255;', '&#34;', '&#38;', '&#60;', '&#62;', '&#338;', '&#339;', '&#352;', '&#353;', '&#376;', '&#710;', '&#732;', '&#8194;', '&#8195;', '&#8201;', '&#8204;', '&#8205;', '&#8206;', '&#8207;', '&#8211;', '&#8212;', '&#8216;', '&#8217;', '&#8218;', '&#8220;', '&#8221;', '&#8222;', '&#8224;', '&#8225;', '&#8240;', '&#8249;', '&#8250;', '&#8364;', '&#402;', '&#913;', '&#914;', '&#915;', '&#916;', '&#917;', '&#918;', '&#919;', '&#920;', '&#921;', '&#922;', '&#923;', '&#924;', '&#925;', '&#926;', '&#927;', '&#928;', '&#929;', '&#931;', '&#932;', '&#933;', '&#934;', '&#935;', '&#936;', '&#937;', '&#945;', '&#946;', '&#947;', '&#948;', '&#949;', '&#950;', '&#951;', '&#952;', '&#953;', '&#954;', '&#955;', '&#956;', '&#957;', '&#958;', '&#959;', '&#960;', '&#961;', '&#962;', '&#963;', '&#964;', '&#965;', '&#966;', '&#967;', '&#968;', '&#969;', '&#977;', '&#978;', '&#982;', '&#8226;', '&#8230;', '&#8242;', '&#8243;', '&#8254;', '&#8260;', '&#8472;', '&#8465;', '&#8476;', '&#8482;', '&#8501;', '&#8592;', '&#8593;', '&#8594;', '&#8595;', '&#8596;', '&#8629;', '&#8656;', '&#8657;', '&#8658;', '&#8659;', '&#8660;', '&#8704;', '&#8706;', '&#8707;', '&#8709;', '&#8711;', '&#8712;', '&#8713;', '&#8715;', '&#8719;', '&#8721;', '&#8722;', '&#8727;', '&#8730;', '&#8733;', '&#8734;', '&#8736;', '&#8743;', '&#8744;', '&#8745;', '&#8746;', '&#8747;', '&#8756;', '&#8764;', '&#8773;', '&#8776;', '&#8800;', '&#8801;', '&#8804;', '&#8805;', '&#8834;', '&#8835;', '&#8836;', '&#8838;', '&#8839;', '&#8853;', '&#8855;', '&#8869;', '&#8901;', '&#8968;', '&#8969;', '&#8970;', '&#8971;', '&#9001;', '&#9002;', '&#9674;', '&#9824;', '&#9827;', '&#9829;', '&#9830;');
        return this.swapArrayVals(s, arr1, arr2);
    },
    htmlDecode: function (s) {
        var c, m, d = s;
        if (this.isEmpty(d)) return "";
        d = this.HTML2Numerical(d);
        arr = d.match(/&#[0-9]{1,5};/g);
        if (arr != null) {
            for (var x = 0; x < arr.length; x++) {
                m = arr[x];
                c = m.substring(2, m.length - 1);
                if (c >= -32768 && c <= 65535) {
                    d = d.replace(m, String.fromCharCode(c));
                } else {
                    d = d.replace(m, "");
                }
            }
        }
        return d;
    },
    swapArrayVals: function (s, arr1, arr2) {
        if (this.isEmpty(s)) return "";
        var re;
        if (arr1 && arr2) {
            if (arr1.length == arr2.length) {
                for (var x = 0, i = arr1.length; x < i; x++) {
                    re = new RegExp(arr1[x], 'g');
                    s = s.replace(re, arr2[x]);
                }
            }
        }
        return s;
    }
};

var wall = {};
var cache = {};

wall.scrollElem;


$(function() {
  $('abbr.timeago').timeago();

  $('.wallitem').live('mouseover mouseout', function(event) {
    if (event.type == 'mouseover') {
      $(this).children('.remove-wallitem').css('opacity', 1);
      $(this).siblings('.remove-wallitem').css('opacity', 0);
    } else {
      $(this).children('.remove-wallitem').css('opacity', 0);
      $(this).siblings('.remove-wallitem').css('opacity', 1);
    }
  });
});


$(function() {
  $('#wallitem-post-button').click(function() {
    if (wall.getContentEditableText('wallitem-input').trim().length > 0) {
      var loggedin = loginSignup.getStatus();
      if (loggedin) {
        wall.postWallitem();
      } else {
        loginSignup.showDialog('wall post');
      }
    }
    return false;
  });
});


wall.getContentEditableText = function(id) {
  var ce = $('<pre />').html($('#' + id).html());
  if ($.browser.webkit)
    ce.find('div').replaceWith(function() { return '\n' + this.innerHTML; });
  if ($.browser.msie)
    ce.find('p').replaceWith(function() { return this.innerHTML + '<br>'; });
  if ($.browser.mozilla || $.browser.opera || $.browser.msie)
    ce.find('br').replaceWith('\n');
  return ce.text();
}


wall.postWallitem = function() {
  var text = wall.getContentEditableText('wallitem-input').trim();
  var matches = text.match(/@[\w-']+/g);
  for (i in matches) {
    var name = matches[i].replace(/@/, '');
    var id = $('#autocomplete-results').data(name);
    name = name.replace(/-/g, ' ');
    text = text.replace(matches[i], '<place id="'+id+'">'+name+'</place>');
  }

  $.post(baseUrl+'wallitems/ajax_save', {tripId:tripId, content:text},
    function(r) {
      var r = $.parseJSON(r);
      wall.displayWallitem(r);
    });
};


wall.displayWallitem = function(r) {
  var html = [];
  if (r.parentId) {
    html[0] = '<div class="wallitem reply" id="wallitem-'+r.id+'">';
      html[1] = '<div class="postcontent">'+r.content+'</div>';
      html[2] = '<div class="actionbar">';    
        html[3] = '<a href="'+baseUrl+'profile/'+r.userId+'" class="author">'+r.userName+'</a> ';
        html[4] = '<a class="like-button" href="#">Like</a>';
        html[5] = '<abbr class="timeago" title="'+r.created+'">'+r.created+'</abbr>';
      html[6] = '</div>';
      html[7] = '<div class="remove-wallitem"></div>';
    html[8] = '</div>';    
  } else {
    html[0] = '<div class="wallitem" id="wallitem-'+r.id+'">';
      html[1] = '<div class="postcontent">'+r.content+'</div>';
      html[2] = '<div class="actionbar">';
        html[3] = '<a href="'+baseUrl+'profile/'+r.userId+'">';
          html[4] = '<img src="'+staticSub+'profile_pics/'+r.userPic+'" height="22" width="22"/>';
        html[5] = '</a> ';
        html[6] = '<a href="'+baseUrl+'profile/'+r.userId+'" class="author">'+r.userName+'</a> ';
        html[7] = '<a class="reply-button" href="#">Add comment</a>';
        html[8] = '<a class="like-button" href="#">Like</a>';
        html[9] = '<abbr class="timeago" title="'+r.created+'">'+r.created+'</abbr>';
      html[10] = '</div>';
      html[11] = '<div class="remove-wallitem"></div>';
    html[12] = '</div>';
  }
  html = html.join('');
  
  if (r.parentId) {
    $('#wallitem-'+r.parentId).append(html);
  } else {
    $('#wall').append(html);  
    $('#wallitem-input').html('');
  }
  $('abbr.timeago').timeago();
  wall.bindLike();
  
  var a = $(html).find('a.place');
  var i = $('a.place').length-1;
  map.displayWallMarkers(i, a.attr('lat'), a.attr('lng'));
};


$(function() {
  $('.remove-wallitem').live('click', function() {
    // TODO: ask user to confirm removal
    var regex = /^wallitem-(\d+)$/;
    var match = regex.exec($(this).parent().attr('id'));
    
    var postData = {
      id: match[1]
    };
    
    $.ajax({
      type: 'POST',
      url: baseUrl+'wallitems/ajax_remove',
      data: postData,
      success: function(r) {
        var r = $.parseJSON(r);
        wall.removeWallitem(r.id);
      }
    });
  });
});


wall.removeWallitem = function(id) {
  $('#wallitem-'+id).fadeOut(300, function() {
    $(this).remove();
  });
};


$(function() {
  $('.reply-button').click(function() {
    var parentId = $(this).parent().parent().attr('id');
    var regex = /^wallitem-(\d+)$/;
    var match = regex.exec(parentId);
    parentId = match[1];
    
    wall.removeReplyBox(parentId);
    var replyBox = $('<div class="reply-box" style="margin-left:48px;"><textarea style="height:14px; display:block; overflow:hidden; resize:none; line-height:13px; width:450px;"></textarea></div>');
    $(this).parent().parent().append(replyBox);
    var replyInput = replyBox.children('textarea');
    replyInput.focus();
    wall.loadReplyEnter(replyInput);
    return false;
  });
});


// hitting enter posts the reply
wall.loadReplyEnter = function(replyInput) {
  replyInput.keydown(function(e) {
    var keyCode = e.keyCode || e.which,
        enter = 13;
    if (keyCode == enter) {
      e.preventDefault();
      var loggedin = loginSignup.getStatus();
      var parentId = replyInput.parent().parent().attr('id').match(/^wallitem-(\d+)$/)[1];
      if (loggedin) {
        wall.postReply(parentId);
      } else {
        loginSignup.showDialog('wall reply', parentId);
      }
    }
  });
};


wall.postReply = function(parentId) {  
  var postData = {
    tripId: tripId,
    parentId: parentId,
    content: $('#wallitem-'+parentId).find('textarea').val()
  };
  
  $.ajax({
    type: 'POST',
    url: baseUrl+'wallitems/ajax_save',
    data: postData,
    success: function(r) {
      var r = $.parseJSON(r);
      wall.displayWallitem(r);
      wall.removeReplyBox(parentId);
      wall.bindLike();
    }
  });  
};


wall.removeReplyBox = function(parentId) {
  $('#wallitem-'+parentId).find('.reply-box').remove();
};


wall.bindLike = function() {
  $('a.like-button, a.unlike-button').unbind();
  $('a.like-button').click(function() {
    var loggedin = loginSignup.getStatus();
    var regex = /^wallitem-(\d+)$/;
    var match = regex.exec($(this).parent().parent().attr('id'));
    var wallitemId = match[1];
    if (loggedin) {
      wall.saveLike(wallitemId, 1);
    } else {
      loginSignup.showDialog('wall like', wallitemId, 1);
    }
    return false;
  });

  $('a.unlike-button').click(function() {
    var loggedin = loginSignup.getStatus();
    if (loggedin) {
      var regex = /^wallitem-(\d+)$/;
      var match = regex.exec($(this).parent().parent().attr('id'));
      var wallitemId = match[1];
      wall.saveLike(wallitemId, 0);
    } else {
      loginSignup.showDialog('wall like', wallitemId, 0);
    }
    return false;
  });
};


wall.saveLike = function(wallitemId, isLike) {
  var postData = {
    wallitemId: wallitemId,
    isLike: isLike
  };
  
  $.ajax({
    type: 'POST',
    url: baseUrl+'wallitems/ajax_save_like',
    data: postData,
    success: function(r) {
      var r = $.parseJSON(r);
      if (r.success) {
        wall.displayLike(r.wallitemId, r.isLike);
      } else {
        alert('something broken. Tell David to fix it.');
      }
    }
  });
};


wall.displayLike = function(wallitemId, isLike) {
  var actionbar = $('#wallitem-'+wallitemId).children('div.actionbar');
  var numLikes = actionbar.children('span.num-likes');
  var regex = /^\d+/;
  var match = regex.exec(numLikes.html());
  if (isLike == 1 && match == null) {
    actionbar.children('abbr.timeago').before('<span class="num-likes">1 person likes this</span>');
  } else if (isLike == 1) {
    var n = match[0];
    if (n == 1) {
      numLikes.html('2 people like this');
    } else {
      n++;
      numLikes.html(n+' people like this');
    }
  } else if (isLike == 0) {
    var n = match[0];
    if (n == 2) {
      numLikes.html('1 person likes this');
    } else {
      n--;
      numLikes.html(n+' people like this');
    }
  }
  wall.unbindLike(wallitemId, isLike);
};


wall.unbindLike = function(wallitemId, isLike) {
  var actionbar = $('#wallitem-'+wallitemId).children('div.actionbar');
  if (isLike == 1) {  
    var like = actionbar.children('a.like-button');
    like.removeClass('like-button').addClass('unlike-button').html('Unlike');
  } else {
    var unlike = actionbar.children('a.unlike-button');
    unlike.removeClass('unlike-button').addClass('like-button').html('Like');
  }
  wall.bindLike();
};


wall.bindPlaces = function(marker, i) {
  $('a.place:eq('+i+')').click(function() {
    $(document).trigger('click');
    map.googleMap.panTo(marker.getPosition());
    var image = new google.maps.MarkerImage('http://dev.shoutbound.com/david/images/marker_sprite.png',
      new google.maps.Size(20, 34),
      new google.maps.Point(20, 0),
      new google.maps.Point(10, 34));
    marker.setOptions({
      icon: image
    });

    // highlight corresponding wallitem text
    var placeText = $(this);
    placeText.animate({
      backgroundColor: '#fffb2c',
    }, 250, function() {
      $(document).one('click', function() {
        // reset text and marker icon when user clicks elsewhere
        placeText.css({'background-color': '#ffffff'});
        
        image = new google.maps.MarkerImage('http://dev.shoutbound.com/david/images/marker_sprite.png',
          new google.maps.Size(20, 34),
          new google.maps.Point(0, 0),
          new google.maps.Point(10, 34));
        marker.setOptions({
          icon: image
        });
      });
    });
    
    return false;
  });
};


// use the first element that is scrollable
wall.scrollableElement = function(els) {
  for (var i = 0, argLength = arguments.length; i <argLength; i++) {
    var el = arguments[i],
        $scrollElement = $(el);
    if ($scrollElement.scrollTop()> 0) {
      return el;
    } else {
      $scrollElement.scrollTop(1);
      var isScrollable = $scrollElement.scrollTop()> 0;
      $scrollElement.scrollTop(0);
      if (isScrollable) {
        return el;
      }
    }
  }
  return [];
}


$(function() {
  var isShift = false;
  
  $('#wallitem-input').keyup(function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode == 16) {
      isShift = false;
    }
  }).keydown(function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode == 16) {
      isShift = true;
    }
    if (keyCode == 50 && isShift) {
      wall.insertTextAtCursor('<span id="placeholder">...</span>');
      $(this).html(Encoder.htmlDecode($(this).html()));
      
      var offset = $('#placeholder').offset();
      $('#autocomplete-box').css({
        top: offset.top,
        left: offset.left
      }).show();
      
      $('#autocomplete-input').data('target', $(this).attr('id')).focus();
      wall.autocomplete();
      isShift = false;
      return false;
    }
  });
});


wall.insertTextAtCursor = function(text) {
  var sel, range, html;
  if (window.getSelection) {
    sel = window.getSelection();
    if (sel.getRangeAt && sel.rangeCount) {
      range = sel.getRangeAt(0);
      range.insertNode(document.createTextNode(text));
    }
  } else if (document.selection && document.selection.createRange) {
    range = document.selection.createRange();
    range.pasteHTML(text);
  }
}


wall.autocomplete = function() {
  var autocompInput = $('#autocomplete-input');
  autocompInput.keyup(function(e) {
    var keyCode = e.keyCode || e.which;
    // ignore non-char keys
    var nonChars = [9, 13, 16, 17, 18, 20, 33, 34, 35, 36, 37, 38, 39, 40, 45, 91, 93, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 144];
    var query = $.trim($(this).val());
    if ($.inArray(keyCode, nonChars)==-1 && query.length>2) {
      var f = function () {wall.placeAutocomplete(query);};
      wall.delay(f, 250);
    }
  }).keydown(function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode == 27) {
      placeholder = $('#placeholder');
      wall.putCursorBefore(placeholder[0]);
      placeholder.remove();
      $('#autocomplete-box').hide();
      autocompInput.val('');
      $('#autocomplete-results').empty().hide();
    }
  });
  
  $('#autocomplete-close').click(function() {
    var e = $.Event('keydown');
    e.keyCode = 27;
    autocompInput.trigger(e);
    return false;
  });
};


wall.putCursorBefore = function(ele) {
  if (!ele) return;
  var sel, range;
  if (window.getSelection && document.createRange) {
    range = document.createRange();
    range.selectNode(ele);
    range.collapse(true);
    sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
  } else if (document.body.createTextRange) {
    range = document.body.createTextRange();
    range.moveToElementText(ele);
    range.select();
  }
};


wall.delay = (function() {
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();


wall.placeAutocomplete = function(query) {
  $.ajax({
    type: 'POST',
    url: baseUrl+'places/ajax_autocomplete',
    data: {query:query},
    success: function(r) {
      var r = $.parseJSON(r);
      wall.listPlaces(r.places);
    }
  });
};


$(function() {
  $('.loading-places')
    .hide()
    .ajaxStart(function() {
      $(this).show();
    })
    .ajaxStop(function() {
      $(this).hide();
    });
});


wall.listPlaces = function(places) {
  var parent = $('#autocomplete-results');
  parent.empty().show();
  for (var id in places) {
    var div = $('<div></div>');
    div.html('<a href="#" place_id="'+id+'">'+places[id]+'</a>');
    div.click(function() {
      var a = $(this).children('a');
      wall.autocompleteClick(a.attr('place_id'), a.text());
      return false;
    });
    parent.append(div);
  }
};


wall.autocompleteClick = function(id, name) {
  name = name.replace(/ /g, '-');
  var placeholder = $('#placeholder');
  placeholder.before('@' + name);
  wall.putCursorBefore(placeholder[0]);
  var e = $.Event('keydown');
  e.keyCode = 27;
  $('#autocomplete-input').trigger(e);
  $('#autocomplete-results').data(name, id);
  //console.log($('#autocomplete-results').data());
  return false;
};

$(function() {
  wall.bindLike();
  var defaultTab = $('#main-tabs').find('a:first').attr('href').substring(1);
  loadTabs(defaultTab);
});


loadTabs = function(defaultTab) {
  $(window).bind('hashchange', function(e) {
    var tabName = $.param.fragment();
    var path = window.location.pathname;
    var matches = path.match(/\d*$/);
    myUrl = baseUrl+'trips';
    if (tabName) {
      myUrl += '/'+tabName;
    }
    if (matches[0]) {
      myUrl += '/'+matches[0];
    }
    $('li.active').removeClass('active');
    $('#main-tab-container').children(':visible').hide();

    if (tabName == '') {
      $('a[href="#'+defaultTab+'"]').parent().addClass('active');
    } else {
      $('a[href="#'+tabName+'"]').parent().addClass('active');
    }
    
    if (tabName==defaultTab || tabName=='') {
      $('#'+defaultTab+'-tab').show();
      //map.clearMarkers();
      //map.showTabMarkers(defaultTab);
    } else if (cache[tabName]) {
      $('#'+tabName+'-tab').show();
      //map.clearMarkers();
      //map.showTabMarkers(tabName);
    } else {
      $('#main-tab-loading').show();
      $.get(myUrl, function(d) {
        $('#main-tab-loading').hide();
        $('#main-tab-container').append(d);
        $('abbr.timeago').timeago();
        cache[tabName] = $(d);
        //map.saveMarkers(tabName);
        //map.clearMarkers();
        //map.showTabMarkers(tabName);
      });
    }
  });
  
  $(window).trigger('hashchange');
};