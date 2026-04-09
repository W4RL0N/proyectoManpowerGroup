<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Tickets</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            color: #333;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
        }

        .content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        @media (max-width: 1024px) {
            .content {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }

        .btn {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .btn-reset {
            background: #95a5a6;
            margin-left: 10px;
        }

        .btn-reset:hover {
            background: #7f8c8d;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .filters {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .filters input,
        .filters select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .tickets-list {
            max-height: 600px;
            overflow-y: auto;
        }

        .ticket-item {
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #667eea;
            margin-bottom: 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .ticket-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transform: translateX(5px);
        }

        .ticket-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .ticket-meta {
            display: flex;
            gap: 15px;
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-alta {
            background: #ffe6e6;
            color: #c0392b;
        }

        .badge-media {
            background: #fff3cd;
            color: #856404;
        }

        .badge-baja {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-abierto {
            background: #cce5ff;
            color: #004085;
        }

        .badge-en_proceso {
            background: #fff3cd;
            color: #856404;
        }

        .badge-cerrado {
            background: #d4edda;
            color: #155724;
        }

        .ticket-description {
            color: #555;
            font-size: 14px;
            line-height: 1.5;
            margin-top: 8px;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #667eea;
        }

        .spinner {
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        .empty-state svg {
            width: 60px;
            height: 60px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .pagination {
            display: flex;
            gap: 5px;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination button {
            padding: 5px 10px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 3px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .pagination button.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .pagination button:hover:not(.active) {
            background: #f5f5f5;
        }

        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    @verbatim
    <div id="app">
        <div class="container">
            <div class="header">
                <h1>📋 Sistema de Gestión de Tickets</h1>
                <p>Crea y administra tickets de soporte de manera eficiente</p>

            </div>

            <div class="content">
                <!-- FORMULARIO DE CREACIÓN -->
                <div class="card">
                    <h2>Crear Nuevo Ticket</h2>

                    <div v-if="successMessage" class="alert alert-success">
                        ✓ {{ successMessage }}
                    </div>

                    <div v-if="errorMessage" class="alert alert-error">
                        ✗ {{ errorMessage }}
                    </div>

                    <form @submit.prevent="createTicket">
                        <div class="form-group">
                            <label for="titulo">Título *</label>
                            <input
                                v-model="form.titulo"
                                type="text"
                                id="titulo"
                                maxlength="120"
                                placeholder="Descripción breve del problema"
                                @blur="validateField('titulo')"
                            />
                            <div v-if="errors.titulo" class="error-message">{{ errors.titulo }}</div>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción *</label>
                            <textarea
                                v-model="form.descripcion"
                                id="descripcion"
                                placeholder="Detalles del problema..."
                                @blur="validateField('descripcion')"
                            ></textarea>
                            <div v-if="errors.descripcion" class="error-message">{{ errors.descripcion }}</div>
                        </div>

                        <div class="form-group">
                            <label for="prioridad">Prioridad *</label>
                            <select v-model="form.prioridad" id="prioridad" @blur="validateField('prioridad')">
                                <option value="">-- Seleccionar --</option>
                                <option value="baja">🟢 Baja</option>
                                <option value="media">🟡 Media</option>
                                <option value="alta">🔴 Alta</option>
                            </select>
                            <div v-if="errors.prioridad" class="error-message">{{ errors.prioridad }}</div>
                        </div>

                        <div class="form-group">
                            <label for="cliente_id">Cliente *</label>
                            <select v-model="form.cliente_id" id="cliente_id" @blur="validateField('cliente_id')">
                                <option value="">-- Seleccionar cliente --</option>
                                <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
                                    {{ cliente.nombre }} ({{ cliente.empresa }})
                                </option>
                            </select>
                            <div v-if="errors.cliente_id" class="error-message">{{ errors.cliente_id }}</div>
                        </div>

                        <button type="submit" class="btn" :disabled="loading">
                            <span v-if="loading">⏳ Guardando...</span>
                            <span v-else>✓ Crear Ticket</span>
                        </button>
                        <button type="button" class="btn btn-reset" @click="resetForm">
                            🔄 Limpiar
                        </button>
                    </form>
                </div>

                <!-- LISTADO Y FILTROS -->
                <div class="card">
                    <h2>Tickets</h2>

                    <div class="filters">
                        <input
                            v-model="filters.titulo"
                            type="text"
                            placeholder="🔍 Buscar por título..."
                            @input="filterTickets"
                        />
                        <select v-model="filters.prioridad" @change="filterTickets">
                            <option value="">📊 Todas las prioridades</option>
                            <option value="baja">🟢 Baja</option>
                            <option value="media">🟡 Media</option>
                            <option value="alta">🔴 Alta</option>
                        </select>
                        <input
                            v-model="filters.fecha_inicio"
                            type="date"
                            @change="filterTickets"
                        />
                        <input
                            v-model="filters.fecha_fin"
                            type="date"
                            @change="filterTickets"
                        />
                    </div>

                    <div v-if="loadingTickets" class="loading">
                        <div class="spinner"></div>
                        <p>Cargando tickets...</p>
                    </div>

                    <div v-else-if="tickets.length === 0" class="empty-state">
                        <p>📭 No hay tickets disponibles</p>
                    </div>

                    <div v-else class="tickets-list">
                        <div v-for="ticket in tickets" :key="ticket.id" class="ticket-item">
                            <div class="ticket-title">{{ ticket.titulo }}</div>
                            <div class="ticket-meta">
                                <span><strong>Cliente:</strong> {{ getClientName(ticket.cliente_id) }}</span>
                                <span><span class="badge" :class="'badge-' + ticket.prioridad">{{ ticket.prioridad }}</span></span>
                                <span><span class="badge" :class="'badge-' + ticket.estado">{{ ticket.estado }}</span></span>
                            </div>
                            <div class="ticket-description">{{ ticket.descripcion }}</div>
                            <small style="color: #999;">📅 {{ formatDate(ticket.created_at) }}</small>
                        </div>
                    </div>

                    <div v-if="pagination.last_page > 1" class="pagination">
                        <button
                            @click="previousPage"
                            :disabled="pagination.current_page === 1"
                        >
                            ← Anterior
                        </button>
                        <span style="padding: 5px 10px;">
                            Página {{ pagination.current_page }} de {{ pagination.last_page }}
                        </span>
                        <button
                            @click="nextPage"
                            :disabled="pagination.current_page === pagination.last_page"
                        >
                            Siguiente →
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endverbatim

    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    form: {
                        titulo: '',
                        descripcion: '',
                        prioridad: '',
                        cliente_id: '',
                    },
                    errors: {},
                    successMessage: '',
                    errorMessage: '',
                    loading: false,
                    loadingTickets: false,
                    tickets: [],
                    clientes: [],
                    filters: {
                        titulo: '',
                        prioridad: '',
                        fecha_inicio: '',
                        fecha_fin: '',
                    },
                    pagination: {
                        total: 0,
                        per_page: 15,
                        current_page: 1,
                        last_page: 1,
                        from: 0,
                        to: 0,
                    },
                };
            },
            methods: {
                async createTicket() {
                    this.errors = {};
                    this.errorMessage = '';
                    this.successMessage = '';

                    // Validaciones básicas
                    if (!this.form.titulo.trim()) {
                        this.errors.titulo = 'El título es requerido';
                    }
                    if (!this.form.descripcion.trim()) {
                        this.errors.descripcion = 'La descripción es requerida';
                    }
                    if (!this.form.prioridad) {
                        this.errors.prioridad = 'La prioridad es requerida';
                    }
                    if (!this.form.cliente_id) {
                        this.errors.cliente_id = 'Debe seleccionar un cliente';
                    }

                    if (Object.keys(this.errors).length > 0) {
                        return;
                    }

                    this.loading = true;

                    try {
                        const response = await axios.post('/api/tickets', this.form, {
                            headers: {
                                'Content-Type': 'application/json',
                            },
                        });

                        this.successMessage = response.data.message || 'Ticket creado exitosamente';
                        this.resetForm();
                        this.loadTickets();

                        setTimeout(() => {
                            this.successMessage = '';
                        }, 4000);
                    } catch (error) {
                        if (error.response?.data?.errors) {
                            this.errors = error.response.data.errors;
                        }
                        this.errorMessage = error.response?.data?.message || 'Error al crear el ticket';
                    } finally {
                        this.loading = false;
                    }
                },

                async loadTickets() {
                    this.loadingTickets = true;

                    try {
                        const params = {
                            ...this.filters,
                            page: this.pagination.current_page,
                            per_page: this.pagination.per_page,
                        };

                        // Remover parámetros vacíos
                        Object.keys(params).forEach(key => {
                            if (!params[key]) delete params[key];
                        });

                        const response = await axios.get('/api/tickets', { params });

                        this.tickets = response.data.data || [];
                        this.pagination = response.data.pagination || {};
                    } catch (error) {
                        this.errorMessage = 'Error al cargar los tickets';
                    } finally {
                        this.loadingTickets = false;
                    }
                },

                async loadClientes() {
                    try {
                        const response = await axios.get('/api/clientes');
                        this.clientes = response.data.data || [];
                    } catch (error) {
                        this.errorMessage = 'Error al cargar clientes.';
                        console.error('Error al cargar clientes:', error);
                    }
                },

                filterTickets() {
                    this.pagination.current_page = 1;
                    this.loadTickets();
                },

                previousPage() {
                    if (this.pagination.current_page > 1) {
                        this.pagination.current_page--;
                        this.loadTickets();
                    }
                },

                nextPage() {
                    if (this.pagination.current_page < this.pagination.last_page) {
                        this.pagination.current_page++;
                        this.loadTickets();
                    }
                },

                resetForm() {
                    this.form = {
                        titulo: '',
                        descripcion: '',
                        prioridad: '',
                        cliente_id: '',
                    };
                    this.errors = {};
                },

                validateField(field) {
                    // Validaciones básicas
                    if (field === 'titulo' && !this.form.titulo.trim()) {
                        this.errors.titulo = 'El título es requerido';
                    } else if (field === 'titulo') {
                        delete this.errors.titulo;
                    }

                    if (field === 'descripcion' && !this.form.descripcion.trim()) {
                        this.errors.descripcion = 'La descripción es requerida';
                    } else if (field === 'descripcion') {
                        delete this.errors.descripcion;
                    }
                },

                getClientName(clienteId) {
                    const cliente = this.clientes.find(c => c.id === clienteId);
                    return cliente ? cliente.nombre : 'Cliente desconocido';
                },

                formatDate(date) {
                    return new Date(date).toLocaleDateString('es-ES', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                    });
                },

            },
            mounted() {
                this.loadClientes();
                this.loadTickets();

                // Recargar tickets cada 30 segundos
                setInterval(() => {
                    this.loadTickets();
                }, 30000);
            },
        }).mount('#app');
    </script>
</body>
</html>
