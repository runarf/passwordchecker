<?php

include 'YamlReader.php';

class PasswordChecker
{
  public function __construct($dbloc, $dbport, $dbname, $dbuser, $dbpass, $pwRulesFile)
  {
    $this->dbloc = $dbloc;
    $this->dbport = $dbport;
    $this->dbname = $dbname;
    $this->dbuser = $dbuser;
    $this->dbpass = $dbpass;
    $this->pwRulesFile = $pwRulesFile;

    print("Created password checker!\n");
  }

  private function updatePasswords($conn, $pwRules)
  {
    $selectRowSql = 'SELECT password FROM passwords';
    $updateRowSql = 'UPDATE passwords SET valid=1 WHERE id=';

    $row = $conn->query($selectRowSql);
    if(! $row) {
      die('Could not get data: ' . mysqli_error());
    }
    $row->data_seek(0);

    $rowNum = 1;
    while ($rowValues = $row->fetch_assoc()) {
      $validPw = true;
      printf($rowValues['password'] . "\n");
      foreach($pwRules as $pwRule) {
        $regex = '/'. $pwRule['regex'] .'/';
        if (! preg_match($regex, $rowValues['password'])) {
          print($pwRule['error'] . "\n");
          $validPw = false;
        }
      }
      if ($validPw) {
        print("Password is valid!\n");
        $conn->query($updateRowSql . $rowNum);
      } else {
        print("__Password is not valid__\n");
      }
      print("\n");
      $rowNum++;
    }
  }

  public function checkPasswords()
  {
    $pwRules = YamlReader::readYaml($this->pwRulesFile);

    $dbconn = $this->dbloc . ':' . $this->dbport;
    print("Connecting to $dbconn with $this->dbuser\n");
    $conn = new mysqli($dbconn, $this->dbuser, $this->dbpass, $this->dbname);

    if(! $conn) {
      die('Could not connect: ' . mysqli_error());
    }

    $this->updatePasswords($conn, $pwRules);

    $conn->close();
  }
}

if ($argc < 6){
  die('use: php ' . $argv[0] . " dbserverip dbserverport dbname dbusername dbpassword pwrulesfile\n");
}

printf("Got input: \ndatabaseip: %s
databaseport: %s \ndatabasetable: %s
databaseuser: %s \ndatabasepassword: %s
passwordRulesFile: %s \n",
$argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6]);

$passChecker = new PasswordChecker($argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6]);
$passChecker->checkPasswords();
