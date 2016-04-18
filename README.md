# Progress
## Simple decision object

Is useful if you have to decide if user can access an element in a ordered queue.

Installation
============

Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require mdx/progress 1.0
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Usage
============
```php
<?php

require_once('./vendor/autoload.php');

//input
$allSorted = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
$done = [9, 5, 6];
$current = 4;

//progress
$progress = new \MDX\Progress\Progress($allSorted, $done);

echo 'All items: ' . "\n";
print_r($allSorted);

echo 'Done items: ' . "\n";
print_r($done);

echo 'Done items ordered by all items: ' . "\n";
print_r($progress->getDoneOrderedItems());

echo 'Current Item: ' . $current . "\n";
echo 'First Item: ' . $progress->getFirstItem() . "\n";
echo 'Last Item: ' . $progress->getLastItem() . "\n";
echo 'Last done Item: ' . $progress->getLastDoneItem() . "\n";
echo 'Next Item: ' . $progress->getNextItem($current) . "\n";
echo 'Previous Item: ' . $progress->getPreviousItem($current) . "\n";

//decisions
$decisionMaker = new \MDX\DecisionMaker\DecisionMaker($progress);
echo 'Current item ' . $current . ' is ' . ($decisionMaker->isAvailable($current) ? 'available' : 'unavailable') . "\n";
echo 'Last available item: ' . $decisionMaker->getLastAvailable() . "\n";
for ($i = 1; $i <= 10; $i++) {
    echo 'Item ' . $i . ' is ' . ($decisionMaker->isAvailable($i) ? 'available' : 'unavailable') . "\n";
}
```