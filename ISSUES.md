# ISSUES
This is a history and brief description of the issues found.

## [1.0.2]
### 2021-07-28

- #1. The `CHARACTER SET` and `COLLATION` were bad configured in the scripts `setup_db.sql`, and
`eb_v1_0_2.sql`, and therefore making them unrecognizable when imported from phpMyAdmin. 
**Solution:** change the `CHARACTER SET` to `utf8`, and `COLLATION` to `utf8_general_ci`.
