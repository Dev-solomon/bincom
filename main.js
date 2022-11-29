// below are buttons for each div table
var pu_button = document.getElementById('pu');
var lg_button = document.getElementById('lg');
// below are  for each div table contents
var pu_div = document.getElementById('divpu');
var lg_div = document.getElementById('divlg');


// Function for the polling_unit button on table_display
function pu_Func(){
    if(pu_div.style.display == "none" && lg_div.style.display == "none"){
        pu_div.style.display = "block";
    } else if(pu_div.style.display == "none" && lg_div.style.display == "block"){
        pu_div.style.display = "block";
        lg_div.style.display = "none";
    }   
    else{ 
        pu_div.style.display = "none";
    }
}

// Function for theL GA button on table_display
function lg_Func(){
    if(lg_div.style.display == "none" && pu_div.style.display == "none"){
        lg_div.style.display = "block";
    } else if(pu_div.style.display == "block" && lg_div.style.display == "none"){
        pu_div.style.display = "none"; 
        lg_div.style.display = "block";
    } else{
        lg_div.style.display = "none";
    }
}
  