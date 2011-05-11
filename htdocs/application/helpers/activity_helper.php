<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function save_activity($user_id=NULL, $activity_type=NULL, $source_id=NULL, $parent_id=NULL, $parent_type=NULL, $timestamp=NULL)
{
    if ( ! ($user_id AND $activity_type AND $source_id AND $timestamp))
    {
        return FALSE;
    }
    $a = new Activitie();
    $a->user_id = $user_id;
    $a->activity_type = $activity_type;
    $a->source_id = $source_id;
    $a->timestamp = $timestamp;
    if ($a->save())
    {
        return TRUE;
    }
}


function get_source(&$activity)
{
    switch ($activity->activity_type) {
        case 1:
            $t = new Trip($activity->source_id);
            $activity->stored->trip = $t->stored;
            break;
        case 2:
            $p = new Post($activity->source_id);
            $activity->stored->post = $p->stored;
            break;
        case 3:
            $u = new User($activity->source_id);
            $activity->stored->following = $u->stored;
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