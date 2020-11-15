<?php
/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
namespace Task\TodoList\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface TaskSearchResultInterface
 */
interface TaskSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return TaskInterface[]
     */
    public function getItems();

    /**
     * @param TaskInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
