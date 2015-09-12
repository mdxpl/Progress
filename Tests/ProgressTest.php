<?php
include('RichTestCase.php');
include('Progress.php');

/**
 * Class ProgressTest
 *
 * @author Mateusz Dołęga <mdx@mdx.pl>
 */
class ProgressTest extends RichTestCase
{

    public function testIfIsMoreThanOneAfterIsUnavailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 2;
        $progress = new Progress($allOrdered, $doneUnordered);
        $this->assertFalse($progress->isAvailable($testId));
    }

    public function testIfIsEqualToOneAfterDoneIsAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 7;
        $progress = new Progress($allOrdered, $doneUnordered);
        $this->assertTrue($progress->isAvailable($testId));
    }

    public function testIfIsEqualToLastDoneIsAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 10;
        $progress = new Progress($allOrdered, $doneUnordered);
        $this->assertTrue($progress->isAvailable($testId));
    }

    public function testIfIsLessThanLastDoneIdAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [5, 6, 9, 10];
        $testId = 6;
        $progress = new Progress($allOrdered, $doneUnordered);
        $this->assertTrue($progress->isAvailable($testId));
    }

    public function testIfNothingIsDoneFirstIsAvailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [];
        $testId = 9;
        $progress = new Progress($allOrdered, $doneUnordered);
        $this->assertTrue($progress->isAvailable($testId));
    }

    public function testIfNothingIsDoneLastIsUnavailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [];
        $testId = 3;
        $progress = new Progress($allOrdered, $doneUnordered);
        $this->assertFalse($progress->isAvailable($testId));
    }

    public function testIfNothingIsDoneSecondIsUnavailable()
    {
        $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
        $doneUnordered = [];
        $testId = 6;
        $progress = new Progress($allOrdered, $doneUnordered);

        $this->assertFalse($progress->isAvailable($testId));
    }

    public function testIfAllOrderedArrayIsEmptyObjectThrowException()
    {
        $test = function () {
            $allOrdered = [];
            $doneUnordered = [];
            new Progress($allOrdered, $doneUnordered);
        };

        $this->assertException($test, 'InvalidArgumentException');
    }

}
