# Sistema de Inventario de Cruz Roja

Versión integrada del proyecto SC-502. Incluye autenticación, inventario,
préstamos y devoluciones, mantenimiento y reportes conectados a MySQL.

## Ejecutar el proyecto

Requisito: Docker Desktop abierto.

```bash
docker compose up --build
```

Después abra:

- Aplicación: http://localhost:8080
- phpMyAdmin: http://localhost:8082

Credenciales iniciales de la aplicación:

- Usuario: `admin`
- Contraseña: `Admin123*`

Credenciales de phpMyAdmin:

- Usuario: `root`
- Contraseña: `root`

La base de datos y sus tablas se crean automáticamente la primera vez. Los
datos se conservan en el volumen `db_data` cuando se detienen los contenedores.

Si ya se había iniciado una versión anterior sin tablas y se desea reconstruir
la base desde cero, ejecute `docker compose down -v` antes de volver a ejecutar
`docker compose up --build`. Este comando elimina los datos anteriores del
proyecto.
