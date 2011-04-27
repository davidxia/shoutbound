<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_source(&$activity)
{
    switch ($activity->activity_type) {
        case 1:
            $t = new Trip($activity->source_id);
            $activity->stored->trip = $t->stored;
            break;
        case 2:
            $p = new Wallitem($activity->source_id);
            $activity->stored->post = $p->stored;
            break;
        case 3:
            break;
        case 4:
            break;
        case 5:
            break;
        case 6:
            break;
        case 7:
            break;
        case 8:
            break;
        case 9:
            break;
        case 10:
            break;
    }
}


function get_parent(&$activity)
{
    switch ($activity->parent_type) {
        case 1:
            $p = new Place($activity->parent_id);
            $activity->stored->place = $p->stored;
            break;
        case 2:
            $t = new Trip($activity->parent_id);
            $activity->stored->trip = $t->stored;
            break;
        case 3:
            break;
        case 4:
            break;
    }

}


/* End of file activity_helper.php */
/* Location: ./system/application/helpers/activity_helper.php */