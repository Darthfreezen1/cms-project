<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Page Title</title>
</head>
<body>
    <form action="insert.php" method="post">
        <label for="page_type">Type: </label>
        <select name="page_type" id="page_type">
            <option value="item">Item</option>
            <option value="location">Location</option>
            <option value="enemy">Enemy</option>
            <option value="quartz">Quartz</option>
            <option value="spell">Spell</option>
        </select>

        <label for="title">Title: </label>
        <input type="text" name="title" id="title"/>

        <label for="description">Description: </label>
        <textarea name="description" id="description" cols="100" rows="10"></textarea>

        <!--php if items is selected then show this -->
        <!-- session[username] is the creator -->

    </form>
    
</body>
</html>