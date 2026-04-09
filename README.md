
## Sistema de Tickets

Proyecto Laravel para administrar tickets de soporte con API REST y frontend Vue.

## Requisitos
- PHP 8.3+
- MySQL
- Composer
- Node.js (opcional para assets)

## Instalación

1. Clona el repositorio y entra al directorio.
https://github.com/W4RL0N/proyectoManpowerGroup.git

Rama: main

2. Instala dependencias:
   
   ``` composer install ```
  

3. Crea la base de datos MySQL llamada `laravel13`:
   
   
    ``` CREATE DATABASE laravel13; ```
  

4. El archivo `.env` ya está incluido en el repositorio. Verifica que tenga:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel13
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Ejecuta migraciones y seeders para crear tablas y datos iniciales:
   ```
   php artisan migrate --seed
   ```

6. Inicia el servidor:
   ```
   php artisan serve
   ```

## Uso

Usar el link de la vista ya que esta configurado el puerto 8000:

- Frontend: `http://127.0.0.1:8000/tickets`
- API:
  - `GET /api/tickets` (con filtros: prioridad, fecha_inicio, fecha_fin, titulo)
  - `POST /api/tickets` (campos: titulo, descripcion, prioridad, cliente_id)
  - `GET /api/clientes`




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

## Notas
- No requiere autenticación.
- Datos iniciales incluidos via seeders.

