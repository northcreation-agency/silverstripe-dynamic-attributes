<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\ORM\DataObject;

class AttributeSet extends DataObject
{
  private static $db = [
    'Key' => 'Varchar',
    'Title' => 'Varchar',
  ];

  private static $many_many = [
    'Attributes' => Attribute::class,
  ];

  private static $many_many_extraFields = [
    'Attributes' => ['Sort' => 'Number']
  ];
}
