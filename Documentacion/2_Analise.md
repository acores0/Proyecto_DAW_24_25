# Requerimientos do sistema

- [Requerimientos do sistema](#requerimientos-do-sistema)
  - [1- Descrición Xeral](#1--descrición-xeral)
  - [2- Funcionalidades](#2--funcionalidades)
  - [3- Tipos de usuarios](#3--tipos-de-usuarios)
  - [4- Contorno operacional](#4--contorno-operacional)
  - [5- Normativa](#5--normativa)
  - [6- Melloras futuras](#6--melloras-futuras)


Este documento describe os requirimentos para BaseInfoDB3 especificando que funcionalidade ofrecerá e de que xeito.

## 1- Descrición Xeral
O proxecto utiliza a base de datos dunha empresa vitivinícola para mostrar a través da súa páxina web a información que a bodega ten dos seus proveedores de uva.


## 2- Funcionalidades
As funcionalidades da aplicación son as seguintes:

- Funcións dos usuarios:

| Acción   |  Descrición        |
|----------|--------------------|
| **Modificar datos**   | Modificación dos seus datos persoais. |
| **Consulta de parcelas** | Consulta dos datos das súas parcelas. |
| **Consulta dos saldos** | Consulta do saldo das débedas e abonos coa empresa vitivinícola. |
| **Consulta do rendemento da parcela** | Consulta do número de kg entregados na campaña de vendima por ano. |
| **Descarga de facturas**  | Descarga das facturas de pago e cobro. |
| **Descarga de xustificantes** | Descarga dos xustificantes de entrega de uva.
| **Consulta de información da campaña da vendima** |  Consulta das normas para a entrega de uva así como dos prazos de inicio e remate da campaña. |



- Funcións dos usuarios administradores:

| Acción | Descrición|
| --- | --- |
| **Alta de usuarios** | Dar de alta ós usuarios na base de datos. |
| **Modificar os usuarios** | Modificación dos datos dos usuarios na base de datos. |
| **Baixa de usuarios** | Eliminación de usuarios na base de datos. |
| **Consultar usuarios** | Consulta dos datos dos usuarios |
| **Alta de parcelas** | Dar de alta as parcelas pertencentes a cada usuario. |
| **Modificar parcelas** | Modificación dos datos das parcelas de cada usuario. |
| **Baixa de parcelas** | Eliminación de parcelas pertencentes aos usuarios. |
| **Consultar parcelas** | Consulta dos datos das parcelas |
| **Consultar os usuarios** | Consulta dos usuarios rexistrados na base de datos. |
| **Consultar débedas** | Consulta da cantidade que ten pendente de pagar cada usuario. |
| **Consultar pagos a proveedores** | Consulta da cantidade que hai que pagar a cada usuario. |
| **Alta prezo** | Dar de alta o prezo por kg. de uva. |


## 3- Tipos de usuarios
Os usuarios que teñen acceso á aplicación clasifícanse en:
- Usuario rexistrado que terá acceso ao seguinte:
  - Datos persoais e das parcelas.
  - Datos das facturas de pago e cobro.
  - Información da vendima: data de inicio, data de fin, normas de entrega de uva, recibos de entrega da uva.
  
- Usuario administrador que terá acceso aos datos dos usuarios e das facturas de cobro e pago cos proveedores de uva.

## 4- Contorno operacional
Os recursos que necesitan os usuarios para acceder á aplicación é unha computadora que ten instalado un navegador web actualizado e unha conexión a Internet.


## 5- Normativa
A normativa que afecta á aplicación é a seguinte: 
- [Ley Orgánica 3/2018, de 5 de diciembre, de Protección de Datos Personales y garantía de los derechos digitales (LOPDPGDD)](https://www.boe.es/buscar/act.php?id=BOE-A-2018-16673)

- [Ley 34/2002, de 11 de julio, de servicios de la sociedad de la información y de comercio electrónico ("LSSI")](https://www.boe.es/buscar/act.php?id=BOE-A-2002-13758)

- [Real Decreto Legislativo 1/2007, de 16 de noviembre, por el que se aprueba el texto refundido de la Ley General para la Defensa de los Consumidores y Usuarios y otras leyes complementarias](https://www.boe.es/buscar/act.php?id=BOE-A-2007-20555)

- [Ley 7/1998, de 13 de abril, sobre condiciones generales de contratación](https://www.boe.es/buscar/act.php?id=BOE-A-1998-8789)

- [Real Decreto 1112/2018, de 7 de septiembre, sobre accesibilidad de los sitios web y aplicaciones para dispositivos móviles del sector público](https://www.boe.es/buscar/act.php?id=BOE-A-2018-12699)

Para cumprir coas leis anteriores, incluirase na web os seguintes apartados:

  - **Aviso legal:** neste apartado recóllense os datos identificativos do titular da web co obxectivo de informar aos usuarios do propietario da páxina e mostrar as actividades da empresa.

  - **Política de privacidade:** neste apartado indícase quén é a persoa responsable do tratamento dos datos, neste caso a empresa vitivinícola, e para que fins se van utilizar. Tamén indicarase un apartado no que se informa ao usuario dos seus dereitos en materia de protección de datos (acceso, rectificación, cancelación e oposición), que neste caso os usuarios poderán exercer estes dereitos enviando un correo electrónico á empresa vitivinicola.

  - **Política de cookies:** neste apartado infórmarase aos usuarios de todas as cookies que se utilizan para recoller información.


Para implementar os apartados anteriores na web utilizaranse dúas "capas" legais de información:

  1. Para cada un dos apartados crearase unha páxina web independente coa información correspondente e engadiremos un enlace a cada unha no pé de páxina, de xeito que esta información estea dispoñible para todos os usuarios.
   
  2. Engadiremos enlaces a estas políticas nos formularios da web onde o usuario debe marcar unha casilla para indicar que coñecen as condicións e as aceptan.


E, por último, a aplicación debe ser accesible. Para elo, cumpriremos cos criterios de nivel A e AA dos estándares recollidos nas [Pautas de Accesibilidade para el Contenido Web 2.1 (WCAG 2.1)](https://www.w3.org/TR/WCAG21/) que abarcan dende os elementos que forman a composición dunha páxina web (como os contrastes das cores, os encabezados, os botóns, as ligazóns ou o funcionamento dos formularios) ata os máis técnicos (como a arquitectura interna da web, a estructura do código ou a súa navegabilidade).

## 6- Melloras futuras

> *EXPLICACION* É posible que o noso proxecto se centre en resolver un problema concreto que se poderá ampliar no futuro con novas funcionalidades, novas interfaces, etc.