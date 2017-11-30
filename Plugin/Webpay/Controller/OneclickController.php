<?php
App::uses('AppController', 'Controller');
class OneclickController extends WebpayAppController
{
	public function inscripcionOneclick()
	{
		$token		= $this->request->query['token'];
		$url		= $this->request->query['url'];

		$this->set(compact('token', 'url'));
	}
}
