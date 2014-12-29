<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Cat&aacute;logo de Cuentas Contables</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
a:link {
	color: #006699;
}
a:visited {
	color: #006699;
}
a:active {
	color: #006699;
}
-->
</style>
<link href="../../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../../shared/css/general.css" rel="stylesheet" type="text/css">
<link href="../../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:hover {
	color: #006699;
}
-->
</style></head>

<body>
<form name="form1" method="post" action="">
  <p align="left">&nbsp;</p>
  <div align="left">
    <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
      <tr>
        <td height="22" colspan="3" align="right" class="titulo-celda"><input name="operacion" type="hidden" id="operacion">
        Cat&aacute;logo de Cuentas Contables </td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="87" height="22" align="right">Cuenta</td>
        <td width="273" height="22"><div align="left">
            <input name="codigo" type="text" id="codigo">        
        </div></td>
        <td width="138" height="22">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" style="text-align:right">Denominaci&oacute;n</td>
        <td height="22" colspan="2"><div align="left">
            <input name="nombre" type="text" id="nombre" size="70" maxlength="500">
  <label></label>
  <br>
          </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="right"><a href="javascript: ue_search();"><img src="../../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="20" height="20" border="0"> Buscar </a></div></td>
      </tr>
    </table>
    <div align="center"><br>
      <?php
require_once("../../shared/class_folder/sigesp_include.php");
$io_include=new sigesp_include();
$io_connect=$io_include->uf_conectar();
require_once("../../shared/class_folder/class_fecha.php");
require_once("../../shared/class_folder/class_mensajes.php");
require_once("../../shared/class_folder/class_funciones.php");
require_once("../../shared/class_folder/class_datastore.php");
require_once("../../shared/class_folder/class_sql.php");
require_once("../../shared/class_folder/class_sigesp_int.php");
require_once("../../shared/class_folder/class_sigesp_int_scg.php");
$dat=$_SESSION["la_empresa"];
$io_int_scg=new class_sigesp_int_scg();
$io_msg=new class_mensajes();
$ds=new class_datastore();
$io_sql=new class_sql($io_connect);
$arr=$_SESSION["la_empresa"];
$as_codemp=$arr["codemp"];

if(array_key_exists("operacion",$_POST))
{
	$ls_operacion=$_POST["operacion"];
	$li_fila=$_POST["fila"];
	$ls_codigo=$_POST["codigo"]."%";
	$ls_denominacion="%".$_POST["nombre"]."%";

	
}
else
{
	$ls_operacion="";
	$li_fila=$_GET["fila"];
}

print "<table width=500 border=0 cellpadding=1 cellspacing=1 class=fondo-tabla align=center>";
print "<tr class=titulo-celda>";
print "<td style=text-align:center width=150>Cuenta Contable</td>";
print "<td style=text-align:center width=350>Denominación</td>";
print "</tr>";
if ($ls_operacion=="BUSCAR")
   {
	 $ls_sql = "SELECT trim(sc_cuenta) as sc_cuenta, denominacion, status, asignado, distribuir,enero, febrero, marzo, abril, 
	                   mayo, junio, julio,agosto, septiembre, octubre, noviembre, diciembre,nivel, referencia 
			      FROM scg_cuentas
		         WHERE codemp = '".$as_codemp."'
			       AND sc_cuenta like '".$ls_codigo."'
			       AND denominacion like '".$ls_denominacion."'
			  	 ORDER BY sc_cuenta";
	 $rs_data = $io_sql->select($ls_sql);
	 if ($rs_data===false)
	    {
	      $io_msg->message("Error en Consulta, Contacte al Administrador del Sistema !!!");
	    }
 	 else
	   {
	     $li_numrows = $io_sql->num_rows($rs_data);
		 if ($li_numrows>0)
		    {
			  while ($row=$io_sql->fetch_row($rs_data))
			        {
					  $ls_scgcta    = $row["sc_cuenta"];
					  $ls_denctascg = $row["denominacion"];
					  $ls_estmovcta = $row["status"];
					  if ($ls_estmovcta=="S")
					     {
						   print "<tr class=celdas-blancas>";
						   print "<td style=text-align:center width=150>".$ls_scgcta."</td>";
				 	     }
					  else
						 {
						   print "<tr class=celdas-azules>";
						   print "<td style=text-align:center width=150><a href=\"javascript: aceptar('$ls_scgcta','$ls_denctascg','$ls_estmovcta');\">".$ls_scgcta."</a></td>";
						 }
					  print "<td style=text-align:left width=350 title='$ls_denctascg'>".$ls_denctascg."</td>";
					  print "</tr>";
					}
			}
	     else
		    {
			  $io_msg->message("No se han definido definido Cuentas Contables !!!");			
			}
	   }
   }
print "</table>";
?>
      <input name="fila" type="hidden" id="fila" value="<?php print $li_fila; ?>">
    </div>
  </div>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
<script language="JavaScript">

  function aceptar(cuenta,d,status)
  {
	  f=document.form1;
      fila=f.fila.value;
  	  eval("opener.document.formulario.txtcuentascg"+fila+".value='"+cuenta+"'");
	 close();
  }

  function ue_search()
  {
	  f=document.form1;
	  f.operacion.value="BUSCAR";
	  f.action="sigesp_sel_scg_plancuentaspg.php";
	  f.submit();
  }
</script>
</html>