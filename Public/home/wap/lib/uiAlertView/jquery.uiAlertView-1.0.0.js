(function($) {
	$.extend({
		alertView: function(options) {
			var defaults = {
				showMask: true,
				title: "",
				msg: "",
			};
			var settings = {};
			if ($.type(options) == "string") {
				settings = defaults;
				settings.msg = options;
			} else if ($.type(options) == "object") {
				settings = $.extend(true, defaults, options);
			}
			if (!settings.buttons || settings.buttons.length == 0) {
				settings.buttons = [{
					title: "确定"
				}];
			}
			$.closeView();
			if (settings.showMask) {
				$("body").append('<div id="popup-dialog-mask" class="lodding-mask"></div>');
			}
			var popupDialog = $('<div id="popup-dialog" class="popup-dialog"></div>');
			if (settings.title) {
				popupDialog.append('<h3 id="popup-dialog-title">' + settings.title + '</h3>');
			}
			popupDialog.append('<p id="popup-dialog-msg" class="message ' + ((settings.title ? "": "margin-top-15")) + '">' + settings.msg + '</p>');
			if (settings.input && $.type(settings.input) == 'array') {
				var html;
				// console.log(settings.input);

				$.each(settings.input,
				function(key, value) {

					html = "<input";
					$.each(settings.input[key],function(k,v){
						console.log(k);
						
						html += ' ' + k + '="' + v + '"';
						
						
					});
					html += "/>";
					$(html).appendTo(popupDialog);

				});
				
				
			}
			var btnSize = settings.buttons.length;
			if (btnSize == 2) {
				var buttonGroup = $('<div class="ui-grid-a group"></div>');
				$.each(settings.buttons,
				function(i, btnJson) {
					var color = btnJson.color ? 'style="color:' + btnJson.color + '"': "";
					var button = $('<div class="ui-block-' + (i == 0 ? "a": "b") + '" ' + color + '>' + btnJson.title + '</div>');
					addBtnEvent(button, btnJson);
					buttonGroup.append(button);
				});
				popupDialog.append(buttonGroup);
			} else {
				$.each(settings.buttons,
				function(i, btnJson) {
					var color = btnJson.color ? 'style="color:' + btnJson.color + '"': "";
					var button = $('<div class="ui-grid-a' + (i == 0 ? " group": "") + '" ' + color + '>' + btnJson.title + '</div>');
					addBtnEvent(button, btnJson);
					popupDialog.append(button);
				})
			}
			$("body").append(popupDialog);
		},
		closeView: function() {
			$(".popup-dialog, .lodding-mask").fadeOut(50,
			function() {
				$(this).remove();
			});
		}
	});
	function addBtnEvent(btn, btnJson) {
		btn.on("click",
		function() {
			if (btnJson.click && typeof(btnJson.click) == "function") {
				var content = $(this).closest("div.popup-dialog");
				var val = $.trim(content.find("input").val());
				btnJson.click(val, content);
			}
			if (!btnJson.hasOwnProperty("autoClose") || btnJson.autoClose != false) {
				$.closeView();
			}
		});
	}
})(jQuery);
jQuery(function() {
	document.body.addEventListener('touchstart',
	function() {});
});