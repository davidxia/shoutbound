<style type="text/css">
.confirm-button{
  width:75px;
  color:white;
  display:block;
  height:30px;
  line-height:30px;
  text-align:center;
  font-weight:bold;
  font-size:11px;
  text-decoration:none;
  background:-webkit-gradient(linear, left top, left bottom, from(#000099), to(#000033));
  background:-moz-linear-gradient(top, #000099 , #000033);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#000099', endColorstr='#000033');
  border: 1px solid #686868;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  display:inline-block;
  float:right;
}
.confirm-button:hover{
  background: #ffad32;
  background: -webkit-gradient(linear, left top, left bottom, from(#ffad32), to(#ff8132));
  background: -moz-linear-gradient(top,  #ffad32,  #ff8132);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffad32', endColorstr='#ff8132');
}
.confirm-button:active{
  background: #ff8132;
  background: -webkit-gradient(linear, left top, left bottom, from(#ff8132), to(#ffad32));
  background: -moz-linear-gradient(top,  #ff8132,  #ffad32);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff8132', endColorstr='#ffad32');
}

.cancel-button{
  width:45px;
  color:white;
  height:30px;
  line-height:30px;
  text-align:center;
  font-weight:bold;
  font-size:11px;
  text-decoration:none;
  background:-webkit-gradient(linear, left top, left bottom, from(#E0E0E0), to(#888888));
  background:-moz-linear-gradient(top, #E0E0E0 , #888888);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#E0E0E0', endColorstr='#888888');
  border: 1px solid #686868;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  display:inline-block;
}
.cancel-button:hover {
  background: green;
  background: -webkit-gradient(linear, left top, left bottom, from(#A80000), to(#980000));
  background: -moz-linear-gradient(top,  #A80000,  #980000);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#A80000', endColorstr='#980000');
}
.cancel-button:active {
  background: #ff8132;
  background: -webkit-gradient(linear, left top, left bottom, from(#ff8132), to(#ffad32));
  background: -moz-linear-gradient(top,  #ff8132,  #ffad32);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff8132', endColorstr='#ffad32');
}
.share-selected{
  background-color:aqua;
}
</style>

<div style="padding:10px; background:rgba(82, 82, 82, 0.7); border-radius: 8px; -webkit-border-radius:8px; -moz-border-radius:8px;">

  <div style="background-color:#FAFAFA;width:320px;padding:10px 10px 10px 10px;">
    <div style="font-size:20px; font-weight:bold; padding-bottom:10px; border-bottom:1px solid #C8C8C8;text-align:center;">
      <? if ($share_role == 5):?>
        Invite others to<br>join you on this trip!
      <? elseif ($share_role == 0):?>
        Share this trip<br>with others!
      <? endif;?>
    </div>
    
    <div id="friends" style="padding:10px 0px 10px 0px;  border-bottom:1px solid #C8C8C8;"><span style="font-size:16px;font-weight:bold;">Following on Shoutbound:</span>
      <ul style="overflow-y:auto;">
        <? foreach ($uninvited_followings as $uninvited_following):?>
          <li uid="<?=$uninvited_following->id?>" class="friend-capsule" style="height:64px; width:134px; margin:3px; cursor:pointer; float:left;">
            <a href="#" style="display:block; height:56px; padding:4px; border-spacing:0; text-decoration:none;">
              <img src="<?=static_sub('profile_pics/'.$uninvited_following->profile_pic)?>" width="50" height="50" style="border:1px solid #E0E0E0; margin-right:5px; padding:2px; display:block; height:50px; width:50px; float:left;"/>
              <span class="friend-name" style="font-size:11px; float:left; display:block; width:65px; margin-top:2px;"><?=$uninvited_following->name?></span>
            </a>
          </li>
        <? endforeach;?>
    	</ul>
    </div>

    <div>
      <div style="font-size:16px; font-weight:bold; padding:10px 0px 10px 0px; border-bottom:1px solid #C8C8C8;">via
        <? if ($share_role == 5):?>
        <a href="#" id="facebook-invite">Facebook</a>
        <? elseif ($share_role == 0):?>
        <a href="#" id="facebook-share">Facebook</a>
        <? endif;?>
      </div>

      <div style="font-size:16px; font-weight:bold; padding:10px 0px 10px 0px; border-bottom:1px solid #C8C8C8;">via
        <? if ($share_role == 5):?>
        <a href="#" id="twitter-invite">Twitter</a>
        <? elseif ($share_role == 0):?>
        <a href="#" id="twitter-share">Twitter</a>
        <? endif;?>
      </div>

      <div style="font-size:16px; padding:10px 0px 10px 0px; border-bottom:1px solid #C8C8C8;">
        <span style="font-weight:bold;">via e-mail:</span>
		    <div id="email-input">
		      <label for="emails" style="font-size:14px; color:gray; margin-bottom:2px; margin-top:5px;">Enter e-mail addresses, separated by commas</label>
		      <input type="text" id="emails" name="emails" style="width:300px;"/>
		    </div>
    	</div>
    </div>
    
    <? if ($share_role == 5):?>
      <label for="deadline">deadline</label>
      <input id="deadline" name="deadline" type="text" size="10" style="margin-top:5px; margin-bottom:10px;"/>
    <? endif;?>

    <div id="trip-share-toolbar" style="margin:10px 0px 10px 0px;">
      <? if ($share_role == 5):?>
      <a href="#" id="confirm-invite" class="confirm-button">Invite</a>
      <a href="#" id="invite-cancel" class="cancel-button" style="margin-left:185px;">cancel</a>
      <? elseif ($share_role == 0):?>
      <a href="#" id="confirm-share" class="confirm-button">Share</a>
      <a href="#" id="share-cancel" class="cancel-button" style="margin-left:185px;">cancel</a>
      <? endif;?>
    </div>

  </div>
</div>

<link rel="stylesheet" href="<?=site_url('static/css/excite-bike/jquery-ui-1.8.11.custom.css')?>" type="text/css" media="screen" charset="utf-8"/></script>
<script type="text/javascript" src="<?=site_url('static/js/jquery/jquery-ui-1.8.11.custom.min.js')?>"></script>

<script type="text/javascript">
  $('#deadline').datepicker();
</script>