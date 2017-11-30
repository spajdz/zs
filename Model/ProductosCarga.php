<?php
App::uses('AppModel', 'Model');
class ProductosCarga extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */
	public $displayField	= 'nombre';

	public function beforeSave($options = array())
	{
		parent::beforeSave($options);

		$this->data[$this->alias]['created']	=  date('Y-m-d H:i:s');
		$this->data[$this->alias]['modified']	=  date('Y-m-d H:i:s');
		
		return true;
	}
}
