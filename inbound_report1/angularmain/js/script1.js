var app=angular.module('myApp',['ngRoute']);
app.controller('appdataenter', function() {
});
app.config(function($routeProvider) {
		$routeProvider
			.when('/display', {
				templateUrl : 'pages/display.html',
				controller  : 'tabledata'
			})
			.when('/adddid', {
				templateUrl : 'pages/adddata.html',
				controller  : 'adddata'
			})
			.when('/update/:sno/:name/:course', {
				templateUrl : 'pages/update.html',
				controller  : 'update'
			})
	});

app.controller('tabledata', function($scope,$http,$route) {
	 var responseData;
    $http.get('pages/select.php').then(function (response) {
        responseData = response.data.records;
    $scope.names = responseData;
	});
			
	$scope.deletedata = function(sno) {
		$scope.sno=sno;
			$http.post("pages/delete.php",{'sno':$scope.sno})
			.success(function(response){
			$route.reload();
			});	
		}
	
});
app.controller('adddata', function($scope,$http,$route){
	
	$scope.insertdata = function() {
		$http.post("pages/insert.php",{'sno':$scope.sno,'name':$scope.name,'course':$scope.course})
		.success(function(response){
			$route.reload();
		});	
	}
	
});
 app.controller('update', function($scope,$http,$routeParams,$location,$route){
	 $scope.sno = $routeParams.sno;
	 $scope.name = $routeParams.name;
	 $scope.course = $routeParams.course;
	 $scope.updatedata = function() {
	 $http.post("pages/update.php",{'sno':$scope.sno,'name':$scope.name,'course':$scope.course})
		.success(function(response){		
			$location.path('/display');
		});
	 }
	
});