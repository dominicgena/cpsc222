<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Exam 2 Part 2</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
  </head>
  <body>
    <h1>Student Profile Builder</h1>
    <?php
      if($_GET['error'] == "incomplete") {
        echo "<h3>Please make sure you finish the form before submitting.</h3>";
      }
    ?>
    <div id="form-container" style="display: flex; width: 50vw;">
      <form method="post" action="/php/final/form.php">
        <table>
          <tr>
            <td><label for="first-name">First name</label></td><td><input name="fname" type="text" id="first-name"></td>
          </tr>
          <tr>
            <td><label for="last-name">Last name</label></td><td><input name="lname" type="text" id="last-name"></td>
          </tr>
          <tr>
            <td><label for="major">Major</label></td><td><input name="major" type="text" id="major"></td>
          </tr>
          <tr>
            <td><label for="favorite-language">Favorite Programming Language</label></td><td><input name="flang" type="text" id="favorite-language"></td>
          </tr>
          <tr>
            <td><label for="hobby">One hobby</label></td><td><input name="hobby" type="text" id="hobby"></td>
          </tr>
          <tr><td><input type="submit"></td></tr>
        </table>
      </form>
  </body>
</html>