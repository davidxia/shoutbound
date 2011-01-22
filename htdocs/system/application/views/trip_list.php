<div id="trip-list-body">
    
    <div>suggest something</div>
        
    
    
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
    
</div>

<script>
    Constants.Trip['tripItems'] = <? echo json_encode($list_items);?>;
</script>