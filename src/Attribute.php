<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\ORM\DataObject;

class Attribute extends DataObject
{

  private static $db = [
    'Key' => 'Varchar',
    'Title' => 'Varchar',
  ];

  private static $has_many = [
    'Values' => AttributeValue::class,
  ];

  private static $belongs_many_many = [
    "AttributeSets" => AttributeSet::class,
  ];
}
