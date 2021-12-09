<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\Dev\Debug;
use SilverStripe\Dev\SapphireTest;

class AttributeTest extends SapphireTest
{

  public function setUp(): void
  {
    parent::setUp();

    for ($attr = 0; $attr < 5; $attr++) {
      $attribute = Attribute::create([
        'Key' => 'Attr' . "${$attr}",
        'Title' => 'AttrTitle' . "${$attr}"
      ]);
      for ($val = 0; $val < 3; $val++) {
        $value = AttributeValue::create([
          'Value' => 'Attr' . "${$attr}" . 'Val' . "${$val}",
          'LocalizedValue' => 'Attr' . "${$attr}" . 'LocalVal' . "${$val}",
        ]);
        $value->write();
        $attribute->Values()->add($value);
      }
      $attribute->write();
    }
  }

  public function testGetValue()
  {
    //TODO:: Implement tests
  }
}
