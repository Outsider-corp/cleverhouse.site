
jQuery(document).ready(function(){

	jQuery(".menu_top .navbar-toggle").on("click", function(){
		if(jQuery(this).hasClass("active"))
		{
			jQuery(this).removeClass("active");
		}
		else
		{
			jQuery(this).addClass("active");
		}
		
	})


})