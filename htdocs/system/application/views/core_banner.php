<div id="banner" class="container_12">
    <div id="logo" class="grid_2">
        <a class="home" href="<?=site_url('home');?>">
            <img src="<?=static_url('images/noqnok-logo.jpg')?>"/>
        </a>
    </div>

		<div id="create-trip" class="grid_4">
        	<a href="javascript: Create.showCreateDialog();">Create trip</a>
        </div>
    
    <ul id="navigation-buttons" class="grid_3 push_3">
    <? if($user): ?>
        <li><a class="navigation" href="<?=site_url('user/logout')?>">Logout</a></li>
        <li><a class="navigation" href="<?=site_url('profile/settings')?>">Settings</a></li>
        <li><a class="navigation" href="<?=site_url('home');?>">Home</a></li>
    <? else: ?>
        You are not logged in!
    <? endif; ?>
    </ul>
  
    <div class="clear"></div>
  
</div>