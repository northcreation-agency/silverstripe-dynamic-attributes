<?php



namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\ORM\DataObject;



class Attribute extends DataObject
{
  private static $db = [
    'Key' => 'Varchar',
    'Title' => 'Varchar',
    'Type' => 'Enum(array("' . AttributeType::Number . '","' . AttributeType::Text . '"), "' . AttributeType::Text . '")',
    'Localized' => 'Boolean'
  ];

  private static $owns = [
    'Values',
  ];

  private static $has_many = [
    'Values' => AttributeValue::class,
  ];

  private static $belongs_many_many = [
    "AttributeSets" => AttributeSet::class,
  ];

  public function getCMSFields()
  {
    $fields = parent::getCMSFields();
    $fields->removeByName('Key');
    return $fields;
  }

  public function isLocalized()
  {
    return $this->Localized;
  }

  public static function findOrCreate(array $input)
  {
    $existing = Attribute::get()->filter($input)->first();
    if ($existing) {
      return $existing;
    }
    return Attribute::create($input);
  }
}
