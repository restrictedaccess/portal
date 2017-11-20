<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<title>Tab-View Sample</title>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords"    content="" />

<link rel="stylesheet" type="text/css" href="tab-view.css" />

</head>
<body>

<?php $id = isset($_GET['id']) ? $_GET['id'] : 1; ?>

<div class="TabView" id="TabView">


<!-- ***** Tabs ************************************************************ -->

<div class="Tabs" style="width: 452px;">
  <a <?=($id == 1) ? 'class="Current"' : 'href="sample.php?id=1"';?>>Tab 1</a>
  <a <?=($id == 2) ? 'class="Current"' : 'href="sample.php?id=2"';?>>Tab 2</a>
  <a <?=($id == 3) ? 'class="Current"' : 'href="sample.php?id=3"';?>>Tab 3</a>
</div>


<!-- ***** Pages *********************************************************** -->

<div class="Pages" style="width: 450px; height: 300px;">

  <div class="Page" style="display: <?=($id == 1) ? 'block' : 'none';?>">
  <div class="Pad">
    Page 1
  </div>
  </div>

  <div class="Page" style="display: <?=($id == 2) ? 'block' : 'none';?>">
  <div class="Pad">
    Page 2
  </div>
  </div>

  <div class="Page" style="display: <?=($id == 3) ? 'block' : 'none';?>">
  <div class="Pad">
    Page 3
  </div>
  </div>

</div>

</div>

<script type="text/javascript" src="tab-view.js"></script>
<script type="text/javascript">
tabview_initialize('TabView');
</script>

</body>
</html>