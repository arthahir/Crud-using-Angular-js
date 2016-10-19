var app=angular.module('myApp',['ngRoute','ngCookies','jkuri.datepicker']);

app.controller('appdataenter', function($scope,$http) {

$scope.connectmylocation = function(id) {
		
		alert("checking connectivity");
		
	
			alert(id);
			$http.post("pages/pandbconnect.php",{'connectid':id}).success(function(response){
			alert('Connected');		
		});
	   
	}
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
			.when('/update/:sno/:name/:course/:id', {
				templateUrl : 'pages/update.html',
				controller  : 'update'
			})
			.when('/liveuser', {
				templateUrl : 'pages/liveuser.html',
				controller  : 'liveuser'
			})
			.when('/loggeduser', {
				templateUrl : 'pages/loggeduserdisplay.html',
				controller  : 'loggeduser'
			}).when('/userdetail', {
				templateUrl : 'pages/userdetail.html',
				controller  : 'userdetail'
			})
	});


	
app.controller('tabledata', function($scope,$http,$route,$timeout,$cookies,$window) {
	 var responseData;
	$scope.myclass = [];
	var favoriteCookie = $cookies['username'];
	if(typeof favoriteCookie !== 'undefined')
	{
    $http.get('pages/select.php').then(function (response) {
        responseData = response.data.records;
    $scope.names = responseData;
	});
    
    $scope.checkClick = function(idnx,boolen){
		$scope.boo = boolen;
		$scope.idn = idnx;
       if($scope.boo == true)
	   {
			$http.post("pages/update.php",{'id':$scope.idn,'check':'1'})
		.success(function(response){	
		});
	   }
	   else
	   {
			$http.post("pages/update.php",{'id':$scope.idn,'check':'0'})
		.success(function(response){		
			});
	   }
}

	$scope.deletedata = function(id) {
		$scope.id=id;
		$scope.myclass.push('show');
	}
	$scope.accept = function(){
		$http.post("pages/delete.php",{'sno':$scope.id})
		.success(function(response){
		$scope.myclass.pop('show');
		$timeout(function () {
			$route.reload();
		}, 510);
		});
	}
	$scope.close = function(){
		$scope.myclass.pop('show');
	}
	}
	else
	{
		var host = $window.location.host;
		$window.location.href = 'http://'+ host +'/inbound_report1/index.php';
	}
		
		
	
});
app.controller('adddata', function($scope,$http,$route,$cookies,$window){
	
	var favoriteCookie = $cookies['username'];
	if(typeof favoriteCookie !== 'undefined')
	{
		
   $scope.data = [
   { name: 'Fresh', id: '1' },
   { name: 'RRT', id: '2' },
   { name: 'CBSQueue', id: '6' },
   { name: 'Assisted', id: '40' },
   { name: 'Elite', id: '51' }];
	$scope.insertdata = function() {
	if ($scope.course==undefined || $scope.course=='' || $scope.sno=='')
	{
	$scope.alertmsg = 'Please Enter Values and click add';
	$scope.alert = {
		"color" : "red",
		"font-weight" : "bold",
		"text-align" : "center",
		"display" : "block"
	}
	return false;
	}
	if($scope.course.length <= 11 && $scope.course.length >= 8)
	{
		$http.post("pages/insert.php",{'sno':$scope.sno.id,'name':$scope.name,'course':$scope.course})
		.success(function(response){
			$scope.condition = response;
			if($scope.condition == "Successfully inserted")
			{
				$scope.successn = {
					"color" : "green",
					"font-weight" : "bold",
					"text-align" : "center",
					"display" : "block"
				}
				$scope.alert = {
					"display" : "none"
				}
			}
			else
			{
				$scope.successn = {
					"color" : "red",
					"font-weight" : "bold",
					"text-align" : "center",
					"display" : "block"
				}
				$scope.alert = {
					"display" : "none"
				}
			}
			$scope.sno = null;
			$scope.name = null;
			$scope.course = null;
		});
	}
	else
		{
			$scope.alertmsg = "Min Length is 8 and Max Length is 11 Digit";
			$scope.alert = {
				"color" : "red",
				"font-weight" : "bold",
				"text-align" : "center",
				"display" : "block"
			}
		}	
	}
	$scope.indata = function() {
		$scope.name = $scope.sno.name;
		$scope.successn = {
			"display" : "none"
		}
		$scope.alert = {
			"display" : "none"
		}
	}
	$scope.hiden = function() {
		$scope.alert = {
			"display" : "none"
		}
	}
	$scope.validate = function(evt){
		validatenew(evt);
	}
	}
	else
	{
		var host = $window.location.host;
		$window.location.href = 'http://'+ host +'/inbound_report1/index.php';
	}
});
 app.controller('update', function($scope,$http,$routeParams,$location,$route,$cookies,$window){
	var favoriteCookie = $cookies['username'];
	if(typeof favoriteCookie !== 'undefined')
	{
		
	 $scope.sno = $routeParams.sno;
	 $scope.name = $routeParams.name;
	 $scope.course = $routeParams.course;
	 $scope.id = $routeParams.id;
	 $scope.updatedata = function() {
		if($scope.course.length <= 11 && $scope.course.length >= 8)
		{
			$http.post("pages/update.php",{'sno':$scope.sno,'name':$scope.name,'course':$scope.course,'id':$scope.id})
			.success(function(response){		
				$location.path('/display');
			});
		}			
		else
		{
			$scope.alertmsg = "Min Length is 8 and Max Length is 11 Digit";
			$scope.alert = {
				"color" : "red",
				"font-weight" : "bold",
				"text-align" : "center",
				"display" : "block"
			}
		}
	 }
	
	$scope.hiden = function() {
		$scope.alert = {
			"display" : "none"
		}
	}
	}
	else
	{
		var host = $window.location.host;
		$window.location.href = 'http://'+ host +'/inbound_report1/index.php';
	}
});

app.controller('liveuser', function($scope,$http,$route,$timeout,$interval,$cookies,$window) {
	var favoriteCookie = $cookies['username'];
	if(typeof favoriteCookie !== 'undefined')
	{
	 var responseData;
	 $scope.secondsn = 10;
    $http.get('pages/selectlive.php').then(function (response) {
        responseData = response.data.records;
		$scope.names = responseData;
	});
	
	$interval(function(){
		$scope.secondsn = $scope.secondsn - 1;
		 },1000);
		 
	$timeout(function(){
		$route.reload();
	 },11000);
	 
	$scope.mystyle = {
		"color" : "green",
		"font-weight" : "bold"
	}
	$scope.mystylen = {
		"color" : "red",
		"font-weight" : "bold",
		"animation" : "blinker 1s linear infinite"
	}
	}
	else
	{
		var host = $window.location.host;
		$window.location.href = 'http://'+ host +'/inbound_report1/index.php';
	}
	});
	
	app.controller('tabledata', function($scope,$http,$route,$timeout,$cookies,$window) {
	 var responseData;
	$scope.myclass = [];
	var favoriteCookie = $cookies['username'];
	if(typeof favoriteCookie !== 'undefined')
	{
    $http.get('pages/select.php').then(function (response) {
        responseData = response.data.records;
    $scope.names = responseData;
	});
    
    $scope.checkClick = function(idnx,boolen){
		$scope.boo = boolen;
		$scope.idn = idnx;
       if($scope.boo == true)
	   {
			$http.post("pages/update.php",{'id':$scope.idn,'check':'1'})
		.success(function(response){	
		});
	   }
	   else
	   {
			$http.post("pages/update.php",{'id':$scope.idn,'check':'0'})
		.success(function(response){		
			});
	   }
}

	$scope.deletedata = function(id) {
		$scope.id=id;
		$scope.myclass.push('show');
	}
	$scope.accept = function(){
		$http.post("pages/delete.php",{'sno':$scope.id})
		.success(function(response){
		$scope.myclass.pop('show');
		$timeout(function () {
			$route.reload();
		}, 510);
		});
	}
	$scope.close = function(){
		$scope.myclass.pop('show');
	}
	}
	else
	{
		var host = $window.location.host;
		$window.location.href = 'http://'+ host +'/inbound_report1/index.php';
	}
		
		
	
});
app.controller('loggeduser', function($scope,$http,$route,$timeout,$interval,$cookies,$window,$routeParams) {
	$scope.mystatus = "false";
	var favoriteCookie = $cookies['username'];
	if(typeof favoriteCookie !== 'undefined')
	{	
	$scope.data = [
   { name: 'fresh', id: '1' },
   { name: 'rrt', id: '2' },
   { name: 'assisted', id: '3' }];
	$scope.change=function(){
	$ext=$scope.team.name;	
	$scope.mystatus = "true";
	}
		$http.get('pages/loggeduser.php').then(function (response) {
        responseData = response.data.records1;
		$scope.names = responseData;
	});
	$scope.logout = {
		"color" : "#D92432",
		"font-size" : "20px"
	}
	$scope.team = $routeParams.team;
	$scope.fromdate = $routeParams.fromdate;
	
	
	$scope.submitdata = function(){
	
	if($scope.fromdate=='undefined')
	{
	alert("choose date");
	return false;
	}
	
		$http.post("pages/loggeduser.php",{'team':$scope.team.name,'fromdate':$scope.fromdate})
			.then(function(response){		
			
				 responseData = response.data.records1;
				$scope.names = responseData;
			});
	}
	
	$scope.exportData = function () {
        var blob = new Blob([document.getElementById('exportable').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "Report.xls");
    };
	
	}
	else
	{
		var host = $window.location.host;
		$window.location.href = 'http://'+ host +'/inbound_report1/index.php';
	}
	});
	
	
function validatenew(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /^[0-9]*(?:\.\d{1,2})?$/;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}





app.controller('userdetail', function($scope,$http,$route,$timeout,$interval,$cookies,$window,$routeParams) {
	$scope.mystatus = "false";
	var favoriteCookie = $cookies['username'];
	if(typeof favoriteCookie !== 'undefined')
	{	
	$scope.data = [
   { name: 'fresh', id: '1' },
   { name: 'rrt', id: '2' },
   { name: 'assisted', id: '3' }];
	$scope.change=function(){
	$ext=$scope.team.name;	
	$scope.mystatus = "true";
	}
		 $http.get('pages/userdetails.php').then(function (response) {
        responseData = response.data.records1;
		$scope.names = responseData;
	}); 
	$scope.logout = {
		"color" : "#D92432",
		"font-size" : "20px"
	}
	$scope.team = $routeParams.team;
	$scope.fromdate = $routeParams.fromdate;
	
	
	$scope.submitdata = function(){
	
	if($scope.fromdate=='undefined')
	{
	alert("choose date");
	return false;
	}
	
		$http.post("pages/userdetails.php",{'team':$scope.team.name,'fromdate':$scope.fromdate})
			.then(function(response){		
			
				 responseData = response.data.records1;
				$scope.names = responseData;
			});
	}
	

	
	}
	else
	{
		var host = $window.location.host;
		$window.location.href = 'http://'+ host +'/inbound_report1/index.php';
	}
	});