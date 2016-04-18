<?php

namespace MDX\Progress;

/**
 * Class Progress
 *
 * @link https://github.com/mdxpl/Progress
 */
class Progress implements ProgressInterface
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
    public function __construct(array $allOrdered = [], array $doneUnordered = [])
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
     * @throws \InvalidArgumentException
     */
    private function setAllOrderedItems(array $allOrderedItems)
    {
        if (count($allOrderedItems) < 1) {
            throw new \InvalidArgumentException('Ordered items array can`t be empty.');
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
    private function setDoneUnorderedItems($doneUnorderedItems)
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
     * @param $id
     * @return bool
     */
    public function isDoneItem($id)
    {
        return in_array($id, $this->getDoneOrderedItems());
    }

    /**
     * @return mixed
     */
    public function getLastDoneItem()
    {
        $done = $this->getDoneOrderedItems();
        return end($done);
    }

    /**
     * @return array
     */
    public function getFirstItem()
    {
        return $this->getAllOrderedItems()[0];
    }

    /**
     * @return mixed
     */
    public function getLastItem()
    {
        $all = $this->getAllOrderedItems();
        return end($all);
    }

    /**
     * @param $id
     * @return bool
     */
    public function isFirstItem($id)
    {
        return $this->getFirstItem() === $id;
    }

    /**
     * @param $id
     * @return bool
     */
    public function isLastItem($id)
    {
        return $this->getLastItem() === $id;
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function getNextItem($id)
    {
        if ($this->isLastItem($id)) {
            return null;
        }

        $all = $this->getAllOrderedItems();
        $itemPosition = array_search($id, $all);

        return $all[$itemPosition + 1];
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function getPreviousItem($id)
    {
        if ($this->isFirstItem($id)) {
            return null;
        }

        $all = $this->getAllOrderedItems();
        $itemPosition = array_search($id, $all);

        return $all[$itemPosition - 1];
    }
}
