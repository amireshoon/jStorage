# jStorage - a Light non-framework JSON-BASED storage
[![GitHub issues](https://img.shields.io/github/issues/Naereen/StrapDown.js.svg)](https://github.com/amireshoon/jStorage/issues/)
[![Awesome Badges](https://img.shields.io/badge/badges-awesome-green.svg)](https://github.com/amireshoon/jStorage)

jStorage is JSON-BASED small key value storage for more porductive.

  - No frameworks used
  - .gitignore option
  - Light and ready to go

### Installation

Install using composer:

```php
$ composer require amirhwsin/jstorage:dev-master
```
it's highly recommended installing using composer but if you need other way to go you can download project from git or simply clone it.
```sh
$ git clone https://github.com/amireshoon/jStorage.git
```

### Methods

There is no index or primary key for fetching data.
jStorage uses `jStorage_key` for indexing data.
You will have custom `key` paramteres for customizing storage.

Some methods you have to know about:

| Methods | Description |
| ------ | ------ |
| add | Insert new data set in storage |
| update | Update exists data set by `key`|
| remove | Remove exists data set by `key` |
| get | Get exists data set by `key` |
| commit | Commit all changes that you made |


### Usage

Use this code to load class:
```php
use jStorage;
```
If you want to git ignore your storage then use like this:
First parameter is where storage(JSON file) stored.
And the second one is for `.gitignore` file path.
```php
$jStorage = new jStorage\App('storage_folder/db.json', __DIR__ .  '/.gitignore');
```
Otherwise use this:
```php
 $jStorage = new jStorage\App('storage_folder/db.json');
```

# Add
For adding object to storage use like this:

array usage (Will compiled to json):
```php
 $jStorage->add('username',[
     'password' => 'JG^RWY',
     'first_last_name' => 'Amirhossein Meydani',
     'email' => 'amirhwsin@outlook.com'
 ]);
```
string usage:
```php
$jStorage->add('username','amirhossein');
```
int usage:
```php
$jStorage->add('phone_number',19248124);
```
bool usage:
```php
$jStorage->add('is_prefect_day', true);
```

At the end **do not forget to commit** like this:
```php
$jStorage->commt();
```

# Get
To get a data set you have to use `key` that you used to store data set.
You can get data set like this:
```php
$is_prefect_day = $jStorage->get('is_prefect_day');
```
# Update
For update a data set you have to use `key` that you store data set.
```php
$jStorage->update('key','new value');
```
At the end **do not forget to commit** like this:
```php
$jStorage->commt();
```
# Remove
```php
$jStorage->remove('key');
```
At the end **do not forget to commit** like this:
```php
$jStorage->commt();
```
License
----

MIT


**Feel free to contribute**

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)
