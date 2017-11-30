//<![CDATA[
'use strict';

/**
 * jQuery
 */
jQuery(document).ready(function($)
{

	/* LOCK SCREEN */
    $('.lockscreen-box .lsb-access').on('click',function()
	{
		$(this).parent('.lockscreen-box').addClass('active').find('input').focus();
		return false;
	});

    $('.lockscreen-box .user_signin').on('click',function()
	{
		$('.sign-in').show();
		$(this).remove();
		$('.user').hide().find('img').attr('src', webroot + 'backend/assets/images/users/no-image.jpg');
		$('.user').show();
		return false;
	});
    /* END LOCK SCREEN */

});
//]]>
