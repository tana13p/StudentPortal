<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registrationType = $_POST["registration_type"];
    $role = $_POST["role"];
    $Registration_ID = $_POST["id"];

    if ($registrationType == "new" && $role == "student") {
        $Full_Name = $_POST["Full_Name"];
        $Email_Address =  $_POST["Email_Address"];
        $Date_of_Admission = !empty($_POST["Date_of_Admission"]) ? $_POST["Date_of_Admission"] : null;
        $Admission_Fees_Paid = !empty($_POST["Admission_Fees_Paid"]) ? $_POST["Admission_Fees_Paid"] : null;
        $First_Name = !empty($_POST["First_Name"]) ? $_POST["First_Name"] : null;
        $Middle_Name = !empty($_POST["Middle_Name"]) ? $_POST["Middle_Name"] : null;
        $SURNAME = !empty($_POST["SURNAME"]) ? $_POST["SURNAME"] : null;
        $Father_Name = !empty($_POST["Father_Name"]) ? $_POST["Father_Name"] : null;
        $Mother_Name = !empty($_POST["Mother_Name"]) ? $_POST["Mother_Name"] : null;
        $Email_ID = !empty($_POST["Email_ID"]) ? $_POST["Email_ID"] : null;
        $Contact_Number = !empty($_POST["Contact_Number"]) ? $_POST["Contact_Number"] : null;
        $Gender = !empty($_POST["Gender"]) ? $_POST["Gender"] : null;
        $Date_of_Birth = !empty($_POST["Date_of_Birth"]) ? $_POST["Date_of_Birth"] : null;
        $Category = !empty($_POST["Category"]) ? $_POST["Category"] : null;
        $Blood_Group = !empty($_POST["Blood_Group"]) ? $_POST["Blood_Group"] : null;
        $Physically_Handicap = !empty($_POST["Physically_Handicap"]) ? $_POST["Physically_Handicap"] : null;
        $Handicap_Type = !empty($_POST["Handicap_Type"]) ? $_POST["Handicap_Type"] : null;

        $sql = "INSERT INTO students (Registration_ID, Full_Name, Email_Address, Date_of_Admission, Admission_Fees_Paid,
        First_Name, Middle_Name, SURNAME, Father_Name, Mother_Name, Email_ID, Contact_Number,
        Gender, Date_of_Birth, Category, Blood_Group, Physically_Handicap, Handicap_Type)
        VALUES (?, ?, ?, STR_TO_DATE(?, '%d-%m-%Y'), ?, ?, ?, ?, ?, ?, ?, ?, ?, STR_TO_DATE(?, '%d-%m-%Y'), ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssssssssssssssss", $Registration_ID, $Full_Name, $Email_Address, $Date_of_Admission,
            $Admission_Fees_Paid, $First_Name, $Middle_Name, $SURNAME, $Father_Name, $Mother_Name,
            $Email_ID, $Contact_Number, $Gender, $Date_of_Birth, $Category,
            $Blood_Group, $Physically_Handicap, $Handicap_Type);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "<div style='text-align: center;'>";
                echo "New student registered successfully!";
                echo "</div>";
            } else {
                echo "<div style='text-align: center;'>";
                echo "Error: Unable to register new student.";
                echo "</div>";
            }
            $stmt->close();
        } else {
            echo "<div style='text-align: center;'>";
            echo "Error: Unable to prepare SQL statement.";
            echo "</div>";
        }
    }
}

$conn->close();
?>
