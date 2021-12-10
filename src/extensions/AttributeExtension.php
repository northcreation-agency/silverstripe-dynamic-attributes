<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class AttributeExtension extends DataExtension
{

  private static $has_one = [
    'AttributeSet' => AttributeSet::class,
  ];

  private static $has_many = [
    'AttributeValues' => AttributeValue::class,
  ];

  public function updateCMSFields(FieldList $fields)
  {
    $fields->removeByName('AttributeSet');
    $fields->removeByName('AttributeValues');
  }

  public function getAttributes()
  {
    if (!$this->owner->AttributeSet()->exists()) {
      return [];
    }
    $set = $this->owner->AttributeSet();
    $attributes = $set->Attributes();
    return $attributes;
  }
}
