<?
    $header_args = array(
        'css_paths'=>array(
            'css/home.css',
            'css/grid.css',
        ),
        'js_paths'=>array(
            'js/profile/profile.js',
        )
        
    );
    echo($this->load->view('core_header', $header_args));
?>


</head> 
<body>
    <?
        $banner_args = array('user'=>$user);
        echo($this->load->view('core_banner', $banner_args));
    ?>
  
    <div id="main" class="container_12">
        
        <div id="col1" class="grid_6">

            <div id="avatar">
                <img src="http://graph.facebook.com/<?=$user['fid']?>/picture?type=large" />
            </div>    

            <div id="home-trips">
                <span>Welcome, <?=first_name($user['name'])?>. Create a trip and share it with your friends.</span>
                
                <div id="create-trip">
                <button type="button" id="create-trip-button" class="large-button">Create trip</button>
                </div>

                <div id="create-trip-window" class="large-panel">
                    <table><tbody>
                        <tr><td><label for="tripwhat" class="large-label">What</label></td>
                        <td><input type="text" name="tripwhat" id="tripwhat" class="large-input"/></td></tr>

                        <tr><td><label for="tripwhere" class="large-label">Where</label></td>
                        <td><input type="text" name="tripwhere" id="tripwhere" readonly="true" class="large-input" value="New York (fixed for now)"/></td></tr>

                        <tr><td><button type="button" id="save-trip-button" class="large-button">save</button></td>
                        <td><a class="cancel-link" href="javascript:hideCreateTripWindow();">cancel</a></td</tr>
                    </tbody></table>
                </div>

                Your trips
                <ul>        
                    <? if(!sizeof($trips)): ?>
                    <li>You don't have any trips yet...</li>
                    <? endif; ?>

                    <? foreach($trips as $trip): ?>
                    <li>
                        <div class="home-trip">
                            <a href="<?=site_url('trip/details/'.$trip['tripid'])?>"><?=$trip['name']?></a>
                        </div>
                    </li>
                    <? endforeach; ?>
                </ul>

            </div>
        </div>
        
        
        <div id="col2" class="grid_6">
                
                <?
                    $wall_data = array(
                        'news_feed_data' => $news_feed_data,
                    );
                ?>
                
                <?php //$this->load->view('profile_feed', $wall_data, true); ?>
                
                <div id="home-friends">
                    <div id="home-friends-title">Your friends on noqnok</div>
                    <? foreach($user_friends as $user_friend): ?>
                        <div class="friend-capsule">
                            <a class="friend-capsule-link" href="<?=site_url('profile/details/'.$user_friend['uid']);?>">
                                <img class="square-50" src="http://graph.facebook.com/<?=$user_friend['fid']?>/picture?type=square" />
                            </a>
                            
                            <div class="friend-capsule-name"><?=$user_friend['name']?></div>
                        </div>
                    <? endforeach; ?>
                </div>
                
                <div id="friends-trips">
                    <span>Your friends' trips</span>
                    
                    <? foreach($friends_trips as $friends_trip): ?>
                    <div class="friends-trip">
                        <a href="<?=site_url('trip/details/'.$friends_trip['tripid']);?>"><?=$friends_trip['name']?></a>
                        posted by <?=$friends_trip['user']['name']?>
                    </div>
                    <? endforeach; ?>
                </div>
            
        </div>
</div>

</body> 
</html>