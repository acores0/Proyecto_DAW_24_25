# FASE DE IMPLANTACIÓN

- [FASE DE IMPLANTACIÓN](#fase-de-implantación)
  - [1- Manual técnico](#1--manual-técnico)
    - [1.1- Instalación](#11--instalación)
    - [1.2- Administración do sistema](#12--administración-do-sistema)
  - [2- Manual de usuario](#2--manual-de-usuario)
  - [3- Melloras futuras](#3--melloras-futuras)

## 1- Manual técnico

### 1.1- Instalación

Para a implantación da aplicación web necesítanse ter os seguintes requisitos de software:
   - Servidor web.
   - Servidor de base de datos.
   - APIs: 
     - API do INE para obter o nome dun municipio mediante o seu código postal.
     - API de openstreetmaps para obter as coordenadas xeográficas da ubicación das parcelas para mostralas nun mapa.

Unha vez que se cumpren os requisitos de software realizaránse os seguintes pasos para a implantar a aplicación:
  1. **Creación da estructura da base de datos.**   
  Executarase o script estructuraBD.sql ubicado no cartafol BD na base de datos para crear a estructura da mesma.

  1. **Creación dos usuarios da aplicación**  
  A continuación crearánse os usuarios que van a ser os administradores da aplicación. Para elo necesítanse os seguintes datos de cada un deles: DNI, nome, apelidos, dirección, código postal, municipio, provincia, correo electrónico que utilizaráse para o acceso do usuario á aplicación, contrasinal de acceso á aplicación e teléfono. 
  Unha vez recadados os datos anteriores de cada un dos usuarios que van ser administradores, executarase o arquivo altaAdministradores.php ubicado no cartafol usuarios que contén un formulario onde se introducirán os datos anterior para dar de alta na base de datos os usuarios administradores.

  1. **Carga de datos de exemplo.**  
  Este paso é opcional. Se é necesario mostrar o funcionamento da aplicación, cargarase na base de datos o arquivo datosExemplo.sql  ubicado no cartafol BD que contén datos de exemplo da aplicación.

  1. **Carga dos arquivos da aplicación**  
  Carga dos arquivos da aplicación no cartafol do dominio configurado no servidor web. 

  1. **Acceso á aplicación**  
  Accederase á aplicación a través do dominio da aplicación.

  1. **Creación dos usuarios da aplicación**  
  Para dar de alta os usuarios da aplicación os administradores utilizarán o formulario ubicado na sección "Alta usuarios" no menú da aplicación. Unha vez dados de alta na aplicación, para cada un dos usuarios poñeráselle un contrasinal por defecto que deberán cambiar ao acceder á aplicación mediante o formulario cambiar contrasinal ubicado no inicio da aplicación.

  1. **Uso da aplicación**  
  Tanto os usuarios como os administradores poderán acceder á aplicación a traves do dominio web da mesma e utilizando como credenciais o seu correo electrónico e o seu contrasinal.



### 1.2- Administración do sistema

Para a administración do sistema realizaránse as seguintes tarefas:
- Administración do servidor web:
  - Monitorización e actualización do software do servidor web.
  - Configurar un firewall para limitar o acceso a portos non utilizados.
  - Revisión dos arquivos de rexistro de incidencias access.log y error.log para identificar problemas de accesos non autorizados.
  - Utilizar ferramentas de monitoreo para supervisar a cargar do servidor e o rendemento.

- Administración do servidor de base de datos:
  - Optimizar as consultas e os índices para garantiza o rendemento.
  - Configurar copias de seguridade automáticas diarias.
  - Realizar probas de restauración das copias de seguridade para garantizar o seu funcionamento.

- Administración do servidor:
  - Monitorizar o uso do espazo en disco configurando alertas para evitar que o disco duro énchase.
  - Realizar copias de seguridade dos arquivos subidos polos usuarios.
  - Realizar escaneos con ferramentas antivirus para evitar malware.



## 2- Manual de usuario

Para a utilización da aplicación non é necesarios que os usuarios teñan uns coñecementos específicos de informática, pero para calquera duda sobre o funcionamento da aplicación póñese á disposición dos usuarios un manual de usuario específico para cada tipo de usuario.
[Manual de usuario](arquivos/Manual_de_usuario.pdf)
[Manual de usuario administrador](arquivos/Manual_de_administrador.pdf)



## 3- Melloras futuras

Como melloras futuras propóñense as seguintes:
- Integración dun chat que permita a comunicación directa entre os proveedores de uva e a empresa. A través deste chat os usuarios poderán realizar consultas á empresa e ésta poderá enviar notificacións aos usuarios.
- Integración da aplicación coas APIs de Google, Facebook e Apple para permitir o inicio de sesión na aplicación a través dunha conta de correo das mesmas.
- Adaptar á aplicación aos idiomas dos países nos que ten mercado á aplicación.
- Adaptar á aplicación a diferentes empresas que recollen productos agricolas como as olivas, as froitas, ...
- Implementar un sistema que permita exportar os datos en formato xls, PDF ou CSV para a integración dos datos con paquetes estadísticos como SPSS/PSPP, R/RStudio, JASP ou Jamovi para analizar as tendencias productivas.
- Converter a aplicación nun módulo que se poidan integrar nun sistema ERP que permita xestionar os procesos da empresa.
