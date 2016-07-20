function validateData()
{

   if (!(document.getElementById("loan_val").value))
    {
       alert("Please enter loan amount.");
       return false;
    }
   
    if (!(document.getElementById("prop_val").value))
    {
       alert("Please enter property value.");
       return false;
    }
  
    if (!(document.getElementById("ssn").value))
    {
       alert("Please enter SSN.");
       return false;
    }
  
    return true;
}

function validateLoan()
{
  if (!(document.getElementById("id").value))
    {
       alert("Please enter loan id.");
       return false;
    }
  return true;
}
 