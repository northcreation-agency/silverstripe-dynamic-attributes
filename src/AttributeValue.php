<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\ORM\DataObject;

class AttributeValue extends DataObject
{
  private static $db = [
    'Value' => 'Text',
    'LocalizedValue' => 'Text',
    'Type' => 'Enum(array("Numerical, Text"), "String")',
    'Localized' => 'Boolean'
  ];

  private static $has_one = [
    'Attribute' => Attribute::class,
  ];
}
