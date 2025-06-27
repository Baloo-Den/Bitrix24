<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quick start. Local server-side application with UI</title>
</head>
<body>
	<div id="auth-data">OAuth 2.0 data from REQUEST:
		<pre><?php
			print_r($_REQUEST);
			?>
		</pre>
	</div>
	<div id="name">
		<?php

        echo "Где";
		require_once (__DIR__.'/crestcurrent.php');

		//$result = CRest::call('user.current');
		$result = CRestCurrent::call('user.current');

        echo '<pre>';
        print_r($result);
        echo '</pre>';


        $method = 'crm.contact.get';

        $params = [
            'id' => 2,
        ];

        $result = CRest::call(
            'crm.contact.get',
            [
                'id' => 2,
            ]
        );

        print_r($result);






		echo $result['result']['NAME'].' '.$result['result']['LAST_NAME'];
		?>
	</div>
</body>
</html>