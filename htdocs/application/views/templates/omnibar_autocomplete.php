<? foreach ($places as $key => $val):?>
  <div>
    <a href="#" id="place-<?=$key?>" lat="<?=$val['lat']?>" lng="<?=$val['lng']?>"><?=$val['name']?></a>
  </div>
<? endforeach;?>