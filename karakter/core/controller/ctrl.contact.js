/**
 * contact
 * dynamic controller
 */

define([

], function(){
    function Ctrlcontact($scope,serviceAjax){
        //set combobox
        $scope.param = {};
		$scope.berhasil = false;
        $scope.email = function() { 
			serviceAjax.posDataToServer('api_disc','feedback',$scope.param).then(function(data){
				if (data) {
					//alert(data);
					if(data=='success'){
							$scope.berhasil= true;
					}
					//$scope.$apply();
				}
			});	
        };
    }

    // set to global
    window.Ctrlcontact = Ctrlcontact;

    return Ctrlcontact;
});
