<ul id="place-autocomplete">
<? foreach ($places as $key => $val):?>
  <li class="autocomplete-item-container">
    <a href="#" class="autocomplete-item" id="place-<?=$key?>" lat="<?=$val['lat']?>" lng="<?=$val['lng']?>"><?=$val['name']?></a>
  </li>
<? endforeach;?>
<!--   <li>was cached: <?=$was_cached?></li> -->
</ul>