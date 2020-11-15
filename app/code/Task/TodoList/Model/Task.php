<?php
/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
namespace Task\TodoList\Model;

use Magento\Framework\Model\AbstractModel;
use Task\TodoList\Api\Data\TaskInterface;
use Task\TodoList\Model\ResourceModel\Task as TaskResource;

/**
 * Class Task
 */
class Task extends AbstractModel implements TaskInterface
{
    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = TaskInterface::ID;

    /**
     * Model initialization
     */
    protected function _construct()
    {
        $this->_init(TaskResource::class);
    }

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData(TaskInterface::CUSTOMER_ID);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setCustomerId(int $id)
    {
        $this->setData(TaskInterface::CUSTOMER_ID, $id);
        return $this;
    }

    /**
     * @return string
     */
    public function getTask()
    {
        return $this->getData(TaskInterface::TASK);
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setTask(string $content)
    {
        $this->setData(TaskInterface::TASK, $content);
        return $this;
    }
}
