<?
    $header_args = array(
        'css_paths'=>array(
            'css/settings.css',
            //'css/trip.css',
        ),
        'js_paths'=>array(
            'js/profile/settings.js'
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

    
        <h1>stay in the loop on ShoutBound! <br/>
    choose the notification settings that are right for you.</h1><br/>
        
        <form>
        
        <div class="settings-panel panel">
            <h3>I want to receive notifications when someone posts on one of my trips:</h3><br>
            <input type="checkbox" name="trip_suggestion" 
            <? if($user_settings['trip_suggestion']): ?>checked<?endif;?>
            /> Suggestions<br />
            <input type="checkbox" name="trip_post" 
            <? if($user_settings['trip_post']): ?>checked<?endif;?>
            /> Posts<br />
            <input type="checkbox" name="trip_reply" 
            <? if($user_settings['trip_reply']): ?>checked<?endif;?>
            /> Replies<br />
        </div>

        <div class="settings-panel panel">
            <h3>I want to receive notifications when someone replies to a post I make:</h3><br>
            <input type="radio" name="replies" value="2" 
            <? if($user_settings['replies'] == 2):?>checked<?endif;?>
            /> All Replies<br />
            <input type="radio" name="replies" value="1" 
            <? if($user_settings['replies'] == 1):?>checked<?endif;?>
            /> Only Direct Replies<br />
            <input type="radio" name="replies" value="0" 
            <? if($user_settings['replies'] == 0):?>checked<?endif;?>
            /> None
        </div>
        
        
        <div class="settings-panel panel">
            <button id="save-button">save settings</button>
        </div>
        <span id="status_text"></span>
        
        </form>
    
    </div>
    
</body>
</head>