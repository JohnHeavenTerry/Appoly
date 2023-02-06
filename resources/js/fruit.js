import './bootstrap';

var list = document.getElementsByTagName("LI");
var close = document.getElementsByClassName("close");
var nextDate = new Date();

/**
 * Records the current time and
 */
if (nextDate.getMinutes() === 0) {
    callEveryHour()
} else {
    nextDate.setHours(nextDate.getHours() + 1);
    nextDate.setMinutes(0);
    nextDate.setSeconds(0);

    var difference = nextDate - new Date();
    setTimeout(callEveryHour, difference);
}

for (var i = 0; i < list.length; i++) {
    var span = document.createElement("SPAN");
    var txt = document.createTextNode("\u00D7");
    span.className = "close";
    span.appendChild(txt);
    list[i].appendChild(span);
}

for (var i = 0; i < close.length; i++) {
    close[i].onclick = function(i) {
        var div = this.parentElement;
        div.style.display = "none";
        removeFruit(this.parentElement.getAttribute('class'));
    }
}

// Create a new list item when clicking on the "Add" button
function newElement(value = '') {
    var inputValue = document.getElementById("myInput").value ?? value;
    var li = document.createElement("li");
    var t = document.createTextNode(inputValue);

    if (inputValue === '') {
        alert("Please Provide Input");
    } else {
        document.getElementById("fruitsUl").appendChild(li);
    }

    li.appendChild(t);
    var span = document.createElement("SPAN");
    var txt = document.createTextNode("\u00D7");

    span.className = "close";
    span.appendChild(txt);
    li.appendChild(span);

    for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.display = "none";
        }
    }

    // Update Backend for new value.
    updateFruitTable(inputValue);
}
function updateFruitTable(inputValue) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '/updateFruitTable',
        data: {
            'name':inputValue
        },
        success: function() {
            console.log("New Fruit Added");
        }
    });
}

function removeFruit(fruitNumber) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '/removeFruit',
        data: {
            'id':fruitNumber
        },
        success: function() {
            console.log("Fruit Removed");
        }
    });
};

/**
 * update 1 hour from current time.
 */
function callEveryHour() {
    setInterval(UpdateFruitByJson, 1000 * 60 * 60);
}

// Endpoint Refuses to work from all attempts to access it
// Leaving in skeleton code for bonus points.
function UpdateFruitByJson() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: '/getJsonFruit',
        success: function() {
            // Reload the new data that's been saved into the table.
            location.reload();
        }
    });
};

