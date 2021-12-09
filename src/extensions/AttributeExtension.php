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
    'AttributeValues' => AttributeValues::class,
  ];

  public function updateCMSFields(FieldList $fields)
  {
    $fields->removeByName('AttributeSet');
    $fields->removeByName('AttributeValues');
  }

  public function getAttributes()
  {
    $set = $this->owner->AttributeSet();
    $attributes = $set->Attributes();
    $values = $attributes->Values()->filter(['OwnerItemID' => $this->owner->ID]);
    return $values;
  }
}
