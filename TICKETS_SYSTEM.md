# 📋 Sistema de Gestión de Tickets - Guía Completa

## Requisitos Cumplidos ✅

### 1. Backend API
✅ **POST /api/tickets** - Crear ticket
- Validación: titulo (max 120), descripcion, prioridad, cliente_id
- Manejo de errores y respuesta JSON consistente

✅ **GET /api/tickets** - Listar tickets con filtros
- Filtros: prioridad, rango de fechas, búsqueda por título
- Validaciones, manejo de errores, respuesta JSON
- Autenticación: `auth:sanctum` (ambas rutas)

### 2. Base de Datos
✅ **Tabla `clientes`**
- Campos: id (PK), nombre, email, telefono, empresa, direccion
- Soft deletes, timestamps
- Índices para nombre y email

✅ **Tabla `tickets`**
- Campos: id (PK), titulo, descripcion, prioridad, estado
- Foreign keys: cliente_id, user_id
- Soft deletes, timestamps
- Índices: prioridad, created_at, titulo, cliente_id

✅ **Migraciones y Seeders**
- Migraciones: `2026_04_09_000001_create_clientes_table.php`
- Migraciones: `2026_04_09_000000_create_tickets_table.php`
- Seeders: `ClienteSeeder.php`, `TicketSeeder.php`
- DatabaseSeeder configurado

### 3. Frontend Vue
✅ **Formulario para crear tickets**
- Campos: titulo, descripcion, prioridad, cliente_id
- Validaciones en UI
- Estados: loading, error, éxito

✅ **Listado con filtros**
- Filtro por prioridad
- Filtro por rango de fechas
- Búsqueda por título
- Paginación

✅ **Estados y manejo de errores**
- Loading states
- Mensajes de éxito/error
- Validaciones básicas

---

## 📊 Tablas de Base de Datos

```
users (existente)
├─ id, name, email, password, timestamps

personal_access_tokens (Sanctum)
├─ Tokens para autenticación

clientes (NUEVA)
├─ id (PK)
├─ nombre, email (UNIQUE), telefono, empresa, direccion
├─ timestamps, deleted_at (soft deletes)
└─ Índices: nombre, email

tickets (NUEVA)
├─ id (PK)
├─ titulo (120), descripcion, prioridad (enum)
├─ estado (default: abierto)
├─ cliente_id (FK → clientes)
├─ user_id (FK → users, nullable)
├─ timestamps, deleted_at (soft deletes)
└─ Índices: prioridad, created_at, titulo, cliente_id
```

---

## 🚀 Instrucciones de Instalación y Ejecución

### 1. Migraciones
```bash
# Ejecutar todas las migraciones
php artisan migrate

# Si necesitas rehacer desde cero
php artisan migrate:fresh
```

### 2. Seeders
```bash
# Llenar la BD con datos de prueba
php artisan db:seed

# O ejecutar los seeders después de migrate:fresh
php artisan migrate:fresh --seed
```

### 3. Generar Token (Autenticación Sanctum)
```bash
# Crear un usuario de prueba con token
php artisan tinker

# En la consola tinker:
$user = App\Models\User::first();
$token = $user->createToken('api-token')->plainTextToken;
echo $token;
# Copiar el token generado
```

### 4. Acceder al Frontend
```
http://localhost/Laravel/proyecto/tickets
```

> **Nota:** Para que la API funcione sin autenticación en local, puedes comentar temporalmente el middleware `auth:sanctum` en `routes/api.php`

---

## 🔑 Protección con Autenticación Sanctum

### Opción A: Generar token en la BD
```bash
php artisan tinker
$user = User::first();
$token = $user->createToken('api-token')->plainTextToken;
echo $token;
```

### Opción B: Desactivar autenticación temporalmente
Editar `routes/api.php`:
```php
// Comentar temporalmente para pruebas
// Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/clientes', [ClienteController::class, 'index']);
// });
```

---

## 📡 Endpoints API

### GET /api/clientes
**Respuesta:**
```json
{
  "success": true,
  "message": "Clientes obtenidos correctamente",
  "data": [
    {
      "id": 1,
      "nombre": "Juan García",
      "email": "juan@example.com",
      "telefono": "+34 912 345 678",
      "empresa": "Tech Solutions S.A.",
      "direccion": "Calle Principal 123, Madrid",
      "created_at": "2026-04-09T10:00:00.000000Z"
    }
  ]
}
```

### POST /api/tickets
**Request:**
```json
{
  "titulo": "Error en login",
  "descripcion": "Los usuarios no pueden iniciar sesión",
  "prioridad": "alta",
  "cliente_id": 1
}
```

**Respuesta (201):**
```json
{
  "success": true,
  "message": "Ticket creado exitosamente",
  "data": {
    "titulo": "Error en login",
    "descripcion": "Los usuarios no pueden iniciar sesión",
    "prioridad": "alta",
    "cliente_id": 1,
    "estado": "abierto",
    "id": 1,
    "created_at": "2026-04-09T10:00:00.000000Z",
    "updated_at": "2026-04-09T10:00:00.000000Z"
  }
}
```

### GET /api/tickets
**Query Parameters:**
- `prioridad` (nullable): "baja", "media", "alta"
- `fecha_inicio` (nullable): formato YYYY-MM-DD
- `fecha_fin` (nullable): formato YYYY-MM-DD
- `titulo` (nullable): búsqueda parcial
- `per_page` (nullable): 1-100, default 15

**Ejemplo:**
```
GET /api/tickets?prioridad=alta&titulo=error&per_page=10&page=1
```

**Respuesta:**
```json
{
  "success": true,
  "message": "Tickets obtenidos correctamente",
  "data": [...],
  "pagination": {
    "total": 6,
    "per_page": 15,
    "current_page": 1,
    "last_page": 1,
    "from": 1,
    "to": 6
  }
}
```

---

## 🧪 Pruebas con Postman/cURL

### Crear Ticket
```bash
curl -X POST http://localhost/Laravel/proyecto/api/tickets \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "titulo": "Nuevo problema",
    "descripcion": "Descripción del problema",
    "prioridad": "media",
    "cliente_id": 1
  }'
```

### Listar Tickets
```bash
curl -X GET "http://localhost/Laravel/proyecto/api/tickets?prioridad=alta" \
  -H "Authorization: Bearer {token}"
```

### Filtrar por Rango de Fechas
```bash
curl -X GET "http://localhost/Laravel/proyecto/api/tickets?fecha_inicio=2026-04-01&fecha_fin=2026-04-09" \
  -H "Authorization: Bearer {token}"
```

### Búsqueda por Título
```bash
curl -X GET "http://localhost/Laravel/proyecto/api/tickets?titulo=error" \
  -H "Authorization: Bearer {token}"
```

---

## 📁 Estructura de Archivos

```
app/
├─ Http/
│  └─ Controllers/
│     ├─ TicketController.php       ✅
│     └─ ClienteController.php      ✅
├─ Models/
│  ├─ Ticket.php                   ✅
│  └─ Cliente.php                  ✅

database/
├─ migrations/
│  ├─ 2026_04_09_000000_create_tickets_table.php     ✅
│  └─ 2026_04_09_000001_create_clientes_table.php    ✅
└─ seeders/
   ├─ ClienteSeeder.php            ✅
   ├─ TicketSeeder.php             ✅
   └─ DatabaseSeeder.php           ✅

routes/
├─ api.php                         ✅
└─ web.php                         ✅

resources/
└─ views/
   └─ tickets.blade.php            ✅
```

---

## 🔍 Validaciones Implementadas

### Backend (Laravel)
- `titulo`: required, max 120
- `descripcion`: required
- `prioridad`: required, in:baja,media,alta
- `cliente_id`: required, exists:clientes,id
- Filtros de fechas: date_format Y-m-d, after_or_equal

### Frontend (Vue)
- Campo requerido validación
- Max length display
- Select dropdowns for restricted values
- Mensajes de error dinámicos

---

## 📝 Notas Importantes

1. **Autenticación:** El sistema usa Laravel Sanctum. Necesitas un token válido para usar los endpoints.
2. **Soft Deletes:** Los registros eliminados se marcan como deleted pero no se borran.
3. **Timestamps:** Automáticos (created_at, updated_at)
4. **Índices:** Optimizados para filtros en el listado
5. **Paginación:** 15 registros por defecto, máximo 100

---

## ❓ Solución de Problemas

### Error: Table not found
```bash
php artisan migrate
```

### Error: Class not found
```bash
composer dump-autoload
```

### Tokens no funcionan
```bash
php artisan tinker
$user = User::first();
$token = $user->createToken('api-token')->plainTextToken;
```

### Frontend no se ve
```
Asegúrate de acceder a: http://localhost/Laravel/proyecto/tickets
```

---

## ✨ Características Adicionales

- Búsqueda parcial con LIKE en SQL
- Estados de carga (loading, success, error)
- Recarga automática cada 30 segundos
- Paginación interactiva
- Badges de colores por prioridad y estado
- Fecha formateada en español
- Relaciones Eloquent configuradas

---

**Proyecto completado: 2026-04-09** ✅
