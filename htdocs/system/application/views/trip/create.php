<?
$header_args = array(
    'js_paths'=>array(
    ),
    'css_paths'=>array(
    )
);

$this->load->view('core_header', $header_args);
?>
<?=$this->load->view('core_header_end')?>

	<body>
    <?=$this->load->view('core_banner')?>
    <div style="margin-left:auto; margin-right:auto; width:960px;">
      <!-- PROGRESS BAR CONTAINER -->
      <div style="width:240px; display:inline; float:left; position:relative; ">
      
        <!-- PROGRESS BAR -->
        <div style="margin-left:20px; margin-right:20px; margin-top:40px;">
          <div style="border:1px solid black; padding-left:10px;">1. Where and when</div>
          <div style="border:1px solid black; padding-left:10px;">2. People</div>
        </div>
        <!-- PROGRESS BAR ENDS -->
      </div>
      <!-- PROGRESS BAR CONTAINER ENDS -->
      
      
      <!-- TRIP CREATION FORM CONTAINER -->
      <div style="width:718px; display:inline; float:left; position:relative; border-left:1px solid black">
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
            <! -- DESTINATION INPUT BOX -->
            <div style="margin-left:10px; margin-top:10px; border:1px solid black;">
              add another destination
            </div>
          </div>
          <!-- DESTINATION BOX ENDS -->
          
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
          </div>
          <!-- DATE PICKER BOX ENDS -->
          
          
        </div>
        <!-- DESTINATION AND DATES CONTAINER ENDS -->
      </div>
      <!-- TRIP CREATION FORM CONTAINER ENDS -->
      
      
    </div>
	
	</body>
</html>
