<?php
$header_args = array(
    'title' => 'Edit trail | Shoutbound',
    'css_paths'=>array(
        'css/excite-bike/jquery-ui-1.8.11.custom.css',
        'css/settings.css',
    ),
    'js_paths'=>array(
        'js/settings/trail.js',
        'js/jquery/jquery-ui-1.8.11.custom.min.js',
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
</script>
</head>

<body>
  <div id="sticky-footer-wrapper">
  <? $this->load->view('templates/header')?>
  <? $this->load->view('templates/content')?>
  
    <div id="top-bar">
      <div class="top-bar-header">Manage your Shoutbound account.</div>
    </div>
        
    <div id="col-left">
    
      <div id="left-content-container">
      
        <ul id="main-tabs">
          <li><a href="<?=site_url('settings')?>">Account</a></li>
          <li><a href="<?=site_url('settings/profile')?>">Profile</a></li>
          <li class="active">Trail</li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="main-tab-container" class="tab-container"><!--TAB CONTAINER-->
          <div id="trail-tab" class="main-tab-content">
            Where I've been

            <div>
              <? if (!$user->places):?>
                You don't have a history of your awesome travels. Show off where you've been below.
              <? endif;?>
              <? foreach($user->places as $place):?>
              <div>
                <?=$place->name?>
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
                <a id="save-places-been" href="#">Save</a>
              </fieldset>
            </form>
            
          </div><!-- PROFILE TAB ENDS -->
        </div><!-- TAB CONTAINER ENDS -->
      </div><!-- LEFT CONTENT CONTAINER ENDS -->
  
  </div><!-- CONTENT ENDS -->
  </div><!-- WRAPPER ENDS -->
  </div><!--STICKY FOOTER WRAPPER ENDS-->
  <? $this->load->view('footer')?>
</body>
</head>