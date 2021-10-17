# Issues History
This is a brief description of issues found and/or solved.

## [1.0.2]
### 2021-08-28
- #1. `CHARACTER SET` and `COLLATION` was set to `utf8mb4_0900_ai_ci` in the scripts setup_db.sql, and eb_v1_0_2.sql
This format was not being well recognized when imported by phpMyAdmin. 
**Solution:** change `CHARACTER SET` to `utf8` and `COLLATION` to `utf8_general_ci`.


