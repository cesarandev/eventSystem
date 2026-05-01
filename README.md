# Eventia Pro

Aplicacion PHP MVC con MySQL para centralizar una empresa de eventos de recreacion.

## Estructura

- `index.php`: front controller y definicion de rutas.
- `app/Core`: router, controlador base, modelo base y conexion PDO.
- `app/Controllers`: controladores por modulo.
- `app/Models`: modelos conectados a tablas MySQL.
- `app/Views`: vistas PHP por modulo y layout general.
- `config/database.php`: credenciales MySQL.
- `database/schema.sql`: base de datos, tablas y datos semilla.

## Instalar base de datos

```bash
mysql -u root -p < database/schema.sql
```

Si tus credenciales son distintas, ajusta `config/database.php` o usa variables de entorno:

```bash
DB_HOST=127.0.0.1 DB_DATABASE=eventia_pro DB_USERNAME=root DB_PASSWORD=secret php -S localhost:8000 index.php
```

## Ejecutar

```bash
php -S localhost:8000 index.php
```

Abre `http://localhost:8000`.

## Modulos

- Dashboard ejecutivo con ingresos, utilidad, pipeline, cotizaciones y eventos.
- Clientes CRM con datos fiscales y comerciales.
- Servicios tipo inventario con unidad de cobro, precio, costo, margen y capacidad.
- Cotizaciones conectadas a clientes, IVA 19%, descuento, probabilidad y estado.
- Eventos conectados a clientes/cotizaciones con enlace a Google Calendar.
- Contabilidad colombiana: facturacion electronica, IVA, retenciones, ICA/ReteICA, nomina electronica, cartera y flujo de caja.
