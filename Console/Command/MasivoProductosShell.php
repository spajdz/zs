<?php
App::uses('View', 'View');
class MasivoProductosShell extends AppShell
{
	public $uses = array('Producto');

    public $Result = '';
    public $pxp = 300;

    public $endpoint = 'http://200.29.13.186:8091/WebService1.asmx?WSDL';

    function mem($lugar = 'N/A')
    {
        $this->out(sprintf('Uso memoria (%s): %s', $lugar, convert(memory_get_usage(true))));
    }

     function mem2($lugar = 'N/A')
    {
        $this->Result .= sprintf('Uso memoria (%s): %s', $lugar, convert(memory_get_usage(true))).'<br>';
    }
}
