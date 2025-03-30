//Basic functionality for now. PHP will handle most dynamic content.
//Example, to show the user section when logged in, or the herb details.
//example show the user section.
document.addEventListener('DOMContentLoaded', function() {
    //Example, if user is logged in, show user section.
    let loggedIn = false; //Change to true for testing.
    if (loggedIn){
        document.getElementById('user-section').classList.remove('hidden');
    }

    
    
  });

//   this is for search bar fetching results
  
  function showResult(str) {
        if (str.length === 0) {
            document.getElementById("livesearch").innerHTML = "";
            document.getElementById("livesearch").style.border = "0px";
            return;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
            document.getElementById("livesearch").innerHTML = this.responseText;
            document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
            }
        }
        xmlhttp.open("GET", "livesearch.php?q=" + str, true);
        xmlhttp.send();
        }

        function selectSuggestion(suggestion) {
        document.querySelector('input[type="text"]').value = suggestion; 
        document.getElementById("livesearch").innerHTML = ""; 
        document.getElementById("livesearch").style.border = "0px";
        }