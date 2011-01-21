<div id="trip-list-body">
    
    <div>recommend something</div>
    
    <div id="trip-wall-control-recommend-edit">
        
        <form name="recommendation">
            
            <div class="recommendation-input-wrap">
                <input id="term" class="recommendation-input">
                <button id="submit-recommendation">search</button>
            </div>
            

        </form>
        
        <div id="trip-wall-recommend-list-wrapper">
            <ol id="trip-wall-recommend-list"></ol>
        </div>
        
        
    </div>
    
</div>

<script>
    Constants.Trip['tripItems'] = <? echo json_encode($list_items);?>;
</script>