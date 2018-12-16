<?php $error = $this->session->getFlash('message'); ?>
<?php if ( !empty($error)) {?>
  <p><?php echo $error; ?></p>
<?php } ?>
<form action="<?php echo BASE_URL . '?page=login&action=login'; ?>" method="POST">
  <div>
    <label>Email</label>
    <input type="text" name="email" />
  </div>
  <div>
    <label>Password</label>
    <input type="password" name="password" />
  </div>

  <input type="submit" name="login" value="login">
</form>