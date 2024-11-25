# FASE DE DESEÑO

- [FASE DE DESEÑO](#fase-de-deseño)
  - [1- Diagrama da arquitectura](#1--diagrama-da-arquitectura)
  - [2- Casos de uso](#2--casos-de-uso)
  - [3- Diagrama de Base de Datos](#3--diagrama-de-base-de-datos)
  - [**Documentación base de datos:**](#documentación-base-de-datos)
  - [**Tabla albaranes**](#tabla-albaranes)
  - [**Tabla dias\_vendimia**](#tabla-dias_vendimia)
  - [**Tabla facturas**](#tabla-facturas)
  - [**Tabla ingresos**](#tabla-ingresos)
  - [**Tabla parcelas**](#tabla-parcelas)
  - [**Tabla recolecta**](#tabla-recolecta)
  - [**Tabla usuarios**](#tabla-usuarios)
  - [4- Deseño de interface de usuarios](#4--deseño-de-interface-de-usuarios)

Este documento inclúe os diferentes diagramas, esquemas e deseños que axuden a describir mellor o BaseInfoDB3 detallando os seus compoñentes, funcionalidades, bases de datos e interface.

## 1- Diagrama da arquitectura
![Diagrama de arquitectura](img/Diagrama%20de%20arquitectura.png)

## 2- Casos de uso

![Diagrama de casos de uso](img/Diagrama%20casos%20de%20uso.png)

## 3- Diagrama de Base de Datos
![Diagrama de base de datos](img/Diagrama%20BD.png)

**<u>Documentación base de datos:</u>**  
---

**Tabla albaranes**  
---
Tabla que almacena los albaranes de uva

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  | numero\_albaran| VARCHAR(16)  | Campo que almacena el numero del albarán |
| * &#128270; &#11016; | usuario| VARCHAR(9)  | Campo que almacena el propietario de la entrega. |
| * &#128270; &#11016; | parcela| INT  | Campo que almacena la parcela recolectada. |
| * | fecha\_hora| DATETIME  | Campo que almacena la fecha y hora de la entrega de uva. |
| * | grado| DECIMAL(4,2)  | Campo que almacena el grado de la entrega. |
| * | peso\_bruto| DECIMAL(10,2)  | Campo que almacena el peso bruto de la entrega de uva. |
| * | tara| DECIMAL(8,2)  | Campo que almacena la tara. |
| * | peso\_neto| DECIMAL(10,2)  | Campo que almacena el peso neto de la entrega de uva. |
| * | cajas| INT  | Campo que almacena el número de cajas entregadas. |
|  | archivo| VARCHAR(20)  | Campo que almacena el nombre del archivo del albarán |


**Indexes**
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_albaranes | ON numero\_albaran|
| &#128270;  | fk\_albaranes\_usuarios | ON usuario|
| &#128270;  | fk\_albaranes\_parcelas | ON parcela|

**Foreign Keys**
|Type |Name |On |
|---|---|---|
|  | fk_albaranes_parcelas | ( parcela ) ref [baseinfodb3.parcelas](#parcelas) (id) |
|  | fk_albaranes_usuarios | ( usuario ) ref [baseinfodb3.usuarios](#usuarios) (dni) |


**Options**
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4\_0900\_ai\_ci 


**Tabla dias_vendimia**  
---
Tabla que almacena los días de la vendimia

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  | id| INT AUTO_INCREMENT | Campo que almacena el id del día. |
|  | fecha| DATE  | Campo que almacena la fecha. |
| &#128270; &#11016; | usuario| VARCHAR(9)  | Campo que almacena el usuario al que pertenece el día. |
|  | cajas| INT  | Campo que almacena el número de cajas que l corresponden al usuario. |


**Indexes**
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_dias\_vendimia | ON id|
| &#128270;  | fk\_diasvendimia\_usuarios | ON usuario|

**Foreign Keys**
|Type |Name |On |
|---|---|---|
|  | fk_diasvendimia_usuarios | ( usuario ) ref [baseinfodb3.usuarios](#usuarios) (dni) |


**Options**
ENGINE=InnoDB AUTO\_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4\_0900\_ai\_ci 


**Tabla facturas**
---
Tabla que almacena las facturas.

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  | numero\_factura| VARCHAR(16)  | Campo que almacena el número de la factura. |
| * &#128270; &#11016; | usuario| VARCHAR(9)  | Campo que almacena el usuario al que pertenece la factura. |
| * | concepto| VARCHAR(100)  | Campo que almacena el concepto de la factura. |
| * | fecha| DATE  | Campo que almacena la fecha en la que se generó la factura. |
| * | base\_imponible| DECIMAL(10,2)  | Campo que almacena la base imponible de la factura. |
| * | iva| DECIMAL(4,2)  | Campo que almacena el IVA de la factura. |
| * | total| DECIMAL(10,2)  | Campo que almacena el total de la factura. |
|  | pagada| BOOLEAN  DEFAULT false | Campo que almacena si la factura está pagada. |
|  | archivo| VARCHAR(20)  | Campo que almacena el nombre del archivo PDF de la factura. |


**Indexes**
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_facturas | ON numero\_factura|
| &#128270;  | fk\_facturas\_usuarios | ON usuario|

**Foreign Keys**
|Type |Name |On |
|---|---|---|
|  | fk_facturas_usuarios | ( usuario ) ref [baseinfodb3.usuarios](#usuarios) (dni) |


**Options**
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4\_0900\_ai\_ci 


**Tabla ingresos**
---
Tabla que almacena los ingresos

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  | numero\_ingreso| VARCHAR(16)  | Campo que almacena el número del ingreso. |
| * | fecha| DATE  DEFAULT curdate() | Campo que almacena la fecha del ingreso. |
| * | concepto| VARCHAR(100)  | Campo que almacena el concepto del ingreso. |
| * | ingreso\_bruto| DECIMAL(10,2)  | Campo que almacena el ingreso bruto. |
| * | retencion| DECIMAL(10,0)  | Campo que almacena la retención. |
| * | porcentaje\_retencion| DECIMAL(5,2)  | Campo que almacena el porcentaje de la retención. |
| * | total| DECIMAL(10,2)  | Campo que almacena el total del ingreso. |
| * | estado| ENUM('cobrado','pendiente de cobro')  | Campo que almacena el estado del ingreso: cobrado o pendiente de cobro. |
| * &#128270; &#11016; | usuario| VARCHAR(9)  | Campo que almacena el usuario al que se le realiza el ingreso. |
|  | archivo| VARCHAR(20)  | Campo que almacena el nombre del archivo PDF del ingreso. |


**Indexes**
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_ingresos | ON numero\_ingreso|
| &#128270;  | fk\_ingresos\_ingresos | ON usuario|

**Foreign Keys**
|Type |Name |On |
|---|---|---|
|  | fk_ingresos_ingresos | ( usuario ) ref [baseinfodb3.usuarios](#usuarios) (dni) |


**Options**
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4\_0900\_ai\_ci 


**Tabla parcelas**
---
Tabla que almacena las parcelas de los usuarios.

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  &#11019; | id| INT AUTO_INCREMENT | Campo que almacena el id de la parcela. |
| * &#128270; &#11016; | usuario| VARCHAR(9)  | Campo que almacena el propietario de la parcela. |
|  | nombre| CHAR(30)  | Campo que almacena el nombre de la parcela. |
| * | direccion| CHAR(50)  | Campo que almacena la dirección de la parcela. |
| * | municipio| VARCHAR(50)  | Campo que almacena el municipio donde se ubica la parcela. |
| * | m2| DECIMAL(10,2)  | Campo que almacena los metros cuadrados de la parcela. |
| * | cupo| DECIMAL(10,2)  | Campo que almacena el cupo de la parcela. |
| * | codigo\_postal| VARCHAR(5)  | Campo que almacena el código postal de la parcela. |
| * | provincia| VARCHAR(50)  | Campo que almacena la provincia donde se ubica la parcela. |
|  | variedad\_uva| VARCHAR(100)  | Campo que almacena las variedades de uva que tiene la parcela. |


**Indexes**
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_parcelas | ON id|
| &#128270;  | fk\_parcelas\_usuarios | ON usuario|

**Foreign Keys**
|Type |Name |On |
|---|---|---|
|  | fk_parcelas_usuarios | ( usuario ) ref [baseinfodb3.usuarios](#usuarios) (dni) |


**Options**
ENGINE=InnoDB AUTO\_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4\_0900\_ai\_ci 


**Tabla recolecta**
---
Tabla que almacena los datos de la campaña de uva.

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  | id| INT AUTO_INCREMENT | Campo que almacena el id. |
| * &#128270; &#11016; | usuario| VARCHAR(9)  | Campo que almacena el usuario al que pertenece los datos de la recoleta. |
| * | ano| VARCHAR(4)  | Campo que almacena el año de la recolecta. |
|  | precio| DECIMAL(4,2)  | Campo que almacena el precio de la recolecta. |
| * | kg| DECIMAL(8,2)  | Campo que almacena el número de kg recogidos en la recolecta. |
|  | base\_imponible| DECIMAL(8,2)  | Campo que almacena la base imponible de la recolecta. |
|  | retencion| DECIMAL(8,2)  | Campo que almacena la retención de la recolecta. |
|  | total| DECIMAL(8,2)  | Campo que almacena el total a pagar de la recolecta. |
| * | graduacion| DECIMAL(4,2)  | Campo que almacena la graduación media de la recolecta. |
|  | porcentaje| DECIMAL(4,2)  | Campo que almacena el porcentaje de la recolecta. |
|  | cobrado| BOOLEAN  DEFAULT '0' | Campo que almacena si la campaña está cobrada |


**Indexes**
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_recolecta | ON id|
| &#128270;  | fk\_campaña\_usuarios | ON usuario|

**Foreign Keys**
|Type |Name |On |
|---|---|---|
|  | fk_campaña_usuarios | ( usuario ) ref [baseinfodb3.usuarios](#usuarios) (dni) |


**Options**
ENGINE=InnoDB AUTO\_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4\_0900\_ai\_ci 


**Tabla usuarios**
---
Tabla que almacena los datos de los usuarios

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  &#11019; | dni| VARCHAR(9)  | Campo que almacena el dni del usuario. |
| * | nombre| VARCHAR(50)  | Campo que almacena el nombre del usuario. |
| * | direccion| VARCHAR(50)  | Campo que almacena la dirección en la que vive del usuario. |
| * | codigo\_postal| CHAR(5)  | Campo que almacena el código postal. |
| * | municipio| VARCHAR(50)  | Campo que almacena el municipio en el que vive el usuario. |
| * | provincia| VARCHAR(50)  | Campo que almacena la provincia al que pertenece el municipio donde vive el usuario. |
| * | rol| ENUM('usuario','administrador')  | Campo que almacena el rol del usuario, que puede ser usuario o administrador. |
| * | correo| VARCHAR(30)  | Campo que almacena el correo electrónico del usuario. |
| * | contrasinal| VARCHAR(100)  | Campo que almacena la contraseña encriptada del usuario. |
| * | forma\_pago| ENUM('domiciliado','cheque','contado','')  | Campo que almacena la forma de pago: domiciliado, cheque, al contado. |
|  | cuenta\_bancaria| VARCHAR(24)  | Campo que almacena la cuenta bancaria. |
| * | apellidos| VARCHAR(50)  | Campo que almacena los apellidos del usuario. |
| * | telefono| CHAR(9)  | Campo que almacena el teléfono del usuario. |
|  | foto| VARCHAR(50)  | Campo que almacena la imagen de perfil del usuario. |


**Indexes**
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_usuarios | ON dni|

**Options**
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4\_0900\_ai\_ci 



## 4- Deseño de interface de usuarios
 [Arquivo que contén o deseño da interface dos usuarios](arquivos/BaseInfoDB3.fig)