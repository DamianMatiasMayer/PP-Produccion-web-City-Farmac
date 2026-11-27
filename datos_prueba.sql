USE city_farmac;

INSERT INTO categorias (id, nombre, categoria_padre_id, activo) VALUES
(1,'Cuidado personal',NULL,1),
(2,'Dermocosmética',NULL,1),
(3,'Perfumería',NULL,1);

INSERT INTO categorias (id, nombre, categoria_padre_id, activo) VALUES
(4,'Cuidado del cabello',1,1),
(5,'Cuidado facial',1,1),
(6,'Higiene personal',1,1),
(7,'Protección solar',2,1),
(8,'Tratamiento antiacné',2,1),
(9,'Perfumes',3,1),
(10,'Desodorantes',3,1);

INSERT INTO marcas (id, nombre, activo) VALUES
(1,'Pantene',1),
(2,'Nivea',1),
(3,'La Roche-Posay', 1),
(4,'Rochas',1),
(5,'Rexona',1),
(6,'Dove',1);


INSERT INTO productos (id, nombre, descripcion, modelo, precio, imagen, destacado, activo, categoria_id, marca_id) VALUES
(1,'Shampoo Reparador 400 ml','Shampoo para cabello dañado que repara y fortalece desde la raíz.','Pro-V 400',8500.00,'producto1.png',1,1,4,1),
(2,'Acondicionador Reparador 400 ml','Acondicionador que desenreda y aporta suavidad al cabello dañado.','Pro-V 400',8900.00,'producto1.png',0,1,4,1),
(3,'Shampoo Hidratante 400 ml','Shampoo con micro-suero hidratante para cabello seco.','Nutritive 400',7600.00,'producto1.png',0,1,4,6),
(4,'Crema Hidratante Facial','Crema facial de uso diario con hidratación por 24 horas.','Soft 200',12900.00,'producto2.png',1,1,5,2),
(5,'Agua Micelar 400 ml','Limpia y desmaquilla el rostro sin necesidad de enjuague.','Micellair 400',9800.00,'producto2.png',0,1,5,2),
(6,'Sérum Facial Vitamina C','Sérum antioxidante que unifica el tono y aporta luminosidad.','Pure Vit C10',32000.00,'producto2.png',1,1,5,3),
(7,'Jabón Líquido Neutro','Jabón líquido de pH neutro para todo tipo de piel.','Neutro 250',4100.00,'producto6.png',0,1,6,6),
(8,'Jabón en Barra Original','Jabón en barra con un cuarto de crema humectante.','Original 90',1800.00,'producto6.png',0,1,6,6),
(9,'Crema Corporal Soft','Crema corporal liviana de rápida absorción.','Soft 300',6500.00,'producto6.png',0,0,6,2),
(10,'Protector Solar FPS 50','Protección solar alta para rostro y cuerpo, resistente al agua.','Anthelios 50',24500.00,'producto3.png',1,1,7,3),
(11,'Protector Solar Niños FPS 50','Protector solar especial para la piel sensible de los chicos.','Sun Kids 50',18900.00,'producto3.png',0,1,7,2),
(12,'Protector Solar Facial Toque Seco','Protección facial de textura liviana y acabado mate.','Anthelios Dry',27500.00,'producto3.png',0,1,7,3),
(13,'Gel Limpiador Purificante','Gel de limpieza para piel grasa con tendencia acneica.','Effaclar Gel',21000.00,'producto2.png',0,1,8,3),
(14,'Crema Anti-imperfecciones','Tratamiento que reduce imperfecciones y marcas.','Effaclar Duo',26800.00,'producto2.png',1,0,8,3),
(15,'Perfume Eau de Toilette','Fragancia fresca y floral para uso diario.','Eau de Rochas',58000.00,'producto4.png',0,1,9,4),
(16,'Perfume Eau de Parfum Mujer','Fragancia intensa con notas orientales y de larga duración.','Madame Rochas',72000.00,'producto4.png',1,1,9,4),
(17,'Body Splash Floral','Bruma corporal perfumada de aroma suave.','Splash 200',21500.00,'producto4.png',0,1,9,4),
(18,'Desodorante Roll-on','Desodorante roll-on con protección de 48 horas.','Clinical 50',3200.00,'producto5.png',0,0,10,5),
(19,'Desodorante Aerosol Men','Antitranspirante en aerosol con protección prolongada.','Men V8 150',3900.00,'producto5.png',0,1,10,5),
(20,'Antitranspirante Original','Antitranspirante con crema humectante que cuida la piel.','Original 150',3600.00,'producto5.png',0,1,10,6);


INSERT INTO comentarios (id, producto_id, email, comentario, ranking, ip, aprobado, fecha_creacion) VALUES
(1,1,'lucia.gomez@mail.com','Me dejó el pelo suave y sin frizz. Lo recomiendo.',5,'192.168.0.10',1,'2026-10-01 10:15:00'),
(2,1,'martin.perez@mail.com','Muy bueno, aunque el envase podría ser más grande.',4,'192.168.0.11',1,'2026-10-02 18:40:00'),
(3,1,'sofia.ruiz@mail.com','No noté mucha diferencia con otros shampoo.',3,'192.168.0.12',0,'2026-10-05 09:05:00'),
(4,2,'carla.diaz@mail.com','Combina perfecto con el shampoo de la misma línea.',5,'192.168.0.13',1,'2026-10-03 14:20:00'),
(5,3,'juan.lopez@mail.com','Buen producto para pelo seco.',4,'192.168.0.14',1,'2026-10-04 11:30:00'),
(6,4,'ana.fernandez@mail.com','Hidrata muchísimo y no deja la piel grasa.',5,'192.168.0.15',1,'2026-10-06 08:50:00'),
(7,4,'diego.sosa@mail.com','La uso todos los días, excelente.',5,'192.168.0.16',1,'2026-10-07 21:10:00'),
(8,4,'paula.romero@mail.com','Me dio un poco de picazón.',2,'192.168.0.17',0,'2026-10-08 16:25:00'),
(9,5,'nicolas.alvarez@mail.com','Desmaquilla bien y no irrita los ojos.',4,'192.168.0.18',1,'2026-10-09 12:00:00'),
(10,6,'valentina.torres@mail.com','Se nota la piel más luminosa en pocas semanas.',5,'192.168.0.19',1,'2026-10-10 19:45:00'),
(11,6,'lucas.medina@mail.com','Caro, pero vale la pena.',4,'192.168.0.20',1,'2026-10-11 10:35:00'),
(12,6,'camila.castro@mail.com','Excelente sérum, ya voy por el segundo.',5,'192.168.0.21',0,'2026-10-12 15:15:00'),
(13,7,'federico.ramos@mail.com','Suave y rinde mucho.',4,'192.168.0.22',1,'2026-10-13 09:55:00'),
(14,8,'julieta.herrera@mail.com','Clásico de siempre, nunca falla.',4,'192.168.0.23',1,'2026-10-14 13:05:00'),
(15,9,'tomas.molina@mail.com','Muy liviana, se absorbe rápido.',4,'192.168.0.24',1,'2026-10-15 17:30:00'),
(16,10,'agustina.silva@mail.com','El mejor protector que probé, no deja la piel blanca.',5,'192.168.0.25',1,'2026-10-16 11:20:00'),
(17,10,'mateo.rojas@mail.com','Ideal para la playa, resiste el agua.',5,'192.168.0.26',1,'2026-10-17 08:10:00'),
(18,10,'florencia.vega@mail.com','Un poco espeso, pero protege bien.',4,'192.168.0.27',0,'2026-10-18 20:00:00'),
(19,11,'santiago.nunez@mail.com','Lo uso con mis hijos y ninguno tuvo reacción.',5,'192.168.0.28',1,'2026-10-19 10:40:00'),
(20,12,'micaela.ortiz@mail.com','Perfecto para piel grasa, queda mate.',4,'192.168.0.29',1,'2026-10-20 14:50:00'),
(21,13,'bruno.gimenez@mail.com','Me ayudó a controlar los granitos.',4,'192.168.0.30',1,'2026-10-21 09:15:00'),
(22,13,'rocio.morales@mail.com','Me resecó un poco la piel.',2,'192.168.0.31',0,'2026-10-22 18:05:00'),
(23,14,'ignacio.paz@mail.com','Funciona, pero tarda en verse el resultado.',3,'192.168.0.32',0,'2026-10-23 12:45:00'),
(24,15,'milagros.acosta@mail.com','Aroma fresco, ideal para el verano.',4,'192.168.0.33',1,'2026-10-24 16:00:00'),
(25,16,'emilia.benitez@mail.com','Me encanta, dura todo el día.',5,'192.168.0.34',1,'2026-10-25 21:30:00'),
(26,16,'joaquin.suarez@mail.com','Se lo regalé a mi novia y le fascinó.',5,'192.168.0.35',0,'2026-10-26 11:10:00'),
(27,17,'brenda.luna@mail.com','El olor dura poco.',2,'192.168.0.36',0,'2026-10-27 08:35:00'),
(28,18,'gaston.cabrera@mail.com','Protege bien pero mancha la ropa.',3,'192.168.0.37',1,'2026-10-28 19:20:00'),
(29,19,'pilar.rios@mail.com','Muy bueno para el gimnasio.',4,'192.168.0.38',1,'2026-10-29 10:05:00'),
(30,20,'lautaro.franco@mail.com','No me gustó el aroma.',1,'192.168.0.39',0,'2026-10-30 15:55:00');