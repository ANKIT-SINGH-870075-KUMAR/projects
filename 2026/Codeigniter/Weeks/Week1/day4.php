<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1>Day 4 Assissment</h1>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form method="Get" action="day4.php">
                        <div class="form-control">
                            <label for="name">
                             Full Name
                            </label>
                            <input type="text" name="name" id="name" value="" placeholder="Please enter your complete name">
                        </div>
                        <div class="form-control">
                            <label for="email">
                            Email Address
                            </label>
                            <input type="email" name="email" id="email" value="" placeholder="Please enter your valid email">
                        </div>
                        <div class="form-control">
                            <label for="phoneno">
                            Phone Number
                            </label>
                            <input type="number" name="phoneno" id="phoneno" value="" placeholder="Please enter your Phone number">
                        </div>
                        <div class="form-control">
                            <label for="password">
                             Password
                            </label>
                            <input type="password" name="password" id="password" value="" placeholder="Please enter your password here">
                        </div>
                        <div class="form-control">
                            <label for="male">
                             Male
                            </label>
                            <input type="radio" name="gener" id="male" value="Male">
                        </div>
                        <div class="form-control">
                            <label for="female">
                             Female
                            </label>
                            <input type="radio" name="gender" id="female" value="Female">
                        </div>
                        <div class="form-control">
                            <button type="submit">Submit Here</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
  </body>
</html>