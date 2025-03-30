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

function goToHerbPage(herbId) {
    window.location.href = `herbDetails.php?id=${herbId}`;
}
  
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
            
        function selectSuggestion(suggestion) { // For the header search bar
            document.querySelector('#search-bar-header input[type="text"]').value = suggestion;
            document.getElementById("livesearch").innerHTML = "";
            document.getElementById("livesearch").style.border = "0px";
        }


        function showResultMain(str) { // For the main search bar
            if (str.length === 0) {
                document.getElementById("livesearch-main").innerHTML = "";
                document.getElementById("livesearch-main").style.border = "0px";
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("livesearch-main").innerHTML = this.responseText;
                    document.getElementById("livesearch-main").style.border = "1px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "livesearch.php?q=" + str, true);
            xmlhttp.send();
        }

    
        function selectSuggestionMain(suggestion) { // For the main search bar
            document.querySelector('#search-bar-main input[type="text"]').value = suggestion;
            document.getElementById("livesearch-main").innerHTML = "";
            document.getElementById("livesearch-main").style.border = "0px";
        }