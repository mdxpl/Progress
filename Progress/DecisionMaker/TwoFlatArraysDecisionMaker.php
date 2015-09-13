<?php

include('DecisionMakerInterface.php');

/**
 * Class TwoFlatArraysDecisionMaker
 *
 * @link https://github.com/mdxpl/Progress
 */
class TwoFlatArraysDecisionMaker implements DecisionMakerInterface
{

    /**
     * @var Progress
     */
    protected $progress;

    /**
     * @param ProgressInterface $progress
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
            } else {
                break;
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
        if (!$lastDone = $this->progress->getLastDoneItem()) {
            return false;
        }

        //If item position is equal to one after last done is available
        return $itemPosition === array_search($lastDone, $this->progress->getAllOrderedItems()) + 1;
    }
}