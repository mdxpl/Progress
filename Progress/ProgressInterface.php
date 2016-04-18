<?php

namespace MDX\Progress;

/**
 * Interface ProgressInterface
 *
 * @link https://github.com/mdxpl/Progress
 */
interface ProgressInterface
{
    /**
     * @return mixed
     */
    public function getFirstItem();

    /**
     * @return mixed
     */
    public function getLastItem();

    /**
     * @param $id
     * @return bool
     */
    public function isFirstItem($id);

    /**
     * @param $id
     * @return bool
     */
    public function isLastItem($id);

    /**
     * @param $id
     * @return mixed|null
     */
    public function getNextItem($id);

    /**
     * @param $id
     * @return mixed|null
     */
    public function getPreviousItem($id);

    /**
     * @return array
     */
    public function getAllOrderedItems();

    /**
     * @return array
     */
    public function getDoneUnorderedItems();

    /**
     * @return array
     */
    public function getDoneOrderedItems();

    /**
     * @return mixed|null
     */
    public function getLastDoneItem();

}
