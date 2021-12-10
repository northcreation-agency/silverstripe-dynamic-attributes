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

  private static $summary_fields = [
    'Attribute.Title' => 'Name',
    'Value' => 'Value',
  ];

  public function isLocalized()
  {
    return $this->Attribute()->exists() && $this->Attribute()->isLocalized();
  }

  public function getCMSFields()
  {
    $fields = parent::getCMSFields();
    $title = $this->Attribute()->exists() ? $this->Attribute()->Title : "Value";
    if ($this->isLocalized()) {
      $fields->removeByName('Value');
      $fields->dataFieldByName("LocalizedValue")->setTitle($title);
    } else {
      $fields->removeByName('LocalizedValue');
      $fields->dataFieldByName("Value")->setTitle($title);
    }
    return $fields;
  }

  public function setValue($value)
  {
    $df = $this->isLocalized() ? 'LocalizedValue' : 'Value';
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
