<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataObject;

class AttributeValue extends DataObject
{
  private static $db = [
    'Value' => 'Text',
    'LocalizedValue' => 'Text',
  ];

  private static $has_one = [
    'Attribute' => Attribute::class,
    'OwnerItem' => DataObject::class,
  ];

  public function isLocalized()
  {
    return $this->Attribute()->exists() && $this->Attribute()->isLocalized();
  }

  public function getCMSFields()
  {
    $fields = parent::getCMSFields();

    if ($this->isLocalized()) {
      $fields->removeByName('Value');
      $fields->dataFieldByName("LocalizedValue")->setTitle(_t(__CLASS__ . 'ATTRIBUTEVALUE', 'Value'));
    } else {
      $fields->removeByName('LocalizedValue');
      $fields->dataFieldByName("Value")->setTitle(_t(__CLASS__ . 'ATTRIBUTEVALUE', 'Value'));
    }
    return $fields;
  }

  public function setValue($value)
  {
    $df = $this->isLocalized ? 'LocalizedValue' : 'Value';
    $this->setField($df, $value);
  }

  public function getValue()
  {
    if ($this->isLocalized()) {
      return $this->LocalizedValue;
    }
    return $this->getField('Value');
  }

  public static function findOrCreate(array $input)
  {
    $existing = AttributeValue::get()->filter($input)->first();
    if ($existing) {
      return $existing;
    }
    return AttributeValue::create($input);
  }
}
