# FASE DE CODIFICACIÓN E PROBAS

- [FASE DE CODIFICACIÓN E PROBAS](#fase-de-codificación-e-probas)
  - [1- Codificación](#1--codificación)
  - [2- Prototipos](#2--prototipos)
  - [3- Innovación](#3--innovación)
  - [4- Probas](#4--probas)

## 1- Codificación
O código da aplicación está ubicado na carpeta Proxecto e está dividido en dous cartafois:
- BD: Este cartafol contén os arquivos para crear a base de datos e os datos de exemplo da aplicación.
- Codigo: Este cartafol contén os arquivos co código da aplicación.



## 2- Prototipos
As funcións implementadas en cada páxina da aplicación son as seguintes:
1. Páxinas do usuario:
   1. Dashboard:
      - Comprobar os datos do usuario coa empresa: 
        - Cantidade pendente de pagar.
        - Cantidade pendente de ingresar a empresa.
        - Cupo de uva en quilos que ten o usuario.
        - Número de quilos entregados na recollida de uva.
        - Grao medio que tivo na campaña.
      - Comprobar a evolución, mediante gráficos dos quilos entregados, a media de graos por ano, os ingresos e os gastos, e a cantidade que ten pendente de pagar a bodega e a cantidade que a bodega abonou da deuda no ano actual.
      - Comprobar as últimas facturas e ingresos do usuario.  
   1. Consulta de documentos:
      - Consultar as facturas do usuario filtradas por ano.
      - Acceder ás facturas de anos anteriores.
      - Consultar os ingresos da empresa ao usuario filtrados por ano.
      - Acceder ás facturas de anos anteriores.
      - Descargar os documentos correspondentes a cada factura e ingreso.
   1. Vendimia
      1. Normativa:
         - Consultar as datas de inicio de fin da vendima.
         - Consultar os días que ten asignados de vendima e o número de caixas concedidas.
         - Consultar a normativa de entrega da uva.
      2. Albaráns:
         - Consultar os albaráns de entrega de uva filtrados por ano.
         - Acceder aos albaráns doutros anos.
         - Descargar o documento correspondente ao albarán.
         - Consultar o resumo de datos da colleita:
           - Total de quilos entregados.
           - Grao medio da colleita.
           - Datos financeiros da colleita: prezo, base impoñible, porcentaxe de retención e total a percibir.
   2. Perfil:
      - Consulta dos datos persoais do usuario.
      - Modificación dos datos persoais do usuario.
      - Cambiar o contrasinal do usuario.
      - Consultar as parcelas asociadas ao usuairo.


2. Páxinas do administrador:  
   As páxinas dos administradores son:
   1. Dashboard:
      - Comprobar os datos da empresa: 
        - Cantidade que ten pendente de pagar aos proveedores.
        - Cantidade que os proveedores teñen pendente de pagar á empresa en concepto de facturas.
        - Número de proveedores de uva que ten a bodega.
        - Cantidade de quilos entregados na vendima.
        - Graduación media desa campaña.
      - Comprobar a evolución, mediante gráficos, dos quilos entregados en total por todos os proveedores de uva, a media de graduación e a cantidade que ten de deuda cos proveedores e a cantidade de deuda pagada nese ano.
      - Comprobar aos últimos ingresos e facturas.
      - Comprobar a deuda que ten a empresa con cada proveedor, así como a cantidade que éstes débenlle á empresa.
   2. Alta usuario:
      - Engadir á base de datos un novo usuario.
      - Unha vez engadido o usuario, engadir as súas parcelas.
   3. Consultar usuarios:
      - Consultar os datos persoais dun usuario en concreto.
      - Modificar os datos persoais dun usuairo.
      - Dar de baixa un usuario na base de datos.
      - Consultar as parcelas asociadas a un usuario en concreto.
      - Modificar os datos dunha parcela.
      - Dar de baixa unha ou varias parcelas na base de datos.
   4. Consultar documentos:
      - Consultar os ingresos e facturas dun usuario en concreto filtrados por ano.
      - Acceder aos ingresos e facturas doutros anos.
      - Modificar os datos dunha factura en concreto.
      - Eliminar unha ou varias facturas e borrar un ou varios ingresos.
   5. Vendimia:
      1. Normativa:
         - Consulta das datas de inicio de fin da vendima.
         - Consulta da normativa da entrega da uva.
      2. Días vendima:
         - Consulta dos días asignados a un usuario xunto coas caixas concedidas para cada día.
         - Modificación da data vendima e as súas caixas asignadas.
         - Dar de baixa unha ou varias datas de vendima.
      3. Albaranes:
         - Consulta dos albaráns dun usuario en concreto filtrados por anos.
         - Acceder aos albaráns de anos anteriores.
         - Modificar os datos dos albaráns.
         - Eliminar un ou varios albaráns.
         - Consultar o resumo da colleita do ano consultado nos albaráns:
           - Total de quilos de uva entregados.
           - Grado medio da colleita.
           - Datos financeiros da colleita: prezo, base impoñible, a porcentaxe de retención e o total que a empresa ténlle que retribuír.
      4. Campañas:
         - Consultar o resumo da colleita dende o punto de vista da empresa:
           - Suma dos quilos de uva entregados polos proveedores.
           - Grado medio da colleita.
           - Datos financeiros: prezo da colleita, a base impoñible, a retención e o total de deuda que a empresa debe retribuír aos proveedores de uva.
           - Acceso ao resumo da colleita de anos anteriores.

Os prototipos da aplicación poden visualizarse no [arquivo do deseño da interface dos usuarios](arquivos/BaseInfoDB3.fig).



## 3- Innovación
Para este proxecto, ademais das tecnoloxías utilizadas no ciclo formativo (PHP, JavaScript, HTML, CSS) utilizouse SASS, qué un preprocesador CSS que estende as capacidades da linguaxe CSS mediante o uso de variables, mixins, anidamento, partials, funcións e operacións.

O manexo desta tecnoloxía é confusa ao principio porque existen dúas sintaxes: SCSS, que é similir a CSS ou indentada, que non ten chaves nin punto e coma e, tamén, ten unha estructura de código diferente xa que utiliza anidamento onde os selectores anídanse uns dentro de outros e emprega mixins que son bloques de código que agrupan propiedades que poden ser chamados en diferentes partes da folla de estilos.

Ademais, para o manexo desta tecnoloxía é necesario ter un compilador para traducir o código SASS a CSS, que pode ser un plugin dun entorno de desenvolvemento integrado como a extensión Live Sass Compliler en Visual Studio Code ou instalar SASS localmente utilizando Node.js.

Aínda que non tiña coñecementos previos sobre esta tecnoloxía, aprendelo foime moi doado xa que algúns dos coñecementos utilizados en CSS, como as variables, tamén se aplican en SASS e coa axuda dalgúns videotitoriais e un pouco de práctica conseguín aprendelo rápidamente.



## 4- Probas
As probas realizadas para o correcto funcionamento da aplicación son as seguintes:

1. Iniciar sesión  
   - Iniciar sesión con credenciais correctas --> Ao iniciar sesión á aplicación con credenciais correctas accédese á aplicación.
   - Iniciar sesión con credenciais incorrectas --> Ao iniciar sesión á aplicación con credenciais incorrectas mostra unha mensaxe de erro e non se accede á aplicación.

1. Cambiar contrasinal 
   - Cambiar contrasinal con correo erróneo -> Ao intentar cambiar o contrasinal se introduces un correo erróneo mostra unha mensaje de erro.
   - Validación do formulario --> Ao non cumprir cos requisitos dalgún campo non valida o formulario e mostra unha mensaxe de erro.

1. Probas xerais:
   1. Formularios:
      
      1. Formularios para dar de alta datos:
         - Se algún dos campos non está cuberto, o formulario non valida e mostra unha mensaxe de erro.
         - Se algún dos campos non cumpre cos requisitos dese campo o formulario non valida e mostra unha mensaxe de erro.
         - Se os campos son válidos o formulario valídase e garda os datos na base de datos.  
      
      1. Formularios para modificar os datos:
         - O formulario que mostra é acorde cos datos do documento a editar.
         - O formulario debe estar cumprimentado cos datos do documento que se vai editar.
         - Se algún dos campos non está cumprimentado ou non son correctos, o formulario non valida.
         - Se os campos son correctos, os datos do documento actualízanse.
  
      1. Formularios para consultar datos dos usuarios:
         - Se o campo non está cuberto ou non cumpre os requisitos, o formulario non se valida e mostra unha mensaxe de erro.
         - Se os campos son válidos, mostra os datos que se están a buscar correspondentes do usuario buscado.
  
      1. Notificacións dos formularios:
         - Se o campo a cubrir do formulario está incorrectamente cuberto deberá aparecer unha notificación cunha mensaxe advertindo do erro.
         - Se se fai click no botón que envía o formulario deberán suceder dúas cousas:
           - Se algún dos campos non están cubertos aparecerá unha mensaxe advertindo de que faltan campos por cubrir.
           - Se todos os campos están cubertos, pero hai algún que non cumpre os requisitos para estar correctos, deberá aparecer unha mensaxe indicando o erro.
           - Se todos os campos están cubertos e cumpren coas condicións requeridas, o formulario enviarase ao servidor e deberá aparecer unha mensaxe de que a operación realizouse correctamente.
  
    1. Táboas
       - Según o usuario logeado comprobar que aparecen as opcións que correspondentes a ese usuario:
          - Usuario: visualizar e descargar.
          - Administrador: visualizar, descargar, editar, borrar un rexistro e borrar varios rexitros.
  
       1. Accións:
          - Descargar o documento --> No caso das facturas, ingresos e albaráns pódese descargar o arquivo correspondente a ese documento.
          - Visualizar os rexistros --> Comprobar se os datos mostrados corresponden co rexistro da táboa seleccionado. No caso de seleccionar unha factura, ingreso ou albarán haberá un enlace para descargar o documento.
          - Editar os rexistros --> Comprobar se no formulario que aparece está cumprimentado cos datos do rexistro seleccionado. Nel o administrador pode cambiar aqueles que sexan incorrectos.
          - Borrar os rexistros --> Comprobar se borra o documento seleccionado na base de datos.
          - Borrar varios documentos --> Comprobar que os rexistros seleccionados se borran da base de datos.
    1. Ventás modais:
       - Comprobar que se poden abrir e cerrar as ventás modais.
       - Comprobar que mostran o contido correcto.

1. Dashboard  
   
   1. Resumo de datos: Mostra os datos correspondentes ao usuario que se logueou.
        - Administradores: No caso dos administradores mostra a cantidade que a empresa ten pendente de facturar, a cantidad que ten pendente de ingresar aos proveedores de uva, o número de proveedores dados de alta na aplicación, o número total de kilogramos entregados na campaña da vendima e a media de grado da uva da campaña.
        - Usuarios: No caso dos usuarios mostra o total de diñeiro que o usuario ten pendente de pagar á empresa (facturas), a cantidade que a empresa ténlle que pagar, o número de kilogramos que ten de cupo, o número de kilogramos entregados na campaña dese ano e a media dos grados de uva que tivo na campaña.
  
     1. Táboa de proveedores de uva: No caso dos administradores comprobar que móstrase unha táboa con todos os usuarios que non son administradores coa cantidade que teñen pendente de cobrar e a cantidade pendente de pagar de facturas.
  
     1. Táboa últimos movementos --> No caso do usuarios móstranse as súas últimas facturas e ingresos ordeados por data e no caso dos adminstradores móstrase as últimas facturas e ingresos da empresa ordeados por data
  
     1.  Gráficos --> Comprobar que se mostran as gráficas correspondentes a cada usuario cos seus datos.

 1. Partes da aplicación dependendo do usuario: 
   
    1. Administrador:       
   
        1. Alta usuario --> Comprobar que aparece un formulario onde se pode dar de alta a un usuario. Se o formulario é correcto, aparecerá debaixo unha sección para dar de alta as parcelas dos usuarios.

        1. Parcelas --> Comprobar que, ao dar de alta o usuario, aparece esta sección.
  
            1. Formulario parcelas:
               - Comprobar que aparece o formulario para engadir parcelas.
               - Comprobar o funcionamento do formulario.
               - Comprobar que se pode engadir unha nova parcela.
               - Comprobar que, ao engadir unha nova parcela, a táboa das parcelas actulízase para mostrar a nova parcela.
               - Comprobar que ao cubrir os datos da dirección e código postal móstrase un mapa onde aparece a parcela.
  
            1. Táboa parcelas --> Comprobar que se poden realizar as accións asociadas á parcela.
  
        1. Consultar usuarios:
           - Comprobar o funcionamento do formulario para consultar usuarios.
           - Comprobar que aparecen dúas seccións: os datos do usuario e as parcelas do usuario:

            1. Datos do usuario:
               - Comprobar que os datos que mostra son os do usuario seleccionado.
               - Comprobar que o botón editar datos mostra unha ventá modal cun formulario que mostra os campos cubertos cos datos do usuario seleccionado e comprobar o funcionamento do formulario.
               - Comprobar que o botón borrar usuario borra o usuario seleccionado.
  
            1. Táboa parcelas:
                - Comprobar que as parcelas que aparecen son as do usuario seleccionado.
                - Comprobar que se poden realizar as accións da táboa.
  
            1.  Formulario parcelas:
                - Comprobar que facendo clic no botón engadir parcela móstrase o formulario correspondente.
                - Comprobar que ao dar de alta a parcela actualízase a táboa de parcelas engadindo a parcela engadida.
        
        1. Consulta de documentos:
           - Comprobar o funcionamento do formulario para consultar usuarios.
           - Comprobar que aparecen dúas pestanas onde aparecen os documentos a consutar: facturas e ingresos do usuario:
           - Comprobar que, facendo clic en cada pestana, aparecen os documentos correspondentes.
           - Comprobar que se poden realizar as accións das táboas.
           - Comprobar que, a través dos botóns de navegación, móstranse as facturas ou ingresos do ano seleccionado.
     
        1. Vendimia
            - Comprobar que se mostran tres lapelas:
              1. Normativa: comprobar que mostra as normas de entrega de uva.
              1. Albaráns: 
                   - Comprobar o funcionamento do formulario para consultar usuarios.
                  - Comprobar que se mostran os albaráns e o resuma da campaña do usuario seleccionado.
                  - Comprobar que, mediante os botóns de navegacións, pódese acceder aos albaráns doutras campañas, así como o resumo da campaña dese ano.
                  - Formulario de alta dun albarán:
                     - Comprobar que permite gardar un albarán.
                     - Comprobar que o formulario mostra as parcelas que corresponden a o usuario propietario do albarán.
           
              1. Campañas:
                 - Comprobar que mostra o resumo da campaña dese ano.
                 - Comprobar que, mediante os botóns de navegación, pódense acceder aos resumos doutras campañas.
  
     1. Usuarios:  
         1. Mis documentos:
             - Comprobar que aparecen dúas lapelas: facturas e ingresos.
  
             1. Facturas:
                  - Comprobar que aparecen as facturas dese ano dese usuario ordeadas por data de máis nova a máis vella.
                  - Comprobar que se poden acceder ás facturas dos anos anteriores mediante os botóns de navegación.
                  - Comprobar que se poden realizar as accións da táboa.
  
            1. Ingresos:
               - Comprobar que aparecen os ingresos dese usuario e dese ano ordeadas por data máis nova.
               - Comprobar que se poden acceder aos ingresos de anos anteriores mediante os botóns de navegacións.
               - Comprobar que se poden realizar as accións das táboas.
        
        1. Vendima
             - Comprobar que aparecen dúas lapelas: normativa e albaráns.

             1. Normativa: 
                - Comprobar que aparece a normativa da entrega de uva.
             
             1. Albaráns:
                  - Comprobar que aparecen os albaráns dese ano e dese usuario ordeados pola data máis nova.
                  - Comprobar que se poden acceder aos albaráns de anos anteriores mediante as flechas de navegación.
                  - Comprobar que se poden realizar as accións das táboas.
                  
                  - Táboa resumen vendima:
                       - Comprobar que aparecen os datos correctos dese ano e dese usuario.
                       - Comprobar que, ao consultar os albaráns doutros anos, actualízase esta táboa para mostrar o resumo da vendima dese ano.
         1. Perfil
            - Comprobar que os datos mostrados son os do usuario logueado.
            - Comprobar que os botóns de editar perfil e cambiar contrasinal abren a correspondente ventá modal.
            - Táboa parcelas:
              - Comprobar que aparecen as parcelas correspondente ao usuario logueado.
              - Comprobar que aparecen os datos da parcela seleccionada.
              - Comprobar que aparece o mapa correspondente á parcela.
  
Realizadas as probas anteriores, pódese observar que o funcionamento da aplicación é correcto.

