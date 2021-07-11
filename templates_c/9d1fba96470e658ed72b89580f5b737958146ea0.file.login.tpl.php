<?php /* Smarty version Smarty-3.1.18, created on 2016-01-22 12:43:52
         compiled from "templates/setup/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:66493169856a215f8eb15c7-21757537%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9d1fba96470e658ed72b89580f5b737958146ea0' => 
    array (
      0 => 'templates/setup/login.tpl',
      1 => 1428079199,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '66493169856a215f8eb15c7-21757537',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56a215f903f175_00911593',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a215f903f175_00911593')) {function content_56a215f903f175_00911593($_smarty_tpl) {?><?php if (file_exists("templates/language/german.conf")) {?>
    <?php  $_config = new Smarty_Internal_Config("templates/language/german.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<?php } else { ?>
    Missing Languagefile: "templates/language/german.conf"
<?php }?>

<html>
<tbody>
<meta name="author" content="Florian Asche">
<link rel="shortcut icon" href="lib/favicon.ico" type="image/x-icon">
<link rel="icon" href="lib/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="lib/mams.css">
<link rel="stylesheet" type="text/css" href="lib/jquery.gridster.min.css">
<link rel="stylesheet" type="text/css" href="lib/jquery-ui-1.11.0.css">
<link rel="stylesheet" type="text/css" href="lib/jquery-ui-slider-pips-1.5.5.css">
<title>Measurement and Management System - Smart Home - Setup</title>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="pragma" content="no-cache" />

<body>
<script type="text/javascript" src="lib/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="lib/jquery.gridster.dustmoo.js"></script>
<script type="text/javascript" src="lib/jquery-ui-1.11.0.min.js"></script>
<script type="text/javascript" src="lib/jquery-ui-slider-pips-1.5.5.min.js"></script>
<script type="text/javascript" src="lib/mams.js"></script>
<script type="text/javascript" src="lib/wz_tooltip.js"></script>
</body>

<script language="javascript" type="text/javascript">
function setFocus() {
document.loginbox.name.focus();
}
</script>
<body onload="javascript:setFocus()"></body>
<div id="notify" class="notifyInfo"><span id="notify_body">&nbsp;</span></div>

<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td class="loginlayout" align="center">
            <table class="loginlayout_content" id="table1">
                <tr>
                    <td>
                        <table border="0" width="410px" id="table2">
                            <tr>
                                <td colspan="2" width="120px" height="110px">
                                    <table border="0" width="100%">
                                        <tr>
                                            <td>
                                                <img src="lib/images/schloss.png" width="100px" height="100px" alt="*GRAFIK*">
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <b>Measurement and Management System</b>
                                                    <br>
                                                    Login Administratiorbereich
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
<?php $_tmp1=ob_get_clean();?><?php if ($_tmp1=="loginfailed") {?>
                                        <dl id="system-message">
                                            <dd class="message message fade error">
                                                <ul>
                                                    <li>
                                                        Die Login-Daten sind nicht korrekt!
                                                    </li>
                                                </ul>
                                            </dd>
                                        </dl>
                                    <?php }?>
                                </td>
                            </tr>

                            <form name="loginbox" method="post" page="setup.php">
                            <tr>
                                <td width="150px">
                                    Benutzername:
                                </td>
                                <td>
                                    <div align="right"><input type="text" name="username"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Passwort:
                                </td> 
                                <td>
                                    <div align="right"><input type="password" name="password"></div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <INPUT TYPE="button" VALUE="zur&uuml;ck" onClick="history.go(-1);return true;"> 
                                </td>
                                <td>
                                    <input type="hidden" id="page" name="page" value="login">
                                    <div align="right"><input type="submit" value="Login"></div>
                                </td>
                            </tr>
                            </form>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>     
        
</tbody>
</html>
<?php }} ?>
