/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
define([
    'ko',
    'jquery',
    'Task_TodoList/js/model/resource-url-manager',
    'mage/storage'
], function (ko, $, urlManager, storage) {
    'use strict';

    return function (taskId) {
        let url = urlManager.getCancelTaskUrl(taskId);

        return storage.delete(
            url
        );
    };
});
