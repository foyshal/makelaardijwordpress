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

$(document).ready(function() {
	$('#overige-teksten-link').click(function() {
	  $('#overige-teksten').toggle('slow', function() {
	    // Animation complete.
	  });
	});
});




