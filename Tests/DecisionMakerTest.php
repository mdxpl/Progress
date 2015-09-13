<?php

require_once('Progress/Progress.php');
require_once('Progress/DecisionMaker/DecisionMaker.php');

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
        $test = function () {
            $allOrdered = [9, 6, 5, 4, 8, 10, 7, 2, 1, 3];
            $doneUnordered = [5, 6, 9, 10];
            $testId = 11;
            $progress = new Progress($allOrdered, $doneUnordered);
            $decisionMaker = new DecisionMaker($progress);
            $decisionMaker->isAvailable($testId);
        };

        $this->assertException($test, 'InvalidArgumentException');
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
        $test = function () {
            $allOrdered = [];
            $doneUnordered = [];
            $progress = new Progress($allOrdered, $doneUnordered);
            new DecisionMaker($progress);
        };

        $this->assertException($test, 'InvalidArgumentException');
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
