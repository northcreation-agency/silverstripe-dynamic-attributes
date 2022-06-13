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

  public function testAutomaticSort()
  {
    $attributeSet = AttributeSet::create();
    $attributeSet->write();

    $attribute = Attribute::create();
    $attribute->write();

    $attribute2 = Attribute::create();
    $attribute2->write();
    $attributeSet->Attributes()->addMany([$attribute, $attribute2]);

    $attributeSet->write();
    $attributeSet = AttributeSet::get()->filter('ID', $attributeSet->ID)->first();

    $links = AttributeLink::get()->filter(['AttributeSetID' =>  $attributeSet->ID])->sort('Sort', 'ASC')->column('Sort');
    $this->assertEquals([0, 1], $links);

    $attribute->delete();
    $attribute2->delete();
    $attributeSet->delete();
  }

  public function testAutmaticSortIgnoresInactiveAttributes()
  {
    $attributeSet = AttributeSet::create();
    $attributeSet->write();

    $attribute = Attribute::create();
    $attribute->write();

    $attribute2 = Attribute::create();
    $attribute2->write();
    $attributeSet->Attributes()->addMany([$attribute, $attribute2]);

    $attributeSet->write();
    $attributeSet = AttributeSet::get()->filter('ID', $attributeSet->ID)->first();

    $link = AttributeLink::get()->filter(['AttributeSetID' =>  $attributeSet->ID])->sort('Sort', 'DESC')->first();
    $link->Active = false;
    $link->write();

    $attribute3 = Attribute::create();
    $attribute3->write();
    $attributeSet->Attributes()->add($attribute3);
    $links = AttributeLink::get()->filter(['AttributeSetID' =>  $attributeSet->ID])->sort('Sort', 'ASC')->column('Sort');
    $this->assertEquals([0, 1, 1], $links);
  }
}
