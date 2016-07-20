<?php
# Define class and define functions so that you can reuse them many times
class DB {
  
     var $dbh;
     //
     // Function to connect to database and select database.
     //
     function DB() {
       
        $this->dbh = mysql_connect("localhost", "root", "")
              or die("Could not connect : " . mysql_error());
        
        mysql_select_db("loan") or die("Could not select database");
  
    }
 
     #
     # This function expects complete ready query.
     #  Ex: insert into loan_accept(loan_amount, property_amount, ssn) values(123,4567,'6768678678')
     #
     function insert_data($query) {
   
       mysql_query($query) or die("Insertion of data failed due to error :".mysql_error());
       
       # echo if we want last inserted id.
       # printf("Last inserted record has id %d\n", mysql_insert_id());
       return mysql_insert_id();
       
    }
  
    #
    #  This function expects complete ready query and executes it and returns of records matching with query
    #
    function get_count($query) {
      
      $result = mysql_query($query) or die("Failed to get number of matching records:".mysql_error());
      $num_rows = mysql_num_rows($result);
      
      return $num_rows;
    }
  
  #
  # This function returns exact rowm matched..Expects complete query 
  #
    function get_row($query) { 
      
         $result = mysql_query($query);  
         $row = mysql_fetch_row($result); 
                              
         return $row;
    }
}

?>