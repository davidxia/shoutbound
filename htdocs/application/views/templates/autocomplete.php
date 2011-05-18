<ul id="place-autocomplete" style="position:absolute; background-color:white; width:309px; -moz-border-radius-bottomleft:5px; -moz-border-radius-bottomright:5px; border-bottom-right-radius:5px; border-bottom-left-radius:5px; cursor:pointer;">
<? foreach ($places as $key => $val):?>
  <li style="line-height:25px; padding-left:10px;">
    <a href="#" style="font-size:18px;" id="<?=$key?>"><?=$val?></a>
  </li>
<? endforeach;?>
  <li>was cached: <?=$was_cached?></li>
</ul>