<?
    $header_args = array(
        'css_paths'=>array(
        ),
        'js_paths'=>array(
			'js/trip/create.js',
        )
        
    );
    echo($this->load->view('core_header', $header_args));
?>

<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
    var baseUrl = "<?php echo site_url(""); ?>";
    var staticUrl = "<?php echo static_url(""); ?>";
</script>

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
				
				<?php echo $this->load->view('profile_feed', '', true); ?>

			</div>

            	<!--<div id="avatar">
                	<img src="http://graph.facebook.com/<?php echo $user['fid']; ?>/picture?type=large" />
            	</div>-->

            <div id="home-trips">
				<div id="home-trips-header">Your trips</div>
                <ul>        
                    <?php if(!(count($trips_yes) || count($trips_awaiting) || count($trips_no))){
                        echo "<li>You don't have any trips yet...</li>";
                    } else {
                        if($trips_yes){
                            echo "trips on which you're going";
                            foreach($trips_yes as $trip_yes){ ?>
                                <li><div class="home-trip">
                                    <a href="<?php echo site_url('trip/details/'.$trip_yes['tripid']).'">'.$trip_yes['name']; ?></a>
                                </div></li>
                            <?php }
                        }
                        if($trips_awaiting){
                            echo "<br/>your friends invited you to these trips";
                            foreach($trips_awaiting as $trip_awaiting){ ?>
                                <li><div class="home-trip">
                                    <a href="<?php echo site_url('trip/details/'.$trip_awaiting['tripid']).'">'.$trip_awaiting['name']; ?></a>
                                </div></li>
                            <?php }
                        }
                        if($trips_no){
                            echo "<br/>you rsvped no to these trips";
                            foreach($trips_no as $trip_no){ ?>
                                <li><div class="home-trip">
                                    <a href="<?php echo site_url('trip/details/'.$trip_no['tripid']).'">'.$trip_no['name']; ?></a>
                                </div></li>
                            <?php }
                        }
                    } ?>
                </ul>
            </div>
        </div>
        
        
        <div id="col2" class="grid_6">            
            <div id="home-friends">
                <div id="home-friends-header">Your Shoutbound friends</div>
                <?php foreach($user_friends as $user_friend): ?>
                    <div class="friend-capsule">
                        <img class="square-50" src="http://graph.facebook.com/<?php echo $user_friend['fid']; ?>/picture?type=square" />
                        <div class="friend-capsule-name"><?php echo $user_friend['name']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
                

            <div id="home-friends-trips">
                <div id="home-friends-trips-header">Your friends' trips</div>

                <?php if(!count($friends_trips)){
                    echo "Tell your friends to share some trips with you";
                } else {
                    foreach($friends_trips as $friends_trip){ ?>
                    <div class="home-friends-trip">
                        <a href="<?php echo site_url('trip/details/'.$friends_trip['tripid']).'">'.$friends_trip['name']; ?></a>
                    posted by <?php foreach($friends_trip['users'] as $planner){ echo $planner['name']; } ?>
                    </div>
                <?php }
                } ?>
            </div>

            
        </div>
</div>

</body> 
</html>