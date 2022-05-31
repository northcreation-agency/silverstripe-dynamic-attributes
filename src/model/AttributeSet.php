<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\GridField\GridField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class AttributeSet extends DataObject
{
  private static $table_name = 'Nca_AttributeSet';

  private static $db = [
    'Key' => 'Varchar',
    'Title' => 'Varchar',
  ];

  private static $many_many = [
    "Attributes" => [
      'through' => AttributeLink::class,
      'from' => 'AttributeSet',
      'to' => 'Attribute',
    ]
  ];



  // private static $many_many_extraFields = [
  //   'Attributes' => [
  //     'Sort' => 'Int',
  //     'Active' => 'Boolean'
  //   ]
  // ];

  // private static $defaults = [
  //   'Attributes' => [
  //     'Active' => 1,
  //   ],
  // ];

  public function getCMSFields()
  {
    $fields = parent::getCMSFields();
    $fields->removeByName('Key');
    $fields->removeByName('Attributes');
    $fields->addFieldToTab("Root.Main", new GridField("Attributes", "Attributes", $this->Attributes(), $cnf = GridFieldConfig_RecordEditor::create()));
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

  public function getActiveAttributes()
  {
    return $this->Attributes()->filter('Active', true);
  }
}
