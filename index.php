<!DOCTYPE html>
<html lang="en">
<!--
MD5 Hash Decryptor Tool by BML WEB
https://www.bmlweb.net/
-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MD5 Hash Decryptor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
<style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #1a1a1a, #000000);
            color: #fff;
            font-family: 'Courier New', Courier, monospace;
        }

        .card {
            background-color: rgba(0, 0, 0, 0.7);
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
			box-shadow: 0 0 10px 0 red;
            animation: heartbeat 1.5s infinite alternate;
        }
	
        @keyframes heartbeat {
            from {
                transform: scale(1);
            }
            to {
                transform: scale(1.05);
            }
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.5);
        }

        .form-label {
            color: red;
        }

        .btn-success {
            background-color: #4CAF50;
            border-color: #4CAF50;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<!--
MD5 Hash Decryptor Tool by BML WEB
https://www.bmlweb.net/
-->
<?php
if(isset($_REQUEST["user_hash"])) {
	if(!empty($_REQUEST["user_hash"])) {
	function formatSize($size) {
		$units = array('B', 'KB', 'MB', 'GB', 'TB');
		$i = 0;
		while ($size >= 1024 && $i < count($units) - 1) {
			$size /= 1024;
			$i++;
		}
		return round($size, 2) . ' ' . $units[$i];
	}


    $start_time = microtime(true);

    $user_hash = $_REQUEST["user_hash"];
	$pwfile = "pwlist_small.txt";
	$pwfs = filesize($pwfile);
	$pwfilesize = formatSize($pwfs);
	
    $pwlist = file($pwfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $total_words = count($pwlist);
    
    foreach ($pwlist as $index => $password) {
        $current_word_index = $index + 1;
        $hashed_password = md5($password);
        
        if ($hashed_password === $user_hash) {
            $end_time = microtime(true);
            $execution_time = round($end_time - $start_time, 4);
            echo '<div class="container">';
			echo '<div class="col-md-8 mx-auto">';
            echo '<div class="card">';
            echo '<div class="card-body" id="result" style="display: none;">';
			echo '<input type="hidden" id="foundpw" value="'.$password.'">';
            echo '<div class="alert alert-success" role="alert"><i class="fa-solid fa-fire"></i> Chosen AttackForce File: <strong>'.$pwfile.'</strong> ~ Size: <strong>'.$pwfilesize.'</strong><br><i class="fas fa-check-circle"></i> Password Found: [ <strong>' . $password . '</strong> <button type="button" class="btn" id="copyPasswordBtn"><i class="fas fa-copy"></i></button> ] (Word ' . $current_word_index . '/' . $total_words . ')<br><i class="fas fa-code"></i>  Hash: <strong>'.$user_hash.'</strong></div>';
            echo '<div class="alert alert-info" role="alert"><i class="fas fa-clock"></i> Time Taken: ' . $execution_time . ' seconds</div>';
            echo '<button type="button" class="btn btn-primary" onclick="location.href=\''. $_SERVER['REQUEST_URI'] .'\'"><i class="fas fa-arrow-up"></i> Go Back</button>';
            echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
            echo '<script>
					$(document).ready(function() {
						$("#copyPasswordBtn").click(function() {
							var password = $("#foundpw").val();
							var tempTextarea = $("<textarea>");
							tempTextarea.val(password);
							$("body").append(tempTextarea);
							tempTextarea.select();
							document.execCommand("copy");
							tempTextarea.remove();
							alert("Password copied to clipboard!");
						});
						$("#result").show("slow");
					});
					</script>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            exit;
        }
    }
    
    echo '<div class="container">';
	echo '<div class="col-md-8 mx-auto">';
    echo '<div class="card">';
    echo '<div class="card-body">';
    echo '<div class="alert alert-danger" role="alert"><i class="fas fa-times-circle"></i> Password not found!</div>';
    echo '<button type="button" class="btn btn-primary" onclick="location.href=\''. $_SERVER['REQUEST_URI'] .'\'"><i class="fas fa-arrow-up"></i>  Go Back</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    exit;
	} else {
		$msg = '<p class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> Please enter hash to decrypt!</p>';
	}
}
?>

<div class="container">
	<div class="col-md-8 mx-auto">
		<div class="card">
			<div class="card-body">
				<h1 class="card-title text-center text-danger mb-4">MD5 Hash Decryptor</h1>
				<?php if(isset($msg)) { echo $msg; } ?>
				<form id="hashForm" method="post" style="display: none;">
					<div class="mb-3">
						<label for="userHash" class="form-label">Enter MD5 Hash:</label>
						<input type="text" class="form-control" id="userHash" name="user_hash" required>
					</div>
					<button type="submit" class="btn btn-success"><i class="fa-solid fa-masks-theater"></i> Decrypt</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function() {
    $('#hashForm').show("slow");
});
</script>
<!--
MD5 Hash Decryptor Tool by BML WEB
https://www.bmlweb.net/
-->
</body>
<!--
MD5 Hash Decryptor Tool by BML WEB
https://www.bmlweb.net/
-->
</html>
