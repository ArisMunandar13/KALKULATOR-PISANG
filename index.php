<?php
$currentValue = 0;

$input = [];


function getInputAsString($values){
	$o = "";
	foreach ($values as $value){
		$o .= $value;
	}
	return $o;
}


function calculateInput($userInput){
    // format user input
    $arr = [];
    $char = "";
    foreach ($userInput as $num){
        if(is_numeric($num) || $num == "."){
            $char .= $num;
        }else if(!is_numeric($num)){
            if(!empty($char)){
                $arr[] = $char;
                $char = "";
            }
            $arr[] = $num;
        }
    }
    if(!empty($char)){
        $arr[] = $char;
    }
    // calculate user input

    $current = 0;
    $action = null;
    for($i=0; $i<= count($arr)-1; $i++){
        if(is_numeric($arr[$i])){
            if($action){
                if($action == "+"){
                    $current = $current + $arr[$i];
                }
                if($action == "-"){
                    $current = $current - $arr[$i];
                }
                if($action == "x"){
                    $current = $current * $arr[$i];
                }
                if($action == "/"){
                    $current = $current / $arr[$i];
				}
				if($action == "%"){
                    $current = $current % $arr[$i];
				}
                $action = null;
            }else{
                if($current == 0){
                    $current = $arr[$i];
                }
            }
        }else{
            $action = $arr[$i];
        }
    }
    return $current;

}

$rep="";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['input'])){
        $input = json_decode($_POST['input']);
	}


    if(isset($_POST)){
		
        foreach ($_POST as $key=>$value){
			if($key == 'squareroot'){
				$currentValue = sqrt(floatval(getInputAsString($input)));
				$input = [];
				$input[] = $currentValue;
			 }
			 elseif($key == 'square'){
				$currentValue = pow(floatval(getInputAsString($input)),2);
				$input = [];
				$input[] = $currentValue;
			 }
            elseif($key == 'equal'){
               $currentValue = calculateInput($input);
               $input = [];
               $input[] = $currentValue;
            }elseif($key == "c"){
                $input = [];
                $currentValue = 0;
            }elseif($key == "back"){
                $lastPointer = count($input) -1;
                if(is_numeric($input[$lastPointer])){
                    array_pop($input);
                }
            }elseif($key != 'input'){
                $input[] = $value;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title>KALKULATOR PISANG</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

	<style>

		body {
			background-image: url(pisang.jpg);
			background-size: 150px;
		}

		div {
			width: 100%;
			background-color: yellow;
		}

		/*.op {
			 display: block;
			  width: 100%;
			  background-color: darkgrey;
		}*/

		.result {
			color: blue;
			background-color: whitesmoke;
			width: 100%;
		}

		/*.form-control {
			background-color: whitesmoke;
		}*/
	</style>
</head>
<body>

<main>
<h3>KALKULATOR PISANG</h3>
<div style="border: 1px solid #E0144C; border-radius: 5px; padding: 5px; display: inline-block">
    <form method="post" id="form">
	<input class="form-control, result" style="padding: 3px; margin: 0; min-height: 20px;" value="<?php echo getInputAsString($input);?>">
    <input class="form-control" type="hidden" name="input" value='<?php echo json_encode($input);?>'/>
	
    <table style="width:100%;">
        <tr>
            <td><input class="form-control text-warning" type="submit" name="c" value="C"/></td>
			<td><input class="form-control" type="submit" name="squareroot" value="√"/></td>
        </tr>
        <tr>
            <td><input class="form-control" type="submit" name="7" value="7"/></td>
            <td><input class="form-control" type="submit" name="8" value="8"/></td>
			<td><input class="form-control" type="submit" name="9" value="9"/></td>
			<td><input class="form-control bg-secondary text-light" type="submit" name="square" value="^"/></td>
        </tr>
        <tr>
            <td><input class="form-control" type="submit" name="4" value="4"/></td>
            <td><input class="form-control" type="submit" name="5" value="5"/></td>
            <td><input class="form-control" type="submit" name="6" value="6"/></td>        
            <td><input class="form-control bg-secondary text-light" type="submit" name="multiply" value="x"/></td>
        </tr>
        <tr>
            <td><input class="form-control" type="submit" name="1" value="1"/></td>
            <td><input class="form-control" type="submit" name="2" value="2"/></td>
            <td><input class="form-control" type="submit" name="3" value="3"/></td>
			<td><input class="form-control bg-secondary text-light" type="submit" name="minus" value="-"/></td>
        </tr>
        <tr>
            <!-- <td><button class="btn btn-primary" type="submit" name="plusminus" value="plusminus">&#177;</button></td> -->
            <td><input class="form-control" type="submit" name="zero" value="0"/></td>
            <td><input class="form-control" type="submit" name="." value="."/></td>
			<td><input class="form-control bg-danger text-light" type="submit" name="equal" value="="/></td>
			<td><input class="form-control bg-secondary text-light" type="submit" name="add" value="+"/></td>
        </tr>
    </table>
    </form>
</div>
</main>

</body>
</html>