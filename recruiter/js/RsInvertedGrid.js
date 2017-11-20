function RSInvertedGrid(config){
	this.config = config;
	this.config.page = 1;
	this.config.rows = 50;
	this.config.total = 0;
	this.columnHeights = [];
	this.sorters = "";
	this.sorterPos = [];
	this.config.defaulturl = this.config.url;
	this.config.baseurl = this.config.url;
	//console.log(this.config);
	this.config.url = this.config.url+"?rows="+this.config.rows+"&page="+this.config.page;
	this.data = null;
	this._loadingRequest = false;
	this._autoload = true;
	if (this.config.autoload!=undefined){
		this._autoload = this.config.autoload;	
	}
	
	this._events();
}
RSInvertedGrid.prototype.dataLoaded = function(){}
RSInvertedGrid.prototype._events = function(){
	var me = this;
	me.dataLoaded = me.config.dataLoaded;
	jQuery(".ui-pg-button").live("hover", function(){
		jQuery(this).toggleClass("ui-state-hover").css("cursor", "pointer");
	}).live("blur", function(){
		jQuery(this).toggleClass("ui-state-hover").css("cursor", "default");
	}).live("click", function(){
		if (jQuery(this).hasClass("ui-state-disabled")){
			return;
		}
		if (!me._loadingRequest){
			var id = jQuery(this).attr("id");
			if (id=="first_pager"){
				me.config.page = 1;
				jQuery(this).addClass("ui-state-disabled");
				jQuery("#prev_pager").addClass("ui-state-disabled");
				jQuery("#next_pager").removeClass("ui-state-disabled");
				jQuery("#last_pager").removeClass("ui-state-disabled");
			}else if (id=="prev_pager"){
				me.config.page--;
				if (me.config.page<=1){
					me.config.page = 1;
					jQuery(this).addClass("ui-state-disabled");
					jQuery("#first_pager").addClass("ui-state-disabled");
				}
				jQuery("#next_pager").removeClass("ui-state-disabled");
				jQuery("#last_pager").removeClass("ui-state-disabled");			
			}else if (id=="next_pager"){
				me.config.page++;
				if (me.config.page>=me.config.total){
					me.config.page = me.config.total;
					jQuery(this).addClass("ui-state-disabled");
					jQuery("#last_pager").addClass("ui-state-disabled");
				}
				jQuery("#prev_pager").removeClass("ui-state-disabled");
				jQuery("#first_pager").removeClass("ui-state-disabled");
			}else if (id=="last_pager"){
				me.config.page = me.config.total;
				jQuery("#first_pager").removeClass("ui-state-disabled");
				jQuery("#prev_pager").removeClass("ui-state-disabled");
				jQuery("#next_pager").addClass("ui-state-disabled");
				jQuery("#last_pager").addClass("ui-state-disabled");
			}
		}
		me.paginate();
	});
	jQuery(".ui-pg-input").live("keypress", function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
 		if(code == 13) { 
 			var value =parseInt(jQuery(this).val());
			if (isNaN(jQuery(this).val())){
				alert("Not a valid number");
			}else if (parseInt(jQuery("#sp_1_pager").val())<value){
				alert("You have entered an invalid page number");
			}else if (value<=0){
				alert("You have entered an invalid page number");
			}else{		
				me.config.page = value;	
			} 
			me.paginate();
		}
		
	})
	
	jQuery(".rs-header-item a").live("click", function(e){
		if (jQuery(this).hasClass("sorter")){
			if (!me._loadingRequest){
				me.sorters = "";
				var sorterColumn = jQuery(this).attr("data-col");
				var sortingInfo = {
					sorterColumn:sorterColumn
				};
				
				if (!jQuery(this).hasClass("asc")){
					jQuery(this).addClass("asc");
					sortingInfo.direction = "asc";
				}else if (!jQuery(this).hasClass("desc")){
					jQuery(this).addClass("desc");
					sortingInfo.direction = "desc";
				}else{
					jQuery(this).removeClass("asc").removeClass("desc");
					sortingInfo.direction = "";
				}
				var newSorterPos = [];
				var i = 0;
				jQuery.each(me.sorterPos, function(j, item){
					if (item.sorterColumn!=sortingInfo.sorterColumn){
						newSorterPos[i] = item;
						i++;
					}
				});
				newSorterPos[i] = sortingInfo;
				me.sorterPos = newSorterPos;
				jQuery(".ui-icon-triangle-1-s").remove();
				jQuery(".ui-icon-triangle-1-n").remove();
				i = 0;
				me.sorterPos = me.sorterPos.reverse();
				jQuery.each(me.sorterPos, function(j, item){
					if (item.direction!=""){
						me.sorters+=("&column_"+i+"="+item.sorterColumn+"&direction_"+i+"="+item.direction);	
						i++;
					}
				});
				jQuery(".sorter").each(function(){
					if (jQuery(this).hasClass("desc")){
						jQuery(this).append("<span class='ui-icon ui-icon-triangle-1-s'></span>");
					}else if (jQuery(this).hasClass("asc")){
						jQuery(this).append("<span class='ui-icon ui-icon-triangle-1-n'></span>");
					}else{
						jQuery(this).remove("span");
					}
				});
				me.sorters += ("&sorter_length="+(i));
				me.paginate();
			}
			
		}
		e.preventDefault();
	});
	
}

RSInvertedGrid.prototype.render = function(){
	var tableHeads = this._renderHeader();
	jQuery("#"+this.config.id).html(tableHeads);
	jQuery("#rs-grid-container-"+this.config.id).css("min-height", jQuery("#rs-header-"+this.config.id).outerHeight(true)+"px");
	if (this._autoload){
		this._renderBody();	
	}
	var me = this;
	function resizeGridBody(){
		var rsHeaderWidth = jQuery(".rs-header").width();
		var documentWidth = jQuery(document).width()-rsHeaderWidth-10;
		jQuery(".rs-grid-container").width(documentWidth);	
		i = 1; 
		jQuery(".rs-grid-container tr").each(function(){
			var header = jQuery(".rs-header tr:nth-child("+i+")");
			if (jQuery(this).children("td").children("ul").length>0||jQuery(this).children("td").children("select").length>0){
				header.height(jQuery(this).height()+2);
			}else{
				header.height(jQuery(this).height());	
			}
			i++;
		});	
		jQuery("#rs-preloader").width(documentWidth);
	
	}
	var flexify = setInterval(me.flexiColumns, 1000);
	jQuery(window).resize(resizeGridBody);
	resizeGridBody();
	if (this.config.pager!=undefined){
		this._renderPager();	
		jQuery("#prev_pager").addClass("ui-state-disabled");
		jQuery("#first_pager").addClass("ui-state-disabled");
	}
	jQuery(".rs-header tr").each(function(){
		me.columnHeights.push(jQuery(this).height());
	});
}

RSInvertedGrid.prototype._renderHeader = function(){
	var columns = this.config.columns;
	var models = this.config.colModel;
	var tableHeads = "<table id='rs-header-"+this.config.id+"' class='rs-header'>";
	tableHeads+="<tr class='rs-header-item'><td>&nbsp;</td></tr>";
	
	jQuery.each(columns, function(i, column){
		var model = models[i];
		var _class='';
		if (model.sortable!=undefined&&model.sortable){
			_class='sorter';
		}
		tableHeads+="<tr class='rs-header-item ui-state-default ui-th-column ui-th-ltr'>";
		tableHeads+=("<td><a href='#' class='"+_class+"' data-col='"+model.name+"'>"+column+"</a></td>");
		
		tableHeads+="</tr>";
	});
	var container = "<div class='rs-grid-container' id='rs-grid-container-"+this.config.id+"'></div>";
	tableHeads+="</table>";
	return tableHeads+container;
}

RSInvertedGrid.prototype._resetColumns = function(){
	var i = 1;
	var me = this;
	jQuery(".rs-header tr").each(function(){
		jQuery(this).height(me.columnHeights[i-1]);
		i++;
	});
}
RSInvertedGrid.prototype._createOverlay = function(){
	var overlay = "<div class='ui-overlay'>";
	overlay+="<div class='ui-widget-overlay'></div>";
	overlay+="<div class='ui-widget-shadow ui-corner-all'></div>";
	overlay+="</div>";
	return jQuery(overlay);
}
RSInvertedGrid.prototype.flexiColumns = function(){
	var i = 1; 
	jQuery(".rs-grid-container tr").each(function(){
		var header = jQuery(".rs-header tr:nth-child("+i+")");
		if (!jQuery.browser.mozilla){
			if (jQuery(window).width()>=600){
				header.height(jQuery(this).outerHeight(true));	
			}else{
				header.height(jQuery(this).height());
			}
		}else{
			header.height(jQuery(this).height());
		}
		i++;
	});		
}
RSInvertedGrid.prototype.loadPreloader = function(){
	var gridHeight = jQuery("#rs-grid-container-"+this.config.id).outerHeight(true);
	gridHeight = gridHeight/2;
	
	var preloader = "<div id='rs-preloader' class='rs-preloader'>";
	preloader+="<img src='../images/ajax-loader.gif'/ id='preloader-img' style='position:relative"+"'>";
	preloader+="</div>";
	var height = jQuery("#rs-header-"+this.config.id).height();
	var width = jQuery("#rs-grid-container-"+this.config.id).width();
	var offset = jQuery("#rs-grid-container-"+this.config.id).offset();
	jQuery(preloader).appendTo("body").css("height", height+"px").css("width", width+"px").css({opacity:0.5}).fadeIn(100);
	if (offset!=null){
		jQuery("#rs-preloader").css("left", offset.left+"px").css("top", offset.top+"px");
		var img = jQuery("#preloader-img");
		img.css("top", gridHeight-img.height());
	}
}
RSInvertedGrid.prototype.removePreloader = function(){
	jQuery("#rs-preloader").fadeOut(100, function(){
		jQuery(this).remove();
	});
}

RSInvertedGrid.prototype._renderBody = function(){
	var url = this.config.url;
	var colModel = this.config.colModel;
	var selfConfig = this.config;
	var columnData = [];
	var me = this;
	if (!me._loadingRequest){
		me._loadingRequest = true;
		var height = jQuery("#rs-grid-container-"+selfConfig.id).height();
		var width = jQuery("#rs-grid-container-"+selfConfig.id).width();
		me.loadPreloader();
		jQuery.get(url, function(data){
			
			me._loadingRequest = false;
			data = jQuery.parseJSON(data);
			me.data = data;
			me.config.total = data.total;
			if (data.total==parseInt(data.page)){
				jQuery("#next_pager").addClass("ui-state-disabled");
				jQuery("#last_pager").addClass("ui-state-disabled");
			}else{
				jQuery("#next_pager").removeClass("ui-state-disabled");
				jQuery("#last_pager").removeClass("ui-state-disabled");
			}
			me.removePreloader();
			
			var pass_dues = [];
			
			jQuery.each(data.rows, function(i, item){
				
				if (typeof item.pass_due_order != "undefined"){
					if (item.pass_due_order){
						pass_dues.push(i+1);
					}					
				}

				
				var columnContent = {};
				columnContent.number = i+1;
				columnContent.fields = [];
				jQuery.each(colModel, function(j, model){
					var found = false;
					var columnField = {};
					for(var key in item){
						if (model.name == key){
							var output = "";
							if (model.formatter!=undefined){
								output = model.formatter(item[key], selfConfig, item)
							}else{
								output = item[key];
							}
							output = jQuery.trim(output);
							if (output==""){
								output = "&nbsp;";
							}
							columnField.model = model;
							columnField.output = output;
							found = true;
							//console.log(model.name);
							break;
							
						}
						
					}
					columnContent.fields.push(columnField);
				});
				columnData.push(columnContent);
			});
			
			
			var length = columnData.length;
			var tableContent = "<table class='clear ui-jqgrid-btable'>";
			tableContent+="<tr>";
			var i = 0;
			var number = 0;
			var page = parseInt(data.page);
			for(i=1;i<=length;i++){
				number = ((page-1)*me.config.rows) + i;
				
				if (jQuery.inArray(i, pass_dues)==-1){
					tableContent+=("<td title='"+number+"' class='ui-state-default ui-th-column ui-th-ltr'>"+number+"</td>");				
				}else{
					tableContent+=("<td title='"+number+"' class='ui-state-default ui-th-column ui-th-ltr' style='background-color:#ff0000;color:#fff;background-image:none!important'>"+number+"</td>");	
				}
			}	
			tableContent+="</tr>";
			if (columnData.length>0){
				for (j=0;j<columnData[0].fields.length;j++){
					tableContent+="<tr class='ui-widget-content jqgrow ui-row-ltr'>";
					for(i=0;i<length;i++){
						var align = "";
						if (columnData[i].fields[j].model.align!=undefined){
							align="align='"+columnData[i].fields[j].model.align+"'";
						}
						//console.log(columnData[i].fields[j].model.showTitle);
						if (columnData[i].fields[j].model.showTitle!=undefined&&columnData[i].fields[j].model.showTitle){						
							tableContent+=("<td title='"+jQuery(columnData[i].fields[j].output).text()+"' role='grid_cell' "+align+" class='gridrow'>"+columnData[i].fields[j].output+"</td>");		
						}else{
							tableContent+=("<td role='grid_cell' "+align+" class='gridrow'>"+columnData[i].fields[j].output+"</td>");
						}
					}
					tableContent+="</tr>";
				}
				tableContent+="</table>";
				jQuery("#rs-grid-container-"+selfConfig.id).html(tableContent).scrollLeft(0);
				me.flexiColumns();
				number = ((page-1)*me.config.rows) + 1;
				jQuery(".ui-pg-input").val(data.page);
				jQuery("#sp_1_pager").text(data.total);
				var lastRecord = ((number+data.rows.length)-1);
				if (lastRecord>data.records){
					lastRecord = data.records;
				}
				jQuery(".ui-paging-info").text("View "+number+" - "+lastRecord+" of "+data.records);
			}else{
				jQuery("#rs-grid-container-"+selfConfig.id).html("");
				jQuery(".ui-pg-input").val(0);
				jQuery("#sp_1_pager").text(0);
				jQuery(".ui-paging-info").text("View 0 - 0 of 0");				
				me._resetColumns();
			}
			me.dataLoaded();
		});
	}
}
RSInvertedGrid.prototype.reload = function(url){
	this.config.page = 1;
	this.config.defaulturl = url;
	this.config.url = (url+"&rows="+this.config.rows+"&page="+this.config.page+this.sorters);
	this._renderBody();
}
RSInvertedGrid.prototype.refresh = function(){
	this.config.page = 1;
	this.config.defaulturl = this.config.baseurl;
	this.sorters = "";
	this._renderBody();
}
RSInvertedGrid.prototype.paginate = function(){
	this.config.url = this.config.defaulturl;
	if (this.config.url.indexOf("?") == -1){
		this.config.url = (this.config.url+"?"+"&rows="+this.config.rows+"&page="+this.config.page+this.sorters);
	}else{
		this.config.url = (this.config.url+"&rows="+this.config.rows+"&page="+this.config.page+this.sorters);		
	}
	this._renderBody();
	//this.sorters = "";
}
RSInvertedGrid.prototype._renderPager = function(){
	var pager = "<div id='pg_pager' class='ui-pager-control' role='group'>";
	pager+="<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"ui-pg-table\" style=\"width:100%;table-layout:fixed;height:100%;\" role=\"row\">";
		pager+="<tr>";
		pager+='<td id="pager_left" align="left">&nbsp;</td>';
		pager+='<td id="pager_center" align="center">';
			pager+="<table cellspacing=\"0\" cellpadding=\"0\" border\"0\" style=\"table-layout:auto;\" class=\"ui-pg-table\">";
			pager+="<tr>";
				pager+='<td id="first_pager" class=\"ui-pg-button ui-corner-all\" style=\"cursor: default; \"><span class=\"ui-icon ui-icon-seek-first\"></span></td>';
				pager+='<td id="prev_pager" class=\"ui-pg-button ui-corner-all\" style=\"cursor: default; \"><span class=\"ui-icon ui-icon-seek-prev\"></span></td>';
				pager+='<td class="ui-pg-button ui-state-disabled" style="width:4px;"><span class="ui-separator"></span></td>';
				
				pager+='<td dir="ltr">';
					pager+='Page <input class="ui-pg-input" type="text" size="2" maxlength="7" value="0" role="textbox"/> of <span id="sp_1_pager">0</span>';
					
				pager+="</td>";
				
				pager+='<td class="ui-pg-button ui-state-disabled" style="width:4px;"><span class="ui-separator"></span></td>';
				pager+='<td id="next_pager" class=\"ui-pg-button ui-corner-all\" style=\"cursor: default; \"><span class=\"ui-icon ui-icon-seek-next\"></span></td>';
				pager+='<td id="last_pager" class=\"ui-pg-button ui-corner-all\" style=\"cursor: default; \"><span class=\"ui-icon ui-icon-seek-end\"></span></td>';
				
			pager+="</tr>";
			pager+="</table>";
		pager+="</td>";
		pager+="<td id='pager_right' align='left'>";
			pager+='<div div="ltr" style="text-align:right" class="ui-paging-info">View 0 - 0 of 0</div>';
		pager+="</td>";
		pager+="</tr>";
	pager+="</table>";
	pager+="</div>";
	jQuery(this.config.pager).html(pager).addClass("ui-state-default ui-jqgrid-pager ui-corner-bottom");
}
