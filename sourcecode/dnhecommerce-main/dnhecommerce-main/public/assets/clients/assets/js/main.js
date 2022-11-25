function ProductView(iamgeList) {

    let linkGif = "{{asset('assets/clients/assets/images/blank.gif')}}"
    for (let i = 0; i < iamgeList.length; i++) {
        let linkImg = window.location.protocol + "//" + window.location.hostname + "/images/product/" + iamgeList[i];

        $('#imgProducShowClient-' + i).append(
            '<img class="img-responsive" alt="" src="' + linkGif + '"' +
            ' data-echo="' + linkImg + '"' +
            '/>'
        );

        $('#imgProducShowClientThumbs-' + i).append(
            '<img class="img-responsive" alt="" src="' + linkGif + '"' +
            ' data-echo="' + linkImg + '"' +
            '/>'
        );

    }
}

function filterSelection(c) {
    var x, i;
    x = document.getElementsByClassName("filterDiv");


    if (c == "theme--") c = "";
    for (i = 0; i < x.length; i++) {
        RemoveClass(x[i], "show");
        if (x[i].className.indexOf(c) > -1) AddClass(x[i], "show");
    }
    setSelect();
}

function AddClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
        if (arr1.indexOf(arr2[i]) == -1) { element.className += " " + arr2[i]; }
    }
}

function RemoveClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
        while (arr1.indexOf(arr2[i]) > -1) {
            arr1.splice(arr1.indexOf(arr2[i]), 1);
        }
    }
    element.className = arr1.join(" ");
}

function setSelect() {
    let divContainer = document.getElementById("product-tabs-slider");
    let themeSelectList = divContainer.getElementsByClassName("themeSelect");

    for (let i = 0; i < themeSelectList.length; i++) {
        themeSelectList[i].addEventListener("click", function() {
            let current = document.getElementsByClassName("selected");
            current[0].className = current[0].className.replace(" selected", "");
            this.className += " selected";
        });
    }
}

function btnAddToCart() {
    let btn = document.getElementById("btn_add_to_cart");
    let id_size = document.getElementById("id_size").value;
    let id_color = document.getElementById("id_color").value;
    if (id_size == 0 || id_color == 0) {
        document.getElementById("cart-warning").style.display = "block";
    } else {
        btn.type = "submit";
    }
}

function QuantityProduct(price, countID) {
    for (let index = 0; index <= countID; index++) {
        var quantity_product = "quantity_product[" + index + "]";
        var total_price = "total_price[" + index + "]"
        var quantity = document.getElementById(quantity_product).value;
        document.getElementById(total_price).innerHTML = new Intl.NumberFormat('de-DE').format(quantity * price);
    }
}

function Voucher(id, name, price) {
    document.getElementById("id_voucher").value = id;
    document.getElementById("name_voucher").innerHTML = name;
    document.getElementById("price_voucher").innerHTML = new Intl.NumberFormat('de-DE').format(price) + " VNĐ";
    $('#list_voucher').modal('hide');
}

function Delivery(id, name, price) {
    document.getElementById("id_delivery").value = id;
    document.getElementById("name_delivery").innerHTML = name;
    document.getElementById("price_delivery").innerHTML = new Intl.NumberFormat('de-DE').format(price) + " VNĐ";
    $('#list_delivery').modal('hide');
}

function inputCheckout() {
    var delivery = document.getElementById("id_delivery").value;
    if (!delivery) {
        alert('Vui lòng chọn đơn vị vận chuyển!');
        return false;
    }
    return true;
}