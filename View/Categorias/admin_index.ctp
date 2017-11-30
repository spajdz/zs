<div class="page-title">
	<h3><span class="fa fa-list"></span> Categorias</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Listado de Categorias</h3>
			<div class="btn-group pull-right">
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<h5>Selecciona las categorias que deseas mostrar en el menu desplegable de accesorios</h5>
						</tr>
					</thead>
					<tbody> 
						<div class="checkbox text-right">
							<label><input type="checkbox" id="marcar-categorias-todas" onclick="MarcarcategoriasTodas();">Seleccionar todas las categorias</label>
						</div>

                        <?= $this->Form->create('Categoria', array(
		                      'class' => 'form-horizontal',
		                      'type' => 'file',
		                      'inputDefaults' => array('label' => false,'div' => false)
		                      )
		                ); ?>
						<div class="panel-group accordion-categorias" id="accordion-categorias" role="tablist" aria-multiselectable="true">
							<?php  foreach ( $categorias as $key => $categoria ) : ?>
					          <?
					            if( $categoria['Categoria']['parent_id']=='3'):
									if(count($categoria['children'])>0):
									?>  	
										<div class="panel panel-default" style="min-height: auto;">
											<div class="panel-heading" role="tab" id="heading-categoria-<?= $categoria['Categoria']['id']; ?>">
											  <h5 class="panel-title">
											    <a role="button" data-toggle="collapse" data-parent="#accordion-categorias" href="#collapse-categoria-<?= $categoria['Categoria']['id']; ?>" aria-expanded="true" aria-controls="collapse-categoria-<?= $categoria['Categoria']['id']; ?>">
												<label class="categoria-padre-label">
													<?= $categoria['Categoria']['nombre'];?>
												</label>
											    </a>
											  </h5>
											</div>

											<div id="collapse-categoria-<?= $categoria['Categoria']['id']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading-categoria-<?= $categoria['Categoria']['id']; ?>">
											  	<div class="panel-body">

													<div class="checkbox text-right" style="float: none; border-bottom: solid 1px #ccc; margin-bottom: 10px;">
														<label><input type="checkbox" id="marcar-categorias-<?= $categoria['Categoria']['id']; ?>" onclick="MarcarcategoriasPorCategoriaPadre(<?= $categoria['Categoria']['id']; ?>);">Seleccionar todas</label>
													</div>

												  	<div style="height: auto; max-height: 150px; overflow: auto;" id="categorias-hijas-<?= $categoria['Categoria']['id']; ?>">
												  		
														<strong><?= $categoria['Categoria']['nombre'];?></strong>
														<label>
															<input type="checkbox" value="<?= $categoria['Categoria']['id'];?>" name="data[categoriasSeleccionadas][]"  <?= !empty($categoria['Categoria']['menu']) ? "checked='checked'" : '' ?>>
														</label>
												  		<ul style="padding: 0; margin: 0; list-style: none;">

															<?php foreach ( $categoria['children'] as $key => $subcategoria ) : ?>
										      					<li>
										      						<div class="checkbox">
																		<label>
																			<input type="checkbox" value="<?= $subcategoria['Categoria']['id'];?>" name="data[categoriasSeleccionadas][]" <?= !empty($subcategoria['Categoria']['menu']) ? "checked='checked'" : '' ?> ><?= $subcategoria['Categoria']['nombre'];?>
																		</label>
																	</div>
										      					</li>
				 											<?php endforeach; ?>
												  		<ul>
												  	</div>
												</div>
											</div>
										</div>
									<?
									endif;
						        endif;
						      ?> 
						 	<?php endforeach; ?>
						</div>
                        <div class="col-xs-12">
                            <?= $this->Form->input('Guardar Menu', array('type' => 'button', 'class' => 'btn btn-primary')); ?>                   
                        </div>
 						<?= $this->Form->end(); ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>	