Articles Extension for Yii 2
=====================================

INSTALLATION
------------

### Composer require section
```javascript
"black-lamp/yii2-articles": "0.*"
```

### Migrate

	yii migrate --migrationPath=@vendor/black-lamp/yii2-multi-lang/migration
	yii migrate --migrationPath=@vendor/black-lamp/yii2-articles/common/migrations
	yii migrate --migrationPath=@vendor/black-lamp/yii2-seo/migrations

### Add articles module to your backend config
```php
    'modules' => [
    	...
        'articles' => [
            'class' => 'bl\articles\backend\Module'
        ],
        ...
    ]
```

### Add articles module to your frontend config
```php
    'modules' => [
    	...
        'articles' => [
            'class' => 'bl\articles\frontend\Module'
        ],
        ...
    ]
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

### Use
	yourbackend.url/articles/article