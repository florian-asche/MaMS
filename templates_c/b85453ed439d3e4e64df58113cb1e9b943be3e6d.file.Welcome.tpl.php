<?php /* Smarty version Smarty-3.1.18, created on 2016-02-01 20:04:20
         compiled from "templates/setup/Welcome.tpl" */ ?>
<?php /*%%SmartyHeaderCode:54540422456afac348b7a83-29447548%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b85453ed439d3e4e64df58113cb1e9b943be3e6d' => 
    array (
      0 => 'templates/setup/Welcome.tpl',
      1 => 1432397409,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54540422456afac348b7a83-29447548',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menu' => 0,
    'menuentry' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56afac34970d25_02844199',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56afac34970d25_02844199')) {function content_56afac34970d25_02844199($_smarty_tpl) {?><?php if (file_exists("templates/language/german.conf")) {?>
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
<meta http-equiv="pragma" content="no-cache">

<body>
<script type="text/javascript" src="lib/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="lib/jquery.gridster.dustmoo.js"></script>
<script type="text/javascript" src="lib/jquery-ui-1.11.0.min.js"></script>
<script type="text/javascript" src="lib/jquery-ui-slider-pips-1.5.5.min.js"></script>
<script type="text/javascript" src="lib/mams.js"></script>
<script type="text/javascript" src="lib/wz_tooltip.js"></script>
</body>

<div id="notify" class="notifyInfo"><span id="notify_body">&nbsp;</span></div>

<div class="mams_content">
    <div class="header" align="center">
        <a class="headertext">Measurement and Management System - Smart Home - Setup</a>
    </div>

    <div class="navigation">
        <?php  $_smarty_tpl->tpl_vars['menuentry'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menuentry']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menuentry']->key => $_smarty_tpl->tpl_vars['menuentry']->value) {
$_smarty_tpl->tpl_vars['menuentry']->_loop = true;
?>
            <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['menuentry']->value;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
<?php $_tmp2=ob_get_clean();?><?php if ($_tmp1==$_tmp2) {?>
            <a href="setup.php?page=<?php echo $_smarty_tpl->tpl_vars['menuentry']->value;?>
" class="menuobject-selected"><?php echo $_smarty_tpl->tpl_vars['menuentry']->value;?>
</a>
            <?php } else { ?>
            <a href="setup.php?page=<?php echo $_smarty_tpl->tpl_vars['menuentry']->value;?>
" class="menuobject"><?php echo $_smarty_tpl->tpl_vars['menuentry']->value;?>
</a>
            <?php }?>
        <?php } ?>

        <div class="menurechts">
            <a href="http://mams.florian-asche.de" class="menuobject">Dokumentation</a>
            <a href="setup/index.php" class="menuobject">Setup</a>
        </div>
    </div>

    <div class="content">
        <h1><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</h1>
        <?php echo $_smarty_tpl->getSubTemplate ("templates/setup/index_start.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <br>
        INHALT HIER
        <br>
        
        <br>
        INHALT HIER
	
        <br>
        <br>
    </div>
    
    <div class="copyright" align="center">
    Copyright &copy by <a href='http://www.florian-asche.de/'>Florian Asche</a>
    </div>
</div>
</tbody>
</html>
<?php }} ?>
