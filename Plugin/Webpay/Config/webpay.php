<?php
$config = array(
	'Webpay' => array(
		'Oneclick' => array(
			'integracion' => array(
				'endpoint'		=> 'https://webpay3gint.transbank.cl/webpayserver/wswebpay/OneClickPaymentService?wsdl',
				'server_cert'	=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'oneclick', 'tbk.pem')),
				'private_key'	=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'oneclick', '597020000547.key')),
				'cert_file'		=> dirname(__FILE__) . DS . implode(DS, array('webpay', 'oneclick', '597020000547.crt'))
			),
			'produccion' => array(
				//
			)
		)
	)
);
