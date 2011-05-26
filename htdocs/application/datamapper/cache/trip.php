<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'trips',
  'fields' => 
  array (
    0 => 'id',
    1 => 'name',
    2 => 'response_deadline',
    3 => 'description',
    4 => 'is_private',
    5 => 'is_active',
    6 => 'created',
    7 => 'updated',
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
    'response_deadline' => 
    array (
      'field' => 'response_deadline',
      'label' => 'Deadline',
      'rules' => 
      array (
        0 => '',
      ),
    ),
    'description' => 
    array (
      'field' => 'description',
      'label' => 'Description',
      'rules' => 
      array (
        0 => 'trim',
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
    'is_private' => 
    array (
      'field' => 'is_private',
      'rules' => 
      array (
      ),
    ),
    'is_active' => 
    array (
      'field' => 'is_active',
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
    'updated' => 
    array (
      'field' => 'updated',
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
    'place' => 
    array (
      'field' => 'place',
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
    'suggestion' => 
    array (
      'field' => 'suggestion',
      'rules' => 
      array (
      ),
    ),
    'destination' => 
    array (
      'field' => 'destination',
      'rules' => 
      array (
      ),
    ),
    'trip_share' => 
    array (
      'field' => 'trip_share',
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
    'place' => 
    array (
      'class' => 'place',
      'other_field' => 'trip',
      'join_self_as' => 'trip',
      'join_other_as' => 'place',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'post' => 
    array (
      'class' => 'post',
      'other_field' => 'trip',
      'join_self_as' => 'trip',
      'join_other_as' => 'post',
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
    'destination' => 
    array (
      'class' => 'destination',
      'other_field' => 'trip',
      'join_self_as' => 'trip',
      'join_other_as' => 'destination',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'trip_share' => 
    array (
      'class' => 'trip_share',
      'other_field' => 'trip',
      'join_self_as' => 'trip',
      'join_other_as' => 'trip_share',
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