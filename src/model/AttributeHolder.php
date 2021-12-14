<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;

class AttributeHolder extends DataObject
{

  private static $table_name = "Nca_AttributeHolder";

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
    $set = $this->AttributeSet();
    $attributes = $set->Attributes();
    $values = $attributes->Values()->filter(['OwnerID' => $this->ID]);
    return $values;
  }
}
