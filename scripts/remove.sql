/* Fichero para borrar la Base de Datos, y el usuario de nuestra instalación,
 * y dejar el sistema limpio.
 * Ejecutar como root en MySQL. 
 *
 * --- Cuidado: Se destruirán todos los datos !!! ---
 *
 * Autor: Yoel Monsalve.
 * Fecha: Febrero, 2021.
 * Modificado: Julio, 2021.
 */

DROP DATABASE IF EXISTS `eb_v1_0_2`;

/* borrar el usuario de la aplicación */
DROP USER IF EXISTS 'eb_admin'@'localhost';

