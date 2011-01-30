<?
    $header_args = array(
        'css_paths'=>array(
            'css/home.css',
            'css/grid.css',
        ),
        'js_paths'=>array(
            //'js/profile/profile.js',
			'js/trip/create.js',
        )
        
    );
    echo($this->load->view('core_header', $header_args));
?>


</head> 
<body>

	<div id="div_to_popup"></div>

    <?
        $banner_args = array('user'=>$user);
        echo($this->load->view('core_banner', $banner_args));
    ?>
  
    <div id="main" class="container_12">
        
        <div id="col1" class="grid_6">
			<div id="recent-activity">
				<div id="recent-activity-header">Recent activity</div>
				
				<?=$this->load->view('profile_feed', '', true); ?>

			</div>

            	<!--<div id="avatar">
                	<img src="http://graph.facebook.com/<?=$user['fid']?>/picture?type=large" />
            	</div>-->

            <div id="home-trips">
				<div id="home-trips-header">Your trips</div>
                <ul>        
                    <?php if(!sizeof($trips)): ?>
                    <li>You don't have any trips yet...</li>
                    <?php endif; ?>

                    <?php foreach($trips as $trip): ?>
                    <li>
                        <div class="home-trip">
                            <a href="<?php echo site_url('trip/details/'.$trip['tripid'])?>"><?php echo $trip['name']; ?></a>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>
        
        
        <div id="col2" class="grid_6">            
                <div id="home-friends">
                    <div id="home-friends-header">Your noqnok friends</div>
                    <?php foreach($user_friends as $user_friend): ?>
                        <div class="friend-capsule">
                                <img class="square-50" src="http://graph.facebook.com/<?=$user_friend['fid']?>/picture?type=square" />
                            
                            <div class="friend-capsule-name"><?php echo $user_friend['name']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                

                <div id="home-friends-trips">
                    <div id="home-friends-trips-header">Your friends' trips</div>
                    
                    <?php foreach($friends_trips as $friends_trip): ?>
                        <?php foreach($friends_trip['users'] as $user) {
                            if($user['uid'] != $this->user['uid']) {
                                $planners[] = $user['name'];
                            }
                        } ?>
                    <div class="home-friends-trip">
                        <a href="<?=site_url('trip/details/'.$friends_trip['tripid']);?>"><?php echo $friends_trip['name']; ?></a>
                        posted by <?php foreach($planners as $planner) {echo $planner.', '; }; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                

            
        </div>
</div>

</body> 
</html>