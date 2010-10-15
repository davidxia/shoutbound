<div id="trip-wall-body">
    
    <div id="trip-wall-control">
        
        <ul id="trip-wall-control-tab-list">
            <li class="trip-wall-control-tab"><a>+ Suggest</a></li>
            <li class="trip-wall-control-tab"><a>+ Comment</a></li>
        </ul>
        
        <div style="clear:both"></div>
        
        <div id="trip-wall-control-suggest-edit">
            
            <form name="suggestion">
                
                <div class="suggestion-input-wrap"><input class="suggestion-input"></div>
                <button id="submit-suggestion">submit</button>

            </form>
            
            
        </div>
        
        <div id="trip-wall-control-comment-edit">
            This is the editor for commenting some stuff.
        </div>
        
    </div>
    
    <div id="trip-wall-content">
        <ul>
            <?php foreach($wall_items as $item):?>

                <li><?php echo $item['text'];?></li>
            
            <?php endforeach;?>
        </ul>
    </div>
</div>