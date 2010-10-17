<div id="trip-list-body">
    <ul>
    <?php foreach($list_items as $item):?>

    <li><?php echo $item['title'];?></li>

    <?php endforeach;?>
    </ul>
    
</div>

<script>
    Constants.Trip['tripItems'] = <? echo json_encode($list_items);?>;
</script>