<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\DataObject;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class AttributeSet extends DataObject
{
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
    $cnf->addComponent(GridFieldOrderableRows::create());
    return $fields;
  }
}
