<?php

function showMessage($message) {
    echo "
      <div id='message-box'>
        <p>$message</p>
      </div>
      ";
  
    echo "
      <script>
        setTimeout(function() {
          var messageBox = document.getElementById('message-box');
          if (messageBox) {
            messageBox.parentNode.removeChild(messageBox);
          }
        }, 3000);
      </script>
      ";
}

if(isset($_POST["message"])){
  showMessage($_POST["message"]);
}
?>