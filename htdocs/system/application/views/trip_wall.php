<div id="trip-wall-body">
    
    <div id="trip-wall-control">
        <!--
        <ul id="trip-wall-control-tab-list">
            <li class="trip-wall-control-tab"><h3>Search for a Location to Suggest</h3></li>
        </ul>-->
        
        <div style="clear:both"></div>
        
        
        
    </div>

    
    <div id="trip-wall-content">
        <h3> Trip Wall </h3><br/>
        
        <ul>
            <?php foreach($wall_items as $item):?>

                <li><?php echo $item['text'];?></li>
            
            <?php endforeach;?>
        </ul>
    </div>
</div>