/*global angular */
(function (angular) {
    'use strict';
    angular.module('mainApp', ['countdownTimer'])
        .controller('bodyController', function ($scope) {
            $scope.dates = [
                'October 27, 2015'
            ];
            $scope.units = [
                'Seconds'
            ];
            
        });
        
}(angular));