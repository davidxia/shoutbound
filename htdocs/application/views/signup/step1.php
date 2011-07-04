<?php
$header_args = array(
    'title' => 'Sign Up step 1 | Shoutbound',
    'css_paths'=>array(
        'css/ui-lightness/jquery-ui-1.8.14.custom.css',
    ),
    'js_paths'=>array(
        'js/jquery/jquery.validate.min',
        'js/signup.js',
        'js/jquery/jquery-ui-1.8.14.custom.min',
    )
);

$this->load->view('templates/core_header', $header_args);
?>

</head>
<body>
<? $this->load->view('templates/header')?>
<? $this->load->view('templates/content')?>

  Thanks for signing up.
  
  We&rsquo;ve sent a welcome email to <?=$user->email?>. In the meantime, complete these steps or we'll go and kill some porpoises.
  
  <form action="<?=site_url('signup/step/2')?>" method="post">
    <label for="first_name">First name</label>
    <input type="text" id="first_name" name="first_name"/>
    <label for="last_name">Last name</label>
    <input type="text" id="last_name" name="last_name"/>
    <select id="gender" name="gender">
      <option value="">Gender</option>
      <option value="1">Male</option>
      <option value="2">Female</option>
    </select>
    <select id="income_range" name="income_range">
      <option value="" selected="selected">Income range</option>
      <option value="1">Less than $30,000</option>
      <option value="2">$30,000 - $44,999</option>
      <option value="3">$45,000 - $59,999</option>
      <option value="4">$60,000 - $74,999</option>
      <option value="5">$75,000 - $99,999</option>
      <option value="6">$100,000 - $199,999</option>
      <option value="7">$200,000 - $299,999</option>
    </select>
    <label for="bday">Birthday</label>
    <input id="bday" name="bday"/>
    <label for="zipcode">Zipcode</label>
    <input id="zipcode" name="zipcode"/>
    <input type="submit" name="save" value="Save"/>
    <input type="submit" name="skip" value="skip"/>
  </form>
  

</div><!-- CONTENT ENDS -->
</div><!-- WRAPPER ENDS -->
<? $this->load->view('templates/footer')?>
</body>
</html>