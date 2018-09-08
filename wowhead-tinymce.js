(function() {
    tinymce.PluginManager.add( 'wowhead_tooltip_class', function( editor, url ) {
         // Add Button to Visual Editor Toolbar
        editor.addButton('wowhead_tooltip_button', {
            title: 'Insert Button Link',
            cmd: 'wowhead_tooltip_cmd',
            image: url + '/icon.png',
        }); 
    });
})();