<?php
App::uses('AppController', 'Controller');
class CargasController extends AppController
{
    public function admin_index()
    {
        
        $this->paginate     = array(
            'order' => 'Carga.id DESC',
            'limit' => 10
        );
        $cargas  = $this->paginate();
        $this->set(compact('cargas'));
    }
}
