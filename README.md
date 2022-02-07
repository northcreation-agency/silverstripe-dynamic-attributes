# Dynamic Attributes

Silverstripe extension for management of Object/Product attribute management.

## Installation

Add the following to your composer.json file:

```
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

```
use NorthCreationAgency\DynamicAttributes\AttributeHolder;

class MyClass extends AttributeHolder
{
  //...
}
```

or by extension, simply add this to your yml-config

```
MyClass:
  extensions:
    - 'NorthCreationAgency\DynamicAttributes\AttributeExtension'
```

## Usage

Coming soon...
