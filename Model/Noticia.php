<?php
App::uses('AppModel', 'Model');
class Noticia extends AppModel
{
    /**
     * CONFIGURACION DB
     */
    public $displayField    = 'nombre';
    /**
     * BEHAVIORS
     */
    var $actsAs         = array(
        /**
         * IMAGE UPLOAD
         */
        
        'Image'     => array(
            'fields'    => array(
                'imagen'  => array(
                    'versions'  => array(
                        array(
                            'prefix'    => 'mini',
                            'width'     => 390,
                            'height'    => 202,
                            'crop'      => false
                        ),
                        array(
                            'prefix'    => 'interna',
                            'width'     => 790,
                            'height'    => 412,
                            'crop'      => false
                        )
                    )
                )
            )
        )
        
    );
    /**
     * VALIDACIONES
     */
    public $validate = array(
        'titulo' => array(
            'notBlank' => array(
                'rule'          => array('notBlank'),
                'last'          => true,
            ),
        ),
        'slug' => array(
            'notBlank' => array(
                'rule'          => array('notBlank'),
                'last'          => true,
            ),
        ),        
    );

    public function beforeSave($options = array())
	{
		parent::beforeSave($options);

		$this->data[$this->alias]['created']	=  date('Y-m-d H:i:s');
		$this->data[$this->alias]['modified']	=  date('Y-m-d H:i:s');
		
		return true;
	}
}
