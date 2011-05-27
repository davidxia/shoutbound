<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'likes',
  'fields' => 
  array (
    0 => 'id',
    1 => 'user_id',
    2 => 'post_id',
    3 => 'is_like',
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
    'is_like' => 
    array (
      'field' => 'is_like',
      'label' => 'Is Like',
      'rules' => 
      array (
        0 => 'required',
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
    'post_id' => 
    array (
      'field' => 'post_id',
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
    'user' => 
    array (
      'field' => 'user',
      'rules' => 
      array (
      ),
    ),
    'message' => 
    array (
      'field' => 'message',
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
    'user' => 
    array (
      'class' => 'user',
      'other_field' => 'like',
      'join_self_as' => 'like',
      'join_other_as' => 'user',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'message' => 
    array (
      'class' => 'message',
      'other_field' => 'like',
      'join_self_as' => 'like',
      'join_other_as' => 'message',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'suggestion' => 
    array (
      'class' => 'suggestion',
      'other_field' => 'like',
      'join_self_as' => 'like',
      'join_other_as' => 'suggestion',
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