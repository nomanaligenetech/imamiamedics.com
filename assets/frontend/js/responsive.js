$(window).resize(function() {
	
	var windowH	= $(this).height();
	var windowW	= $(this).width();
	
	is_Responsive					= false;
	if ( windowW <= range  )
	{
		is_Responsive				= true;
	}
	
	mobile_version( windowW, windowH, is_Responsive );
	
});


function mobile_version( windowW, range, is_Responsive )
{
	readMoreEllipseWithEllipse();
	
	if ( windowW > range )
	{
		$('.header_nav li').each(function(){
										  
			if($(this).children('ul').length > 0)
			{
				$(this).children('ul').css('display' , 'none')
				$(this).children('.chidlBtn').children('span').removeClass('minus')
			}
			
		});
	}
	
	
	
	//if responsive - also using smartdevice and  width >= range means in ipad
	if ( is_Responsive || (is_SmartDevice && windowW >= range) )
	{
		$( ".innermenutab > ul.formobile" ).show();
		$( ".innermenutab > ul.fordesktop" ).hide();
		
		
		$(".accordin-section .conf-prog-tab .starttab .package").addClass( 'width-99-percent' );
		
	}
	else
	{
		
		$( ".innermenutab > ul.formobile" ).hide();
		$( ".innermenutab > ul.fordesktop" ).show();
		
		$(".accordin-section .conf-prog-tab .starttab .package").removeClass( 'width-99-percent' );
		
		
	}
	
	
}