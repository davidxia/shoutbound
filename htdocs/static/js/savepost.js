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


$(function() {
  String.prototype.trim = function() {return this.replace(/^([\s\t\n]|\&nbsp\;|<br>)+|([\s\t\n]|\&nbsp\;|<br>)+$/g, '');}

  var sbEditor = new nicEditor({
    fullPanel:false,
    buttonList:['bold','italic','underline','ol','ul','link', 'image'],
    iconsPath: baseUrl+'static/images/nicEditorIcons.gif',
    uploadURI : 'http://yourdomain.com/nicUpload.php'
  }).panelInstance('post-input');
  
  sbEditor.addEvent('focus', function() {
    $('#add-to-trip-main').show();
    $('#save-post-button-container').show();
    $('#post-input').addClass('post-input-selected');
    $('.nicEdit-panelContain').show();
    $('#instruction-bar').show();
    
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


  var isShift = false;
  $('#post-input').keyup(function(e) {
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
      insertTextAtCursor('<span id="placeholder">...</span>');
      $(this).html(Encoder.htmlDecode($(this).html()));
      
      var offset = $('#placeholder').offset();
      $('#autocomplete-box').css({
        top: offset.top,
        left: offset.left
      }).show();
      
      $('#autocomplete-input').data('target', $(this).attr('id')).focus();
      autocomplete();
      isShift = false;
      return false;
    }
  });


  $('.loading-places')
    .hide()
    .ajaxStart(function() {
      $(this).show();
    })
    .ajaxStop(function() {
      $(this).hide();
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


insertTextAtCursor = function(text) {
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


autocomplete = function() {
  var autocompInput = $('#autocomplete-input');
  autocompInput.keyup(function(e) {
    var keyCode = e.keyCode || e.which;
    // ignore non-char keys
    var nonChars = [9, 13, 16, 17, 18, 20, 33, 34, 35, 36, 37, 38, 39, 40, 45, 91, 93, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 144];
    var query = $.trim($(this).val());
    if ($.inArray(keyCode, nonChars)==-1 && query.length>2) {
      var f = function () {placeAutocomplete(query);};
      delay(f, 250);
    }
  }).keydown(function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode == 27) {
      placeholder = $('#placeholder');
      putCursorBefore(placeholder[0]);
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


putCursorBefore = function(ele) {
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


delay = (function() {
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();


placeAutocomplete = function(query) {
  $.post(baseUrl+'places/ajax_autocomplete', {query:query, isPost:true},
    function(d) {
      var parent = $('#autocomplete-results');
      parent.empty().html(d).show();
      parent.children().click(function() {
        var a = $(this).children('a'),
            id = a.attr('id').match(/^place-(\d+)$/)[1],
            name = a.text();
        autocompleteClick(id, name);
        return false;
      });
    });
};


autocompleteClick = function(id, name) {
  name = name.replace(/ /g, '-');
  var placeholder = $('#placeholder');
  placeholder.before('@' + name);
  putCursorBefore(placeholder[0]);
  var e = $.Event('keydown');
  e.keyCode = 27;
  $('#autocomplete-input').trigger(e);
  $('#autocomplete-results').data(name, id);
  //console.log($('#autocomplete-results').data());
  return false;
};


savePost = function() {
  var content = convertNewlines(nicEditors.findEditor('post-input').getContent()).trim();
  if (typeof tripId == 'number') {
    var tripIds = [tripId];
  } else {
    var tripIds = $('#trip-selection').multiselect('getChecked').map(function(){
       return this.value;
    }).get();
  }

  var matches = content.match(/@[\w-',]+/g);
  for (i in matches) {
    var name = matches[i].replace(/@/, '');
    var id = $('#autocomplete-results').data(name);
    name = name.replace(/-/g, ' ');
    content = content.replace(matches[i], '<place id="'+id+'">'+name+'</place>');
  }
  //console.log(content);

  $.post(baseUrl+'posts/ajax_save', {content:content, tripIds:tripIds},
    function (d) {
      $('#post-input').text('');
      var r = $.parseJSON(d);
      $('#trip-selection').multiselect('uncheckAll');
      console.log(r);
    });
}