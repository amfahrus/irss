/**
 * api disc
 * dynamic controller
 */

define([

], function(){
    function Ctrldisc($scope,$window,$sce,serviceAjax){
		//set combobox
        $scope.param = {};
        $scope.question = {};
        $scope.result = {};
		$scope.page =0;
		$scope.halaman ='satu';
		$scope.loading = false;
		$scope.error = false;
		$scope.errormsg = '';
		$scope.progress = 0;
		$scope.rate = -1;
		$scope.saveresult = false;
		
		serviceAjax.getDataFromServer('api_disc','getSession')
			.then(function(data){
				if (data) {
					$scope.param.user_id = data['user_id'];
					$scope.param.name = data['name'];
					$scope.param.email = data['email'];
					//$scope.$apply();
					//console.log();
				} 
		}, function(err) {
			$scope.loading = false;
			$scope.error = true;
			$scope.errormsg = err;
		});
		
        $scope.taketest = function() { 
			$scope.question = {};
			$scope.result = {};
			$scope.halaman ='dua';
			$scope.loading = true;
			serviceAjax.posDataToServer('api_disc','takedisc',$scope.param).then(function(data){
				if (data) {
					$scope.loading = false;
					$scope.question = data;
					$scope.progress =  Math.round((4 / data['total'].toFixed()) * 100);
					//$scope.$apply();
				}
			}, function(err) {
				$scope.loading = false;
				$scope.error = true;
				$scope.errormsg = err;
			});	
        };
		
		$scope.next = function() {
			$scope.halaman ='dua';
			$scope.loading = true;    
			$scope.page = $scope.page + 4;
			serviceAjax.getDataFromServer('api_disc','get_user_disc_data',$scope.page)
				.then(function(data){
					if (data) {
						$scope.loading = false;
						$scope.question = data;
						$scope.progress = Math.round(((4 + $scope.page) / data['total'].toFixed()) * 100);
						//$scope.$apply();
						//console.log();
					} 
			}, function(err) {
				$scope.loading = false;
				$scope.error = true;
				$scope.errormsg = err;
			});
        };
		
		$scope.rateFunction = function(option,marks) {
				//alert(option + ' : ' + marks);
				//console.log($scope.param);
			if($scope.param){
				$scope.param.option = option;
				$scope.param.marks = marks;
				serviceAjax.posDataToServer('api_disc','save_answer_disc',$scope.param).then(function(data){
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
			serviceAjax.getDataFromServer('api_disc','finish_user_disc')
				.then(function(resp){
					if (resp) {
						$scope.loading = false;
						$scope.result = resp;
						//console.log(resp);
						$scope.data = {
						  labels: ['Dominan', 'Intim', 'Stabil', 'Cermat'],
						  datasets: [
							{
							  label: 'DISC',
							  fillColor: 'rgba(151,187,205,0.2)',
							  strokeColor: 'rgba(151,187,205,1)',
							  pointColor: 'rgba(151,187,205,1)',
							  pointStrokeColor: '#fff',
							  pointHighlightFill: '#fff',
							  pointHighlightStroke: 'rgba(151,187,205,1)',
							  data: [parseFloat(resp['guest_results'][0]['avg_D']), parseFloat(resp['guest_results'][0]['avg_I']), parseFloat(resp['guest_results'][0]['avg_S']), parseFloat(resp['guest_results'][0]['avg_C'])]
							  //data: [3, 5, 7, 1]
							}
						  ]
						};
						
						$scope.options =  {

						  // Sets the chart to be responsive
						  responsive: true,

						  //Boolean - Whether to show lines for each scale point
						  scaleShowLine : true,

						  //Boolean - Whether we show the angle lines out of the radar
						  angleShowLineOut : true,

						  //Boolean - Whether to show labels on the scale
						  scaleShowLabels : false,

						  // Boolean - Whether the scale should begin at zero
						  scaleBeginAtZero : true,

						  //String - Colour of the angle line
						  angleLineColor : 'rgba(0,0,0,.1)',

						  //Number - Pixel width of the angle line
						  angleLineWidth : 1,

						  //String - Point label font declaration
						  pointLabelFontFamily : '"Arial"',

						  //String - Point label font weight
						  pointLabelFontStyle : 'normal',

						  //Number - Point label font size in pixels
						  pointLabelFontSize : 10,

						  //String - Point label font colour
						  pointLabelFontColor : '#666',

						  //Boolean - Whether to show a dot for each point
						  pointDot : true,

						  //Number - Radius of each point dot in pixels
						  pointDotRadius : 3,

						  //Number - Pixel width of point dot stroke
						  pointDotStrokeWidth : 1,

						  //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
						  pointHitDetectionRadius : 20,

						  //Boolean - Whether to show a stroke for datasets
						  datasetStroke : true,

						  //Number - Pixel width of dataset stroke
						  datasetStrokeWidth : 2,

						  //Boolean - Whether to fill the dataset with a colour
						  datasetFill : true,

						  //String - A legend template
						  legendTemplate : '<ul class="tc-chart-js-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].strokeColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>'
						};
						
						$scope.datapie = [
						  {
							value: parseFloat(resp['guest_results'][0]['avg_D']),
							color:'#F7464A',
							highlight: '#FF5A5E',
							label: 'Dominan'
						  },
						  {
							value: parseFloat(resp['guest_results'][0]['avg_I']),
							color: '#FDB45C',
							highlight: '#FFC870',
							label: 'Intim'
						  },
						  {
							value: parseFloat(resp['guest_results'][0]['avg_S']),
							color: '#46BFBD',
							highlight: '#5AD3D1',
							label: 'Stabil'
						  },
						  {
							value: parseFloat(resp['guest_results'][0]['avg_C']),
							color: '#5B81FD',
							highlight: '#7F9DFF',
							label: 'Cermat'
						  }
						];

						// Chart.js Options
						$scope.optionspie =  {
tooltipTemplate: "<%= value %>",
        
        onAnimationComplete: function()
        {
            this.showTooltip(this.segments, true);
        },
        
        tooltipEvents: [],
        
        showTooltips: true,
						  // Sets the chart to be responsive
						  responsive: true,

						  //Boolean - Whether we should show a stroke on each segment
						  segmentShowStroke : true,

						  //String - The colour of each segment stroke
						  segmentStrokeColor : '#fff',

						  //Number - The width of each segment stroke
						  segmentStrokeWidth : 2,

						  //Number - The percentage of the chart that we cut out of the middle
						  percentageInnerCutout : 0, // This is 0 for Pie charts

						  //Number - Amount of animation steps
						  animationSteps : 100,

						  //String - Animation easing effect
						  animationEasing : 'easeOutBounce',

						  //Boolean - Whether we animate the rotation of the Doughnut
						  animateRotate : true,

						  //Boolean - Whether we animate scaling the Doughnut from the centre
						  animateScale : false,

						  //String - A legend template
						  legendTemplate : '<ul class="tc-chart-js-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'

						};
						
						//$scope.$apply();
						//console.log();
					}
			}, function(err) {
				$scope.loading = false;
				$scope.error = true;
				$scope.errormsg = err;
			});
			
        };
		
		$scope.email = function() { 
			serviceAjax.posDataToServer('api_disc','send_email',$scope.param).then(function(data){
				if (data) {
					//alert(data);
if(data=='success'){
		$scope.saveresult= true;
}
					//$scope.$apply();
				}
			});	
        };
		
		$scope.deliberatelyTrustDangerousSnippet = function(html_code) {
            var decoded = angular.element('<textarea />').html(html_code).text();
            return $sce.trustAsHtml(decoded);
		};
		
		$scope.reloadRoute = function() {
		   $window.location.reload();
		}
		
    }

    // set to global
    window.Ctrldisc = Ctrldisc;

    return Ctrldisc;
});
