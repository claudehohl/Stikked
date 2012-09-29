<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
      <title>Logout</title>
  </head>
  <body>
    <?php if($logged_in): ?>
      <p><?= $username ?> has been logged out.</p>
      <p>Thanks for visiting <?= $name ?></p>
    <?php else: ?>
      <p>You need to <?php echo anchor('/auth/login', 'login', ''); ?> before you log out...</p>
    <?php endif;?>
  </body>
</html>
