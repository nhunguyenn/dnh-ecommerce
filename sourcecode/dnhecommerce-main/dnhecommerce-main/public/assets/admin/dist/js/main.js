$(document).ready(function() {
    $(function() {
        var dataTable = {
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false
        }

        $('#table-supplier-list').DataTable(dataTable)
        $('#table-trash-supplier-list').DataTable(dataTable)

        $('#table-theme-list').DataTable(dataTable)
        $('#table-trash-theme-list').DataTable(dataTable)

        $('#table-group-list').DataTable(dataTable)
        $('#table-trash-group-list').DataTable(dataTable)

        $('#table-tax-list').DataTable(dataTable)
        $('#table-trash-tax-list').DataTable(dataTable)

        $('#table-related-list').DataTable(dataTable)
        $('#table-trash-related-list').DataTable(dataTable)

        $('#table-product-list').DataTable(dataTable)
        $('#table-product-list-sold-out').DataTable(dataTable)
        $('#table-trash-product-list').DataTable(dataTable)

        $('#table-discount-list').DataTable(dataTable)
        $('#table-active-discount-list').DataTable(dataTable)
        $('#table-sold-out-discount-list').DataTable(dataTable)

        $('#table-banner-list').DataTable(dataTable)

        $('#table-size-list').DataTable(dataTable)
        $('#table-trash-size-list').DataTable(dataTable)

        $('#table-color-list').DataTable(dataTable)
        $('#table-trash-color-list').DataTable(dataTable)

        $('#table-delivery-list').DataTable(dataTable)
        $('#table-trash-delivery-list').DataTable(dataTable)

        $('#table-voucher-list').DataTable(dataTable)
        $('#table-trash-voucher-list').DataTable(dataTable)
    })
});

function validate(formName) {
    const inputs = document.getElementById(formName).elements;
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].nodeName === "INPUT" && inputs[i].type === "text") {
            if (inputs[i].value == "" && inputs[i].name != "note") {
                inputs[i].focus();
                alert("Vui lòng nhập đầy đủ thông tin!");
                return (false);
            }
        }
    }
    return (true);
}

var loadImgThemeView = function(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('img_add');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

var loadImgThemeNew = function(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('img_show');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

$(function() {
    $('#images').change(function() {
        document.querySelector("#imgProducNew").remove();
        $('#divImgProducNew').append('<div class="form-group" id="imgProducNew"></div>');

        if (this.files && this.files[0]) {
            for (var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                reader.onload = loadImgProductNew;
                reader.readAsDataURL(this.files[i]);
            }
        }
    });

    $('#images_view').change(function() {
        document.querySelector("#imgProducShow").remove();
        $('#divImgProducShow').append('<div class="form-group" id="imgProducShow"></div>');

        if (this.files && this.files[0]) {
            for (var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                reader.onload = loadImgProductView;
                reader.readAsDataURL(this.files[i]);
            }
        }
    });
});

function loadImgProductNew(event) {
    $('#imgProducNew').append('<img class="img-responsive" src="' + event.target.result + '" style="width: 10%; display: inline;"></img>');
};

function loadImgProductView(event) {
    $('#imgProducShow').append('<img class="img-responsive" src="' + event.target.result + '" style="width: 20%; display: inline;"></img>');
};

function SupplierView(id, name, phone, email, address, bank_name, bank_number, note, created_at, updated_at) {
    document.getElementById("id_view_1").value = id;
    document.getElementById("id_view_2").value = id;
    document.getElementById("name_view").value = name;
    document.getElementById("phone_view").value = phone;
    document.getElementById("email_view").value = email;
    document.getElementById("address_view").value = address;
    document.getElementById("bank_name_view").value = bank_name;
    document.getElementById("bank_number_view").value = bank_number;
    document.getElementById("note_view").value = note;
    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;
}

function ThemeView(id, name, image, note, created_at, updated_at) {
    document.getElementById("id_view_1").value = id;
    document.getElementById("id_view_2").value = id;
    document.getElementById("name_view").value = name;
    document.getElementById("img_show").src = window.location.protocol + "//" + window.location.hostname + "/images/category/" + image;
    document.getElementById("note_view").value = note;
    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;
}

function CategoryView(id, id_theme_list, name, note, created_at, updated_at) {
    document.getElementById("id_view_1").value = id;
    document.getElementById("id_view_2").value = id;
    document.getElementById('id_theme_list_view').value = id_theme_list;
    document.getElementById("name_view").value = name;
    document.getElementById("note_view").value = note;
    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;
}

function TaxView(id, name, value, type, note, created_at, updated_at) {
    document.getElementById("id_view_1").value = id;
    document.getElementById("id_view_2").value = id;
    document.getElementById("name_view").value = name;
    document.getElementById("value_view").value = value;
    document.getElementById("type_view").value = type;
    document.getElementById("note_view").value = note;
    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;
}

function RelatedView(id, name, related_category, note, created_at, updated_at) {
    document.getElementById("id_view_1").value = id;
    document.getElementById("id_view_2").value = id;
    document.getElementById("name_view").value = name;
    document.getElementById("note_view").value = note;
    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;


    var element = document.getElementById('related_category_view');
    var values = related_category.split(",");

    for (var i = 0; i < element.options.length; i++) {
        element.options[i].selected = values.indexOf(element.options[i].value) >= 0;
    }
}

function TaxView(id, name, value, type, note, created_at, updated_at) {
    document.getElementById("id_view_1").value = id;
    document.getElementById("id_view_2").value = id;
    document.getElementById("name_view").value = name;
    document.getElementById("value_view").value = value;
    document.getElementById("type_view").value = type;
    document.getElementById("note_view").value = note;
    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;
}

function ProductView(id, id_supplier, id_tax, id_category, id_related, name, image, quantity, cost, price, viewed, active_sale, active_purchase, note, created_at, updated_at) {

    console.log(id, id_supplier, id_tax, id_category, id_related, name, image, quantity, cost, price, viewed, active_sale, active_purchase, note, created_at, updated_at);
    document.getElementById("id_view_1").value = id;
    document.getElementById("id_view_2").value = id;

    if (active_sale == 1) {
        document.getElementById("active_sale_view").checked = true;
    } else {
        document.getElementById("active_sale_view").checked = false;
    }

    if (active_purchase == 1) {
        document.getElementById("active_purchase_view").checked = true;
    } else {
        document.getElementById("active_purchase_view").checked = false;
    }

    document.getElementById("name_view").value = name;
    var images = image.split(",");
    document.querySelector("#imgProducShow").remove();
    $('#divImgProducShow').append('<div class="form-group" id="imgProducShow"></div>');

    for (let index = 0; index < images.length; index++) {
        $('#imgProducShow').append('<img class="img-responsive" src="' + window.location.protocol + "//" + window.location.hostname + "/images/product/" + images[index] + '" style="width: 20%; display: inline;"></img>');
    }
    document.getElementById("id_category_view").value = id_category;
    document.getElementById("id_related_view").value = id_related;
    document.getElementById("id_supplier_view").value = id_supplier;
    document.getElementById("quantity_view").value = quantity;
    document.getElementById("cost_view").value = cost;
    document.getElementById("price_view").value = price;
    document.getElementById("id_tax_view").value = id_tax;
    document.getElementById("note_view").value = note;
    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;
}

function ProductDiscountView(id, id_product, percent_discount, quantity, time_start, time_end, active, note, created_at, updated_at) {
    document.getElementById("id_view").value = id;
    document.getElementById("id_product_view").value = id_product;
    document.getElementById("percent_discount_view").value = percent_discount;
    document.getElementById("quantity_view").value = quantity;
    document.getElementById("time_start_view").value = time_start;
    document.getElementById("time_end_view").value = time_end;
    if (active == 1) {
        document.getElementById("active_view").checked = true;
    } else {
        document.getElementById("active_view").checked = false;
    }
    document.getElementById("note_view").value = note;
    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;
}

function BannerView(id, id_product, note, created_at, updated_at) {
    document.getElementById("id_view").value = id;
    document.getElementById("id_product_view").value = id_product;
    document.getElementById("note_view").value = note;
    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;
}

function SizeView(id, id_product, name, quantity, note, active, created_at, updated_at) {
    document.getElementById("id_view").value = id;
    document.getElementById("id_product_view").value = id_product;
    document.getElementById("name_view").value = name;
    document.getElementById("quantity_view").value = quantity;
    document.getElementById("note_view").value = note;

    if (active == 1) {
        document.getElementById("active_view").checked = true;
    } else {
        document.getElementById("active_view").checked = false;
    }
    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;
}

function ColorView(id, id_product, name, color_code, quantity, price, note, active, created_at, updated_at) {
    document.getElementById("id_view").value = id;
    document.getElementById("id_product_view").value = id_product;
    document.getElementById("name_view").value = name;
    document.getElementById("color_code_view").value = color_code;
    document.getElementById("color_view").style.backgroundColor = color_code;
    document.getElementById("quantity_view").value = quantity;
    document.getElementById("price_view").value = price;
    document.getElementById("note_view").value = note;

    if (active == 1) {
        document.getElementById("active_view").checked = true;
    } else {
        document.getElementById("active_view").checked = false;
    }

    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;
}

function DeliveryView(id, name, phone, price, note, created_at, updated_at) {
    document.getElementById("id_view").value = id;
    document.getElementById("name_view").value = name;
    document.getElementById("phone_view").value = phone;
    document.getElementById("price_view").value = price;
    document.getElementById("note_view").value = note;
    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;
}

function VoucherView(id, name, price, total_product, note, created_at, updated_at) {
    document.getElementById("id_view").value = id;
    document.getElementById("name_view").value = name;
    document.getElementById("price_view").value = price;
    document.getElementById("total_product_view").value = total_product;
    document.getElementById("note_view").value = note;
    document.getElementById("created_at_view").value = created_at;
    document.getElementById("updated_at_view").value = updated_at;
}