<!-- HEADER -->
<div class="header">
  <div class="wrapper">
    <h1 style="display:inline;">
      <a href="<?=site_url('/')?>">Shoutbound
<!--         <img src="<?=static_subdom('images/160x_50_sb_logo.png')?>" alt="Shoutbound" width="160" height="40"/> -->
      </a>
    </h1>
    
    <div class="nav">    	
    </div>      
    
    <div class="nav">    	
      <? if(isset($user->id)):?>
      <a href="<?=site_url()?>">Home</a>
      <a href="<?=site_url('my_account')?>">My Account</a>
      <a href="<?=site_url('my_account/settings')?>">Settings</a>
      <a href="<?=site_url('logout')?>">Logout</a>        
      <? else:?>
      <a href="<?=site_url()?>">Home</a>
      <a href="<?=site_url('login')?>">Login</a>
      <a href="<?=site_url('signup')?>">Sign Up</a>
      <? endif;?>
    </div>
        
  </div>
</div><!-- HEADER ENDS -->