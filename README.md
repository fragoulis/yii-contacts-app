Yii Contacts Extension
===================

A versatile and easy to incorporate to your web application module. **Contacts** hands out an API
to connect any model with contact information, namely Address and/or Phone Numbers.

## Installation

* Download the module and save it in your project's _extensions_ folder

`git clone git@github.com:jfragoulis/yii-contacts.git /path/to/project/protected/extensions/contacts`

* Update your project's configuration (web and console application).

Import the module files:
```php
'import' => array(
	...
	'ext.contacts.models.*',
	...
),
```

* Run `./yiic migrate --migrationPath=ext.contacts.migrations --interactive=0`