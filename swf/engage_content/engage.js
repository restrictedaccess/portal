function WriteSwfObject(strSwfFile, nWidth, nHeight, strScale, strAlign, strQuality, strBgColor, strFlashVars)
{
	var strHtml = "";

	strHtml += "<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,79,0' width='" + nWidth + "' height='" + nHeight + "' align='" + strAlign + "'>";
	strHtml += "<param name='allowScriptAccess' value='sameDomain' />";
	strHtml += "<param name='scale' value='" + strScale + "' />";
	strHtml += "<param name='movie' value='" + strSwfFile + "' />";
	strHtml += "<param name='quality' value='" + strQuality + "' />";
	strHtml += "<param name='bgcolor' value='" + strBgColor + "' />";
	strHtml += "<param name='flashvars' value='" + strFlashVars + "' />";
	strHtml += "<embed src='" + strSwfFile +"' flashvars='" + strFlashVars + "' scale='" + strScale + "' quality='" + strQuality + "' bgcolor='" + strBgColor + "' width='" + nWidth + "' height='" + nHeight + "' align='" + strAlign + "' allowscriptaccess='sameDomain' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />";
	strHtml += "</object>";

	document.write(strHtml);
}

function player_DoFSCommand(command, args) 
{
	args = String(args);
	command = String(command);
	var F_intData = args.split(";");

	switch (command)
	{
		case "QM_ZoomImage":
			PopZoomImage(F_intData[0], F_intData[1], F_intData[2]);
			break;
	}
}


////////////////////////////////////////////////////////////////////////////////
// Gets the base path
////////////////////////////////////////////////////////////////////////////////

function GetBasePath()
{
	var strFullPath = document.location.href;
	var nPos1 = -1;
	var nPos2 = -1;

	nPos1 = strFullPath.lastIndexOf("\\");
	nPos2 = strFullPath.lastIndexOf("/");

	if (nPos2 > nPos1)
	{
		nPos1 = nPos2;
	}

	if (nPos1 >= 0)
	{
		strFullPath = strFullPath.substring(0, nPos1 + 1);
	}

	return(strFullPath);
}

////////////////////////////////////////////////////////////////////////////////
// Zoom code
////////////////////////////////////////////////////////////////////////////////

var g_oZoomInfo = new Object();
var g_wndZoom;

function PopZoomImage(strFileName, nWidth, nHeight)
{
	var strScroll = "0";
	g_oZoomInfo.strContentFolder = g_strContentFolder;
	g_oZoomInfo.strFileName = strFileName;
	g_oZoomInfo.nWidth = parseInt(nWidth);
	g_oZoomInfo.nHeight = parseInt(nHeight);

	if (g_oZoomInfo.nWidth > screen.availWidth)
	{
		g_oZoomInfo.nWidth = screen.availWidth;
		strScroll = "1";
	}

	if (g_oZoomInfo.nHeight > screen.availHeight)
	{
		g_oZoomInfo.nHeight = screen.availHeight;
		strScroll = "1";
	}


	var strOptions = "width=" + g_oZoomInfo.nWidth +",height=" + g_oZoomInfo.nHeight + ", status=0, toolbar=0, location=0, menubar=0, scrollbars=" + strScroll;

	if (g_wndZoom)
	{
		try
		{
			g_wndZoom.close()
		}
		catch (e)
		{
		}
	}

	g_wndZoom = window.open(GetBasePath() + g_strContentFolder + "/zoom.html", "Zoom", strOptions);
}