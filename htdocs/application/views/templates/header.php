<!-- HEADER -->
<div class="header">
  <div class="wrapper">
    <h1 style="display:inline-block">
      <a href="<?=site_url('/')?>" style="display:block; background:url(http://static.shoutbound.com/images/header-logo.png) no-repeat; width:258px; height:30px; text-indent:-9999px;">Shoutbound
      </a>
    </h1>
    
    <ul class="nav">
      <? if(isset($user->id)):?>
      <li style="display:inline-block; border-right:1px solid #fff; padding:0 20px;">
        <a href="<?=site_url()?>">Home</a>
      </li>
      <li style="display:inline-block; border-right:1px solid #fff; padding:0 20px;">
        <a href="<?=site_url('my_account')?>">My Account</a>
      </li>
      <li style="display:inline-block; border-right:1px solid #fff; padding:0 20px;">
        <a href="<?=site_url('my_account/settings')?>">Settings</a>
      </li>
      <li style="display:inline-block; border-right:1px solid #fff; padding:0 20px;">
        <a href="<?=site_url('logout')?>">Logout</a>
      </li>
      <? else:?>
      <li style="display:inline-block; border-right:1px solid #ddd; padding:0 20px;"><a href="<?=site_url()?>">Home</a></li>
      <li style="display:inline-block; border-right:1px solid #ddd; padding:0 20px;"><a href="<?=site_url('login')?>">Login</a></li>
      <li style="display:inline-block; border-right:1px solid #ddd; padding:0 20px;"><a href="<?=site_url('signup')?>">Sign Up</a></li>
      <? endif;?>
    </ul>
                
  </div>
</div><!-- HEADER ENDS -->