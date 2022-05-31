<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\Dev\SapphireTest;

class AttributeSetTest extends SapphireTest
{
  protected static $fixture_file = "src/tests/fixtures/AttributeSetTest.yml";

  public function testAttributesDefaultActive()
  {
    $attributeSet = AttributeSet::create();
    $attributeSet->write();

    $attribute = Attribute::create();
    $attribute->write();
    $attributeSet->Attributes()->add($attribute);
    $attributeSet->write();
    $attributeSet = AttributeSet::get()->filter('ID', $attributeSet->ID)->first();


    $this->assertEquals($attributeSet->Attributes()->filter(['Active' => true])->count(), 1);
    $attributeSet->delete();
    $attribute->delete();
  }

  public function testGetActiveAttributes()
  {
    $attributeSet = AttributeSet::create();
    $attributeSet->write();

    $attribute = Attribute::create();
    $attribute->write();
    $attributeSet->Attributes()->add($attribute);
    $attributeSet->write();
    $attributeSet = AttributeSet::get()->filter('ID', $attributeSet->ID)->first();


    $this->assertEquals($attributeSet->getActiveAttributes()->count(), 1);
    $attributeSet->delete();
    $attribute->delete();
  }
}
