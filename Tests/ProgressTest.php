<?php

require_once('Progress/Progress.php');

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
        $test = function () {
            $allOrdered = [];
            $doneUnordered = [];
            new Progress($allOrdered, $doneUnordered);
        };

        $this->assertException($test, 'InvalidArgumentException');
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

    /**
     * @param callable $callback
     * @param string $expectedException
     * @param null $expectedCode
     * @param null $expectedMessage
     * @link https://gist.github.com/VladaHejda/8826707
     */
    protected function assertException(callable $callback, $expectedException = 'Exception', $expectedCode = null, $expectedMessage = null)
    {
        $expectedException = ltrim((string)$expectedException, '\\');
        if (!class_exists($expectedException) && !interface_exists($expectedException)) {
            $this->fail(sprintf('An exception of type "%s" does not exist.', $expectedException));
        }
        try {
            $callback();
        } catch (\Exception $e) {
            $class = get_class($e);
            $message = $e->getMessage();
            $code = $e->getCode();
            $errorMessage = 'Failed asserting the class of exception';
            if ($message && $code) {
                $errorMessage .= sprintf(' (message was %s, code was %d)', $message, $code);
            } elseif ($code) {
                $errorMessage .= sprintf(' (code was %d)', $code);
            }
            $errorMessage .= '.';
            $this->assertInstanceOf($expectedException, $e, $errorMessage);
            if ($expectedCode !== null) {
                $this->assertEquals($expectedCode, $code, sprintf('Failed asserting code of thrown %s.', $class));
            }
            if ($expectedMessage !== null) {
                $this->assertContains($expectedMessage, $message, sprintf('Failed asserting the message of thrown %s.', $class));
            }
            return;
        }
        $errorMessage = 'Failed asserting that exception';
        if (strtolower($expectedException) !== 'exception') {
            $errorMessage .= sprintf(' of type %s', $expectedException);
        }
        $errorMessage .= ' was thrown.';
        $this->fail($errorMessage);
    }
}
