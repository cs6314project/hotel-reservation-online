<div class="row">
    <div class="searchbar">
        <form class="form-inline" method="get" action="search.php">
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" name="location" id="location" class="form-control" />
            </div>
            <div class="form-group">
                <label for="start-date end-date">Dates:</label>
                <div class="input-group input-daterange">
                    <input name="start" type="text" class="form-control">
                    <div class="input-group-addon">to</div>
                    <input name="end" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="maxoccupants">Number of guests:</label>
                <input name="maxoccupants" type="text" class="form-control input-small-num" style="width: 60px">
            </div>
            <input type="submit" value="Search" class="btn btn-default">
        </form>

    </div>
</div>