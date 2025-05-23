<?php
$id = $_GET['id'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Scholarship Details</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <div class="max-w-4xl mx-auto px-6 py-12">
    <a href="index.php" class="text-blue-500 hover:underline">&larr; Back to Listings</a>

    <div id="scholarship-detail" class="mt-6 bg-white p-6 rounded-lg shadow-lg">
      <p>Loading scholarship details...</p>
    </div>
  </div>

  <script>
    const id = "<?php echo $id; ?>";
    const API_URL = `http://localhost:8000/api/scholarships/${id}`;

    fetch(API_URL)
      .then(response => response.json())
      .then(data => {
        const detail = document.getElementById("scholarship-detail");
        const imageUrl = data.image 
          ? `http://localhost:8000/storage/scholarships/${data.image}` 
          : 'default-image.jpg';

        detail.innerHTML = `
          <img src="${imageUrl}" class="w-full h-64 object-cover rounded-md mb-4" alt="Scholarship Image">
          <h1 class="text-2xl font-bold mb-2">${data.title}</h1>
          <p class="text-gray-600 mb-2"><strong>Amount:</strong> ₱${data.amount}</p>
          <p class="text-gray-600 mb-2"><strong>Start Date:</strong> ${data.start_date}</p>
          <p class="text-gray-600 mb-2"><strong>End Date:</strong> ${data.end_date}</p>
          <p class="text-gray-600 mb-2"><strong>Requirements:</strong> ${data.requirements}</p>
          <p class="text-gray-700 mt-4">${data.description}</p>

          <div class="mt-6">
            <a href="apply.php?id=${data.id}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-2 rounded shadow font-semibold">
              Apply Now
            </a>
          </div>
        `;
      })
      .catch(error => {
        document.getElementById("scholarship-detail").innerHTML = `
          <p class="text-red-500">Error loading scholarship details. Please try again later.</p>
        `;
        console.error(error);
      });
  </script>

</body>
</html>
