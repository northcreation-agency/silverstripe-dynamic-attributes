<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\Dev\Debug;
use SilverStripe\Dev\SapphireTest;

class AttributeTest extends SapphireTest
{
  protected static $fixture_file = "src/tests/fixtures/AttributeTest.yml";

  public function testIsLocalized()
  {
    $attribute = Attribute::create();
    $attribute->write();
    $attribute = Attribute::get()->filter('ID', $attribute->ID)->first();
    $this->assertEquals(0, $attribute->isLocalized());

    // Test setting to True then getting the updated value
    $attribute->Localized = true;
    $attribute->write();
    $attribute = Attribute::get()->filter('ID', $attribute->ID)->first();

    $this->assertEquals(1, $attribute->isLocalized());
    $attribute->delete();
  }
}
