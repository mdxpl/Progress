<?php
require_once('Progress/Progress.php');
require_once('Progress/DecisionMaker/DecisionMaker.php');

//input
$allSorted = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
$done = [9, 5, 6];
$current = 4;

//progress
$progress = new Progress($allSorted, $done);

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
$decisionMaker = new DecisionMaker($progress);
echo 'Current item ' . $current . ' is ' . ($decisionMaker->isAvailable($current) ? 'available' : 'unavailable') . "\n";
echo 'Last available item: ' . $decisionMaker->getLastAvailable() . "\n";
for ($i = 1; $i <= 10; $i++) {
    echo 'Item ' . $i . ' is ' . ($decisionMaker->isAvailable($i) ? 'available' : 'unavailable') . "\n";
}
