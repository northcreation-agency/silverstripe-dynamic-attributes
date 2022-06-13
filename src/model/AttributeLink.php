<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\ORM\DataObject;

class AttributeLink extends DataObject
{
  private static $table_name = "Nca_AttributeLink_AttributeSet_Attribute";

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

  public function onBeforeWrite()
  {
    parent::onBeforeWrite();
    if (!$this->exists()) {
      $existing = AttributeLink::get()->filter(['AttributeSetID' => $this->AttributeSetID, 'Active' => 1])->sort('Sort', 'DESC')->first();
      if ($existing) {
        $this->Sort = $existing->Sort + 1;
      }
    }
  }
}
