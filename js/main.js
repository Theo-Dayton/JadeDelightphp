function validate()
{
    err=false;

    with (document.data)
    {
        if (lname.value=="")
        {
            lname.focus();
            lname.select();
            alert("Please enter a value for your last name");
            err = true;
        }
        if (delivery.checked) {
            if (street.value=="") {
                street.focus();
                alert("Street is required for delivery orders.");
                err = true;
            }
            else {
                if (city.value=="") {
                    city.focus();
                    alert("City is required for delivery orders.");
                    err = true;
                }
            }
        }
    }

    let itemCount = 0;
    for (let i = 0; i < menuItems.length; i++) {
        let itemname = "quan" + i;
        if (document.getElementsByName(itemname)[0].value != 0) {
            itemCount++;
        }
    }
    if (itemCount == 0) {
        alert('Please order at least 1 item.');
        err = true;
    }

    var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

    if(re.test(document.data.phone.value)) {
    }
    else {
        alert("Please input a valid phone number");
        phone.focus();
        phone.select();
        err = true;
    }

    let time = 0;
    let deliverance = "";

    if (pickup.checked) {
        time = 15;
        deliverance = "ready for pickup";
    }
    else {
        time = 30;
        deliverance = "delivered";
    }

    return !err;
};

    
function displayForm() {
    if (delivery.checked) {
    document.getElementById("street").style.display = "block";
    document.getElementById("city").style.display = "block";
    }
    else if (pickup.checked) {
        document.getElementById("street").style.display = "none";
    document.getElementById("city").style.display = "none";
    }
};

function updateItems() {
    let subtotal = 0;
    for (let i = 0; i < menuItems.length; i++) {
        let itemname = "quan" + i;
        document.getElementsByName('cost[]')[i].value = menuItems[i].cost*document.getElementsByName(itemname)[0].value;
        subtotal += parseFloat(document.getElementsByName('cost[]')[i].value);
    }
    document.getElementsByName('subtotal')[0].value = subtotal;
    let taxtotal = subtotal*0.0625;
    document.getElementsByName('tax')[0].value = taxtotal.toFixed(2);
    document.getElementsByName('total')[0].value = (subtotal + taxtotal).toFixed(2);
}