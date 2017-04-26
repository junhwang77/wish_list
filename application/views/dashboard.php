<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wishlist Dashboard</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <h2>Hello, <?= $logged_in['name'] ?></h2>
      <a href="/">Logout</a>
      <p>Your Wish List:</p>
      <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Added by</th>
                <th>Date Added</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($wishlist)) {
                foreach ($wishlist as $item) {
                        echo "<tr>
                                <td><a href='/wish_items/{$item['id']}'>{$item['item']}</a></td>
                                <td>{$item['added_by']}</td>
                                <td>{$item['created_at']}</td>";
                            if ($logged_in['username']==$item['added_by']) {
                                echo "<td><a href='/destroy/{$item['id']}'>Delete</a></td>
                            </tr>";
                            }
                            else {
                                echo "<td><a href='/remove/{$item['id']}'>Remove from my Wishlist</a></td>
                            </tr>";}
                }
            } ?>
        </tbody>
      </table>
      <p>Other Users' Wish List:</p>
      <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Added by</th>
                <th>Date Added</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($all_items)) {
                foreach ($all_items as $item) {

                        echo "<tr>
                                <td><a href='/wish_items/{$item['id']}'>{$item['item']}</a></td>
                                <td>{$item['added_by']}</td>
                                <td>{$item['created_at']}</td>
                                <td><a href='/join/{$item['id']}'>Add to my Wishlist</a></td>
                            </tr>";



                    }
                }
             ?>
        </tbody>
      </table>
      <a href="/wish_items/create">Add Item</a>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
