<ul id="searchbar-autocomplete">
<? foreach ($places as $key => $val):?>
  <li class="search-ac-box">
    <a href="<?=site_url('places/'.$key)?>" class="autocomplete-item"><?=$val['name']?></a>
  </li>
<? endforeach;?>
</ul>