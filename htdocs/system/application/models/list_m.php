<?php

class List_m extends Model {

    function get_list_for_user($id){
        return array(
            array('lat'=>100, 'long'=>100, 'name'=>'foobar', 'id'=> 1),
            array('lat'=>100, 'long'=>100, 'name'=>'grixgl', 'id'=> 2),
            array('lat'=>100, 'long'=>100, 'name'=>'frimfi', 'id'=> 3),
            array('lat'=>100, 'long'=>100, 'name'=>'bazbuz', 'id'=> 4)
        );
    }
}
