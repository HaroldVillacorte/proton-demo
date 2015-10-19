// HOME CONTROLLER.
app.controller('homeController', function() {});

// LOGIN CONTROLLER.
app.controller('loginController', function($scope, appFactory, $location) {
    $scope.email = undefined;
    $scope.password = undefined;
    $scope.submit = function(event) {
        event.preventDefault();
        appFactory.login($scope.email, $scope.password, function(data) {
            if (data.success) {
                $location.path('/');
            } else {
                alert(data.message);
            }
        });
    };
});

// MANAGE SHIFTS CONTROLLER.
app.controller('manageShiftsController', function($scope, appFactory) {
    $scope.shifts = [];
    $scope.showFilter = false;
    $scope.filterStart = undefined;
    $scope.filterEnd = undefined;
    $scope.toggleFilter = function() {
        $scope.showFilter = !$scope.showFilter;
    };
    $scope.submitFilter = function() {
        appFactory.getShiftsByDateRange(
            new Date($scope.filterStart).toUTCString(), new Date($scope.filterEnd).toUTCString(),
            function(data) {
            $scope.shifts = data.data;
        });
    };
    appFactory.getAllShifts(function(data) {
        $scope.shifts = data.data;
    });
});

// ADD SHIFT CONTROLLER.
app.controller('addShiftController', function($scope, appFactory, $location) {
    $scope.employees = [];
    $scope.shift = {
        employee_id: undefined,
        start_time: undefined,
        end_time: undefined,
        break: 1.0
    };
    $scope.breakOptions = [
        {duration: 0.5, label: 'Half hour'},
        {duration: 1.0, label: 'Hour'}
    ];
    appFactory.getAllEmployees(function(data) {
        $scope.employees = data.data;
    });
    $scope.submit = function(event) {
        event.preventDefault();
        $scope.shift.start_time = new Date($scope.shift.start_time).toUTCString();
        $scope.shift.end_time = new Date($scope.shift.end_time).toUTCString();
        appFactory.saveShift($scope.shift, function(data) {
            if (data.success) {
                $location.path('/manage-shifts');
            } else {
                alert(data.message);
            }
        });
    };
});

// EDIT SHIFT CONTROLLER.
app.controller('editShiftController', function($scope, $routeParams, appFactory, $location) {
    $scope.shiftId = $routeParams.shiftId;
    $scope.shift = {};
    $scope.employees = [];
    $scope.breakOptions = [
        {duration: 0.5, label: 'Half hour'},
        {duration: 1.0, label: 'Hour'}
    ];
    appFactory.getShift($scope.shiftId, function(data) {
        data.data.start_time = new Date(data.data.start_time * 1000);
        data.data.end_time = new Date(data.data.end_time * 1000);
        $scope.shift = data.data;
    });
    appFactory.getAllEmployees(function(data) {
        $scope.employees = data.data;
    });
    $scope.submit = function(event) {
        event.preventDefault();
        $scope.shift.start_time = new Date($scope.shift.start_time).toUTCString();
        $scope.shift.end_time = new Date($scope.shift.end_time).toUTCString();
        appFactory.saveShift($scope.shift, function(data) {
            if (data.success) {
                $location.path('/manage-shifts');
            } else {
                alert(data.message);
            }
        });
    };
});

// USER CONTROLLER.
app.controller('userController', function($scope, $routeParams, appFactory) {
    $scope.userId = $routeParams.userId;
    $scope.user = {};
    appFactory.getUser($scope.userId, function(data) {
        $scope.user = data.data;
    });
});

// MY SHIFTS CONTROLLER.
app.controller('myShiftsController', function($scope, appFactory) {
    $scope.shifts = [];
    $scope.teamShifts = [];
    $scope.weeklySummary = [];
    appFactory.getMyShifts(function(data) {
        $scope.shifts = data.data;
    });
    appFactory.getWeeklySummary(function(data) {
        for (var i = 0; i < data.data.length; i++) {
            data.data[i].hours = parseInt(data.data[i].hours);
        }
        $scope.weeklySummary = data.data;
    });
    $scope.showTeam = function(event, shift) {
        event.preventDefault();
        var start_time = new Date(shift.start_time * 1000).toUTCString();
        var end_time = new Date(shift.end_time * 1000).toUTCString();
        appFactory.getShiftsByDateRange(start_time, end_time, function(data) {
            for (var i = 0; i < data.data.length; i++) {
                for (var x = 0; x < $scope.shifts.length; x++) {
                    if (data.data[i].employee_id === $scope.shifts[x].employee_id) {
                        data.data.splice(i, 1);
                    }
                }
            }
            $scope.teamShifts = data.data;
        });
        jQuery('#team-modal').foundation('reveal', 'open');
    };
});