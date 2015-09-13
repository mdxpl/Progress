# Progress
## Simple decision object

Is useful if you have to decide if user can access an element in a ordered queue.

```php
<?php

include('Progress/Progress.php');
include('Progress/DecisionMaker/TwoFlatArraysDecisionMaker.php');

$allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
$doneUnordered = [9, 5, 6];
$current = 4;
$progress = new Progress($allOrdered, $doneUnordered);
$decisionMaker = new TwoFlatArraysDecisionMaker($progress);
$isCurrentAvailable = $decisionMaker->isAvailable($current) ? 'available' : 'unavailable';
echo 'Current item (' . $current . ') is ' . $isCurrentAvailable . "\n";

```
