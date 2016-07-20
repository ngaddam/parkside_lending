<?php

# import DB utiltity function.
#
require_once "utility/DB.php";

echo file_get_contents("html/loan_query.html");

if ($_GET['loan_id'])
{ 
    #
    # Get the database instance to create object of database class
    #
    $dbh = new DB();
  
    # Check if loan is already there for same ssn. If so, then alert that they need to contact support team.
    $loan_row = $dbh->get_row("select * from loan_accept where loan_id=".$_GET['loan_id']);
  
    if ($loan_row) {
  
echo <<<EOT
      <div class="rowspace">
             <div class="label">
                  <label class="labelcol">Loan ID : </label>
             </div>
             <div class="field">
               $loan_row[0]
             </div>
       </div>
       <div class="rowspace">
             <div class="label">
                  <label class="labelcol">Loan Amount : </label>
             </div>
             <div class="field">
               $loan_row[1]
             </div>
       </div>
       <div class="rowspace">
             <div class="label">
                  <label class="labelcol">Property Value : </label>
             </div>
             <div class="field">
               $loan_row[2]
             </div>
       </div>
       
       <div class="rowspace">
             <div class="label">
                  <label class="labelcol">SSN : </label>
             </div>
             <div class="field">
               $loan_row[3]
             </div>
       </div>
       
       <div class="rowspace">
             <div class="label">
                  <label class="labelcol">Status : </label>
             </div>
             <div class="field">
               $loan_row[4]
             </div>
       </div>
       
        <div class="rowspace">
             <div class="label">
                  <label class="labelcol">Applied Date : </label>
             </div>
             <div class="field">
               $loan_row[5]
             </div>
       </div>
       
EOT;
    }
    else
    {
echo <<<EOT
       <div class="label" align="center">
         <label id="error" class="errorclass">Loan id : {$_GET['loan_id']} : No such loan details. Please contact support team.</label>
       </div>
EOT;

    }
}
else{
  echo <<<EOT
       <div class="label" align="center">
         <label id="error" class="errorclass">Enter loan id.</label>
       </div>
EOT;
}

?>