<?php /* Smarty version 2.6.19, created on 2009-05-04 14:03:46
         compiled from adminGetNote.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'adminGetNote.tpl', 2, false),array('modifier', 'escape', 'adminGetNote.tpl', 5, false),)), $this); ?>
<?php echo '<div class=\'time_record_notes '; ?><?php echo smarty_function_cycle(array('values' => "bg_color_note_1, bg_color_note_2"), $this);?><?php echo '\'>'; ?><?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['time_record_notes']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?><?php echo '<div class="time_record_left_floater"><div class="time_record_notes_name">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['time_record_notes'][$this->_sections['j']['index']]['first_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?><?php echo ' :</div><div class="time_record_notes_note">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['time_record_notes'][$this->_sections['j']['index']]['note'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?><?php echo '</div></div><div class="clear"></div>'; ?><?php endfor; endif; ?><?php echo '</div><div class="clear"></div>'; ?>
