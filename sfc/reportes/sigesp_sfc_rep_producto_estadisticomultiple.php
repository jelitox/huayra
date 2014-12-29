<?Php
/******************************************/
/* FECHA: 03/09/2007                      */
/* AUTOR: ING. ZULHEYMAR RODR�GUEZ             */
/******************************************/
session_start();
require_once("sigesp_sfc_c_reportes.php");
$reporte = new sigesp_sfc_c_reportes('LETTER','landscape','REPORTE 1');
$io_pdf  = new class_pdf('LETTER','landscape');
$io_pdf->selectFont('../../../shared/ezpdf/fonts/Helvetica.afm');
$io_pdf->set_margenes(10,10,10,10);
require_once("../../shared/class_folder/sigesp_include.php");
require_once("../../shared/class_folder/class_mensajes.php");
require_once("../../shared/class_folder/class_sql.php");
require_once("../../shared/class_folder/class_funciones.php");
require_once("../../shared/class_folder/class_datastore.php");
$io_datastore= new class_datastore();
$io_include=new sigesp_include();
$io_connect=$io_include->uf_conectar();
$io_msg=new class_mensajes();
$io_sql=new class_sql($io_connect);
$io_data=new class_datastore();
$io_funcion=new class_funciones();
$io_pdf = $reporte->get_pdf();
/******************************************************************************************************************************/
$reporte->add_titulo("center",43,11,"ESTADISTICO DE PRODUCTOS VENDIDOS POR L�NEA");
$ls_fecha=date('d/m/Y');
$reporte->add_titulo("left",50,7,"Fecha emisi�n: ".$ls_fecha);
//$ruta=$_GET["ruta"];

$ls_sql=$_GET["sql"];
$ls_fecemi=$_GET["fecemi"];
$ls_fecemi2=$_GET["fecemi2"];
$ls_grafico=$_GET["grafico"];
$totcla=$_GET["totcla"];
$io_pdf->numerar_paginas(6);
$ls_sql=str_replace("\\","",$ls_sql);
$ls_sql=str_replace("/","",$ls_sql);
$rs_datauni=$io_sql->select($ls_sql);
if($rs_datauni==false&&($io_sql->message!=""))
{
	$io_msg->message("No hay Nada que Reportar");
}
else
{
   $la_producto=$io_sql->obtener_datos($rs_datauni);
   if ($la_producto)
   {
	$li_cuotas=(count($la_producto,COUNT_RECURSIVE)/count($la_producto)) - 1;
	$la_total=0;
	if ($ls_fecemi<>"%/%")
	{
	$ls_fecemi="".substr( $ls_fecemi,8,2)."/".substr( $ls_fecemi,5,2)."/".substr( $ls_fecemi,0,4)."";
	  $ls_fecemi2="".substr( $ls_fecemi2,8,2)."/".substr( $ls_fecemi2,5,2)."/".substr( $ls_fecemi2,0,4)."";
	  $reporte->add_titulo("right",50,7,"Fecha desde: ".$ls_fecemi." Hasta ".$ls_fecemi2);
	}
	include "libchart-1.2/libchart/classes/libchart.php";

	if ($ls_grafico=="Multiples_Lineas"){
	$chart =new LineChart(400,200);
	}
	for($i=0;$i<$li_cuotas;$i++)
	{
	 $la_datos[$i]["<b>C�DIGO</b>"]= strtoupper($la_producto["codcla"][$i+1]);
	 $la_datos[$i]["<b>DESCRIPCI�N</b>"]= strtoupper($la_producto["dencla"][$i+1]);
	 $la_datos[$i]["<b>CANTIDAD</b>"]= number_format($la_producto["cantidad"][$i+1],0, ',', '.');
	 $la_datos[$i]["<b>SUBTOTAL</b>"]= number_format($la_producto["subtotal"][$i+1],2, ',', '.');

	 $la_total= $la_total+$la_producto["subtotal"][$i+1];
	 $la_total2=number_format($la_total,2,',','.');
	 //$dataSet->addPoint(new Point(strtolower($la_datos[$i]["<b>DESCRIPCI�N</b>"]),$la_producto["cantidad"][$i+1]));
	 $sumatotal=$sumatotal+$la_producto["cantidad"][$i+1];
	 }
	$anterior=$la_producto["dencla"][1];
	$j=1;
	$existe='false';
	$dataSet = new XYSeriesDataSet();
	$i=0;
	while ($i<$li_cuotas and $j<=$totcla)
	{
		if ($la_producto["dencla"][$i+1]==$anterior)
		{
			if ($la_producto["mes"][$i+1]=='01')
			{

			}else if ($la_producto["mes"][$i+1]=='02')
			{

			}else if ($la_producto["mes"][$i+1]=='03')
			{

			}else if ($la_producto["mes"][$i+1]=='04')
			{

			}else if ($la_producto["mes"][$i+1]=='05')
			{

			}else if ($la_producto["mes"][$i+1]=='06')
			{

			}else if ($la_producto["mes"][$i+1]=='07')
			{

			}else if ($la_producto["mes"][$i+1]=='08')
			{

			}else if ($la_producto["mes"][$i+1]=='09')
			{

			}else if ($la_producto["mes"][$i+1]=='10')
			{

			}else if ($la_producto["mes"][$i+1]=='11')
			{

			}else if ($la_producto["mes"][$i+1]=='12')
			{

			}
		else
		{
			if ($la_producto["mes"][$i+1]=='01')
			{

			}else if ($la_producto["mes"][$i+1]=='02')
			{

			}else if ($la_producto["mes"][$i+1]=='03')
			{

			}else if ($la_producto["mes"][$i+1]=='04')
			{

			}else if ($la_producto["mes"][$i+1]=='05')
			{

			}else if ($la_producto["mes"][$i+1]=='06')
			{

			}else if ($la_producto["mes"][$i+1]=='07')
			{

			}else if ($la_producto["mes"][$i+1]=='08')
			{

			}else if ($la_producto["mes"][$i+1]=='09')
			{

			}else if ($la_producto["mes"][$i+1]=='10')
			{

			}else if ($la_producto["mes"][$i+1]=='11')
			{

			}else if ($la_producto["mes"][$i+1]=='12')
			{

			}
		}
		$anterior=$la_producto["dencla"][$i+1];
		$i++;
	}


	for ($i=0;$i<$li_cuotas;$i++)
	{
	$porcentaje=$sumatotal==0?0:100*$la_producto["cantidad"][$i+1]/$sumatotal;
	$la_datos[$i]["<b>PORCENTAJE DE CANTIDAD VENDIDA</b>"]= number_format($porcentaje) . "%";
	}
	$chart->setDataSet($dataSet);
	$chart->setTitle("PORCENTAJE DE CANTIDAD VENDIDA*LINEA DE PRODUCTO");
	$chart->getPlot()->setGraphCaptionRatio(0.62);
	$chart->render("imagenes/demo.jpg");

	$io_pdf->ezSetY(600);
	$la_anchos_col = array(35,95,18,25,30,40);

    $la_justificaciones = array('center','left','right','right','right','center');
	$la_opciones = array(  "color_fondo" => array(229,229,229),
						   "color_texto" => array(0,0,0),
						   "anchos_col"  => $la_anchos_col,
						   "tamano_texto"=> 7,
						   "lineas"=>1,
						   "alineacion_col"=>$la_justificaciones,
						   "margen_horizontal"=>1);
	$io_pdf->add_tabla(0,$la_datos,$la_opciones);

 	$la_datos2[0]["totales"]= "<b>Total Ventas Bs.</b>";

			   // datos para la segunda columna
			   //$la_titulos2[0]["2"]="";
			  	$la_datos2[0]["resultados"]= '<b>'.$la_total2.'</b>';     // SUBTOTAL

			  //print $li_cuotas;
				//$io_pdf->ezSetY(550-($li_cuotas*20));
				$la_anchos_col = array(25,30);
				$la_justificaciones = array('left','right');
				// titulos de la primera y segunda columna respectivamente
				$la_titulos2[0]["1"]="";
				$la_titulos2[0]["2"]="";


				$la_opciones2 = array(  "color_fondo" => array(229,229,229),
									   "color_texto" => array(0,0,0),
									   "anchos_col"  => $la_anchos_col,
									   "tamano_texto"=> 7,
									   "lineas"=>1,
									   "alineacion_col"=>$la_justificaciones,
									   "margen_horizontal"=>1);
				$io_pdf->add_tabla2(148,$la_datos2,$la_opciones2);

	$io_pdf->add_imagengrafico("imagenes/demo.jpg",center,85,200);



$io_pdf->ezStream();


}
}
else{
?>
<script>
alert ("No hay Nada que Reportar");
</script>
<?php
}
}


?>