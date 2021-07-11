<?php /* Smarty version Smarty-3.1.18, created on 2016-05-15 17:29:19
         compiled from "templates/greensky/dashboard.tpl" */ ?>
<?php /*%%SmartyHeaderCode:70072012956a215daa051c1-44346931%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0035a41d84968b7007a308025085b5083cb73377' => 
    array (
      0 => 'templates/greensky/dashboard.tpl',
      1 => 1463326120,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '70072012956a215daa051c1-44346931',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56a215dabd85a3_27915310',
  'variables' => 
  array (
    'pages' => 0,
    'menuentry' => 0,
    'pageid' => 0,
    'page_objects' => 0,
    'objekt' => 0,
    'ladezeit' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a215dabd85a3_27915310')) {function content_56a215dabd85a3_27915310($_smarty_tpl) {?><html>
<tbody>
<meta name="author" content="Florian Asche">
<link rel="shortcut icon" href="lib/favicon.ico" type="image/x-icon">
<link rel="icon" href="lib/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="lib/mams.css">
<link rel="stylesheet" type="text/css" href="lib/jquery.gridster.min.css">
<link rel="stylesheet" type="text/css" href="lib/jquery-ui-1.11.0.css">
<link rel="stylesheet" type="text/css" href="lib/jquery-ui-slider-pips-1.5.5.css">
<title>Measurement and Management System - Smart Home</title>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="pragma" content="no-cache">

<body>
<script type="text/javascript" src="lib/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="lib/jquery.gridster.dustmoo.js"></script>
<script type="text/javascript" src="lib/jquery-ui-1.11.0.min.js"></script>
<script type="text/javascript" src="lib/jquery-ui-slider-pips-1.5.5.min.js"></script>
<script type="text/javascript" src="lib/mams.js"></script>
<script type="text/javascript" src="lib/wz_tooltip.js"></script>

<script type="text/javascript" src="lib/colorPicker/colors.js"></script>
<script type="text/javascript" src="lib/colorPicker/colorPicker.data.js"></script>
<script type="text/javascript" src="lib/colorPicker/colorPicker.js"></script>
<script type="text/javascript" src="lib/colorPicker/jQuery_implementation/jqColor.js"></script>

</body>

<div id="notify" class="notifyInfo"><span id="notify_body">&nbsp;</span></div>

<div class="mams_content">
    <div class="header" align="center">
        <a class="headertext">Measurement and Management System - Smart Home</a>
    </div>

    <div class="navigation">
        <?php  $_smarty_tpl->tpl_vars['menuentry'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menuentry']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menuentry']->key => $_smarty_tpl->tpl_vars['menuentry']->value) {
$_smarty_tpl->tpl_vars['menuentry']->_loop = true;
?>
            <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['menuentry']->value['active'];?>
<?php $_tmp1=ob_get_clean();?><?php if ($_tmp1=="1") {?>
                <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['menuentry']->value['ID'];?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['pageid']->value;?>
<?php $_tmp3=ob_get_clean();?><?php if ($_tmp2==$_tmp3) {?>
                <a href="index.php?pageid=<?php echo $_smarty_tpl->tpl_vars['menuentry']->value['ID'];?>
" class="menuobject-selected"><?php echo $_smarty_tpl->tpl_vars['menuentry']->value['name'];?>
</a>
                <?php } else { ?>
                <a href="index.php?pageid=<?php echo $_smarty_tpl->tpl_vars['menuentry']->value['ID'];?>
" class="menuobject"><?php echo $_smarty_tpl->tpl_vars['menuentry']->value['name'];?>
</a>
                <?php }?>
            <?php }?>
        <?php } ?>

        <a href="maximal-ausgabe.php" class="menuobject">OLD</a>

        <div class="menurechts">
            <a href="http://mams.florian-asche.de" class="menuobject">Dokumentation</a>
            <a href="setup.php" class="menuobject">Setup</a>
        </div>
    </div>

    <div class="gridster">
        <ul>
        <?php  $_smarty_tpl->tpl_vars['objekt'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['objekt']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['page_objects']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['objekt']->key => $_smarty_tpl->tpl_vars['objekt']->value) {
$_smarty_tpl->tpl_vars['objekt']->_loop = true;
?>
        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['pageid'];?>
<?php $_tmp4=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['pageid']->value;?>
<?php $_tmp5=ob_get_clean();?><?php if ($_tmp4==$_tmp5) {?>
            <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['active'];?>
<?php $_tmp6=ob_get_clean();?><?php if ($_tmp6=="1") {?>
                <li data-row="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['x'];?>
" data-col="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['y'];?>
" data-sizex="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['sizex'];?>
" data-sizey="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['sizey'];?>
" class="gs_w">
                    <script type="text/javascript" language="javascript">
                                            // objectid, time_to_first_data_reload, reloadtime
                        updateStatusStarter('<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
', '2', '15');

                    </script>
                    <div id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['page_objects']['ID'];?>
_data">Loading data...</div>
                    
                </li>
            <?php }?>
        <?php }?>
        <?php } ?>
        </ul>
    </div>

    <script type="text/javascript" id="code">
        var gridster;
        $(function(){ 
                gridster = $(".gridster ul").gridster({
                widget_base_dimensions: [176, 170],
                shift_larger_widgets_down: true,
                widget_margins: [2, 2],
                extra_cols: 3,
                extra_rows: 3,
                resize: {
                    enable: false
                },
            }).data('gridster');
            gridster.disable();
        });
    </script>
    
    <div class="copyright" align="center">
    Copyright &copy by <a href='http://www.florian-asche.de/'>Florian Asche</a>
    <br><FONT SIZE=1pt><FONT COLOR='#20B07F'>
    Seite in <b><?php echo $_smarty_tpl->tpl_vars['ladezeit']->value;?>
 Sekunden generiert</b></FONT></FONT>
    </div>
</div>
</tbody>
</html><?php }} ?>
