# Anteproxecto fin de ciclo

- [Anteproxecto fin de ciclo](#anteproxecto-fin-de-ciclo)
  - [1- Descrición do proxecto](#1--descrición-do-proxecto)
  - [2- Empresa](#2--empresa)
    - [2.1- Idea de negocio](#21--idea-de-negocio)
    - [2.2- Xustificación da idea](#22--xustificación-da-idea)
  - [Análise DAFO](#análise-dafo)
    - [2.3- Segmento de clientes](#23--segmento-de-clientes)
    - [2.4- Competencia](#24--competencia)
    - [2.5- Proposta de valor](#25--proposta-de-valor)
    - [2.6- Forma xurídica](#26--forma-xurídica)
    - [2.7- Investimentos](#27--investimentos)
      - [2.7.1- Custos](#271--custos)
      - [2.7.2- Ingresos](#272--ingresos)
    - [2.8- Viabilidade](#28--viabilidade)
      - [2.8.1- Viabilidade técnica](#281--viabilidade-técnica)
      - [2.8.2 - Viabilidade económica](#282---viabilidade-económica)
      - [2.8.3- Conclusión](#283--conclusión)
  - [3- Requirimentos técnicos](#3--requirimentos-técnicos)
  - [4- Planificación](#4--planificación)


## 1- Descrición do proxecto
O proxecto consiste na creación dunha aplicación web para xestionar a información relativa aos proveedores de uva dunha empresa vitivinícola dando servizo a aquelas que non teñen un software específico que intercambie información cos seus proveedores, sendo o propósito principal ser unha vía de comunicación de consulta de información e realización de pequenos trámites.

Os principais obxectivos son:
- Manter ao proveedor informado en todo momento dos datos de facturación coa empresa.
- Consultar información relacionada coa rendibilidade productiva das parcelas. 
- Acceder ás facturas pendentes de pago e cobro, así como descargar as mesmas.
- Realización de pequenos trámites como a solicitude dos días de entrega de uva e a descarga do modelo de liquidación do IRPF daqueles proveedores que estean suxeitos.

Para comercializar a aplicación necesitamos os seguintes recursos: 
- Un hosting que aloxará a aplicación, no que se instalará un servidor web, unha linguaxe de servidor e unha base de datos. 
- Un subdominio no dominio web da empresa. Se a empresa non ten un dominio propio proporcionarase o servizo para contratar un.

Ademáis, para que o cliente poida utilizar a aplicación será necesario que pague unha licenza baseada en suscripción na que pode utilizar o software durante un período de tempo, neste caso dun ano, pero non ten a propiedade do software nin pode seguir utilizándoo se non renova a suscripción.
 
As tecnoloxías que se utilizarán para a realización do proxecto son PHP, JavaScript, HTML e CSS.




## 2- Empresa


### 2.1- Idea de negocio
O producto central da empresa é unha aplicación web que mostra información referente aos proveedores de uva dunha empresa vitivinícola a través da súa páxina web.

O valor engadido da aplicación radica nas seguintes características:
- Accesibilidade e flexibilidade: os usuarios poden acceder á aplicación dende calquer lugar con conexión a internet e mediante calquer dispositivo como unha tableta, un móvil ou unha computadora.
- Custos reducidos: 
- Facilidade de uso e distribución: non require instalación
- 


### 2.2- Xustificación da idea
A idea xorde da necesidade do intercambio de datos entre as empresas vitivinícolas e os seus proveedores de uva e solventar a necesidade de poder consultar os datos de facturación coa bodega a tempo real e realizar pequenas xestións como a descarga das facturas pendentes de pago e cobro ou consultar a información referente á campaña da vendima sen ter que ir os proveedores de uva presencialmente á bodega para pedir a información e realizar eses trámites.

O software que utilizan as grandes empresas vitivinícolas é mais completo de xeito que, de cara ós clientes, soe ter un módulo que conecta a base de datos da empresa cunha páxina web, pero non teñen este servizo de cara aos proveedores e o software das pequenas empresas é mais simple, de xeito que non ofertan estes servizos.

Na actualidade, as aplicacións que existen céntranse en mellorar a comunicación entre a empresa e os seus clientes, pero olvídanse das relacións cos seus proveedores. Esta aplicación pretende mellorar esas relacións aportando un intercambio de información das transaccións económicas dos proveedores coas empresas vitivinícolas, de xeito que éstes poidan consultar esa información en tempo real.


Análise DAFO
---

| Fortalezas |  | Oportunidades |
| --- | --- | --- |
| Custos baixos de implantación do software para o cliente| | Posibilidade de expandir a aplicación cara outros sectores |
| Personalización do software | | Posibilidade de expansión cara outras empresas do sector agrícola | 
| A aplicación cubre unha necesidade sen cubrir das empresas | | Dixitalización das empresas que buscan aplicacións e solucións informáticas.


| Debilidades |  | Ameazas |
| --- | --- | --- |
| Falta de experiencia | | Empresa vulnerable ante grandes competidores |
| Empresa nova no sector | | Facilidade de entrada de novos competidores no mercado |
| Escasa imaxe de marca | | Dificultade para obter financiación bancaria |


### 2.3- Segmento de clientes
A aplicación está dirixida a aquelas empresas vitivinícolas que non teñen un servizo de comunicación dixital entre a súa empresa e os proveedores de uva. 

Segundo datos do "Directorio Central de Empresas (DIRCE)" do "Instituto Nacional de Estadística (INE)", en España, no ano 2022 había un total de [4.078 bodegas](./img/Numero-bodegas-de-vino.webp). Para a aplicación, centrarémonos nas empresas pertencentes á denominación de orixe Rias Baixas que comprende un total de x bodegas, sendo estas os clientes da aplicación e os seus proveedores de uva os usuarios da mesma.


### 2.4- Competencia
Actualmente, as grandes empresas vitivinícolas utilizan un ERP, que é un software que permite centralizar nunha única base de datos todos os procesos da empresa de xeito que se permite realizar unha xestión unificada das áreas da empresa.

Un ERP está composto por módulos que xestionan as diferentes áreas da empresa onde cada empresa selecciona os módulos que son necesarios e se adaptan a ela.

Entre os seus módulos soe haber un módulo para comunicar a base de datos cun servidor web para realizar a xestión dunha tenda electrónica. Este tipo de servizo soe estar centrado nos clientes, de xeito que éstes poden consultar información a través da páxina, como os pedidos realizados, as facturas emitidas, a xestión de reclamacións,... etc, pero non soen ter esta comunicación cos proveedores.

Os principais ERPs que hai no mercado son: SAP, Oracle, Microsoft e Odoo, aínda que existen algúns ERP españois como Navision e Axapta.

As pequenas e medianas empresas soen ter software máis sinxelo que non soen ofertar servizos de intercambio de información entre a empresa e os proveedores.



### 2.5- Proposta de valor
O principal obxectivo das empresas é a comunicación cos seus clientes mentres que o principal obxectivo desta aplicación é mellorar a comunicación das empresas vitivinícolas cos seus proveedores de uva.

A través da nosa aplicación os proveedores de uva poderán estar informados en todo momento dos seus datos financeiros e da vendima que teñen coa bodega, ademáis de que poderán realizar pequenas xestións como descargar facturas, consultar información doutros anos, ... entre outros, sen ter que ir persoalmente ás instalacións da mesma.



### 2.6- Forma xurídica
A forma xurídica escollida é autónomo debido a que non se necesita capital inicial para constituir a empresa e os únicos trámites que hai realizar é darse de alta no "Régimen Especial de Trabajadores Autónomos" na Seguridade Social e darse de alta no "Centro de Empresarios" na Axencia Tributaria.

Ademáis, debido a que se cumpren os requisitos para a subvención "Cuota cero" dirixida ás persoas que emprenden por primeira vez estaremos exentos de pagar a cota a seguridade social de autónomos durante 12 meses prorrogables por outros 12 meses se temos rendementos netos inferiores ao Salario Mínimo Interprofesional (SMI).



### 2.7- Investimentos
Debido a que a empresa é de nova creación, decidiuse ubicar no [viveiro de empresas do IES Armando Cotarelo Valledor](https://viveirodeempresas.iescotarelo.es/) porque proporciona unhas instalacións e servizos de xeito gratuíto e, ademáis, conta con asesoramento profesional e personalizado.

O viveiro de empresas inclúe servizos como a luz, auga, mobiliario, equipos informáticos e a tarifa de internet e permite aforrarnos os gastos de lixo, aluguer do local, o seguro de impago do aluguer e o seguro da oficina.

Ademáis, aínda que non é obrigatorio, decidíuse contratar un seguro de responsabilidade civil para autónomos que cubre os posibles danos tanto persoais como materiais que poida causar a actividade a terceiras persoas de xeito involuntario que ten un custe duns 120€ ao ano.

Ademáis, para poder traballar fóra da oficina decidiuse adquirir un [ordenador portátil](img/Prezo_portatil.png) valorado en 199€.

Entre os tipos de hosting ofertados, decidiuse contratar un [hosting de servidor privado virtual](img/Prezo_hosting.png) que aloxará a páxina web da empresa e a aplicación que custa 6,64€ ao mes e un [dominio](img/Prezo_dominio.png), que custa uns 6.95€ ao ano (dominio .es).

Para a comunicación entre a empresa e os seus clientes, ademáis de medios dixitais, optouse por contratar un [liña de teléfono](img/Prezo_tarifa_telefono.png) para empresas cun custo de 12'40€ ao mes e a compra dun [teléfono móvil](img/Prezo_smartphone.png) cun custo de 99€.

Para a xestión administrativa optouse por contratar os servizos dunha [asesoría](img/Prezo_asesoria.png) online que ten un custo de 29'95€ ao mes.

Ademáis, como a nosa empresa garda datos dos clientes, é obrigatorio ter un servizo de protección de datos que ten un custo de 60€ ao ano.

Por último, para a xestión dos pagos e cobros da empresa contratouse unha conta corrente de autónomos cun custe de mantemento de 30€ cada seis meses.



#### 2.7.1- Custos
| Investimentos: | | |
| --- | --- | ---: |
| Equipo informático | | 199€
| Teléfono móvil | | 99€



| Custos fixos (prezo anual): | | |
| --- | --- | ---: |
| Dominio web | | 6,95 €
| Servizo de protección de datos | | 60,00 €
| Seguro responsabilidade civil de autónomos | | 120,00 €
| Gastos bancarios | |  60,00 €
| Hosting | | 79,71 €
| Liña de teléfono | | 108,00 €
| Asesoría | | 359,40 €
| Cotización á Seguridade Social | | 0,00 €
| Soldos | | 15.876,00 €


| Custos variables:  | | |
| --- | --- | ---: |
| Kilometraxe | | 2.259,40 € |
| Márketing e publicidade | | 1.000,00 € |



En total a empresa, o primeiro ano, ten uns gastos anuais de 20.187,46€.

#### 2.7.2- Ingresos
A comercialización da aplicación realizarase mediante unha licenza basada en suscripción por un período anual renovable que inclúe o o uso do software, as actualizacións e o soporte da mesma, pero se o cliente non renova a suscripción, non pode seguir utilizándoa.

A empresa fíxase como obxectivo ter 6 novos clientes ao mes, de xeito que ao ano tería uns 72 clientes.

Para calcular o prezo da aplicación utilizouse a seguinte fórmula:
$$\text{Prezo} = \frac{\text{total custos}} {\text{número de clientes obxectivo dun ano}} + 5\% \text{de ganancias} = \frac{\text{120.187,46 €}}{\text{72}} \times 5\%  \equal 22€$$

Polo tanto, o prezo da suscripción á aplicación ten un prezo de 22€ ao mes sendo o custe total para o cliente duns 264€ ao ano.

A este prezo, no caso de que o cliente non tivera un dominio propio, sumaríaselle o prezo do dominio.


### 2.8- Viabilidade

#### 2.8.1- Viabilidade técnica
Para poñer en marcha este proxecto son necesarios os seguintes recursos:
 1. Tecnoloxías utilizadas: PHP, JavaScript, HTML, CSS e MySQL.
 2. Recursos dispoñibles: técnico en desenvolvemento de aplicacións web, hosting, ferramentas de entorno de desenrolo integrado como VSCode, equipo informático, hosting, servidor web, servidor de base de datos, local e mobiliario de oficina.
 3. Integración con sistemas existentes como APIs.
 4. Prazos de desenrolo: 240 horas.
 5. Seguridade: copias de seguridade, tanto do sistema como da base de datos, control de incidencias mediante o acceso aos log do sistema e do servidor web.


O proxecto é viable dende o punto de vista técnico xa que conta cos recursos necesarios para o correcto funcionamento da actividade.



#### 2.8.2 - Viabilidade económica
Según os datos aportados nos apartados anteriores, podemos realizar a seguinte táboa:
![Imaxe dos custos e ingresos](./img/Prevision_gastos_ingresos.png)

Dos datos anteriores pódese deducir o seguinte:
- A inversión inicial da empresa é de 1.927,90€.
- A empresa, todos os meses ten os gastos fixos do servidor, asesoría, liña de teléfono, soldos e cotización á seguridade social que ten un custo dus 1.445,95€ ao mes, excepto nos meses de xuño e decembro no que se engade o custo da comisión de mantemento da conta bancaria.
- Durante o primeiro ano a empresa ten uns custos totais de 17.860,35€.
- As cifras de vendas son estables durante todo o ano debido a que a empresa marcouse un obxectivo de 6 novos clientes cada mes.
- Durante o primeiro ano a empresa ten uns ingresos totais de 18.144€.
- Os ingresos da empresa son maiores que os gastos en todos os meses do primeiro ano, excepto no primeiro mes debido á inversión inicial da empresa, de xeito que non hai problemas de liquidez que motiven a utilizar fontes de financiación externa.





#### 2.8.3- Conclusión
Segun os datos explicados no apartado anterior, a empresa, no primeiro ano, ten uns gastos totais de 17.860,35€ e uns ingresos totais de 18.144€. 

Polo tanto a empresa é viable técnicamente, xa que conta cos recursos necesarios para realizar a actividade, e económicamente xa que, ao final do primeiro ano, ten uns beneficios de 286,65€.



## 3- Requirimentos técnicos
- **Infraestructura:** 
  - Dominio web.
  - Hosting de servidor privado virtual (VPS):
    - Almacenamento: 50 GB de espazo en disco.
    - Memoria: 4GB RAM.
  - Servidor web Apache.
  - Servidor de base de datos MySQL.
- **Backend:** 
  - PHP.
- **Frontend:** 
  - JavaScript
  - HTML
  - CSS.

## 4- Planificación
![Diagrama de Gant](img/Diagrama_Gantt.png)
