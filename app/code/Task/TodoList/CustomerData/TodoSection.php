<?php
/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
namespace Task\TodoList\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Task\TodoList\Api\TaskRepositoryInterface;

/**
 * Class TodoSection
 */
class TodoSection implements SectionSourceInterface
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var TaskRepositoryInterface
     */
    protected $taskRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @param Session $customerSession
     * @param TaskRepositoryInterface $taskRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        Session $customerSession,
        TaskRepositoryInterface $taskRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->customerSession = $customerSession;
        $this->taskRepository = $taskRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @return array
     */
    public function getSectionData()
    {
        $data = [];

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('customer_id', $this->customerSession->getCustomer()->getId())
            ->create();

        $list = $this->taskRepository->getList($searchCriteria);

        foreach ($list->getItems() as $task) {
            $data[] = [
                'id' => $task->getId(),
                'text' => $task->getTask()
            ];
        }

        return ['items' => $data];
    }
}
