<?php

class Trip_m extends Model {

    function create_trip($uid, $name, $lat, $lon) {
        $d = array('uid' => $uid,
                   'name' => $name,
                   'lat'  => $lat,
                   'lon'  => $lon,
               );
        list($sql, $values) = $this->mdb->insert_string('trips', $d);
        $this->mdb->alter($sql, $values);
    }

}
