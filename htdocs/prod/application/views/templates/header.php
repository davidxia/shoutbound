<!-- HEADER -->
<div class="header">
  <div class="wrapper">
    <h1>
      <a href="<?=base_url()?>">Shoutbound
      </a>
    </h1>
    
    <ul class="nav">
      <? if(isset($user->id)):?>
      <li><a href="<?=base_url()?>">Home</a></li>
      <li><a href="<?=site_url('my_account')?>">My Account</a></li>
      <li><a href="<?=site_url('my_account/settings')?>">Settings</a></li>
      <li class="last-child"><a href="<?=site_url('logout')?>">Logout</a></li>
      <? else:?>
      <li><a href="<?=base_url()?>">Home</a></li>
      <li><a href="<?=site_url('login')?>">Login</a></li>
      <li class="last-child"><a href="<?=site_url('signup')?>">Sign Up</a></li>
      <? endif;?>
    </ul>
                
  </div>
</div><!-- HEADER ENDS -->