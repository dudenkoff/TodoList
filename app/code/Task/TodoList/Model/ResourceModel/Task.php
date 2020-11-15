<?php
/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
namespace Task\TodoList\Model\ResourceModel;

use Task\TodoList\Api\Data\TaskInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Task
 */
class Task extends AbstractDb
{
    /**
     * Constants
     */
    const TABLE_NAME = 'task_todo_list';

    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, TaskInterface::ID);
    }
}
