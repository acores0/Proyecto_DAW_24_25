# FASE DE CODIFICACIÓN E PROBAS

- [FASE DE CODIFICACIÓN E PROBAS](#fase-de-codificación-e-probas)
  - [1- Codificación](#1--codificación)
  - [2- Prototipos](#2--prototipos)
  - [3- Innovación](#3--innovación)
  - [4- Probas](#4--probas)

## 1- Codificación
O código da aplicación está ubicado na carpeta Proxecto. Este cartafol está dividido en súas subcarpetas:
- BD: Este cartafol contén os arquivos para crear a base de datos e os datos de exemplo da mesma.
- Codigo: Este cartafol contén os arquivos co código da aplicación.



## 2- Prototipos

> A medida que se vai codificando crearanse varios prototipos, preferentemente realizados con Figma. Para cada un indicar unha descrición das funcionalidades implementadas.
>
> Debes ir incluindo unha mostra representativan dos prototipos da aplicación.
>
> Os proptotipos axudan no deseño da aplicación. Podes empregar:
>
> - [Sketch](https://www.sketch.com/)
> - [Figma](https://www.figma.com/). Recomendada
> - [Proto.io](https://proto.io/)
>
> A mellor opción é empregar Figma xa que esta é unha ferramenta en línea colavorativa. 
> **Comparte o prototipo cos profesores por medio de Figma ou descarga o arquivo local o cal subirás o teu repositorio de GitHub**.



## 3- Innovación



## 4- Probas
As probas realizadas para o correcto funcionamento da aplicación son as seguintes:

1. Iniciar sesión  
   - Iniciar sesión con credenciais correctas --> Ao iniciar sesión á aplicación con credenciais correctas accédese á aplicación.
   - Iniciar sesión con credenciais incorrectas --> Ao iniciar sesión á aplicación con credenciais incorrectas mostra unha mensaxe de erro e non se accede á aplicación.

1. Cambiar contrasinal 
   - Cambiar contrasinal con correo erróneo -> Ao intentar cambiar o contrasinal se introduces un correo erróneo mostra unha mensaje de erro.
   - Validación do formulario --> Ao non cumprir cos requisitos dalgún campo non valida o formulario e mostra unha mensaxe de erro.

2. Probas xerais:
   1. Formularios:
      
      1. Formularios para dar de alta datos:
         - Se algún dos campos non está cuberto, o formulario non valida e mostra unha mensaxe de erro.
         - Se algún dos campos non cumpre cos requisitos dese campo o formulario non valida e mostra unha mensaxe de erro.
         - Se os campos son válidos o formulario valídase e garda os datos na base de datos.  
      
      2. Formularios para editar os datos:
         - O formulario que mostra é acorde cos datos do documento a editar.
         - O formulario debe estar cumprimentado cos datos do documento que se vai editar.
         - Se algún dos campos non está cumprimentado ou non son correctos, o formulario non valida.
         - Se os campos son correctos, os datos do documento actualízanse.
  
      3. Formularios para consultar datos dos usuarios:
         - Se o campo non está cuberto ou non cumpre os requisitos, o formulario non se valida e mostra unha mensaxe de erro.
         - Se os campos son válidos, mostra os datos que se están a buscar correspondentes do usuario buscado.
  
    2. Táboas
       - Según o usuario logeado comprobar que aparecen as opcións que correspondentes a ese usuario:
          - Usuario: visualizar e descargar.
          - Administrador: visualizar, descargar, editar, borrar un rexistro e borrar varios rexitros.
  
       1. Accións:
          - Descargar o documento --> No caso das facturas, ingresos e albaráns pódese descargar o arquivo correspondente a ese documento.
          - Visualizar os rexistros --> Comprobar se os datos mostrados corresponden co rexistro da táboa seleccionado. No caso de seleccionar unha factura, ingreso ou albarán haberá un enlace para descargar o documento.
          - Editar os rexistros --> Comprobar se no formulario que aparece está cumprimentado cos datos do rexistro seleccionado. Nel o administrador pode cambiar aqueles que sexan incorrectos.
          - Borrar os rexistros --> Comprobar se borra o documento seleccionado na base de datos.
          - Borrar varios documentos --> Comprobar que os rexistros seleccionados se borran da base de datos.
    3. Ventás modais:
       - Comprobar que se poden abrir e cerrar as ventás modais.
       - Comprobar que mostran o contido correcto.

3. Dashboard  
   
   1. Resumo de datos: Mostra os datos correspondentes ao usuario que se logueou.
        - Administradores: No caso dos administradores mostra a cantidade que a empresa ten pendente de facturar, a cantidad que ten pendente de ingresar aos proveedores de uva, o número de proveedores dados de alta na aplicación, o número total de kilogramos entregados na campaña da vendima e a media de grado da uva da campaña.
        - Usuarios: No caso dos usuarios mostra o total de diñeiro que o usuario ten pendente de pagar á empresa (facturas), a cantidade que a empresa ténlle que pagar, o número de kilogramos que ten de cupo, o número de kilogramos entregados na campaña dese ano e a media dos grados de uva que tivo na campaña.
  
     1. Táboa de proveedores de uva: No caso dos administradores comprobar que móstrase unha táboa con todos os usuarios que non son administradores coa cantidade que teñen pendente de cobrar e a cantidade pendente de pagar de facturas.
  
     2. Táboa últimos movementos --> No caso do usuarios móstranse as súas últimas facturas e ingresos ordeados por data e no caso dos adminstradores móstrase as últimas facturas e ingresos da empresa ordeados por data
  
     3.  Gráficos --> Comprobar que se mostran as gráficas correspondentes a cada usuario cos seus datos.

 4. Partes da aplicación dependendo do usuario: 
   
    1. Administrador:       
   
        1. Alta usuario --> Comprobar que aparece un formulario onde se pode dar de alta a un usuario. Se o formulario é correcto, aparecerá debaixo unha sección para dar de alta as parcelas dos usuarios.

        2. Parcelas --> Comprobar que, ao dar de alta o usuario, aparece esta sección.
  
            1. Formulario parcelas:
               - Comprobar que aparece o formulario para engadir parcelas.
               - Comprobar o funcionamento do formulario.
               - Comprobar que se pode engadir unha nova parcela.
               - Comprobar que, ao engadir unha nova parcela, a táboa das parcelas actulízase para mostrar a nova parcela.
               - Comprobar que ao cubrir os datos da dirección e código postal móstrase un mapa onde aparece a parcela.
  
            2. Táboa parcelas --> Comprobar que se poden realizar as accións asociadas á parcela.
  
        3. Consultar usuarios:
           - Comprobar o funcionamento do formulario para consultar usuarios.
           - Comprobar que aparecen dúas seccións: os datos do usuario e as parcelas do usuario:

            1. Datos do usuario:
               - Comprobar que os datos que mostra son os do usuario seleccionado.
               - Comprobar que o botón editar datos mostra unha ventá modal cun formulario que mostra os campos cubertos cos datos do usuario seleccionado e comprobar o funcionamento do formulario.
               - Comprobar que o botón borrar usuario borra o usuario seleccionado.
  
            2. Táboa parcelas:
                - Comprobar que as parcelas que aparecen son as do usuario seleccionado.
                - Comprobar que se poden realizar as accións da táboa.
  
            3.  Formulario parcelas:
                - Comprobar que facendo clic no botón engadir parcela móstrase o formulario correspondente.
                - Comprobar que ao dar de alta a parcela actualízase a táboa de parcelas engadindo a parcela engadida.
        
        4. Consulta de documentos:
           - Comprobar o funcionamento do formulario para consultar usuarios.
           - Comprobar que aparecen dúas pestanas onde aparecen os documentos a consutar: facturas e ingresos do usuario:
           - Comprobar que, facendo clic en cada pestana, aparecen os documentos correspondentes.
           - Comprobar que se poden realizar as accións das táboas.
           - Comprobar que, a través dos botóns de navegación, móstranse as facturas ou ingresos do ano seleccionado.
     
        5. Vendimia
            - Comprobar que se mostran tres lapelas:
              1. Normativa: comprobar que mostra as normas de entrega de uva.
              2. Albaráns: 
                   - Comprobar o funcionamento do formulario para consultar usuarios.
                  - Comprobar que se mostran os albaráns e o resuma da campaña do usuario seleccionado.
                  - Comprobar que, mediante os botóns de navegacións, pódese acceder aos albaráns doutras campañas, así como o resumo da campaña dese ano.
                  1. Formulario de alta dun albarán:
                     - Comprobar que permite gardar un albarán.
                     - Comprobar que o formulario mostra as parcelas que corresponden a o usuario propietario do albarán.
           
              3. Campañas:
               - Comprobar que mostra o resumo da campaña dese ano.
               - Comprobar que, mediante os botóns de navegación, pódense acceder aos resumos doutras campañas.
  
     2. Usuarios:  
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
             
             2. Albaráns:
                  - Comprobar que aparecen os albaráns dese ano e dese usuario ordeados por data máis nova.
                  - Comprobar que se poden acceder aos albaráns de anos anteriores mediante as flechas de navegación.
                  - Comprobar que se poden realizar as accións das táboas.
                  
                  1. Táboa resumen vendima:
                       - Comprobar que aparecen os datos correctos dese ano e dese usuario.
                       - Comprobar que, ao consultar os albaráns doutros anos, actualízase esta táboa para mostrar o resumo da vendima dese ano.

Realizadas as probas anteriores, pódese observar que o funcionamento da aplicación é correcto.

