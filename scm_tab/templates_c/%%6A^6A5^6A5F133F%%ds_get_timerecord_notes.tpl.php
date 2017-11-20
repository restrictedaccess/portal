<?php /* Smarty version 2.6.19, created on 2010-03-25 10:56:38
         compiled from ds_get_timerecord_notes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'ds_get_timerecord_notes.tpl', 9, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="ISO-8859-1"<?php echo '?>'; ?>

<response>
    <status><?php echo ((is_array($_tmp=$this->_tpl_vars['status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</status>
    <message><?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</message>
    <time_record_notes>
        <?php $_from = $this->_tpl_vars['time_record_notes_final']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['time_record_note']):
?>
            <time_record_note
                name="<?php echo $this->_tpl_vars['time_record_note']['name']; ?>
"
                note="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record_note']['note'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" 
                time_stamp="<?php echo ((is_array($_tmp=$this->_tpl_vars['time_record_note']['time_stamp'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" 
                />
        <?php endforeach; endif; unset($_from); ?>
    </time_record_notes>
</response>