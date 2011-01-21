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
        
        <?
            $sidebar_args = array(
                'user'=>$user,
                'trips'=>$trips,
                'profile_user'=>$profile_user,
            );
            echo($this->load->view('col1', $header_args));
        ?>
        
        
        
        
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
                    Your friends' trips
                    
                    <? foreach($friends_trips as $friends_trip): ?>
                    <div class="friends-trip">
                        asdf
                    </div>
                    <? endforeach; ?>
                </div>
            
        </div>
</div>

</body> 
</html>