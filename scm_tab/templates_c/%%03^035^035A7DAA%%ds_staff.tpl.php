<?php /* Smarty version 2.6.19, created on 2010-03-22 15:15:28
         compiled from ds_staff.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'ds_staff.tpl', 5, false),array('modifier', 'date_format', 'ds_staff.tpl', 16, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="ISO-8859-1"<?php echo '?>'; ?>

<response>
    <status><?php echo ((is_array($_tmp=$this->_tpl_vars['status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</status>
    <message><?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</message>
    <admin_status><?php echo $this->_tpl_vars['admin_status']; ?>
</admin_status>
    <staffs>
        <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['staff']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?>
            <staff userid="<?php echo $this->_tpl_vars['staff'][$this->_sections['j']['index']]['userid']; ?>
" 
                    lname="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff'][$this->_sections['j']['index']]['lname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
                    fname="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff'][$this->_sections['j']['index']]['fname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
                    email="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff'][$this->_sections['j']['index']]['email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
                    skype_id="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff'][$this->_sections['j']['index']]['skype_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
                    image="<?php echo $this->_tpl_vars['staff'][$this->_sections['j']['index']]['image']; ?>
"
                    last_snapshot_date="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff'][$this->_sections['j']['index']]['last_snapshot_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"
                    last_snapshot_time="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff'][$this->_sections['j']['index']]['last_snapshot_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%r") : smarty_modifier_date_format($_tmp, "%r")); ?>
"
                    last_machine_reported_date="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff'][$this->_sections['j']['index']]['last_machine_reported_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"
                    last_machine_reported_time="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff'][$this->_sections['j']['index']]['last_machine_reported_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%r") : smarty_modifier_date_format($_tmp, "%r")); ?>
"
                    last_activity_note_date="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff'][$this->_sections['j']['index']]['last_activity_note_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"
                    last_activity_note_time="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff'][$this->_sections['j']['index']]['last_activity_note_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%r") : smarty_modifier_date_format($_tmp, "%r")); ?>
"
                    subcontractors_id="<?php echo $this->_tpl_vars['staff'][$this->_sections['j']['index']]['subcontractors_id']; ?>
"
                    leads_id="<?php echo $this->_tpl_vars['staff'][$this->_sections['j']['index']]['leads_id']; ?>
"
                    leads_name="<?php echo ((is_array($_tmp=$this->_tpl_vars['staff'][$this->_sections['j']['index']]['leads_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
                    status="<?php echo $this->_tpl_vars['staff'][$this->_sections['j']['index']]['status']; ?>
"
                />
        <?php endfor; endif; ?>
    </staffs>
</response>