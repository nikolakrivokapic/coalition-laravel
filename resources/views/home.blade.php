<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Home</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    </head>
    <body id="page-top" class="index">

    <form id="form1" method="post">
      <div class="form-group">
        <label for="product_name">Product Name:</label>
        <input type="text" class="form-control" name="product_name" id="product_name">
      </div>
      <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="text" class="form-control" name="quantity" id="quantity">
      </div>
      <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" class="form-control" name="price" id="price">
      </div>
      <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
    <table class="table">
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Time</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
      @if(!empty($rows))
      @foreach($rows as $row)
      <tr>
        <td>{{$row->product_name}}</td>
        <td>{{$row->quantity}}</td>
        <td>{{$row->price}}</td>
        <td>{{$row->time}}</td>
        <td>{{$row->total}}</td>
      </tr>
      @endforeach
      @endif
      </tbody>
    </table>
    </body>
</html>

<script type="text/javascript">
$("#form1").submit(function(e) {

    var url = "{{route('submit')}}"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#form1").serialize(), // serializes the form's elements.
           success: function(data)
           {
            var output;
            $.each(JSON.parse(data), function(row, value) {
                output+="<tr>"
                output+="<td>" + value.product_name + "</td><td>" + value.quantity + "</td><td>" + value.price + "</td><td>" + value.time + "</td><td>" + value.total + "</td>";
                output+="</tr>";
            });

            $('tbody').html(output);
           }
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});
</script>