<?php
$config = array(
	'Webpay' => array(
		'PagoSimultaneo' => array(
			'endpoint'		=> 'https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl',
			'server_cert'	=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'pagoSimultaneo','desarrollo', 'tbk.pem')),
			'private_key'	=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'pagoSimultaneo','desarrollo', '597020000541.key')),
			'cert_file'		=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'pagoSimultaneo','desarrollo', '597020000541.crt'))

			// 'endpoint'		=> 'https://webpay3g.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl',
			// 'server_cert'	=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'pagoSimultaneo', 'serverTBK.crt')),
			// 'private_key'	=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'pagoSimultaneo', '597032470963.key')),
			// 'cert_file'		=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'pagoSimultaneo', '597032470963.crt'))
		),
		'Anulacion' => array(
			// 'endpoint'		=> 'https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSCommerceIntegrationService?wsdl',
			// 'server_cert'	=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'anulacion','desarrollo', 'tbk.pem')),
			// 'private_key'	=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'anulacion','desarrollo', '597020000541.key')),
			// 'cert_file'		=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'anulacion','desarrollo', '597020000541.crt'))

			'endpoint'		=> 'https://webpay3g.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl',
			'server_cert'	=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'anulacion', 'serverTBK.crt')),
			'private_key'	=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'anulacion', '597032470963.key')),
			'cert_file'		=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'anulacion', '597032470963.crt'))
		)
	)
);
