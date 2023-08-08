var obj = {
	init: function () {
		this.addListener();
	},
	addListener: function () {
		var _this = this;
		$("#universalSelect").change(function () {
			var value = $("#universalSelect").val();
			if (value == "1") {
				$("#major-row").show();
			} else {
				$("#major-row").hide();
			}
		});
	},
};

$("document").ready(function () {
	obj.init();
});
