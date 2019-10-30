var svgExport = function()
{
var graphCreateSvgImageExport = Graph.prototype.createSvgImageExport;
	
	Graph.prototype.createSvgImageExport = function()
	{
		var exp = graphCreateSvgImageExport.apply(this, arguments);
		
		// Overrides rendering to add metadata
		var expDrawCellState = exp.drawCellState;

		exp.drawCellState = function(state, canvas)
		{
			var svgDoc = canvas.root.ownerDocument;
			var g = (svgDoc.createElementNS != null) ?
					svgDoc.createElementNS(mxConstants.NS_SVG, 'g') : svgDoc.createElement('g');
			g.setAttribute('id', 'cell-' + state.cell.id);

			// Temporary replaces root for content rendering
			var prev = canvas.root;
			prev.appendChild(g);
			canvas.root = g;
			
			expDrawCellState.apply(this, arguments);
			
			// Adds metadata if group is not empty
			if (g.firstChild == null)
			{
				g.parentNode.removeChild(g);
			}
			else if (mxUtils.isNode(state.cell.value))
			{
				//g.setAttribute('content', mxUtils.getXml(state.cell.value));
				
				for (var i = 0; i < state.cell.value.attributes.length; i++)
				{
					var attrib = state.cell.value.attributes[i];
					g.setAttribute('' + attrib.name, attrib.value);
				}
			}
			
			// Restores previous root
			canvas.root = prev;
		};

		return exp;
	};

	};
svgExport();

EditorUi.prototype.save = function(name)
{
	if (name != null)
	{
		if (this.editor.graph.isEditing())
		{
			this.editor.graph.stopEditing();
		}

		var xml = mxUtils.getXml(this.editor.getGraphXml());
		var svg = mxUtils.getXml(this.editor.graph.getSvg(null, 1, 0))
		
		try
		{
			if (this.editor.modified)
			{
			
				if (xml.length < MAX_REQUEST_SIZE*1.5)
				{
					localStorage.setItem(name, xml);
					new mxXmlRequest(SAVE_URL, 'filename=' + encodeURIComponent(name) +
						'&xml=' + encodeURIComponent(xml)+'&svg=' + encodeURIComponent(svg)).send();
						this.editor.setStatus(mxUtils.htmlEntities(name+ " - "+mxResources.get('saved')) + ' ' + new Date());
				}
				else
				{
					mxUtils.alert(mxResources.get('drawingTooLarge'));
					mxUtils.popup(xml);
					
					return;
				}
			}

			this.editor.setModified(false);
			this.editor.setFilename(name);
			this.updateDocumentTitle();
		}
		catch (e)
		{
			this.editor.setStatus(mxUtils.htmlEntities(mxResources.get('errorSavingFile')));
		}
	}
};


EditorUi.prototype.saveFile = function(forceDialog)
{
	if (!forceDialog && this.editor.filename != null)
	{
		this.save(this.editor.getOrCreateFilename());
	}
	else
	{
		var dlg = new FilenameDialog(this, this.editor.getOrCreateFilename(), mxResources.get('save'), mxUtils.bind(this, function(name)
		{
			this.save(name);
		}), null, mxUtils.bind(this, function(name)
		{
			if (name != null && name.length > 0)
			{
				return true;
			}
			
			mxUtils.confirm(mxResources.get('invalidName'));
			
			return false;
		}));
		this.showDialog(dlg.container, 300, 100, true, true);
		dlg.init();
	}
};