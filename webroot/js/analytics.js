/*jshint bitwise:true, browser:true, eqeqeq:true, es5:true, forin:true, globalstrict:true, indent:4, jquery:true, loopfunc:true, maxerr:3, noarg:true, node:true, noempty:true, onevar: true, quotmark:single, strict:true, undef:true, white:false */
/*global uid*/
/*!
 * Analytics
 */

//<![CDATA[
var analytics 		= {

	/**
	 * Setup inicial del js Analytics
	 */
	setup			: function()
	{
		(function(iwindow, sdocument, oscript, gjs, rga, element, mparent)
		{
			iwindow['GoogleAnalyticsObject'] = rga;
			iwindow[rga]		= iwindow[rga] || function()
			{
				(iwindow[rga].q = iwindow[rga].q || []).push(arguments);
			},
			iwindow[rga].l		= 1 * new Date();
			element				= sdocument.createElement(oscript),
			mparent				= sdocument.getElementsByTagName(oscript)[0];
			element.async		= 1;
			element.src			= gjs;
			mparent.parentNode.insertBefore(element, mparent);
		})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-28007160-1', 'auto');
		analytics.plugins();
		analytics.uid();
	},

	/**
	 * Activa los plugins necesarios
	 */
	plugins			: function()
	{
		ga('require', 'ec');
	},

	/**
	 * Si existe un usuario logeado, informa el ID a Analytics
	 */
	uid			: function()
	{
		if ( typeof(uid) !== 'undefined' )
		{
			ga('set', '&uid', uid);
		}
	},

	/**
	 * Envia el pageview (se recomienda ejecutar en el footer)
	 */
	pageview		: function()
	{
		ga('send', 'pageview');
	}
}

analytics.setup();

//]]>
