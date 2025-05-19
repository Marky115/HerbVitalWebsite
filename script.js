
document.addEventListener('DOMContentLoaded', function() {
    let loggedIn = false; //Change to true for testing.
    if (loggedIn){
        document.getElementById('user-section').classList.remove('hidden');
    }


    const concernLinks = document.querySelectorAll('.filter-by-concern');
    const featuredHerbsSection = document.getElementById('featured-herbs-db'); 

    concernLinks.forEach(link => {
        link.addEventListener('click', function() {

            const concernId = this.dataset.concernId;
            
            if (concernId) {
                fetch('herbs_by_concern.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'concern_id=' + encodeURIComponent(concernId)
                })
                .then(response => response.json()) // Parse the response as JSON
                .then(data => {
                    if (data.success) {
                        let html = '<h2>Herbs for ' + this.textContent + '</h2>';
                        // Loop through each herb to build the UI dynamically
                        data.herbs.forEach(herb => {
                            html += `
                                <div class="herb-item" onclick="window.location.href='herbDetails.php?id=${herb.herbID}'">
                                    <img src="${herb.imagePath}" alt="${herb.herbName}">
                                    <h3>${herb.herbName}</h3>
                                    <p>${herb.Benefit}</p>
                                </div>
                            `;
                        });
                        featuredHerbsSection.innerHTML = html;
                    } else {
                        featuredHerbsSection.innerHTML = '<p>' + data.message + '</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching herbs:', error);
                    if (featuredHerbsSection) {
                        featuredHerbsSection.innerHTML = '<p>Error loading herbs.</p>';
                    }
                });
            }

        });
    });

    
    
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
    // fetch using fetch api to get the herb details
    fetch("livesearch.php?q=" + encodeURIComponent(str))
        .then(response => response.text())
        .then(data => {
            document.getElementById("livesearch").innerHTML = data;
            document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
        })
        .catch(error => {
            console.error("Error fetching search results:", error);
        });
}

document.querySelector('#search-bar-header input[name="query"]').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
    event.preventDefault(); // Prevent the default form submission
              
    const firstResult = document.querySelector('#livesearch div');
    if (firstResult) {
        const onclickAttribute = firstResult.getAttribute('onclick');
        if (onclickAttribute) {
            const herbIdMatch = onclickAttribute.match(/goToHerbPage\("(\d+)"\)/);
            if (herbIdMatch && herbIdMatch[1]) {
                // see if the searched result matches, if yes then take to the herb detail
                window.location.href = 'herbDetails.php?id=' + herbIdMatch[1];
                }
            }
        }

        // no action if theres no result match
    }
});

            
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

        document.querySelector('#search-bar-main input[name="query"]').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
              event.preventDefault(); // Prevent the default form submission
        
              const firstResultMain = document.querySelector('#livesearch-main div');
              if (firstResultMain) {
                const onclickAttributeMain = firstResultMain.getAttribute('onclick');
                if (onclickAttributeMain) {
                  const herbIdMatchMain = onclickAttributeMain.match(/goToHerbPage\("(\d+)"\)/);
                  if (herbIdMatchMain && herbIdMatchMain[1]) {
                    // see if the searched result matches, if yes then take to the herb detail
                    window.location.href = 'herbDetails.php?id=' + herbIdMatchMain[1];
                  }
                }
              }         // no action if theres no result match

            }
          });

        // for the profile page.

        function confirmDeleteProfile() {
            if (confirm('Are you sure you want to delete your profile? This action is irreversible and will also delete your saved herbs and comments.')) {
                window.location.href = 'delete-profile.php';
            }
        }
    
        //this is for the unsave herb in the profile page
        function unsaveHerb(herbId, button) {
            // Store the button reference explicitly
            const clickedButton = button || event.target;
            
            if (confirm("Are you sure you want to remove this herb from your saved list?")) {
                // Create AJAX request
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "unsave_herb.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                
                // Handle response
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            //JSON APIs
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                // Remove the herb element from the DOM
                                const herbElement = clickedButton.closest('.saved-herb-item');
                                if (herbElement) {
                                    herbElement.remove();
                                    
                                    const savedHerbs = document.querySelectorAll('.saved-herb-item');
                                    if (savedHerbs.length === 0) {
                                        const container = document.querySelector('.container');
                                        const noHerbsMessage = document.createElement('p');
                                        noHerbsMessage.className = 'no-saved-herbs';
                                        noHerbsMessage.textContent = "You haven't saved any herbs yet.";
                                        
                                        const profileActions = document.querySelector('.profile-actions');
                                        if (profileActions && container) {
                                            container.insertBefore(noHerbsMessage, profileActions);
                                        } else if (container) {
                                            container.appendChild(noHerbsMessage);
                                        }
                                    }
                                    
                                    console.log("Herb removed successfully");
                                } else {
                                    console.error("Could not find herb element to remove");
                                }
                            } else {
                                alert("Error: " + response.message);
                            }
                        } catch (e) {
                            console.error("Error parsing response:", e);
                            console.log("Raw response:", xhr.responseText);
                        }
                    } else {
                        alert("Error processing your request. Please try again.");
                    }
                };
                
                // Send the request
                xhr.send("herbId=" + herbId);
            }
        }
        