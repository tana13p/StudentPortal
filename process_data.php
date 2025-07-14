<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registrationType = $_POST["registration_type"];
    $role = $_POST["role"];
    $id = $_POST["id"];

    if ($registrationType == "existing") {
        if ($role == "student") {
            $tableName = "students";
            $sql = "SELECT * FROM studentinfo WHERE Registration_ID = '$id'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<h2 style='text-align: center;'>Student Information</h2>";
                    echo "<div style='overflow-x: auto;'>";
                    echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
                    $cellsPerRow = 4;
                    $cellCount = 0;
                    while ($row = $result->fetch_assoc()) {
                        if ($cellCount % $cellsPerRow === 0) {
                            echo "<tr>";
                        }
                        foreach ($row as $key => $value) {
                        if ($value !== null) {
                            echo "<td style='padding: 10px; border: 1px solid #ddd;'><b>$key</b></td>";
                            echo "<td style='padding: 10px; border: 1px solid #ddd;'>$value</td>";
                            echo "</tr>";
                            $cellCount++;
            
                            if ($cellCount % $cellsPerRow === 0) {
                                echo "</tr><tr>";
                            }
                        }
                    }
                }
                    if ($cellCount % $cellsPerRow !== 0) {
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                    echo "<br>";}

                    $sql = "SELECT * FROM admissiondetails WHERE Registration_ID = '$id'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<h2 style='text-align: center;'>Admission Details</h2>";
                    echo "<div style='overflow-x: auto;'>";
                    echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
                    $cellsPerRow = 4;
                    $cellCount = 0;
                    while ($row = $result->fetch_assoc()) {
                        if ($cellCount % $cellsPerRow === 0) {
                            echo "<tr>";
                        }
                        foreach ($row as $key => $value) {
                        if ($value !== null) {
                            echo "<td style='padding: 10px; border: 1px solid #ddd;'><b>$key</b></td>";
                            echo "<td style='padding: 10px; border: 1px solid #ddd;'>$value</td>";
                            echo "</tr>";
                            $cellCount++;
                            if ($cellCount % $cellsPerRow === 0) {
                                echo "</tr><tr>";
                            }
                        }
                    }
                }
                    if ($cellCount % $cellsPerRow !== 0) {
                        echo "</tr>";
                    }
            
                    echo "</table>";
                    echo "</div>";
                    echo "<br>";}

                    $sql = "SELECT * FROM personaldetails WHERE Registration_ID = '$id'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<h2 style='text-align: center;'>Personal Details</h2>";
                    echo "<div style='overflow-x: auto;'>";
                    echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
                    
                    $cellsPerRow = 4;
                    $cellCount = 0;
            
                    while ($row = $result->fetch_assoc()) {
                        if ($cellCount % $cellsPerRow === 0) {
                            echo "<tr>";
                        }
            
                        foreach ($row as $key => $value) {
                        if ($value !== null) {
                            echo "<td style='padding: 10px; border: 1px solid #ddd;'><b>$key</b></td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>$value</td>";
                    echo "</tr>";
                            $cellCount++;
            
                            if ($cellCount % $cellsPerRow === 0) {
                                echo "</tr><tr>";
                            }
                        }
                    }
                }
                    if ($cellCount % $cellsPerRow !== 0) {
                        echo "</tr>";
                    }
            
                    echo "</table>";
                    echo "</div>";
                    echo "<br>";
                }
            }  
                    $sqlCourses = "SELECT DISTINCT c.Course_ID, c.Academic_Department, c.Programme
                    FROM student_courses pc
                    JOIN course c ON pc.course_id = c.Course_ID
                    WHERE pc.registration_id = '$id'";

     $resultCourses = $conn->query($sqlCourses);

     if ($resultCourses->num_rows > 0) {
         echo "<h2 style='text-align: center;'>Courses for Student ID: $id</h2>";
         echo "<div style='overflow-x: auto;'>";
         echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
         echo "<tr><th style='padding: 10px; border: 1px solid #ddd;'>Course ID</th><th style='padding: 10px; border: 1px solid #ddd;'>Academic Department</th><th style='padding: 10px; border: 1px solid #ddd;'>Programme</th></tr>";

         while ($row = $resultCourses->fetch_assoc()) {
             echo "<tr>";
             echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["Course_ID"] . "</td>";
             echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["Academic_Department"] . "</td>";
             echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["Programme"] . "</td>";
             echo "</tr>";
         }

         echo "</table>";
         echo "</div>";
         echo "<br>";

     } else {
        echo "<div style='text-align: center;'>";
         echo "No courses found for Student ID: $id\n";
         echo "</div>";
         echo "<br>";

     }         

     $sqlgrade = "SELECT * FROM gradelist WHERE registration_number = '$id'";

     $resultGrade = $conn->query($sqlgrade);

     if ($resultGrade->num_rows > 0) {
         echo "<div style='overflow-x: auto;'>";
         echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
         echo "<tr><th style='padding: 10px; border: 1px solid #ddd;'>Grade</th>";

         while ($row = $resultGrade->fetch_assoc()) {
             echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["finalgrade"] . "</td>";
             echo "</tr>";
         }

         echo "</table>";
         echo "</div>";
     } else {
        echo "<div style='text-align: center;'>";
         echo "No grade found for Student ID: $id\n";
         echo "</div>";
         echo "<br>";

     }         

        $sql = "SELECT p.ProfessorID, p.Name AS ProfessorName
        FROM student_courses sc
        JOIN course c ON sc.course_id = c.Course_ID
        JOIN professor_courses pc ON c.Course_ID = pc.Course_ID
        JOIN Professors p ON pc.professor_id = p.ProfessorID
        WHERE sc.registration_id = '$id'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2 style='text-align: center;'>Professors for Student ID: $id</h2>";
    echo "<div style='overflow-x: auto;'>";
    echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
    echo "<tr><th style='padding: 10px; border: 1px solid #ddd;'>Professor ID</th><th style='padding: 10px; border: 1px solid #ddd;'>Professor Name</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["ProfessorID"] . "</td>";
        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["ProfessorName"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";

} else {
    echo "<div style='text-align: center;'>";
    echo "<p>No professors found for Student ID: $id\n</p>";
    echo "</div>";
    echo "<br>";

}

echo "<div style='overflow-x: auto;'>";
echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
echo "<tr>";
echo "<td style='border: 0px solid #ddd; text-align: center;'>";

echo "<form style='display: inline-block;' method='post' action='update_user.php'>";
echo "<input type='hidden' name='role' value='$role'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='submit' name='update' value='UPDATE' style=' background-color: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer;'>";
echo "</form>";
echo "</td>";

echo "<td style='border: 0px solid #ddd; text-align: center;'>";
echo "<form style='display: inline-block;' method='post' action='print.php'>";
echo "<input type='hidden' name='role' value='$role'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='submit' name='print' value='PRINT' style=' background-color: #0000FF; color: #fff; border: none; border-radius: 4px; cursor: pointer;'>";
echo "</form>";
echo "</td>";


echo "<td style='border: 0px solid #ddd; text-align: center;'>";
echo "<form style='display: inline-block;' method='post' action='graph2.php'>";
echo "<input type='hidden' name='role' value='$role'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='submit' name='visualise' value='VISUALISE' style=' background-color: #0000FF; color: #fff; border: none; border-radius: 4px; cursor: pointer;'>";
echo "</form>";
echo "</td>";

echo "<td style='border: 0px solid #ddd; text-align: center;'>";
echo "<form  style='display: inline-block;' method='post' action='delete_user.php' onsubmit='return confirm(\"Are you sure you want to delete this user?\");'>";
echo "<input type='hidden' name='role' value='$role'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='submit' name='delete' value='DELETE' style=' background-color: #dc3545; color: #fff; border: none; border-radius: 4px; cursor: pointer;'>";
echo "</form>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</div>";
}
                else {
                    echo "<div style='text-align: center;'>";
                    echo "No students found for Student ID: $id";
                    echo "</div>";
                }
            }
}


    elseif ($role == "Professor") {
    $tableName = "Professors";
    $sql = "SELECT * FROM $tableName WHERE ProfessorID = '$id'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<h2 style='text-align: center;'>User Information</h2>";
            echo "<div style='overflow-x: auto;'>";
            echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
            $cellsPerRow = 6;
        $cellCount = 0;
        while ($row = $result->fetch_assoc()) {
            if ($cellCount % $cellsPerRow === 0) {
                echo "<tr>";
            }
foreach ($row as $key => $value) {
if ($value !== null) {
    echo "<td style='padding: 10px; border: 1px solid #ddd;'><b>$key</b></td>";
echo "<td style='padding: 10px; border: 1px solid #ddd;'>$value</td>";
echo "</tr>";
    $cellCount++;
    if ($cellCount % $cellsPerRow === 0) {
        echo "</tr><tr>";
    }
}
}
    }
        if ($cellCount % $cellsPerRow !== 0) {
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
            $sqlCourses = "SELECT DISTINCT c.Course_ID, c.Academic_Department, c.Programme
                           FROM professor_courses pc
                           JOIN course c ON pc.Course_ID = c.Course_ID
                           WHERE pc.professor_id = '$id'";

            $resultCourses = $conn->query($sqlCourses);
            if ($resultCourses->num_rows > 0) {
                echo "<h2 style='text-align: center;'>Courses Taught by Professor ID: $id</h2>";
                echo "<div style='overflow-x: auto;'>";
                echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
                echo "<tr><th style='padding: 10px; border: 1px solid #ddd;'>Course ID</th><th style='padding: 10px; border: 1px solid #ddd;'>Academic Department</th><th style='padding: 10px; border: 1px solid #ddd;'>Programme</th></tr>";
                while ($row = $resultCourses->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["Course_ID"] . "</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["Academic_Department"] . "</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["Programme"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            } else {
                echo "<div style='text-align: center;'>";
                echo "No courses found for Professor ID: $id";
                echo "</div>";
            }
                $sqlStudents = "SELECT s.Registration_ID, s.First_Name, s.SURNAME
                                FROM student_courses sc
                                JOIN students s ON sc.Registration_ID = s.Registration_ID
                                JOIN course c ON sc.Course_ID = c.Course_ID
                                JOIN professor_courses pc ON c.Course_ID = pc.Course_ID
                                WHERE pc.professor_id = '$id'";

                $resultStudents = $conn->query($sqlStudents);
                if ($resultStudents->num_rows > 0) {
                    echo "<h2 style='text-align: center;'>Students Enrolled in Courses Taught by Professor ID: $id</h2>";
                    echo "<div style='overflow-x: auto;'>";
                    echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
                    echo "<tr><th style='padding: 10px; border: 1px solid #ddd;'>Registration ID</th><th style='padding: 10px; border: 1px solid #ddd;'>First Name</th><th style='padding: 10px; border: 1px solid #ddd;'>Last Name</th></tr>";
                    while ($row = $resultStudents->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["Registration_ID"] . "</td>";
                        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["First_Name"] . "</td>";
                        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row["SURNAME"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<div style='text-align: center;'>";
                    echo "No students found for courses taught by Professor ID: $id";
                    echo "</div>";
                }
            
        echo "<div style='overflow-x: auto;'>";
        echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
        echo "<tr>";
        echo "<td style='border: 0px solid #ddd; text-align: center;'>";
        echo "<form style='display: inline-block;' method='post' action='update_user.php'>";
        echo "<input type='hidden' name='role' value='$role'>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "<input type='submit' name='update' value='UPDATE' style=' background-color: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer;'>";
        echo "</form>";
        echo "</td>";

echo "<td style='border: 0px solid #ddd; text-align: center;'>";
echo "<form style='display: inline-block;' method='post' action='print.php'>";
echo "<input type='hidden' name='role' value='$role'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='submit' name='print' value='PRINT' style=' background-color: #0000FF; color: #fff; border: none; border-radius: 4px; cursor: pointer;'>";
echo "</form>";
echo "</td>";


echo "<td style='border: 0px solid #ddd; text-align: center;'>";
echo "<form style='display: inline-block;' method='post' action='graph2.php'>";
echo "<input type='hidden' name='role' value='$role'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='submit' name='visualise' value='VISUALISE' style=' background-color: #0000FF; color: #fff; border: none; border-radius: 4px; cursor: pointer;'>";
echo "</form>";
echo "</td>";

        echo "<td style='border: 0px solid #ddd; text-align: center;'>";
        echo "<form  style='display: inline-block;' method='post' action='delete_user.php' onsubmit='return confirm(\"Are you sure you want to delete this user?\");'>";
        echo "<input type='hidden' name='role' value='$role'>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "<input type='submit' name='delete' value='DELETE' style=' background-color: #dc3545; color: #fff; border: none; border-radius: 4px; cursor: pointer;'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

        echo "</div>";
        } else {
            echo "<div style='text-align: center;'>";
            echo "No user found with ID: $id";
            echo "</div>";
        }}}}
    
     elseif ($registrationType == "new") {
            $existingId = $_POST["id"];
            $tableName = ($_POST["role"] == "student") ? "students" : "Professors";
            $idColumnName = ($_POST["role"] == "student") ? "Registration_ID" : "ProfessorID";
            
            $checkQuery = "SELECT * FROM $tableName WHERE $idColumnName = '$existingId'";
            $checkResult = $conn->query($checkQuery);
        
            if ($checkResult && $checkResult->num_rows > 0) {
                echo "<div style='text-align: center;'>";
                echo "User with ID $existingId is already registered.";
                echo "</div>";
            } else {
                if ($role == "student") {
                    echo "<!DOCTYPE html>";
            echo "<html lang='en'>";
            echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<title>User Registration</title>";
            echo "<style>";
            echo "body { font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px; }";
            echo "form { max-width: 600px; margin: 0 auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }";
            echo "label { display: block; font-weight: bold; margin-bottom: 10px; }";
            echo "input[type='text'], input[type='email'], select { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; }";
            echo "input[type='submit'] { width: 100%; padding: 10px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; }";
            echo "</style>";
            echo "</head>";
            echo "<body>";
            echo "<h2 style='text-align: center;'>New User Registration</h2>";
            echo "<form method='post' action='student_input.php'>";
            echo"<input type='hidden' name='id' value='$id'>";

            echo"<input type='hidden' name='registration_type' value='new'>";
            echo "<input type='hidden' name='role' value='student'>";
            echo "<label>Full Name: (Compulsory) </label>";
            echo "<input type='text' name='Full_Name' required>";
            echo "<br><br>";
            echo "<label>Registration ID :</label>";
echo " $id\n";
echo "<br><br>";

            echo "<label>College Email Address: Compulsory) </label>";
            echo "<input type='email' name='Email_Address' required>";
            echo "<br><br>";                
            echo "<label>Date of Admission:</label>";
            echo "<br>";
            echo"insert in this format 12-01-2020";
            echo "<br>";
            echo "<input type='text' name='Date_of_Admission'>";
            echo "<br><br>";                
            echo "<label>Fees:</label>";
            echo "<input type='text' name='Admission_Fees_Paid'>";
            echo "<br><br>";
            echo "<label>First Name:</label>";
            echo "<input type='text' name='First_Name'>";
                echo "<br><br>";
                
                echo "<label>Middle Name:</label>";
                echo "<input type='text' name='Middle_Name'>";
                echo "<br><br>";
                
                echo "<label>Surname:</label>";
                echo "<input type='text' name='SURNAME'>";
                echo "<br><br>";
                
                echo "<label>Father's Name:</label>";
                echo "<input type='text' name='Father_Name'>";
                echo "<br><br>";
                
                echo "<label>Mother's Name:</label>";
                echo "<input type='text' name='Mother_Name'>";
                echo "<br><br>";
                
                echo "<label>Personal Email:</label>";
                echo "<input type='email' name='Email_ID'>";
                echo "<br><br>";
                
                echo "<label>Contact Number:</label>";
                echo "<input type='text' name='Contact_Number'>";
                echo "<br><br>";
                
                echo "<label>Gender:</label>";
                echo "<select name='Gender'>";
                echo "<option value='Male'>Male</option>";
                echo "<option value='Female'>Female</option>";
                echo "<option value='Other'>Other</option>";
                echo "</select>";
                echo "<br><br>";
                
                echo "<label>Date of Birth:</label>";
                echo "<br>";
                echo"insert in this format 12-01-2020";
                echo "<br>";
                echo "<input type='text' name='Date_of_Birth'>";
                echo "<br><br>";
                
                echo "<label>Category:</label>";
                echo "<input type='text' name='Category'>";
                echo "<br><br>";
                
                echo "<label>Blood Group:</label>";
                echo "<select name='Blood_Group'>";
                echo "<option value='A+'>A+</option>";
                echo "<option value='B+'>B+</option>";
                echo "<option value='AB+'>AB+</option>";
                echo "<option value='O+'>O+</option>";
                echo "<option value='A-'>A-</option>";
                echo "<option value='B-'>B-</option>";
                echo "<option value='AB-'>AB-</option>";
                echo "<option value='O-'>O-</option>";
                echo "</select>";
                echo "<br><br>";
                
                echo "<label>Physically Handicapped:</label>";
                echo "<select name='Physically_Handicap'>";
                echo "<option value='Yes'>Yes</option>";
                echo "<option value='No'>No</option>";
                echo "</select>";
                echo "<br><br>";
                
                echo "<label>If Yes, Handicap Type:</label>";
                echo "<input type='text' name='Handicap_Type'>";
                echo "<br><br>";
                
                echo "<input type='submit' value='Register'>";
                echo "</form>";
                echo "</body>";
                echo "</html>";
                } elseif ($role == "Professor") {
                    echo "<!DOCTYPE html>";
            echo "<html lang='en'>";
            echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<title>User Registration</title>";
            echo "<style>";
            echo "body { font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px; }";
            echo "form { max-width: 600px; margin: 0 auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }";
            echo "label { display: block; font-weight: bold; margin-bottom: 10px; }";
            echo "input[type='text'], input[type='email'], select { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; }";
            echo "input[type='submit'] { width: 100%; padding: 10px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; }";
            echo "</style>";
            echo "</head>";
            echo "<body>";
            echo "<h2 style='text-align: center;'>New User Registration</h2>";
            echo "<form method='post' action='professor_input.php'>";

            echo"<input type='hidden' name='registration_type' value='new'>";
            echo "<input type='hidden' name='role' value='Professor'>";
            echo"<input type='hidden' name='id' value='$id'>";

            echo "<label>Full Name: (Compulsory) </label>";
            echo "<input type='text' name='Name' required>";
            echo "<br><br>";

            echo "<label>Professor ID :</label>";
            echo " $id\n";
            echo "<br><br>";

            echo "<label>Department (compulsory)</label>";
            echo "<input type='text' name='Department' required>";
            echo "<br><br>";                

            echo "<label>Designation (compulsory) :</label>";
            echo "<input type='text' name='Designation' required>";
            echo "<br><br>";                

            echo "<label>Email (compulsory):</label>";
            echo "<input type='email' name='Email1' required>";
            echo "<br><br>";

            echo "<label>Personal Email:</label>";
            echo "<input type='email' name='Email2'>";
            echo "<br><br>";

                echo "<label>Contact Number:</label>";
                echo "<input type='text' name='Phone1'>";
                echo "<br><br>";
                
                echo "<label>Contact Number (if any other):</label>";
                echo "<input type='text' name='Phone2'>";
                echo "<br><br>";
                
                echo "<label>Qualification:</label>";
                echo "<input type='text' name='Qualification'>";
                echo "<br><br>";
                
                echo "<label>Experience (in years):</label>";
                echo "<input type='text' name='Experience'>";
                echo "<br><br>";
                
                echo "<input type='submit' value='Register'>";
                echo "</form>";
                echo "</body>";
                echo "</html>";
                }
            }
        
    }
}

echo '<style>';
echo '    body {';
echo '        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;';
echo '        background-color: #f9f9f9;';
echo '        color: #333;';
echo '        margin: 0;';
echo '        padding: 0;';
echo '        justify-content: center;';
echo '        align-items: center;';
echo '        height: 100vh;';
echo '    }';
echo '    h2 {';
echo '        text-align: center;';
echo '        margin-bottom: 30px;';
echo '        color: #007bff;';
echo '        text-transform: uppercase;';
echo '        letter-spacing: 2px;';
echo '    }';
echo '    table {';
echo '        width: 80%;';
echo '        max-width: 800px;';
echo '        border-collapse: collapse;';
echo '        margin-bottom: 30px;';
echo '        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);';
echo '        background-color: #fff;';
echo '    }';
echo '    table th, table td {';
echo '        padding: 10px;';
echo '        text-align: left;';
echo '        border-bottom: 1px solid #ddd;';
echo '    }';
echo '    form {';
echo '        width: 80%;';
echo '        max-width: 600px;';
echo '        padding: 20px;';
echo '        border-radius: 8px;';
echo '        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);';
echo '        background-color: #f5f5f5;';
echo '        text-align: center; /* Center form content */';
echo '    }';
echo '    label {';
echo '        font-weight: bold;';
echo '        display: block;';
echo '        margin-bottom: 10px;';
echo '        color: #555;';
echo '    }';
echo '    input[type="text"], input[type="email"], select {';
echo '        width: calc(100% - 24px); /* Adjusted width to remove button padding */';
echo '        padding: 10px;';
echo '        margin-bottom: 20px;';
echo '        border: 1px solid #ccc;';
echo '        border-radius: 4px;';
echo '        font-size: 16px;';
echo '    }';
echo '    input[type="submit"] {';
echo '        width: 100%;';
echo '        padding: 10px 0; /* Adjusted padding for button */';
echo '        background-color: #007bff;';
echo '        color: #fff;';
echo '        border: none;';
echo '        border-radius: 4px;';
echo '        font-size: 16px;';
echo '        cursor: pointer;';
echo '        transition: background-color 0.3s ease;';
echo '    }';
echo '    input[type="submit"]:hover {';
echo '        background-color: #0056b3;';
echo '    }';
echo '    .center-text {';
echo '        text-align: center;';
echo '    }';
echo '</style>';

$conn->close();
?>