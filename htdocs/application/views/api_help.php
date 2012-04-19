<?php $this->load->view("defaults/header");?>

<div class="api">
	<h1>API</h1>
    <p class="explain border">Create pastes from the commandline</p>

	<h2>API URL</h2>
    <p class="explain"><code><?php echo site_url('api/create'); ?></code></p>

	<h2>Return values</h2>
    <p class="explain">
        On success, the API returns the paste URL in JSON format: <code>{"url":"<?php echo site_url('view/[pasteid]'); ?>"}</code><br />
        On error, the API returns the error message in JSON format: <code>{"error":"missing paste text"}</code>
    </p>

	<h2>POST parameters</h2>
    <p>&nbsp;</p>

	<code>text=[your paste text]</code>
    <p class="explain">The paste content. Required.</p>

	<code>title=[title]</code>
    <p class="explain">Title for the paste.</p>

	<code>name=[name]</code>
    <p class="explain">The author's name.</p>

	<code>private=1</code>
    <p class="explain">Make paste private.</p>

	<code>lang=[language]</code>
    <p class="explain">
        Use alternative syntax highlighting.<br />
        Possible values: <?php echo $languages; ?>
    </p>

	<code>expire=[minutes]</code>
    <p class="explain">Set paste expiration.</p>

	<code>reply=[pasteid]</code>
    <p class="explain">Reply to existing paste.</p>

	<h2>Examples</h2>
    <p>&nbsp;</p>

	<h3>Create paste</h3>
	<code>curl -d text='this is my text' <?php echo site_url('api/create'); ?></code>
    <p class="explain">Create a paste with the text 'this is my text'.</p>

	<h3>Create paste from a file</h3>
	<code>curl -d private=1 -d name=Herbert --data-urlencode text@/etc/passwd <?php echo site_url('api/create'); ?></code>
    <p class="explain">Create a private paste with the author 'Herbert' and the contents of '/etc/passwd'.</p>

	<h3>Create paste from a php file</h3>
	<code>curl -d lang=php --data-urlencode text@main.php <?php echo site_url('api/create'); ?></code>
    <p class="explain">Create a paste with PHP syntax highlighting.</p>

	<h3>Get paste ;-)</h3>
	<code>curl <?php echo site_url('view/raw/[pasteid]'); ?></code>
    <p class="explain">Display paste.</p>

</div>

<?php $this->load->view("defaults/footer");?>
