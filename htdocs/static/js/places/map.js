var map= {};

$(function() {
  var po = org.polymaps;
  
  var polymap = po.map()
      .container(document.getElementById('map-canvas').appendChild(po.svg('svg')))
      .add(po.drag())
      .add(po.wheel())
      .add(po.dblclick());
  
  polymap.add(po.image()
      .url(po.url('http://{S}tile.cloudmade.com'
      + '/baa414b63d004f45863be327e9145ec4'
      + '/998/256/{Z}/{X}/{Y}.png')
      .hosts(['a.', 'b.', 'c.', ''])));
  
  polymap.extent([{lon:map.swLng, lat:map.swLat}, {lon:map.neLng, lat:map.neLat}]);
  
  polymap.add(po.compass()
      .pan('none'));
});