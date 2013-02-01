/* Author:
 Gouwestad Marketing & Media
*/

 /* Animation on doc ready
-------------------------------------------------------------- */
$(document).ready(function()
{
  $('.home header').addClass('animate');
});


$(document).ready(function() {
	$('#zoekform-link').click(function() {
	  $('#zoekformulier').toggle('slow', function() {
	    // Animation complete.
	  });
	});
});




