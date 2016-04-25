/**
 * api mbti
 * dynamic controller
 */

define([

], function(){
    function Ctrlmbti($scope,$sce,$timeout,serviceAjax){
		//set combobox
        $scope.param = {};
        $scope.question = {};
        $scope.result = {};
		$scope.page =0;
		$scope.halaman ='satu';
		$scope.loading = false;
			
        $scope.taketest = function() { 
			$scope.param = {};
			$scope.question = {};
			$scope.result = {};
			$scope.page =0;
			$scope.halaman ='dua';
			$scope.loading = true;
			serviceAjax.getDataFromServer('api_mbti','takembti').then(function(data){
				if (data) {
					$scope.loading = false;
					$scope.question = data;
					//$scope.$apply();
				}
			});	
        };
		
		$scope.next = function() {
			$scope.halaman ='dua';
			$scope.loading = true;     
			$scope.page = $scope.page + 5;
			serviceAjax.getDataFromServer('api_mbti','get_user_mbti_data',$scope.page)
				.then(function(data){
					if (data) {
						$scope.loading = false;
						$scope.question = data;
						//$scope.$apply();
						//console.log();
					}
			});
        };
		
		$scope.toggle = function(qid) {
				//alert(qid + ' : ' + $scope.param[qid]);
				//console.log($scope.param);
			if($scope.param){
				$scope.param.question = qid;
				$scope.param.answer = $scope.param[qid];
				serviceAjax.posDataToServer('api_mbti','save_answer_mbti',$scope.param).then(function(data){
					if (data) {
						$scope.loading = false;
						//$scope.$apply();
					}
				});	
			}
		};

		$scope.finish = function() {
			$scope.halaman ='tiga';
			$scope.loading = true;     
			serviceAjax.getDataFromServer('api_mbti','finish_user_mbti')
				.then(function(data){
					if (data) {
						$scope.loading = false;
						$scope.result = data;
						//$scope.$apply();
						//console.log();
					}
			});
        };
        
		$scope.deliberatelyTrustDangerousSnippet = function(html_code) {
            var decoded = angular.element('<textarea />').html(html_code).text();
            return $sce.trustAsHtml(decoded);
		};
		
    }

    // set to global
    window.Ctrlmbti = Ctrlmbti;

    return Ctrlmbti;
});
