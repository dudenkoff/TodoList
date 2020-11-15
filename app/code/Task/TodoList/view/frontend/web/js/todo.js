/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
define([
    'jquery',
    'ko',
    'uiComponent',
    'Task_TodoList/js/action/add-task',
    'Task_TodoList/js/action/cancel-task',
    'Magento_Customer/js/customer-data'
], function ($, ko, Component, addTaskAction, cancelTaskAction, customer) {
    'use strict';

    let task = ko.observable(null);
    let addedTasks = ko.observableArray([]);

    customer.reload('todo-list').done(function () {
        customer.get('todo-list')().items.forEach(function (item) {
            addedTasks.push(item);
        })
    });

    return Component.extend({
        /**
         * Current task
         */
        task: task,

        /**
         * Already added tasks
         */
        addedTasks: addedTasks,

        /**
         * Add task functionality
         */
        addTask: function () {
            if (this.validate()) {
                addTaskAction(task()).done(function (response) {
                    addedTasks.push($.parseJSON(response));
                    task('');
                });
            }
        },

        /**
         * Remove task functionality
         */
        removeTask: function () {
            let that = this;
            cancelTaskAction(this.id).done(function () {
                addedTasks.remove(that);
                task('');
            });
        },

        /**
         * Task form validation
         *
         * @returns {Boolean}
         */
        validate: function () {
            let form = '#todo-form';
            return $(form).validation() && $(form).validation('isValid');
        }
    });
});
