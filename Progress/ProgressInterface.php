<?php

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
}
