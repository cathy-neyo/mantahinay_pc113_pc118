<!-- view-applications.php -->

<!DOCTYPE html>
<html>
<head>
    <title>View Applications - List of Applicants</title>
    <style>
        /* Print styles */
        @media print {
            /* Hide buttons and other non-printable elements */
            .no-print {
                display: none;
            }
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
    </style>
</head>
<body>

<h2>List of Applicants</h2>

<button class="no-print" onclick="window.print()">Print Applicants List</button>

<table>
    <thead>
        <tr>
            <th>Applicant ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Contact Number</th>
            <th>Applied Scholarship</th>
            <th>Application Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Example: fetch applicants data from database (using mysqli or PDO)
        // Replace this with your actual DB connection & query

        // Sample data array to simulate DB results
        $applicants = [
            ['id'=>1, 'fullname'=>'Juan Dela Cruz', 'email'=>'juan@example.com', 'contact'=>'09171234567', 'scholarship'=>'Academic Excellence', 'date'=>'2025-05-20'],
            ['id'=>2, 'fullname'=>'Maria Santos', 'email'=>'maria@example.com', 'contact'=>'09181234567', 'scholarship'=>'Sports Scholarship', 'date'=>'2025-05-21'],
            // add more data here...
        ];

        foreach($applicants as $applicant) {
            echo "<tr>
                <td>{$applicant['id']}</td>
                <td>{$applicant['fullname']}</td>
                <td>{$applicant['email']}</td>
                <td>{$applicant['contact']}</td>
                <td>{$applicant['scholarship']}</td>
                <td>{$applicant['date']}</td>
            </tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
