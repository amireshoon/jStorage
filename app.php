<?php

namespace App\sample;

use jStorage;

require_once('src/jStorage.php');

// With .gitignore
$jStorage = new jStorage\App('storage2/main.json', __DIR__ .  '/.gitignore');

// Without .gitignore
// $jStorage = new jStorage\App('storage2/main.json');
// $jStorage = new jStorage\App('storage2/main.json', false);

// $jStorage->get();

// $jStorage->add('amir',[
//     'password' => 'JG^RWY',
//     'first_last_name' => 'Amirhossein Meydani'
// ]);

// $jStorage->commit();

$jStorage->update('username','ali');