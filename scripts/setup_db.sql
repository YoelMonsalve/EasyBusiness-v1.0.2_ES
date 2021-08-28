/* Fichero para crear la Base de Datos, y el usuario de la aplicación 
 * Ejecutar como root en MySQL. 
 *
 * Autor: Yoel Monsalve.
 * Fecha: Febrero, 2021.
 * Modificado: Julio, 2021.
 */

CREATE DATABASE IF NOT EXISTS `eb_v1_0_2`;

/* crear el usuario, y darle privilegios LIMITADOS */

# Para MySQL, descomentar esta linea y comentar la 16
#CREATE USER IF NOT EXISTS 'eb_admin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'admin';
# Para MariaDB, descomentar esta linea y comentar la 14
CREATE USER IF NOT EXISTS 'eb_admin'@'localhost' IDENTIFIED BY 'admin';

GRANT SELECT, INSERT, UPDATE, DELETE, LOCK TABLES ON `eb_v1_0_2`.* TO 'eb_admin'@'localhost';
FLUSH PRIVILEGES;

