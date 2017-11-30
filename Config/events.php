<?php
App::uses('CakeEventManager', 'Event');
App::uses('UsuarioListener', 'Lib/Event');
App::uses('ContactoListener', 'Lib/Event');
App::uses('CompraListener', 'Lib/Event');
App::uses('CompraDespachoListener', 'Lib/Event');
App::uses('CompraEntregaDespachoListener', 'Lib/Event');
App::uses('CompraEmailEstadoListener', 'Lib/Event');

CakeEventManager::instance()->attach(new UsuarioListener());
CakeEventManager::instance()->attach(new ContactoListener());
CakeEventManager::instance()->attach(new CompraListener());
CakeEventManager::instance()->attach(new CompraDespachoListener());
CakeEventManager::instance()->attach(new CompraEntregaDespachoListener());
CakeEventManager::instance()->attach(new CompraEmailEstadoListener());
