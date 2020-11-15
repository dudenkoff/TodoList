<?php
/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
namespace Task\TodoList\Model\ResourceModel\Task;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Task\TodoList\Model\ResourceModel\Task as TaskResource;
use Task\TodoList\Model\Task;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Collection initialization
     */
    protected function _construct()
    {
        $this->_init(Task::class, TaskResource::class);
    }
}
