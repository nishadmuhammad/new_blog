<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
          
            .newform{
            margin-left:255px;
            width:167px;
        }
  


        </style>
    </head>
    <body>
       
      
  {{ csrf_field() }}
<div class="row">
<div class="col-md-12 col-sd-6">
<div class="newform">

<form class="form-horizontal" method="POST" action="/api/add-task">
 <div class="form-group">
  <label for="Name">Name: </label>
  <input type="text" class="form-control" id="names" placeholder="Name" name="name" required>
 </div>

 <div class="form-group">
  <label for="email">Email: </label>
  <input type="text" class="form-control" id="email" placeholder="Email" name="email" required>
 </div>

 <div class="form-group">
  <label for="message">Message: </label>
  <textarea type="text" class="form-control" id="message" placeholder="Enter your message here" name="message" required> </textarea>
 </div>
 <div class="form-group">
   <button type="submit" class="btn btn-primary" value="submit">submit</button>
 </div> 
</form>
</div>
</div>
</div>
    </body>
</html>
