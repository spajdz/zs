<?php
App::uses('AppModel', 'Model');
class Carga extends AppModel
{
	public $validate = array(
		'identificador' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
			),
		),
	);

	public $belongsTo = array(
		'Administrador' => array(
			'className'				=> 'Administrador',
			'foreignKey'			=> 'administrador_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
		)
	);
	
	public function beforeSave($options = array())
	{
		parent::beforeSave($options);

		$this->data[$this->alias]['created']	=  date('Y-m-d H:i:s');
		$this->data[$this->alias]['modified']	=  date('Y-m-d H:i:s');
		
		return true;
	}
}
