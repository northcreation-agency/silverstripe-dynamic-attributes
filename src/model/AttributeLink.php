<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\ORM\DataObject;

class AttributeLink extends DataObject
{
  private static $table_name = "Nca_AttributeLink";

  private static $db = [
    'Sort' => 'Int',
    'Active' => 'Boolean',
  ];

  private static $has_one = [
    'Attribute' => Attribute::class,
    'AttributeSet' => AttributeSet::class,
  ];

  private static $defaults = [
    'Active' => true,
  ];
}
