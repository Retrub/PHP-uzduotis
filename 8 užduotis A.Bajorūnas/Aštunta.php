<?php
	session_start();
	if(!isset($_SESSION['Studentai']))
	{
		$_SESSION['Studentai'] = array();
	}		
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Aštunta</title>
    <meta charset="utf-8">
</head>
<body>

<?php
$Klaida="";
function Sudauginti()
{
$num1=$num2=$Suma=0;

	if (isset($_POST['Pirmas_mygtukas'])) 
	{
		if (empty($_POST["firstNumber"]))
				{
					$Klaida = "Laukelis negali būti tuščias!";
				}
		else
		{
			   $num1 = test_input($_POST["firstNumber"]);
		}
		if (empty($_POST["secondNumber"]))
				{
					$Klaida= "Laukelis negali būti tuščias!";
				}
		else
		{
			  $num2 = test_input($_POST["secondNumber"]);
		}
	}
	
	if($num1<0 && $num2>0)
  {
	  $num1=-$num1;
	   $num2=-$num2;
	  for($i = 0; $i < $num1; $i++)
	  {
		  $Suma+=$num2;
	  }
  }
  else if($num1>0 && $num2>0)
  {
	  for ($i = 0; $i < $num1; $i++)
	  {
		  $Suma+=$num2;
	  }
  }
  else if($num1>0 && $num2<0)
  {
	  for ($i = 0; $i < $num1; $i++)
	  {
		  $Suma+=$num2;
	  }
  }
  else if($num1<0 && $num2<0)
  {
	  $num2=-$num2;
	  $num1=-$num1;
	  for ($i = 0; $i < $num1; $i++)
	  {
		  $Suma+=$num2;
	  }
  }
  else if($num1==0 && $num2==0)
  {
       $Suma=0;
  }
	echo "<br>";
	echo "Suma lygi: ".$Suma;
}
function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<h2>Mano pasinkimas: Sudarykite programą dviejų sveikųjų skaičių sandaugai rasti. Programoje sandaugos operacijos negali būti.</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
1st Number : <input type="text" name="firstNumber">
<span class="error"><?php echo $Klaida;?></span><br><br>

2nd Number: <input type="text" name="secondNumber">
<span class="error"><?php echo $Klaida;?></span><br><br>

<input type="submit" name="Pirmas_mygtukas" value="Sudauginti">  

</form>
<?php
if(isset($_POST['Pirmas_mygtukas']))				
			{
				Sudauginti();
			}
?>
<br><br>
<h3>"Mano pasirinkimas: Duotas studentų masyvas. 3 geriausiai besimokantiems studentams padidinti stipendiją po 20%."</h3>
<br>
<?php

class Studentas {
  public $vardas;
  public $pavarde;
  public $pazangumas;
  public $stipendija;

  function __construct($vardas,$pavarde,$pazangumas,$stipendija) {
    $this->vardas = $vardas; 
	 $this->pavarde = $pavarde; 
	 $this->pazangumas = $pazangumas; 
	 $this->stipendija = $stipendija; 
  }
}
$Error="";
$klaida = false;
$vardas=$pavarde="";
$pazangumas=$stipendija="";

if (isset($_POST['submit'])) 
	{
		if (empty($_POST["vardas"]))
				{
					$Error = "Laukelis negali būti tuščias!";
					$klaida = true;
				}
		else
		{
			$vardas = test_input($_POST["vardas"]);
		}
		
		if (empty($_POST["pavarde"]))
				{
					$Error = "Laukelis negali būti tuščias!";
					$klaida = true;
				}
		else
		{
			$pavarde = test_input($_POST["pavarde"]);
		}
		
		if (empty($_POST["pazangumas"]))
				{
					$Error = "Laukelis negali būti tuščias!";
					$klaida = true;
				}
		else
		{
			$pazangumas = test_input($_POST["pazangumas"]);
		}
		
		if (empty($_POST["stipendija"]))
				{
					$Error = "Laukelis negali būti tuščias!";
					$klaida = true;
				}
		else
		{
			$stipendija = test_input($_POST["stipendija"]);
		}
	}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
Vardas:<input type="text" name="vardas">
<span class="error"><?php echo $Error;?></span><br><br>
Pavarde: <input type="text" name="pavarde">
<span class="error"><?php echo $Error;?></span><br><br>
Pazangumas: <input type ="number" name = "pazangumas">
<span class="error"><?php echo $Error;?></span><br><br>
Stipendija: <input type ="number" name = "stipendija">
<span class="error"><?php echo $Error;?></span><br><br>
<input type="submit" name="submit" value="Pridėti">
</form>	
<br> 	
<br>
		<form method="post">
			<input type="submit" name="endsession" value="Išvalyti"/>
</form>
<br><br>
<h2> Duomenys:  </h2>

<?php	
			if (!$klaida)
			{
				$studentas = new Studentas($vardas, $pavarde, $pazangumas, $stipendija);
				
				$Kartojasi = false;
				foreach ($_SESSION['Studentai'] as $value) 
				{
					if (($studentas -> vardas == $value -> vardas) && ($studentas -> pavarde == $value -> pavarde) 
						&&($studentas -> pazangumas == $value -> pazangumas) && ($studentas -> stipendija == $value -> stipendija))
					{
						$Kartojasi = true;	
					}
				}
				if (!$Kartojasi)
				{
					array_push($_SESSION['Studentai'],$studentas);
				}
				
			}
			foreach ($_SESSION['Studentai'] as $value) 
			{
				echo $value -> vardas.str_repeat("&nbsp;", 5).$value -> pavarde.str_repeat("&nbsp;", 5).$value -> pazangumas.str_repeat("&nbsp;", 5).$value -> stipendija."<br>";
			}
?>
<h2> Rezultatai:  </h2>

<?php	
	function Rezultatai()
	{
		$Langas = "";
		$rez_Failas = "";
		$i=0;
		$Stipendijos_dydis=0;
		$Stud_sk = count($_SESSION['Studentai']);
			if ($Stud_sk>1)
			{
usort(($_SESSION['Studentai']),function($first,$second){
    return $first->pazangumas < $second->pazangumas;
});
					foreach ($_SESSION['Studentai'] as $value) 
			{
				$Stipendijos_dydis=0;
				$Stipendijos_dydis.=$value->stipendija;
				$Langas.= $value -> vardas.str_repeat("&nbsp;", 5).$value -> pavarde.str_repeat("&nbsp;", 5).$value -> pazangumas.str_repeat("&nbsp;", 5).$Stipendijos_dydis*(1.2)."<br>";
				$rez_Failas.= $value -> vardas."   ".$value -> pavarde."   ".$value -> pazangumas."   ".$Stipendijos_dydis*(1.2)."\n";
				$i++;
				if($i==3)
				{
					break;
				}
			}				
		echo "<p>".$Langas."</p>";
				
		$failas = fopen("rezultatai.txt", "w");			
		fwrite($failas, $rez_Failas);			
		fclose($failas);
	}
	}
?>


<?php		
            Rezultatai(); 
			if(isset($_POST['endsession'])) 
			{
				session_destroy();
				header("Refresh:0");
			}
?>
</body>
</html>