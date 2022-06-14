<?php

namespace NorthCreationAgency\DynamicAttributes;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldPageCount;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\TextField;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldConfigurablePaginator;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;

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

  public function getCMSFields()
  {
    $fields = parent::getCMSFields();
    $fields->removeByName('Key');
    $fields->removeByName('Attributes');
    $fields->addFieldToTab("Root.Main", new GridField("Attributes", "Attributes", $this->Attributes(), $cnf = GridFieldConfig_RelationEditor::create()));

    $cnf->removeComponentsByType(GridFieldDataColumns::class);
    $cnf->removeComponentsByType(GridFieldAddNewButton::class);

    $cnf->addComponent(
      new GridFieldEditableColumns(),
      GridFieldEditButton::class
    );
    $cnf->addComponent(
      new GridFieldAddNewInlineButton(),
      GridFieldAddExistingAutocompleter::class
    );

    $cnf->removeComponentsByType(GridFieldPaginator::class);
    $cnf->removeComponentsByType(GridFieldPageCount::class);
    $paginator = new GridFieldConfigurablePaginator();
    $paginator->setPageSizes([20, 50, 100]);
    $cnf->addComponent($paginator);

    /** @var GridFieldEditableColumns */
    $columns = $cnf->getComponentByType(GridFieldEditableColumns::class);

    $columns->setDisplayFields(array(
      'Title' => array(
        'title' => 'Title',
        'callback' => function ($record, $column, $grid) {
          return TextField::create($column);
        }
      ),
      'Key' => array(
        'title' => 'Key',
        'callback' => function ($record, $column, $grid) {
          return TextField::create($column);
        }
      ),
      'Nca_AttributeLink_AttributeSet_Attribute.Sort' => array(
        'title' => 'Sort Order',
        'callback' => function ($record, $column, $grid) {
          return TextField::create($column);
        }
      ),
      'Nca_AttributeLink_AttributeSet_Attribute.Active' => array(
        'title' => 'Active',
        'callback' => function ($record, $column, $grid) {
          return CheckboxField::create($column);
        }
      ),
    ));

    $this->extend('updateDataColumns', $columns);


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
