/* 
 * File controls.js
 * 
 * Access Theme Customizer Controls for a better user experience.
 */
(function ( api ) {
    api.bind( 'ready', function() {
        function sendPreviewedDevice() {
            api.previewer.send( 'previewed-device', api.previewedDevice.get() );
        }

        // Send the initial previewed device when preview is ready.
        api.previewer.bind( 'ready', sendPreviewedDevice );

        // Send the previewed device whenever it changes.
        api.previewedDevice.bind( sendPreviewedDevice );
    });
}) ( wp.customize );