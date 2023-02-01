let count = 0;
function disableButton() {
   count++;
   let button = document.getElementsByName("sendComment");
   if (count>1) {
      button[0].disabled = true;
   }


}
