var app = angular.module('app', ['ngRoute', 'datePicker']);
app.config(function($routeProvider, $httpProvider, $locationProvider) {

    // Set http provider defaults.
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
    $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';

    // Routes.
    $routeProvider.when('/', {
        templateUrl: 'template/home.html',
        controller: 'homeController'
    });
    $routeProvider.when('/login', {
        templateUrl: 'template/login.html',
        controller: 'loginController'
    });
    $routeProvider.when('/manage-shifts', {
        templateUrl: 'template/manage-shifts.html',
        controller: 'manageShiftsController'
    });
    $routeProvider.when('/add-shift', {
        templateUrl: 'template/add-shift.html',
        controller: 'addShiftController'
    });
    $routeProvider.when('/edit-shift/:shiftId', {
        templateUrl: 'template/edit-shift.html',
        controller: 'editShiftController'
    });
    $routeProvider.when('/user/:userId', {
        templateUrl: 'template/user.html',
        controller: 'userController'
    });
    $routeProvider.when('/my-shifts', {
        templateUrl: 'template/my-shifts.html',
        controller: 'myShiftsController'
    });
});
