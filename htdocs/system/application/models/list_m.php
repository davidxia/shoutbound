<?php

class List_m extends Model {

    function get_list_for_user($id){
        return array(
            array('lat'=>100, 'long'=>100, 'name'=>'foobar'),
            array('lat'=>100, 'long'=>100, 'name'=>'bazbuz')
        );
    }
}
