# NexAdopt — Plataforma Integral de Adopción Responsable

NexAdopt es una aplicación web desarrollada como Trabajo de Fin de Grado del ciclo formativo de Desarrollo de Aplicaciones Web. La plataforma actúa como puente digital entre protectoras de animales y personas que quieren adoptar, cubriendo todo el proceso desde la búsqueda del animal hasta la gestión y resolución de las solicitudes por parte del administrador.

---

## Introducción

El abandono animal sigue siendo un problema serio en España. Cada año miles de perros, gatos y otros animales terminan en refugios a la espera de un hogar, y muchos de ellos nunca lo encuentran. Una parte del problema es que el proceso de adopción, cuando no está bien organizado, puede ser opaco, lento o directamente desincentivador tanto para los adoptantes como para las protectoras.

NexAdopt nace con la intención de digitalizar y ordenar ese proceso. La idea no es solo mostrar una lista de animales disponibles, sino construir un sistema completo donde el adoptante pueda registrarse, buscar al animal que mejor encaje con su estilo de vida, rellenar un cuestionario serio de pre-adopción y hacer seguimiento de su solicitud. Todo desde un mismo sitio, sin llamadas ni papeleo innecesario.

Por el lado del administrador, la plataforma ofrece herramientas para gestionar el catálogo de animales, revisar y resolver solicitudes de forma individual, publicar historias de adopciones exitosas y consultar estadísticas básicas del estado general de la protectora.

---

## Tecnologías utilizadas

**Backend**
- PHP 8.2 — lógica del servidor, control de sesiones y procesamiento de formularios
- PDO (PHP Data Objects) — capa de acceso a base de datos con sentencias preparadas
- MySQL — sistema gestor de base de datos relacional

**Frontend**
- HTML5 y CSS3
- Bootstrap 5.3.3 — sistema de grid, componentes y utilidades responsive
- JavaScript (vanilla) — comportamiento del menú móvil y validaciones del lado del cliente
- Chart.js — gráfico de adopciones por mes en el panel de administración
- Lucide Icons — librería de iconos SVG utilizada en la interfaz de administración

**Fuentes y recursos externos**
- Google Fonts (Work Sans) — tipografía principal de la interfaz
- UI Avatars API — generación dinámica de avatares en el perfil de usuario

**Herramientas de desarrollo**
- XAMPP — servidor local Apache + MySQL para desarrollo y pruebas
- Visual Studio Code — editor principal
- Git — control de versiones

---

## Funcionalidades principales

### Registro e identificación de usuarios

Los usuarios pueden crear una cuenta nueva desde el formulario de registro, que recoge nombre, apellidos, correo electrónico, teléfono y contraseña. Las contraseñas se almacenan siempre hasheadas con `password_hash()` usando el algoritmo bcrypt. En el inicio de sesión se valida la contraseña con `password_verify()` y se regenera el ID de sesión tras la autenticación para prevenir ataques de fijación de sesión.

El sistema distingue dos roles: usuario estándar (rol 2) y administrador (rol 1). Los usuarios estándar se registran directamente desde la web; las cuentas de administrador solo pueden crearse desde el panel interno.

### Catálogo de animales con filtros avanzados

La página de adopción muestra todos los animales disponibles que no han sido adoptados todavía. Incluye un sistema de filtros combinables por especie (perro, gato, otro), raza, tramo de edad (cachorro, adulto, senior), tamaño y género. Los filtros se construyen dinámicamente con PDO, añadiendo solo los parámetros activos a la consulta SQL, por lo que nunca se interpola ningún valor directamente en la cadena de texto. Cada tarjeta del catálogo refleja el estado real del animal: si ya tiene solicitudes activas aparece como "En trámite" aunque técnicamente siga sin cerrarse su proceso.

### Ficha de animal y arranque del proceso de adopción

Desde el catálogo se accede al perfil individual de cada animal, donde se muestran sus datos completos: especie, raza, edad, tamaño, sexo, descripción, información clínica (vacunación, desparasitación, esterilización y fecha de última revisión) y su galería de fotografías. Desde esta ficha el usuario autenticado puede iniciar el proceso de adopción. Si ya ha enviado una solicitud previa para ese mismo animal, el botón de adopción se deshabilita para evitar duplicados.

### Formulario de pre-adopción

Es el núcleo del proceso. El formulario recoge información detallada del candidato a adoptante repartida en cinco bloques: datos personales (nombre, apellidos, DNI/NIE, contacto, dirección, profesión), situación de la vivienda (régimen, tipo, si el alquiler permite animales, jardín vallado y dónde vivirá el animal), convivientes y entorno familiar (número de personas, presencia de niños, planes de hijos o bebé, situación de pareja), disponibilidad y rutinas (estabilidad económica, horas que estará solo el animal, número de paseos diarios, plan para vacaciones) y responsabilidad (motivo de adopción, experiencia previa con la especie, otros animales en casa, asunción de gastos veterinarios urgentes y aceptación del seguimiento post-adopción).

Todas las respuestas se almacenan en la tabla `Respuestas_Adopcion` vinculadas a la solicitud correspondiente. La inserción completa, es decir, el registro de la solicitud, las respuestas del cuestionario y la actualización del estado de la mascota a "En proceso", se ejecuta dentro de una transacción PDO. Si algo falla en cualquier punto, todo se revierte y no quedan registros incompletos en la base de datos.

### Área privada del usuario

El perfil del usuario permite editar el nombre, el correo electrónico y la contraseña. Incluye validación de formato de email con `FILTER_VALIDATE_EMAIL` y comprobación de coincidencia de contraseñas antes de hacer ningún cambio en la base de datos. También muestra el historial completo de solicitudes enviadas por ese usuario, con la foto del animal, la fecha de solicitud y el estado actual del trámite (Pendiente, Aprobado o Rechazado), con acceso directo a la ficha de cada animal.

### Formulario de contacto

Permite enviar mensajes a la protectora con campos para nombre, teléfono opcional, correo electrónico, asunto (desplegable con categorías: información sobre adopción, voluntariado, donaciones, aviso de animal abandonado u otro) y mensaje libre. Todos los mensajes se almacenan en la tabla `mensajes_contacto`. El formulario requiere aceptar la política de privacidad antes del envío y valida que el correo tenga formato correcto antes de realizar la inserción en base de datos.

### Panel de administración

El panel está protegido por control de rol: cualquier intento de acceder a las rutas del directorio `admin/` sin sesión activa de administrador redirige automáticamente al inicio de la web pública.

Desde el panel el administrador puede:

**Dashboard principal** — muestra el total de mascotas registradas en el sistema, el número de solicitudes pendientes de revisión y el contador de animales ya adoptados. Incluye un gráfico de líneas generado con Chart.js con las adopciones aprobadas mes a mes durante el año en curso, calculado directamente desde la base de datos.

**Gestión del inventario de animales** — tabla con todos los animales del sistema, mostrando nombre, especie, raza, estado actual, número de solicitudes vinculadas y acciones de edición y borrado. El borrado utiliza sentencias preparadas para evitar cualquier riesgo de inyección.

**Alta de nuevas mascotas** — formulario con subida múltiple de hasta 10 fotografías. El sistema crea una subcarpeta con el nombre del animal en el servidor, mueve los archivos subidos a esa carpeta y guarda la ruta de la foto principal en la base de datos. También registra los datos clínicos del animal: si está vacunado, desparasitado, esterilizado y la fecha de última revisión veterinaria.

**Gestión de solicitudes de adopción** — listado filtrable por estado (todos, pendientes, aprobadas, rechazadas). Al expandir una solicitud se puede leer el cuestionario completo de pre-adopción del candidato. Desde esta misma vista el administrador puede aprobar o rechazar. Al aprobar, el sistema realiza en una sola transacción las siguientes operaciones: marca la solicitud como "Aprobada", actualiza el estado de la mascota a "Adoptada" y rechaza automáticamente todas las solicitudes pendientes restantes para ese mismo animal. Al rechazar, comprueba si quedan otras solicitudes pendientes y, si no es así, devuelve la mascota al estado "Disponible".

**Gestión de historias de adopción exitosa** — permite crear nuevas historias con título, testimonio y fotografía seleccionada de las imágenes ya subidas al servidor. También permite editarlas o eliminarlas desde el inventario de historias. Las historias publicadas aparecen en la página principal y en la sección "Sobre Nosotros".

### Medidas de seguridad implementadas

Todos los formularios con operaciones POST están protegidos con tokens CSRF a través del módulo centralizado `includes/csrf.php`. Los tokens se generan con `random_bytes(32)` y se validan con `hash_equals()` para evitar ataques de temporización. Todas las consultas a base de datos utilizan sentencias preparadas con parámetros nombrados, eliminando cualquier posibilidad de inyección SQL. Los errores de base de datos se registran en el log del servidor con `error_log()` sin exponer información técnica en la respuesta al usuario.

---

## Estructura del proyecto

```
tfg-nexadopt/
│
├── index.php                     # Página principal: hero, características, historias
├── adoptar.php                   # Catálogo de animales con sistema de filtros
├── perfil-mascota.php            # Ficha individual de cada animal
├── formulario-solicitud.php      # Cuestionario de pre-adopción detallado
├── perfil.php                    # Área privada del usuario autenticado
├── registro.php                  # Registro de nuevos usuarios
├── login.php                     # Inicio de sesión
├── logout.php                    # Cierre de sesión y destrucción de sesión
├── contacto.php                  # Formulario de contacto con la protectora
├── colaborar.php                 # Información para colaboradores y voluntarios
├── consejos.php                  # Artículos y recursos sobre tenencia responsable
├── nosotros.php                  # Presentación de la protectora e historias de éxito
│
├── admin/                        # Back-office (solo accesible con rol administrador)
│   ├── dashboard.php             # Panel principal con estadísticas y gráfico mensual
│   ├── crear_mascotas.php        # Alta de nuevas mascotas con subida de imágenes
│   ├── editar_mascota.php        # Edición de datos de una mascota existente
│   ├── lista_mascotas.php        # Inventario completo de mascotas del sistema
│   ├── solicitudes.php           # Gestión y resolución de solicitudes de adopción
│   ├── crear_historia.php        # Creación de historias de adopción exitosa
│   ├── editar_historia.php       # Edición de una historia existente
│   └── gestionar_historias.php   # Inventario de historias con edición y borrado
│
├── includes/                     # Componentes PHP reutilizables en todas las páginas
│   ├── header.php                # Cabecera pública con navegación y menú responsive
│   ├── footer.php                # Pie de página con enlaces, redes y botón WhatsApp
│   ├── header_admin.php          # Cabecera del panel de administración con sidebar
│   ├── footer_admin.php          # Cierre del layout del panel de administración
│   └── csrf.php                  # Módulo centralizado de protección CSRF
│
├── config/
│   └── conexion.php              # Configuración y conexión PDO a la base de datos
│
├── assets/
│   ├── css/
│   │   └── style.css             # Hoja de estilos principal del proyecto
│   ├── img/
│   │   ├── mascotas/             # Fotos de los animales (una subcarpeta por mascota)
│   │   ├── historias/            # Imágenes de las historias de adopción exitosa
│   │   ├── inicio/               # Imágenes de la página de inicio
│   │   ├── consejos/             # Imágenes de los artículos de consejos
│   │   └── header_footer/        # Logo y recursos gráficos del header y footer
│   ├── icons/                    # Iconos propios del proyecto en formato PNG
│   └── video/
│       └── video-nextadopt.mp4   # Vídeo promocional incrustado en la página de inicio
│
└── pages/                        # Páginas informativas y legales
    ├── aviso-legal.php
    ├── privacidad.php
    ├── cookies.php
    └── donar.php
```

**Tablas de la base de datos:**

| Tabla | Descripción |
|---|---|
| `Usuarios` | Datos de registro, credenciales hasheadas y rol asignado |
| `Mascotas` | Ficha completa del animal, datos clínicos, estado y fotos |
| `Solicitudes_Adopcion` | Registro de solicitudes con estado y fecha |
| `Respuestas_Adopcion` | Respuestas del cuestionario vinculadas a cada solicitud |
| `historias_exito` | Historias de adopción publicadas con título, testimonio y foto |
| `mensajes_contacto` | Mensajes recibidos a través del formulario de contacto |

---

## Instalación y configuración

### Requisitos previos

- PHP 8.0 o superior con extensión PDO y PDO_MySQL activa
- MySQL 5.7 o superior (o MariaDB equivalente)
- Servidor Apache con módulo `mod_rewrite` habilitado
- XAMPP, Laragon o cualquier stack AMP local

### Pasos de instalación

**1. Copiar el proyecto en la carpeta del servidor web**

```bash
# En Windows con XAMPP:
C:\xampp\htdocs\tfg-nexadopt\

# En macOS o Linux con XAMPP:
/opt/lampp/htdocs/tfg-nexadopt/
```

**2. Crear la base de datos**

Desde phpMyAdmin o desde el cliente de línea de comandos:

```sql
CREATE DATABASE nexadopt CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Importar el archivo SQL incluido en la entrega:

```bash
mysql -u root -p nexadopt < nexadopt.sql
```

**3. Configurar la conexión a la base de datos**

Abrir `config/conexion.php` y ajustar los valores al entorno local:

```php
$host     = 'localhost';
$dbname   = 'nexadopt';
$usuario  = 'root';
$password = '';  // En XAMPP suele estar vacía por defecto
```

**4. Ajustar la URL base del proyecto**

En `includes/header.php`, comprobar que la variable `$base_url` apunte correctamente a la instalación local:

```php
$base_url = "http://localhost/tfg-nexadopt/";
```

**5. Comprobar permisos de escritura en las carpetas de imágenes**

La subida de fotos de mascotas e historias requiere que Apache tenga permisos de escritura:

```bash
# En Linux/macOS
chmod -R 775 assets/img/mascotas/
chmod -R 775 assets/img/historias/
```

En Windows con XAMPP los permisos suelen estar correctos por defecto.

**6. Iniciar el servidor y acceder desde el navegador**

Arrancar Apache y MySQL desde el panel de XAMPP y acceder a:

```
http://localhost/tfg-nexadopt/
```

Para acceder al panel de administración es necesario tener un usuario con `id_rol = 1` en la base de datos. El archivo SQL de instalación incluye un usuario administrador de ejemplo.

---

## Uso de la aplicación

### Flujo del usuario estándar

El usuario puede navegar por el catálogo de animales sin necesitar cuenta. Para iniciar el proceso de adopción necesita registrarse o iniciar sesión. Una vez autenticado puede filtrar animales por las características que le interesen, consultar la ficha completa de cada uno, enviar el formulario de pre-adopción y hacer seguimiento del estado de su solicitud desde su perfil personal.

### Flujo del administrador

El administrador accede con sus credenciales desde el formulario de login. Al detectar el rol 1, el sistema le muestra el acceso al panel en el menú de usuario. Desde el dashboard puede ver el estado general de la plataforma, gestionar el inventario de animales, añadir nuevas mascotas con sus fotos y datos clínicos, revisar el cuestionario completo de cada candidato a adoptante y tomar la decisión de aprobar o rechazar la solicitud. También gestiona las historias de éxito publicadas en la web pública.

---

## Mejoras futuras

- **Notificaciones por correo electrónico:** avisar al usuario cuando el estado de su solicitud cambie, usando PHPMailer o la función nativa `mail()` correctamente configurada en el servidor.

- **Paginación en el catálogo:** cuando el número de animales crezca, la página de adopción necesita paginación real en lugar de cargar todos los registros de una vez.

- **Galería de imágenes en la ficha del animal:** la subida de hasta 10 fotos ya está implementada en la parte de administración, pero la ficha pública solo muestra la foto principal. Se podría añadir un carrusel con las imágenes adicionales.

- **Vista de mensajes de contacto en el panel:** los mensajes del formulario de contacto se guardan en base de datos pero no existe ninguna interfaz de administración para consultarlos y gestionarlos.

- **Recuperación de contraseña:** flujo de restablecimiento mediante enlace con token de un solo uso enviado por correo electrónico.

- **Módulo de acogida temporal:** diferenciado del proceso de adopción definitiva, con formulario propio y flujo de gestión independiente para las familias de acogida.

- **Exportación de solicitudes:** posibilidad de descargar los datos del cuestionario de pre-adopción en formato PDF o CSV para el uso interno de la protectora.

---

## Conclusión

NexAdopt es un proyecto que intenta resolver un problema real con herramientas concretas. La idea de partida es que este tipo de plataforma podría ser útil de verdad para una protectora pequeña que hoy gestiona sus adopciones por WhatsApp o correo electrónico sin ningún sistema de seguimiento.

Técnicamente, el proyecto abarca la mayor parte de los contenidos trabajados a lo largo del ciclo: diseño de base de datos relacional, programación del lado del servidor con PHP, manejo de sesiones, seguridad básica en aplicaciones web (CSRF, inyección SQL, session fixation, hash de contraseñas), desarrollo frontend con Bootstrap, gestión de archivos y subida de imágenes, y organización de un proyecto de varias páginas con componentes reutilizables.

El resultado es una aplicación funcional, con control de acceso por roles, protección contra los ataques más habituales en aplicaciones web y una interfaz que se adapta correctamente a cualquier dispositivo.

---

## Autor

**Nombre:** David Sánchez Sánchez 
**Ciclo:** Desarrollo de Aplicaciones Web (DAW) — 2.º curso  
**Centro:** Universidad Alfonso X el Sabio  
**Proyecto:** Trabajo de Fin de Grado  
**Fecha:** Mayo 2026