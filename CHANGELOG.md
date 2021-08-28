# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.2] - 2021-08-28
- Issue #1. `CHARACTER SET` y `COLLATION` mal configurados en el fichero de volcado `eb_v1_0_2.sql`,
estaban provocando un error de lectura cuando dichos ficheros eran importados por MariaDB/phpMyAdmin.

## [1.0.2] - 2021-07-27
### Changed
- Cambiar el hash de contraseña de sha1 a sha512

## [1.0.2] - 2021-07-26
### Changed
- DB name pasa de 'almacen' a 'eb_v1_0_2'
- DB user para de 'almacen_admin' a 'eb_admin'. No se necesita indicar la versión, ya que el nombre de la DB lo contiene.
- Cambiar el define SITE_PATH por SITE_URL

### [Nota, para mi]
- Added para funcionalidades nuevas.
- Changed para los cambios en las funcionalidades existentes.
- Deprecated para indicar que una característica o funcionalidad está obsoleta y que se eliminará en las próximas versiones.
- Removed para las características en desuso que se eliminaron en esta versión.
- Fixed para corrección de errores.
- Security
