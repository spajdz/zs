<?php
App::uses('AppController', 'Controller');
class VehiculosController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'limit'			=> 20
		);
		$vehiculos	= $this->paginate();

		$this->set(compact('vehiculos'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Vehiculo->create();
			if ( $this->Vehiculo->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Vehiculo->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Vehiculo->save($this->request->data) )
			{
				$this->Session->setFlash('Registro editado correctamente', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		else
		{
			$this->request->data	= $this->Vehiculo->find('first', array(
				'conditions'	=> array('Vehiculo.id' => $id)
			));
		}
	}

	public function admin_delete($id = null)
	{
		$this->Vehiculo->id = $id;
		if ( ! $this->Vehiculo->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Vehiculo->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->Vehiculo->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Vehiculo->_schema);
		$modelo			= $this->Vehiculo->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}

	public function admin_carga_masiva()
    {
        if ( $this->request->is('post') )
        {
            set_time_limit(0);
            if ($this->request->data['Masiva']['archivo']['tmp_name'] != "") {            
                extract($this->request->data['Masiva']['archivo']);
                if ( empty($error) && ( ( $gestor = fopen($tmp_name, 'r') ) !== FALSE ) )
                {
                    $FilasConDatosIncompletos = "";
                    $FilasAgregadas = "";
                    $FilasIgnoradas = "";
                    $resumen = "";
                    $fila = 2;

                    $error = false;
                    while(($datos = fgetcsv($gestor, 0, ';')) !== FALSE){
                        if (array_key_exists('1', $datos)) {

                            if ($datos[0] == 'MARCA') {
                                continue;
                            } 

                            //verifica si los datos están completos
                            $DatosCompletos = true;

                            for ($i = 0; $i <= 14; $i++) {

                                $dato = trim($datos[$i]);
                                if (empty($dato) || ($dato == "NO DATA")) {
                                    $DatosCompletos = false;
                                    break;
                                }
                            }

                            if (!$DatosCompletos) {
                                if ($FilasConDatosIncompletos != "") {
                                    $FilasConDatosIncompletos .= ", ";
                                }
                                $FilasConDatosIncompletos .= $fila;
                                $fila++;
                                continue;
                            }

                            $dataVehiculo = array(
                            	'marca' => trim($datos[0])
                            	,'modelo' => trim($datos[1])
                            	,'ano' => trim($datos[2])
                            	,'version' => trim($datos[3])
                            	,'puertas' => trim($datos[4])
                            	,'carroceria' => trim($datos[5])
                            	,'traccion' => trim($datos[6])
                            	,'medida_original' => trim($datos[7])
                            	,'ancho_llanta' => trim($datos[8])
                            	,'apernadura' => trim($datos[9])
                            	,'ancho' => trim($datos[10])
                            	,'perfil' => trim($datos[11])
                            	,'aro' => trim($datos[12])
                            	,'indice_carga' => trim($datos[13])
                            	,'velocidad' => trim($datos[14])
                            );

                            $this->Vehiculo->create();
                            if(!$this->Vehiculo->save($dataVehiculo)){
                            	$error = true;
                            }
                        } 

                        $fila++;

                    }

                    fclose($gestor);

                    if($error){
                   		$this->Session->setFlash('Ocurrio un error al guardar algunos vehiculos.', null, array(), 'danger');
                    }else{
                    	$this->Session->setFlash('Se cargaron los vehiculos correctamente.', null, array(), 'success');
                    }

                }

            }

        }

    }

    public function modelos_marca($nombre_marca = null){
		$this->layout='ajax';
		$modelos = $this->Vehiculo->modelosByMarca($nombre_marca);

		$this->set(compact('modelos'));
	}

	public function versiones_marca_modelo($nombre_marca = null, $nombre_modelo = null){
		$this->layout='ajax';
		$versiones = $this->Vehiculo->versionesByMarcaModelo($nombre_marca, $nombre_modelo);
		$this->set(compact('versiones'));
	}

	public function anos_marca_modelo_version($nombre_marca = null, $nombre_modelo = null, $nombre_version = null){
		$this->layout='ajax';
		$anos = $this->Vehiculo->anosByMarcaModeloVersion($nombre_marca, $nombre_modelo, $nombre_version);
		$this->set(compact('anos'));
	}

	public function anchos_marca_modelo_version_ano($tipo = null, $nombre_marca = null, $nombre_modelo = null, $nombre_version = null, $ano = null){
		$this->layout='ajax';

		$tipo = 'neumaticos';
		$anchos = $this->Vehiculo->anchosByMarcaModeloVersionAno($tipo, $nombre_marca, $nombre_modelo, $nombre_version, $ano);

		$this->set(compact('anchos'));
	}

	public function perfiles_marca_modelo_version_ano_ancho($nombre_marca = null, $nombre_modelo = null, $nombre_version = null, $ano = null, $ancho = null){
		$this->layout='ajax';

		$perfiles = $this->Vehiculo->perfilesByMarcaModeloVersionAnoAncho($nombre_marca, $nombre_modelo, $nombre_version, $ano, $ancho);

		$this->set(compact('perfiles'));
	}

	public function aros_marca_modelo_version_ano_ancho_perfil($nombre_marca = null, $nombre_modelo = null, $nombre_version = null, $ano = null, $ancho = null, $perfil = null){
		$this->layout='ajax';

		$aros = $this->Vehiculo->arosByMarcaModeloVersionAnoAnchoPerfil($nombre_marca, $nombre_modelo, $nombre_version, $ano, $ancho, $perfil);

		$this->set(compact('aros'));
	}

}
