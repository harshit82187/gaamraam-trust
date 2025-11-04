document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("logoutButton").addEventListener("click", function () {
        console.log("Before Clearing Storage:", localStorage); 
        localStorage.clear();         
        console.log("All local storage cleared on logout.");
        console.log("After Clearing Storage:", localStorage); 
    });
});
