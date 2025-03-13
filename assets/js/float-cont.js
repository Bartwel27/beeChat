let showbtn = document.querySelector(".add-float-button");
   let showcont = document.querySelector(".add-float-container");
   let count = 0;
   
    showbtn.onclick = function(){      
      if (count == 0) {
        showcont.style.display="block"
        console.log("addContVisible")
        count++
      } else {
        showcont.style.display="none"
        console.log("addContVisible")
        count--
      }
    }