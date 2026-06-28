<?php
function safeReload($success): void {
	if ($success != null)
    	header("Location: {$_SERVER['PHP_SELF']}?success=$success");
	else
		header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

function redirect($path): void {
    header("Location: $path");
    exit();
}

function operatorSelector($name): void {
	echo "
	<select name='$name' class='appearance-none border rounded-md text-center p-0.5 hover:bg-black/10'>
		<option>=</option>
		<option>></option>
		<option>>=</option>
		<option><</option>
		<option><=</option>
	</select>";
}