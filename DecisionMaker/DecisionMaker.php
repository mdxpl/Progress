<?php

namespace MDX\DecisionMaker;
use MDX\Progress\ProgressInterface;

/**
 * Class DecisionMaker
 *
 * @link https://github.com/mdxpl/Progress
 */
class DecisionMaker implements DecisionMakerInterface
{

    /**
     * @var ProgressInterface
     */
    private $progress;

    /**
     * @param ProgressInterface $progress
     * @codeCoverageIgnore
     */
    public function __construct(ProgressInterface $progress)
    {
        $this->progress = $progress;
    }

    /**
     * @return mixed
     */
    public function getLastAvailable()
    {
        $lastAvailable = null;
        $all = $this->progress->getAllOrderedItems();
        foreach ($all as $item) {
            if ($this->isAvailable($item)) {
                $lastAvailable = $item;
            }
        }

        return $lastAvailable;
    }

    /**
     * @param int|string $id
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function isAvailable($id)
    {
        //First is always available
        if ($id === $this->progress->getFirstItem()) {
            return true;
        }

        //Done array is empty is not available
        if (count($this->progress->getDoneUnorderedItems()) < 1) {
            return false;
        }

        //If is done is available
        if (array_search($id, $this->progress->getDoneOrderedItems())) {
            return true;
        }

        //If is next after done is available
        $itemPosition = array_search($id, $this->progress->getAllOrderedItems());
        if (false === $itemPosition) {
            throw new \InvalidArgumentException('Id is not found in All items array.');
        }

        //If nothing is done only first is available
        $lastDone = $this->progress->getLastDoneItem();

        //If item position is equal to one after last done is available
        return $itemPosition === array_search($lastDone, $this->progress->getAllOrderedItems()) + 1;
    }
}
