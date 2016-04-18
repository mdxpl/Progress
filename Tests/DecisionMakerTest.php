<?php

use MDX\Progress\Progress;
use MDX\DecisionMaker\DecisionMaker;

/**
 * Class ProgressTest
 */
class DecisionMakerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testIfItemNotExistsInAllItemsThrowAnException()
    {
        $this->expectException(InvalidArgumentException::class);

        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 11;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);
        $decisionMaker->isAvailable($testId);
    }

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testIfIsMoreThanOneAfterIsUnavailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 2;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);

        $this->assertFalse($decisionMaker->isAvailable($testId));
    }

    /**
     * @covers DecisionMaker::getLastAvailable
     */
    public function testGetLastAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);

        $this->assertEquals(7, $decisionMaker->getLastAvailable());
    }

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testIfIsEqualToOneAfterDoneIsAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 7;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);

        $this->assertTrue($decisionMaker->isAvailable($testId));
    }

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testIfIsEqualToLastDoneIsAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 10;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);

        $this->assertTrue($decisionMaker->isAvailable($testId));
    }

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testIfIsLessThanLastDoneIdAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 6;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);

        $this->assertTrue($decisionMaker->isAvailable($testId));
    }

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testIfNothingIsDoneFirstIsAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [];
        $testId = 9;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);

        $this->assertTrue($decisionMaker->isAvailable($testId));
    }

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testIfNothingIsDoneLastIsUnavailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [];
        $testId = 3;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);

        $this->assertFalse($decisionMaker->isAvailable($testId));
    }

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testIfNothingIsDoneSecondIsUnavailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [];
        $testId = 6;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);

        $this->assertFalse($decisionMaker->isAvailable($testId));
    }

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testIfAllOrderedArrayIsEmptyObjectThrowException()
    {
        $this->expectException(InvalidArgumentException::class);

        $allOrdered = [];
        $doneUnordered = [];
        $progress = new Progress($allOrdered, $doneUnordered);
        new DecisionMaker($progress);
    }

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testIfDoneArrayIsEmptySecondIsUnavailable()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [];
        $testId = 2;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);

        $this->assertFalse($decisionMaker->isAvailable($testId));
    }

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testIfDoneArrayIsEmptyFirstIsAvailable()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [];
        $testId = 1;
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);

        $this->assertTrue($decisionMaker->isAvailable($testId));
    }

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testAlphabeticalArrayIfNothingIsDoneLastIsUnavailable()
    {
        $allOrdered = ['cat', 'dog', 'cow'];
        $doneUnordered = [];
        $testId = 'cow';
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);

        $this->assertFalse($decisionMaker->isAvailable($testId));
    }

    /**
     * @covers DecisionMaker::isAvailable
     */
    public function testAlphabeticalArrayIfNothingIsDoneFirstIsAvailable()
    {
        $allOrdered = ['cat', 'dog', 'cow'];
        $doneUnordered = [];
        $testId = 'cat';
        $progress = new Progress($allOrdered, $doneUnordered);
        $decisionMaker = new DecisionMaker($progress);

        $this->assertTrue($decisionMaker->isAvailable($testId));
    }

}
