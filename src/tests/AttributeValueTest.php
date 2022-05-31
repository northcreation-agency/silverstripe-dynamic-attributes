<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\Dev\Debug;
use SilverStripe\Dev\SapphireTest;
use TractorCow\Fluent\Model\Locale;
use TractorCow\Fluent\State\FluentState;

class AttributeValueTest extends SapphireTest
{

  protected static $fixture_file =  'src/tests/fixtures/AttributeValueTest.yml';

  public function testGetValueReturnsLocalized()
  {
    $attribute = Attribute::create();
    $attribute->Localized = true;
    $attribute->write();

    $value = AttributeValue::create();
    $value->AttributeID = $attribute->ID;
    $value->Value = 'Value';
    $value->write();

    $locales = Locale::get();
    $count = 0;

    foreach ($locales as $locale) {
      FluentState::singleton()->withState(
        function (FluentState $state) use ($locale, $value, &$count) {
          $state->setLocale($locale->Locale);
          $localizedValue = AttributeValue::get()->filter('ID', $value->ID)->first();
          $localizedValue->LocalizedValue = 'LocalizedValue' . (string) $count;
          $count++;
          $localizedValue->write();
        }
      );
    }

    FluentState::singleton()->setLocale($locales[0]->Locale);
    $value = AttributeValue::get()->filter(['ID' => $value->ID])->first();
    $this->assertEquals("LocalizedValue0", $value->getValue());

    FluentState::singleton()->setLocale($locales[1]->Locale);
    $value = AttributeValue::get()->filter(['ID' => $value->ID])->first();
    $this->assertEquals("LocalizedValue1", $value->getValue());

    $attribute->delete();
    $value->delete();
  }

  public function testSetValueForLocalizedValue()
  {
    $attribute = Attribute::create();
    $attribute->Localized = true;
    $attribute->write();

    $value = AttributeValue::create();
    $value->AttributeID = $attribute->ID;
    $value->write();

    $locales = Locale::get();
    $count = 0;
    foreach ($locales as $locale) {
      FluentState::singleton()->withState(
        function (FluentState $state) use ($locale, $value, &$count) {
          $state->setLocale($locale->Locale);
          $localizedValue = AttributeValue::get()->filter('ID', $value->ID)->first();
          $localizedValue->setValue('LocalizedValue' . (string) $count);
          $count++;
          $localizedValue->write();
        }
      );
    }

    FluentState::singleton()->setLocale($locales[0]->Locale);
    $value = AttributeValue::get()->filter(['ID' => $value->ID])->first();
    $this->assertEquals("LocalizedValue0", $value->getValue());
    $this->assertEquals("LocalizedValue0", $value->Value);

    FluentState::singleton()->setLocale($locales[1]->Locale);
    $value = AttributeValue::get()->filter(['ID' => $value->ID])->first();
    $this->assertEquals("LocalizedValue1", $value->getValue());
    $this->assertEquals("LocalizedValue1", $value->Value);
  }

  public function testSetValueForNonLocalizedValue()
  {
    $attribute = Attribute::create();
    $attribute->Localized = false;
    $attribute->write();

    $value = AttributeValue::create();
    $value->AttributeID = $attribute->ID;
    $value->setValue('Value');
    $this->assertEquals('Value', $value->getValue());
    $this->assertEquals('Value', $value->Value);

    $attribute->delete();
  }

  public function testReturnNumericValue()
  {
    $attribute = Attribute::create();
    $attribute->Type = AttributeType::Number;
    $attribute->write();

    $value = AttributeValue::create();
    $value->AttributeID = $attribute->ID;
    $value->setValue('2');
    $this->assertTrue((float) 2 === $value->Value, $value->Value);

    $attribute->delete();
  }

  public function testReturnsNonNumericalValue()
  {
    $attribute = Attribute::create();
    $attribute->Type = AttributeType::Text;
    $attribute->write();

    $value = AttributeValue::create();
    $value->AttributeID = $attribute->ID;
    $value->Value = 2;
    $value->write();

    $value = AttributeValue::get()->filter('ID', $value->ID)->first();
    $this->assertTrue('2' === $value->Value);

    $attribute->delete();
    $value->delete();
  }


  public function testIsLocalizedWhenLocalized()
  {
    $attribute = Attribute::create();
    $attribute->Localized = true;
    $attribute->write();

    $value = AttributeValue::create();
    $value->AttributeID = $attribute->ID;

    $this->assertTrue($value->isLocalized());

    $attribute->delete();
  }

  public function testIsLocalizedWhenNotLocalized()
  {
    $attribute = Attribute::create();
    $attribute->Localized = false;
    $attribute->write();

    $value = AttributeValue::create();
    $value->AttributeID = $attribute->ID;

    $this->assertFalse($value->isLocalized());
    $attribute->delete();
  }

  public function testIsNumericalWhenNumerical()
  {
    $attribute = Attribute::create();
    $attribute->Type = AttributeType::Number;
    $attribute->write();

    $value = AttributeValue::create();
    $value->AttributeID = $attribute->ID;
    $this->assertTrue($value->isNumerical());
  }

  public function testIsNumericalWhenNotNumerical()
  {
    $attribute = Attribute::create();
    $attribute->Type = AttributeType::Text;
    $attribute->write();

    $value = AttributeValue::create();
    $value->AttributeID = $attribute->ID;
    $this->assertFalse($value->isNumerical());
  }
}
