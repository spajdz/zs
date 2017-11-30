<div class="container interior">
  <div class="registro clearfix">
    <div class="col-md-12" style="margin-top: 110px;">
      <?= $this->element('breadcrumbs'); ?>
    </div>
  </div>

  <div class="col-md-7">
    <h4><strong>VENTAS MAYORISTAS</strong></h4>
    <p>Ponemos  nuestros recursos a tu disposición para que  realices todas tus compras de manera rápida, fácil y eficiente:</p>
    <p>&nbsp;</p>
    <ul>
      <li>- Equipo de venta, con vasta experiencia, quienes te visitaran en tu lugar de trabajo el día y hora que indiques.</li>
      <li>- Página web que te permite en el momento que tú quieras y con tan solo un click acceder y comprar los más  de 8.000 productos que tenemos para ti en nuestro catálogo virtual. </li>
      <li>- Sala de exhibición de fácil acceso, amplios estacionamientos, donde podrás retirar los productos de forma inmediata.</li>
      <li>- Despacho directo en RM sin cargo adicional.</li>
    </ul>
    <div class="formulario" id="formulario">
        <div class="inscrip-mayorista forms ">
            <p><strong>Inscripción mayorista</strong></p>
            <p>Solicita aqui la inscripción mayorista.</p>            
                <?= $this->Form->create('Contacto', array(
                      'url' => array('controller' => 'contacto', 'action' => 'index'),                        
                      'class' => 'form-horizontal',
                      'type' => 'file',
                      'inputDefaults' => array('label' => false,'div' => false)
                      )
                ); ?>
                  <?= $this->Form->input('tipo_contacto', array('class' => 'hidden', 'value' => '3')); ?>
                  <?= $this->Form->input('mayoristas', array('class' => 'hidden', 'value' => '1')); ?>
                  <?= $this->Form->input('redirect', array('class' => 'hidden', 'value' => 'pages/display/ventasmayoristas')); ?>
                  <?= $this->Form->input('redirectAction', array('class' => 'hidden', 'value' => 'display')); ?>               
                  <?= $this->Form->input('redirectParam', array('class' => 'hidden', 'value' => 'ventasmayoristas')); ?>               
                  <div class="form-group">
                      <div class="col-xs-12">
                          <?= $this->Form->input('nombre', array('class' => 'form-control input-md', 'placeholder' => 'Nombre Empresa')); ?>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <?= $this->Form->input('rut', array('class' => 'form-control input-md', 'placeholder' => 'Rut empresa')); ?>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <?= $this->Form->input('giro_empresa', array('class' => 'form-control input-md', 'placeholder' => 'Giro empresa')); ?>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <?= $this->Form->input('direccion', array('class' => 'form-control input-md', 'placeholder' => 'Dirección')); ?>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <?= $this->Form->input('nombre_contacto', array('class' => 'form-control input-md', 'placeholder' => 'Nombre contacto')); ?>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <?= $this->Form->input('email', array('class' => 'form-control input-md', 'placeholder' => 'Email contacto')); ?>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <?= $this->Form->input('telefono', array('class' => 'form-control input-md', 'placeholder' => 'telefono contacto')); ?>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <?= $this->Form->textarea('mensaje', array('class' => 'form-control', 'placeholder' => 'Ingrese comentario', 'row' => 65, 'cols' => 50 ));?>                            
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-md-12">
                          <?= $this->Form->input('Enviar', array('type' => 'button', 'class' => 'btn btn-primary')); ?>                            
                      </div>
                  </div>
            <?= $this->Form->end(); ?>
        </div>
    </div> 
    
    <div class="formulario" id="formulario">
      <div class="iniciar-sesion forms ">
        <p><strong>Iniciar Sesión</strong></p>
        <p>Si ya estás registrado, ingresa tus datos para iniciar sesión.</p>
          <?= $this->Form->create('Usuario', array(
                    'url' => array('controller' => 'usuarios', 'action' => 'login'),                        
                    'class' => 'form-horizontal',
                    'inputDefaults' => array('label' => false,'div' => false)
                    )
              ); ?>
            <div class="form-group">
              <label class="sr-only" for="usuario"></label>  
              <div class="col-xs-12">
                <?= $this->Form->input('email', array('type' => 'text', 'placeholder' => 'email', 'class' => 'form-control input-md')); ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label class="sr-only" for="contrasena"></label>
                <?= $this->Form->input('clave', array('autocomplete' => 'new-password', 'type' => 'password', 'class' => 'form-control input-md','placeholder' => 'Contraseña')); ?>                  
              </div>
            </div>            
            <div class="form-group">
              <div class="col-xs-12">
                <p class="contra" ><?= $this->Html->link('¿Olvidaste tu contraseña?', array('controller' => 'usuarios', 'action' => 'add'), array('class' => 'contra')); ?></p>
              </div>
            </div>
            <div class="form-group">
              <label class="sr-only" for="entrar"></label>
              <div class="col-xs-12">
                  <?= $this->Form->button('Entrar', array('type'=>'submit', 'id'=>'entrar', 'name'=>'entrar', 'class' => 'btn btn-primary')); ?>
              </div>
            </div>
        <?= $this->Form->end(); ?>
      </div>
    </div>    
  </div>
  <?if(!empty($miniBanner)):?>
      <div class="col-md-5">
      <div class="banners clearfix">
            <div class='banner'>
             <div class="inner" style="background-image: url('<?= Router::url('/img/'.$miniBanner['Banner']['imagen']['bannerHorizontalHome'], true); ?>');">
                <?
                  if($miniBanner['Banner']['texto'] != "") {
                      echo "<h3>" .$miniBanner['Banner']['texto']. "</h3>";
                    }
                ?>
             </div>
            </div>
      </div>
    </div>
  <?endif;?>
</div>




