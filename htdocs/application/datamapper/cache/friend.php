<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'friends',
  'fields' => 
  array (
    0 => 'id',
    1 => 'facebook_id',
    2 => 'name',
  ),
  'validation' => 
  array (
    'facebook_id' => 
    array (
      'field' => 'facebook_id',
      'label' => 'Facebook Id',
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
    'user' => 
    array (
      'field' => 'user',
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
      'other_field' => 'friend',
      'join_self_as' => 'friend',
      'join_other_as' => 'user',
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