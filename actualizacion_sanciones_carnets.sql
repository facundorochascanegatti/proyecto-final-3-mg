-- Actualización de la base "liga" para Sanciones y Carnets.
-- Se importa una sola vez en phpMyAdmin (pestaña Importar) o con el ENCENDER del escritorio.

-- Los jugadores tenían todos id = 0: se numeran y el id pasa a ser AUTO_INCREMENT,
-- así cada sanción y cada carnet apunta a un jugador en concreto.
SET @n := 0;
UPDATE jugadores SET id = (@n := @n + 1) ORDER BY cedula;
ALTER TABLE jugadores DROP PRIMARY KEY, ADD PRIMARY KEY (id);
ALTER TABLE jugadores MODIFY id int(11) NOT NULL AUTO_INCREMENT;

-- Tarjetas (amarillas y rojas) de cada jugador
CREATE TABLE IF NOT EXISTS sanciones (
  id int(11) NOT NULL AUTO_INCREMENT,
  id_jugador int(11) NOT NULL,
  tipo enum('Amarilla','Roja') NOT NULL,
  fecha date NOT NULL,
  motivo varchar(150) DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_jugador) REFERENCES jugadores (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Boletines de sanciones en PDF que sube el administrador
CREATE TABLE IF NOT EXISTS boletines (
  id int(11) NOT NULL AUTO_INCREMENT,
  titulo varchar(100) NOT NULL,
  archivo varchar(255) NOT NULL,
  fecha date NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Carnet de aptitud física de cada jugador (uno por jugador, con foto y vencimiento)
CREATE TABLE IF NOT EXISTS carnets (
  id int(11) NOT NULL AUTO_INCREMENT,
  id_jugador int(11) NOT NULL,
  foto varchar(255) NOT NULL,
  fecha_vencimiento date NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY id_jugador (id_jugador),
  FOREIGN KEY (id_jugador) REFERENCES jugadores (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
