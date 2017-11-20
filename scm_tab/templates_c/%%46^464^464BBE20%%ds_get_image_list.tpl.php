<?php /* Smarty version 2.6.19, created on 2010-03-22 15:15:34
         compiled from ds_get_image_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'ds_get_image_list.tpl', 5, false),array('modifier', 'date_format', 'ds_get_image_list.tpl', 9, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="ISO-8859-1"<?php echo '?>'; ?>

<response>
    <status><?php echo ((is_array($_tmp=$this->_tpl_vars['status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</status>
    <message><?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</message>
    <screenshots>
        <?php $_from = $this->_tpl_vars['screenshots']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['hour'] => $this->_tpl_vars['screenshot']):
?>
            <screenshot text="<?php echo ((is_array($_tmp=$this->_tpl_vars['screenshot']['post_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" 
                value="<?php echo ((is_array($_tmp=$this->_tpl_vars['screenshot']['post_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
/<?php echo $this->_tpl_vars['userid']; ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['screenshot']['post_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H-%M-%S") : smarty_modifier_date_format($_tmp, "%H-%M-%S")); ?>
.jpg"
                activity_note="<?php echo ((is_array($_tmp=$this->_tpl_vars['screenshot']['activity_note'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
                />
        <?php endforeach; endif; unset($_from); ?>
    </screenshots>
    <quick_breaks>
        <?php $_from = $this->_tpl_vars['breaks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['break']):
?>
            <quick_break start="<?php echo ((is_array($_tmp=$this->_tpl_vars['break']['start'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" end="<?php echo ((is_array($_tmp=$this->_tpl_vars['break']['end'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" diff="<?php echo ((is_array($_tmp=$this->_tpl_vars['break']['diff'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
"/>
        <?php endforeach; endif; unset($_from); ?>
    </quick_breaks>
    <lunch_breaks>
        <?php $_from = $this->_tpl_vars['lunch_breaks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['break']):
?>
            <lunch_break start="<?php echo ((is_array($_tmp=$this->_tpl_vars['break']['time_in'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" end="<?php echo ((is_array($_tmp=$this->_tpl_vars['break']['time_out'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" diff="<?php echo ((is_array($_tmp=$this->_tpl_vars['break']['diff'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
"/>
        <?php endforeach; endif; unset($_from); ?>
    </lunch_breaks>
    <time_records>
        <?php $_from = $this->_tpl_vars['time_records']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['time_record']):
?>
            <time_record start="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['time_in'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" end="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record']['time_out'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" diff="<?php echo $this->_tpl_vars['time_record']['diff']; ?>
"/>
        <?php endforeach; endif; unset($_from); ?>
    </time_records>
</response>