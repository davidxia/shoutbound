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
        <!-- DESTINATION AND DATES CONTAINER -->
        <div style="margin-left:20px; margin-right:20px; margin-top:40px; position:relative; float:left; width:679px; border:1px solid black;">
          <!-- DESTINATION BOX -->
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

          <! -- DESTINATION INPUT BOX -->
          <div style="margin-left:10px; margin-top:10px; border:1px solid black; float:left;">
            add another destination
          </div><!-- DESTINATION BOX ENDS -->
          
        </div><!-- DESTINATION AND DATES CONTAINER ENDS -->
        
        <div class="back-button">Back</div>
        <div class="next-button">Next</div>
        
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
    };

    var showPart2 = function() {
      $('#part1-indicator').css('background-color', 'transparent');
      $('#part2-indicator').css('background-color', '#D0D0FF');
      $('#part3-indicator').css('background-color', 'transparent');
      $('div.back-button').fadeIn(300).click(function() {
        showPart1();
      });
      $('div.next-button').unbind();
      $('div.create-button').unbind().removeClass('create-button').addClass('next-button').html('Next');
      $('div.next-button').click(function() {
        showPart3();
      });    
    }
    
    var showPart3 = function() {
      $('#part2-indicator').css('background-color', 'transparent');
      $('#part3-indicator').css('background-color', '#D0D0FF');
      $('div.back-button').unbind().click(function() {
        showPart2();
      });
      $('div.next-button').unbind().removeClass('next-button').addClass('create-button').html('Create');
      $('div.create-button').click(function() {
        alert('youve created a trip');
      });
    };

  });
</script>
