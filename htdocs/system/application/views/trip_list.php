<div id="trip-list-body">
    
    <div class="panel">
        
        <h3> Make a Suggestion </h3><br/>
        
    </div>
    
    
    <div id="trip-wall-control-suggest-edit">
        
        <form name="suggestion">
            
            <div class="suggestion-input-wrap">
                <input id="term" class="suggestion-input">
                <button id="submit-suggestion">search</button>
            </div>
            

        </form>
        
        <div id="trip-wall-suggest-list-wrapper">
            <ol id="trip-wall-suggest-list"></ol>
        </div>
        
        
    </div>
    
    <div id="trip-list-content" class="panel">
        <h3> Suggestions </h3><br/>

    <div id="trip-list-items">
    <?php foreach($list_items as $item):?>

        <div id="trip-item-<?php echo $item['itemid'];?>" class="list-item-wrap">
            <!-- container for JS to pick up -->
        </div>

    <?php endforeach;?>
    </div>

    </div>
    
</div>

<script>
    Constants.Trip['tripItems'] = <? echo json_encode($list_items);?>;
</script>