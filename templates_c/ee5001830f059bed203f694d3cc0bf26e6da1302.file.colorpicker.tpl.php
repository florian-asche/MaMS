<?php /* Smarty version Smarty-3.1.18, created on 2016-05-16 22:09:27
         compiled from "templates/greensky/control_panels/colorpicker.tpl" */ ?>
<?php /*%%SmartyHeaderCode:147431212157323c4a774e42-95177090%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee5001830f059bed203f694d3cc0bf26e6da1302' => 
    array (
      0 => 'templates/greensky/control_panels/colorpicker.tpl',
      1 => 1463429358,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '147431212157323c4a774e42-95177090',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_57323c4a8ae958_72520457',
  'variables' => 
  array (
    'objekt' => 0,
    'objektdata' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57323c4a8ae958_72520457')) {function content_57323c4a8ae958_72520457($_smarty_tpl) {?></td></tr>
<tr align="center">








<td class="object_control_panel">
<form id="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
colorpicker1">
<input id="someInput" name="someInput" class="colorpicker" value="rgb(<?php echo $_smarty_tpl->tpl_vars['objektdata']->value['resolved_data']['r'];?>
, <?php echo $_smarty_tpl->tpl_vars['objektdata']->value['resolved_data']['g'];?>
, <?php echo $_smarty_tpl->tpl_vars['objektdata']->value['resolved_data']['b'];?>
)" />
<input type="hidden" id="mode" name="mode" value="raw">
<input type="hidden" id="r" name="r" value="">
<input type="hidden" id="g" name="g" value="">
<input type="hidden" id="b" name="b" value="">
<input type="hidden" id="ww" name="ww" value="0">
<input type="hidden" id="cw" name="cw" value="0">
<input type="hidden" id="cw" name="cmd" value="fade">
<input type="hidden" id="t" name="t" value="600">
<input type="hidden" id="q" name="q" value="0">

<input type="hidden" id="station_protocols_ID" name="station_protocols_ID" value="<?php echo $_smarty_tpl->tpl_vars['objekt']->value['station_protocols']['ID'];?>
">
<input type="hidden" id="function" name="function" value="send_data">
<input type="hidden" id="function" name="priority" value="10">
</form>
</td>


</td></tr>


<script type="text/javascript">

    
    var $colors = $('input.colorpicker').colorPicker({
            customBG: '#222',
            readOnly: true,
            init: function(elm, colors) { // colors is a different instance (not connected to colorPicker)
                elm.style.backgroundColor = elm.value;
                elm.style.color = colors.rgbaMixCustom.luminance > 0.22 ? '#222' : '#ddd';
            }
        }).each(function(idx, elm) {
        //$(elm).css({'background-color': this.value})
        });

</script><?php }} ?>
