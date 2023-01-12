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

  public function testGetTitleReturnsCustomIfAvailable()
  {
    $attribute = Attribute::create();
    $attribute->Title = 'Title';
    $attribute->CustomTitle = 'CustomTitle';
    $attribute->write();

    $this->assertEquals('CustomTitle', $attribute->Title);
  }

  public function testGetTitleReturnsTitleIfNoCustom()
  {
    $attribute = Attribute::create();
    $attribute->Title = 'Title';
    $attribute->write();

    $this->assertEquals('Title', $attribute->Title);
  }
}
