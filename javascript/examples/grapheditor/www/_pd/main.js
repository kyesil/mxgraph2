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
		
		try
		{
			if (Editor.useLocalStorage)
			{
				if (localStorage.getItem(name) != null &&
					!mxUtils.confirm(mxResources.get('replaceIt', [name])))
				{
					return;
				}

				localStorage.setItem(name, xml);
				this.editor.setStatus(mxUtils.htmlEntities(mxResources.get('saved')) + ' ' + new Date());
			}
			else
			{
				if (xml.length < MAX_REQUEST_SIZE)
				{
					new mxXmlRequest(SAVE_URL, 'filename=' + encodeURIComponent(name) +
						'&xml=' + encodeURIComponent(xml)).simulate(document, '_blank');
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