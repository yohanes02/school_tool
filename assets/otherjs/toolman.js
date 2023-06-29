var obj = {
	init: function () {
		this.addListener();
	},
	addListener: function () {
		var _this = this;
		$("#typesubmission").change(function () {
			var value = $("#typesubmission").val();
			if (value == "1") {
				$("#parentmonthsubmission").show();
			} else {
				$("#parentmonthsubmission").hide();
			}
		});
	},
};

$("document").ready(function () {
	obj.init();
});

function checkItemIsExist(id, idx) {
	console.log(document.getElementById(id).checked);
	var itemExisting = document.getElementById(id).checked;
	if (itemExisting) {
		$("#itemexisting" + idx).show();
		$("#itemgroup" + idx).hide();
		$("#itemname" + idx).val(
			$("#itemexisting" + idx)
				.find(":selected")
				.text()
		);
		$("#itemname" + idx).prop("readonly", true);
	} else {
		$("#itemexisting" + idx).hide();
		$("#itemgroup" + idx).show();
		$("#itemname" + idx).val("");
		$("#itemname" + idx).prop("readonly", false);
	}
}

function getSelectedItemExisting(idx) {
	$("#itemname" + idx).val(
		$("#itemexisting" + idx)
			.find(":selected")
			.text()
	);
}

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

function generateInputItem() {
	$.ajax({
		type: "post",
		url: "getToolDataAndToolGroup",
		dataType: "JSON",
		traditional: true,
		success: function (resp) {
			var increment;
			if ($("#itemnewcount").val() == "") {
				increment = 0;
				$("#itemnewcount").val(0);
			} else {
				increment = $("#itemnewcount").val();
				increment++;
				$("#itemnewcount").val(increment);
			}
			var elementIncrement = document.getElementById("itemnewcount").value;
			var parentElement = document.getElementById("parent-list-item");
		
			var divRowItem = document.createElement("div");
			divRowItem.classList.add("row");
			divRowItem.setAttribute("id", "itemnew" + increment);
		
			var divColItemNumber = document.createElement("div");
			divColItemNumber.classList.add("col-lg-1");
			var inputItemNumber = document.createElement("input");
			inputItemNumber.classList.add("form-control", "text-center");
			inputItemNumber.setAttribute("id", "itemnumber" + increment);
			inputItemNumber.setAttribute("type", "text");
			inputItemNumber.setAttribute("value", "-");
			inputItemNumber.setAttribute("disabled", true);
			inputItemNumber.innerHTML = "-";
			divColItemNumber.append(inputItemNumber);
		
			var divColSwitch = document.createElement("div");
			divColSwitch.classList.add("col-lg-11");
			var divFormSwitch = document.createElement("div");
			divFormSwitch.classList.add("form-check", "form-switch");
			var inputSwitch = document.createElement("input");
			inputSwitch.classList.add("form-check-input");
			inputSwitch.setAttribute("type", "checkbox");
			inputSwitch.setAttribute("id", "itemexist" + increment);
			inputSwitch.setAttribute("name", "itemexist" + increment);
			inputSwitch.setAttribute(
				"onchange",
				"checkItemIsExist('itemexist" + increment + "', " + increment + ")"
			);
			var inputSwitchLabel = document.createElement("label");
			inputSwitchLabel.classList.add("formc-check-label");
			inputSwitchLabel.setAttribute("for", "itemexist" + increment);
			inputSwitchLabel.innerHTML = "Barang yang sudah ada ?";
			divFormSwitch.append(inputSwitch);
			divFormSwitch.append(inputSwitchLabel);
			divColSwitch.append(divFormSwitch);
		
			var divColToolGroup = document.createElement("div");
			divColToolGroup.classList.add("offset-1", "col-lg-10");
			divColToolGroup.setAttribute("id", "itemgroup" + increment);
			var divFloatToolGroup = document.createElement("div");
			divFloatToolGroup.classList.add("mb-2", "form-floating");
			var selectToolGroup = document.createElement("select");
			selectToolGroup.classList.add("form-select");
			selectToolGroup.setAttribute("name", "itemgroup" + increment);
			for (let i = 0; i < resp['tool_group'].length; i++) {
				var optionToolGroup = document.createElement("option");
				optionToolGroup.setAttribute("value", resp['tool_group'][i]["id"]);
				optionToolGroup.innerHTML = resp['tool_group'][i]["tool_group"];
				selectToolGroup.append(optionToolGroup);
			}
			var labelToolGroup = document.createElement("label");
			labelToolGroup.innerHTML = "Tool Group";
			divFloatToolGroup.append(selectToolGroup);
			divFloatToolGroup.append(labelToolGroup);
			divColToolGroup.append(divFloatToolGroup);

			var divColToolItem = document.createElement("div");
			divColToolItem.classList.add("offset-1", "col-lg-10");
			divColToolItem.setAttribute("id", "itemexisting" + increment);
			divColToolItem.setAttribute("style", "display: none;");
			var divFloatToolItem = document.createElement("div");
			divFloatToolItem.classList.add("mb-2", "form-floating");
			var selectToolItem = document.createElement("select");
			selectToolItem.classList.add("form-select");
			selectToolItem.setAttribute("name", "itemexisting" + increment);
			selectToolItem.setAttribute("onchange", "getSelectedItemExisting("+increment+")")
			for (let i = 0; i < resp['tool_data'].length; i++) {
				var optionToolItem = document.createElement("option");
				optionToolItem.setAttribute("value", resp['tool_data'][i]["id"]);
				optionToolItem.innerHTML = resp['tool_data'][i]["tool_name"];
				selectToolItem.append(optionToolItem);
			}
			var labelToolItem = document.createElement("label");
			labelToolItem.innerHTML = "Tool Item";
			divFloatToolItem.append(selectToolItem);
			divFloatToolItem.append(labelToolItem);
			divColToolItem.append(divFloatToolItem);

		
			var divColItemName = document.createElement("div");
			divColItemName.classList.add("offset-1", "col-lg-5");
			var inputItemName = document.createElement("input");
			inputItemName.classList.add("form-control");
			inputItemName.setAttribute("name", "itemname" + increment);
			inputItemName.setAttribute("id", "itemname" + increment);
			inputItemName.setAttribute("type", "text");
			inputItemName.setAttribute("placeholder", "Nama Barang");
			divColItemName.append(inputItemName);
		
			var divColItemQty = document.createElement("div");
			divColItemQty.classList.add("col-lg-1");
			var inputItemQty = document.createElement("input");
			inputItemQty.classList.add("form-control");
			inputItemQty.setAttribute("name", "itemqty" + increment);
			inputItemQty.setAttribute("id", "itemqty" + increment);
			inputItemQty.setAttribute("type", "number");
			inputItemQty.setAttribute("placeholder", "Qty");
			inputItemQty.setAttribute("onchange", "generateTotal(" + increment + ")");
			divColItemQty.append(inputItemQty);
		
			var divColItemSatuan = document.createElement("div");
			divColItemSatuan.classList.add("col-lg-2");
			var inputItemSatuan = document.createElement("input");
			inputItemSatuan.classList.add("form-control");
			inputItemSatuan.setAttribute("name", "itemsatuan" + increment);
			inputItemSatuan.setAttribute("id", "itemsatuan" + increment);
			inputItemSatuan.setAttribute("type", "number");
			inputItemSatuan.setAttribute("placeholder", "Harga Satuan");
			inputItemSatuan.setAttribute("onchange", "generateTotal(" + increment + ")");
			divColItemSatuan.append(inputItemSatuan);
		
			var divColItemTotal = document.createElement("div");
			divColItemTotal.classList.add("col-lg-2");
			var inputItemTotal = document.createElement("input");
			inputItemTotal.classList.add("form-control");
			inputItemTotal.classList.add("bg-body-secondary");
			inputItemTotal.setAttribute("name", "itemtotal" + increment);
			inputItemTotal.setAttribute("id", "itemtotal" + increment);
			inputItemTotal.setAttribute("type", "number");
			inputItemTotal.setAttribute("placeholder", "Total Harga");
			inputItemTotal.setAttribute("readonly", true);
			divColItemTotal.append(inputItemTotal);
		
			var divColDelete = document.createElement("div");
			divColDelete.classList.add("col-lg-1");
			var buttonDelete = document.createElement("button");
			buttonDelete.classList.add("btn", "btn-danger");
			buttonDelete.setAttribute(
				"onclick",
				"deleteElement('itemnew" + increment + "')"
			);
			buttonDelete.innerHTML = "Hapus";
			divColDelete.append(buttonDelete);
		
			var labelImage = document.createElement("label");
			labelImage.classList.add("offset-1", "mt-3", "mb-1");
			labelImage.innerHTML = "Foto Barang";
		
			var divColItemImage = document.createElement("div");
			divColItemImage.classList.add("col-lg-10", "offset-1");
			var inputItemImage = document.createElement("input");
			inputItemImage.classList.add("form-control");
			inputItemImage.setAttribute("type", "file");
			inputItemImage.setAttribute("accept", "image/*");
			inputItemImage.setAttribute("type", "file");
			inputItemImage.setAttribute("name", "itemimage" + increment);
			divColItemImage.append(inputItemImage);
		
			var divColItemSpecification = document.createElement("div");
			divColItemSpecification.classList.add(
				"col-lg-10",
				"offset-1",
				"mt-3",
				"mb-3"
			);
			var textareaItemSpecification = document.createElement("textarea");
			textareaItemSpecification.classList.add("form-control");
			textareaItemSpecification.setAttribute(
				"name",
				"itemspecification" + increment
			);
			textareaItemSpecification.setAttribute(
				"id",
				"itemspecification" + increment
			);
			textareaItemSpecification.setAttribute("placeholder", "Spesifikasi");
			textareaItemSpecification.setAttribute("cols", "30");
			textareaItemSpecification.setAttribute("rows", "3");
			divColItemSpecification.append(textareaItemSpecification);
		
			divRowItem.append(divColItemNumber);
			divRowItem.append(divColSwitch);
			divRowItem.append(divColToolGroup);
			divRowItem.append(divColToolItem);
			divRowItem.append(divColItemName);
			divRowItem.append(divColItemQty);
			divRowItem.append(divColItemSatuan);
			divRowItem.append(divColItemTotal);
			divRowItem.append(divColDelete);
			divRowItem.append(labelImage);
			divRowItem.append(divColItemImage);
			divRowItem.append(divColItemSpecification);
		
			parentElement.append(divRowItem);
			rebuildNumber();
		},
	});
}

function deleteElement(id) {
	// $("#"+key+idx+"total"+type).val(0);
	$("#" + id).remove();
	rebuildNumber("item_");

	generateTotal(id);
}

function generateTotal(idx) {
	var lastIncrement = $("#itemnewcount").val();
	var totalSubmission = 0;

	var qty = $("#itemqty" + idx).val();
	var satuan = $("#itemsatuan" + idx).val();

	if (qty != null && qty != "" && satuan != null && satuan != "") {
		var total = parseInt(qty) * parseInt(satuan);
		$("#itemtotal" + idx).val(total);
	}

	for (let i = 0; i <= lastIncrement; i++) {
		if (
			$("#itemtotal" + i).val() != null &&
			$("#itemtotal" + i).val() != ""
		) {
			totalSubmission += parseInt($("#itemtotal" + i).val());
		}
	}

	var totalPriceSubmission = document.getElementById("totalpricesubmission");
	var rupiah = formatRupiah(totalSubmission.toString());
	totalPriceSubmission.innerHTML = "Rp. " + rupiah;
}

function rebuildNumber() {
	var lastIncrement = $("#itemnewcount").val();
	console.log("lastincrement " + lastIncrement);
	var increment = 0;

	for (let i = 0; i <= lastIncrement; i++) {
		console.log("Increment " + i + " -- " + $("#itemnew" + i).length);
		if ($("#itemnew" + i).length > 0) {
			increment++;
			$("#itemnumber" + i).val(increment);
		}
	}
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

function formatRupiah(allSum) {
	var formatRp;
	var rawString = allSum;
	if (rawString.length > 3) {
		rawString = rawString.split("").reverse().join("");

		var idx = 0;
		var arrString = [];

		while (idx + 3 <= rawString.length) {
			arrString.push(rawString.slice(idx, idx + 3));
			idx = idx + 3;
		}

		if (idx < rawString.length && idx + 3 > rawString.length) {
			console.log(idx + " --- " + (rawString.length - idx));
			arrString.push(rawString.slice(idx, rawString.length));
		}

		formatRp = arrString.join(".").split("").reverse().join("");
		console.log(arrString);
	} else {
		formatRp = rawString;
	}

	return formatRp;
}

function changeImage(id) {
	$("#itemimagediv" + id).hide();
	$("#itemimagechange" + id).show();
}
