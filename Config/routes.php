<?php
Router::connect('/', array('controller' => 'productos', 'action' => 'home'));

// RUTAS ZSMOTOR
Router::connect('/filtros', array('controller' => 'productos', 'action' => 'filtros'));

foreach ( ['neumaticos', 'accesorios', 'llantas'] as $tipo ) 
{

    Router::connect("/{$tipo}/:marca/ficha/:slug", array('controller' => 'productos', 'action' => 'view', $tipo));
    Router::connect("/{$tipo}/ficha/:slug", array('controller' => 'productos', 'action' => 'view', $tipo));
    // Router::connect("/{$tipo}/:marca/*", array('controller' => 'productos', 'action' => 'marca', $tipo));
    Router::connect("/{$tipo}", array('controller' => 'productos', 'action' => 'index', $tipo));
}

Router::connect("/neumaticos/*", array('controller' => 'productos', 'action' => 'categorias', 'neumaticos'));
Router::connect("/llantas/*", array('controller' => 'productos', 'action' => 'categorias', 'llantas'));
Router::connect('/categoria/*', array('controller' => 'productos', 'action' => 'categoria'));
Router::connect('/ventas-mayoristas', array('controller' => 'pages', 'action' => 'display', 'ventasmayoristas'));


// LO QUE ES DE HOOKIPA

Router::connect('/catalogo/*', array('controller' => 'productos', 'action' => 'index', 'lista' => 'catalogo' ), array('pass' => array('lista')));
Router::connect('/deportes/*', array('controller' => 'productos', 'action' => 'index', 'lista' => 'deportes'), array('pass' => array('lista')));

Router::connect('/ficha/*', array('controller' => 'productos', 'action' => 'view'));
Router::connect('/buscar', array('controller' => 'productos', 'action' => 'buscar'));
Router::connect('/carro', array('controller' => 'productos', 'action' => 'carro'));
Router::connect('/vaciar', array('controller' => 'productos', 'action' => 'vaciar'));

Router::connect('/login', array('controller' => 'usuarios', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'usuarios', 'action' => 'logout'));
Router::connect('/perfil/*', array('controller' => 'usuarios', 'action' => 'edit'));
Router::connect('/registro', array('controller' => 'usuarios', 'action' => 'add'));
Router::connect('/recuperar/*', array('controller' => 'usuarios', 'action' => 'recuperar'));
Router::connect('/cambiar_clave', array('controller' => 'usuarios', 'action' => 'cambiar_clave'));

Router::connect('/resumen', array('controller' => 'compras', 'action' => 'resumen'));
Router::connect('/webpay', array('controller' => 'compras', 'action' => 'webpay'));
Router::connect('/reintentar', array('controller' => 'compras', 'action' => 'reintentar'));
Router::connect('/exito', array('controller' => 'compras', 'action' => 'exito'));
Router::connect('/fracaso', array('controller' => 'compras', 'action' => 'fracaso'));

Router::connect('/despacho', array('controller' => 'direcciones', 'action' => 'add'));
Router::connect('/reservas', array('controller' => 'reservas', 'action' => 'add'));
Router::connect('/listas', array('controller' => 'listas', 'action' => 'add'));
Router::connect('/contacto', array('controller' => 'contactos', 'action' => 'index'));
Router::connect('/sucursales', array('controller' => 'sucursales', 'action' => 'index'));
Router::connect('/sucursal/*', array('controller' => 'sucursales', 'action' => 'view'));
Router::connect('/novedad/*', array('controller' => 'novedades', 'action' => 'view'));
Router::connect('/compras/ver/*', array('controller' => 'compras', 'action' => 'view', 'admin' => false));
Router::connect('/ayuda/*', array('controller' => 'ayudas', 'action' => 'index'));

Router::connect('/admin', array('controller' => 'compras', 'action' => 'dashboard', 'admin' => true));
Router::connect('/admin/login', array('controller' => 'administradores', 'action' => 'login', 'admin' => true));
Router::connect('/admin/logout', array('controller' => 'administradores', 'action' => 'logout', 'admin' => true));

Router::connect('/seccion/*', array('controller' => 'pages', 'action' => 'display'));

Router::connectNamed(array('filtro'));

CakePlugin::routes();
require CAKE . 'Config' . DS . 'routes.php';
