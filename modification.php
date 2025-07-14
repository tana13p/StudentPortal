<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST["role"];
    $registration_type = $_POST["registration_type"];
    $id = $_POST["id"];

    if ($role == "student") {
        $sql = "SELECT Registration_ID FROM students WHERE Registration_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Registration_ID = $row["Registration_ID"];
        $Full_Name = !empty($_POST["Full_Name"]) ? $_POST["Full_Name"] : null;
        $Email_Address = !empty($_POST["Email_Address"]) ? $_POST["Email_Address"] : null;
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
    
        $sql = "UPDATE students SET ";
        $params = [];
        $paramTypes = "";
    
        if (!empty($Full_Name)) {
            $sql .= "Full_Name = ?, ";
            $params[] = $Full_Name;
            $paramTypes .= "s";
        }
        if (!empty($Email_Address)) {
            $sql .= "Email_Address = ?, ";
            $params[] = $Email_Address;
            $paramTypes .= "s";
        }
        if (!empty($Date_of_Admission)) {
            $sql .= "Date_of_Admission = STR_TO_DATE(?, '%d-%m-%Y'), ";
            $params[] = $Date_of_Admission;
            $paramTypes .= "s";
        }
        if (!empty($Admission_Fees_Paid)) {
            $sql .= "Admission_Fees_Paid = ?, ";
            $params[] = $Admission_Fees_Paid;
            $paramTypes .= "s";
        }
        if (!empty($First_Name)) {
            $sql .= "First_Name = ?, ";
            $params[] = $First_Name;
            $paramTypes .= "s";
        }
        if (!empty($Middle_Name)) {
            $sql .= "Middle_Name = ?, ";
            $params[] = $Middle_Name;
            $paramTypes .= "s";
        }
        if (!empty($SURNAME)) {
            $sql .= "SURNAME = ?, ";
            $params[] = $SURNAME;
            $paramTypes .= "s";
        }
        if (!empty($Father_Name)) {
            $sql .= "Father_Name = ?, ";
            $params[] = $Father_Name;
            $paramTypes .= "s";
        }
        if (!empty($Mother_Name)) {
            $sql .= "Mother_Name = ?, ";
            $params[] = $Mother_Name;
            $paramTypes .= "s";
        }
        if (!empty($Email_ID)) {
            $sql .= "Email_ID = ?, ";
            $params[] = $Email_ID;
            $paramTypes .= "s";
        }
        if (!empty($Contact_Number)) {
            $sql .= "Contact_Number = ?, ";
            $params[] = $Contact_Number;
            $paramTypes .= "s";
        }
        if (!empty($Gender)) {
            $sql .= "Gender = ?, ";
            $params[] = $Gender;
            $paramTypes .= "s";
        }
        if (!empty($Date_of_Birth)) {
            $sql .= "Date_of_Birth = STR_TO_DATE(?, '%d-%m-%Y'), ";
            $params[] = $Date_of_Birth;
            $paramTypes .= "s";
        }
        if (!empty($Category)) {
            $sql .= "Category = ?, ";
            $params[] = $Category;
            $paramTypes .= "s";
        }
        if (!empty($Blood_Group)) {
            $sql .= "Blood_Group = ?, ";
            $params[] = $Blood_Group;
            $paramTypes .= "s";
        }
        if (!empty($Physically_Handicap)) {
            $sql .= "Physically_Handicap = ?, ";
            $params[] = $Physically_Handicap;
            $paramTypes .= "s";
        }
        if (!empty($Handicap_Type)) {
            $sql .= "Handicap_Type = ?, ";
            $params[] = $Handicap_Type;
            $paramTypes .= "s";
        }
        
        $sql = rtrim($sql, ", ");
        $sql .= " WHERE Registration_ID = ?";
        $params[] = $Registration_ID;
        $paramTypes .= "s";
    
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param($paramTypes, ...$params);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                echo "<div style='text-align: center;'>";
                echo "Student information updated successfully!";
                echo "</div>";
            } else {
                echo "<div style='text-align: center;'>";
                echo "Error: Unable to update student information.";
                echo "</div>";
            }
        $stmt->close();
    }
    else {
        echo "<div style='text-align: center;'>";
        echo "Error: Unable to prepare SQL statement.";
        echo "</div>";
    }
}
else {
    echo "<div style='text-align: center;'>";
    echo "Debug: SQL Query: " . $sql . " with ID: " . $id;
    echo "<br>";
    echo "Error: Student not found.";
    echo "</div>";
}
}

elseif ($role == "Professor") {
    $sql = "SELECT ProfessorID FROM Professors WHERE ProfessorID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ProfessorID = $row["ProfessorID"];

    $Name = !empty($_POST["Name"]) ? $_POST["Name"] : null;
    $Department = !empty($_POST["Department"]) ? $_POST["Department"] : null;
    $Designation = !empty($_POST["Designation"]) ? $_POST["Designation"] : null;
    $Email1 = !empty($_POST["Email1"]) ? $_POST["Email1"] : null;
    $Email2 = !empty($_POST["Email2"]) ? $_POST["Email2"] : null;
    $Phone1 = !empty($_POST["Phone1"]) ? $_POST["Phone1"] : null;
    $Phone2 = !empty($_POST["Phone2"]) ? $_POST["Phone2"] : null;
    $Qualification = !empty($_POST["Qualification"]) ? $_POST["Qualification"] : null;
    $Experience = !empty($_POST["Experience"]) ? $_POST["Experience"] : null;

    $sql = "UPDATE Professors SET ";
    $params = [];
    $paramTypes = "";

    if (!empty($Name)) {
        $sql .= "Name = ?, ";
        $params[] = $Name;
        $paramTypes .= "s";
    }
    
    if (!empty($Department)) {
        $sql .= "Department = ?, ";
        $params[] = $Department;
        $paramTypes .= "s";
    }
    if (!empty($Designation)) {
        $sql .= "Designation = ?, ";
        $params[] = $Designation;
        $paramTypes .= "s";
    }
    if (!empty($Email1)) {
        $sql .= "Email1 = ?, ";
        $params[] = $Email1;
        $paramTypes .= "s";
    }
    if (!empty($Email2)) {
        $sql .= "Email2 = ?, ";
        $params[] = $Email2;
        $paramTypes .= "s";
    }
    if (!empty($Phone1)) {
        $sql .= "Phone1 = ?, ";
        $params[] = $Phone1;
        $paramTypes .= "s";
    }
    if (!empty($Phone2)) {
        $sql .= "Phone2 = ?, ";
        $params[] = $Phone2;
        $paramTypes .= "s";
    }
    if (!empty($Qualification)) {
        $sql .= "Qualification = ?, ";
        $params[] = $Qualification;
        $paramTypes .= "s";
    }
    if (!empty($Experience)) {
        $sql .= "Experience = ?, ";
        $params[] = $Experience;
        $paramTypes .= "s";
    }

    $sql = rtrim($sql, ", ");
    $sql .= " WHERE ProfessorID = ?";

    $params[] = $ProfessorID;
    $paramTypes .= "s";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param($paramTypes, ...$params);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<div style='text-align: center;'>";
            echo "Professor information updated successfully!";
            echo "</div>";
        } else {
            echo "<div style='text-align: center;'>";
            echo "Error: Unable to update Professor information.";
            echo "</div>";
        }
 $stmt->close();   
}
else {
    echo "<div style='text-align: center;'>";
    echo "Error: Unable to prepare SQL statement.";
    echo "</div>";
}
}
else {
    echo "<div style='text-align: center;'>";
    echo "Debug: SQL Query: " . $sql . " with ID: " . $id;
    echo "<br>";
    echo "Error: Professor not found.";
    echo "</div>";
}
}
}
$conn->close();
?>
