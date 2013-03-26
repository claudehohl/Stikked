<?php $this->load->view('defaults/header'); ?>
    <?php
        $message = $this->db_session->flashdata('login_error');
        if ($message){
            echo '<div class="login_error">';
            echo $message;
            echo '</div>';
        }
    ?>
    <div class="login">
      <?php echo form_fieldset(); ?>
      <?php echo validation_errors();?>

      <?php echo form_open('auth/login', array('id' => 'loginform', 'class' => 'form_wrapper')); ?>
      <?php
      
      $table = array(array('', ''),
          array(form_label('Username', 'username'),
                form_input(array('name' => 'username', 'id' => 'username',
                     'class' => 'formfield'))),
          array(form_label('Password', 'password'),
                form_password(array('name' => 'password', 'id' => 'password',
                     'class' => 'formfield'))));
          echo $this->table->generate($table);
      ?>
      <?php echo form_label('&nbsp;', 'Login'); ?>
      <?php echo form_submit('login', 'Login'); ?>
      <?php echo form_close(); ?>
      <?php echo form_fieldset_close(); ?>
    </div>
      
<?php $this->load->view('defaults/footer'); ?>
