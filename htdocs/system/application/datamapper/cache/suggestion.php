<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'suggestions',
  'fields' => 
  array (
    0 => 'id',
    1 => 'user_id',
    2 => 'trip_id',
    3 => 'name',
    4 => 'text',
    5 => 'lat',
    6 => 'lng',
    7 => 'active',
    8 => 'created',
  ),
  'validation' => 
  array (
    'user_id' => 
    array (
      'field' => 'user_id',
      'label' => 'User',
      'rules' => 
      array (
        0 => 'required',
      ),
    ),
    'trip_id' => 
    array (
      'field' => 'trip_id',
      'label' => 'Trip',
      'rules' => 
      array (
        0 => 'required',
      ),
    ),
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
    'lat' => 
    array (
      'field' => 'lat',
      'label' => 'Lat',
      'rules' => 
      array (
        0 => 'required',
      ),
    ),
    'lng' => 
    array (
      'field' => 'lng',
      'label' => 'Lng',
      'rules' => 
      array (
        0 => 'required',
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
    'text' => 
    array (
      'field' => 'text',
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
    'created' => 
    array (
      'field' => 'created',
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
  ),
  'has_one' => 
  array (
    'user' => 
    array (
      'class' => 'user',
      'other_field' => 'suggestion',
      'join_self_as' => 'suggestion',
      'join_other_as' => 'user',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'trip' => 
    array (
      'class' => 'trip',
      'other_field' => 'suggestion',
      'join_self_as' => 'suggestion',
      'join_other_as' => 'trip',
      'join_table' => '',
      'reciprocal' => false,
    ),
  ),
  'has_many' => 
  array (
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