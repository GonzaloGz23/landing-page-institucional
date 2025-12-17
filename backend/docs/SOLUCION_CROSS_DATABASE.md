# Solución: Consultas Cross-Database sin Privilegios Especiales

## Problema Original

El host no otorgaba privilegios necesarios para realizar consultas JOIN entre dos bases de datos diferentes:
- `sistema_cursos` (o `u881364944_cursos` en producción)
- `sistema_institucional` (o `u881364944_sistema_inst` en producción)

Esto causaba errores en consultas como:
```sql
SELECT c.*, e.alias 
FROM capacitaciones c
LEFT JOIN sistema_institucional.equipos e ON c.equipo_id = e.id_equipo
```

## Solución Implementada

### Estrategia: Consultas Separadas + Combinación en PHP

En lugar de hacer JOIN a nivel de SQL, ahora:

1. **Primera consulta**: Obtener datos de `sistema_cursos`
2. **Segunda consulta**: Obtener datos de `sistema_institucional` 
3. **Combinación en PHP**: Hacer el "JOIN" manualmente usando arrays

### Ventajas

✅ **No requiere privilegios especiales** - Cada consulta se ejecuta en su propia base de datos  
✅ **Eficiente** - Solo 2 consultas en total (no una por cada registro)  
✅ **Rápido** - PHP puede hacer el matching muy rápido con arrays asociativos  
✅ **Mantenible** - Código más claro y fácil de debuggear  

### Ejemplo de Implementación

#### Antes (con JOIN cross-database):
```php
public function getCapacitacionesDisponibles() {
    $sql = "
        SELECT c.*, e.alias AS equipo_nombre
        FROM capacitaciones c
        LEFT JOIN sistema_institucional.equipos e 
            ON c.equipo_id = e.id_equipo
        WHERE c.esta_publicada = 1
    ";
    
    $stmt = $this->dbCourses->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
```

#### Después (con consultas separadas):
```php
public function getCapacitacionesDisponibles() {
    // 1. Obtener capacitaciones
    $sql = "
        SELECT c.*
        FROM capacitaciones c
        WHERE c.esta_publicada = 1
    ";
    
    $stmt = $this->dbCourses->prepare($sql);
    $stmt->execute();
    $capacitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($capacitaciones)) {
        return [];
    }
    
    // 2. Extraer IDs únicos de equipos
    $equipoIds = array_unique(array_column($capacitaciones, 'equipo_id'));
    $equipoIds = array_filter($equipoIds); // Remover nulls
    
    // 3. Obtener información de equipos
    $equipos = $this->getEquiposByIds($equipoIds);
    
    // 4. Combinar datos (JOIN en PHP)
    foreach ($capacitaciones as &$capacitacion) {
        $equipoId = $capacitacion['equipo_id'];
        $capacitacion['equipo_nombre'] = $equipos[$equipoId] ?? 'Sin equipo';
    }
    
    return $capacitaciones;
}
```

### Método Helper: getEquiposByIds()

Este método centraliza la lógica de obtener equipos desde la BD principal:

```php
private function getEquiposByIds($equipoIds) {
    if (empty($equipoIds)) {
        return [];
    }
    
    // Crear placeholders para consulta IN
    $placeholders = implode(',', array_fill(0, count($equipoIds), '?'));
    
    $sql = "
        SELECT id_equipo, alias
        FROM equipos
        WHERE id_equipo IN ($placeholders)
          AND estado = 'habilitado'
          AND borrado = 0
    ";
    
    $stmt = $this->dbMain->prepare($sql);
    $stmt->execute(array_values($equipoIds));
    
    // Retornar array asociativo [id_equipo => alias]
    $equipos = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $equipos[$row['id_equipo']] = $row['alias'];
    }
    
    return $equipos;
}
```

## Métodos Refactorizados

Todos estos métodos fueron actualizados para usar la nueva estrategia:

1. ✅ `getCapacitacionesDestacadas()`
2. ✅ `getCapacitacionesDisponibles()`
3. ✅ `buscarCapacitacionesGlobal()`
4. ✅ `buscarCapacitaciones()`
5. ✅ `getEquiposConCapacitaciones()`
6. ✅ `getCapacitacionCompleta()`

## Rendimiento

### Comparación de Consultas

**Antes (con JOIN):**
- 1 consulta compleja con JOIN cross-database
- Requiere privilegios especiales
- Puede ser bloqueada por el host

**Después (consultas separadas):**
- 2 consultas simples (una por BD)
- Sin privilegios especiales
- Siempre funciona

### Ejemplo con 50 capacitaciones y 10 equipos únicos:

**Antes:**
- 1 consulta JOIN → 50 filas retornadas

**Después:**
- 1 consulta capacitaciones → 50 filas
- 1 consulta equipos → 10 filas
- Combinación en PHP → O(n) muy rápido

**Resultado:** Prácticamente el mismo rendimiento, sin restricciones de privilegios.

## Notas Técnicas

### Array Asociativo para Lookup Rápido

El método `getEquiposByIds()` retorna un array asociativo:
```php
[
    1 => 'Equipo A',
    2 => 'Equipo B',
    5 => 'Equipo C'
]
```

Esto permite lookup O(1) al combinar datos:
```php
$capacitacion['equipo_nombre'] = $equipos[$equipoId] ?? 'Sin equipo';
```

### Manejo de Nulls

Si una capacitación no tiene `equipo_id`, se asigna 'Sin equipo':
```php
$capacitacion['equipo_nombre'] = $equipos[$equipoId] ?? 'Sin equipo';
```

### Prepared Statements con IN

Para consultas con múltiples IDs, se usan placeholders dinámicos:
```php
$placeholders = implode(',', array_fill(0, count($equipoIds), '?'));
// Resultado: "?,?,?,?" para 4 IDs
```

## Conclusión

Esta solución es **más robusta y portable** que la anterior. Funciona en cualquier entorno sin necesidad de configuraciones especiales de privilegios de base de datos.
