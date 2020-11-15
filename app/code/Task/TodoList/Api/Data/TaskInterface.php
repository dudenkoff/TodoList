<?php
/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
namespace Task\TodoList\Api\Data;

/**
 * Interface PostInterface
 * @api
 */
interface TaskInterface
{
    /**
     * Constants
     */
    const ID = 'entity_id';
    const CUSTOMER_ID = 'customer_id';
    const TASK = 'task';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param int $id
     * @return $this
     */
    public function setCustomerId(int $id);

    /**
     * @return string
     */
    public function getTask();

    /**
     * @param string $content
     * @return $this
     */
    public function setTask(string $content);
}
