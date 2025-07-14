<?php
require_once 'includes/db_connect.php';


$role = $_POST['role'] ?? '';
$id = $_POST['id'] ?? '';

function gradeToPoints($grade) {
    $map = ["AA"=>10, "AB"=>9, "BB"=>8, "BC"=>7, "CC"=>6, "CD"=>5, "DD"=>4, "F"=>0];
    return $map[$grade] ?? 0;
}

if (strtolower($role) === "student") {
    $student_id = $id;
$grade_distribution = [];
$res = $conn->query("SELECT finalgrade FROM gradelist WHERE registration_number IN (
  SELECT registration_id FROM student_courses WHERE course_id = (
    SELECT course_id FROM student_courses WHERE registration_id = '$student_id' LIMIT 1
  )
)");
while ($row = $res->fetch_assoc()) {
    $g = $row['finalgrade'];
    $grade_distribution[$g] = ($grade_distribution[$g] ?? 0) + 1;
}
$grades_labels = array_keys($grade_distribution);
$grades_data = array_values($grade_distribution);

}

$course_labels = $course_counts = [];
$res = $conn->query("SELECT course_id, COUNT(*) as count FROM student_courses GROUP BY course_id");
while ($row = $res->fetch_assoc()) {
    $course_labels[] = $row['course_id'];
    $course_counts[] = $row['count'];
}

$course_stats = [];
if (strtolower($role) === "professor") {
    $prof_id = $id;
    $res = $conn->query("
        SELECT c.course_id, g.finalgrade
        FROM professor_courses pc
        JOIN course c ON pc.course_id = c.course_id
        JOIN student_courses sc ON c.course_id = sc.course_id
        JOIN gradelist g ON sc.registration_id = g.registration_number
        WHERE pc.professor_id = '$prof_id'
    ");
    $course_grades = [];
while ($row = $res->fetch_assoc()) {
    $cid = $row['course_id'];
    $points = gradeToPoints($row['finalgrade']);
    $course_stats[$cid][] = $points;
}

$prof_labels = [];
$min_data = $max_data = $avg_data = [];
foreach ($course_stats as $cid => $grades) {
    $prof_labels[] = (string)$cid;
    $min_data[] = min($grades);
    $max_data[] = max($grades);
    $avg_data[] = round(array_sum($grades) / count($grades), 2);
}
    }

$prof_student_labels = $prof_student_data = [];
$res = $conn->query("
    SELECT pc.professor_id, COUNT(DISTINCT sc.registration_id) as student_count
    FROM professor_courses pc
    JOIN student_courses sc ON pc.course_id = sc.course_id
    GROUP BY pc.professor_id
");
while ($row = $res->fetch_assoc()) {
    $prof_student_labels[] = $row['professor_id'];
    $prof_student_data[] = $row['student_count'];
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Student & Professor Charts</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: sans-serif;
      padding: 20px;
    }
    .chart-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
      gap: 40px;
    }
    .chart-box {
      background: #f9f9f9;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    canvas {
      max-width: 100%;
      height: 300px !important;
    }
  </style>
</head>
<body>

<h1>📊 <?= ucfirst($role) ?> Dashboard for ID: <?= htmlspecialchars($id) ?></h1>

<div class="chart-grid">

<?php if (strtolower($role) === "student"): ?>
  <div class="chart-box">
    <h3>📌 Student Grades in Course</h3>
    <canvas id="studentGrades"></canvas>
  </div>


  <div class="chart-box">
    <h3>👥 Student Count per Course</h3>
    <canvas id="courseCount"></canvas>
  </div>
  <?php endif; ?>
<?php if (strtolower($role) === "professor"): ?>
      <div class="chart-box">
    <h3>🧑‍🏫 Avg Grade per Course Taught</h3>
    <canvas id="profAvgGrade"></canvas>
  </div>


  <div class="chart-box">
    <h3>👨‍🏫 Student Count per Professor</h3>
    <canvas id="studentsPerProf"></canvas>
  </div>
  <?php endif; ?>
</div>

<script>

function makeChart(id, labels, data, label, colors, type = 'bar', isGrouped = false) {
  let datasets = [];

  if (isGrouped && typeof data === 'object' && !Array.isArray(data)) {
    const keys = Object.keys(data);
    datasets = keys.map((key, i) => ({
      label: key.charAt(0).toUpperCase() + key.slice(1),
      data: data[key],
      backgroundColor: colors[i]
    }));
  } else {
    datasets = [{
      label: label,
      data: data,
      backgroundColor: Array.isArray(colors) ? colors : Array(data.length).fill(colors)
    }];
  }

  new Chart(document.getElementById(id).getContext('2d'), {
    type: type,
    data: {
      labels: labels,
      datasets: datasets
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: true }
      },
      scales: (type === 'pie' || type === 'doughnut') ? {} : {
        y: {
          beginAtZero: true,
          max: 10
        }
      }
    }
  });
}


<?php if ($role === "student"): ?>
makeChart('studentGrades',
  <?= json_encode($grades_labels) ?>,
  <?= json_encode($grades_data) ?>,
  'Grade Distribution (Points)',
  [
    'rgba(75, 192, 192, 0.6)',
    'rgba(255, 99, 132, 0.6)',
    'rgba(255, 206, 86, 0.6)',
    'rgba(153, 102, 255, 0.6)',
    'rgba(54, 162, 235, 0.6)'
  ],
  'pie'
);


makeChart('courseCount',
  <?= json_encode($course_labels) ?>,
  <?= json_encode($course_counts) ?>,
  'Student Count',
  'rgba(255, 206, 86, 0.6)',
  'doughnut'
);
    <?php endif; ?>
<?php if (strtolower($role) === "professor" && !empty($prof_labels)): ?>
makeChart(
  'profAvgGrade',
  <?= json_encode($prof_labels) ?>,
  {
    min: <?= json_encode($min_data) ?>,
    max: <?= json_encode($max_data) ?>,
    avg: <?= json_encode($avg_data) ?>
  },
  'Grade Summary (Min / Max / Avg)',
  [
    'rgba(255, 99, 132, 0.6)',
    'rgba(54, 162, 235, 0.6)',
    'rgba(255, 206, 86, 0.6)'
  ],
  'bar',
  true
);

makeChart('studentsPerProf', <?= json_encode($prof_student_labels) ?>, <?= json_encode($prof_student_data) ?>, 'Student Count', 'rgba(54, 162, 235, 0.6)');
<?php endif; ?>
</script>

</body>
</html>
