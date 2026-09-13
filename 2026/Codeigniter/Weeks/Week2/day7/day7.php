<?php

require_once 'App/Config/Database.php';
require_once 'App/Classes/ExpenseCalculator.php';
require_once "App/Classes/ExpenseValidator.php";
require_once "App/Classes/Expense.php";

use App\Config\Database;
use App\Classes\ExpenseCalculator;
use App\Classes\ExpenseValidator;
use App\Classes\Expense;
use App\Classes\Income;


// $database = new Database();

$db = Database::getInstance()->getConnection();

$expense = new Expense($db, "testexpense", 45000, "2026-09-18", "NFT");
$incomeproof = new Income("BMW M series", 1000000000, "2026-09-18", "Angle One");

$calculator = new ExpenseCalculator();

$expensearray =$expense->getAll();

$totalExpense =$calculator->total($expensearray);

$budget = 100000;

$remainingBudget = $calculator->remainingBudget($budget,$totalExpense);

$validate = new ExpenseValidator();

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['gid'])) {

    $id = (int) $_GET['gid'];

    $record = $expense->find($id);
    
    header('Content-Type: application/json');

    if ($record) {

        echo json_encode([
            'status' => true,
            'data' => $record,
            'message' => 'Expense found successfully.'
        ]);

    } else {

        echo json_encode([
            'status' => false,
            'message' => 'Expense not found.'
        ]);
    }

    exit;
}


if($_SERVER['REQUEST_METHOD'] === "POST"){
//   <!-- Expense Calculator Application

// Attribute
// title
// amount
// category
// paymentmethod
// description
// date
// Total Income

// Method
// Calculate Total Expense
// Calculate Remaining Balance
// Display Low Balance Alert
// Display All Expense
// Filter Expense by name, amount and Category
// Add Expense, Update Expense, Read Expense, Delete Expense

// -->

if(isset($_POST['id'])){
  $isdelete = $expense->delete($_POST['id']);
  if($isdelete){
    header('Content-Type: application/json');

     echo json_encode([
        'status' => TRUE,
        'message' => $isdelete
            ? 'Expense deleted successfully.'
            : 'Unable to delete expense.'
    ]);

    exit;
  }
}

$title = $_POST['title'];
$amount = $_POST['amount'];
$category = $_POST['category'];
$payment_method = $_POST['payment_method'];
$expense_date = $_POST['expense_date'];
$description="this is description";


$postdata = Array('title'=>$title, 'amount' => $amount, 'category' => $category, 'payment_method' => $payment_method , 'expense_date' => $expense_date );

$isvalid = $validate->validate($postdata);

if($isvalid){

if(isset($_POST['editid']) && $_POST['editid'] !== ''){

  $editid = (int)$_POST['editid'];
  
  $editrecord = $expense->find($editid);

  print_r($editrecord);
  
  if ($editrecord) {
    $isupdate = $expense->update($_POST['editid'], $expense_date,$title,$category,$amount,$payment_method, $description);

     echo json_encode([
        'status' => TRUE,
        'message' => $isupdate
            ? 'Expense Updated successfully.'
            : 'Unable to update expense.'
    ]);

    
    } else {

          echo json_encode([
            'status' => false,
            'message' => 'Expense not found.'
        ]);
    }
}else{
  $expense->addexpense($expense_date,$title,$category,$amount,$payment_method, $description);
  $message =$expense->describe();
  $incomemessage = $incomeproof->describe();
  echo $message;
  echo $incomemessage;
}

}else{
  $errorreport = $validate->getErrors();
  print_r($errorreport);
}
}


?>

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
    <h1 class="text-center">Expense Tracker</h1>

    <div class="container">

    <form method="POST" action="day7.php" class="row g-3">
  <div class="col-md-4">
    <label for="Expense_Name" class="form-label">Expense Name</label>
    <input type="text" name="title" class="form-control" value="<?php if(!empty($record['title'])){ echo $record['title']; } ?>" id="Expense_Name">
  </div>
  <div class="col-md-4">
    <label for="Debit_Amount" class="form-label">Debit Amount</label>
    <input type="number" name="amount" class="form-control" id="Debit_Amount">
  </div>
   <div class="col-md-4">
    <label for="inputState"  class="form-label">Category</label>
    <select id="inputState" name="category" class="form-select">
      <option value="" selected>Choose category</option>
      <option value="Shoppping">Shoppping</option>
      <option value="Traveling">Traveling</option>
      <option value="Hotels">Hotels</option>
      <option value="Investment">Investment</option>
    </select>
  </div>
   <div class="col-md-6">
    <label for="Payment" class="form-label">Payment Method</label>
    <select id="Payment" name="payment_method" class="form-select">
      <option value="" selected>Choose Payment</option>
      <option value="Cash">Cash</option>
      <option value="NFT">NFT</option>
      <option value="UPI">UPI</option>
      <option value="Net Banking">Net Banking</option>
    </select>
  </div>
  <div class="col-md-6">
    <label for="inputAddress" class="form-label">Date</label>
    <input type="Date" name="expense_date" class="form-control" id="inputAddress" placeholder="1234 Main St">
  </div>
  <input type="hidden" name="editid" id="expense_id" value="">
  <div class="col-md-12">
    <button type="submit" class="btn btn-primary" id="signin">Sign in</button>
  </div>
</form>

<div id="messageBox"></div> 
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 text-center">
    <h1>Expense Report</h1>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12">
    <table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Expense</th>
      <th scope="col">Amount</th>
      <th scope="col">Category</th>
      <th scope="col">Payment Method</th>
      <th scope="col">Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach($expensearray as $index => $e){ ?>
    <tr>
      <th scope="row"><?= $index+1; ?></th>
      
      <td><?= $e['title']; ?></td>
      <td><?= $e['amount']; ?></td>
      <td><?= $e['category']; ?></td>
      <td><?= $e['payment_method']; ?></td>
      <td><?= $e['expense_date']; ?></td>
      <td><div class="d-flex align-items-start"> <button type="submit" onclick="eedit(<?= $e['id']; ?>)" class="btn btn-success mx-2">Edit</button> <button type="button" onclick="edelete(<?= $e['id']; ?>)" class="btn btn-danger">Delete</button></div></td>
    </tr>
    <?php } ?>
    <tr>
      <td></td>
      <td>Total Expenses</td>
      <td colspan="5"><?php echo $totalExpense; ?></td>
    </tr>
  </tbody>
</table>
  </div>
</div>

</div>

<!-- Button trigger modal -->
 <?php if($remainingBudget < 10000) {?>
<button type="button" class="btn btn-primary" id="lowbalance" style="position: absolute; visibility: hidden;" data-bs-toggle="modal" data-bs-target="#exampleModal"></button>
<?php }?>
<div class="modal" id="exampleModal" tabindex="-1"> 
  <div class="modal-dialog"> 
    <div class="modal-content"> 

      <div class="modal-header"> 
        <h5 class="modal-title">⚠️ Low Balance Alert</h5> 
        <button type="button" 
                class="btn-close" 
                data-bs-dismiss="modal" 
                aria-label="Close">
        </button> 
      </div> 

      <div class="modal-body"> 
        <p>
          Your Rs. <?php echo $remainingBudget; ?> Balance is low. 
          Please review your expenses and manage your budget carefully.
        </p>
      </div> 

      <div class="modal-footer"> 
        <button type="button" 
                class="btn btn-secondary" 
                data-bs-dismiss="modal">
          Close
        </button> 
      </div> 

    </div> 
  </div> 
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
   function edelete(eid){


     $.ajax({
        url: "/practicecode/day7/day7.php",
        type: "POST",
        data: {
            id: eid
        },
        dataType: "json",

        success: function(response) {
            if (response.status === true) {
                     $("#messageBox").html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> ${response.message}
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                        </button>
                    </div>
                `);

                // Refresh after 2 seconds
                setTimeout(function() {
                    location.reload();
                }, 2000);


            } else {
                     $("#messageBox").html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> ${response.message}
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                        </button>
                    </div>
                `);
            }
        },

        error: function(xhr) {
            console.log(xhr.response);
                 $("#messageBox").html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Something went wrong.
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close">
                    </button>
                </div>
            `);
        }
    });

   };

function eedit(eid) {

    $.ajax({
        url: "/practicecode/day7/day7.php",
        type: "GET",

        data: {
            gid: eid
        },

        dataType: "json",

        success: function(response) {

            console.log(response);

            if (response.status === true) {

                // Put existing data into form
                $("#Expense_Name").val(response.data.title);
                $("#Debit_Amount").val(response.data.amount);
                $("#inputState").val(response.data.category);
                $("#Payment").val(response.data.payment_method);
                $("#inputAddress").val(response.data.expense_date);

                // Store ID for update
                $("#expense_id").val(response.data.id);

            } else {

                $("#messageBox").html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> ${response.message}

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                        </button>
                    </div>
                `);
            }
        },

        error: function(xhr, status, error) {

            console.log("Response:", xhr.responseText);
            console.log("Status:", status);
            console.log("Error:", error);

            $("#messageBox").html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Unable to fetch expense.

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close">
                    </button>
                </div>
            `);
        }
    });
}

function lowbalancealert(){
  let low = document.getElementById("lowbalance");
  if(low){
    document.getElementById("lowbalance").click();
  } 
}

setInterval(() => {
  lowbalancealert();
}, 3000);

  </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>