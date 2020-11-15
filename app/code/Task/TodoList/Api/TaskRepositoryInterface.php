<?php
/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
namespace Task\TodoList\Api;

use Task\TodoList\Api\Data\TaskInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Task\TodoList\Api\Data\TaskSearchResultInterface;

/**
 * Interface TaskRepositoryInterface
 * @api
 */
interface TaskRepositoryInterface
{
    /**
     * @param int $id
     * @return TaskInterface
     */
    public function get(int $id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TaskSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param TaskInterface $task
     * @return TaskInterface
     */
    public function save(TaskInterface $task);

    /**
     * @param TaskInterface $task
     * @return bool
     */
    public function delete(TaskInterface $task);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id);
}
