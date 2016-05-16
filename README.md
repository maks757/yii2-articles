Articles Extension for Yii 2
=====================================

INSTALLATION
------------

### Migrate

	yii migrate --migrationPath=@vendor/black-lamp/yii2-multi-lang/migration
	yii migrate --migrationPath=@vendor/black-lamp/yii2-articles/common/migrations

### Composer require section
```javascript
"black-lamp/yii2-articles": "0.*"
```


### Configure seo-url rule
```php
'urlManager' => [
	...
	'rules' => [
		...
		[
			'class' => 'bl\articles\UrlRule'
		]
	]
]
```
