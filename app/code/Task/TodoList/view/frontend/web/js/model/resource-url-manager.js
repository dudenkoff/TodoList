/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
define([],
    function () {
        'use strict';

        return {
            /**
             * Return add task api url
             *
             * @returns {string}
             */
            getAddTaskUrl: function () {
                return 'rest/V1/todo/action/add';
            },

            /**
             * Return cancel task api url
             *
             * @returns {string}
             */
            getCancelTaskUrl: function (taskId) {
                return 'rest/V1/todo/action/cancel/' + taskId;
            }
        };
    }
);
