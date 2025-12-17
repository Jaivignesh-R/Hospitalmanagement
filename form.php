<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "hospitaldb");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if (isset($_POST['save'])) {

    $patient_name = $_POST['patient_name'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $blood_group = $_POST['blood_group'];
    $contact_number = $_POST['contact_number'];
    $doa = $_POST['doa'];
    $doctor_name = $_POST['doctor_name'];
    $medical_details = $_POST['medical_details'];
    $allergies = $_POST['allergies'];
    $next_visit = $_POST['next_visit'];

    $report_file = "";
    if (!empty($_FILES['reports']['name'])) {
        $report_file = time() . "_" . $_FILES['reports']['name'];
        move_uploaded_file($_FILES['reports']['tmp_name'], "uploads/" . $report_file);
    }

    $sql = "INSERT INTO patient_records 
    (patient_name,address,age,gender,blood_group,contact_number,date_of_admission,doctor_name,medical_details,allergies,next_visit,report_file)
    VALUES
    ('$patient_name','$address','$age','$gender','$blood_group','$contact_number','$doa','$doctor_name','$medical_details','$allergies','$next_visit','$report_file')";

    if ($conn->query($sql)) {
        echo "<script>alert('Record saved successfully');</script>";
    } else {
        echo "SQL Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Record</title>
</head>
<body>

<form method="post" enctype="multipart/form-data">
    Patient Name: <input type="text" name="patient_name" required><br><br>
    Address: <textarea name="address" required></textarea><br><br>
    Age: <input type="number" name="age" required><br><br>

    Gender:
    <input type="radio" name="gender" value="Male" required> Male
    <input type="radio" name="gender" value="Female"> Female
    <input type="radio" name="gender" value="Other"> Other<br><br>

    Blood Group:
    <select name="blood_group">
        <option>A+</option><option>A-</option>
        <option>B+</option><option>B-</option>
        <option>O+</option><option>O-</option>
        <option>AB+</option><option>AB-</option>
    </select><br><br>

    Contact: <input type="text" name="contact_number"><br><br>
    Date of Admission: <input type="date" name="doa"><br><br>
    Doctor: <input type="text" name="doctor_name"><br><br>
    Medical Details: <textarea name="medical_details"></textarea><br><br>
    Allergies: <input type="text" name="allergies"><br><br>
    Next Visit: <input type="date" name="next_visit"><br><br>
    Upload Report: <input type="file" name="reports"><br><br>

    <button type="submit" name="save">Save</button>
</form>

</body>
</html>