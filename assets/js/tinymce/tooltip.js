(function() {

    function decodeHtml(html) {
        var txt = document.createElement("textarea");
        txt.innerHTML = html;
        return txt.value;
    }

    tinymce.PluginManager.add('tooltip', function( editor, url ) {

        var __ = editor.editorManager.i18n.translate,
            wp = window.wp,
            $ = jQuery,
            hasWpautop = ( wp && wp.editor && wp.editor.autop && editor.getParam( 'wpautop', true ) );

        editor.addButton('tooltip_button', {
            icon: 'tooltip',
            tooltip: 'Tooltip',
            onclick: function() {
                // Open window
                var selection = editor.selection.getContent(),
                    $node = $(editor.selection.getNode()),
                    text;

                if(selection == '') {
                    text = $node.text();
                } else {
                    text = decodeHtml(selection);
                }

                var value = $node.data('tooltip');

                editor.windowManager.open({
                    title: 'Infoga tipsruta',
                    body: [
                        {
                            type: 'label',
                            multiline: 'true',
                            text: '',
                            onPostRender : function() {
                                this.getEl().innerHTML =
                                    "Med detta verktyg kan du infoga en tips-ruta<br/>"+
                                    "som visas när en besökare håller muspekaren<br/>" +
                                    "över ett textstycke.";
                            }
                        },
                        {
                            type: 'label',
                            multiline: 'true',
                            text: '',
                            onPostRender : function() {
                                this.getEl().innerHTML =
                                    "Ange textstycke";
                            },
                            style: 'color: #666; font-style: italic; display: block; margin-bottom: 20px'
                        },
                        {
                            type: 'textbox',
                            name: 'text',
                            value: text

                        },
                        {
                            type: 'label',
                            multiline: 'true',
                            text: '',
                            onPostRender : function() {
                                this.getEl().innerHTML =
                                    "Ange text som visas i tips-rutan";
                            },
                            style: 'color: #666; font-style: italic; display: block; margin-bottom: 20px'
                        },
                        {
                            type: 'textbox',
                            name: 'tip',
                            value: value,
                            multiline: true,
                            minHeight: 200
                        }
                    ],
                    onsubmit: function(e) {
                        // Insert content when the window form is submitted
                        editor.insertContent('[tooltip value="' + e.data.tip + '"]' + e.data.text + '[/tooltip]');
                    }
                });
            }
        });

        // Visual
        editor.on( 'BeforeSetContent', function( event ) {

            if ( event.content ) {
                if (event.content.indexOf( '[tooltip' ) !== -1 ) {

                    event.content = wp.shortcode.replace('tooltip', event.content, function(match) {
                            return '<span data-tooltip="' + match.attrs.named.value +'">' + match.content + '</span>';
                    });
                }

                if (event.load && event.format !== 'raw' && hasWpautop ) {
                    event.content = wp.editor.autop( event.content );
                }

                // Remove spaces from empty paragraphs.
                event.content = event.content.replace( /<p>(?:&nbsp;|\u00a0|\uFEFF|\s)+<\/p>/gi, '<p><br /></p>' );
            }
        });

        // Text
        editor.on( 'PostProcess', function( e ) {
            if ( e.get ) {
                e.content = e.content.replace(/<span data-tooltip="(.*?)">(.*?)<\/span>/g, function(full, value, content) {

                    if ( full.indexOf( 'data-tooltip' ) !== -1 ) {

                        var shortcode = wp.shortcode.string({
                            tag: 'tooltip',
                            attrs: {
                                named: {
                                    value: value
                                },
                                numeric: [
                                    value
                                ]
                            },
                            type: 'closed',
                            content: content
                        });
                    }

                    return shortcode;
                });
            }
        });

        // Displayed at the bottom of the editor.
        editor.on('ResolveName', function( event ) {
            if(editor.dom.getAttrib( event.target, 'data-tooltip')) {
                event.name = 'tooltip';
            }
        });


    });

} )();