<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<div class="header">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Fruits</title>
    </head>

    <input type="text" id="myFruit" placeholder="Fruit...">
    <input type="text" id="myType" placeholder="Type...">
    <input type="text" id="myItem" placeholder="Item...">
    <input type="text" id="myItemType" placeholder="Item Type...">

    <span onclick="newElement()" class="addBtn">Add</span>
</div>
<ul id="fruitsUl">
    @foreach($fruits as $fruit)
        <li value='fruit' class="{{$fruit->id}}">{{$fruit->type}}</li>
        @foreach($fruit->children as $i => $type)
            <ul>
                <li value='name' class="{{$type->id}}">{{$type->name}}</li>
                @if($type->item)
                    <ul>
                        <li value='item' class="{{$type->id}}">{{$type->item}} {{$type->item_type}}</li>
                    </ul>
                @endif
            </ul>
        @endforeach
    @endforeach
</ul>


<script>
    var list = document.getElementsByTagName("LI");
    var close = document.getElementsByClassName("close");
    var nextDate = new Date();

    /**
     * Records the current time and sets up for next call
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
            removeRow(this.parentElement.getAttribute('class'), this.parentElement.getAttribute('value'));
        }
    }

    // Create a new list item when clicking on the "Add" button
    function newElement() {
        var value = 'N/A';

        var myFruit = document.getElementById("myFruit").value ?? value;
        var myType = document.getElementById("myType").value ?? value;
        var myItem = document.getElementById("myItem").value ?? value;
        var myItemType = document.getElementById("myItemType").value ?? value;

        // Update Backend for new value.
        updateFruitTable(myFruit, myType, myItem, myItemType);
    }
    function updateFruitTable(myFruit, myType, myItem, myItemType) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '/updateFruitTable',
            data: {
                'name':myFruit,
                'type':myType,
                'item':myItem,
                'item_type':myItemType
            },
            success: function() {
                console.log("New Fruit Added");
            }
        });
    }

    function removeRow(id, type) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '/removeFruit',
            data: {
                'id':id,
                'type':type
            },
            success: function() {
                console.log("Fruit Removed");
                reload();
            }
        });
    };

    /**
     * update 1 hour from current time.
     */
    function callEveryHour() {
        setInterval(UpdateFruitByJson, 1000 * 60 * 60);
    }

    function UpdateFruitByJson() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: '/getJsonFruit',
            success: function() {
                reload();
            }
        });
    };

    function reload() {
        // location.reload();
    }
</script>
<style>
    body {
    margin: 0;
    min-width: 250px;
    }

    .header {
    background-color: #f44336;
    padding: 30px 40px;
    color: white;
    text-align: center;
    }

    .header:after {
    content: "";
    display: table;
    clear: both;
    }

    input {
    margin: 0;
    border: none;
    border-radius: 0;
    width: 75%;
    padding: 10px;
    float: left;
    font-size: 16px;
    }

    .addBtn {
    padding: 10px;
    width: 75%;
    background: #d9d9d9;
    color: #555;
    float: left;
    text-align: center;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
    border-radius: 0;
    }

    .addBtn:hover {
    background-color: #bbb;
    }
</style>
