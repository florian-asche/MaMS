<?php /* Smarty version Smarty-3.1.18, created on 2016-01-22 13:19:16
         compiled from "templates/greensky/graph.tpl" */ ?>
<?php /*%%SmartyHeaderCode:144676967456a21e442c4d70-53698661%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c09d252384bc267fb5fd1fb6133c2aedd6f3658' => 
    array (
      0 => 'templates/greensky/graph.tpl',
      1 => 1420125449,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '144676967456a21e442c4d70-53698661',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'graphdata' => 0,
    'dataheader' => 0,
    'dataarray' => 0,
    'timestamp' => 0,
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56a21e4431fe29_95933806',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a21e4431fe29_95933806')) {function content_56a21e4431fe29_95933806($_smarty_tpl) {?><link href="lib/flot-0.8.3/examples.css" rel="stylesheet" type="text/css">

<script language="javascript" type="text/javascript" src="lib/flot-0.8.3/jquery.js"></script>
<script language="javascript" type="text/javascript" src="lib/flot-0.8.3/jquery.flot.js"></script>
<script language="javascript" type="text/javascript" src="lib/flot-0.8.3/jquery.flot.time.js"></script>

<script type="text/javascript">
    $(function() {
        var options = {
            xaxis: {
                mode: "time"
            }
        };

        <?php  $_smarty_tpl->tpl_vars['dataarray'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dataarray']->_loop = false;
 $_smarty_tpl->tpl_vars['dataheader'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['graphdata']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dataarray']->key => $_smarty_tpl->tpl_vars['dataarray']->value) {
$_smarty_tpl->tpl_vars['dataarray']->_loop = true;
 $_smarty_tpl->tpl_vars['dataheader']->value = $_smarty_tpl->tpl_vars['dataarray']->key;
?>
            var rawData_<?php echo $_smarty_tpl->tpl_vars['dataheader']->value;?>
 = [
            <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_smarty_tpl->tpl_vars['timestamp'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataarray']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
 $_smarty_tpl->tpl_vars['timestamp']->value = $_smarty_tpl->tpl_vars['data']->key;
?>
                [<?php echo $_smarty_tpl->tpl_vars['timestamp']->value*1000;?>
, <?php echo $_smarty_tpl->tpl_vars['data']->value;?>
], 
            <?php } ?>
            ];
        <?php } ?>

        var dataset = [
            <?php  $_smarty_tpl->tpl_vars['dataarray'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dataarray']->_loop = false;
 $_smarty_tpl->tpl_vars['dataheader'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['graphdata']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dataarray']->key => $_smarty_tpl->tpl_vars['dataarray']->value) {
$_smarty_tpl->tpl_vars['dataarray']->_loop = true;
 $_smarty_tpl->tpl_vars['dataheader']->value = $_smarty_tpl->tpl_vars['dataarray']->key;
?>
            {
                label: "<?php echo $_smarty_tpl->tpl_vars['dataheader']->value;?>
",
                data: rawData_<?php echo $_smarty_tpl->tpl_vars['dataheader']->value;?>

            },
            <?php } ?>
        ];

        $.plot($("#placeholder"), dataset, options);
    });
</script>

<body>   
    <div id="content">
        <div class="demo-container">
            <div id="placeholder" class="demo-placeholder"></div>
        </div>
    </div>
</body><?php }} ?>
