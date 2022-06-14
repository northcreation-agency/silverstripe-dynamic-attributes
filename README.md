# Dynamic Attributes

Silverstripe extension for management of Object/Product attribute management.

This module provides an extension that can be applied to DataObjects in Silverstripe to give the a basic setup to manage sets of Attributes that vary across Models, such as product attributes.

The goal is to be able to manage changing Attributes/listing data on a model basis instead of on an object-basis, without having to define database fields for every new attribute that a CMS user wants to add.

There are three levels to the extension:

AttributeSets - A set of Attributes

Attributes - An Attribute Model that be set to be localized and typed as well as being activated on a model by model basis.

AttributeValues - Instances of an Attribute e.g. ProductWeight. The actual object that contains the values.

## Installation

Add the following to your composer.json file:

```json
"repositories" : [
  {
    "type": "vcs",
    "url": "https://github.com/northcreation-agency/silverstripe-dynamic-attributes.git"
  },
]
```

and then require with

```
composer require northcreationagency/dynamic-attributes
```

## Configuration

We have added two ways to use the extension:

By extending the AttributeHolder class

```PHP
use NorthCreationAgency\DynamicAttributes\AttributeHolder;

class MyClass extends AttributeHolder
{
  //...
}
```

or by extension, simply add this to your yml-config

```yml
MyClass:
  extensions:
    - 'NorthCreationAgency\DynamicAttributes\AttributeExtension'
```

## Usage

A lot of functionality will be specific to the project in question, therefore we have chosen to leave the core as clean as possible and leave implementation of detailed features to consumers of this module.

When the extension applied to a DataObject, it will add two relations to that Object:

- One AttributeSet, which will be the "model" applied to that DataObject, e.g. "Product - Camera". The idea is that we will be able to manage this model, and in turn all tables or listings that want to display Camera products.

- has_many AttributeValues: These will be the instances of the values. These are currently not added by default, but in a normal setting would be applied/removed in an onBeforeWrite() on the object in question.

### Useful methods

getSortedAttributeValues - Returns a sorted list of Active AttributeValues that belongs to the AttributeSet assigned to the dataobject.

getAttributes - Gets the Attributes that belongs to the set assigned to the DataObject. It's useful to use this method since you can be sure it will include the "Active" and "Sort" values that are stored in the join table between AttributeSet and Attributes
