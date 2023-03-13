<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\Dev\Debug;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ArrayList;
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
      return ArrayList::create();
    }
    $set = $this->owner->AttributeSet();
    $attributes = $set->Attributes();
    return $attributes;
  }

  public function getSortedAttributes()
  {
    $attributes = $this->owner->getAttributes();
    if (!$attributes) return ArrayList::create();
    return $attributes->sort("Sort", "ASC");
  }

  public function getSortedAttributeValues(bool $filterActive = true, $attributeSet = null)
  {
    $attributeSet = $attributeSet ?? $this->owner->AttributeSet();
    $attributes = $this->owner->getAttributes();
    $keys = $attributes->column('Key');
    $keyStatement = sprintf(
      'IN (%s)',
      implode(',', array_map(function ($i) {
        return "'" . $i . "'";
      }, $keys)),
    );

    $active = $filterActive ? " AND Active=1" : "";
    if ($attributes->count() && $attributeSet->exists()) {
      $attributeValues = $this->owner->getComponents("AttributeValues")
        ->alterDataQuery(function ($dq, $list) {
          $dq->addSelectFromTable('Nca_Attribute', ['Key']);
          return $dq;
        })
        ->leftJoin("Nca_Attribute", '"Nca_AttributeValue"."AttributeID"="Nca_Attribute"."ID"')
        ->leftJoin("Nca_AttributeLink_AttributeSet_Attribute", '"Nca_Attribute"."ID"="Nca_AttributeLink_AttributeSet_Attribute"."AttributeID"')
        ->where('Nca_Attribute.Key ' . $keyStatement . $active . " AND OwnerItemID=" . $this->owner->ID)
        ->sort("Sort ASC");
      return $attributeValues;
    }
    return ArrayList::create();
  }
}
