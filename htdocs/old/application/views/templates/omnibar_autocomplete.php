<? foreach ($places as $key => $val):?>
  <div class="autocomplete-item-container">
    <a href="#" id="place-<?=$key?>" class="autocomplete-item" lat="<?=$val['lat']?>" lng="<?=$val['lng']?>"><?=$val['name']?></a>
  </div>
<? endforeach;?>
