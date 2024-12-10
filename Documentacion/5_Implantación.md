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
   - Dominio.
   - APIs: 
     - API do INE para obter o nome dun municipio e a provincia á que pertence mediante o seu código postal.
     - API de openstreetmaps para obter as coordenadas xeográficas da ubicación das parcelas para mostralas nun mapa.

Unha vez que se cumpren os requisitos de software realizaranse os seguintes pasos para a implantar a aplicación:
  1. **Creación da estructura da base de datos.**   
  Executarase na base de datos o script BD.sql ubicado no cartafol BD do proxecto para crear a estructura da mesma.

  1. **Creación dos administradores da aplicación**  
  A continuación crearanse os usuarios que van a ser os administradores da aplicación. Para elo necesítanse recadar os seguintes datos de cada un deles: DNI, nome, apelidos e correo electrónico. Unha vez recollidos os datos anteriores executarase o arquivo UsuariosAdmin.php localizado no cartafol controlador que contén un modelo de código para crear os usuarios. Despois de crear os usuarios, por motivos de seguridade eliminarase este arquivo.

  1. **Carga de datos de exemplo.**  
  Se é necesario mostrar o funcionamento da aplicación, cargarase na base de datos o arquivo datosExemplo.sql ubicado no cartafol BD que contén datos de exemplo. Este paso é opcional.

  1. **Carga dos arquivos da aplicación**  
  Cargaranse os arquivos da aplicación no cartafol do dominio configurado no servidor web.

  1. **Creación dos usuarios da aplicación**  
  Para dar de alta os usuarios da aplicación os administradores utilizarán o formulario ubicado na páxina "Alta usuarios" á que se pode acceder dende o menú da aplicación. Unha vez dados de alta na aplicación, para cada un dos usuarios poñeráselle un contrasinal por defecto que deberán cambiar ao acceder á aplicación mediante o formulario cambiar contrasinal ubicado no inicio da aplicación.

  1. **Acceso á aplicación**  
  Tanto os usuarios como os administradores poderán acceder á aplicación a traves do dominio web da mesma utilizando como credenciais o seu correo electrónico e o seu contrasinal.

Para probar o funcionamento da aplicación pódese acceder á [URL da aplicación](http://baseinfodb3.rial.com.es/) coas seguintes credenciais:
- **Usuario**:
  - Correo: arancha@daw.es
  - Contrasinal: Arancha123.
- **Administrador**:
  - Correo: administrador@baseinfodb3.es
  - Contrasinal: Arancha123.



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
[Manual de usuario](arquivos/Manual_usuario.pdf)  
[Manual de usuario administrador](arquivos/Manual_administrador.pdf)



## 3- Melloras futuras
Como melloras futuras propóñense as seguintes:
- Integración da aplicación coas APIs de Google, Facebook e Apple para permitir o inicio de sesión na aplicación a través dunha conta de correo das mesmas.
- Implementación dun sistema que permita exportar os datos en formato xls, PDF ou CSV para a integración dos datos con paquetes estadísticos como SPSS/PSPP, R/RStudio, JASP ou Jamovi para analizar as tendencias productivas.
- Conversión da aplicación nun módulo que se poidan integrar nun sistema ERP que permita xestionar os procesos da empresa.
