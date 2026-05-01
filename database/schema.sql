CREATE DATABASE IF NOT EXISTS eventia_pro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE eventia_pro;

DROP TABLE IF EXISTS event_services;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS quote_items;
DROP TABLE IF EXISTS quotes;
DROP TABLE IF EXISTS accounting_entries;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS clients;

CREATE TABLE clients (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(180) NOT NULL,
    document_type VARCHAR(20) NOT NULL DEFAULT 'NIT',
    document_number VARCHAR(40) NOT NULL,
    contact_name VARCHAR(120) NULL,
    phone VARCHAR(60) NULL,
    email VARCHAR(160) NULL,
    city VARCHAR(90) NULL,
    address VARCHAR(180) NULL,
    segment VARCHAR(80) NOT NULL DEFAULT 'Empresa',
    status VARCHAR(40) NOT NULL DEFAULT 'prospecto',
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY clients_document_unique (document_type, document_number)
) ENGINE=InnoDB;

CREATE TABLE services (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(160) NOT NULL,
    category VARCHAR(90) NOT NULL,
    description TEXT NULL,
    billing_unit ENUM('hora', 'dia', 'evento', 'persona') NOT NULL DEFAULT 'evento',
    price DECIMAL(14,2) NOT NULL DEFAULT 0,
    cost DECIMAL(14,2) NOT NULL DEFAULT 0,
    capacity INT UNSIGNED NOT NULL DEFAULT 1,
    status VARCHAR(40) NOT NULL DEFAULT 'disponible',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE quotes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id BIGINT UNSIGNED NOT NULL,
    code VARCHAR(40) NOT NULL,
    event_name VARCHAR(180) NOT NULL,
    event_date DATE NULL,
    subtotal DECIMAL(14,2) NOT NULL DEFAULT 0,
    tax DECIMAL(14,2) NOT NULL DEFAULT 0,
    discount DECIMAL(14,2) NOT NULL DEFAULT 0,
    total DECIMAL(14,2) NOT NULL DEFAULT 0,
    status ENUM('borrador', 'enviada', 'negociacion', 'aprobada', 'perdida') NOT NULL DEFAULT 'borrador',
    probability TINYINT UNSIGNED NOT NULL DEFAULT 50,
    valid_until DATE NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY quotes_code_unique (code),
    CONSTRAINT quotes_client_fk FOREIGN KEY (client_id) REFERENCES clients(id)
) ENGINE=InnoDB;

CREATE TABLE quote_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quote_id BIGINT UNSIGNED NOT NULL,
    service_id BIGINT UNSIGNED NOT NULL,
    quantity DECIMAL(10,2) NOT NULL DEFAULT 1,
    unit_price DECIMAL(14,2) NOT NULL DEFAULT 0,
    total DECIMAL(14,2) NOT NULL DEFAULT 0,
    CONSTRAINT quote_items_quote_fk FOREIGN KEY (quote_id) REFERENCES quotes(id) ON DELETE CASCADE,
    CONSTRAINT quote_items_service_fk FOREIGN KEY (service_id) REFERENCES services(id)
) ENGINE=InnoDB;

CREATE TABLE events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id BIGINT UNSIGNED NOT NULL,
    quote_id BIGINT UNSIGNED NULL,
    name VARCHAR(180) NOT NULL,
    event_date DATE NOT NULL,
    start_time TIME NULL,
    end_time TIME NULL,
    venue VARCHAR(180) NULL,
    city VARCHAR(90) NULL,
    team_notes TEXT NULL,
    logistics_notes TEXT NULL,
    status ENUM('programado', 'confirmado', 'en_ejecucion', 'finalizado', 'cancelado') NOT NULL DEFAULT 'programado',
    expected_margin DECIMAL(5,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT events_client_fk FOREIGN KEY (client_id) REFERENCES clients(id),
    CONSTRAINT events_quote_fk FOREIGN KEY (quote_id) REFERENCES quotes(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE event_services (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id BIGINT UNSIGNED NOT NULL,
    service_id BIGINT UNSIGNED NOT NULL,
    quantity DECIMAL(10,2) NOT NULL DEFAULT 1,
    assigned_notes TEXT NULL,
    CONSTRAINT event_services_event_fk FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    CONSTRAINT event_services_service_fk FOREIGN KEY (service_id) REFERENCES services(id)
) ENGINE=InnoDB;

CREATE TABLE accounting_entries (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    entry_date DATE NOT NULL,
    type ENUM('ingreso', 'egreso') NOT NULL,
    category VARCHAR(90) NOT NULL,
    third_party VARCHAR(180) NOT NULL,
    description VARCHAR(220) NULL,
    base_amount DECIMAL(14,2) NOT NULL DEFAULT 0,
    tax_amount DECIMAL(14,2) NOT NULL DEFAULT 0,
    withholding_amount DECIMAL(14,2) NOT NULL DEFAULT 0,
    total DECIMAL(14,2) NOT NULL DEFAULT 0,
    document_number VARCHAR(80) NULL,
    payment_status ENUM('pendiente', 'pagado', 'vencido', 'parcial') NOT NULL DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX accounting_entries_date_type_idx (entry_date, type)
) ENGINE=InnoDB;

INSERT INTO clients (name, document_type, document_number, contact_name, phone, email, city, address, segment, status, notes) VALUES
('Colegio Nueva Granada', 'NIT', '900845112-1', 'Mariana Pulido', '+57 301 556 4488', 'eventos@nuevagranada.edu.co', 'Bogota', 'Cra 8 # 170-20', 'Institucional', 'activo', 'Cliente con eventos familiares recurrentes.'),
('Constructora Altavista', 'NIT', '901552084-7', 'Daniel Restrepo', '+57 315 900 2201', 'bienestar@altavista.co', 'Medellin', 'Av. El Poblado 18-40', 'Empresa', 'recurrente', 'Alto potencial en bienestar corporativo.'),
('Laura Mendez', 'CC', '52711904', 'Laura Mendez', '+57 320 441 0029', 'laura.mendez@email.com', 'Cali', 'Senderos del Valle', 'Persona natural', 'activo', 'Prefiere paquetes infantiles premium.');

INSERT INTO services (name, category, description, billing_unit, price, cost, capacity, status) VALUES
('Recreacion dirigida premium', 'Talento humano', 'Recreadores senior, juegos por edades, animacion y coordinacion.', 'hora', 180000, 95000, 12, 'disponible'),
('Inflable castillo mediano', 'Atracciones', 'Incluye transporte, montaje, operador y protocolo de seguridad.', 'dia', 450000, 120000, 3, 'disponible'),
('Show de magia familiar', 'Espectaculos', 'Show interactivo para ninos y adultos con sonido basico.', 'evento', 980000, 470000, 2, 'alta_demanda'),
('Estacion de pintucaritas', 'Experiencias', 'Artistas, materiales hipoalergenicos y mesa de atencion.', 'hora', 160000, 72000, 5, 'disponible');

INSERT INTO quotes (client_id, code, event_name, event_date, subtotal, tax, discount, total, status, probability, valid_until, notes) VALUES
(1, 'COT-1048', 'Festival familiar 2026', '2026-05-28', 14800000, 2812000, 0, 17612000, 'negociacion', 82, '2026-05-10', 'Pendiente aprobacion de rectoria.'),
(2, 'COT-1049', 'Dia de la familia Altavista', '2026-05-14', 22200000, 4218000, 900000, 25518000, 'aprobada', 100, '2026-05-05', 'Contrato aprobado con anticipo.'),
(3, 'COT-1050', 'Cumpleanos Valentina', '2026-05-19', 3600000, 684000, 0, 4284000, 'enviada', 68, '2026-05-06', 'Requiere confirmacion de horario.');

INSERT INTO events (client_id, quote_id, name, event_date, start_time, end_time, venue, city, team_notes, logistics_notes, status, expected_margin) VALUES
(2, 2, 'Dia de la familia Altavista', '2026-05-14', '09:00:00', '15:00:00', 'Parque Norte', 'Medellin', '8 recreadores, 2 personas de logistica, 1 coordinador.', 'Llegar 2 horas antes para montaje de inflables y sonido.', 'confirmado', 43.60),
(3, 3, 'Cumpleanos Valentina', '2026-05-19', '14:00:00', '18:00:00', 'Conjunto Senderos del Valle', 'Cali', '3 recreadores y mago.', 'Validar acceso de proveedores con administracion.', 'programado', 39.20),
(1, 1, 'Festival familiar 2026', '2026-05-28', '08:00:00', '13:00:00', 'Campus principal', 'Bogota', '10 recreadores y 1 coordinador.', 'Requiere mapa de estaciones y plan de lluvia.', 'programado', 46.80);

INSERT INTO accounting_entries (entry_date, type, category, third_party, description, base_amount, tax_amount, withholding_amount, total, document_number, payment_status) VALUES
('2026-04-04', 'ingreso', 'Factura electronica', 'Constructora Altavista', 'Anticipo dia de la familia', 11100000, 2109000, 385000, 12824000, 'FEV-1102', 'pagado'),
('2026-04-09', 'ingreso', 'Factura electronica', 'Colegio Nueva Granada', 'Reserva festival familiar', 7400000, 1406000, 256000, 8550000, 'FEV-1103', 'pendiente'),
('2026-04-12', 'egreso', 'Proveedor atracciones', 'Inflables del Valle SAS', 'Alquiler y transporte inflables', 2400000, 456000, 0, 2856000, 'DS-445', 'pagado'),
('2026-04-18', 'egreso', 'Nomina electronica', 'Equipo recreadores', 'Pago operativo quincenal', 6800000, 0, 0, 6800000, 'NE-202604-01', 'pagado'),
('2026-04-25', 'ingreso', 'Cuenta de cobro', 'Laura Mendez', 'Anticipo cumpleanos', 1800000, 342000, 0, 2142000, 'CC-088', 'pagado');
