/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.toolbar =
    [
        ['Source', 'Preview', 'Save', '-', 
		 'Font', 'FontSize', 'TextColor', 'BGColor', '-',
		 'Bold', 'Italic', 'Underline', '-', 
		 'NumberedList', 'BulletedList', '-', 
		 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-',  
		 'RemoveFormat', '-',  
		 'Link', 'Unlink', 'Anchor', 'HorizontalRule', '-',
		 'Image', 'Table', 'Smiley',  '/']
    ];
	
	config.allowedContent = true;
	
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};
