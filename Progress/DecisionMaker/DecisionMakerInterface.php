<?php

/**
 * Interface DecisionMakerInterface
 *
 * @link https://github.com/mdxpl/Progress
 */
interface DecisionMakerInterface
{
    /**
     * @param ProgressInterface $progress
     */
    public function __construct(ProgressInterface $progress);

    /**
     * @param int|string $item
     * @return bool
     */
    public function isAvailable($item);
}
