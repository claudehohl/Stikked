<form action="">
    <div class="item_group searchgroup">
        <div class="item">
            <label for="search"><?php echo lang('paste_search'); ?>
            </label>
            <input type="text" name="search" value="<?php echo str_replace('"', '&quot;', $this->input->get('search')); ?>" id="search" maxlength="100" tabindex="1" />
        </div>
    </div>
</form>
