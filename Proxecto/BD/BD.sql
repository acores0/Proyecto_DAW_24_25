CREATE SCHEMA baseinfodb3;

CREATE  TABLE baseinfodb3.usuarios ( 
	dni                  VARCHAR(9)    NOT NULL   PRIMARY KEY,
	nombre               VARCHAR(50)    NOT NULL   ,
	direccion            VARCHAR(50)    NOT NULL   ,
	codigo_postal        CHAR(5)    NOT NULL   ,
	municipio            VARCHAR(50)    NOT NULL   ,
	provincia            VARCHAR(50)    NOT NULL   ,
	rol                  ENUM('usuario','administrador')    NOT NULL   ,
	correo               VARCHAR(30)    NOT NULL   ,
	contrasinal          VARCHAR(100)    NOT NULL   ,
	forma_pago           ENUM('domiciliado','cheque','contado','')    NOT NULL   ,
	cuenta_bancaria      VARCHAR(24)       ,
	apellidos            VARCHAR(50)    NOT NULL   ,
	telefono             CHAR(9)    NOT NULL   ,
	foto                 VARCHAR(50)       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE  TABLE baseinfodb3.dias_vendimia ( 
	id                   INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	fecha                DATE       ,
	usuario              VARCHAR(9)       ,
	cajas                INT       
 ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE INDEX fk_diasvendimia_usuarios ON baseinfodb3.dias_vendimia ( usuario );

CREATE  TABLE baseinfodb3.facturas ( 
	numero_factura       VARCHAR(16)    NOT NULL   PRIMARY KEY,
	usuario              VARCHAR(9)    NOT NULL   ,
	concepto             VARCHAR(100)    NOT NULL   ,
	fecha                DATE    NOT NULL   ,
	base_imponible       DECIMAL(10,2)    NOT NULL   ,
	iva                  DECIMAL(4,2)    NOT NULL   ,
	total                DECIMAL(10,2)    NOT NULL   ,
	pagada               BOOLEAN  DEFAULT (false)     ,
	archivo              VARCHAR(20)       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE INDEX fk_facturas_usuarios ON baseinfodb3.facturas ( usuario );

CREATE  TABLE baseinfodb3.ingresos ( 
	numero_ingreso       VARCHAR(16)    NOT NULL   PRIMARY KEY,
	fecha                DATE  DEFAULT (curdate())  NOT NULL   ,
	concepto             VARCHAR(100)    NOT NULL   ,
	ingreso_bruto        DECIMAL(10,2)    NOT NULL   ,
	retencion            DECIMAL(10,0)    NOT NULL   ,
	porcentaje_retencion DECIMAL(5,2)    NOT NULL   ,
	total                DECIMAL(10,2)    NOT NULL   ,
	estado               ENUM('cobrado','pendiente de cobro')    NOT NULL   ,
	usuario              VARCHAR(9)    NOT NULL   ,
	archivo              VARCHAR(20)       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE INDEX fk_ingresos_ingresos ON baseinfodb3.ingresos ( usuario );

CREATE  TABLE baseinfodb3.parcelas ( 
	id                   INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	usuario              VARCHAR(9)    NOT NULL   ,
	nombre               CHAR(30)       ,
	direccion            CHAR(50)    NOT NULL   ,
	municipio            VARCHAR(50)    NOT NULL   ,
	m2                   DECIMAL(10,2)    NOT NULL   ,
	cupo                 DECIMAL(10,2)    NOT NULL   ,
	codigo_postal        VARCHAR(5)    NOT NULL   ,
	provincia            VARCHAR(50)    NOT NULL   ,
	variedad_uva         VARCHAR(100)       
 ) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE INDEX fk_parcelas_usuarios ON baseinfodb3.parcelas ( usuario );

CREATE  TABLE baseinfodb3.recolecta ( 
	id                   INT    NOT NULL AUTO_INCREMENT  PRIMARY KEY,
	usuario              VARCHAR(9)    NOT NULL   ,
	ano                  VARCHAR(4)    NOT NULL   ,
	precio               DECIMAL(4,2)       ,
	kg                   DECIMAL(8,2)    NOT NULL   ,
	base_imponible       DECIMAL(8,2)       ,
	retencion            DECIMAL(8,2)       ,
	total                DECIMAL(8,2)       ,
	graduacion           DECIMAL(4,2)    NOT NULL   ,
	porcentaje           DECIMAL(4,2)       ,
	cobrado              BOOLEAN  DEFAULT ('0')     
 ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE INDEX fk_campaña_usuarios ON baseinfodb3.recolecta ( usuario );

CREATE  TABLE baseinfodb3.albaranes ( 
	numero_albaran       VARCHAR(16)    NOT NULL   PRIMARY KEY,
	usuario              VARCHAR(9)    NOT NULL   ,
	parcela              INT    NOT NULL   ,
	fecha_hora           DATETIME    NOT NULL   ,
	grado                DECIMAL(4,2)    NOT NULL   ,
	peso_bruto           DECIMAL(10,2)    NOT NULL   ,
	tara                 DECIMAL(8,2)    NOT NULL   ,
	peso_neto            DECIMAL(10,2)    NOT NULL   ,
	cajas                INT    NOT NULL   ,
	archivo              VARCHAR(20)       
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE INDEX fk_albaranes_usuarios ON baseinfodb3.albaranes ( usuario );

CREATE INDEX fk_albaranes_parcelas ON baseinfodb3.albaranes ( parcela );

ALTER TABLE baseinfodb3.albaranes ADD CONSTRAINT fk_albaranes_parcelas FOREIGN KEY ( parcela ) REFERENCES baseinfodb3.parcelas( id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE baseinfodb3.albaranes ADD CONSTRAINT fk_albaranes_usuarios FOREIGN KEY ( usuario ) REFERENCES baseinfodb3.usuarios( dni ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE baseinfodb3.dias_vendimia ADD CONSTRAINT fk_diasvendimia_usuarios FOREIGN KEY ( usuario ) REFERENCES baseinfodb3.usuarios( dni ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE baseinfodb3.facturas ADD CONSTRAINT fk_facturas_usuarios FOREIGN KEY ( usuario ) REFERENCES baseinfodb3.usuarios( dni ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE baseinfodb3.ingresos ADD CONSTRAINT fk_ingresos_ingresos FOREIGN KEY ( usuario ) REFERENCES baseinfodb3.usuarios( dni ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE baseinfodb3.parcelas ADD CONSTRAINT fk_parcelas_usuarios FOREIGN KEY ( usuario ) REFERENCES baseinfodb3.usuarios( dni ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE baseinfodb3.recolecta ADD CONSTRAINT fk_campaña_usuarios FOREIGN KEY ( usuario ) REFERENCES baseinfodb3.usuarios( dni ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE baseinfodb3.usuarios COMMENT 'Tabla que almacena los datos de los usuarios';

ALTER TABLE baseinfodb3.usuarios MODIFY dni VARCHAR(9)  NOT NULL   COMMENT 'Campo que almacena el dni del usuario.';

ALTER TABLE baseinfodb3.usuarios MODIFY nombre VARCHAR(50)  NOT NULL   COMMENT 'Campo que almacena el nombre del usuario.';

ALTER TABLE baseinfodb3.usuarios MODIFY direccion VARCHAR(50)  NOT NULL   COMMENT 'Campo que almacena la dirección en la que vive del usuario.';

ALTER TABLE baseinfodb3.usuarios MODIFY codigo_postal CHAR(5)  NOT NULL   COMMENT 'Campo que almacena el código postal.';

ALTER TABLE baseinfodb3.usuarios MODIFY municipio VARCHAR(50)  NOT NULL   COMMENT 'Campo que almacena el municipio en el que vive el usuario.';

ALTER TABLE baseinfodb3.usuarios MODIFY provincia VARCHAR(50)  NOT NULL   COMMENT 'Campo que almacena la provincia al que pertenece el municipio donde vive el usuario.';

ALTER TABLE baseinfodb3.usuarios MODIFY rol ENUM('usuario','administrador')  NOT NULL   COMMENT 'Campo que almacena el rol del usuario, que puede ser usuario o administrador.';

ALTER TABLE baseinfodb3.usuarios MODIFY correo VARCHAR(30)  NOT NULL   COMMENT 'Campo que almacena el correo electrónico del usuario.';

ALTER TABLE baseinfodb3.usuarios MODIFY contrasinal VARCHAR(100)  NOT NULL   COMMENT 'Campo que almacena la contraseña encriptada del usuario.';

ALTER TABLE baseinfodb3.usuarios MODIFY forma_pago ENUM('domiciliado','cheque','contado','')  NOT NULL   COMMENT 'Campo que almacena la forma de pago: domiciliado, cheque, al contado.';

ALTER TABLE baseinfodb3.usuarios MODIFY cuenta_bancaria VARCHAR(24)     COMMENT 'Campo que almacena la cuenta bancaria.';

ALTER TABLE baseinfodb3.usuarios MODIFY apellidos VARCHAR(50)  NOT NULL   COMMENT 'Campo que almacena los apellidos del usuario.';

ALTER TABLE baseinfodb3.usuarios MODIFY telefono CHAR(9)  NOT NULL   COMMENT 'Campo que almacena el teléfono del usuario.';

ALTER TABLE baseinfodb3.usuarios MODIFY foto VARCHAR(50)     COMMENT 'Campo que almacena la imagen de perfil del usuario.';

ALTER TABLE baseinfodb3.dias_vendimia COMMENT 'Tabla que almacena los días de la vendimia';

ALTER TABLE baseinfodb3.dias_vendimia MODIFY id INT  NOT NULL  AUTO_INCREMENT COMMENT 'Campo que almacena el id del día.';

ALTER TABLE baseinfodb3.dias_vendimia MODIFY fecha DATE     COMMENT 'Campo que almacena la fecha.';

ALTER TABLE baseinfodb3.dias_vendimia MODIFY usuario VARCHAR(9)     COMMENT 'Campo que almacena el usuario al que pertenece el día.';

ALTER TABLE baseinfodb3.dias_vendimia MODIFY cajas INT     COMMENT 'Campo que almacena el número de cajas que l corresponden al usuario.';

ALTER TABLE baseinfodb3.facturas COMMENT 'Tabla que almacena las facturas.';

ALTER TABLE baseinfodb3.facturas MODIFY numero_factura VARCHAR(16)  NOT NULL   COMMENT 'Campo que almacena el número de la factura.';

ALTER TABLE baseinfodb3.facturas MODIFY usuario VARCHAR(9)  NOT NULL   COMMENT 'Campo que almacena el usuario al que pertenece la factura.';

ALTER TABLE baseinfodb3.facturas MODIFY concepto VARCHAR(100)  NOT NULL   COMMENT 'Campo que almacena el concepto de la factura.';

ALTER TABLE baseinfodb3.facturas MODIFY fecha DATE  NOT NULL   COMMENT 'Campo que almacena la fecha en la que se generó la factura.';

ALTER TABLE baseinfodb3.facturas MODIFY base_imponible DECIMAL(10,2)  NOT NULL   COMMENT 'Campo que almacena la base imponible de la factura.';

ALTER TABLE baseinfodb3.facturas MODIFY iva DECIMAL(4,2)  NOT NULL   COMMENT 'Campo que almacena el IVA de la factura.';

ALTER TABLE baseinfodb3.facturas MODIFY total DECIMAL(10,2)  NOT NULL   COMMENT 'Campo que almacena el total de la factura.';

ALTER TABLE baseinfodb3.facturas MODIFY pagada BOOLEAN   DEFAULT (false)  COMMENT 'Campo que almacena si la factura está pagada.';

ALTER TABLE baseinfodb3.facturas MODIFY archivo VARCHAR(20)     COMMENT 'Campo que almacena el nombre del archivo PDF de la factura.';

ALTER TABLE baseinfodb3.ingresos COMMENT 'Tabla que almacena los ingresos';

ALTER TABLE baseinfodb3.ingresos MODIFY numero_ingreso VARCHAR(16)  NOT NULL   COMMENT 'Campo que almacena el número del ingreso.';

ALTER TABLE baseinfodb3.ingresos MODIFY fecha DATE  NOT NULL DEFAULT (curdate())  COMMENT 'Campo que almacena la fecha del ingreso.';

ALTER TABLE baseinfodb3.ingresos MODIFY concepto VARCHAR(100)  NOT NULL   COMMENT 'Campo que almacena el concepto del ingreso.';

ALTER TABLE baseinfodb3.ingresos MODIFY ingreso_bruto DECIMAL(10,2)  NOT NULL   COMMENT 'Campo que almacena el ingreso bruto.';

ALTER TABLE baseinfodb3.ingresos MODIFY retencion DECIMAL(10,0)  NOT NULL   COMMENT 'Campo que almacena la retención.';

ALTER TABLE baseinfodb3.ingresos MODIFY porcentaje_retencion DECIMAL(5,2)  NOT NULL   COMMENT 'Campo que almacena el porcentaje de la retención.';

ALTER TABLE baseinfodb3.ingresos MODIFY total DECIMAL(10,2)  NOT NULL   COMMENT 'Campo que almacena el total del ingreso.';

ALTER TABLE baseinfodb3.ingresos MODIFY estado ENUM('cobrado','pendiente de cobro')  NOT NULL   COMMENT 'Campo que almacena el estado del ingreso: cobrado o pendiente de cobro.';

ALTER TABLE baseinfodb3.ingresos MODIFY usuario VARCHAR(9)  NOT NULL   COMMENT 'Campo que almacena el usuario al que se le realiza el ingreso.';

ALTER TABLE baseinfodb3.ingresos MODIFY archivo VARCHAR(20)     COMMENT 'Campo que almacena el nombre del archivo PDF del ingreso.';

ALTER TABLE baseinfodb3.parcelas COMMENT 'Tabla que almacena las parcelas de los usuarios.';

ALTER TABLE baseinfodb3.parcelas MODIFY id INT  NOT NULL  AUTO_INCREMENT COMMENT 'Campo que almacena el id de la parcela.';

ALTER TABLE baseinfodb3.parcelas MODIFY usuario VARCHAR(9)  NOT NULL   COMMENT 'Campo que almacena el propietario de la parcela.';

ALTER TABLE baseinfodb3.parcelas MODIFY nombre CHAR(30)     COMMENT 'Campo que almacena el nombre de la parcela.';

ALTER TABLE baseinfodb3.parcelas MODIFY direccion CHAR(50)  NOT NULL   COMMENT 'Campo que almacena la dirección de la parcela.';

ALTER TABLE baseinfodb3.parcelas MODIFY municipio VARCHAR(50)  NOT NULL   COMMENT 'Campo que almacena el municipio donde se ubica la parcela.';

ALTER TABLE baseinfodb3.parcelas MODIFY m2 DECIMAL(10,2)  NOT NULL   COMMENT 'Campo que almacena los metros cuadrados de la parcela.';

ALTER TABLE baseinfodb3.parcelas MODIFY cupo DECIMAL(10,2)  NOT NULL   COMMENT 'Campo que almacena el cupo de la parcela.';

ALTER TABLE baseinfodb3.parcelas MODIFY codigo_postal VARCHAR(5)  NOT NULL   COMMENT 'Campo que almacena el código postal de la parcela.';

ALTER TABLE baseinfodb3.parcelas MODIFY provincia VARCHAR(50)  NOT NULL   COMMENT 'Campo que almacena la provincia donde se ubica la parcela.';

ALTER TABLE baseinfodb3.parcelas MODIFY variedad_uva VARCHAR(100)     COMMENT 'Campo que almacena las variedades de uva que tiene la parcela.';

ALTER TABLE baseinfodb3.recolecta COMMENT 'Tabla que almacena los datos de la campaña de uva.';

ALTER TABLE baseinfodb3.recolecta MODIFY id INT  NOT NULL  AUTO_INCREMENT COMMENT 'Campo que almacena el id.';

ALTER TABLE baseinfodb3.recolecta MODIFY usuario VARCHAR(9)  NOT NULL   COMMENT 'Campo que almacena el usuario al que pertenece los datos de la recoleta.';

ALTER TABLE baseinfodb3.recolecta MODIFY ano VARCHAR(4)  NOT NULL   COMMENT 'Campo que almacena el año de la recolecta.';

ALTER TABLE baseinfodb3.recolecta MODIFY precio DECIMAL(4,2)     COMMENT 'Campo que almacena el precio de la recolecta.';

ALTER TABLE baseinfodb3.recolecta MODIFY kg DECIMAL(8,2)  NOT NULL   COMMENT 'Campo que almacena el número de kg recogidos en la recolecta.';

ALTER TABLE baseinfodb3.recolecta MODIFY base_imponible DECIMAL(8,2)     COMMENT 'Campo que almacena la base imponible de la recolecta.';

ALTER TABLE baseinfodb3.recolecta MODIFY retencion DECIMAL(8,2)     COMMENT 'Campo que almacena la retención de la recolecta.';

ALTER TABLE baseinfodb3.recolecta MODIFY total DECIMAL(8,2)     COMMENT 'Campo que almacena el total a pagar de la recolecta.';

ALTER TABLE baseinfodb3.recolecta MODIFY graduacion DECIMAL(4,2)  NOT NULL   COMMENT 'Campo que almacena la graduación media de la recolecta.';

ALTER TABLE baseinfodb3.recolecta MODIFY porcentaje DECIMAL(4,2)     COMMENT 'Campo que almacena el porcentaje de la recolecta.';

ALTER TABLE baseinfodb3.recolecta MODIFY cobrado BOOLEAN   DEFAULT ('0')  COMMENT 'Campo que almacena si la campaña está cobrada';

ALTER TABLE baseinfodb3.albaranes COMMENT 'Tabla que almacena los albaranes de uva';

ALTER TABLE baseinfodb3.albaranes MODIFY numero_albaran VARCHAR(16)  NOT NULL   COMMENT 'Campo que almacena el numero del albarán';

ALTER TABLE baseinfodb3.albaranes MODIFY usuario VARCHAR(9)  NOT NULL   COMMENT 'Campo que almacena el propietario de la entrega.';

ALTER TABLE baseinfodb3.albaranes MODIFY parcela INT  NOT NULL   COMMENT 'Campo que almacena la parcela recolectada.';

ALTER TABLE baseinfodb3.albaranes MODIFY fecha_hora DATETIME  NOT NULL   COMMENT 'Campo que almacena la fecha y hora de la entrega de uva.';

ALTER TABLE baseinfodb3.albaranes MODIFY grado DECIMAL(4,2)  NOT NULL   COMMENT 'Campo que almacena el grado de la entrega.';

ALTER TABLE baseinfodb3.albaranes MODIFY peso_bruto DECIMAL(10,2)  NOT NULL   COMMENT 'Campo que almacena el peso bruto de la entrega de uva.';

ALTER TABLE baseinfodb3.albaranes MODIFY tara DECIMAL(8,2)  NOT NULL   COMMENT 'Campo que almacena la tara.';

ALTER TABLE baseinfodb3.albaranes MODIFY peso_neto DECIMAL(10,2)  NOT NULL   COMMENT 'Campo que almacena el peso neto de la entrega de uva.';

ALTER TABLE baseinfodb3.albaranes MODIFY cajas INT  NOT NULL   COMMENT 'Campo que almacena el número de cajas entregadas.';

ALTER TABLE baseinfodb3.albaranes MODIFY archivo VARCHAR(20)     COMMENT 'Campo que almacena el nombre del archivo del albarán';

