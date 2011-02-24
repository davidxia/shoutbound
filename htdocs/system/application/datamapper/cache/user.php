<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'users',
  'fields' => 
  array (
    0 => 'id',
    1 => 'fid',
    2 => 'name',
    3 => 'email',
    4 => 'password',
    5 => 'created',
  ),
  'validation' => 
  array (
    'fid' => 
    array (
      'field' => 'fid',
      'label' => 'fid',
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
    'email' => 
    array (
      'field' => 'email',
      'label' => 'Email Address',
      'rules' => 
      array (
        0 => 'required',
        1 => 'trim',
        2 => 'unique',
        3 => 'valid_email',
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
    'password' => 
    array (
      'field' => 'password',
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
    'trip' => 
    array (
      'field' => 'trip',
      'rules' => 
      array (
      ),
    ),
    'friend' => 
    array (
      'field' => 'friend',
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
    'trip' => 
    array (
      'class' => 'trip',
      'other_field' => 'user',
      'join_self_as' => 'user',
      'join_other_as' => 'trip',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'friend' => 
    array (
      'class' => 'friend',
      'other_field' => 'user',
      'join_self_as' => 'user',
      'join_other_as' => 'friend',
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