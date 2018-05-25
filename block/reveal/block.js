/**
 * BLOCK: Image
 *
 * Gutenberg Block for Aesop Image.
 *
 */
( function() {
	var __ = wp.i18n.__; // The __() for internationalization.
	var el = wp.element.createElement; // The wp.element.createElement() function to create elements.
	var registerBlockType = wp.blocks.registerBlockType; // The registerBlockType() to register blocks.

	/**
	 * Register Basic Block.
	 *
	 * Registers a new block provided a unique name and an object defining its
	 * behavior. Once registered, the block is made available as an option to any
	 * editor interface where blocks are implemented.
	 *
	 * @param  {string}   name     Block name.
	 * @param  {Object}   settings Block settings.
	 * @return {?WPBlock}          The block, if it has been successfully
	 *                             registered; otherwise `undefined`.
	 */
	registerBlockType( 'ase/reveal', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
		title: __( 'Aesop Reveal Block', 'ASE' ), // Block title.
		icon: 'image-flip-horizontal', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
		category: 'widgets', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
		
		attributes: {
			width : {
				type: 'string'
			},
			before : {
				type: 'string'
			},
			after : {
				type: 'string'
			}
		},

		// The "edit" property must be a valid function.
		//edit: function(props ) {
			
		edit	( { attributes, setAttributes, isSelected, className }) {
			

			var onSelectMedia = ( media ) => {
				return setAttributes({                       
					img:media.url
                });
			};
			
			
			const advcontrols = isSelected && el( wp.editor.InspectorControls, {},
				
				el( 'div', { className: 'wp-block-aesop-story-engine-option-label' },__('Width') ),
				el( wp.components.TextControl, {
						label: __( 'Width of the image. You can enter the size in pixels or percentage such as 40% or 500px.' ),
						value: attributes.width,
						onChange: function( content ) {
							setAttributes( { width: content } );
						},
					} 
				)
			);
			
			var controls = el( 'div', { className: 'wp-block-aesop-reveal-row' }
				,
				el( 'div',
					{
						className: "wp-block-aesop-reveal-column"
					},
					
					isSelected &&  el(
						wp.editor.MediaUpload,
						{
								title: __( 'Select "Before" Image' ),
								onSelect: function( media ) {
											return setAttributes({                       
												before:media.url
											});
								},
								type: 'image',
								value: attributes.before,
								render: function( obj ) {
											return el( wp.components.Button, {
										  className:  'button button-large',
										  onClick: obj.open
										},
										 __( 'Set "Before" Image' ) 
									); }
						}
					),
					attributes.before && el(
						'img', // Tag type.
						{ 
						src: attributes.before}
					)
				),
				el( 'div',
					{className: "wp-block-aesop-reveal-column"},
					
					isSelected &&  el(
						wp.editor.MediaUpload,
						{
								title: __( 'Select "After" Image' ),
								type: 'image',
								onSelect: function( media ) {
											return setAttributes({                       
												after:media.url
											});
								},
								value: attributes.after,
								render: function( obj ) {
											return el( wp.components.Button, {
										  className:  'button button-large',
										  onClick: obj.open
										},
										 __( 'Set "After" Image' ) 
									); }
						}
					),
					attributes.after && el(
						'img', // Tag type.
						{ 
						src: attributes.after}
					)
				)
			);
			var label = el(
						'div', 
						{ className: "wp-block-aesop-story-engine-label" }, 
						el(
							'span', 
							{ className: "dashicons dashicons-image-flip-horizontal" },
							''
						),
						el(
							'span', 
							{ className: "wp-block-aesop-story-engine-title" },
							'Aesop Reveal'
						)
			);

				
			var uis = [];

			uis.push(label);	
            uis.push(controls);
			
			return [ advcontrols,
				el(
					'div', // Tag type.
					{ className: "wp-block-aesop-story-engine" }, 
					uis// Content inside the tag.
				)
			];
	
							

		},

		// The "save" property must be specified and must be a valid function.
		save: function( props ) {
			return null;
		},
	} );
})();
