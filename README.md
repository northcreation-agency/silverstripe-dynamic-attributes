# Dynamic Attributes

Silverstripe extension for management of Object/Product attribute management.

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
