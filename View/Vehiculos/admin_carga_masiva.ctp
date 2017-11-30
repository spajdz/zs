<div class="page-title">
    <h2><span class="fa fa-list"></span> Vehiculo</h2>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Nueva Carga</h3>
    </div>
    <div class="panel-body">
            <?= $this->Form->create('Masiva', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
               <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body profile">
                                <div class="profile-data">
                                    <div class="profile-data-name"><span class="fa fa-pencil"></span> Carga masiva de vehículos</div>
                                </div>
                                <div class="btn-group pull-left">
                                    <?= $this->Html->link(
                                        '<i class="fa fa-cloud-download"></i> Formato ejemplo CSV vehiculos especificaciones',
                                        '/backend/file/vehiculos_especificaciones.csv',
                                        array('class' => 'btn btn-success',
                                              'escape' => false
                                    )); ?>
                                </div> 
                                <div class="btn-group pull-right">
                                    <?= $this->Form->input('archivo', array('type' => 'file', 'class' => '')); ?>
                                </div>  
                            </div>                                 
                        </div> 
                </div>
                <div class="pull-right">
                    <input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
                    <?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
                </div>
            <?= $this->Form->end(); ?>
    </div>
</div>
