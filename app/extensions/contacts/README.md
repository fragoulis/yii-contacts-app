Yii Contacts Module
===================

A versatile and easy to incorporate to your web application module. **Contacts** hands out an API
to connect any model with contact information, namely Address and/or Phone Numbers.

## Installation

* Download the module and save it in your project's _extensions_ folder

`git clone git@github.com:jfragoulis/yii-contacts.git /path/to/project/protected/modules/contacts`

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