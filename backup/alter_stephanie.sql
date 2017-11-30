ALTER TABLE `zsmotor_sitiov2`.`sitio_contactos` 
ADD COLUMN `giro_empresa` VARCHAR(255) NULL AFTER `mensaje`,
ADD COLUMN `direccion` VARCHAR(255) NULL AFTER `giro_empresa`,
ADD COLUMN `nombre_contacto` VARCHAR(255) NULL AFTER `direccion`;
