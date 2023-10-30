<form action="">
    <div class="item_group searchgroup">
        <div class="item">
            <label for="search"><?php echo lang('paste_search'); ?>
            </label>
            <input type="text" name="search" value="<?php
$search = $this->input->get('search');
echo $search ? str_replace('"', '&quot;', $search) : '';
?>" id="search" maxlength="100" tabindex="1" />
        </div>
    </div>
</form>
