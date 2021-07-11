<?php /* Smarty version Smarty-3.1.18, created on 2016-01-22 13:19:16
         compiled from "templates/greensky/mouseover/data_minmax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:205829254456a21e442300d4-42683167%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1fc2f6d9ef012476ca1e792fc77b3c640b463856' => 
    array (
      0 => 'templates/greensky/mouseover/data_minmax.tpl',
      1 => 1420130226,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '205829254456a21e442300d4-42683167',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'objekt' => 0,
    'value' => 0,
    'default_configuration' => 0,
    'minmaxdata' => 0,
    'tabledata_array' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56a21e442bebd4_56860135',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a21e442bebd4_56860135')) {function content_56a21e442bebd4_56860135($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include '/var/www/html/mams/lib/Smarty-3.1.18/libs/plugins/function.cycle.php';
?><table border = "0">
    <thead>
        <tr>
            <th style="background-color: #d0d0d0"><font color="black"><?php echo $_smarty_tpl->getConfigVariable('time_discription');?>
</font></th>
            <th style="background-color: #d0d0d0"><font color="black"><?php echo $_smarty_tpl->getConfigVariable('type_discription');?>
</font></th>
            
            <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['show_table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                    <th style="background-color: #d0d0d0"><font color="black"><?php echo $_smarty_tpl->tpl_vars['default_configuration']->value['datatypes'][$_smarty_tpl->tpl_vars['value']->value]['description'];?>
</font></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php  $_smarty_tpl->tpl_vars['tabledata_array'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tabledata_array']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['minmaxdata']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tabledata_array']->key => $_smarty_tpl->tpl_vars['tabledata_array']->value) {
$_smarty_tpl->tpl_vars['tabledata_array']->_loop = true;
?>
            <tr style="background-color: <?php echo smarty_function_cycle(array('values'=>"#eeeeee,#d0d0d0"),$_smarty_tpl);?>
">
                <td><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['time'];?>
<?php echo $_smarty_tpl->getConfigVariable('time_unit');?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['type'];?>
 <?php echo $_smarty_tpl->getConfigVariable('type_unit');?>
</td>
                
                <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['objekt']->value['objects']['configuration']['show_table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                    <td>
                        <?php if (isset($_smarty_tpl->tpl_vars['tabledata_array']->value['resolved_data'][$_smarty_tpl->tpl_vars['value']->value])) {?>
                            <?php echo $_smarty_tpl->tpl_vars['tabledata_array']->value['resolved_data'][$_smarty_tpl->tpl_vars['value']->value];?>
<?php echo $_smarty_tpl->tpl_vars['default_configuration']->value['datatypes'][$_smarty_tpl->tpl_vars['value']->value]['unit'];?>

                        <?php }?>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table><?php }} ?>
