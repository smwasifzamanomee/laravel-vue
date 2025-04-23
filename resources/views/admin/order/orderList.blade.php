<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="main-panel">
    <div class="content-wrapper">
        <div id="app">
            <order-list :order_lists="{{ json_encode($orders) }}"></order-list>
        </div>
        
    </div>
</div>
</body>
</html>
