<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'trips',
  'fields' => 
  array (
    0 => 'id',
    1 => 'name',
    2 => 'trip_startdate',
    3 => 'lat',
    4 => 'lng',
    5 => 'sbound',
    6 => 'wbound',
    7 => 'nbound',
    8 => 'ebound',
    9 => 'active',
    10 => 'lastupdated',
  ),
  'validation' => 
  array (
    'name' => 
    array (
      'field' => 'name',
      'label' => 'Name',
      'rules' => 
      array (
        0 => 'required',
        1 => 'trim',
      ),
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'trip_startdate' => 
    array (
      'field' => 'trip_startdate',
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
    'sbound' => 
    array (
      'field' => 'sbound',
      'rules' => 
      array (
      ),
    ),
    'wbound' => 
    array (
      'field' => 'wbound',
      'rules' => 
      array (
      ),
    ),
    'nbound' => 
    array (
      'field' => 'nbound',
      'rules' => 
      array (
      ),
    ),
    'ebound' => 
    array (
      'field' => 'ebound',
      'rules' => 
      array (
      ),
    ),
    'active' => 
    array (
      'field' => 'active',
      'rules' => 
      array (
      ),
    ),
    'lastupdated' => 
    array (
      'field' => 'lastupdated',
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
    'suggestion' => 
    array (
      'field' => 'suggestion',
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
    'user' => 
    array (
      'class' => 'user',
      'other_field' => 'trip',
      'join_self_as' => 'trip',
      'join_other_as' => 'user',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'suggestion' => 
    array (
      'class' => 'suggestion',
      'other_field' => 'trip',
      'join_self_as' => 'trip',
      'join_other_as' => 'suggestion',
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