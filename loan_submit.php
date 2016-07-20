<?php

#
# import DB utiltity function.
#
require_once "utility/DB.php";

class loan_details 
{
  
  var $loan_val;
  var $prop_val;
  var $ssn;
  var $error_msg;
  
  # Accept all data passed and intialise them in the class
  function loan_details($loan_val, $prop_val, $ssn)
  {
      $this->loan_val  = $loan_val;
      $this->prop_val  = $prop_val;
      $this->ssn       = $ssn;
      $this->error_msg = "";  
  }
  
  #
  #  Function to validate the data passed.
  #
  function validate_data()
  {
     
      # Check if valid loan amount is entered.
      if (!$this->loan_val) 
      {
         $this->error_msg = "Please enter value for 'Loan amount'.";
         return $error_msg; 
      }
    
      if (!is_numeric($this->loan_val)) 
      {
         $this->error_msg = "You cannot enter 'Loan amount' which is not numeric value.";
         return $error_msg; 
      }
    
       # Check if valid property value is entered.
      if (!$this->prop_val) 
      {
         $this->error_msg = "Please enter value for 'Property Value'.";
         return $error_msg; 
      }
   
      if (!is_numeric($this->prop_val)) 
      {
         $this->error_msg = "You cannot enter 'Property value' which is not numeric value.";
         return $error_msg; 
      }
    
      # Check if valid ssn is entered.
      if (!$this->ssn) 
      {
         $this->error_msg = "Please enter value for 'SSN in the format xxx-xx-xxxx'.";
         return $error_msg; 
      }
    
      # Assuming that SSN should be 11 characters.
      if (strlen($this->ssn) != 11)
      {
        $this->error_msg = "SSN should be only 11 characters.";
        return $error_msg;
      }
    
      # ssn should have -
      if (substr_count($this->ssn, '-') != 2)
      {
        $this->error_msg = "SSN should have 2 '-'.";
        return $error_msg;
      }
    
      # Assuming ssn can have digits and -. We can enhance this real time anyways
      $ssn_val =  str_replace("-", "", $this->ssn);
      if (!is_numeric($ssn_val))
      {
        $this->error_msg = "SSN should have numbers and - only in the format xxx-xx-xxxx.";
        return $error_msg;
      }
    
      # Loan amount cannot be greater than the property value
      if ($this->loan_val > $this->prop_val)
      {
         $this->error_msg = "You cannot enter 'Loan amount' greater than 'Property Value'";
         return $error_msg; 
      }
    
      # Calculate LTV and if you find it > 40%, then we can get that.
      # Logiv used = (loan value / property value )
      $loanToValue =   ( $this->loan_val / $this->prop_val ) * 100;
      if ($loanToValue > 40)
      {
         $this->error_msg = "You cannot get the loan since LTV(Loan to Value) > 40%. Please contact support team for further details.";
         return $this->error_msg;
      }
    
   }
};

# Pass loan data entered by user and validate them.
$loan = new loan_details($_POST['loan_val'], $_POST['prop_val'], $_POST['ssn']);
$loan->validate_data();

 $page_url = 'http';
      if ($_SERVER["HTTPS"] == "on") 
      { 
        $page_url .= "s";
      }
      $page_url .= "://".$_SERVER["SERVER_NAME"];

      if ($_SERVER["SERVER_PORT"] != "80") {
       $page_url .= ":".$_SERVER["SERVER_PORT"];
      }


if (!($loan->error_msg))
{
    #
    # Get the database instance to create object of database class
    #
    $dbh = new DB();
  
    # Check if loan is already there for same ssn. If so, then alert that they need to contact support team.
    $ssn_rows = $dbh->get_count("select * from loan_accept where ssn='".$loan->ssn."'");
  
    if ($ssn_rows > 0)
    {
       $loan->error_msg = "Please check with support team since your ssn is already having loan with us.";
    }
    else
    {
       $loan_id = $dbh->insert_data("insert into loan_accept(loan_amount, property_amount, ssn) values(".$loan->loan_val.",".$loan->prop_val.",'".$loan->ssn."')");
       header("Location:".$page_url."/loan_details.php?loan_id=".$loan_id);
    }

   

}

#
# If invalid data is passed, then error out by redirecting to home page with error.
#
if ($loan->error_msg)
{
      $page_url .= "/index.php?loan_val=".$_POST['loan_val']."&prop_val=".$_POST['prop_val']."&ssn=".$_POST['ssn']."&error=".$loan->error_msg;
      header("Location:".$page_url);

}
?>