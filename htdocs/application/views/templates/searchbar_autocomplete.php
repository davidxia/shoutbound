<ul id="searchbar-autocomplete">
<? if ($users):?>
  People
<? endif;?>
<? foreach ($users as $user):?>
  <li class="search-ac-box">
    <a href="<? if($user->username){echo site_url($user->username);}else{echo site_url('profile/'.$user->id);}?>" class="autocomplete-item"><?=$user->name?></a>
  </li>
<? endforeach;?>

<? if ($trips):?>
  Trips
<? endif;?>
<? foreach ($trips as $trip):?>
  <li class="search-ac-box">
    <a href="<?=site_url('trips/'.$trip->id)?>" class="autocomplete-item"><?=$user->name?></a>
  </li>
<? endforeach;?>

<? if ($places):?>
  Places
<? endif;?>
<? foreach ($places as $key => $val):?>
  <li class="search-ac-box">
    <a href="<?=site_url('places/'.$key)?>" class="autocomplete-item"><?=$val['name']?></a>
  </li>
<? endforeach;?>
</ul>