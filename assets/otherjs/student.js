var obj = {
	init: function () {
		this.addListener();
	},
	addListener: function () {},
};

$("document").ready(function () {
	obj.init();
});

function generateInputBorrow() {
	$.ajax({
		type: "post",
		url: "getToolData",
		dataType: "JSON",
		traditional: true,
		success: function (resp) {
			var increment;
			if ($("#itemnewborrowcount").val() == "") {
				increment = 0;
				$("#itemnewborrowcount").val(0);
			} else {
				increment = $("#itemnewborrowcount").val();
				increment++;
				$("#itemnewborrowcount").val(increment);
			}
			var parentElement = document.getElementById("parent-item-borrow");

			var divRowItem = document.createElement("div");
			divRowItem.classList.add("row", "mt-3");
			divRowItem.setAttribute("id", "itemborrow" + increment);

			var divColItemNumber = document.createElement("div");
			divColItemNumber.classList.add("col-lg-1");
			var inputItemNumber = document.createElement("input");
			inputItemNumber.classList.add("form-control", "text-center");
			inputItemNumber.setAttribute("id", "itemborrownumber" + increment);
			inputItemNumber.setAttribute("value", increment);
			inputItemNumber.setAttribute("type", "text");
			inputItemNumber.setAttribute("disabled", true);
			divColItemNumber.append(inputItemNumber);

			var divColItemChoose = document.createElement("div");
			divColItemChoose.classList.add("col-lg-7");
			var selectItemChoose = document.createElement("select");
			selectItemChoose.classList.add("form-select");
			selectItemChoose.setAttribute("id", "itemborrowname" + increment);
			selectItemChoose.setAttribute("name", "itemborrowname" + increment);
			for (let i = 0; i < resp.length; i++) {
				var optionItem = document.createElement("option");
				optionItem.setAttribute("value", resp[i]["id"]);
				optionItem.innerHTML =
					resp[i]["tool_code"] + " - " + resp[i]["tool_name"];
				selectItemChoose.append(optionItem);
			}
			divColItemChoose.append(selectItemChoose);

			var divColItemCount = document.createElement("div");
			divColItemCount.classList.add("col-lg-2");
			var inputItemCount = document.createElement("input");
			inputItemCount.classList.add("form-control");
			inputItemCount.setAttribute("id", "itemborrowcount" + increment);
			inputItemCount.setAttribute("name", "itemborrowcount" + increment);
			inputItemCount.setAttribute("type", "number");
			divColItemCount.append(inputItemCount);

			var divColDelete = document.createElement("div");
			divColDelete.classList.add("col-lg-2");
			var divColDgrid = document.createElement("div");
			divColDgrid.classList.add("d-grid");
			var buttonDelete = document.createElement("button");
			buttonDelete.classList.add("btn", "btn-danger");
			buttonDelete.setAttribute(
				"onclick",
				"deleteElementBorrow('itemborrow" + increment + "')"
			);
			buttonDelete.innerHTML = "Hapus";
			divColDgrid.append(buttonDelete);
			divColDelete.append(divColDgrid);

			divRowItem.append(divColItemNumber);
			divRowItem.append(divColItemChoose);
			divRowItem.append(divColItemCount);
			divRowItem.append(divColDelete);

			parentElement.append(divRowItem);
			rebuildNumberBorrow();
		},
	});
}

function deleteElementBorrow(id) {
	$("#" + id).remove();
	rebuildNumberBorrow();
}

function rebuildNumberBorrow() {
	var lastIncrement = $("#itemnewborrowcount").val();
	console.log("lastincrement " + lastIncrement);
	var increment = 0;

	for (let i = 0; i <= lastIncrement; i++) {
		console.log("Increment " + i + " -- " + $("#itemborrow" + i).length);
		if ($("#itemborrow" + i).length > 0) {
			increment++;
			$("#itemborrownumber" + i).val(increment);
		}
	}
}
