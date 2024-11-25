<?php 
//Añadimos los archivos del modelo
$archivosModelo = glob('../modelo/*.php');

foreach ($archivosModelo as $archivo) {
    require_once $archivo;
}

//? Datos de los usuarios
/*$contrasinal = password_hash('abc123.', PASSWORD_DEFAULT);
$usuario = new Usuarios("46001270M", "Arancha Cores López", "Paseo Mayor, 18", "27742", "Trabada", "Lugo", "", $contrasinal, "cheque");
echo $usuario->mostrarUsuario();
$usuario->guardarUsuario();*/

$usuario = new Usuarios();
$contrasinal = password_hash('abc123.', PASSWORD_DEFAULT);
$usuario->cambiarContrasinal($contrasinal, "administrador@scientist.com");


//? Datos de las parcelas
//$parcela1 = new Parcelas("46001270M", "Prueba", "Bulevar Mayor, 2, 15317, A Laracha, A Coruña", "41°54'10'' N y 12°27'20'' E", 1000.0, "Albariño", 3000.0);
//$parcela1->guardarParcela();

//$parcela2 = new Parcelas("46001270M", "Probando", "Carrera Iglesia, 88, 33484, Colunga(Asturias)", "41°54'10'' N y 12°27'20'' E", 5000.0, "Caíño", 10000.0);
//$parcela2->guardarParcela();


//? Datos de las facturas
/* $facturas1 = new Facturas("46001270M", "Compra fitosanitarios", "2023-06-06", "34.36", "8.00", "52.02");
$facturas1->guardarFactura();

$facturas2 = new Facturas("46001270M", "Compra cordel", "2023-05-13", "33.59", "2.00", "40.29");
$facturas2->guardarFactura();

$facturas3 = new Facturas("46001270M", "Análisis suelo", "2024-07-16", "69.52", "7.00", "72.34");
$facturas3->guardarFactura();

$facturas4 = new Facturas("91742808V", "Compra fitosanitarios", "2023-03-04", "66.55", "6.00", "67.06");
$facturas4->guardarFactura();

$facturas5 = new Facturas("91742808V", "Análisis suelo", "2022-08-08", "78.44", "4.00", "80.00");
$facturas5->guardarFactura(); */


//? Datos de los ingresos
/* $ingreso1 = new Ingresos("46001270M", "2022-01-25", "Pago año 2022", 56.94, 10.09, 5, 40.50, "cobrado");
$ingreso1->guardarIngreso();

$ingreso2 = new Ingresos("46001270M", "2023-06-17", "Pago 50% 2023", 11.95, 3.15, 5, 10.50, "cobrado");
$ingreso2->guardarIngreso();

$ingreso3 = new Ingresos("91742808V", "2023-08-18", "Pago 50% 2023", 33.09, 6.05, 5, 30.0, "cobrado");
$ingreso3->guardarIngreso();

$ingreso4 = new Ingresos("91742808V", "2024-08-12", "Pago 50% 2024", 22.74, 1.77, 5, 18.75, "cobrado");
$ingreso4->guardarIngreso(); */

/* $ingreso5 = new Ingresos("91742808V", "2024-12-12", "Pago 50% 2024", 81.22, 18.87, 5, 72.62, "pendiente de cobro");
$ingreso5->guardarIngreso(); */



//? Datos de los días de vendimia
// $dia1 = new DiasVendimia("46001270M", "2024-09-01", 300);
// $dia1->guardarDiasVendimia();

// $dia2 = new DiasVendimia("46001270M", "2024-09-03", 180);
// $dia2->guardarDiasVendimia();

// $dia3 = new DiasVendimia("46001270M", "2024-09-04", 50);
// $dia3->guardarDiasVendimia();

// $dia4 = new DiasVendimia("91742808V", "2024-09-04", 80);
// $dia4->guardarDiasVendimia();

// $dia5 = new DiasVendimia("91742808V", "2024-09-09", 80);
// $dia5->guardarDiasVendimia();

// $dia6 = new DiasVendimia("91742808V", "2024-09-11", 80);
// $dia6->guardarDiasVendimia();




//? Datos de los albaranes
/* $albaran1 = new AlbaranesEntrega("46001270M", '1', '2024-09-01 13:14:54',1359.24, 11.15, 150);
$albaran1->guardarAlbaran();

$albaran2 = new AlbaranesEntrega("46001270M", '1', '2024-09-1 20:44:12',1643.75, 12.45, 150);
$albaran2->guardarAlbaran();

$albaran3 = new AlbaranesEntrega("46001270M", '1','2024-09-03 21:29:13',1025.44, 11.76, 180);
$albaran3->guardarAlbaran();

$albaran4 = new AlbaranesEntrega("91742808V",'2', '2024-09-09 18:26:10', 881.3, 11.62, 80);
$albaran4->guardarAlbaran();

$albaran5 = new AlbaranesEntrega("91742808V",'2', '2024-09-11 10:57:10', 1209.33, 12.49, 40);
$albaran5->guardarAlbaran();

$albaran6 = new AlbaranesEntrega("91742808V",'2', '2024-09-11 14:17:48', 615.07, 11.71, 40);
$albaran6->guardarAlbaran(); */




//? Datos de la campaña

/*$campaña1 = new Recolecta("46001270M", 2024, 0.00, 1000.00, 2.00);
$campaña1->guardarRecolecta();

$campaña4 = new Recolecta("91742808V", 2024, 0.00, 2.00);
$campaña4->guardarRecolecta();*/






?>