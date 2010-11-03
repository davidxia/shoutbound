<?
    $header_args = array(
        'css_paths'=>array(
            'css/profile.css',
            //'css/trip.css',
        ),
        'js_paths'=>array(
            'js/profile/profile.js'
        )
        
    );
    echo($this->load->view('core_header',$header_args));
?>    


</head> 
<body>
    <?
        $banner_args = array('user'=>$user);
        echo($this->load->view('core_banner',$banner_args));
    ?>
  
    <div id="nn-body">
        
        <?
            $sidebar_args = array(
                'user'=>$user,
                'trips'=>$trips,
                'profile_user'=>$profile_user,
            );
            echo($this->load->view('core_sidebar',$header_args));
        ?>
        
        <div id="nn-main">
            <? if($profile_user['uid']==$user['uid']){?>
            <h1>Welcome home, <?=first_name($user['name'])?>. <br/>
                Create a new trip to start a conversation with your friends.</h1>
            <? } else { ?>
            <h1>You are viewing <?=first_name($profile_user['name'])?>'s profile. Click on a trip to see what's up!</h1>    
            <? } ?>
            <br/>
            
            <div id="profile-content" class="large-panel">
                <div style="height:130px;">
                    <? if($profile_user['uid']==$user['uid']){?>
                    <button type="button" id="create-trip-button" class="large-button">Create a Trip</button>
                    <?}?>
                </div>
                
                <?
                    $wall_data = array(
                        'news_feed_data' => $news_feed_data
                    );
                ?>
                
                <?=$this->load->view('profile_feed', $wall_data, true)?>
                
                <div id="profile-friends" class="panel">
                    <h3><?=first_name($profile_user['name'])?>'s Friends on noqnok</h3><br/>
                    <? 
                    $counter = 0;
                    foreach($profile_user_friends as $friend) { 
                    if($counter && $counter%3 == 0){
                        //echo('<div class="clear-both"></div>');
                    }    $counter++;
                    ?>
                        <div class="friend-capsule">
                            <a class="nn-link-home" href="<?=site_url('profile/details/'.$friend['uid']);?>">
                                <img class="square-50" src="http://graph.facebook.com/<?=$friend['fid']?>/picture?type=square" />
                            </a>
                            
                            <div class="friend-capsule-name"><?=$friend['name']?></div>
                        </div>
                    <? } ?>
                </div>
                
            </div>
            
            <div id="create-trip-window" class="large-panel">
       
                <p><LABEL for="tripCity" class="large-label">Choose a city: </LABEL>
                <input type="text" name="tripCity" id="trip-city" readonly="true" class="large-input" value="New York (fixed for now)"/></p>
                <br/>
                <p><LABEL for="tripName" class="large-label"> Give your trip a name: </LABEL>
                <input name="tripName" id="trip-name" class="large-input"/></p>
                <br/>
                <p><button type="button" id="save-trip-button" class="large-button">Save!</button>
                    <a class="cancel-link">or</a>
                    <a class="cancel-link" href="javascript:hideCreateTripWindow();">cancel</a><p/>

            </div>
            
        </div>
        
        <div class="clear-both"></div>
  </div>
    
   









</body> 
</html>