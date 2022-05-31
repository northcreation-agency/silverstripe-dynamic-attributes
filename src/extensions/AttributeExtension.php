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
      return null;
    }
    $set = $this->owner->AttributeSet();
    $attributes = $set->Attributes();
    return $attributes;
  }

  public function getSortedAttributeValues()
  {
    $attributeSet = $this->owner->AttributeSet();
    $attributes = $this->owner->getAttributes();
    if ($attributes) {
      $attributeValues = $this->owner->getComponents("AttributeValues")
        ->leftJoin("Nca_Attribute", '"Nca_AttributeValue"."AttributeID"="Nca_Attribute"."ID"')
        ->leftJoin("Nca_AttributeLink_AttributeSet_Attribute", '"Nca_Attribute"."ID"="Nca_AttributeLink_AttributeSet_Attribute"."AttributeID"')
        ->where('"AttributeSetID"=' . $attributeSet->ID . " AND Active=1 AND OwnerItemID=" . $this->owner->ID)
        ->sort("Sort ASC");
      return $attributeValues;
    }
    return null;
  }
}
