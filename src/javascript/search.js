var search = document.getElementById("search");

        search.addEventListener("keydown", function(event){
            if(event.key === "Enter"){
                searchData();
            }
        })

        function searchData(){
            window.location = 'loja.php?search='+search.value;
        }