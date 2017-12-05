var itemsPerPage = 4;
var currentPage = 1;
var rooms = [];

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
    var hiddenParam = '<input type="hidden" name="roomid" value="' + obj.id + '" />';
    var submitBtn = '<form action="details.php" method="GET"><button class="btn btn-primary">Go</button>' + hiddenParam + '</form>';
    var favBtn = "";
    if (obj.hasOwnProperty("favorite")) {
        if (obj.favorite)
            favBtn = '<i data-roomid="' + obj.id + '" data-wishstate="' + obj.favorite + '" class="fa fa-heart fa-2x favbtn"></i>';
        else
            favBtn = '<i data-roomid="' + obj.id + '" data-wishstate="' + obj.favorite + '" class="fa fa-heart-o fa-2x favbtn"></i>';
    }
    var form = '<div class="book-form">' + price + submitBtn;
    form += '</div>';
    var name = '<h3>' + obj.name + '</h3>'
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
    var html = '<div class="row room center-block">' + img + desc + favBtn + '</div>';
    return html;
}

function displayPage() {
    $("#searchresults").empty();
    $("#pagebuttons").empty();
    if(rooms.length == 0) {
        var noresults = '<p>Your favorites list is empty</p>';
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
    $.getJSON("api/userfavorites.php", function (result) {
        $.each(result, function () {
            var html = roomHTML(this);
            rooms.push(html);
        });
        displayPage();
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
