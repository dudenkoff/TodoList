<?php
/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
namespace Task\TodoList\Api;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface TaskManagementInterface
 */
interface TaskManagementInterface
{
    /**
     * Adds new task
     *
     * @param CustomerInterface $customer
     * @param string $task
     * @return string
     * @throws CouldNotSaveException The specified task could not be added.
     */
    public function set(CustomerInterface $customer, $task);

    /**
     * Removes task
     *
     * @param CustomerInterface $customer
     * @param string $taskId
     * @return bool
     * @throws NoSuchEntityException The specified task does not exist.
     * @throws CouldNotSaveException The specified task could not be removed.
     */
    public function remove(CustomerInterface $customer, $taskId);
}
