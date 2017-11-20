<?php /* Smarty version 2.6.19, created on 2010-05-11 16:09:47
         compiled from ds_staff_activity_tracker.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'ds_staff_activity_tracker.tpl', 5, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="ISO-8859-1"<?php echo '?>'; ?>

<response>
    <status><?php echo ((is_array($_tmp=$this->_tpl_vars['status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</status>
    <message><?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</message>
    <ActivityTrackerNotes total_time_delay="<?php echo $this->_tpl_vars['total_time_delay']; ?>
">
        <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['activity_tracker_notes']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <Note id="<?php echo $this->_tpl_vars['activity_tracker_notes'][$this->_sections['j']['index']]['id']; ?>
" 
                    lname="<?php echo $this->_tpl_vars['activity_tracker_notes'][$this->_sections['j']['index']]['lname']; ?>
"
                    fname="<?php echo $this->_tpl_vars['activity_tracker_notes'][$this->_sections['j']['index']]['fname']; ?>
"
                    company_name="<?php echo $this->_tpl_vars['activity_tracker_notes'][$this->_sections['j']['index']]['company_name']; ?>
"
                    expected_time="<?php echo $this->_tpl_vars['activity_tracker_notes'][$this->_sections['j']['index']]['expected_time']; ?>
"
                    checked_in_time="<?php echo $this->_tpl_vars['activity_tracker_notes'][$this->_sections['j']['index']]['checked_in_time']; ?>
"
                    delay="<?php echo $this->_tpl_vars['activity_tracker_notes'][$this->_sections['j']['index']]['delay']; ?>
"
            ><?php echo '<![CDATA['; ?><?php echo $this->_tpl_vars['activity_tracker_notes'][$this->_sections['j']['index']]['note']; ?><?php echo ']]>'; ?>

            </Note>
        <?php endfor; endif; ?>
    </ActivityTrackerNotes>
</response>