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
    5 => 'bio',
    6 => 'url',
    7 => 'profile_pic',
    8 => 'is_onboarded',
    9 => 'created',
  ),
  'validation' => 
  array (
    'fid' => 
    array (
      'field' => 'fid',
      'label' => 'fid',
      'rules' => 
      array (
        0 => '',
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
    'bio' => 
    array (
      'field' => 'bio',
      'label' => 'Biography',
      'rules' => 
      array (
        0 => 'trim',
      ),
    ),
    'url' => 
    array (
      'field' => 'url',
      'label' => 'Personal URL',
      'rules' => 
      array (
        0 => 'trim',
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
    'password' => 
    array (
      'field' => 'password',
      'rules' => 
      array (
      ),
    ),
    'profile_pic' => 
    array (
      'field' => 'profile_pic',
      'rules' => 
      array (
      ),
    ),
    'is_onboarded' => 
    array (
      'field' => 'is_onboarded',
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
    'place' => 
    array (
      'field' => 'place',
      'rules' => 
      array (
      ),
    ),
    'setting' => 
    array (
      'field' => 'setting',
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
    'related_user' => 
    array (
      'field' => 'related_user',
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
  ),
  'has_one' => 
  array (
  ),
  'has_many' => 
  array (
    'related_user' => 
    array (
      'class' => 'user',
      'other_field' => 'user',
      'reciprocal' => true,
      'join_self_as' => 'user',
      'join_other_as' => 'related_user',
      'join_table' => '',
    ),
    'user' => 
    array (
      'other_field' => 'related_user',
      'class' => 'user',
      'join_self_as' => 'related_user',
      'join_other_as' => 'user',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'trip' => 
    array (
      'class' => 'trip',
      'other_field' => 'user',
      'join_self_as' => 'user',
      'join_other_as' => 'trip',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'post' => 
    array (
      'class' => 'post',
      'other_field' => 'user',
      'join_self_as' => 'user',
      'join_other_as' => 'post',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'place' => 
    array (
      'class' => 'place',
      'other_field' => 'user',
      'join_self_as' => 'user',
      'join_other_as' => 'place',
      'join_table' => '',
      'reciprocal' => false,
    ),
    'setting' => 
    array (
      'class' => 'setting',
      'other_field' => 'user',
      'join_self_as' => 'user',
      'join_other_as' => 'setting',
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