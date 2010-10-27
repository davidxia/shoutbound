<?
    $header_args = array(
        'css_paths'=>array(
            'css/profile.css',
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
            
            <h1>Welcome to noqnok! Start a discussion about a location by creating a trip or select an existing trip on the left.</h1>

            <br/>
            
            <div id="profile-content" class="large-panel">
                <div style="height:131px;">
                    <button type="button" id="create-trip-button" class="large-button">Create a Trip</button>
                </div>
                
                <div class="panel">
                    <h3>Friends on noqnok</h3><br/>
                    <? foreach($profile_user_friends as $friend) { ?>
                        <div class="friend-capsule">
                            <a class="nn-link-home" href="<?=site_url('profile/details/'.$friend['uid']);?>">
                                <img src="http://graph.facebook.com/<?=$friend['fid']?>/picture?type=square" />
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