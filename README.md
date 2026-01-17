# 🖨️ Imprimeindo - Sistema de Impresión con QR

Sistema moderno de impresión que utiliza códigos QR para gestionar trabajos de impresión de manera eficiente y segura.

## 🚀 Características Principales

### 📱 Sistema de Códigos QR

-   **Generación automática** de códigos QR únicos para cada sesión
-   **Renovación automática** cada 30 segundos
-   **Expiración configurable** (por defecto 30 minutos)
-   **Validación segura** de tokens de sesión

### 🖨️ Gestión Multi-Impresora

-   **Monitoreo en tiempo real** del estado de las impresoras
-   **Balanceador de carga inteligente** para distribución óptima
-   **Detección automática** de impresoras disponibles
-   **Configuración flexible** por impresora (color, dúplex, prioridad)

### 📄 Gestión de Archivos

-   **Soporte múltiple** de formatos (PDF, DOC, DOCX, TXT, JPG, PNG)
-   **Validación automática** de archivos y tamaños
-   **Análisis inteligente** de contenido y páginas
-   **Limpieza automática** de archivos temporales

### 👨‍💼 Panel Administrativo

-   **Dashboard completo** con estadísticas en tiempo real
-   **Gestión de impresoras** (agregar, editar, eliminar)
-   **Monitoreo de trabajos** y cola de impresión
-   **Sistema de autenticación** con roles y permisos

### 🎨 Interfaz Moderna

-   **Diseño responsive** con TailwindCSS
-   **Tema personalizable** con variables CSS centralizadas
-   **Animaciones fluidas** y transiciones suaves
-   **Notificaciones en tiempo real**

## 🛠️ Tecnologías Utilizadas

### Backend

-   **Laravel 11** - Framework PHP moderno
-   **MongoDB** - Base de datos NoSQL
-   **Jenssegers/MongoDB** - ODM para Laravel

### Frontend

-   **TailwindCSS** - Framework CSS utilitario
-   **Vite** - Bundler moderno y rápido
-   **JavaScript ES6+** - Funcionalidades interactivas
-   **Blade Templates** - Motor de plantillas de Laravel

### Herramientas de Desarrollo

-   **ESLint** - Linter para JavaScript
-   **Webpack Mix** - Compilación de assets
-   **Composer** - Gestor de dependencias PHP
-   **NPM** - Gestor de dependencias JavaScript

## 📋 Requisitos del Sistema

-   **PHP** >= 8.2
-   **Composer** >= 2.0
-   **Node.js** >= 18.0
-   **NPM** >= 9.0
-   **MongoDB** >= 5.0
-   **Extensión PHP MongoDB**

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/imprimeindo.git
cd imprimeindo
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Instalar dependencias JavaScript

```bash
npm install
```

### 4. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurar la base de datos

Edita el archivo `.env` con tus credenciales de MongoDB:

```env
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=imprimeindo
DB_USERNAME=
DB_PASSWORD=
```

### 6. Ejecutar migraciones y seeders

```bash
php artisan migrate
php artisan db:seed
```

### 7. Compilar assets

```bash
npm run dev
# o para producción
npm run build
```

### 8. Iniciar el servidor

```bash
php artisan serve
```

## 🔧 Configuración

### Variables de Entorno Importantes

```env
# Configuración de impresoras
PRINTER_DEFAULT_TIMEOUT=30
PRINTER_MAX_RETRIES=3
PRINTER_QUEUE_REFRESH_INTERVAL=5

# Configuración de QR
QR_SESSION_DURATION=1800
QR_REFRESH_INTERVAL=30
QR_IMAGE_SIZE=256

# Configuración de archivos
FILE_MAX_SIZE=10485760
FILE_ALLOWED_TYPES="pdf,doc,docx,txt,jpg,jpeg,png"
FILE_RETENTION_DAYS=7

# Configuración de administración
ADMIN_SESSION_DURATION=7200
ADMIN_MAX_LOGIN_ATTEMPTS=5
```

## 👥 Usuarios por Defecto

Después de ejecutar los seeders, tendrás estos usuarios disponibles:

### Super Administrador

-   **Email:** admin@imprimeindo.com
-   **Password:** admin123
-   **Permisos:** Acceso completo al sistema

### Operador

-   **Email:** operador@imprimeindo.com
-   **Password:** operador123
-   **Permisos:** Gestión de impresoras y trabajos

### Técnico

-   **Email:** tecnico@imprimeindo.com
-   **Password:** tecnico123
-   **Permisos:** Mantenimiento y monitoreo

> ⚠️ **IMPORTANTE:** Cambia estas contraseñas en producción

## 🖨️ Impresoras de Ejemplo

El sistema incluye 4 impresoras de ejemplo:

1. **Impresora Principal** (192.168.1.100) - EPSON L325
2. **Impresora Secundaria** (192.168.1.101) - EPSON L355
3. **Impresora Express** (192.168.1.102) - EPSON L375
4. **Impresora Mantenimiento** (192.168.1.103) - EPSON L365

## 📖 Uso del Sistema

### Para Usuarios

1. **Accede** a la página principal
2. **Escanea** el código QR con tu dispositivo móvil
3. **Selecciona** los archivos a imprimir
4. **Configura** las opciones de impresión
5. **Confirma** y envía el trabajo

### Para Administradores

1. **Accede** al panel en `/admin/login`
2. **Monitorea** el estado de las impresoras
3. **Gestiona** la cola de trabajos
4. **Configura** nuevas impresoras
5. **Revisa** estadísticas y reportes

## 🔄 Comandos Artisan Personalizados

```bash
# Limpiar archivos temporales
php artisan files:cleanup

# Verificar estado de impresoras
php artisan printers:check

# Generar reporte de uso
php artisan reports:generate

# Optimizar sistema
php artisan system:optimize
```

## 🧪 Testing

```bash
# Ejecutar tests
php artisan test

# Ejecutar tests con cobertura
php artisan test --coverage

# Linter JavaScript
npm run lint

# Corregir errores de linting
npm run lint:fix
```

## 📁 Estructura del Proyecto

```
imprimeindo/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controladores
│   │   └── Middleware/      # Middleware personalizado
│   ├── Models/              # Modelos MongoDB
│   └── Services/            # Servicios especializados
├── database/
│   ├── migrations/          # Migraciones
│   └── seeders/            # Seeders
├── resources/
│   ├── css/                # Estilos CSS
│   ├── js/                 # JavaScript
│   └── views/              # Plantillas Blade
├── routes/
│   ├── web.php             # Rutas web
│   └── api.php             # Rutas API
└── public/                 # Assets públicos
```

## 🤝 Contribución

1. **Fork** el proyecto
2. **Crea** una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. **Commit** tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. **Push** a la rama (`git push origin feature/AmazingFeature`)
5. **Abre** un Pull Request

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 🆘 Soporte

Si tienes problemas o preguntas:

1. **Revisa** la documentación
2. **Busca** en los issues existentes
3. **Crea** un nuevo issue si es necesario
4. **Contacta** al equipo de desarrollo

## 🎯 Roadmap

### Versión 1.1

-   [ ] Integración con servicios de nube
-   [ ] Notificaciones push
-   [ ] API REST completa
-   [ ] Aplicación móvil

### Versión 1.2

-   [ ] Integración con sistemas de pago
-   [ ] Reportes avanzados
-   [ ] Multi-tenancy
-   [ ] Escalabilidad horizontal

## 📊 Estadísticas del Proyecto

-   **Líneas de código:** ~15,000
-   **Archivos:** ~150
-   **Controladores:** 6
-   **Modelos:** 5
-   **Servicios:** 4
-   **Vistas:** 12
-   **Tests:** En desarrollo

---

**Desarrollado con ❤️ por el equipo de Imprimeindo**

_Sistema de impresión moderno, eficiente y seguro para el siglo XXI_
