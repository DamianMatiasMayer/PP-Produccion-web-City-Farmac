<?php
// Datos de ejemplo para la vista de detalle (Instancia 1: sin base de datos).
// Se completan con lo que ya trae datosTemporales/productos.php (nombre, marca, precio, imagen).
// La clave de cada array es el id del producto.
// IMPORTANTE: el promedio de las valoraciones de cada producto coincide con el 'ranking'
// cargado en productos.php, así la tarjeta del home y el detalle muestran lo mismo.

$detalles = array(
    1 => array(
        'modelo'      => 'Reparación Total',
        'descripcion' => 'Shampoo reparador de 400 ml para cabello dañado. Ayuda a nutrir la fibra capilar, controlar el frizz y dejar el pelo suave y con brillo desde el primer lavado.',
    ),
    2 => array(
        'modelo'      => 'Hidratación Intensiva',
        'descripcion' => 'Crema hidratante facial de uso diario. Su fórmula rica protege la piel de la sequedad y deja una sensación de suavidad duradera.',
    ),
    3 => array(
        'modelo'      => 'Anthelios',
        'descripcion' => 'Protector solar con FPS 50, de alta protección contra rayos UVA y UVB. De rápida absorción y sin brillo, apto para pieles sensibles.',
    ),
    4 => array(
        'modelo'      => 'Eau de Rochas',
        'descripcion' => 'Eau de toilette de aroma fresco y floral, ideal para uso diario. Presentación con vaporizador.',
    ),
    5 => array(
        'modelo'      => 'Control Inteligente',
        'descripcion' => 'Desodorante antitranspirante en roll-on con protección de hasta 72 horas. Seca rápido y no mancha la ropa.',
    ),
    6 => array(
        'modelo'      => 'Nutrición Profunda',
        'descripcion' => 'Jabón líquido neutro que limpia suavemente mientras hidrata la piel durante la ducha.',
    ),
);

// Solo comentarios APROBADOS (los que el panel marcaría con Aprobar).
$comentarios = array(
    1 => array(
        array('email' => 'ana.gomez@mail.com',   'comentario' => 'Me dejó el pelo muy suave, lo vuelvo a comprar.',     'valoracion' => 5, 'fecha' => '2026-09-12'),
        array('email' => 'lucas.perez@mail.com', 'comentario' => 'Muy buen producto, el aroma es agradable.',         'valoracion' => 5, 'fecha' => '2026-09-20'),
    ),
    2 => array(
        array('email' => 'marta.diaz@mail.com',  'comentario' => 'Hidrata muy bien, rinde bastante.',                    'valoracion' => 4, 'fecha' => '2026-09-05'),
    ),
    3 => array(
        array('email' => 'sofi.ruiz@mail.com',   'comentario' => 'Muy cómodo de aplicar y no deja la cara brillosa.',    'valoracion' => 5, 'fecha' => '2026-09-18'),
        array('email' => 'juan.m@mail.com',      'comentario' => 'Se absorbe rápido y protege muy bien.',                'valoracion' => 5, 'fecha' => '2026-09-25'),
    ),
    4 => array(
        array('email' => 'caro.l@mail.com',      'comentario' => 'Un clásico, perfume liviano y agradable.',             'valoracion' => 4, 'fecha' => '2026-08-30'),
    ),
    5 => array(
        array('email' => 'diego.t@mail.com',     'comentario' => 'Cumple lo que promete, dura todo el día.',             'valoracion' => 3, 'fecha' => '2026-09-02'),
    ),
    6 => array(), // Sin comentarios aprobados: sirve para probar el estado vacío.
);