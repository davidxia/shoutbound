<?
    $header_args = array(
        'css_paths'=>array(
            'css/settings.css',
            //'css/trip.css',
        ),
        'js_paths'=>array(
            'js/profile/settings.js'
        )
        
    );
    echo($this->load->view('core_header',$header_args));
?>    


</head> 
<body>
    
    <?
        $banner_args = array('user'=>$user);
        echo($this->load->view('core_banner',$banner_args));
    ?>
    <div id="nn-body">

    
        <h1>noqnok resects your privacy. <br/>Choose the settings that are right for you.</h1><br/>
        
        <form>
        
        <div class="settings-panel panel">
            <h3>This is the text that explains what the radio buttons do.</h3><br>
            <input type="radio" name="boom" value="one" /> ONE<br />
            <input type="radio" name="boom" value="two" /> TWO
        </div>
        
        <div class="settings-panel panel">
            <h3>This is the text that explains what the checkboxes do.</h3><br>
            <input type="checkbox" name="boom" value="won" /> WON<br />
            <input type="checkbox" name="boom" value="too" /> TOO
        </div>
        
        <div class="settings-panel panel">
            <button id="save-button">save settings</button>
        </div>
        
        </form>
    
    </div>
    
</body>
</head>