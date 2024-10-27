# FASE DE DESEÑO

- [FASE DE DESEÑO](#fase-de-deseño)
  - [1- Diagrama da arquitectura](#1--diagrama-da-arquitectura)
  - [2- Casos de uso](#2--casos-de-uso)
  - [3- Diagrama de Base de Datos](#3--diagrama-de-base-de-datos)
  - [4- Deseño de interface de usuarios](#4--deseño-de-interface-de-usuarios)

Este documento inclúe os diferentes diagramas, esquemas e deseños que axuden a describir mellor o BaseInfoDB3 detallando os seus compoñentes, funcionalidades, bases de datos e interface.

## 1- Diagrama da arquitectura
![Diagrama de arquitectura](img/Diagrama%20de%20arquitectura.png)

## 2- Casos de uso

![Diagrama de casos de uso](img/Diagrama%20casos%20de%20uso.png)

## 3- Diagrama de Base de Datos
![Diagrama de base de datos](img/Diagrama%20BD.png)

**Documentación base de datos:**
1. **Tabla albaranes:** tabla que almacena los albaranes de uva

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  | id| INT AUTO_INCREMENT | Campo que almacena el id del albarán |
| * &#11016; | usuario| VARCHAR(9)  | Campo que almacena el usuario al que pertene el albarán. |
| * &#11016; | parcela| INT  | Campo que almacena la parcela de donde proceden las uvas. |
| * | fechahora| DATETIME  | Campo que almacena la fecha y hora a la que se entregaron las uvas. |
| * | peso| FLOAT(8,2)  | Campo que almacena el peso de las uvas entregadas. |
| * | grado| FLOAT(4,2)  | Campo que almacena el grado de las uvas entregadas. |

**Indexes**
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_albaranes | ON id|

**Foreign Keys**
|Type |Name |On |
|---|---|---|
|  | fk_albaranes_usuarios | ( usuario ) ref [baseinfodb3.usuarios](#usuarios) (dni) |
|  | fk_albaranes_parcelas | ( parcela ) ref [baseinfodb3.parcelas](#parcelas) (id) |


**Options:** engine=InnoDB 


2. **Tabla campaña:** tabla que almacena los datos de la campaña de uva.

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  | id| INT AUTO_INCREMENT | Campo que almacena el id. |
| * &#11016; | usuario| VARCHAR(9)  | Campo que almacena el usuario. |
| * | ano| INT  | Campo que almacena el año de la campaña |
|  | precio| FLOAT(4,2)  | Campo que almacena el precio de la uva de esa campaña. |
| * | kg| FLOAT(8,2)  | Campo que almacena el número de kg entregados |
|  | totalcobro| FLOAT(8,2)  | Campo que almacena el total a cobrar esa campaña el usuario |


**Indexes** 
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_campaña | ON id|

**Foreign Keys**
|Type |Name |On |
|---|---|---|
|  | fk_campaña_usuarios | ( usuario ) ref [baseinfodb3.usuarios](#usuarios) (dni) |


**Options:** engine=InnoDB 


3. **Tabla facturas:** tabla que almacena las facturas.

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  | id| INT AUTO_INCREMENT | Campo que almacena el id de la factura. |
| * &#128270; &#11016; | usuario| VARCHAR(9)  | Campo que almacena el usuario propietario de factura. |
| * | concepto| VARCHAR(100)  | Campo que almacena el concepto de la factura. |
| * | fecha| DATE  | Campo que almacena la fecha de la factura. |
| * | baseimponible| FLOAT(8,2)  | Campo que almacena la base imponible de la factura. |
| * | iva| FLOAT(4,2)  | Campo que almacena el IVA. |
| * | total| FLOAT(8,2)  | Campo que almacena el total de la factura. |


**Indexes**
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_facturas | ON id|
| &#128270;  | fk\_facturas\_usuarios | ON usuario|

**Foreign Keys**
|Type |Name |On |
|---|---|---|
|  | fk_facturas_usuarios | ( usuario ) ref [baseinfodb3.usuarios](#usuarios) (dni) |


**Options:** ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4\_0900\_ai\_ci 


4. **Tabla ingresos:** tabla que almacena los ingresos

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  | id| CHAR(20)  | Campo que almacena el id del ingreso. |
| * | fecha| DATE  DEFAULT curdate() | Campo que almacena la fecha de la factura. |
| * | concepto| VARCHAR(100)  | Campo que almacena el concepto del ingreso. |
| * | ingresobruto| FLOAT(8,2)  | Campo que almacena el ingreso bruto. |
| * | retencion| FLOAT(8,2)  | Campo que almacena la retención del ingreso. |
| * | porcentaje| FLOAT(4,2)  | Campo que almacena el porcentaje de la retención del ingreso. |
| * | total| FLOAT(8,2)  | Campo que almacena el total a percibir. |
|  | estado| ENUM('cobrado','pendiente de cobro')  | Campo que almacena el estado del ingreso. |
| * &#128270; &#11016; | usuario| VARCHAR(9)  | Campo que almacena el dni del usuario del ingreso. |


**Indexes**
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_ingresos | ON id|
| &#128270;  | fk\_ingresos\_ingresos | ON usuario|

**Foreign Keys**
|Type |Name |On |
|---|---|---|
|  | fk_ingresos_ingresos | ( usuario ) ref [baseinfodb3.usuarios](#usuarios) (dni) |


**Options:** ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4\_0900\_ai\_ci 


5. **Tabla parcelas:** tabla que almacena las parcelas de los usuarios.

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  &#11019; | id| INT AUTO_INCREMENT |  |
| * &#128270; &#11016; | usuario| VARCHAR(9)  |  |
|  | nombre| CHAR(30)  | Campo que almacena el nombre de la parcela. |
| * | direccion| CHAR(50)  | Campo que almacena la dirección de la parcela. |
| * | municipio| VARCHAR(50)  |  |
| * | coordenadas| CHAR(50)  | Campo que almacena las coordenadas geográficas de la parcela. |
| * | m2| FLOAT(10,2)  |  |
| * | variedad| CHAR(20)  | Campo que almacena la variedad de uva plantada en la parcela. |
| * | cupo| FLOAT(8,2)  |  |
| * | codigopostal| INT  | Campo que almacena el código postal |
| * | provincia| VARCHAR(50)  | Campo que almacena la provincia |


**Indexes**
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_parcelas | ON id|
| &#128270;  | fk\_parcelas\_usuarios | ON usuario|

**Foreign Keys**
|Type |Name |On |
|---|---|---|
|  | fk_parcelas_usuarios | ( usuario ) ref [baseinfodb3.usuarios](#usuarios) (dni) |


**Options:** ENGINE=InnoDB AUTO\_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4\_0900\_ai\_ci 


6. **Tabla usuarios:** tabla que almacena los datos de los usuarios

|Idx |Name |Data Type |Description |
|---|---|---|---|
| * &#128273;  &#11019; | dni| VARCHAR(9)  | Campo que almacena el dni del usuario. |
| * | nombreapellidos| VARCHAR(50)  | Campo que almacena el nombre y los apellidos del usuario. |
| * | direccion| VARCHAR(50)  | Campo que almacena la dirección del usuario. |
| * | codigopostal| INT  | Campo que almacena el código postal del usuario. |
| * | municipio| VARCHAR(50)  | Campo que almacena el municipio del usuario. |
| * | provincia| VARCHAR(50)  | Campo que almacena la provincia del usuario. |
| * | rol| ENUM('usuario','administrador')  | Campo que almacena el rol del usuario: usuario o administrador. |
| * | correo| VARCHAR(30)  | Campo que almacena el correo electrónico. |
| * | contrasinal| VARCHAR(100)  | Campo que almacena la contraseña. |
| * | formapago| ENUM('domiciliado','cheque','contado')  | Campo que almacena el tipo de pago al usuario: domiciliado, cheque, al contado ... |
|  | cuentabancaria| VARCHAR(24)  | Campo que almacena la cuenta bancaria de usuario. |


**Indexes**
|Type |Name |On |
|---|---|---|
| &#128273;  | pk\_usuarios | ON dni|

**Options:** ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4\_0900\_ai\_ci 



## 4- Deseño de interface de usuarios
 [Arquivo que contén o deseño da interface dos usuarios](arquivos/BaseInfoDB3.fig)