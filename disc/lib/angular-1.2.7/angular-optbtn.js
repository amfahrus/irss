angular.module("angular-optbtn", []);
angular.module('angular-optbtn').directive("optButton", function() {
  return {
    restrict : "A",
    template : "<p class='rating' ng-class='{readonly: readonly}'>" +
			   "<span ng-repeat='star in stars' ng-class='{readonly: readonly}'>" + 
			   "&nbsp;<button ng-class='star' ng-click='toggle($index,0)' type='button' ng-if='$index==0' class='btn btn-danger btn-lg' title='Tidak Setuju' data-toggle='tooltip' data-position='top' tooltip>" +
               "    <span ng-if='$index<3' class='glyphicon glyphicon-remove'></span >" + //&#9733
               "    <span ng-if='$index>=3' class='glyphicon glyphicon-ok'></span >" + //&#9733
			   "<button ng-class='star' ng-click='toggle($index,0)' type='button' ng-if='$index==1' class='btn btn-danger' title='Tidak Setuju' data-toggle='tooltip' data-position='top' tooltip>" +
               "    <span ng-if='$index<3' class='glyphicon glyphicon-remove'></span >" + //&#9733
               "    <span ng-if='$index>=3' class='glyphicon glyphicon-ok'></span >" + //&#9733
			   "<button ng-class='star' ng-click='toggle($index,0)' type='button' ng-if='$index==2' class='btn btn-danger btn-sm' title='Tidak Setuju' data-toggle='tooltip' data-position='top' tooltip>" +
               "    <span ng-if='$index<3' class='glyphicon glyphicon-remove'></span >" + //&#9733
               "    <span ng-if='$index>=3' class='glyphicon glyphicon-ok'></span >" + //&#9733
			   "<button ng-class='star' ng-click='toggle($index,1)' type='button' ng-if='$index==3' class='btn btn-success btn-sm' title='Setuju' data-toggle='tooltip' data-position='top' tooltip>" +
               "    <span ng-if='$index<3' class='glyphicon glyphicon-remove'></span >" + //&#9733
               "    <span ng-if='$index>=3' class='glyphicon glyphicon-ok'></span >" + //&#9733
			   "<button ng-class='star' ng-click='toggle($index,2)' type='button' ng-if='$index==4' class='btn btn-success' title='Setuju' data-toggle='tooltip' data-position='top' tooltip>" +
               "    <span ng-if='$index<3' class='glyphicon glyphicon-remove'></span >" + //&#9733
               "    <span ng-if='$index>=3' class='glyphicon glyphicon-ok'></span >" + //&#9733
			   "<button ng-class='star' ng-click='toggle($index,3)' type='button' ng-if='$index==5' class='btn btn-success btn-lg' title='Setuju' data-toggle='tooltip' data-position='top' tooltip>" +
               "    <span ng-if='$index<3' class='glyphicon glyphicon-remove'></span >" + //&#9733
               "    <span ng-if='$index>=3' class='glyphicon glyphicon-ok'></span >" + //&#9733
               "</button>&nbsp;" +
			   "</span>" +
               "</p>",
    scope : {
      ratingValue : "=ngModel",
      max : "=?", //optional: default is 5
      onRatingSelected : "&?",
      readonly: "=?"
    },
    link : function(scope, elem, attrs) {
      if (scope.max == undefined) { scope.max = 6; }
      function updateStars() {
        scope.stars = [];
        for (var i = 0; i < scope.max; i++) {
			
			scope.stars.push({
				filled2 : i == scope.ratingValue - 1
			});
			
        }
      };
      scope.toggle = function(index, val) {
        if (scope.readonly == undefined || scope.readonly == false){
          scope.ratingValue = index + 1;
          scope.onRatingSelected({
            rating: val
          });
        }
      };
      scope.$watch("ratingValue", function(oldVal, newVal) {
        if (newVal) { updateStars(); }
      });
    }
  };
});