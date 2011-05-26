<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'places',
  'fields' => 
  array (
    0 => 'id',
    1 => 'ISO',
    2 => 'name',
    3 => 'language',
    4 => 'type',
    5 => 'parent',
    6 => 'country',
    7 => 'admin1',
    8 => 'admin2',
    9 => 'admin3',
    10 => 'locality1',
    11 => 'locality2',
    12 => 'postal',
    13 => 'lat',
    14 => 'lng',
    15 => 'g',
    16 => 'sw_lat',
    17 => 'sw_lng',
    18 => 'ne_lat',
    19 => 'ne_lng',
    20 => 'area_rank',
    21 => 'pop_rank',
  ),
  'validation' => 
  array (
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'ISO' => 
    array (
      'field' => 'ISO',
      'rules' => 
      array (
      ),
    ),
    'name' => 
    array (
      'field' => 'name',
      'rules' => 
      array (
      ),
    ),
    'language' => 
    array (
      'field' => 'language',
      'rules' => 
      array (
      ),
    ),
    'type' => 
    array (
      'field' => 'type',
      'rules' => 
      array (
      ),
    ),
    'parent' => 
    array (
      'field' => 'parent',
      'rules' => 
      array (
      ),
    ),
    'country' => 
    array (
      'field' => 'country',
      'rules' => 
      array (
      ),
    ),
    'admin1' => 
    array (
      'field' => 'admin1',
      'rules' => 
      array (
      ),
    ),
    'admin2' => 
    array (
      'field' => 'admin2',
      'rules' => 
      array (
      ),
    ),
    'admin3' => 
    array (
      'field' => 'admin3',
      'rules' => 
      array (
      ),
    ),
    'locality1' => 
    array (
      'field' => 'locality1',
      'rules' => 
      array (
      ),
    ),
    'locality2' => 
    array (
      'field' => 'locality2',
      'rules' => 
      array (
      ),
    ),
    'postal' => 
    array (
      'field' => 'postal',
      'rules' => 
      array (
      ),
    ),
    'lat' => 
    array (
      'field' => 'lat',
      'rules' => 
      array (
      ),
    ),
    'lng' => 
    array (
      'field' => 'lng',
      'rules' => 
      array (
      ),
    ),
    'g' => 
    array (
      'field' => 'g',
      'rules' => 
      array (
      ),
    ),
    'sw_lat' => 
    array (
      'field' => 'sw_lat',
      'rules' => 
      array (
      ),
    ),
    'sw_lng' => 
    array (
      'field' => 'sw_lng',
      'rules' => 
      array (
      ),
    ),
    'ne_lat' => 
    array (
      'field' => 'ne_lat',
      'rules' => 
      array (
      ),
    ),
    'ne_lng' => 
    array (
      'field' => 'ne_lng',
      'rules' => 
      array (
      ),
    ),
    'area_rank' => 
    array (
      'field' => 'area_rank',
      'rules' => 
      array (
      ),
    ),
    'pop_rank' => 
    array (
      'field' => 'pop_rank',
      'rules' => 
      array (
      ),
    ),
    'user' => 
    array (
      'field' => 'user',
      'rules' => 
      array (
      ),
    ),
    'trip' => 
    array (
      'field' => 'trip',
      'rules' => 
      array (
      ),
    ),
    'post' => 
    array (
      'field' => 'post',
      'rules' => 
      array (
      ),
    ),
    'related_place' => 
    array (
      'field' => 'related_place',
      'rules' => 
      array (
      ),
    ),
    'place' => 
    array (
      'field' => 'place',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
  ),
  'has_many' => 
  array (
    'related_place' => 
    array (
      'class' => 'place',
      'other_field' => 'place',
      'reciprocal' => true,
      'join_self_as' => 'place',
      'join_other_as' => 'related_place',
      'join_table' => '',
    ),
    'place' => 
    array (
      'other_field' => 'related_place',
      'class' => 'place',
      'join_self_as' => 'related_place',
      'join_other_as' => 'place',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'user' => 
    array (
      'class' => 'user',
      'other_field' => 'place',
      'join_self_as' => 'place',
      'join_other_as' => 'user',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'trip' => 
    array (
      'class' => 'trip',
      'other_field' => 'place',
      'join_self_as' => 'place',
      'join_other_as' => 'trip',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'post' => 
    array (
      'class' => 'post',
      'other_field' => 'place',
      'join_self_as' => 'place',
      'join_other_as' => 'post',
      'join_table' => '',
      'reciprocal' => false,
    ),
  ),
  '_field_tracking' => 
  array (
    'get_rules' => 
    array (
    ),
    'matches' => 
    array (
    ),
    'intval' => 
    array (
      0 => 'id',
    ),
  ),
);