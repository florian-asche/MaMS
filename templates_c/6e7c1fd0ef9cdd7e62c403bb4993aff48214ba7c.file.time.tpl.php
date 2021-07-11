<?php /* Smarty version Smarty-3.1.18, created on 2016-02-04 20:40:56
         compiled from "templates/afterlife/time.tpl" */ ?>
<?php /*%%SmartyHeaderCode:121706286556b3a948af14f7-46856559%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6e7c1fd0ef9cdd7e62c403bb4993aff48214ba7c' => 
    array (
      0 => 'templates/afterlife/time.tpl',
      1 => 1444504709,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '121706286556b3a948af14f7-46856559',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objektdata' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56b3a948b55329_33552052',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b3a948b55329_33552052')) {function content_56b3a948b55329_33552052($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/html/mams/lib/Smarty-3.1.18/libs/plugins/modifier.date_format.php';
?></td></tr>
<tr>

<td class="object_time" colspan="3">
    <p align="center" >
        <font size="2">
        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['objektdata']->value['timestampdiff'];?>
<?php $_tmp2=ob_get_clean();?><?php if ($_tmp2<"60") {?>
            vor <?php echo $_smarty_tpl->tpl_vars['objektdata']->value['timestampdifftext'];?>

        <?php } else { ?>
            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['objektdata']->value['timestamp'],"%d.%m.%Y");?>
 um <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['objektdata']->value['timestamp'],"%H:%M:%S");?>
 Uhr
        <?php }?>
        </font>
    </p>
</td><?php }} ?>
