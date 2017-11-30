<?= $this->Html->script(array('servicio.form.js?v=3')); ?> 

<?if(!empty($banners)):?>
	<div id="mainCarousel" class="carousel slide home">
		<div class="carousel-inner">
			<ol class="carousel-indicators">
				<?
					if(count($banners)>1){
		                for ($i = 0; $i < count($banners); $i++) {
		                    $ActiveClass = "";
		                    if ($i == 0) $ActiveClass = "class='active'";
		                    echo "<li data-target='#mainCarousel' data-slide-to='" .$i. "' " .$ActiveClass. "></li>";
		                }
		           }
				?>
			</ol>
	        <?php
	            $i = 0;
	            foreach ($banners as $key => $banner) {
	                $ActiveClass = "";
	                if ($i == 0) $ActiveClass = " active";
	                $i++;

	                $urlImg = $banner['Banner']['imagen']['bannerhome'];
	                $link = $banner['Banner']['link'];
	                $texto_slider = $BannerSliderHome['Imagen']['texto_slider'];

	                echo "<div class='item" .$ActiveClass."'>";
	                if(!empty($banner['Banner']['link'])){
	                	echo "<a href='".$banner['Banner']['link']."'>";
	                }
	                echo "<div class='fill' ><img src='".Router::url('/img/'.$banner['Banner']['imagen']['bannerhome'], true)."' class='img-responsive' style='width:100%'></div>";
	                if(!empty($banner['Banner']['link'])){
	                	echo "</a>";
	                }
	                echo "</div>";  
	            }
	        ?>    
		</div>
	</div>
<?endif;?>

<div class="container interior">
	<div class="registro clearfix">
        <div class="col-md-12">
          <?= $this->element('breadcrumbs'); ?> 
        </div>
    </div>
	<?if(!empty($sucursales)):?>
		<div class="col-md-7">
			<div class="col-md-12">
	            <h4><strong>Nuestras Sucursales</strong></h4>
	            <p>Aquí tiene una lista detallada de nuestras tiendas, no dude en ponerse en contacto con nosotros:</p>
	            <div class="panel-group" id="accordion">
	            	<? $i = 0;?>
	            	<?foreach ($sucursales as $sucursal):?>		
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$i;?>">
										<?= $sucursal['Sucursal']['nombre'];?>
										<i class="indicator glyphicon glyphicon-chevron-down pull-right"></i>
									</a>
								</h4>
							</div>
		                    <div id="collapse<?=$i;?>" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="row"> 
									    <div class="col-md-6">  
		                                    <?= $this->Html->image($sucursal['Sucursal']['imagen']['mini'],array('class'=>'img-responsive')); ?>
		                                </div>
		    							<div class="col-md-6 ubicacion">
		    							  <p><strong>Ubicación</strong></p>
		    							  <p><?= $sucursal['Sucursal']['direccion'];?></p>
		    							  <p> Teléfono: <?= $sucursal['Sucursal']['telefono'];?></p>
		    							  <br />
		    							  <p><strong>Horario de atención:</strong></p>
		    							  <?if(!empty($sucursal['Sucursal']['hr_semana'])):?>
		    							  	<p>Lunes a viernes de <?= $sucursal['Sucursal']['hr_semana'];?>.</p>
		    							  <?endif;?>
		    							  <?if(!empty($sucursal['Sucursal']['hr_sabado'])):?>
		    							  	<p>Sábado de <?= $sucursal['Sucursal']['hr_sabado'];?>.</p>
		    							  <?endif;?>
		    							   <?if(!empty($sucursal['Sucursal']['hr_domingo'])):?>
		    							  	<p>Domingo de <?= $sucursal['Sucursal']['hr_domingo'];?>.</p>
		    							  <?endif;?>
		    							</div>
										<div class="col-md-12"><hr></div>
		        						<div class="col-md-6">
		        						  <iframe src="<?= $sucursal['Sucursal']['url_mapa'];?>" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
		        						</div>
		                                <? if( !empty($sucursal['Servicio']) ): ?>
										  <div class="col-md-6 ubicacion">
		                                    <p><strong>Servicios</strong></p>
		                                        <? foreach ($sucursal['Servicio'] as $key => $servicio):?>
										                <p>
			                                                <?=
			                                                    $this->Html->link(
			                                                        $servicio['nombre'],
			                                                        '/servicios/'.$servicio['slug'],
			                                                        array('escape' => false)
			                                                    ); 
			                                                ?>
		                                                </p>    
		                                        <?endforeach;?> 
										  </div>
		                                <?endif;?>
									</div>
								</div>
							</div>
						</div>

						<?$i++;?>
					<?endforeach;?>
	            </div>
	        </div>
		</div>
	<?endif;?>
	<?if(!empty($distribuidores)):?>
		<div class="col-md-7">
			<div class="col-md-12">
	            <h4><strong>Nuestros Distribuidores</strong></h4>
	            <p>Aquí tiene una lista detallada de nuestros distribuidores, no dude en ponerse en contacto con nosotros:</p>
	            <div class="panel-group" id="accordion">
	            	<? $i = 0;?>
	            	<?foreach ($distribuidores as $sucursal):?>		
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$i;?>">
										<?= $sucursal['Sucursal']['nombre'];?>
										<i class="indicator glyphicon glyphicon-chevron-down pull-right"></i>
									</a>
								</h4>
							</div>
		                    <div id="collapse<?=$i;?>" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="row"> 
									    <div class="col-md-6">  
		                                    <?= $this->Html->image($sucursal['Sucursal']['imagen']['mini'],array('class'=>'img-responsive')); ?>
		                                </div>
		    							<div class="col-md-6 ubicacion">
		    							  <p><strong>Ubicación</strong></p>
		    							  <p><?= $sucursal['Sucursal']['direccion'];?></p>
		    							  <p> Teléfono: <?= $sucursal['Sucursal']['telefono'];?></p>
		    							  <br />
		    							  <p><strong>Horario de atención:</strong></p>
		    							  <?if(!empty($sucursal['Sucursal']['hr_semana'])):?>
		    							  	<p>Lunes a viernes de <?= $sucursal['Sucursal']['hr_semana'];?>.</p>
		    							  <?endif;?>
		    							  <?if(!empty($sucursal['Sucursal']['hr_sabado'])):?>
		    							  	<p>Sábado de <?= $sucursal['Sucursal']['hr_sabado'];?>.</p>
		    							  <?endif;?>
		    							   <?if(!empty($sucursal['Sucursal']['hr_domingo'])):?>
		    							  	<p>Domingo de <?= $sucursal['Sucursal']['hr_domingo'];?>.</p>
		    							  <?endif;?>
		    							</div>
										<div class="col-md-12"><hr></div>
		        						<div class="col-md-6">
		        						  <iframe src="<?= $sucursal['Sucursal']['url_mapa'];?>" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
		        						</div>
		                                <? if( !empty($sucursal['Servicio']) ): ?>
										  <div class="col-md-6 ubicacion">
		                                    <p><strong>Servicios</strong></p>
		                                        <? foreach ($sucursal['Servicio'] as $key => $servicio):?>
										                <p>
			                                                <?=
			                                                    $this->Html->link(
			                                                        $servicio['nombre'],
			                                                        '/servicios/'.$servicio['slug'],
			                                                        array('escape' => false)
			                                                    ); 
			                                                ?>
		                                                </p>    
		                                        <?endforeach;?> 
										  </div>
		                                <?endif;?>
									</div>
								</div>
							</div>
						</div>

						<?$i++;?>
					<?endforeach;?>
	            </div>
	        </div>
		</div>
	<?endif;?>
	<div class="col-md-5">
        <div class="formulario" id="formulario">
            <div class="contacto forms "> 
                <p><strong>Contáctanos</strong></p>           
                <?= $this->Form->create('Contacto', array('url' => array('controller' => 'contacto', 'action' => 'index'), 'class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false,'div' => false))); ?>
                	<?= $this->Form->input('redirect', array('class' => 'hidden', 'value' => 'sucursales')); ?>
                	<?= $this->Form->input('tipo_contacto', array('class' => 'hidden', 'value' => '1')); ?>
	                <div class="form-group">
	                    <div class="col-xs-12">
	                        <?= $this->Form->input('nombre', array('class' => 'form-control input-md', 'placeholder' => 'Nombre y Apellido')); ?>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <div class="col-xs-12">
	                        <?= $this->Form->input('email', array('class' => 'form-control input-md', 'placeholder' => 'email')); ?>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <div class="col-xs-12">
	                        <?= $this->Form->input('telefono', array('class' => 'form-control input-md', 'placeholder' => 'telefono')); ?>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <div class="col-xs-12">
	                        <?= $this->Form->textarea('mensaje', array('class' => 'form-control', 'placeholder' => 'Ingrese comentario', 'row' => 65, 'cols' => 50 ));?>                            
	                    </div>
	                </div>
	                <div class="form-group">
	                	<?= $this->Form->hidden('origen', array('value' => $origen)); ?>
	                    <?= $this->Form->hidden('utm_source', array('value' => $utm_source)); ?>
	                    <?= $this->Form->hidden('utm_medium', array('value' => $utm_medium)); ?>
	                    <?= $this->Form->hidden('utm_campaign', array('value' => $utm_campaign)); ?>
	                    <?= $this->Form->hidden('utm_term', array('value' => $utm_term)); ?>
	                    <?= $this->Form->hidden('utm_content', array('value' => $utm_content)); ?>
	                    <?= $this->Form->hidden('scid', array('value' => $scid)); ?>
	                    <?= $this->Form->hidden('gclid', array('value' => $gclid)); ?>
	                    <?= $this->Form->hidden('formulario', array('value' => 'contactanos')); ?>
	                    <?= $this->Form->input('Enviar', array('type' => 'button', 'class' => 'btn btn-primary')); ?>  
	                    <label class="sr-only" for="enviar">enviar</label>
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