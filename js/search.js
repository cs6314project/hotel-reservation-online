var itemsPerPage = 4;
var currentPage = 1;
var rooms = [];
var isAdmin = false;
var checkin = "";
var checkout = "";
var numOccupants = "";

var featureStrings = [];
featureStrings.wifi = '<i class="material-icons md-18">wifi</i>Free Wireless Internet';
featureStrings.smoking = '<i class="material-icons md-18">smoking_rooms</i>Allows Smoking';
featureStrings.nosmoking = '<i class="material-icons md-18">smoke_free</i>Non-smoking';
featureStrings.tv = '<i class="material-icons md-18">tv</i>Premium TV channels';

function pageButtons() {
    var firstBtn = '<button id="firstpage" class="btn btn-default page-btn">First</button>';
    var lastBtn = '<button id="lastpage" class="btn btn-default page-btn">Last</button>';
    var btnHTML = firstBtn;
    var numItems = rooms.length;
    var max = Math.floor((numItems - 1) / itemsPerPage) + 1;
    for (var i = 1; i <= max; i++) {
        btn = '<button id="page' + i + '" class="btn btn-default page-btn">' + i + '</button>';
        btnHTML += btn;
    }
    btnHTML += lastBtn;
    return btnHTML;
}

function roomHTML(obj) {
    var img = '<img src="img/room'+obj.id+'/'+obj.photo+ '" alt="' + obj.name + '"/>';
    var price = '<p>$' + obj.price + '/night</p>';
    var hiddenID = '<input type="hidden" name="roomid" value="' + obj.id + '" />';
    var hiddenCheckin = '<input type="hidden" name="checkin" value="'+(checkin?checkin:"")+'" />';
    var hiddenCheckout = '<input type="hidden" name="checkout" value="'+(checkout?checkout:"")+'" />';
    var hiddenNum = '<input type="hidden" name="numoccupants" value="'+(numOccupants?numOccupants:"")+'" />';
    var hiddenParams = hiddenID+hiddenCheckin+hiddenCheckout+hiddenNum;
    var submitBtn = '<form action="product_details.php" method="GET"><button class="btn btn-primary">Book Now</button>' + hiddenParams + '</form>';
    var editBtn = '<form action="admin-edit-room.php" method="POST"><button class="btn btn-default">Edit</button>' + hiddenID + '</form>';
    var removeBtn = '<form action="admin-delete-room.php" method="POST"><button class="btn btn-danger">Remove</button>' + hiddenID + '</form>';
    var favBtn = "";
    if (obj.favorite != null) {
        if (obj.favorite)
            favBtn = '<i data-roomid="' + obj.id + '" data-wishstate="' + obj.favorite + '" class="fa fa-heart fa-2x favbtn"></i>';
        else
            favBtn = '<i data-roomid="' + obj.id + '" data-wishstate="' + obj.favorite + '" class="fa fa-heart-o fa-2x favbtn"></i>';
    }
    var form = '<div class="book-form">' + price + submitBtn;
    if (isAdmin==1) {
        form += editBtn + removeBtn;
    }
    form += '</div>';
    var name = '<h3>' + obj.name + '</h3>';
    var beds = '<p>' + obj.numbeds + ' ' + obj.bedsize + ' size bed';
    if (obj.numbeds > 1)
        beds += 's';
    beds += ', up to '+obj.maxoccupants+' occupants</p>';
    var features = "";
    $.each(obj.features, function (key, value) {
        features += '<li>' + featureStrings[value] + '</li>';
    });
    features = '<ul>' + features + '</ul>';
    var desc = form + name + beds + features;
    var html = '<div class="room center-block">' + img + desc + favBtn + '</div>';
    return html;
}

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

function sqlDateFormat(date) {
    if (date) {
        var arr = date.split("/");
        return arr[2] + "-" + arr[0] + "-" + arr[1];
    }
    else return "";
}

function filter() {
    rooms = [];
    var wifi = $("#wifi:checked").val();
    var tv = $("#tv:checked").val();
    var smokingfilter = $('input[name="smoking"]:checked').val();
    var smoking = "";
    var nosmoking = "";
    if(smokingfilter) {
        if(smokingfilter=="smoking")
            smoking = "on";
        else if(smokingfilter=="nosmoking") 
            nosmoking = "on";
    }
    var filters = {
        "wifi": wifi,
        "tv": tv,
        "smoking": smoking,
        "nosmoking": nosmoking
    };
    var sort = $('input[name="sort"]:checked').val();
    var pricemin = $("#price-min").val();
    var pricemax = $("#price-max").val();
    var array = [];
    var data = {
        "start": sqlDateFormat(checkin),
        "end": sqlDateFormat(checkout),
        "maxoccupants": numoccupants
    }
    $.getJSON("api/rooms.php", data, function (result) {
        isAdmin = result.isadmin;
        var roomsphp = result.rooms;
        $.each(roomsphp, function () {
            var room = this;
            var add = true;
            $.each(filters, function (key, value) {
                var hasFeature = $.inArray(key, room.features);
                if (value == "on" && hasFeature == -1)
                    add = false;
            });
            if (add && !(this.deleted==1))
                if ((!pricemin || pricemin <= room.price) && (!pricemax ||
                        pricemax >= room.price))
                    array.push(room);
        });
        if (sort) {
            array.sort(function (a, b) {
                return a.price - b.price;
            });
            if (sort == "price-desc")
                array.reverse();
        }

        $.each(array, function () {
            var html = roomHTML(this);
            rooms.push(html);
        });
        currentPage = 1;
        displayPage();
    });
}

function displayPage() {
    $("#searchresults").empty();
    $("#pagebuttons").empty();
    if(rooms.length == 0) {
        var noresults = '<p>Sorry, there are no results</p>';
        $("#searchresults").append(noresults);
    } else {
        var minIndex = (currentPage - 1) * itemsPerPage;
        var maxIndex = currentPage * itemsPerPage;
        for (var i = minIndex;
            (i < rooms.length && i < maxIndex); i++) {
            $("#searchresults").append(rooms[i]);
        }
        $("#pagebuttons").append(pageButtons());
        $("#page" + currentPage).addClass("active");
    }
}

$(document).ready(function () {
    $('.input-daterange input').each(function () {
        $(this).datepicker({}).on("changeDate", function() {
            if($(this).attr("name") == "start") 
                checkin = $(this).val();
            else if($(this).attr("name") == "end") 
                checkout = $(this).val();
            //alert(checkin + "  "+ checkout);
            filter();
        });
    });

    $("#maxoccupants").on("input", function() {
        numoccupants = $(this).val();
        filter();
    });

    $('#start').val(findGetParameter("start"));
    $('#end').val(findGetParameter("end"));
    $('#maxoccupants').val(findGetParameter("maxoccupants"));
    checkin = findGetParameter("start");
    checkout = findGetParameter("end");
    numoccupants = findGetParameter("maxoccupants");


    filter();

    $("#apply-filters").click(function () {
        filter();
    });

    $("#clear-filters").click(function() {
        $(".sidebar input").each(function() {
            if(this.type == 'checkbox' || this.type == 'radio') {
                this.checked = false;
            } else if(this.type == 'text') {
                $(this).val('');
            }
        });
        filter();
    });

    $("#pagebuttons").on('click', '.page-btn', function () {
        oldPage = "page" + currentPage;
        $("#oldPage").removeClass("active");
        var newPage;
        if (this.id == "firstpage") {
            newPage = 1;
        } else if (this.id == "lastpage") {
            newPage = Math.floor((rooms.length - 1) / itemsPerPage) + 1;
        } else {
            newPage = Number(this.id.substring(4));
        }
        currentPage = newPage;
        displayPage();
    });

    $("#searchresults").on("click", ".favbtn", function () {
        var element = this;
        var originalWishstate = $(this).data("wishstate");
        // Get user id from the session
        var data = {
            "roomid": $(this).data("roomid")
        };
        $.post("api/wishlist.php", data,
			function (data, textStatus, jqXHR) {
				data = JSON.parse(data);
				if(data.status == 1) {
					$(element).data("wishstate", false);
					$(element).removeClass("fa-heart");
					$(element).addClass("fa-heart-o");
					app.showNotificationFailure(data.message);
				} else if(data.status == 3) {
					$(element).data("wishstate", true);
					$(element).removeClass("fa-heart-o");
					$(element).addClass("fa-heart");
					app.showNotificationSuccess(data.message);
				}
			}
        );
    });
});
