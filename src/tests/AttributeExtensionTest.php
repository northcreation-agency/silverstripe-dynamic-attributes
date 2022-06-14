<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\Dev\Debug;
use SilverStripe\Dev\SapphireTest;

class AttributeExtensionTest extends SapphireTest
{
  protected static $fixture_file = "src/tests/fixtures/AttributeExtensionTest.yml";

  public function testGetAttributes()
  {
    $attributeSet = AttributeSet::create();
    $attribute1 = Attribute::create();
    $attribute2 = Attribute::create();
    $attributeSet->Attributes()->add($attribute1);
    $attributeSet->Attributes()->add($attribute2);
    $attributeSet->write();

    $object = AttributeHolder::create();
    $object->AttributeSetID = $attributeSet->ID;
    $value1 = AttributeValue::create();
    $value2 = AttributeValue::create();
    $value1->AttributeID = $attribute1->ID;
    $value2->AttributeID = $attribute2->ID;

    $attributeSet->write();
    $object->write();

    $this->assertEquals(2, $object->getAttributes()->count());

    $object->delete();
    $attributeSet->delete();
    $attribute1->delete();
    $attribute2->delete();
  }

  public function testGetSortedAttributesReturnsSorted()
  {
    $attributeSet = AttributeSet::create();
    $attribute1 = Attribute::create();
    $attribute2 = Attribute::create();
    $attributeSet->Attributes()->add($attribute1);
    $attributeSet->Attributes()->add($attribute2);
    $attributeSet->write();

    $object = AttributeHolder::create();
    $object->AttributeSetID = $attributeSet->ID;
    $object->write();
    $link1 = AttributeLink::get()->filter(['AttributeID' => $attribute1->ID])->first();
    $link2 = AttributeLink::get()->filter(['AttributeID' => $attribute2->ID])->first();

    $link1->Sort = 1;
    $link2->Sort = 2;

    $link1->write();
    $link2->write();

    $this->assertEquals([$attribute1->ID, $attribute2->ID], $object->getSortedAttributes()->column('ID'));


    $link1->Sort = 2;
    $link2->Sort = 1;

    $link1->write();
    $link2->write();

    $this->assertEquals([$attribute2->ID, $attribute1->ID], $object->getSortedAttributes()->column('ID'));
  }

  public function testGetSortedAttributeValues()
  {
    $attributeSet = AttributeSet::create();
    $attribute1 = Attribute::create();
    $attribute2 = Attribute::create();
    $attributeSet->Attributes()->add($attribute1);
    $attributeSet->Attributes()->add($attribute2);
    $attributeSet->write();

    $object = AttributeHolder::create();
    $object->AttributeSetID = $attributeSet->ID;
    $object->write();

    $value1 = AttributeValue::create();
    $value2 = AttributeValue::create();
    $value1->AttributeID = $attribute1->ID;
    $value2->AttributeID = $attribute2->ID;
    $object->write();

    $object->AttributeValues()->add($value1);
    $object->AttributeValues()->add($value2);
    $value1->write();
    $value2->write();

    $object->write();
    $attributeSet->write();

    $this->assertEquals([$value1->ID, $value2->ID], $object->getSortedAttributeValues()->column('ID'));

    $link1 = AttributeLink::get()->filter(['AttributeID' => $attribute1->ID])->first();
    $link2 = AttributeLink::get()->filter(['AttributeID' => $attribute2->ID])->first();

    $link1->Sort = 2;
    $link2->Sort = 1;

    $link1->write();
    $link2->write();

    $this->assertEquals([$value2->ID, $value1->ID], $object->getSortedAttributeValues()->column('ID'));

    $object->delete();
    $attributeSet->delete();
    $attribute1->delete();
    $attribute2->delete();
    $link1->delete();
    $link2->delete();
  }

  public function testGetSortedAttributeValuesNotReturnsActive()
  {
    $attributeSet = AttributeSet::create();
    $attribute1 = Attribute::create();
    $attribute2 = Attribute::create();
    $attributeSet->Attributes()->add($attribute1);
    $attributeSet->Attributes()->add($attribute2);
    $attributeSet->write();

    $object = AttributeHolder::create();
    $object->AttributeSetID = $attributeSet->ID;
    $object->write();

    $value1 = AttributeValue::create();
    $value2 = AttributeValue::create();
    $value1->AttributeID = $attribute1->ID;
    $value2->AttributeID = $attribute2->ID;
    $object->write();

    $object->AttributeValues()->add($value1);
    $object->AttributeValues()->add($value2);
    $value1->write();
    $value2->write();

    $object->write();
    $attributeSet->write();

    $this->assertEquals([$value1->ID, $value2->ID], $object->getSortedAttributeValues()->column('ID'));

    $link1 = AttributeLink::get()->filter(['AttributeID' => $attribute1->ID])->first();
    $link2 = AttributeLink::get()->filter(['AttributeID' => $attribute2->ID])->first();

    $link1->Active = 1;
    $link2->Active = 0;

    $link1->write();
    $link2->write();

    $this->assertEquals([$value1->ID], $object->getSortedAttributeValues()->column('ID'));
    $this->assertEquals([$value1->ID, $value2->ID], $object->getSortedAttributeValues(false)->column('ID'));

    $object->delete();
    $attributeSet->delete();
    $attribute1->delete();
    $attribute2->delete();
    $link1->delete();
    $link2->delete();
  }
}
