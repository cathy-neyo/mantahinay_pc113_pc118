<!-- view-reports.php -->

<!DOCTYPE html>
<html>
<head>
    <title>View Reports - List of Scholarships</title>
    <style>
        @media print {
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

<h2>List of Scholarships</h2>

<button class="no-print" onclick="window.print()">Print Scholarships List</button>

<table>
    <thead>
        <tr>
            <th>Scholarship ID</th>
            <th>Scholarship Name</th>
            <th>Description</th>
            <th>Amount</th>
            <th>Posted Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Example: fetch scholarships from database

        $scholarships = [
            ['id'=>101, 'name'=>'Academic Excellence', 'description'=>'For students with high grades', 'amount'=>'₱10,000', 'date'=>'2025-04-01'],
            ['id'=>102, 'name'=>'Sports Scholarship', 'description'=>'For athletes', 'amount'=>'₱8,000', 'date'=>'2025-04-10'],
            // add more...
        ];

        foreach($scholarships as $scholarship) {
            echo "<tr>
                <td>{$scholarship['id']}</td>
                <td>{$scholarship['name']}</td>
                <td>{$scholarship['description']}</td>
                <td>{$scholarship['amount']}</td>
                <td>{$scholarship['date']}</td>
            </tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
