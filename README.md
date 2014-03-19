yii-contacts
============

A Contacts module for Yii

# How to install

* Download the module
* Save it in your project's extensions forlder
* Update your project's configuration (web and console application).

Include the module: 
```php
'modules' => array(
	...
	'contacts',
	...
),
```

Import the module files:
```php
'import' => array(
	...
	'application.modules.contacts.models.*',
	'application.modules.contacts.components.*',
	'application.modules.contacts.components.behaviors.*',
	'application.modules.contacts.components.enums.*',
	'application.modules.contacts.components.interfaces.*',
	...
),
```

* Run `./yiic migrate --migrationPath=contacts.migrations --interactive=0`