<?php
App::uses('AppModel', 'Model');
class Marca extends AppModel
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
                'nombreimg'    => array(
                    'versions'  => array(
                        array(
                            'prefix'    => 'original',
                            'width'     => 211,
                            'height'    => 100,
                            'crop'      => false
                        ),
                        array(
                            'prefix'    => 'mini',
                            'width'     => 148,
                            'height'    => 70,
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
        'nombre' => array(
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

    /**
     * ASOCIACIONES
     */
    public $hasMany = array(
        'Producto' => array(
            'className'             => 'Producto',
            'foreignKey'            => 'marca_id',
            'dependent'             => false,
            'conditions'            => '',
            'fields'                => '',
            'order'                 => '',
            'limit'                 => '',
            'offset'                => '',
            'exclusive'             => '',
            'finderQuery'           => '',
            'counterQuery'          => ''
        )
    );

    public function beforeSave($options = array())
    {
        parent::beforeSave($options);

        $this->data[$this->alias]['created']    =  date('Y-m-d H:i:s');
        $this->data[$this->alias]['modified']   =  date('Y-m-d H:i:s');
        
        return true;
    }
}
