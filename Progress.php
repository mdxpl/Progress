<?php

/**
 * Class Progress
 *
 * @author Mateusz Dołęga <mdx@mdx.pl>
 * @link https://github.com/mdxpl/Progress
 */
class Progress
{
    /**
     * @var array
     */
    private $allOrderedItems = [];

    /**
     * @var array
     */
    private $doneUnorderedItems = [];

    /**
     * @var array|null
     */
    private $doneOrderedItems = null;

    /**
     * @param array $allOrdered
     * @param array $doneUnordered
     */
    public function __construct(array $allOrdered, array $doneUnordered)
    {
        $this->setAllOrderedItems($allOrdered);
        $this->setDoneUnorderedItems($doneUnordered);
    }

    /**
     * @return array
     */
    public function getAllOrderedItems()
    {
        return $this->allOrderedItems;
    }

    /**
     * @param array $allOrderedItems
     */
    public function setAllOrderedItems(array $allOrderedItems)
    {
        if (count($allOrderedItems) < 1) {
            throw new InvalidArgumentException('Ordered items array can`t be empty.');
        }
        //reset keys 0..n
        $this->allOrderedItems = array_values($allOrderedItems);
    }

    /**
     * @return array
     */
    public function getDoneUnorderedItems()
    {
        return $this->doneUnorderedItems;
    }

    /**
     * @param array $doneUnorderedItems
     */
    public function setDoneUnorderedItems($doneUnorderedItems)
    {
        $this->doneUnorderedItems = $doneUnorderedItems;
    }

    /**
     * @return array
     */
    public function getDoneOrderedItems()
    {
        if (null === $this->doneOrderedItems) {
            $this->doneOrderedItems = array_intersect($this->getAllOrderedItems(), $this->getDoneUnorderedItems());
        }

        return $this->doneOrderedItems;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isDone($id)
    {
        return in_array($id, $this->getDoneOrderedItems());
    }

    public function getLastDone()
    {
        $done = $this->getDoneOrderedItems();
        return end($done);
    }

    public function getFirstItem()
    {
        return $this->getAllOrderedItems()[0];
    }

    public function isAvailable($id)
    {
        //First is always available
        if ($id === $this->getFirstItem()) {
            return true;
        }

        //Done array is empty is not available
        if (count($this->doneUnorderedItems) < 1) {
            return false;
        }

        //If is done is available
        if (array_search($id, $this->getDoneOrderedItems())) {
            return true;
        }

        //If is next after done is available
        $itemPosition = array_search($id, $this->getAllOrderedItems());
        if (false === $itemPosition) {
            throw new InvalidArgumentException('Id is not found in All items array.');
        }

        //If nothing is done only first is available
        if (!$lastDone = $this->getLastDone()) {
            return false;
        }

        //If item position is equal to one after last done is available
        return $itemPosition === array_search($lastDone, $this->getAllOrderedItems()) + 1;
    }
}
