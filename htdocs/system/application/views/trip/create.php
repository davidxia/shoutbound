<?
$header_args = array(
    'js_paths'=>array(
    ),
    'css_paths'=>array(
    )
);

$this->load->view('core_header', $header_args);
?>

<style type="text/css">
  .next-button, .create-button {
    border: 1px solid black;
    float: right;
    margin-top: 40px;
    margin-right: 20px;
    background: #2B72CC url(/david/static/images/blueButton.png) repeat-x 0 0;
    cursor: pointer;
    height: 40px;
    width: 80px;
    text-align: center;
    line-height: 2.4;
  }
  .next-button:hover, .back-button:hover, .create-button:hover {
    background: url(/david/static/images/blueButton.png) repeat-x 0 -40px;
  }
  .next-button:active, .back-button:active, .create-button:active {
    background: url(/david/static/images/blueButton.png) repeat-x 0 -80px;
  }
  .back-button {
    display: none;
    border: 1px solid black;
    float: left;
    margin-top: 40px;
    margin-left: 20px;
    background: #2B72CC url(/david/static/images/blueButton.png) repeat-x 0 0;
    cursor: pointer;
    height: 40px;
    width: 80px;
    text-align: center;
    line-height: 2.4;
  }
  #name-invite-box, #interests-box {
    display: none;
  }
  textarea, input {
    margin-top: 20px;
  }
</style>
 
 
<?=$this->load->view('core_header_end')?>

	<body>
    <?=$this->load->view('core_banner')?>
    <div style="margin-left:auto; margin-right:auto; width:960px;">
      <!-- PROGRESS BAR CONTAINER -->
      <div style="width:240px; display:inline; float:left; position:relative; ">
      
        <!-- PROGRESS BAR -->
        <div style="margin-left:20px; margin-right:20px; margin-top:40px;">
          <div id="part1-indicator" style="border:1px solid black; padding-left:10px; background-color:#D0D0FF;">1. Where and when</div>
          <div id="part2-indicator" style="border:1px solid black; padding-left:10px;">2. People</div>
          <div id="part3-indicator" style="border:1px solid black; padding-left:10px;">3. Advice</div>
        </div>
        <!-- PROGRESS BAR ENDS -->
      </div>
      <!-- PROGRESS BAR CONTAINER ENDS -->
      
      
      <!-- TRIP CREATION FORM CONTAINER -->
      <div id="trip-creation-form" style="width:718px; display:inline; float:left; position:relative; border-left:1px solid black">
        <!-- PLACE AND DATES BOX -->
        <div id="place-date-box" style="margin-left:20px; margin-right:20px; margin-top:40px; position:relative; float:left; width:679px; border:1px solid black;">
          <!-- PLACE BOX -->
          <div style="float:left; width:35%;">
            <div style="margin-top:10px; margin-left:10px">
              <span style="">Destination</span>
            </div>
            <br/>
            <div style="margin-top:10px; margin-left:10px">
              <span style="font-size:1.5em;">New York</span>
            </div>
          </div>
          
          
          <!-- DATE PICKER BOX -->
          <div style="float:left; width:65%;">
            <div style="margin-left:10px; margin-top:10px;">
              <span style="">Dates (optional)</span>
            </div>
            <div style="margin-top:40px; margin-bottom:20px;">
              <div style="margin-left:10px;">
                from
                <div style="border:1px solid black; display:inline-block; width:150px;">12/12/2012</div>
                to
                <div style="border:1px solid black; display:inline-block; width:150px;">12/24/2012</div>
              </div>
            </div>
          </div><!-- DATE PICKER BOX ENDS -->

          <! -- PLACE INPUT BOX -->
          <div style="margin-left:10px; margin-top:10px; border:1px solid black; float:left;">
            add another destination
          </div><!-- PLACE BOX ENDS -->
          
        </div><!-- PLACE AND DATES BOX ENDS -->
        
        <!-- NAME INVITES BOX -->
        <div id="name-invite-box" style="margin-left:20px; margin-right:20px; margin-top:40px; position:relative; float:left; width:679px; border:1px solid black;">
          <div style="padding:0px 0px 20px 10px; width:669px; border-bottom:1px solid black;">
            My trip is called:
            <input type="text" size="40" />
          </div>
          
          <div style="padding:20px 0px 20px 10px; width:669px; border-bottom:1px solid black;">
            Invite others to join your trip (optional):
            <br/>
            <div style="margin-left:135px;">
              <input type="text" size="40" />
            </div>
            <br/>
            Give them a deadline to respond by (optional):
            <div style="margin-left:135px;">
              <input type="text" />
            </div>
          </div>

          <div style="padding:20px 0px 20px 10px; width:669px;">
            Describe your trip in 140 characters or less (optional)
            <textarea style="width:450px; height:56px;"></textarea>
          </div>
        </div><!-- NAME INVITES BOX ENDS -->
        
        <!-- INTERESTS BOX -->
        <div id="interests-box" style="margin-left:20px; margin-right:20px; margin-top:40px; position:relative; float:left; width:679px; border:1px solid black;">
          <div style="padding:20px 0px 20px 10px; width:669px; border-bottom:1px solid black;">
            On my trip I'm interested in:
            <textarea style="width:482px; height:56px;"></textarea>
          </div>
          
          <div style="padding:20px 0px 20px 10px; width:669px; border-bottom:1px solid black;">
            I want suggestions for:
            <br/>
            <label for="accommodation">Accommodation</label>
            <input type="checkbox" name="accommodation" value="accommodation" />
            <br/>
          </div>

          <div style="padding:20px 0px 20px 10px; width:669px;">
            Ask specific friends to give you advice on your trip:
            <div style="margin-left:135px;">
              <input type="text" size="40" />
            </div>
            <br/>
            Share this trip on Facebook and Twitter to get even more advice.
          </div>        
        </div><!-- INTERESTS BOX ENDS -->
        
        <div class="back-button"><a href="#">Back</a></div>
        <div class="next-button"><a href="#">Next</a></div>
        
      </div><!-- TRIP CREATION FORM CONTAINER ENDS -->
      
    </div>
	
	</body>
</html>

<script type="text/javascript">
  $(document).ready(function() {
    $('div.next-button').click(function() {
      showPart2();
    });


    var showPart1 = function() {
      $('#part1-indicator').css('background-color', '#D0D0FF');
      $('#part2-indicator').css('background-color', 'transparent');
      
      $('div.back-button').fadeOut(300);
      $('div.next-button').unbind().click(function() {
        showPart2();
      });
      
      $('#name-invite-box').hide();
      $('#place-date-box').show();
    };


    var showPart2 = function() {
      $('#part1-indicator').css('background-color', 'transparent');
      $('#part2-indicator').css('background-color', '#D0D0FF');
      $('#part3-indicator').css('background-color', 'transparent');
      
      $('div.back-button').fadeIn(300).click(function() {
        showPart1();
      });
      $('div.next-button').unbind();
      $('div.create-button').unbind().removeClass('create-button').addClass('next-button').html('<a href="#">Next</a>');
      $('div.next-button').click(function() {
        showPart3();
      });
      
      $('#place-date-box').hide();
      $('#interests-box').hide();
      $('#name-invite-box').show();
    }
    
    
    var showPart3 = function() {
      $('#part2-indicator').css('background-color', 'transparent');
      $('#part3-indicator').css('background-color', '#D0D0FF');
      
      $('div.back-button').unbind().click(function() {
        showPart2();
      });
      $('div.next-button').unbind().removeClass('next-button').addClass('create-button').html('<a href="#">Create</a>');
      $('div.create-button').click(function() {
        alert('youve created a trip');
      });
      
      $('#name-invite-box').hide();
      $('#interests-box').show();

    };

  });
</script>
