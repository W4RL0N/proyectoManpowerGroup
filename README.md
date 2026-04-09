<<<<<<< HEAD
# proyectoManpowerGroup
Proyecto Prueba Tecnica ManpowerGroup Desarrollador Laravel
=======
# Sistema de Tickets

Proyecto Laravel para administrar tickets de soporte con creación, listado y filtros.

## Contenido del proyecto

- API REST con endpoints para:
  - crear tickets
  - listar tickets
  - obtener clientes
- Frontend Vue integrado en Blade: `resources/views/tickets.blade.php`
- Migraciones Laravel para MySQL
- Seeders para datos iniciales de clientes y tickets
- Pruebas backend para validación, creación y filtrado

## Requisitos para desplegar en localhost

- PHP 8.3+
- MySQL
- Composer
- Servidor web o `php artisan serve`

## Configuración del entorno

1. Copia el archivo de entorno:
   ```bash
   cp .env.example .env
   ```

2. Configura la conexión MySQL en `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nombre_base_datos
   DB_USERNAME=usuario
   DB_PASSWORD=contraseña
   ```

3. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

4. Instala dependencias PHP:
   ```bash
   composer install
   ```

## Base de datos y migraciones

Ejecuta migraciones y carga los datos iniciales:
```bash
php artisan migrate --seed
```

### Tablas principales

#### `clientes`

- `id` bigint PK auto-increment
- `nombre` string
- `email` string único
- `telefono` string nullable
- `empresa` string nullable
- `direccion` text nullable
- `created_at`, `updated_at`
- `deleted_at` soft delete
- índices: `nombre`, `email`

#### `tickets`

- `id` bigint PK auto-increment
- `titulo` string (120)
- `descripcion` text
- `prioridad` enum (`baja`, `media`, `alta`)
- `estado` string default `abierto`
- `cliente_id` unsignedBigInteger FK -> `clientes.id`
- `user_id` unsignedBigInteger nullable
- `created_at`, `updated_at`
- `deleted_at` soft delete
- índices: `prioridad`, `created_at`, `titulo`, `cliente_id`

### Datos iniciales

El proyecto incluye seeders que generan:

- varios clientes de prueba
- varios tickets de prueba con prioridades y estados diversos

Esto permite probar el frontend y los filtros sin necesidad de crear datos manualmente.

## API

### `GET /api/clientes`

Obtiene la lista de clientes.

### `GET /api/tickets`

Lista tickets con filtros opcionales:

- `prioridad` = `baja` | `media` | `alta`
- `fecha_inicio` = `YYYY-MM-DD`
- `fecha_fin` = `YYYY-MM-DD`
- `titulo` = búsqueda parcial en título
- `per_page` = número de resultados por página

### `POST /api/tickets`

Crea un ticket.

#### Campos requeridos

- `titulo` (máximo 120)
- `descripcion`
- `prioridad` (`baja`, `media`, `alta`)
- `cliente_id` (debe existir)

#### Ejemplo de petición

```bash
curl -X POST http://127.0.0.1:8000/api/tickets \
  -H "Content-Type: application/json" \
  -d '{
    "titulo": "Error en login",
    "descripcion": "No permite iniciar sesión",
    "prioridad": "alta",
    "cliente_id": 1
  }'
```

## Frontend

- Ruta: `/tickets`
- Usa Vue 3 para:
  - crear tickets
  - listar tickets
  - aplicar filtros por prioridad, fecha y texto de título
- Ubicación del archivo: `resources/views/tickets.blade.php`

## Pruebas

Ejecuta las pruebas con:
```bash
php artisan test
```

Pruebas incluidas:
- validación de payload al crear ticket
- creación exitosa de ticket
- consulta y filtro de tickets por prioridad y texto

## Decisiones técnicas

- No se requiere autenticación para usar la API en localhost.
- API simple con respuestas JSON consistentes.
- Frontend integrado en Blade para facilitar despliegue sin build adicional.
- Migraciones y seeders proporcionan la estructura de BD y datos iniciales.

## Cómo ejecutar en localhost

1. Asegúrate de que MySQL esté corriendo.
2. Ajusta `.env` con la base de datos.
3. Corre migraciones y seeders:
   ```bash
   php artisan migrate --seed
   ```
4. Inicia el servidor:
   ```bash
   php artisan serve
   ```
5. Accede a:
   ```
   http://127.0.0.1:8000/tickets
   ```

## NOTA

El proyecto está diseñado para un entorno de desarrollo local. Si se desea desplegar a producción, se debe configurar un servidor web que sirva la carpeta `public` y proteger las rutas apropiadamente.
>>>>>>> ebdd89e (primer commit del proyecto, donde se crean las especificaciones del proyecto Vue+Laravel)
