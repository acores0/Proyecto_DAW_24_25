# Proxecto fin de ciclo

- [Proxecto fin de ciclo](#proxecto-fin-de-ciclo)
  - [Taboleiro do proxecto](#taboleiro-do-proxecto)
  - [Descrición](#descrición)
  - [Instalación / Posta en marcha](#instalación--posta-en-marcha)
  - [Uso](#uso)
  - [Sobre o autor](#sobre-o-autor)
  - [Licenza](#licenza)
  - [Índice](#índice)
  - [Guía de contribución](#guía-de-contribución)
  - [Ligazóns](#ligazóns)

## Taboleiro do proxecto
Proxecto finalizado.



## Descrición
O proxecto consiste na creación dunha aplicación web totalmente funcional, capaz de xestionar a información en tempo real relativa aos proveedores de uva dunha empresa vitivinícola. O obxectivo da aplicación é dar servizo a aquelas que non contan cun software específico que intercambie información cos seus proveedores e proporcionar unha vía de comunicación e consulta entre a empresa e os seus proveedores sen que estes teñan que desprazarse presencialmente á empresa para obter a información. Ademáis, a aplicación permite realizar pequenas xestións como a descarga das facturas e ingresos ou consultar a información referente á campaña da vendima.
 
As tecnoloxías empregadas para a realización do proxecto son: PHP, JavaScript, HTML e SASS.



## Instalación / Posta en marcha
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



## Uso
O obxetivo da interface da aplicación é proporcionar unha plataforma intuitiva e accesible que permita aos usuarios xestionar e visualizar a información sobre as transaccións financeiras permitindo realizar un seguimento dos pagos pendentes e os ingresos realizados por parte da empresa. 

Os principais aspectos do seu funcionamento son:
- Implementar un sistema de autenticación de usuarios onde cada usuario só poida acceder á sua información.
- Facilitar o rápido acceso á información clave aos usuarios.
- Mostrar gráficos dinámicos que visualizan os datos dos proveedores actualizados en tempo real.
- Permitir o acceso á aplicación dende calquera dispositivo, como un ordenador, tablet ou móbil.
- Ofrecer unha visión global dos datos consultando un panel principal que mostra os datos económicos das facturas e ingresos e un resumo dos datos da colleita.
- Acceder ao histórico dos documentos.
- Visualizar os datos da recollida de uva incluíndo datas, cantidades e calidades.



## Sobre o autor
Son unha desenvolvedora web con coñecementos nas tecnoloxías PHP, JavaScript, HTML e CSS. Especialízome na creación de aplicacións web dinámicas e responsivas, o que me permite desenvolver proxectos personalizados. Entre os meus puntos fortes inclúense a capacidade para resolver problemas e a atención ao detalle.

A miña motivación para este proxecto está dirixido ao nicho de mercado das pequenas bodegas locais que necesitan unha vía de comunicación sinxela e accesible entre elas e os seus proveedores de uva.

Para garantir a comunicación durante o proceso de creación do proxecto pódeste pór en contacto comigo a través do meu correo electrónico arancolo25@gmail.com ou mediante o meu teléfono.



## Licenza
O proxecto atópase licenciado baixo a licenza GNU Free Documentation License Version 3.



## Índice
1. [Anteproxecto](Documentacion/1_Anteproxecto.md)
2. [Análise](Documentacion//2_Analise.md)
3. [Deseño](Documentacion//3_Deseño.md)
4. [Codificación e probas](Documentacion/4_Codificacion_e_probas.md)
5. [Implantación](Documentacion/5_Implantación.md)
6. [Referencias](Documentacion/6_Referencias.md)
7. [Incidencias](Documentacion/7_Incidencias.md)



## Guía de contribución
A aplicación pode colaborar cun software de xestión integral sendo un dos módulos que o conforman. Ademáis, as funcionalidades que se lle poden engadir son: 
  - Crear unha nova páxina que permita gardar o rexistro dos fitosanitarios empregados nas parcelas.
  - Integrar a aplicación co proxecto wIméteo de xeito que se mostre a información metereolóxica das parcelas en tempo real.



## Ligazóns
 - [URL da aplicación](http://baseinfodb3.rial.com.es/)