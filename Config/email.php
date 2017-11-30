<?php

class EmailConfig
{
	public $gmail	= array(
		'host'				=> 'ssl://smtp.gmail.com',
		'port'				=> 465,
		'username'			=> 'apps@brandon.cl',
		'password'			=> 'brandoor2',
		'transport'			=> 'Smtp'
	);

	public $fidelizador	= array(
		'host'				=> 'relay.fidelizador.com',
		'port'				=> 25,
		'username'			=> 'booksand.60e111+cl1.fidelizador.com',
		'password'			=> '9ddec111052d201e1b1c752f083c97d0',
		'transport'			=> 'Smtp'
	);
}
