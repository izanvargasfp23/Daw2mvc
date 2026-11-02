CREATE TABLE `usuarios` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20),
  `direccion` varchar(255),
  `fecha_nacimiento` date,
  `rol` varchar(20) NOT NULL DEFAULT 'usuario' COMMENT 'Valores: usuario, admin',
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `categorias` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` text,
  `activa` boolean NOT NULL DEFAULT true
);

CREATE TABLE `productos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `categoria_id` int NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255),
  `activo` boolean NOT NULL DEFAULT true
);

CREATE TABLE `ingredientes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `precio_extra` decimal(10,2) NOT NULL DEFAULT 0,
  `activo` boolean NOT NULL DEFAULT true
);

CREATE TABLE `producto_ingrediente` (
  `producto_id` int NOT NULL,
  `ingrediente_id` int NOT NULL,
  `cantidad` decimal(10,2) NOT NULL DEFAULT 1,
  PRIMARY KEY (`producto_id`, `ingrediente_id`)
);

CREATE TABLE `ofertas` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text,
  `tipo` varchar(20) NOT NULL COMMENT 'Valores: descuento, 2x1, combo, codigo',
  `valor` decimal(10,2),
  `codigo` varchar(50) UNIQUE,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime,
  `activa` boolean NOT NULL DEFAULT true
);

CREATE TABLE `oferta_producto` (
  `oferta_id` int NOT NULL,
  `producto_id` int NOT NULL,
  PRIMARY KEY (`oferta_id`, `producto_id`)
);

CREATE TABLE `pedidos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'pendiente' COMMENT 'Valores: pendiente, confirmado, preparando, enviado, entregado, cancelado',
  `fecha_pedido` datetime NOT NULL DEFAULT (CURRENT_TIMESTAMP),
  `subtotal` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT 0,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL DEFAULT 'simulado',
  `estado_pago` varchar(20) NOT NULL DEFAULT 'pendiente' COMMENT 'Valores: pendiente, pagado, fallido'
);

CREATE TABLE `pedido_detalle` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `pedido_id` int NOT NULL,
  `producto_id` int,
  `nombre_producto` varchar(150) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `cantidad` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL COMMENT 'CHECK cantidad > 0 y precio_unitario >= 0'
);

CREATE TABLE `pedido_detalle_ingrediente` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `pedido_detalle_id` int NOT NULL,
  `ingrediente_id` int,
  `nombre_ingrediente` varchar(100) NOT NULL,
  `precio_extra` decimal(10,2) NOT NULL DEFAULT 0,
  `accion` varchar(20) NOT NULL COMMENT 'Valores: incluido, quitado, añadido'
);

ALTER TABLE `productos` ADD FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

ALTER TABLE `producto_ingrediente` ADD FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

ALTER TABLE `producto_ingrediente` ADD FOREIGN KEY (`ingrediente_id`) REFERENCES `ingredientes` (`id`);

ALTER TABLE `oferta_producto` ADD FOREIGN KEY (`oferta_id`) REFERENCES `ofertas` (`id`);

ALTER TABLE `oferta_producto` ADD FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

ALTER TABLE `pedidos` ADD FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

ALTER TABLE `pedido_detalle` ADD FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

ALTER TABLE `pedido_detalle` ADD FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

ALTER TABLE `pedido_detalle_ingrediente` ADD FOREIGN KEY (`pedido_detalle_id`) REFERENCES `pedido_detalle` (`id`);

ALTER TABLE `pedido_detalle_ingrediente` ADD FOREIGN KEY (`ingrediente_id`) REFERENCES `ingredientes` (`id`);

-- 1. Insertar o asegurar las categorías
INSERT INTO categorias (id, nombre) VALUES
(1, 'ENTRANTES'),
(2, 'PRIMEROS'),
(3, 'SEGUNDOS'),
(4, 'POSTRES'),
(5, 'MENUS')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- 2. Insertar todos los productos
INSERT INTO productos (categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
(1, 'BURBUJA DE BARRICADA', 'Caprese Táctica: Queso mozzarella fresco con tomates confitados sobre cama verde y toque aromático bajo campana de humo.', 8.50, 'burbuja_barricada.jpg', 1),
(1, 'FUEGO FATUO', 'Bruschetta Calabresa de masa madre con nduja picante, ricota cremosa y hilo de miel. Agente: Phoenix.', 9.00, 'fuego_fatuo.jpg', 1),
(1, 'DARDO REVELADOR', 'Arancini crujientes rellenos de risotto de trufa negra, champiñones y queso Fontina fundido. Servidos con alioli de trufa helado. Agente: Sova.', 9.50, 'dardo_revelador.jpg', 1),
(1, 'BURRATA AHUMADA DE LA SOMBRA', 'Burrata fresca ahumada al momento con trufa negra, tostas crujientes y gotas de aceite. Inspiración: Omen.', 12.00, 'burrata_sombra.jpg', 1),
(2, 'BOWL DE MARISCO ORBITAL', 'Frescos mejillones del Pacífico salteados con toque especiado de curry tailandés, leche de coco y virutas de hierba de limón.', 11.50, 'bowl_marisco.jpg', 1),
(2, 'CORTE DE VIENTO', 'Lomo de salmón fresco marcado a la plancha sobre cama de cuscús de verduras y suave salsa de cítricos.', 12.00, 'corte_viento.jpg', 1),
(2, 'LLAMADA DEL VENENO', 'Pasta fresca en espiral con pesto de albahaca casero, piñones tostados, perlas de queso de cabra y virutas de tomate deshidratado.', 10.50, 'llamada_veneno.jpg', 1),
(2, 'BOCADO IMPERIAL', 'Jugoso estofado de ternera marinada en cerveza negra y especias montado sobre puré de patata estilo Robuchon.', 11.00, 'bocado_imperial.jpg', 1),
(3, 'TIRO DE GRACIA', 'Corte de vacuno mayor madurado a la parrilla con acabado en láminas de oro comestible de 24k, sal escamada y una elegante reducción de Chianti Classico.', 22.00, 'tiro_gracia.jpg', 1),
(3, 'SALTO TÁCTICO', 'Jarrete de ternera tierno cocinado a fuego lento en salsa de tomate picante y vino tinto, servido sobre cremoso risotto al azafrán con crujiente de gremolata cítrica y un toque chispeante de guindilla.', 21.00, 'salto_tactico.jpg', 1),
(3, 'PESADILLA NOCTURNA', 'Lomo de atún rojo marcado a la sellada con costra de sésamo negro, sobre puré suave de boniato morado, reducción de aceto balsámico envejecido y aire de tinta de sepia.', 20.50, 'pesadilla_nocturna.jpg', 1),
(3, 'IMPACTO DE FUEGO', 'Masa artesanal de fermentación lenta de 48 horas, base de tomate San Marzano, mozzarella fior di latte, salame picante napolitano, hilos de chile rojo fresco y aceite infusionado en guindilla ahumada.', 17.00, 'impacto_fuego.jpg', 1),
(4, 'INFILTRACIÓN GELATA', 'Affogato al caffè con gelato di pistacchio artesanal, acompañado de galleta cantucci y shot de espresso hirviendo. Agente: Yoru.', 8.00, 'infiltracion_gelata.jpg', 1),
(4, 'FORMA ASTRAL', 'Panna cotta infusionada con vainilla bourbon y menta fresca, bañada en gelificada de moras carnosas y soplo azul. Agente: Astra.', 8.50, 'forma_astral.jpg', 1),
(4, 'RED DE ESPÍAS', 'Crujiente cannoli siciliano frito relleno de ricotta dulce de oveja, chips de chocolate negro al 70% y pistacho soplado dorado. Agente: Cypher.', 9.00, 'red_espias.jpg', 1),
(4, 'BLOQUEO DULCE', 'Capas voluptuosas de bizcocho Savoiardi impregnado en espresso concentrado y licor Amaretto, crema de mascarpone y micro-crujientes de avellana. Agente: Killjoy.', 9.50, 'bloqueo_dulce.jpg', 1),
(5, 'RUN IT BACK', 'Menú táctico inspirado en Phoenix: Pizza Diávola Phoenix, Bistecca alla Fiorentina con oro, Tiramisú y Radiante Energy Drink.', 43.50, 'menu_run_it_back.jpg', 1),
(5, 'RECON BOLT', 'Menú de precisión inspirado en Sova: Carpaccio de ternera, Pesadilla Nocturna (Atún rojo), Nano-enfriamiento y Vino/Agua.', 36.00, 'menu_recon_bolt.jpg', 1),
(5, 'RESURRECTION', 'Menú de equilibrio inspirado en Sage: Ensalada Caprese Táctica, Tiro de Gracia (Chuletón con oro 24k), Nano-enfriamiento y Cerveza/Agua de Jade.', 39.50, 'menu_resurrection.jpg', 1);

