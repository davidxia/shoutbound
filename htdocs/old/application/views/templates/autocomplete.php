<ul id="place-autocomplete" style="position:absolute;">
<? foreach ($places as $key => $val):?>
  <li class="autocomplete-item-container">
    <a href="#" class="autocomplete-item" id="place-<?=$key?>" lat="<?=$val['lat']?>" lng="<?=$val['lng']?>"><?=$val['name']?></a>
  </li>
<? endforeach;?>
</ul>