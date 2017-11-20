<?php /* Smarty version 2.6.19, created on 2014-01-21 11:21:11
         compiled from index.tpl */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tracking Links Monitoring</title>

<link href="../site_media/workflow_v2/js/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../site_media/workflow_v2/js/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

<script src="../site_media/workflow_v2/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../site_media/workflow_v2/js/modernzr.js"></script>    
<script type="text/javascript" src="../site_media/workflow_v2/js/bootstrap/js/bootstrap.min.js"></script>


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../site_media/workflow_v2/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
<link rel="shortcut icon" href="../favicon.ico">    
</head>

<body>
<div style="margin:auto; width:70%;">
<h3 align="center">Tracking Links Monitoring</h3>
<p align="center">(Promotional Codes List)</p>
<form name="form" method="post">
<div style="margin:5px;">Owner : 
<select name="tracking_createdby" id="tracking_createdby">
	<option value="">Please Select</option>
	<?php $_from = $this->_tpl_vars['creators']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['creator'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['creator']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['creator']):
        $this->_foreach['creator']['iteration']++;
?>
    	<option <?php if ($this->_tpl_vars['tracking_createdby'] == $this->_tpl_vars['creator']['tracking_createdby']): ?> selected="selected" <?php endif; ?>value="<?php echo $this->_tpl_vars['creator']['tracking_createdby']; ?>
"><?php echo $this->_tpl_vars['creator']['fname']; ?>
 <?php echo $this->_tpl_vars['creator']['lname']; ?>
 - <?php echo $this->_tpl_vars['creator']['work_status']; ?>
</option>
    <?php endforeach; endif; unset($_from); ?>
</select> <button>Go</button>
</div>
<hr>
<?php if ($this->_tpl_vars['codes']): ?>
<table width="100%" cellpadding="1" border="1" style="font-size:11px; font-family:tahoma;">
	<thead>
        <th>Code</th>
        <th>Description</th>
		<th>Date Created</th>
		<th>Points</th>
		<th>Hits</th>

	</thead>
	<tbody>
        <?php $_from = $this->_tpl_vars['codes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tracking'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tracking']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['tracking']):
        $this->_foreach['tracking']['iteration']++;
?>
        <tr>
            <td valign="top" ><?php echo $this->_tpl_vars['tracking']['tracking_no']; ?>

            <td valign="top" ><?php echo $this->_tpl_vars['tracking']['tracking_desc']; ?>
</td>
            <td valign="top" ><?php echo $this->_tpl_vars['tracking']['tracking_created']; ?>
</td>
            <td valign="top" align="center" ><?php if ($this->_tpl_vars['tracking']['points']): ?><?php echo $this->_tpl_vars['tracking']['points']; ?>
<?php else: ?>0<?php endif; ?></td>
            <td valign="top" align="center" class="tracking_id" tracking_id="<?php echo $this->_tpl_vars['tracking']['id']; ?>
" id="<?php echo $this->_tpl_vars['tracking']['id']; ?>
_td"><img src="../images/ajax-loader.gif" width="20" height="20" /></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
    </tbody>

</table>
<?php endif; ?>
<p align="center" class="muted">Beta version 2014-01-21</p>
</form>
</td>
</body>
<script type="text/javascript" src="../site_media/bulletin_board/js/jquery.ajaxq-0.0.1.js"></script>
<script type="text/javascript" src="./media/js/pcm.js"></script></script>
</html>