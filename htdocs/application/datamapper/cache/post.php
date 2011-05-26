<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'posts',
  'fields' => 
  array (
    0 => 'id',
    1 => 'user_id',
    2 => 'content',
    3 => 'parent_id',
    4 => 'is_active',
    5 => 'created',
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
    'content' => 
    array (
      'field' => 'content',
      'label' => 'Content',
      'rules' => 
      array (
        0 => 'required',
        1 => 'trim',
      ),
    ),
    'parent_id' => 
    array (
      'field' => 'parent_id',
      'label' => 'Parent',
      'rules' => 
      array (
        0 => '',
      ),
    ),
    'is_active' => 
    array (
      'field' => 'is_active',
      'label' => 'Active',
      'rules' => 
      array (
        0 => '',
      ),
    ),
    'created' => 
    array (
      'field' => 'created',
      'label' => 'Created',
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
    'parent' => 
    array (
      'field' => 'parent',
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
  ),
  'has_one' => 
  array (
    'parent' => 
    array (
      'class' => 'post',
      'other_field' => 'post',
      'join_self_as' => 'post',
      'join_other_as' => 'parent',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'user' => 
    array (
      'class' => 'user',
      'other_field' => 'post',
      'join_self_as' => 'post',
      'join_other_as' => 'user',
      'join_table' => '',
      'reciprocal' => false,
    ),
  ),
  'has_many' => 
  array (
    'post' => 
    array (
      'other_field' => 'parent',
      'class' => 'post',
      'join_self_as' => 'parent',
      'join_other_as' => 'post',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'trip' => 
    array (
      'class' => 'trip',
      'other_field' => 'post',
      'join_self_as' => 'post',
      'join_other_as' => 'trip',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'place' => 
    array (
      'class' => 'place',
      'other_field' => 'post',
      'join_self_as' => 'post',
      'join_other_as' => 'place',
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