<?php
$header_args = array(
    'title' => 'Edit trail | Shoutbound',
    'css_paths'=>array(
        'css/excite-bike/jquery-ui-1.8.13.custom.css',
        'css/settings.css',
    ),
    'js_paths'=>array(
        'js/common.js',
        'js/settings/profile.js',
        'js/jquery/jquery-ui-1.8.13.custom.min.js',
        'js/jquery/jquery-dynamic-form.js',
        'js/jquery/validate.min.js',
    )
);
$this->load->view('core_header', $header_args);
?>
<style type="text/css">
  table.ui-datepicker-calendar{
    display:none;
  }
</style>
<!-- JAVASCRIPT CONSTANTS --> 
<script type="text/javascript">
  var baseUrl = '<?=site_url()?>';
  var uid = <?=$user->id?>;
  var swLat = -50;
  var swLng = -180;
  var neLat = 50;
  var neLng = 180;
</script>
</head>

<body>
  <div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>
  
    <div id="col-left">
      <div id="settings-header">
        Manage your Shoutbound account.
      </div>    
      <div id="left-content-container">
      
        <ul id="tab-style">
          <li><a href="<?=site_url('settings')?>">Account</a></li>
          <li><a href="<?=site_url('settings/profile')?>">Profile</a></li>
          <li class="active"><a>Places</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
          <div id="trail-tab" class="main-tab-content">
            Where I've been

            <div>
              <? if (!$user->past_places):?>
                Show off where you've been!
              <? endif;?>
              
              <? foreach($user->past_places as $place):?>
                <div>
                  <span class="place" lat="<?=$place->lat?>" lng="<?=$place->lng?>" title="<?=$place->name?>">
                    <a href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a><? if($place->country){echo ', '.$place->country;}?>
                  </span>
                <? if ($place->timestamp):?>
                  <?=date('F Y', $place->timestamp)?>
                <? endif;?>
              </div>
              <? endforeach;?>
              
            </div>

            <form id="places-been-form">
              <fieldset>
                <div style="display:inline-block; margin-bottom:5px;">Places</div>
                <div style="display:inline-block; margin-left:260px; margin-bottom:5px;">Dates (optional)</div>
                <div class="places_dates" style="position:relative; margin-bottom:10px;">
                  <a id="add-place" href="#" style="position:absolute; top:15px; left:-15px; font-size:13px;">[+]</a>
                  <a id="subtract-place" href="" style="position:absolute; top:-2px; left:-15px;">[-]</a>
                  <div class="field place" style="margin-bottom:10px; float:left; position:relative; width:312px;">
                    <span class="label-and-errors">
                      <label for="place"></label>
                      <span class="error-message" style="float:right;"></span>
                    </span>
                    <input id="place" class="place-input" name="place" type="text" style="width:300px;" autocomplete="off"/>
                    <img class="loading-places" src="<?=site_url('static/images/ajax-loader.gif')?>" width="16" height="16" style="display:none; position:absolute; right:12px; top:3px;"/>
                    <input id="place_id" class="place_id" name="place_id" type="hidden"/>
                  </div>
                  
                  <div class="field dates" style="width:251px; margin-left:325px;">
                    <span class="label-and-errors">
                      <span class="error-message" style="float:right;"></span>
                    </span>
                    <label for="date">date</label>
                    <input id="date" class="date" name="date" type="text" size="10"/> 
                  </div>
                </div>
              </fieldset>

              <div id="save-settings-container">
                <input type="submit" id="save-places-been" value="Save" class="save-settings-button"/>
                <span id="save-response" class="response"></span>
              </div>
            </form>
            
          </div><!-- TAB ENDS -->
        </div><!-- TAB CONTAINER ENDS -->
      </div><!-- CONTENT ENDS -->
    </div><!--LEFT COL ENDS-->

    <!-- RIGHT COLUMN -->
    <div id="col-right">
      <!-- MAP -->
      <div id="map-shell">
        <div id="map-canvas"></div>
      </div>
    </div><!-- RIGHT COLUMN ENDS -->
    
  </div><!-- WRAPPER ENDS -->
  </div><!--CONTENT ENDS-->  
  </div><!--STICKY FOOTER WRAPPER ENDS-->
  <? $this->load->view('templates/footer')?>
</body>
</head>