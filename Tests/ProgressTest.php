<?php

use MDX\Progress\Progress;

/**
 * Class ProgressTest
 */
class ProgressTest extends PHPUnit_Framework_TestCase
{

    public function testFirstItem()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [2, 1];
        $progress = new Progress($allOrdered, $doneUnordered);

        $this->assertEquals($progress->getFirstItem(), 1);
    }

    public function testLastItem()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [2, 1];
        $progress = new Progress($allOrdered, $doneUnordered);

        $this->assertEquals($progress->getLastItem(), 3);
    }

    public function testLastDoneItem()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [2, 1];
        $progress = new Progress($allOrdered, $doneUnordered);

        $this->assertEquals($progress->getLastDoneItem(), 2);
    }


    public function testGetAllOrderedItems()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [2, 1];
        $progress = new Progress($allOrdered, $doneUnordered);

        $this->assertEquals($progress->getAllOrderedItems(), $allOrdered);
    }

    public function testGetDoneUnorderedItems()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [2, 1];
        $progress = new Progress($allOrdered, $doneUnordered);

        $this->assertEquals($progress->getDoneUnorderedItems(), $doneUnordered);
    }

    public function testNextItem()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [2, 1];
        $progress = new Progress($allOrdered, $doneUnordered);

        $this->assertEquals($progress->getNextItem(1), 2);
    }

    public function testPrevItemIsEmptyForFirstItem()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [2, 1];
        $progress = new Progress($allOrdered, $doneUnordered);

        $this->assertNull($progress->getPreviousItem(1));
    }

    public function testNextItemIsEmptyForLastItem()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [2, 1];
        $progress = new Progress($allOrdered, $doneUnordered);

        $this->assertNull($progress->getNextItem(3));
    }

    public function testPrevItemIsEmptyForSecondItem()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [2, 1];
        $progress = new Progress($allOrdered, $doneUnordered);

        $this->assertEquals($progress->getPreviousItem(2), 1);
    }

    public function testNextItemIsEmptyForSecondItem()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [2, 1];
        $progress = new Progress($allOrdered, $doneUnordered);

        $this->assertEquals($progress->getNextItem(2), 3);
    }

    public function testSetOrderedItemSetSequentialKeys()
    {
        $allOrdered = [1 => 1, 3 => 2, 5 => 3];
        $doneUnordered = [2, 1];
        $progress = new Progress($allOrdered, $doneUnordered);

        $this->assertEquals(array_keys($progress->getAllOrderedItems()), [0, 1, 2]);
    }

    public function testSetEmptyArrayAsOrderedItem()
    {
        $this->expectException(InvalidArgumentException::class);

        $allOrdered = [];
        $doneUnordered = [];
        new Progress($allOrdered, $doneUnordered);
    }

    public function testIsDoneItem()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [1, 3];
        $progress = new Progress($allOrdered, $doneUnordered);
        $this->assertTrue($progress->isDoneItem(3));
    }

    public function testIsNotDoneItem()
    {
        $allOrdered = [1, 2, 3];
        $doneUnordered = [1, 3];
        $progress = new Progress($allOrdered, $doneUnordered);
        $this->assertFalse($progress->isDoneItem(2));
    }

}
