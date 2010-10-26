<div id="nn-sidebar">
    <?
        $available_navs = array('home', 'profile');
    ?>
    <ul>
        <li>
            <div class="sidebar-title"><h3>Trips</h3><br/></div>
        </li>
        
        <? 
        if(!$current_trip) $current_trip = array();
        
        foreach($trips as $trip) { 
        ?>
            
        <li>

            <? if($trip['tripid'] == $current_trip['tripid']) { ?>    
                <div class="sidebar-item sidebar-item-selected">
                        <?=$trip['name']?>
                </div>  
            <? } else { ?>
                <div class="sidebar-item">
                    <a href="<?=site_url('trip/details/'.$trip['tripid'])?>">
                        <?=$trip['name']?>
                    </a>
                </div>
            <? } ?>
                
        </li>
        
        <? } ?>
    </ul>
    
    
    
    
    
</div>