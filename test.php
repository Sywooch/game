<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.10.14
 * Time: 10:53
 */
$m = new MongoClient();
$db = $m->selectDB('modx');
$collection = new MongoCollection($db, 'Template');

// search for fruits
$fruitQuery = array('id' => '99');

$cursor = $collection->find($fruitQuery);
foreach ($cursor as $doc) {
    var_dump($doc);
}

//// search for produce that is sweet. Taste is a child of Details.
//$sweetQuery = array('Details.Taste' => 'Sweet');
//echo "Sweet\n";
//$cursor = $collection->find($sweetQuery);
//foreach ($cursor as $doc) {
//    var_dump($doc);
//}