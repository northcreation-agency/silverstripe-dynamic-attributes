# Dynamic Attributes

Silverstripe extension for management of Object/Product attribute management.

This module provides an extension that can be applied to DataObjects in Silverstripe to give the a basic setup to manage sets of Attributes that vary across Models, such as product attributes.
The goal is to be able to manage table/listing data on a model basis instead of on an object-basis.

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

When applied to a DataObject, it will add two relations to that Object:

- One AttributeSet, which will be the "model" applied to that DataObject, e.g. "Product - Camera". The idea is that we will be able to manage this model and in turn all tables or listings that want to display Camera products.

- has_many AttributeValues: These will be the instances of the values. These are currently not added by default, but in a normal setting would be applied/removed in an onBeforeWrite() on the object in question.

There are some additional gridfieldextensions that have been applied for easier, inline editing of AttributeSets.
