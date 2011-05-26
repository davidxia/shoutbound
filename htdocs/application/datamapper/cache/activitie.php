<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'activities',
  'fields' => 
  array (
    0 => 'id',
    1 => 'user_id',
    2 => 'activity_type',
    3 => 'source_id',
    4 => 'parent_id',
    5 => 'parent_type',
    6 => 'is_active',
    7 => 'timestamp',
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
    'activity_type' => 
    array (
      'field' => 'activity_type',
      'label' => 'Activity type',
      'rules' => 
      array (
        0 => 'required',
      ),
    ),
    'source_id' => 
    array (
      'field' => 'source_id',
      'label' => 'Source ID',
      'rules' => 
      array (
        0 => 'required',
      ),
    ),
    'parent_id' => 
    array (
      'field' => 'parent_id',
      'label' => 'Parent ID',
      'rules' => 
      array (
        0 => '',
      ),
    ),
    'parent_type' => 
    array (
      'field' => 'parent_type',
      'label' => 'Parent type',
      'rules' => 
      array (
        0 => '',
      ),
    ),
    'timestamp' => 
    array (
      'field' => 'timestamp',
      'label' => 'Timestamp',
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
  ),
  'has_one' => 
  array (
    'user' => 
    array (
      'class' => 'user',
      'other_field' => 'activitie',
      'join_self_as' => 'activitie',
      'join_other_as' => 'user',
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