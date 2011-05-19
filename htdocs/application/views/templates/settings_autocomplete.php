<div id="autocomplete-results" style="position:absolute;background-color:white;width:275px;border:1px solid gray;padding-left:2px;">
<? foreach ($places as $key => $val):?>
  <div>
    <a href="#" id="place-<?=$key?>"><?=$val?></a>
  </div>
<? endforeach;?>
</div>