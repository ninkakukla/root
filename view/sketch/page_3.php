<div class='container'>
	<form class='form-inline' action='controller/functions.php' method='post' >
		<input type="hidden" name="register" value="registerform"/>
		<p> Add a frieand from another planet</p><br>
		<p> Please fill all the information</p><br><br>
		 <div class='form-group'>
    <label class='sr-only' for='exampleInputEmail3'>User name</label>
    <input type='text' name='registername' class='form-control' id='registuser' placeholder='User name'>
  </div>
  <div class='form-group'>
    <label class='sr-only' for='exampleInputPassword3'>Password</label>
    <input type='password' name='registerpassword' class='form-control' id='password' placeholder='Password'>
    
  </div>
	<div class='form-group'>
    <label class='sr-only' for='planet'>planet</label>
    <select class="form-control" name="planet">
  <option value="zongo">Zongo</option>
  <option value="urzo">Urzo</option>
  <option value="gorem">Gorem</option>
  <option value="morg">Morg</option>
  <option value="earth">Earth</option>
</select>
     <button type='submit' class='btn btn-default'>Rgister</button>
  </div>
	</form>

</div>