<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\DataObject;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class AttributeSet extends DataObject
{
  private static $table_name = 'nca/AttributeSet';

  private static $db = [
    'Key' => 'Varchar',
    'Title' => 'Varchar',
  ];

  private static $many_many = [
    'Attributes' => Attribute::class,
  ];

  private static $many_many_extraFields = [
    'Attributes' => ['Sort' => 'Int']
  ];

  public function getCMSFields()
  {
    $fields = parent::getCMSFields();
    $fields->removeByName('Key');
    $gf = $fields->dataFieldByName("Attributes");
    $gf->setConfig($cnf = GridFieldConfig_RecordEditor::create());
    if ($this->Attributes()->count() > 0) {
      $cnf->addComponent(GridFieldOrderableRows::create('Sort'));
    }
    return $fields;
  }

  public static function findOrCreate(array $input)
  {
    $existing = AttributeSet::get()->filter($input)->first();
    if ($existing) {
      return $existing;
    }
    return AttributeSet::create($input);
  }
}
