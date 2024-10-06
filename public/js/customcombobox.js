//CUSTOM COMBOBOX ORIGINAL DE JQUERY CON DROPDOWN
$.widget( "custom.combobox", {
	_create: function() {
		this.wrapper = $( "<span>" )
			.addClass( "custom-combobox" )
			.insertAfter( this.element );

		this.element.hide();
		this._createAutocomplete();
		this._createShowAllButton();
	},

	_createAutocomplete: function() {
		var selected = this.element.children( ":selected" ),
			value = selected.val() ? selected.text() : "";

		this.input = $( "<input>" )
			.appendTo( this.wrapper )
			.val( value )
			.attr( "title", "" )
			.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
			.autocomplete({
				delay: 0,
				minLength: 0,
				source: $.proxy( this, "_source" )
			})
			.tooltip({
				classes: {
					"ui-tooltip": "ui-state-highlight"
				}
			});

		this._on( this.input, {
			autocompleteselect: function( event, ui ) {
				ui.item.option.selected = true;

				this._trigger( "select", event, {
					item: ui.item.option
				});
			},

			autocompletechange: "_removeIfInvalid"
		});
	},

	_createShowAllButton: function() {
		var input = this.input,
			wasOpen = false;

		$( "<a>" )
			.attr( "tabIndex", -1 )
			.attr( "title", "Mostrar todos los items" )
			.tooltip()
			.appendTo( this.wrapper )
			.button({
				icons: {
					primary: "ui-icon-triangle-1-s"
				},
				text: false
			})
			.removeClass( "ui-corner-all" )
			.addClass( "custom-combobox-toggle ui-corner-right" )
			.on( "mousedown", function() {
				wasOpen = input.autocomplete( "widget" ).is( ":visible" );
			})
			.on( "click", function() {
				input.trigger( "focus" );

				// Close if already visible
				if ( wasOpen ) {
					return;
				}

				// Pass empty string as value to search for, displaying all results
				input.autocomplete( "search", "" );
			});
	},

	_source: function( request, response ) {
		var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
		response( this.element.children( "option" ).map(function() {
			var text = $( this ).text();
			var fila = $(this).data('fila');
			if ( this.value && ( !request.term || matcher.test(text) ) )
				return {
					label: text,
					value: text,
					option: this,
					fila: fila
				};
		}) );
	},

	_removeIfInvalid: function( event, ui ) {

		// Selected an item, nothing to do
		if ( ui.item ) {
			return;
		}

		// Search for a match (case-insensitive)
		var value = this.input.val(),
			valueLowerCase = value.toLowerCase(),
			valid = false;
		this.element.children( "option" ).each(function() {
			if ( $( this ).text().toLowerCase() === valueLowerCase ) {
				this.selected = valid = true;
				return false;
			}
		});

		// Found a match, nothing to do
		if ( valid ) {
			return;
		}

		// Remove invalid value
		this.input
			.val( "" )
			.attr( "title", value + " No coincide ningun item." )
			.tooltip( "open" );
		this.element.val( "" );
		this._delay(function() {
			this.input.tooltip( "close" ).attr( "title", "" );
		}, 2500 );
		this.input.autocomplete( "instance" ).term = "";
	},

	_destroy: function() {
		this.wrapper.remove();
		this.element.show();
	},

	//esta funcion permite asignar el valor al autocomplete ejem= $(#aaa).combobox('autocomplete',id)
	autocomplete : function(value) {
		this.element.val(value);

        var selected = this.element.children(":selected"),
                value = selected.val() ? selected.text() : "";
        this.input.val(value);
    }
});

//CUSTOM COMBOBOX PARA CATEGORIAS
$.widget( "custom.comboboxcategoria", {
	_create: function() {
		this.wrapper = $( "<span>" )
			.addClass( "custom-combobox" )
			.insertAfter( this.element );

		this.element.hide();
		this._createAutocomplete();
		this._createShowAllButton();
	},

	_createAutocomplete: function() {
		var selected = this.element.children( ":selected" ),
			value = selected.val() ? selected.text() : "";


		/******CESAR***************/
        var idActual = this.element[0].id;
        var nuevoIdInputSelect = "inputselect_" + idActual;
        /**********FIN - CESAR***********/

		this.input = $( "<input id='"+nuevoIdInputSelect+"'>" )
			.appendTo( this.wrapper )
			.val( value )
			.attr( "title", value )
			.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
			.autocomplete({
				delay: 0,
				minLength: 0,
				source: $.proxy( this, "_source" )
			})
			.tooltip({
				classes: {
					"ui-tooltip": "ui-state-highlight"
				}
			});

		this._on( this.input, {
			autocompleteselect: function( event, ui ) {
				ui.item.option.selected = true;

				//valores del item seleccionado
				// console.log(ui.item.option.value);
				// console.log(ui.item);
				// console.log(nuevoIdInputSelect);

				asignarAutocompleteProducto(ui.item.option.value,ui.item.fila);

				//agregado ruddy para el title 
	            //$('#'+nuevoIdInputSelect).prop('title', ui.item.value);
	            //en agregado ruddy title

	            //verficamos el valor del select 
	            //console.log("El valor es "+$("#cat-"+ui.item.fila).val());

				this._trigger( "select", event, {
					item: ui.item.option
				});
			},

			autocompletechange: "_removeIfInvalid"
		});
	},

	_createShowAllButton: function() {
		var input = this.input,
			wasOpen = false;

		$( "<a>" )
			.attr( "tabIndex", -1 )
			.attr( "title", "" )
			.tooltip()
			.appendTo( this.wrapper )
			.button({
				icons: {
					primary: "ui-icon-triangle-1-s"
				},
				text: false
			})
			.removeClass( "ui-corner-all" )
			.addClass( "custom-combobox-toggle ui-corner-right" )
			.on( "mousedown", function() {
				wasOpen = input.autocomplete( "widget" ).is( ":visible" );
			})
			.on( "click", function() {
				input.trigger( "focus" );

				// Close if already visible
				if ( wasOpen ) {
					return;
				}

				// Pass empty string as value to search for, displaying all results
				input.autocomplete( "search", "" );
			});
	},

	_source: function( request, response ) {
		var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
		response( this.element.children( "option" ).map(function() {
			var text = $( this ).text();
			var fila = $(this).data('fila');
			if ( this.value && ( !request.term || matcher.test(text) ) )
				return {
					label: text,
					value: text,
					option: this,
					fila: fila
				};
		}) );
	},

	_removeIfInvalid: function( event, ui ) {

		// Selected an item, nothing to do
		if ( ui.item ) {
			return;
		}

		// Search for a match (case-insensitive)
		var value = this.input.val(),
			valueLowerCase = value.toLowerCase(),
			valid = false;
		this.element.children( "option" ).each(function() {
			if ( $( this ).text().toLowerCase() === valueLowerCase ) {
				this.selected = valid = true;
				return false;
			}
		});

		// Found a match, nothing to do
		if ( valid ) {
			return;
		}

		// Remove invalid value
		this.input
			.val( "" )
			.attr( "title", value + " No coincide ningun item." )
			.tooltip( "open" );
		this.element.val( "" );
		this._delay(function() {
			this.input.tooltip( "close" ).attr( "title", "" );
		}, 2500 );
		this.input.autocomplete( "instance" ).term = "";
	},

	_destroy: function() {
		this.wrapper.remove();
		this.element.show();
	},

	autocomplete : function(value) {
		this.element.val(value);

        var selected = this.element.children(":selected"),
                value = selected.val() ? selected.text() : "";
        this.input.val(value);
    }
});

//CUSTOM COMBOBOX PARA PRODUCTOS
$.widget( "custom.comboboxproducto", {
	_create: function() {
		this.wrapper = $( "<span>" )
			.addClass( "custom-combobox" )
			.insertAfter( this.element );

		this.element.hide();
		this._createAutocomplete();
		this._createShowAllButton();
	},

	_createAutocomplete: function() {
		var selected = this.element.children( ":selected" ),
			value = selected.val() ? selected.text() : "";


		/******CESAR***************/
        var idActual = this.element[0].id;
        var nuevoIdInputSelect = "inputselect_" + idActual;
        /**********FIN - CESAR***********/

		this.input = $( "<input id='"+nuevoIdInputSelect+"'>" )
			.appendTo( this.wrapper )
			.val( value )
			.attr( "title", value )
			.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
			.autocomplete({
				delay: 0,
				minLength: 0,
				source: $.proxy( this, "_source" )
			})
			.tooltip({
				classes: {
					"ui-tooltip": "ui-state-highlight"
				}
			});

		this._on( this.input, {
			autocompleteselect: function( event, ui ) {
				ui.item.option.selected = true;
				this._trigger( "select", event, {
					item: ui.item.option
				});
				
				elegirProductoFila(ui.item.option.value,ui.item.fila,ui.item.precio,ui.item.unidad,ui.item.stock);

				//agregado ruddy para el title 
	            //$('#'+nuevoIdInputSelect).prop('title', ui.item.value);
	            //en agregado ruddy title

				
			},

			autocompletechange: "_removeIfInvalid"
		});
	},

	_createShowAllButton: function() {
		var input = this.input,
			wasOpen = false;

		$( "<a>" )
			.attr( "tabIndex", -1 )
			.attr( "title", "" )
			.tooltip()
			.appendTo( this.wrapper )
			.button({
				icons: {
					primary: "ui-icon-triangle-1-s"
				},
				text: false
			})
			.removeClass( "ui-corner-all" )
			.addClass( "custom-combobox-toggle ui-corner-right" )
			.on( "mousedown", function() {
				wasOpen = input.autocomplete( "widget" ).is( ":visible" );
			})
			.on( "click", function() {
				input.trigger( "focus" );

				// Close if already visible
				if ( wasOpen ) {
					return;
				}

				// Pass empty string as value to search for, displaying all results
				input.autocomplete( "search", "" );
			});
	},

	_source: function( request, response ) {
		var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
		response( this.element.children( "option" ).map(function() {
			var text = $( this ).text();
			var fila = $(this).data('fila');
			var precio = $(this).data('precio');
			var unidad = $(this).data('unidad');
			var stock = $(this).data('stockproducto');
			if ( this.value && ( !request.term || matcher.test(text) ) )
				return {
					label: text,
					value: text,
					option: this,
					fila: fila,
					precio: precio,
					unidad: unidad,
					stock: stock
				};
		}) );
	},

	_removeIfInvalid: function( event, ui ) {

		// Selected an item, nothing to do
		if ( ui.item ) {
			return;
		}

		// Search for a match (case-insensitive)
		var value = this.input.val(),
			valueLowerCase = value.toLowerCase(),
			valid = false;
		this.element.children( "option" ).each(function() {
			if ( $( this ).text().toLowerCase() === valueLowerCase ) {
				this.selected = valid = true;
				return false;
			}
		});

		// Found a match, nothing to do
		if ( valid ) {
			return;
		}

		// Remove invalid value
		this.input
			.val( "" )
			.attr( "title", value + " No coincide ningun item." )
			.tooltip( "open" );
		this.element.val( "" );
		this._delay(function() {
			this.input.tooltip( "close" ).attr( "title", "" );
		}, 2500 );
		this.input.autocomplete( "instance" ).term = "";
	},

	_destroy: function() {
		this.wrapper.remove();
		this.element.show();
	},

	autocomplete : function(value) {
		this.element.val(value);

        var selected = this.element.children(":selected"),
                value = selected.val() ? selected.text() : "";
        this.input.val(value);
    }
    
});