# Predictive Search Plugin para WordPress

Plugin completo de búsqueda predictiva con AJAX que indexa contenidos en un archivo JSON dentro del plugin, con estructura compatible con WPML y búsqueda asíncrona.

## Características

✨ **Búsqueda Predictiva en Tiempo Real**: Los resultados aparecen mientras escribes (AJAX asíncrono)
🔍 **Indexación Completa**: Busca en títulos, contenido, extractos, categorías, tags, ACF, eventos y más
🌍 **Compatibilidad WPML**: Soporte completo para sitios multiidioma con WPML
⚙️ **Panel de Administración**: Genera el índice a demanda y configura qué post types y campos excluir
📊 **Índice JSON**: Almacenado dentro del directorio del plugin para mejor organización
🎯 **Sistema de Relevancia**: Algoritmo que prioriza resultados más relevantes
🔄 **Actualización Automática**: Índice actualizado diariamente mediante cron
⚡ **Optimizado**: Búsquedas rápidas usando índice pre-generado
📱 **Responsive**: Funciona perfectamente en móviles y tablets
🔒 **Seguro**: Directorio de índice protegido con .htaccess

## Instalación

1. Sube la carpeta `predictive-search-plugin` a `/wp-content/plugins/`
2. Activa el plugin desde el menú "Plugins" en WordPress
3. Ve a "Predictive Search" en el menú de administración
4. Configura tus preferencias y campos a indexar

## Uso

### Shortcode

Inserta el buscador en cualquier página o entrada:

```
[predictive_search]
```

Con parámetros personalizados:

```
[predictive_search placeholder="Buscar contenido..." min_chars="2"]
```

### Widget

1. Ve a **Apariencia → Widgets**
2. Arrastra el widget "Predictive Search" a cualquier área de widgets
3. Configura el título y opciones

### Código PHP

Inserta directamente en tus plantillas:

```php
<?php echo do_shortcode('[predictive_search]'); ?>
```

## Configuración

### Panel de Administración

Accede a **Predictive Search** en el menú de WordPress para:

- **Caracteres mínimos**: Número de caracteres antes de mostrar resultados (por defecto: 3)
- **Resultados máximos**: Cantidad de resultados a mostrar (por defecto: 10)
- **Formato del índice**: JSON o XML
- **Campos a excluir**: Selecciona qué campos NO quieres indexar

### Campos Indexados

Por defecto, el plugin indexa:

- ✅ Título
- ✅ Contenido
- ✅ Extracto
- ✅ Categorías
- ✅ Etiquetas
- ✅ Autor
- ✅ Campos ACF (Advanced Custom Fields)
- ✅ Eventos (The Events Calendar)
- ✅ Campos personalizados
- ✅ Imagen destacada

Puedes excluir cualquiera de estos campos desde el panel de administración.

## Indexación

### Automática

El plugin crea un índice automáticamente:

- Al activar el plugin
- Diariamente mediante WordPress Cron
- Al publicar o actualizar un post
- Al eliminar un post

### Manual (Asíncrono)

Puedes regenerar el índice manualmente desde el panel de administración haciendo clic en **"Regenerar Índice Ahora"**. El proceso se ejecuta de forma asíncrona mediante AJAX, mostrando un indicador de progreso y sin necesidad de recargar la página.

## Integración con Plugins

### Advanced Custom Fields (ACF)

El plugin detecta automáticamente si ACF está activo y indexa todos los campos personalizados.

### The Events Calendar

Detecta eventos automáticamente e indexa:
- Fecha de inicio
- Fecha de fin
- Lugar del evento

## Sistema de Relevancia

Los resultados se ordenan por relevancia usando un sistema de puntuación:

- **Título**: 10 puntos (+ 5 bonus si empieza con la búsqueda)
- **Extracto**: 5 puntos
- **Eventos**: 6 puntos
- **Categorías**: 4 puntos
- **Tags**: 4 puntos
- **Contenido**: 3 puntos (+ puntos por múltiples ocurrencias)
- **ACF**: 3 puntos
- **Campos personalizados**: 2 puntos
- **Autor**: 2 puntos

## Archivos del Índice

Los índices se guardan dentro del directorio del plugin:

```
/wp-content/plugins/predictive-search-plugin/index/
├── search-index.json
├── search-index.xml
└── .htaccess (protección del directorio)
```

**Ventajas de esta ubicación:**
- ✅ El índice viaja con el plugin (mejor para backups)
- ✅ No depende de permisos de `/wp-content/uploads/`
- ✅ Más fácil de gestionar y mantener
- ✅ Protegido con `.htaccess` para seguridad

## Requisitos

- WordPress 5.0 o superior
- PHP 7.2 o superior
- jQuery (incluido en WordPress)

## Plugins Compatibles

- ✅ **WPML** - Compatibilidad completa con multiidioma
- ✅ **Polylang** - Soporte para sitios multiidioma
- ✅ **Advanced Custom Fields (ACF)** - Indexa campos personalizados
- ✅ **The Events Calendar** - Indexa eventos con fechas y lugares
- ✅ **WooCommerce** - Indexa productos con SKU, precios y atributos
- ✅ **Cualquier Custom Post Type** - Soporte completo para tipos personalizados

### Compatibilidad WPML

El plugin está completamente optimizado para trabajar con WPML:

- **Detección automática**: Detecta si WPML está activo
- **Indexación multiidioma**: Indexa contenido de todos los idiomas
- **Filtrado por idioma**: Las búsquedas muestran solo resultados del idioma actual
- **Información de traducción**: Guarda IDs de traducción (trid) para mejor gestión
- **Detección flexible**: Funciona con diferentes métodos de WPML (filters, constants, functions)

## Personalización CSS

Puedes personalizar los estilos agregando CSS personalizado:

```css
/* Personalizar input */
.ps-search-input {
    border-color: #tu-color;
    border-radius: 20px;
}

/* Personalizar resultados */
.ps-result-item a:hover {
    background-color: #tu-color-hover;
}

/* Personalizar título de resultados */
.ps-result-title {
    color: #tu-color;
}
```

## Hooks y Filtros

### Filtros Disponibles

```php
// Modificar datos antes de indexar
add_filter('ps_index_post_data', function($data, $post_id) {
    // Tu código aquí
    return $data;
}, 10, 2);

// Modificar resultados de búsqueda
add_filter('ps_search_results', function($results, $query) {
    // Tu código aquí
    return $results;
}, 10, 2);
```

### Acciones Disponibles

```php
// Después de crear el índice
add_action('ps_after_create_index', function() {
    // Tu código aquí
});

// Antes de crear el índice
add_action('ps_before_create_index', function() {
    // Tu código aquí
});
```

## Troubleshooting

### Los resultados no aparecen

1. Verifica que el índice esté creado (Panel de administración)
2. Regenera el índice manualmente
3. Verifica que no hayas excluido todos los campos
4. Comprueba la consola del navegador por errores JavaScript

### El índice no se actualiza automáticamente

1. Verifica que WordPress Cron esté funcionando
2. Regenera el índice manualmente desde el panel de administración
3. Verifica los permisos de escritura en el directorio del plugin (`/wp-content/plugins/predictive-search-plugin/index/`)
4. Asegúrate de que el directorio `index` existe dentro del plugin

### Búsquedas lentas

1. Reduce el número máximo de resultados
2. Excluye campos que no necesites
3. Considera usar JSON en lugar de XML (es más rápido)

## Soporte

Para soporte y consultas:
- Email: tu-email@ejemplo.com
- Documentación: https://tu-sitio.com/docs

## Configuración de Post Types y Campos

### Excluir Post Types

Desde el panel de administración puedes seleccionar qué tipos de contenido deseas indexar. Solo los post types marcados serán incluidos en el índice.

### Excluir Campos por Post Type

Para cada post type habilitado, puedes excluir campos específicos de la indexación:

- **Título**: Excluir títulos de la búsqueda
- **Contenido**: Excluir el contenido principal
- **Extracto**: Excluir extractos
- **Categorías**: Excluir categorías
- **Etiquetas**: Excluir tags
- **Autor**: Excluir información del autor
- **Campos ACF**: Excluir campos de Advanced Custom Fields
- **Campos personalizados**: Excluir metadatos personalizados
- **Imagen destacada**: Excluir URLs de imágenes destacadas

**Nota**: Los campos marcados NO serán incluidos en la búsqueda para ese tipo de contenido específico.

## Changelog

### 1.1.0
- ✅ Índice ahora se guarda dentro del directorio del plugin
- ✅ Compatibilidad completa con WPML mejorada
- ✅ Generación de índice asíncrona mediante AJAX
- ✅ Mejor detección de idioma en frontend y backend
- ✅ Protección del directorio de índice con .htaccess
- ✅ Interfaz mejorada con indicadores de progreso

### 1.0.0
- Lanzamiento inicial
- Búsqueda predictiva con AJAX
- Indexación diaria automática
- Panel de administración
- Soporte para ACF y The Events Calendar
- Widget y shortcode

## Licencia

GPL v2 or later

## Créditos

Desarrollado por [Tu Nombre]
