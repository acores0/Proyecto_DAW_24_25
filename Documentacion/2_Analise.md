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
A aplicación utiliza os datos dunha empresa vitivinícola almacenados na base de datos polos usuarios administradores mediante os formularios da propia aplicación para mostrar a través da súa páxina web a información que a bodega ten dos seus proveedores de uva.



## 2- Funcionalidades
As funcionalidades da aplicación son as seguintes:

- Funcións dos usuarios:

| Acción   |  Descrición        |
|----------|--------------------|
| **Modificar datos persoais** | Modificación dos seus datos persoais. |
| **Cambiar contrasinal** | Cambio do seu contrasinal persoal. |
| **Consulta de parcelas** | Consulta dos datos das súas parcelas. |
| **Consulta dos saldos** | Consulta do saldo das débedas e abonos coa empresa vitivinícola. |
| **Consulta do rendemento da parcela** | Consulta do número de kg entregados na campaña de vendima por ano. |
| **Consulta dos ingresos e facturas** | Consulta dos documentos de ingresos e facturas do usuario. |
| **Descarga de facturas e ingresos**  | Descarga das facturas de pago e ingresos. |
| **Consulta de información da campaña da vendima** |  Consulta das normas para a entrega de uva,dos prazos de inicio e remate da campaña, dos albaráns de entrega de uva e do resumo da campaña: media total de graduación, número de quilos entregados, ... |
| **Descarga dos albaráns de entrega de uva** | Descarga dos albaráns de entrega de uva. |
| **Consulta das datas da vendima** | Consulta das datas de inicio e fin da vendima así como das datas asignadas xunto coas caixas concedidas. |



- Funcións dos usuarios administradores:

| Acción | Descrición|
| --- | --- |
| **Alta de usuarios** | Dar de alta ós usuarios na base de datos. |
| **Modificar os usuarios** | Modificación dos datos persoais dos usuarios na base de datos. |
| **Baixa de usuarios** | Eliminación de usuarios na base de datos. |
| **Consultar os usuarios** | Consulta dos datos dos usuarios rexistrados na base de datos. |
| **Alta de parcelas** | Dar de alta as parcelas pertencentes a cada usuario. |
| **Modificar parcelas** | Modificación dos datos das parcelas de cada usuario. |
| **Baixa de parcelas** | Eliminación de parcelas pertencentes aos usuarios. |
| **Consultar parcelas** | Consulta dos datos das parcelas. |
| **Alta de facturas** | Dar de alta as facturas na base de datos.|
| **Modificar as facturas**| Modificación dos datos das facturas na base de datos. |
| **Baixa de facturas** | Eliminación de facturas. |
| **Consultar facturas** | Consulta das facturas dos usuarios. |
| **Alta de ingresos** | Dar de alta os ingresos aos usuarios. |
| **Modificar os ingresos** | Modificación dos datos dos ingresos. |
| **Baixa dos ingresos** | Eliminacion dos ingresos dos usuarios. |
| **Consultar os ingresos** | Consulta dos ingresos dos usuarios. |
| **Alta días da vendima** | Dar de alta os días da vendima asignados a cada usuario xuntos cos caixas concedidas. |
| **Modificar días da vendima** | Modificación dos datos do días da vendima dos usuarios. |
| **Baixa días da vendima** | Eliminación dos días da vendima. |
| **Consultar días da vendima** | Consulta dos días da vendima dos usuarios.|
| **Alta albaráns entrega de uva** | Dar de alta os albaráns que xustifican a entrega de uva dos usuarios. |
| **Modificar albaráns de entrega de uva** | Modificacións dos datos dos albaráns de entrega de uva dos usuarios. |
| **Baixa albaráns de uva** | Eliminación dos albaráns de entrega de uva dos usuarios. |
| **Consultar albaráns de uva** | Consulta dos albaráns de entrega de uva dos proveedores. |
| **Consultar número proveedores** | Consultar o número de proveedores que ten a adega. |
| **Consultar débedas** | Consulta da cantidade que ten pendente de pagar cada usuario á empresa. |
| **Consultar pagos a proveedores** | Consulta da debéda que ten que pagar a empresa á cada usuario. |
| **Alta prezo** | Dar de alta o prezo por quilo de uva. |
| **Modificar o prezo** | Modificación do prezo por quilo de uva. |
| **Consulta da información sobre a vendima** | Consulta da normativa sobre a entrega de uva e das datas de comezo e remate da campaña.



## 3- Tipos de usuarios
Os usuarios que teñen acceso á aplicación clasifícanse en:
- Usuario rexistrado que terá acceso ao seguinte:
  - Datos persoais e das parcelas.
  - Datos das facturas de pago e cobro.
  - Información da vendima: data de inicio, data de fin, normas de entrega de uva, recibos de entrega da uva.
  
- Usuario administrador que terá acceso aos seguintes datos:
  - Datos dos proveedores de uva e das súas parcelas.
  - Datos das facturas de cobro e pago, así como a alta das mesmas.
  - Datos da vendima: albaráns de entrega de uva, normativa.
  - Alta das facturas, albaráns de entrega de uva, ingresos aos proveedores e prezo da colleita.

## 4- Contorno operacional
Os recursos que necesitan os usuarios para acceder á aplicación son: unha computadora que ten instalado un navegador web e unha conexión a Internet.



## 5- Normativa
A normativa que afecta á aplicación é a seguinte:
- [Lei 37/1992, do 28 de decembro, del Imposto sobre o Valor Engadido (IVE).](https://www.boe.es/buscar/act.php?id=BOE-A-1992-28740)

- [Real Decreto 1619/2012, do 30 de novembro sobre as obligacións de facturación onde as facturas emitidas deben incluir o IVE, a desagregación do prezo e os datos do emisor e receptor.](https://www.boe.es/buscar/act.php?id=BOE-A-2012-14696)

- [Lei 7/1998, do 13 de abril sobre as condicións xerais de contratación.](https://www.boe.es/buscar/act.php?id=BOE-A-1998-8789)
  
- [Lei 34/2002, do 11 de xulio sobre servizos da sociedade da información e de comercio electrónico ("LSSI").](https://www.boe.es/buscar/act.php?id=BOE-A-2002-13758)
  
- [Real Decreto Lexislativo 1/2007, do 16 de novembro onde apróbase o texto refundido da Lei Xeral para a Defensa dos Consumidores e Usuarios e outras leis complementarias.](https://www.boe.es/buscar/act.php?id=BOE-A-2007-20555)
  
- [Lei 24/2015, do 24 de xulio sobre patentes.](https://www.boe.es/buscar/act.php?id=BOE-A-2015-8328)
  
- [Reglamento Europeo 2016/679, do 27 de abril de 2016 sobre Protección de Datos](https://www.boe.es/doue/2016/119/L00001-00088.pdf)
  
- [Real Decreto 1112/2018, do 7 de setembro sobre accesibilidade dos sitios web e aplicacións para dispositivos móviles do sector público.](https://www.boe.es/buscar/act.php?id=BOE-A-2018-12699)
  
- [Lei Orgánica 3/2018, do 5 de decembro sobre Protección de Datos Personais e garantía dos dereitos dixitais (LOPDPGDD).](https://www.boe.es/buscar/act.php?id=BOE-A-2018-16673)
  
- [Reglamento Europeo 2019/771, do 20 de maio de 2019 sobre bens dixitais que obriga a proporcionar actualizacións e soporte durante un período de tempo razoable despois da venda.](https://www.boe.es/doue/2019/136/L00028-00050.pdf)
  


Para cumprir coas leis anteriores, incluirase na web os seguintes apartados:

  - **Aviso legal:** neste apartado recóllense os datos identificativos do titular da web co obxectivo de informar aos usuarios do propietario da páxina e mostrar as actividades da empresa.

  - **Política de privacidade:** neste apartado indícase quén é a persoa responsable do tratamento dos datos, neste caso a empresa vitivinícola, e para que fins se van utilizar. Tamén indicarase un apartado no que se informa ao usuario dos seus dereitos en materia de protección de datos (acceso, rectificación, cancelación e oposición), que neste caso os usuarios poderán exercer estes dereitos enviando un correo electrónico á empresa vitivinicola.

  - **Política de cookies:** neste apartado infórmarase aos usuarios de todas as cookies que se utilizan para recoller información.


Para implementar os apartados anteriores na web realizaranse as seguintes accións:

  1. Para cada un dos apartados crearase unha páxina web independente coa información correspondente e engadiremos un enlace a cada unha no pé de páxina, de xeito que esta información estea dispoñible para todos os usuarios.
   
  2. Engadiremos enlaces a estas políticas nos formularios da web onde o usuario debe marcar unha casa de verificación para indicar que coñecen as condicións e as aceptan.


E, por último, a aplicación debe ser accesible. Para elo, cumpriremos cos criterios de nivel A e AA dos estándares recollidos nas [Pautas de Accesibilidade para el Contenido Web 2.1 (WCAG 2.1)](https://www.w3.org/TR/WCAG21/) que abarcan dende os elementos que forman a composición dunha páxina web (como os contrastes das cores, os encabezados, os botóns, as ligazóns ou o funcionamento dos formularios) ata os máis técnicos (como a arquitectura interna da web, a estructura do código ou a súa navegabilidade).



## 6- Melloras futuras
As posibles melloras futuras da aplicación son:
- Adaptar á aplicación aos idiomas das zonas xeográficas nos que ten mercado.
- Personalizar a aplicación para que o cliente poida poñer o seu logo e as súas cores de marca.
- Modificar a aplicación para que se poida adaptar a diferentes empresas que recollen productos agrícolas como olivas, froitas, ...