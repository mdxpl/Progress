<?php

include('RichTestCase.php');
include('Progress/Progress.php');
include('Progress/DecisionMaker/TwoFlatArraysDecisionMaker.php');

/**
 * Class ProgressTest
 */
class TwoFlatArraysDecisionMakerTest extends RichTestCase
{

    public function testIfIsMoreThanOneAfterIsUnavailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 2;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new TwoFlatArraysDecisionMaker($progress);

        $this->assertFalse($decisionMaker->isAvailable($testId));
    }

    public function testIfIsEqualToOneAfterDoneIsAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 7;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new TwoFlatArraysDecisionMaker($progress);

        $this->assertTrue($decisionMaker->isAvailable($testId));
    }

    public function testIfIsEqualToLastDoneIsAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 10;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new TwoFlatArraysDecisionMaker($progress);

        $this->assertTrue($decisionMaker->isAvailable($testId));
    }

    public function testIfIsLessThanLastDoneIdAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 6;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new TwoFlatArraysDecisionMaker($progress);

        $this->assertTrue($decisionMaker->isAvailable($testId));
    }

    public function testIfNothingIsDoneFirstIsAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [];
        $testId = 9;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new TwoFlatArraysDecisionMaker($progress);

        $this->assertTrue($decisionMaker->isAvailable($testId));
    }

    public function testIfNothingIsDoneLastIsUnavailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [];
        $testId = 3;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new TwoFlatArraysDecisionMaker($progress);

        $this->assertFalse($decisionMaker->isAvailable($testId));
    }

    public function testIfNothingIsDoneSecondIsUnavailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [];
        $testId = 6;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new TwoFlatArraysDecisionMaker($progress);

        $this->assertFalse($decisionMaker->isAvailable($testId));
    }

    public function testIfAllOrderedArrayIsEmptyObjectThrowException()
    {
        $test = function () {
            $allOrdered = [];
            $doneUnordered = [];
            $progress = new Progress($allOrdered, $doneUnordered);
            new TwoFlatArraysDecisionMaker($progress);
        };

        $this->assertException($test, 'InvalidArgumentException');
    }

    public function testIfDoneArrayIsEmptySecondIsUnavailable()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [];
        $testId = 2;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new TwoFlatArraysDecisionMaker($progress);

        $this->assertFalse($decisionMaker->isAvailable($testId));
    }

    public function testIfDoneArrayIsEmptyFirstIsAvailable()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [];
        $testId = 1;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new TwoFlatArraysDecisionMaker($progress);

        $this->assertTrue($decisionMaker->isAvailable($testId));
    }

    public function testAlphabeticalArrayIfNothingIsDoneLastIsUnavailable()
    {
        $allOrdered = ['cat', 'dog', 'cow'];
        $doneUnordered = [];
        $testId = 'cow';
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new TwoFlatArraysDecisionMaker($progress);

        $this->assertFalse($decisionMaker->isAvailable($testId));
    }

    public function testAlphabeticalArrayIfNothingIsDoneFirstIsAvailable()
    {
        $allOrdered = ['cat', 'dog', 'cow'];
        $doneUnordered = [];
        $testId = 'cat';
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new TwoFlatArraysDecisionMaker($progress);

        $this->assertTrue($decisionMaker->isAvailable($testId));
    }
}
