<div id="col1" class="grid_6">
    
    <div id="welcome-message">Welcome, <?=first_name($user['name'])?>. Create a trip and share it with your friends.</div>
    
    <div id="avatar">
        <img src="http://graph.facebook.com/<?=$profile_user['fid']?>/picture?type=large" />
    </div>    
        
    <div id="home-trips">
        <div id="create-trip">
        <button type="button" id="create-trip-button" class="large-button">Create trip</button>
        </div>
        
        <div id="create-trip-window" class="large-panel">
            <table><tbody>
                <tr><td><label for="tripwhat" class="large-label">What</label></td>
                <td><input type="text" name="tripwhat" id="tripwhat" class="large-input"/></td></tr>
                
                <tr><td><label for="tripwhere" class="large-label">Where</label></td>
                <td><input type="text" name="tripwhere" id="tripwhere" readonly="true" class="large-input" value="New York (fixed for now)"/></td></tr>
                
                <tr><td><button type="button" id="save-trip-button" class="large-button">save</button></td>
                <td><a class="cancel-link" href="javascript:hideCreateTripWindow();">cancel</a></td</tr>
            </tbody></table>
        </div>
        
        Your trips
        <ul>        
            <? if(!sizeof($trips)): ?>
            <li class="sidebar-message">You don't have any trips yet...</li>
            <? endif; ?>
        
            <? foreach($trips as $trip): ?>
            <li>
                <div class="home-trip">
                    <a href="<?=site_url('trip/details/'.$trip['tripid'])?>"><?=$trip['name']?></a>
                </div>
            </li>
            <? endforeach; ?>
        </ul>
        
    </div>
</div>