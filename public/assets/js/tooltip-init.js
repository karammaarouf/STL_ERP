
"use strict";
// Remove the jQuery-based initialization that conflicts with Bootstrap 5
// $(document).ready(function() {
// 	var tooltip_init = {
// 		init: function() {
// 			$("button").tooltip();
// 			$("a").tooltip();
// 			$("input").tooltip();
// 		}
// 	};
//     tooltip_init.init()
// });

// Keep only the Bootstrap 5 native initialization
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})