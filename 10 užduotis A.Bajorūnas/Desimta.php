<?php
	session_start();
	if(!isset($_SESSION['Studentai']))
	{
		$_SESSION['Studentai'] = array();
	}		
?>

<?php
function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Devinta</title>
    <meta charset="utf-8">
</head>
<body>
<h3>"Tekstiniame faile yra studentai. Sudaryti galimybę papildyti failą naujais studentais. Surasti kurių studentų pažymių vidurkiai patenka tarp X% geriausių."</h3>
<br>
<?php
class Studentas {
  public $vardas;
  public $pavarde;
  public $vidurkis;

  function __construct($vardas,$pavarde,$vidurkis) {
    $this->vardas = $vardas; 
	 $this->pavarde = $pavarde; 
	 $this->vidurkis = $vidurkis; 
  }
}
$Error="";
$klaida = false;
$vardas=$pavarde=$vidurkis="";

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
		
		if (empty($_POST["vidurkis"]))
				{
					$Error = "Laukelis negali būti tuščias!";
					$klaida = true;
				}
		else
		{
			$vidurkis = test_input($_POST["vidurkis"]);
		}
	}
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
Vardas:<input type="text" name="vardas">
<span class="error"><?php echo $Error;?></span><br><br>
Pavarde: <input type="text" name="pavarde">
<span class="error"><?php echo $Error;?></span><br><br>
Vidurkis: <input type ="number" name = "vidurkis">
<span class="error"><?php echo $Error;?></span><br><br>
<input type="submit" name="submit" value="Pridėti">
</form>	
<br>

<form action="#" method="post">
			<input type="submit" name="parodyti" value="Parodyti Duomenys"/>
</form>	

<br>
		<form action="#" method="post">
		Procentai: <input type ="number" name = "procentai"><br><br>
			<input type="submit" name="rasti" value="Surasti"/>
</form>

<br>
<form action="#" method="post">
			<input type="submit" name="nuskaito" value="Nuskaityti iš failo"/>
</form>

<br>
		<form method="post">
			<input type="submit" name="endsession" value="Išvalyti visus duomenys"/>
</form>

<br><br>
<h2> Duomenys:  </h2>

<?php	
if (isset($_POST['submit'])) 
{
			if (!$klaida)
			{
				$studentas = new Studentas($vardas, $pavarde, $vidurkis);
				
				$Kartojasi = false;
				foreach ($_SESSION['Studentai'] as $value) 
				{
					if (($studentas -> vardas == $value -> vardas) && ($studentas -> pavarde == $value -> pavarde) 
						&&($studentas -> vidurkis == $value -> vidurkis))
					{
						$Kartojasi = true;
					}
				}
				if (!$Kartojasi)
				{;
			        $failas = fopen("upload.json", "w");
					array_push($_SESSION['Studentai'],$studentas);
					$Kodas = json_encode($_SESSION['Studentai']);
		            file_put_contents("upload.json",$Kodas);
				}
				
			}	
}

if (isset($_POST['parodyti'])) 
{
	foreach ($_SESSION['Studentai'] as $value) 
			{
				echo $value -> vardas.str_repeat("&nbsp;", 5).$value -> pavarde.str_repeat("&nbsp;", 5).$value -> vidurkis.str_repeat("&nbsp;", 5)."<br>";
			}
}
	
if (isset($_POST['nuskaito'])) 
{
if(file_exists("upload.json")){
$data=file_get_contents("upload.json");
$obj = json_decode($data,true);
$total = count((array)$obj);
for($i=0;$i<$total;$i++)
{
$studentas =  new Studentas(
			$obj[$i]['vardas'],$obj[$i]['pavarde'],$obj[$i]['vidurkis']);
			$Kartojasi = false;
				foreach ($_SESSION['Studentai'] as $value) 
				{
					if (($studentas -> vardas == $value -> vardas) && ($studentas -> pavarde == $value -> pavarde) 
						&&($studentas -> vidurkis == $value -> vidurkis))
					{
						$Kartojasi = true;
					}
				}
				if (!$Kartojasi)
				{
					array_push($_SESSION['Studentai'],$studentas);
				}
}
}	
else
{
	echo "Tokio failo nepavyko rasti arba jis tusčias";
}
}
?>

<h2> Rezultatai:  </h2>

<?php
$Error="";
if (isset($_POST['rasti'])) 
{
	$procentas=0;
	if (empty($_POST["procentai"]))
				{
					$Error = "Laukelis negali būti tuščias!";
					$klaida = true;
				}
				else
				{
						$procentas = test_input($_POST["procentai"]);
				}
		$Langas = "";
		$i=0;
		$Stud_sk = count($_SESSION['Studentai']);
		$Kiekis=$procentas*$Stud_sk/100;
		$Kiekis=round($Kiekis);
			if ($Stud_sk>1)
			{
usort(($_SESSION['Studentai']),function($first,$second){
    return $first->vidurkis < $second->vidurkis;
});
					foreach ($_SESSION['Studentai'] as $value) 
					{
						$Langas.= $value -> vardas.str_repeat("&nbsp;", 5).$value -> pavarde.str_repeat("&nbsp;", 5).$value -> vidurkis.str_repeat("&nbsp;", 5)."<br>";
				$i++;
				if($i==$Kiekis)
				{
					echo "<p>".$Langas."</p>";
					break;
				}
				else if ($Kiekis==0)
				{
					break;
					$Langas="";
				}
			}		
	}
	}
?>

<?php		
			if(isset($_POST['endsession'])) 
			{
				session_unset();
				session_destroy();
				header("Refresh:0");
			}
?>

</body>
</html>