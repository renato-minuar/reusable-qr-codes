/**
 * QR Code List Download Handler
 *
 * @package Reusable_QR_Codes
 */

(function($) {
	'use strict';

	/**
	 * Handle download button clicks in the list view.
	 */
	$(document).ready(function() {
		// PNG download from list.
		$(document).on('click', '.rqrc-download-list-png', function(e) {
			e.preventDefault();
			var $button = $(this);
			var permalink = $button.data('permalink');
			var title = $button.data('title');

			downloadQRCode(permalink, title, 'png');
		});

		// SVG download from list.
		$(document).on('click', '.rqrc-download-list-svg', function(e) {
			e.preventDefault();
			var $button = $(this);
			var permalink = $button.data('permalink');
			var title = $button.data('title');

			downloadQRCode(permalink, title, 'svg');
		});
	});

	/**
	 * Generate and download QR code.
	 *
	 * @param {string} permalink The QR code URL.
	 * @param {string} title     The QR code title.
	 * @param {string} format    Download format (png or svg).
	 */
	function downloadQRCode(permalink, title, format) {
		// Create QR code options.
		var options = {
			width: 1024,
			height: 1024,
			type: format === 'svg' ? 'svg' : 'canvas',
			margin: 10,
			data: permalink,
			dotsOptions: {
				color: rqrcListData.qrColor,
				type: rqrcListData.qrDotStyle
			},
			backgroundOptions: {
				color: rqrcListData.qrBgColor
			}
		};

		// Generate QR code.
		var qrCode = new QRCodeStyling(options);

		// Download with sanitized filename.
		qrCode.download({
			name: sanitizeFilename(title),
			extension: format
		});
	}

	/**
	 * Sanitize filename for download.
	 *
	 * @param {string} filename Original filename.
	 * @return {string} Sanitized filename.
	 */
	function sanitizeFilename(filename) {
		if (!filename || filename === '') {
			return 'qr-code';
		}

		// Remove special characters and replace spaces with hyphens.
		return filename
			.toLowerCase()
			.replace(/[^a-z0-9\s-]/g, '')
			.replace(/\s+/g, '-')
			.replace(/-+/g, '-')
			.substring(0, 50);
	}

})(jQuery);
