<html>
<head>
  <title>SimpleGeo test</title>

  <link rel="stylesheet" href="<?=site_url('static/css/simplegeo.css')?>" type="text/css" media="screen" charset="utf-8" />
  <link rel="stylesheet" href="<?=site_url('static/css/common.css')?>" type="text/css" media="screen" charset="utf-8" />
  
  <script src="<?=site_url('static/js/jquery/jquery.js')?>"></script>
  <script type="text/javascript" src="<?=site_url('static/js/simplegeo/polymaps.min.js')?>"></script>
  <script src="<?=site_url('static/js/simplegeo/simplegeo.all.jq.min.js')?>"></script>

</head>

<body>
  <div id="searchbox">
    <h1>SimpleGeo Places Search</h1>
    <input type="text" id="search"/>
  </div>

  <div>
    <h1>Address Search</h1>
    <input type="text" id="address"/>
  </div>

  <div class="demo-frame" style="width:500px; height:400px; padding:2px;">
    <div class="demo-map">
      <div class="the-map"></div>
      <div class="tooltip">
        <div class="tooltip-inner">
          <div class="stuff"></div>
        </div>
        <div class="carat"></div>
      </div>
    </div>
  </div>
<script type="text/javascript">
var _gaq = _gaq || [];

$(document).ready(function(){

  var client = new simplegeo.PlacesClient('4H36bBJ4CmvMxDWnuDwt8wUwWsrzPjcS');
  
  var po = org.polymaps;
  var map = po.map()
      .container($(".the-map")[0].appendChild(po.svg("svg")))
      .add(po.interact())
      .on("move", move)
      .on("resize", move);
  
  var icons = {
      marker: function() {
        var path = po.svg("path");
        path.setAttribute("class", "map-poi");
        path.setAttribute("transform", "translate(-16,-28)");
        path.setAttribute("d", "M16,3.5c-4.142,0-7.5,3.358-7.5,7.5c0,4.143,7.5,18.121,7.5,18.121S23.5,15.143,23.5,11C23.5,6.858,20.143,3.5,16,3.5z M16,14.584c-1.979,0-3.584-1.604-3.584-3.584S14.021,7.416,16,7.416S19.584,9.021,19.584,11S17.979,14.584,16,14.584z");
        return path;
      }
    };
  
  
  map.add(po.image()
    .url(po.url("http://{S}tile.cloudmade.com"
    + "/1a1b06b230af4efdbb989ea99e9841af" // http://cloudmade.com/register
    + "/998/256/{Z}/{X}/{Y}.png")
    .hosts(["a.", "b.", "c.", ""])));
  
  
  var dataload = function(e) {
    for (var i = 0; i < e.features.length; i++) {
      var f = e.features[i],
              c = f.element,
              g = f.element = po.svg("g");
      g.appendChild(icons.marker());
      g.setAttribute("transform", c.getAttribute("transform"));
      g.setAttribute("style","cursor:pointer;");
      g.setAttribute("id", f.data.id);
      c.parentNode.replaceChild(g, c);
      var p = map.locationPoint({
          lat: f.data.geometry.coordinates[1],
          lon: f.data.geometry.coordinates[0]
        });
      $(g).hover((function(data,loc){
        return function(e) {
          _gaq.push([data.properties.name]);
          var cats = [];
          for(var c in data.properties.classifiers) {
            cats.push(data.properties.classifiers[c].category)
          }
          $(".demo-map .tooltip-inner .stuff").html("<h5 class='place-name'>"+data.properties.name+"</h5>"+
            "<p class='place-address'>" + data.properties.address + "<br/>"+data.properties.city+", "+data.properties.province+" "+ data.properties.postcode +"<br/>"+ data.properties.phone+"</p>"+
            "<p class='categories'><span>Category:</span> " + cats.join(", ") + 
            (data.properties.tags&&data.properties.tags.length==1&&data.properties.tags[0]!=""?" <span>Tags:</span> " + data.properties.tags.join(", "):"") + "</p>");
          $(".demo-map .tooltip").css({"opacity":1,"display":"block","top":parseInt(loc.y)-30+"px","left":parseInt(loc.x)+20+"px"})
        };
      })(f.data,p),function(){
        $(".demo-map .tooltip").css({"opacity":0,"display":"none"})
      });
    }
  };
  
  
  var geojson = po.geoJson()
                  .on("load", dataload);
  map.add(geojson);
  map.add(po.compass().pan("none"))
  
  
  client.getLocationFromIP(function(err, position) {
    positionMap(err, position);
    client.getLocationFromBrowser({enableHighAccuracy: true}, function(err, position) {
      positionMap(err, position);
    });
  });
  
  function positionMap(err, position) {
    if (err) { 
      (typeof console == "undefined") ? alert(err) : console.error(err);
    } else {
      var coords = position.coords;
      map.center({lat: coords.latitude, lon: coords.longitude});
      map.zoom(15);
    }
  }
  
  //var radius = 10, tips = {};
  var timeout, delay = 300;
  
  function move() {
    if (timeout) clearTimeout(timeout);
    timeout = setTimeout(refresh, delay);
  }
  
  function refresh() {
    var search = document.getElementById("search");
    if (search.value != "") {
      _gaq.push([search.value]);
      timeout = setTimeout(function () {}, delay);
      client.search(map.center().lat, map.center().lon, {q: search.value}, function(err, data) {
        if (err) 
          (typeof console == "undefined") ? alert(err) : console.error(err);
        else
          geojson.features(data.features);
      });
    }
  }
  
  $("#search").change(function(){
    refresh();
    return false;
  });


  ///////////////
  $("#address").change(function(){
    autosuggest();
    return false;
  });

  function autosuggest() {
    var address = document.getElementById('address');
    if (address.value != '') {
      _gaq.push([address.value]);
      timeout = setTimeout(function () {}, delay);
      client.searchFromAddress(address.value, function(err, data) {
        if (err) 
          (typeof console == "undefined") ? alert(err) : console.error(err);
        else
          //geojson.features(data.features);
          console.log(data);
      });
    }
  }

})
 
</script>

</body>
</html> 