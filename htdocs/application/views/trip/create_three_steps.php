<?
$header_args = array(
    'js_paths'=>array(
    ),
    'css_paths'=>array(
        'css/common.css',
    )
);

$this->load->view('core_header', $header_args);
?>

<style type="text/css">
  .progress-bar {
    width: 240px;
    height: 48px;
    cursor: pointer;
  }
  #trip-creation-form {
    padding-top: 30px;
  }
  .next-button, .create-button {
    border: 1px solid black;
    margin-top: 40px;
    margin-right: 20px;
    background: #2B72CC url(/david/images/blue_button.png) repeat-x 0 0;
    cursor: pointer;
    height: 40px;
    width: 80px;
    text-align: center;
    line-height: 2.4;
  }
  .next-button:hover, .back-button:hover, .create-button:hover {
    background: url(/david/images/blue_button.png) repeat-x 0 -40px;
  }
  .next-button:active, .back-button:active, .create-button:active {
    background: url(/david/images/blue_button.png) repeat-x 0 -80px;
  }
  .back-button {
    display: none;
    border: 1px solid black;
    margin-top: 40px;
    margin-left: 20px;
    background: #2B72CC url(/david/images/blue_button.png) repeat-x 0 0;
    cursor: pointer;
    height: 40px;
    width: 80px;
    text-align: center;
    line-height: 2.4;
  }
  .next-button a, .back-button a, .create-button a {
    color: white;
    text-decoration: none;
  }
  #summary-invites-field, #interests-field {
    display: none;
  }
  #main table{
    border-collapse: collapse;
  }
  #main th, td {
    padding: 0 0 15px 0;
  }
  #main th {
    text-align: right;
    font-weight: normal;
    font-size: 16px;
    padding-right: 10px;
    min-width: 200px;
  }
  #interests-box td {
    text-align: right;
  }
  .checkbox-name {
    padding-right: 10px;
  }
  .padding-right {
    padding-right: 40px;
  }
  #other-textbox {
    position: absolute;
  }
</style>
 
 
</head>
	<body>
    <div id="wrapper" style="margin: 0 auto; width:960px;">
      <?=$this->load->view('header')?>
      <div id="container" style="overflow:hidden;">
        <!-- PROGRESS BAR -->
        <div style="float:left; ">
          <div id="part1-indicator" class="progress-bar" style="background-color:#D0D0FF;">1. Where and when</div>
          <div id="part2-indicator" class="progress-bar" style="">2. People</div>
          <div id="part3-indicator" class="progress-bar" style="">3. Advice</div>
        </div><!-- PROGRESS BAR ENDS -->
        
        
        <!-- MAIN -->
        <div id="main" style="min-height:500px; margin:0 0 0 240px;">
          <!-- TRIP CREATION FORM -->
          <form id="trip-creation-form" action="" method="post">
            <!-- PLACE DATES FIELD -->
            <fieldset id="place-dates-field" style="border-width:0; border-color:transparent;">
              <table>
                <tbody>
                  <tr>
                    <th>Destination</th>
                    <td><input type="text" size="30" /></td>
                  </tr>
                  <tr>
                    <th>Dates (optional)</th>
                    <td>From <input type="text" size="7"/> to <input type="text" size="7" /></td>
                  </tr>
                </tbody>
              </table>
              <div style="">
                add another destination
              </div>
            </fieldset><!-- PLACE DATES FIELD ENDS -->
            <!-- SUMMARY INVITES FIELD -->
            <fieldset id="summary-invites-field" style="border-width:0; border-color:transparent;">
              <table>
                <tbody>
                  <tr>
                    <th>Trip name</th>
                    <td><input type="text" size="30" /></td>
                  </tr>
                  <tr>
                    <th>Invite people (optional)</th>
                    <td><input type="text" size="30" /></td>
                  </tr>
                  <tr>
                    <th>Deadline (optional)</th>
                    <td><input type="text" /></td>
                  </tr>
                  <tr>
                    <th>Describe your<br/>trip (optional)</th>
                    <td><textarea style="width:450px; height:56px;"></textarea></td>
                  </tr>
                </tbody>
              </table>
            </fieldset><!-- SUMMARY INVITES FIELD ENDS -->
            <!-- INTERESTS FIELD -->
            <fieldset id="interests-field" style="border-width:0; border-color:transparent; position:relative;">
              I'm interested in
              <br/>
              <textarea style="width:482px; height:56px;"></textarea>
              <br/>
              I want suggestions for:
              
              <table>
                <tbody>
                  <tr>
                    <td class="checkbox-name"><label for="accommodation">Accommodation</label></td>
                    <td class="padding-right"><input type="checkbox" name="accommodation" id="accommodation" value="accommodation" /></td>
                    <td class="checkbox-name"><label for="local-attractions">Local attractions</label></td>
                    <td class="padding-right"><input type="checkbox" name="local-attractions" id="local-attractions" value="local-attractions" /></td>
                    <td class="checkbox-name"><label for="other">Other</label></td>
                    <td><input type="checkbox" name="other" id="other" value="other" /></td>
                  </tr>
                  <tr>
                    <td class="checkbox-name"><label for="restaurants">Restaurants</label></td>
                    <td class="padding-right"><input type="checkbox" name="restaurants" id="restaurants" value="accommodation" /></td>
                    <td class="checkbox-name"><label for="bars-nightlife">Bars/nightlife</label></td>
                    <td class="padding-right"><input type="checkbox" name="bars-nightlife" id="bars-nightlife" value="bars-nightlife" /></td>
                  </tr>
                  <tr>
                    <td class="checkbox-name"><label for="landmarks">Landmarks</label></td>
                    <td class="padding-right"><input type="checkbox" name="landmarks" id="landmarks" value="accommodation" /></td>
                    <td class="checkbox-name"><label for="activities-events">Activities/events</label></td>
                    <td class="padding-right"><input type="checkbox" name="activities-events" id="activities-events" value="activities-events" /></td>
                  </tr>
                  <tr>
                    <td class="checkbox-name"><label for="shopping">Shopping</label></td>
                    <td class="padding-right"><input type="checkbox" name="shopping" id="shopping" value="accommodation" /></td>
                    <td class="checkbox-name"><label for="landmarks">Landmarks</label></td>
                    <td class="padding-right"><input type="checkbox" name="landmarks" id="landmarks" value="landmarks" /></td>
                  </tr>
                </tbody>
              </table>
              <textarea id="other-textbox" style="position:absolute; right:120px; top:150px; width:200px; height:63px; display:none;"></textarea>
              Ask specific friends to give you advice for your trip.
              <input type="text" size="40" />
              <br/>
              Share this trip on Facebook and Twitter to get more advice.

            </fieldset><!-- INTERESTS FIELD ENDS -->
            
          </form><!-- TRIP CREATION FORM ENDS -->
          
                      
  
          
          <div class="back-button"><a href="#">Back</a></div>
          <div class="next-button"><a href="#">Next</a></div>
          
        </div><!-- TRIP CREATION FORM CONTAINER ENDS -->
        
      </div><!-- CONTAINER ENDS -->
    </div><!-- WRAPPER ENDS -->
	
	</body>
</html>

<script type="text/javascript">
  $(document).ready(function() {
    $('div.next-button').click(function() {
      showPart2();
    });
    
    $('#part2-indicator').click(function() {
      showPart2();
    });


    var showPart1 = function() {
      $('#part1-indicator').css('background-color', '#D0D0FF');
      $('#part2-indicator').css('background-color', 'transparent');
      $('#part3-indicator').css('background-color', 'transparent');

      $('div.back-button').fadeOut(300);
      $('div.next-button').unbind().click(function() {
        showPart2();
      });
      $('#part1-indicator').unbind();
      $('#part2-indicator').unbind().click(function() {
        showPart2();
      });
      $('#part3-indicator').unbind().click(function() {
        showPart3();
      });
      
      $('#place-dates-field').show();
      $('#summary-invites-field').hide();
      $('#interests-field').hide();
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
      
      $('#part1-indicator').unbind().click(function() {
        showPart1();
      });
      $('#part2-indicator').unbind();
      $('#part3-indicator').unbind().click(function() {
        showPart3();
      });      
      
      $('#place-dates-field').hide();
      $('#summary-invites-field').show();
      $('#interests-field').hide();
    }
    
    
    var showPart3 = function() {
      $('#part1-indicator').css('background-color', 'transparent');
      $('#part2-indicator').css('background-color', 'transparent');
      $('#part3-indicator').css('background-color', '#D0D0FF');
      
      $('div.back-button').unbind().click(function() {
        showPart2();
      });
      $('div.next-button').unbind().removeClass('next-button').addClass('create-button').html('<a href="#">Create</a>');
      $('div.create-button').click(function() {
        alert('youve created a trip');
      });
      
      
      $('#part1-indicator').unbind().click(function() {
        showPart1();
      });
      $('#part2-indicator').unbind().click(function() {
        showPart2();
      });
      $('#part3-indicator').unbind();
      
      $('#place-dates-field').hide();
      $('#summary-invites-field').hide();
      $('#interests-field').show();
    };
    
    
    $('#other').click(function() {
      $('#other-textbox').toggle();
    });

  });
</script>
