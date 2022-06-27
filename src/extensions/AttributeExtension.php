<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\Dev\Debug;
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

  public function getSortedAttributes()
  {
    $attributes = $this->owner->getAttributes();
    if (!$attributes) return null;
    return $attributes->sort("Sort", "ASC");
  }

  public function getSortedAttributeValues(bool $filterActive = true)
  {
    $attributeSet = $this->owner->AttributeSet();
    $attributes = $this->owner->getAttributes();

    $active = $filterActive ? " AND Active=1" : "";
    if ($attributes && $attributeSet->exists()) {
      $attributeValues = $this->owner->getComponents("AttributeValues")
        ->leftJoin("Nca_Attribute", '"Nca_AttributeValue"."AttributeID"="Nca_Attribute"."ID"')
        ->leftJoin("Nca_AttributeLink_AttributeSet_Attribute", '"Nca_Attribute"."ID"="Nca_AttributeLink_AttributeSet_Attribute"."AttributeID"')
        ->where('"AttributeSetID"=' . $attributeSet->ID . $active . " AND OwnerItemID=" . $this->owner->ID)
        ->sort("Sort ASC");
      return $attributeValues;
    }
    return null;
  }
}
