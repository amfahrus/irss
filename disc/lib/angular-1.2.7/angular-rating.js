angular.module("angular-rating", []);
angular.module('angular-rating').directive("starRating", function() {
  return {
    restrict : "A",
    template : "<p class='rating' ng-class='{readonly: readonly}'>" +
			   "<button ng-repeat='star in stars' ng-class='star' ng-click='toggle($index)' type='button' class='btn btn-default btn-lg'>" +
               "    <span class='glyphicon glyphicon-ok'></span >" + //&#9733
               "</button>" +
               "</p>",
    scope : {
      ratingValue : "=ngModel",
      max : "=?", //optional: default is 5
      onRatingSelected : "&?",
      readonly: "=?"
    },
    link : function(scope, elem, attrs) {
      if (scope.max == undefined) { scope.max = 5; }
      function updateStars() {
        scope.stars = [];
        for (var i = 0; i < scope.max; i++) {
			
            if (scope.ratingValue <= 3){
				scope.stars.push({
					filled1 : i < scope.ratingValue
				});
			}
			
			if (scope.ratingValue == 4){
				scope.stars.push({
					filled2 : i < scope.ratingValue
				});
			}
			
			if (scope.ratingValue > 4){
				scope.stars.push({
					filled3 : i < scope.ratingValue
				});
			}
        }
      };
      scope.toggle = function(index) {
        if (scope.readonly == undefined || scope.readonly == false){
          scope.ratingValue = index + 1;
          scope.onRatingSelected({
            rating: index + 1
          });
        }
      };
      scope.$watch("ratingValue", function(oldVal, newVal) {
        if (newVal) { updateStars(); }
      });
    }
  };
});