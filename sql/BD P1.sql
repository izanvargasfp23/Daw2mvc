CREATE DATABASE IF NOT EXISTS daw2mvc
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
use daw2mvc;

-- 1. TABLA USUARIOS
CREATE TABLE `usuarios` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `telefono` VARCHAR(20),
  `direccion` VARCHAR(255),
  `fecha_nacimiento` DATE,
  `rol` VARCHAR(20) NOT NULL DEFAULT 'usuario' COMMENT 'Valores: usuario, admin',
  `fecha_registro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- 2. TABLA CATEGORIAS
CREATE TABLE `categorias` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(100) UNIQUE NOT NULL,
  `descripcion` TEXT,
  `activa` BOOLEAN NOT NULL DEFAULT TRUE
);

-- 3. TABLA PRODUCTOS (Platos individuales y Bebidas)
CREATE TABLE `productos` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `categoria_id` INT NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `descripcion` TEXT,
  `precio` DECIMAL(10,2) NOT NULL,
  `imagen` VARCHAR(255),
  `activo` BOOLEAN NOT NULL DEFAULT TRUE,
  CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE
);

-- 4. TABLA ALÉRGENOS
CREATE TABLE `alergenos` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(100) UNIQUE NOT NULL,
  `icono` VARCHAR(255)
);

-- 5. TABLA INTERMEDIA PRODUCTO_ALERGENO
CREATE TABLE `producto_alergeno` (
  `producto_id` INT NOT NULL,
  `alergeno_id` INT NOT NULL,
  PRIMARY KEY (`producto_id`, `alergeno_id`),
  CONSTRAINT `fk_pa_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pa_alergeno` FOREIGN KEY (`alergeno_id`) REFERENCES `alergenos` (`id`) ON DELETE CASCADE
);

-- 6. TABLA MENUS (Exclusiva para Menús Tácticos)
CREATE TABLE `menus` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `descripcion` TEXT,
  `precio` DECIMAL(10,2) NOT NULL,
  `imagen` VARCHAR(255),
  `activo` BOOLEAN NOT NULL DEFAULT TRUE
);

-- 7. TABLA INTERMEDIA MENU_PRODUCTO (Relaciona los menús con los productos)
CREATE TABLE `menu_producto` (
  `menu_id` INT NOT NULL,
  `producto_id` INT NOT NULL,
  `tipo_plato` ENUM('PRIMERO', 'SEGUNDO', 'POSTRE', 'BEBIDA') NOT NULL,
  PRIMARY KEY (`menu_id`, `producto_id`, `tipo_plato`),
  CONSTRAINT `fk_mp_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_mp_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
);

-- 8. TABLA INGREDIENTES
CREATE TABLE `ingredientes` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(100) UNIQUE NOT NULL,
  `precio_extra` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `activo` BOOLEAN NOT NULL DEFAULT TRUE
);

-- 9. TABLA INTERMEDIA PRODUCTO_INGREDIENTE
CREATE TABLE `producto_ingrediente` (
  `producto_id` INT NOT NULL,
  `ingrediente_id` INT NOT NULL,
  `cantidad` DECIMAL(10,2) NOT NULL DEFAULT 1.00,
  PRIMARY KEY (`producto_id`, `ingrediente_id`),
  CONSTRAINT `fk_pi_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pi_ingrediente` FOREIGN KEY (`ingrediente_id`) REFERENCES `ingredientes` (`id`) ON DELETE CASCADE
);

-- 10. TABLA OFERTAS
CREATE TABLE `ofertas` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `descripcion` TEXT,
  `tipo` VARCHAR(20) NOT NULL COMMENT 'Valores: descuento, 2x1, combo, codigo',
  `valor` DECIMAL(10,2),
  `codigo` VARCHAR(50) UNIQUE,
  `fecha_inicio` DATETIME NOT NULL,
  `fecha_fin` DATETIME,
  `activa` BOOLEAN NOT NULL DEFAULT TRUE
);

-- 11. TABLA OFERTA_PRODUCTO
CREATE TABLE `oferta_producto` (
  `oferta_id` INT NOT NULL,
  `producto_id` INT NOT NULL,
  PRIMARY KEY (`oferta_id`, `producto_id`),
  CONSTRAINT `fk_op_oferta` FOREIGN KEY (`oferta_id`) REFERENCES `ofertas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_op_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
);

-- 12. TABLA PEDIDOS
CREATE TABLE `pedidos` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `estado` VARCHAR(20) NOT NULL DEFAULT 'pendiente' COMMENT 'Valores: pendiente, confirmado, preparando, enviado, entregado, cancelado',
  `fecha_pedido` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subtotal` DECIMAL(10,2) NOT NULL,
  `descuento` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `total` DECIMAL(10,2) NOT NULL,
  `metodo_pago` VARCHAR(50) NOT NULL DEFAULT 'simulado',
  `estado_pago` VARCHAR(20) NOT NULL DEFAULT 'pendiente' COMMENT 'Valores: pendiente, pagado, fallido',
  CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
);

-- 13. TABLA PEDIDO_DETALLE
CREATE TABLE `pedido_detalle` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `pedido_id` INT NOT NULL,
  `producto_id` INT NULL,
  `nombre_producto` VARCHAR(150) NOT NULL,
  `precio_unitario` DECIMAL(10,2) NOT NULL,
  `cantidad` INT NOT NULL CHECK (`cantidad` > 0),
  `subtotal` DECIMAL(10,2) NOT NULL CHECK (`subtotal` >= 0),
  CONSTRAINT `fk_pd_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pd_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL
);

-- 14. TABLA PEDIDO_DETALLE_INGREDIENTE
CREATE TABLE `pedido_detalle_ingrediente` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `pedido_detalle_id` INT NOT NULL,
  `ingrediente_id` INT NULL,
  `nombre_ingrediente` VARCHAR(100) NOT NULL,
  `precio_extra` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `accion` VARCHAR(20) NOT NULL COMMENT 'Valores: incluido, quitado, añadido',
  CONSTRAINT `fk_pdi_detalle` FOREIGN KEY (`pedido_detalle_id`) REFERENCES `pedido_detalle` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pdi_ingrediente` FOREIGN KEY (`ingrediente_id`) REFERENCES `ingredientes` (`id`) ON DELETE SET NULL
);

-- -----------------------------------------------------
-- INSERCIÓN DE DATOS INICIALES
-- -----------------------------------------------------

-- 1. Categorías
INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'ENTRANTES'),
(2, 'PRIMEROS'),
(3, 'SEGUNDOS'),
(4, 'POSTRES'),
(5, 'BEBIDAS')
ON DUPLICATE KEY UPDATE `nombre` = VALUES(`nombre`);

-- 2. Alérgenos con archivos SVG asignados
INSERT INTO `alergenos` (`id`, `nombre`, `icono`) VALUES
(1, 'Gluten', 'sin-gluten.svg'),
(2, 'Lácteos', 'libre-de-lacteos.svg'),
(3, 'Huevos', 'huevos.svg'),
(4, 'Pescado', 'pescado.svg'),
(5, 'Cacahuetes', 'mani.svg'),
(6, 'Sésamo', 'sesamo.svg'),
(7, 'Sulfitos', 'sulfito.svg'),
(8, 'Moluscos', 'moluscos.svg')
ON DUPLICATE KEY UPDATE `nombre` = VALUES(`nombre`), `icono` = VALUES(`icono`);

-- 3. Productos (Platos individuales y Bebidas)
INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `imagen`, `activo`) VALUES
-- Entrantes (Cat 1)
(1, 1, 'BURBUJA DE BARRICADA', 'Caprese Táctica: Queso mozzarella fresco con tomates confitados sobre cama verde y toque aromático bajo campana de humo.', 8.50, 'burbuja_barricada.jpg', 1),
(2, 1, 'FUEGO FATUO', 'Bruschetta Calabresa de masa madre con nduja picante, ricota cremosa y hilo de miel. Agente: Phoenix.', 9.00, 'fuego_fatuo.jpg', 1),
(3, 1, 'DARDO REVELADOR', 'Arancini crujientes rellenos de risotto de trufa negra, champiñones y queso Fontina fundido. Servidos con alioli de trufa helado. Agente: Sova.', 9.50, 'dardo_revelador.jpg', 1),
(4, 1, 'BURRATA AHUMADA DE LA SOMBRA', 'Burrata fresca ahumada al momento con trufa negra, tostas crujientes y gotas de aceite. Inspiración: Omen.', 12.00, 'burrata_sombra.jpg', 1),

-- Primeros (Cat 2)
(5, 2, 'BOWL DE MARISCO ORBITAL', 'Frescos mejillones del Pacífico salteados con toque especiado de curry tailandés, leche de coco y virutas de hierba de limón.', 11.50, 'bowl_marisco.jpg', 1),
(6, 2, 'CORTE DE VIENTO', 'Lomo de salmón fresco marcado a la plancha sobre cama de cuscús de verduras y suave salsa de cítricos.', 12.00, 'corte_viento.jpg', 1),
(7, 2, 'LLAMADA DEL VENENO', 'Pasta fresca en espiral con pesto de albahaca casero, piñones tostados, perlas de queso de cabra y virutas de tomate deshidratado.', 10.50, 'llamada_veneno.jpg', 1),
(8, 2, 'BOCADO IMPERIAL', 'Jugoso estofado de ternera marinada en cerveza negra y especias montado sobre puré de patata estilo Robuchon.', 11.00, 'bocado_imperial.jpg', 1),

-- Segundos (Cat 3)
(9, 3, 'TIRO DE GRACIA', 'Corte de vacuno mayor madurado a la parrilla con acabado en láminas de oro comestible de 24k, sal escamada y una elegante reducción de Chianti Classico.', 22.00, 'tiro_gracia.jpg', 1),
(10, 3, 'SALTO TÁCTICO', 'Jarrete de ternera tierno cocinado a fuego lento en salsa de tomate picante y vino tinto, servido sobre cremoso risotto al azafrán con crujiente de gremolata cítrica y un toque chispeante de guindilla.', 21.00, 'salto_tactico.jpg', 1),
(11, 3, 'PESADILLA NOCTURNA', 'Lomo de atún rojo marcado a la sellada con costra de sésamo negro, sobre puré suave de boniato morado, reducción de aceto balsámico envejecido y aire de tinta de sepia.', 20.50, 'pesadilla_nocturna.jpg', 1),
(12, 3, 'IMPACTO DE FUEGO', 'Masa artesanal de fermentación lenta de 48 horas, base de tomate San Marzano, mozzarella fior di latte, salame picante napolitano, hilos de chile rojo fresco y aceite infusionado en guindilla ahumada.', 17.00, 'impacto_fuego.jpg', 1),

-- Postres (Cat 4)
(13, 4, 'INFILTRACIÓN GELATA', 'Affogato al caffè con gelato di pistacchio artesanal, acompañado de galleta cantucci y shot de espresso hirviendo. Agente: Yoru.', 8.00, 'infiltracion_gelata.jpg', 1),
(14, 4, 'FORMA ASTRAL', 'Panna cotta infusionada con vainilla bourbon y menta fresca, bañada en gelificada de moras carnosas y soplo azul. Agente: Astra.', 8.50, 'forma_astral.jpg', 1),
(15, 4, 'RED DE ESPÍAS', 'Crujiente cannoli siciliano frito relleno de ricotta dulce de oveja, chips de chocolate negro al 70% y pistacho soplado dorado. Agente: Cypher.', 9.00, 'red_espias.jpg', 1),
(16, 4, 'BLOQUEO DULCE', 'Capas voluptuosas de bizcocho Savoiardi impregnado en espresso concentrado y licor Amaretto, crema de mascarpone y micro-crujientes de avellana. Agente: Killjoy.', 9.50, 'bloqueo_dulce.jpg', 1),

-- Bebidas (Cat 5)
(17, 5, 'RADIANTE ENERGY DRINK', 'Bebida energética artesanal infusionada con frutas del bosque y toque cítrico.', 4.50, 'radiante_energy.jpg', 1),
(18, 5, 'VINO DE LA CASA O AGUA', 'Copa de vino tinto de la casa o agua mineral embotellada.', 3.50, 'vino_agua.jpg', 1),
(19, 5, 'CERVEZA O AGUA DE JADE', 'Cerveza artesanal de tirador o agua purificada de jade.', 4.00, 'cerveza_jade.jpg', 1);

-- 4. Relación Producto -> Alérgenos (producto_alergeno)
INSERT INTO `producto_alergeno` (`producto_id`, `alergeno_id`) VALUES
-- Burbuja de Barricada: Lácteos
(1, 2),
-- Fuego Fatuo: Gluten, Lácteos
(2, 1), (2, 2),
-- Dardo Revelador: Gluten, Lácteos, Huevos
(3, 1), (3, 2), (3, 3),
-- Burrata Ahumada de la Sombra: Gluten, Lácteos
(4, 1), (4, 2),
-- Bowl de Marisco Orbital: Moluscos
(5, 8),
-- Corte de Viento: Gluten, Pescado
(6, 1), (6, 4),
-- Llamada del Veneno: Gluten, Lácteos
(7, 1), (7, 2),
-- Bocado Imperial: Gluten, Lácteos
(8, 1), (8, 2),
-- Tiro de Gracia: Sulfitos
(9, 7),
-- Salto Táctico: Lácteos, Sulfitos
(10, 2), (10, 7),
-- Pesadilla Nocturna: Pescado, Sésamo, Sulfitos, Moluscos
(11, 4), (11, 6), (11, 7), (11, 8),
-- Impacto de Fuego: Gluten, Lácteos
(12, 1), (12, 2),
-- Infiltración Gelata: Gluten, Lácteos, Huevos
(13, 1), (13, 2), (13, 3),
-- Forma Astral: Lácteos
(14, 2),
-- Red de Espías: Gluten, Lácteos
(15, 1), (15, 2),
-- Bloqueo Dulce: Gluten, Lácteos, Huevos
(16, 1), (16, 2), (16, 3),
-- Cerveza o Agua de Jade: Gluten
(19, 1);

-- 5. Menús (Tabla `menus`)
INSERT INTO `menus` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `activo`) VALUES
(1, 'RUN IT BACK', 'Menú táctico inspirado en Phoenix.', 43.50, 'menu_run_it_back.jpg', 1),
(2, 'RECON BOLT', 'Menú de precisión inspirado en Sova.', 36.00, 'menu_recon_bolt.jpg', 1),
(3, 'RESURRECTION', 'Menú de equilibrio inspirado en Sage.', 39.50, 'menu_resurrection.jpg', 1);

-- 6. Relación Menú -> Productos (menu_producto)
INSERT INTO `menu_producto` (`menu_id`, `producto_id`, `tipo_plato`) VALUES
-- RUN IT BACK (Menu ID 1)
(1, 12, 'PRIMERO'), -- IMPACTO DE FUEGO (Pizza Diávola)
(1, 9,  'SEGUNDO'), -- TIRO DE GRACIA (Bistecca con oro)
(1, 16, 'POSTRE'),  -- BLOQUEO DULCE (Tiramisú)
(1, 17, 'BEBIDA'),  -- RADIANTE ENERGY DRINK

-- RECON BOLT (Menu ID 2)
(2, 3,  'PRIMERO'), -- DARDO REVELADOR (Arancini / Carpaccio)
(2, 11, 'SEGUNDO'), -- PESADILLA NOCTURNA (Atún rojo)
(2, 13, 'POSTRE'),  -- INFILTRACIÓN GELATA (Affogato)
(2, 18, 'BEBIDA'),  -- VINO DE LA CASA O AGUA

-- RESURRECTION (Menu ID 3)
(3, 1,  'PRIMERO'), -- BURBUJA DE BARRICADA (Caprese)
(3, 9,  'SEGUNDO'), -- TIRO DE GRACIA (Chuletón 24K)
(3, 14, 'POSTRE'),  -- FORMA ASTRAL (Panna Cotta)
(3, 19, 'BEBIDA');  -- CERVEZA O AGUA DE JADE

-- 7. Catálogo de Ingredientes
INSERT INTO `ingredientes` (`id`, `nombre`, `precio_extra`, `activo`) VALUES
(1, 'Queso Mozzarella Fresco', 1.50, 1),
(2, 'Tomates Confitados', 1.00, 1),
(3, 'Nduja Picante Calabresa', 2.00, 1),
(4, 'Ricotta Cremosa', 1.20, 1),
(5, 'Trufa Negra', 2.50, 1),
(6, 'Queso Fontina', 1.50, 1),
(7, 'Burrata Fresca', 3.00, 1),
(8, 'Mejillones del Pacífico', 2.50, 1),
(9, 'Salsa Curry Tailandés', 1.00, 1),
(10, 'Lomo de Salmón Fresco', 4.00, 1),
(11, 'Cuscús de Verduras', 1.50, 1),
(12, 'Pesto de Albahaca Casero', 1.20, 1),
(13, 'Queso de Cabra', 1.50, 1),
(14, 'Estofado de Ternera', 3.50, 1),
(15, 'Puré de Patata Robuchon', 1.50, 1),
(16, 'Corte de Vacuno Madurado', 6.00, 1),
(17, 'Láminas de Oro 24K', 5.00, 1),
(18, 'Jarrete de Ternera', 4.50, 1),
(19, 'Risotto al Azafrán', 2.00, 1),
(20, 'Lomo de Atún Rojo', 5.00, 1),
(21, 'Sésamo Negro', 0.80, 1),
(22, 'Puré de Boniato Morado', 1.50, 1),
(23, 'Salame Picante Napolitano', 2.00, 1),
(24, 'Masa Madre Artesanal', 1.50, 1),
(25, 'Gelato di Pistacchio', 1.80, 1),
(26, 'Shot de Espresso', 1.00, 1),
(27, 'Panna Cotta Vainilla Bourbon', 1.50, 1),
(28, 'Cannoli Siciliano', 1.50, 1),
(29, 'Chips Chocolate 70%', 1.00, 1),
(30, 'Bizcocho Savoiardi', 1.00, 1),
(31, 'Crema Mascarpone', 1.50, 1),
(32, 'Frutas del Bosque', 1.00, 1),
(33, 'Vino Tinto de la Casa', 2.00, 1),
(34, 'Cerveza Artesanal', 2.00, 1);

-- 8. Inserción de Ingredientes por Producto (producto_ingrediente)
INSERT INTO `producto_ingrediente` (`producto_id`, `ingrediente_id`, `cantidad`) VALUES
-- Burbuja de Barricada (1)
(1, 1, 1.00), (1, 2, 1.00),
-- Fuego Fatuo (2)
(2, 3, 1.00), (2, 4, 1.00), (2, 24, 1.00),
-- Dardo Revelador (3)
(3, 5, 1.00), (3, 6, 1.00),
-- Burrata Ahumada de la Sombra (4)
(4, 7, 1.00), (4, 5, 1.00),
-- Bowl de Marisco Orbital (5)
(5, 8, 1.00), (5, 9, 1.00),
-- Corte de Viento (6)
(6, 10, 1.00), (6, 11, 1.00),
-- Llamada del Veneno (7)
(7, 12, 1.00), (7, 13, 1.00),
-- Bocado Imperial (8)
(8, 14, 1.00), (8, 15, 1.00),
-- Tiro de Gracia (9)
(9, 16, 1.00), (9, 17, 1.00),
-- Salto Táctico (10)
(10, 18, 1.00), (10, 19, 1.00),
-- Pesadilla Nocturna (11)
(11, 20, 1.00), (11, 21, 1.00), (11, 22, 1.00),
-- Impacto de Fuego (12)
(12, 23, 1.00), (12, 1, 1.00), (12, 24, 1.00),
-- Infiltración Gelata (13)
(13, 25, 1.00), (13, 26, 1.00),
-- Forma Astral (14)
(14, 27, 1.00), (14, 32, 1.00),
-- Red de Espías (15)
(15, 28, 1.00), (15, 4, 1.00), (15, 29, 1.00),
-- Bloqueo Dulce (16)
(16, 30, 1.00), (16, 31, 1.00), (16, 26, 1.00),
-- Radiante Energy Drink (17)
(17, 32, 1.00),
-- Vino de la Casa o Agua (18)
(18, 33, 1.00),
-- Cerveza o Agua de Jade (19)
(19, 34, 1.00);