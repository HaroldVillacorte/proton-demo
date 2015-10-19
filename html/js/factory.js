app.factory('appFactory', function($http) {
    var factory = {
        login: function(email, password, callback) {
            $http({
                method: 'POST',
                url: '/login',
                data: jQuery.param({email: email, password: password})
            })
                .success(function(data) {
                    callback(data);
                })
                .error(function(data) {
                    throw data;
                });
        },
        getAllShifts: function(callback) {
            $http({
                method: 'GET',
                url: '/shifts'
            })
                .success(function(data) {
                    callback(data);
                })
                .error(function(data) {
                    throw data;
                });
        },
        getShiftsByDateRange: function(start, end, callback) {
            $http({
                method: 'GET',
                url: '/shifts-by-date-range/' + start + '/' + end
            })
                .success(function(data) {
                    callback(data);
                })
                .error(function(data) {
                    throw data;
                });
        },
        getAllEmployees: function(callback) {
            $http({
                method: 'GET',
                url: '/employees'
            })
                .success(function(data) {
                    callback(data);
                })
                .error(function(data) {
                    throw data;
                });
        },
        saveShift: function(shift, callback) {
            $http({
                method:  shift.id ? 'PUT' : 'POST',
                url: '/shift',
                data: jQuery.param(shift)
            })
                .success(function(data) {
                    callback(data);
                })
                .error(function(data) {
                    throw data;
                });
        },
        getShift: function(shiftId, callback) {
            $http({
                method: 'GET',
                url: '/shift/' + shiftId
            })
                .success(function(data) {
                    callback(data);
                })
                .error(function(data) {
                    throw data;
                });
        },
        getUser: function(userId, callback) {
            $http({
                method: 'GET',
                url: '/user/' + userId
            })
                .success(function(data) {
                    callback(data);
                })
                .error(function(data) {
                    throw data;
                });
        },
        getMyShifts: function(callback) {
            $http({
                method: 'GET',
                url: '/my-shifts'
            })
                .success(function(data) {
                    callback(data);
                })
                .error(function(data) {
                    throw data;
                });
        },
        getWeeklySummary: function(callback) {
            $http({
                method: 'GET',
                url: '/weekly-summary'
            })
                .success(function(data) {
                    callback(data);
                })
                .error(function(data) {
                    throw data;
                });
        }
    };
    return factory;
});