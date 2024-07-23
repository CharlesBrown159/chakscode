
<form id="myForm" action="submit.php" method="post">
  <input type="text" name="data" />
  <button type="button" onclick="submitForm()">Submit</button>
</form>

<script>
  function submitForm() {
    var formData = new FormData(document.getElementById("myForm"));
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "submit.php", true);
    xhr.onload = function() {
      if (xhr.status == 200) {
        alert('Form submitted successfully!');
      } else {
        alert('Error submitting form. Please try again.');
      }
    };
    xhr.send(formData);
  }
</script>
