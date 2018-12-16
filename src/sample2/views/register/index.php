<?php $errors = $this->session->get('validation_errors'); ?>
<?php if ( !empty($errors)) {?>
  <p>Please check the following errors:</p>
  <ul>
    <li>
      <?php echo implode('</li><li>', array_values($errors)); ?>
    </li>
  </ul>
<?php } ?>
<form action="<?php echo BASE_URL . '?page=register&action=register'; ?>" method="POST">
  <div>
    <label>Email</label>
    <input type="text" name="email" value="<?php echo $this->input->old('email'); ?>"/>
  </div>
  <div>
    <label>First Name</label>
    <input type="text" name="firstname" value="<?php echo $this->input->old('firstname'); ?>"/>
  </div>
  <div>
    <label>Last Name</label>
    <input type="text" name="lastname" value="<?php echo $this->input->old('lastname'); ?>"/>
  </div>
  <div>
    <label>Password</label>
    <input type="password" name="password" />
  </div>
  <div>
    <label>Confirm Password</label>
    <input type="password" name="password_confirm" />
  </div>
  <input type="submit" name="register" value="register">
</form>