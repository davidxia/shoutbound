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
    var baseUrl = "<?=site_url(""); ?>";
    var staticUrl = "<?=static_url(""); ?>";
</script>

</head> 
<body>

	<div id="div_to_popup"></div>

    <?
        $banner_args = array('user'=>$user);
        echo($this->load->view('core_banner', $banner_args));
    ?>
  
    <div id="main">
        
        <div id="col1">
			<div id="feed">
				<div id="feed-header">News feed</div>
				
				<?=$this->load->view('home_feed', '', true)?>

			</div>
        </div>
        
        
        <div id="col2">
            <div id="home-trips">
				<div id="home-trips-header">Your trips</div>
				<? if ( ! count($trips)):?>
                    You don't have any trips yet...
                <? else:?>
                    <? foreach ($trips as $trip):?>
                        <div class="home-trip">
                            <div class="home-trip-name">
                                <a href="<?=site_url('trips/details/'.$trip->id)?>"><?=$trip->name?></a>
                            </div>
                            <div class="home-trip-content">
                                <div class="trip-place">Chatham, MA</div>
                                <div class="trip-startdate">February 23-27, 2011</div>
                                <div class="trip-avatar-container">
                                    <? foreach ($trip->users as $trip_user):?>
                                        <img class="square-50" src="http://graph.facebook.com/<?=$trip_user->fid?>/picture?type=square" />
                                    <? endforeach;?>
                                </div>
                            </div>
                        </div>
                    <? endforeach;?>
                <? endif; ?>
            </div>
            
                
            <div id="home-friends-trips">
				<div id="home-friends-trips-header">Your friends' trips</div>
				<? if ( ! count($advising_trips)):?>
                        Tell your friends to share some trips with you.
                <? else:?>
                    <? foreach ($advising_trips as $advising_trip):?>
                        <div class="home-trip">
                            <div class="home-trip-name">
                                <a href="<?=site_url('trips/details/'.$advising_trip->id)?>"><?=$advising_trip->name?></a>
                            </div>
                            <div class="home-trip-content">
                                <div class="trip-place">Chatham, MA</div>
                                <div class="trip-startdate">February 23-27, 2011</div>
                                <div class="trip-avatar-container">
                                    <? foreach ($advising_trip->users as $trip_user):?>
                                        <img class="square-50" src="http://graph.facebook.com/<?=$trip_user->fid?>/picture?type=square" />
                                    <? endforeach;?>
                                </div>
                            </div>
                        </div>
                    <? endforeach;?>
                <? endif;?>
            </div>
        </div><!-- COL2 END -->
        
    </div><!-- MAIN END -->

</body> 
</html>