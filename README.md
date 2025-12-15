# Gilded Rose Kata - PHP

## ¿En qué consiste?

Bienvenido a **Gilded Rose**, una pequeña posada con una ubicación privilegiada en una ciudad prominente, regentada por la amable posadera Allison. También compra y vende mercancías de la mejor calidad. 

Desafortunadamente, los productos van bajando de calidad a medida que se aproxima su fecha de venta. Tienes un sistema que actualiza el inventario automáticamente. Fue desarrollado por un tipo razonable llamado Leeroy, que ahora se dedica a nuevas aventuras. 

Tu tarea es **añadir una nueva funcionalidad** al sistema, pero hay un problema: el código es un desastre de `ifs` anidados que nadie entiende bien. Además, hay un goblin en la esquina que te apuñalará si tocas la clase `Item`.

### El sistema

Cada artículo tiene tres propiedades:
- **name**: Nombre del artículo
- **sellIn**: Días restantes para venderlo
- **quality**: Valor de calidad (0-50)

### Reglas del negocio:

1. Al final de cada día, `sellIn` y `quality` disminuyen
2. Pasada la fecha de venta (`sellIn < 0`), la calidad se degrada el doble de rápido
3. La calidad nunca es negativa ni mayor a 50
4. **"Aged Brie"** incrementa su calidad con el tiempo (mejora como el vino)
5. **"Sulfuras"** nunca cambia (es un artículo legendario)
6. **"Backstage passes"** (pases para conciertos):
   - +2 calidad cuando quedan ≤10 días
   - +3 calidad cuando quedan ≤5 días
   - Calidad = 0 después del concierto (nadie los quiere)

### Tu misión:

Refactorizar el código legacy para que sea mantenible y añadir soporte para artículos **"Conjured"** (conjurados), que degradan su calidad el doble de rápido que los artículos normales.

⚠️ **RESTRICCIÓN: NO modificar la clase `Item`** (el goblin te está vigilando)

## Cómo empezar

```bash
# 1. Clonar y entrar
git clone <url-del-repositorio>
cd gilded-rose-php

# 2. Levantar Docker
docker-compose up -d

# 3. Entrar al contenedor
docker-compose exec php bash

# 4. Comprobar que funciona
php example.php

# 5. Cuando termines
docker-compose down
```
