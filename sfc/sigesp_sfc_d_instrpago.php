<?Php

session_start();
if (!array_key_exists("la_logusr",$_SESSION))
   {
    print "<script language=JavaScript>";
	 print "location.href='../sigesp_conexion.php'";
	 print "</script>";		
   }
$la_datemp=$_SESSION["la_empresa"];


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Definici&oacute;n de Nota</title>
<meta http-equiv="" content="text/html; charset=iso-8859-1">
<meta http-equiv="" content="text/html; charset=iso-8859-1">

<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<meta http-equiv="" content="text/html; charset=iso-8859-1"><meta http-equiv="" content="text/html; charset=iso-8859-1">
<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
<link href="../shared/js/css_intra/datepickercontrol.css" rel="stylesheet" type="text/css"> <!--  para icono de fecha -->
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript1.2" src="../shared/js/disabled_keys.js"></script>
<script language="javascript">
	if(document.all)
	{ //ie 
		document.onkeydown = function(){ 
		if(window.event && (window.event.keyCode == 122 || window.event.keyCode == 116 || window.event.ctrlKey))
		{
			window.event.keyCode = 505; 
		}
		if(window.event.keyCode == 505){ return false;} 
		} 
	}
</script>
<style type="text/css">
<!--
.Estilo1 {color: #6699CC}
-->
</style>
</head>
<body link="#006699" vlink="#006699" alink="#006699">
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" class="contorno">
  <tr> 
    <td height="30" colspan="2" class="cd-logo"><img src="../shared/imagebank/header.jpg" width="778" height="40"></td>
  </tr>
  <tr>
    <td width="552" height="20" class="cd-menu"><span class="descripcion_sistema Estilo1 Estilo1">Sistema de Facturaci&oacute;n</span></td>
    <td width="226" class="cd-menu"><div align="right"><b><?PHP print date("j/n/Y")." - ".date("h:i a");?></b></div></td>
  </tr>
  <tr>
    <td height="20" class="cd-menu">&nbsp;</td>
    <td height="20" class="cd-menu"><div align="right"><b><?PHP print $_SESSION["la_nomusu"]." ".$_SESSION["la_apeusu"];?></b></div></td>
  </tr>
  <tr>
    <td height="20" colspan="2" class="cd-menu">
	<script type="text/javascript" language="JavaScript1.2" src="js/menu.js"></script>
	<script type="text/javascript" language="JavaScript1.2" src="js/validaciones.js"></script>	</td>
  </tr>
  <tr>
    <td height="20" colspan="2" bgcolor="#FFFFFF" class="toolbar">&nbsp;</td>
  </tr>
  <tr> 
    <td height="20" colspan="2" bgcolor="#FFFFFF" class="toolbar"><a href="javascript:ue_nuevo();"><img src="../shared/imagebank/tools20/nuevo.gif" alt="Nuevo" width="20" height="20" border="0"></a><a href="javascript:ue_guardar();"><img src="../shared/imagebank/tools20/grabar.gif" alt="Grabar" width="20" height="20" border="0"></a><a href="javascript:ue_buscar();"><img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="20" height="20" border="0"></a><!--img src="../shared/imagebank/tools20/imprimir.gif" alt="Imprimir" width="20" height="20"--><a href="javascript:ue_eliminar();"><img src="../shared/imagebank/tools20/eliminar.gif" alt="Eliminar" width="20" height="20" border="0"></a><a href="sigespwindow_blank.php"><img src="../shared/imagebank/tools20/salir.gif" alt="Salir" width="20" height="20" border="0"></a></td>
  </tr>
</table>

<?Php
/*/////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	require_once("../shared/class_folder/sigesp_c_seguridad.php");
	$io_seguridad= new sigesp_c_seguridad();

	$arre=$_SESSION["la_empresa"];
	$ls_empresa=$arre["codemp"];
	$ls_logusr=$_SESSION["la_logusr"];
	$ls_sistema="SOB";
	$ls_ventanas="sigesp_sob_d_unidad.php";

	$la_seguridad["empresa"]=$ls_empresa;
	$la_seguridad["logusr"]=$ls_logusr;
	$la_seguridad["sistema"]=$ls_sistema;
	$la_seguridad["ventanas"]=$ls_ventanas;

	if (array_key_exists("permisos",$_POST)||($ls_logusr=="PSEGIS"))
	{	
		if($ls_logusr=="PSEGIS")
		{
			$ls_permisos="";
			$la_permisos=$io_seguridad->uf_sss_load_permisossigesp();
		}
		else
		{
			$ls_permisos=             $_POST["permisos"];
			$la_permisos["leer"]=     $_POST["leer"];
			$la_permisos["incluir"]=  $_POST["incluir"];
			$la_permisos["cambiar"]=  $_POST["cambiar"];
			$la_permisos["eliminar"]= $_POST["eliminar"];
			$la_permisos["imprimir"]= $_POST["imprimir"];
			$la_permisos["anular"]=   $_POST["anular"];
			$la_permisos["ejecutar"]= $_POST["ejecutar"];
		}
	}
	else
	{
		$la_permisos["leer"]="";
		$la_permisos["incluir"]="";
		$la_permisos["cambiar"]="";
		$la_permisos["eliminar"]="";
		$la_permisos["imprimir"]="";
		$la_permisos["anular"]="";
		$la_permisos["ejecutar"]="";
		$ls_permisos=$io_seguridad->uf_sss_load_permisos($ls_empresa,$ls_logusr,$ls_sistema,$ls_ventanas,$la_permisos);
	}

//////////////////////////////////////////////         SEGURIDAD               ////////////////////////////////////////////*/
	require_once("class_folder/sigesp_sfc_c_nota.php");
	require_once("../shared/class_folder/class_mensajes.php");
	
	require_once("../shared/class_folder/class_funciones_db.php");
	require_once ("../shared/class_folder/sigesp_include.php");		
	$io_include=new sigesp_include();
	$io_connect=$io_include->uf_conectar();
	$io_funcdb=new class_funciones_db($io_connect);
	$is_msg=new class_mensajes();
	$io_nota=new sigesp_sfc_c_nota();
	
	if(array_key_exists("operacion",$_POST))
	{   
	
		$ls_operacion=$_POST["operacion"]; /* campo oculto */
		$ls_codcli=$_POST["txtcodcli"];
		$ls_razcli=$_POST["txtrazcli"];
		
		$ls_numnot=$_POST["txtnumnot"];
		$ls_dennot=$_POST["txtdennot"];
		$ls_tipnot=$_POST["combotipo"];
		$ls_fecnot=$_POST["txtfecnot"];
		$ld_monto=$_POST["txtmonto"];
    }
	else
	{
		$ls_operacion=""; /* campo oculto */
		$ls_codcli="";
		$ls_razcli="";
		
		$ls_numnot="";
		$ls_dennot="";
		$ls_tipnot="";
		$ls_fecnot="";
		$ld_monto="";
	}
	
	/*Cuando la operacion es UE_NUEVO*/
	if($ls_operacion=="ue_nuevo")
	{
		$ls_operacion=""; /* campo oculto */
		$ls_codcli="";
		$ls_razcli="";	
		
		
	    $ls_numnot=$io_funcdb->uf_generar_codigo(false,0,"sfc_nota","numnot",25); /* correlativo incrementa automaticamente */
		
		
		$ls_dennot="";
		$ls_tipnot="";
		$ls_fecnot="";
		$ld_monto="";
		
	}
	elseif($ls_operacion=="ue_guardar")
	{
		                                      
		$lb_valido=$io_nota->uf_guardar_nota($ls_codcli,$ls_numnot,$ls_dennot,$ls_tipnot,$ls_fecnot,$ld_monto/*$la_seguridad*/);
		$ls_mensaje=$io_nota->io_msgc;
		
		if ($lb_valido===true) /* SI SE GUARDA SE LIMPIAN LAS VARIABLES*/
		{
			$is_msg->message ($ls_mensaje);
			
			$ls_codcli="";
			$ls_razcli="";
			
			$ls_numnot="";
			$ls_dennot="";
			$ls_tipnot="";
			$ls_fecnot="";
			$ld_monto="";
		}
		else
		{
			if($lb_valido==0)
			{
				$ls_codcli="";
				$ls_razcli="";
				
				$ls_numnot="";
				$ls_dennot="";
				$ls_tipnot="";
				$ls_fecnot="";
				$ld_monto="";
			}
			else
			{
				$is_msg->message ($ls_mensaje);
			}
		}
	}
	elseif($ls_operacion=="ue_eliminar")
	{
		$lb_valido=$io_nota->uf_delete_nota($ls_numnot/*$la_seguridad*/);			
		if ($lb_valido===true)
		{
			$is_msg->message($io_nota->io_msgc);
			$ls_codcli="";
			$ls_razcli="";
				
			$ls_numnot="";
			$ls_dennot="";
			$ls_tipnot="";
			$ls_fecnot="";
			$ld_monto="";
		}
    }
	
?>
<p>&nbsp;</p>
<form name="form1" method="post" action="">
<?php
/*/////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
if (($ls_permisos)||($ls_logusr=="PSEGIS"))
{
	print("<input type=hidden name=permisos id=permisos value='$ls_permisos'>");
	print("<input type=hidden name=leer     id=leer value='$la_permisos[leer]'>");
	print("<input type=hidden name=incluir  id=incluir value='$la_permisos[incluir]'>");
	print("<input type=hidden name=cambiar  id=cambiar value='$la_permisos[cambiar]'>");
	print("<input type=hidden name=eliminar id=eliminar value='$la_permisos[eliminar]'>");
	print("<input type=hidden name=imprimir id=imprimir value='$la_permisos[imprimir]'>");
	print("<input type=hidden name=anular   id=anular value='$la_permisos[anular]'>");
	print("<input type=hidden name=ejecutar id=ejecutar value='$la_permisos[ejecutar]'>");
}
else
{
	
	print("<script language=JavaScript>");
	print(" location.href='sigespwindow_blank.php'");
	print("</script>");
}
//////////////////////////////////////////////         SEGURIDAD               ////////////////////////////////////////////*/
?>	

    <table width="518" height="293" border="0" align="center" cellpadding="0" cellspacing="0" class="formato-blanco">
      <tr>
        <td width="516" height="291"><div align="center">
          <table  border="0" cellspacing="0" cellpadding="0" class="formato-blanco" align="center">
            <tr>
              <td colspan="2" class="titulo-ventana">Instrumento de pago  </td>
            </tr>
            <tr>
              <td ><input name="operacion" type="hidden" id="operacion"  value="<? print $ls_operacion?>">
              <input name="hidstatus" type="hidden" id="hidstatus"></td>
              <td >&nbsp;</td>
            </tr>
            <tr>
              <td width="92" height="22" align="right">Forma de pago </td>
              <td width="376" ><select name="select" size="1" id="select">
                <?php
				   if($ls_tipnot==C)
				   {
				?>
                <option value="C" selected>CREDITO</option>
                <option value="D">DEBITO</option>
                <?php
				  }
				 else
				  {	 
				 ?>
                <option value="C" >CREDITO</option>
                <option value="D" selectd>DEBITO</option>
                <?php
				 }
				 /* opcion ninguna */
				 ?>
              </select>
              <a href="javascript:ue_catclientenota();"></a></td>
            </tr>
            <tr>
              <td width="92" height="31" align="right">No. control</td>
              <td width="376" ><input name="txtnumnot" type="text" style="text-align:center " id="txtnumnot" value="<? print  $ls_numnot?>" size="28" maxlength="25"  readonly="true">
              <a href="javascript:ue_cattienda();"></a></td>
            </tr>
            
            
            <tr>
              <td height="8"><div align="right">Monto</div></td>
              <td><input name="txtmonto" type="text" id="txtmonto"  onKeyPress="return(currencyFormat(this,'.',',',event))" value="<? print $ld_monto;?>"  size="40"></td>
            </tr>
          </table>
          <p>&nbsp;</p>
        </div></td>
      </tr>
  </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</form>
</body>

<script language="JavaScript">


/*******************************************************************************************************************************/

function ue_nuevo()
{
	f=document.form1;
	f.operacion.value="ue_nuevo";
	f.txtcodcli.value="";
	f.txtrazcli.value="";
	f.txtnumnot.value="";
	f.txtdennot.value="";
	f.txtfecnot.value="";
	f.txtmonto.value="";
	f.action="sigesp_sfc_d_nota.php";
	f.submit();
/*	li_incluir=f.incluir.value;
	if(li_incluir==1)
	{		
	}
	else
	{
		alert("No tiene permiso para realizar esta operacion");
	}*/	
}


function ue_guardar()
{
	f=document.form1;
	with(f)
		{
			if (ue_valida_null(txtcodcli,"Cliente")==false)
			 {
			 	txtcodcli.focus();
			 }
			else if (ue_valida_null(txtnumnot,"No de Nota de cr�dito")==false)
			 {
				txtnumnot.focus();
			 }
			else if (ue_valida_null(txtdennot,"Denominaci�n de Nota de cr�dito")==false)
			 {
				  txtdennot.focus();
			  }
			else if (ue_valida_null(txtfecnot,"Fecha")==false)
			 {
				  txtfecnot.focus();
			 } 
			else if (ue_valida_null(txtmonto,"Monto")==false)
			 {
				  txtmonto.focus();
			 }	
			else	
			 {	
					f.operacion.value="ue_guardar";
					f.action="sigesp_sfc_d_nota.php";
					f.submit();
			 } 
			
		} 
	/*li_incluir=f.incluir.value;
	li_cambiar=f.cambiar.value;
	lb_status=f.hidstatus.value;
	if(((lb_status=="C")&&(li_cambiar==1))||(lb_status!="C")&&(li_incluir==1))
	{
	}
	else
	{
		alert("No tiene permiso para realizar esta operacion");
	}*/
}					
					
function ue_eliminar()
{
	f=document.form1;
	with(f)
		{
			if (ue_valida_null(txtnumnot,"No. Nota de cr�dito")==false)
			{
				txtnumnot.focus();
			}
			else
			{
				if (confirm("� Esta seguro de eliminar este registro ?"))
				{ 		
					f.operacion.value="ue_eliminar";
					f.action="sigesp_sfc_d_nota.php";
					f.submit();
				}
				else
				{ 
					f=document.form1;
					f.action="sigesp_sfc_d_nota.php";
					alert("Eliminaci�n Cancelada !!!");
					f.txtcodcli.value="";
					f.txtrazcli.value="";
					f.txtnumnot.value="";
					f.txtdennot.value="";
					f.txtfecnot.value="";
					f.txtmonto.value="";
					f.operacion.value="";
					f.submit();
				}
			}	   
		}
	/*li_incluir=f.incluir.value;
	li_cambiar=f.cambiar.value;
	lb_status=f.hidstatus.value;
	if(((lb_status=="C")&&(li_cambiar==1))||(lb_status!="C")&&(li_incluir==1))
	{
    }
	else
	{
		alert("No tiene permiso para realizar esta operacion");
	}*/
}

function ue_buscar()
{
	f=document.form1;
	f.operacion.value="";			
	pagina="sigesp_cat_nota.php";
	popupWin(pagina,"catalogo",650,300);
	/*li_leer=f.leer.value;
	if(li_leer==1)
	{
	}
	else
	{
		alert("No tiene permiso para realizar esta operacion");
	}*/
}

/***********************************************************************************************************************************/        
		
		function ue_catclientenota()
		{
            f=document.form1;
			f.operacion.value="";					
			
		    pagina="sigesp_cat_cliente.php";
	    	popupWin(pagina,"catalogo",520,200);
		}
		
		function ue_cattienda()
		{
            f=document.form1;
			f.operacion.value="";						
		    pagina="sigesp_cat_tienda.php";
	    	popupWin(pagina,"catalogo",520,200);
		}
		
		function ue_cargarnota(codcli,numnot,dennot,tipnot,fecnot,monto)
		{
		    
 	   	    f=document.form1;
			f.txtcodcli.value=codcli;
			f.txtrazcli.value="";
			f.txtnumnot.value=numnot;
			f.txtdennot.value=dennot;
			/*if (tipnot=="C")
			{
			 tipnot="CREDITO";
			} 
			else
			{
			 tipnot="DEBITO";
			}*/
			
			f.combotipo.value=tipnot;
			f.txtfecnot.value=fecnot;
			f.txtmonto.value=monto;
					
		}
		/*******************  modificada ***************************************/
		function ue_cargarcliente(codcli,nomcli,dircli,telcli,celcli,codpai,codest,codmun,codpar)
		{
		    f=document.form1;
			f.txtcodcli.value=codcli;
			f.txtrazcli.value=nomcli;
			
       	}
/***********************************************************************************************************************************/

</script>
<script language="javascript" src="../shared/js/js_intra/datepickercontrol.js"></script>
</html>