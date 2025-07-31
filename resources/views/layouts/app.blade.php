@props(['title'])

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '-' }} - SMK AL-FIKRI Cilegon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">

        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            @include('layouts.navigation', ['title' => $title])

            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>

        </div>
    </div>

    <script>
        // Simple chart implementation without external libraries
        function drawLineChart(canvasId, data, labels) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext('2d');
            const width = canvas.width;
            const height = canvas.height;

            // Clear canvas
            ctx.clearRect(0, 0, width, height);

            // Chart settings
            const padding = 50;
            const chartWidth = width - 2 * padding;
            const chartHeight = height - 2 * padding;

            // Find min and max values
            const minValue = Math.min(...data) - 0.2;
            const maxValue = Math.max(...data) + 0.2;

            // Draw grid
            ctx.strokeStyle = '#e5e7eb';
            ctx.lineWidth = 1;

            // Horizontal grid lines
            for (let i = 0; i <= 5; i++) {
                const y = padding + (chartHeight / 5) * i;
                ctx.beginPath();
                ctx.moveTo(padding, y);
                ctx.lineTo(width - padding, y);
                ctx.stroke();
            }

            // Vertical grid lines
            for (let i = 0; i < labels.length; i++) {
                const x = padding + (chartWidth / (labels.length - 1)) * i;
                ctx.beginPath();
                ctx.moveTo(x, padding);
                ctx.lineTo(x, height - padding);
                ctx.stroke();
            }

            // Draw line
            ctx.strokeStyle = '#3b82f6';
            ctx.lineWidth = 3;
            ctx.beginPath();

            for (let i = 0; i < data.length; i++) {
                const x = padding + (chartWidth / (data.length - 1)) * i;
                const y = height - padding - ((data[i] - minValue) / (maxValue - minValue)) * chartHeight;

                if (i === 0) {
                    ctx.moveTo(x, y);
                } else {
                    ctx.lineTo(x, y);
                }

                // Draw points
                ctx.fillStyle = '#3b82f6';
                ctx.beginPath();
                ctx.arc(x, y, 4, 0, 2 * Math.PI);
                ctx.fill();
            }
            ctx.stroke();

            // Draw labels
            ctx.fillStyle = '#6b7280';
            ctx.font = '12px Inter';
            ctx.textAlign = 'center';

            // X-axis labels
            for (let i = 0; i < labels.length; i++) {
                const x = padding + (chartWidth / (labels.length - 1)) * i;
                ctx.fillText(labels[i], x, height - padding + 20);
            }

            // Y-axis labels
            ctx.textAlign = 'right';
            for (let i = 0; i <= 5; i++) {
                const y = padding + (chartHeight / 5) * i;
                const value = (maxValue - (maxValue - minValue) * i / 5).toFixed(1);
                ctx.fillText(value, padding - 10, y + 4);
            }
        }

        function drawDoughnutChart(canvasId, data, labels, colors) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext('2d');
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            const radius = Math.min(centerX, centerY) - 40;

            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Calculate total
            const total = data.reduce((sum, value) => sum + value, 0);

            // Draw segments
            let currentAngle = -Math.PI / 2;

            for (let i = 0; i < data.length; i++) {
                const sliceAngle = (data[i] / total) * 2 * Math.PI;

                ctx.fillStyle = colors[i];
                ctx.beginPath();
                ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);
                ctx.arc(centerX, centerY, radius * 0.6, currentAngle + sliceAngle, currentAngle, true);
                ctx.closePath();
                ctx.fill();

                currentAngle += sliceAngle;
            }

            // Draw legend
            const legendY = canvas.height - 60;
            const legendItemWidth = canvas.width / labels.length;

            ctx.font = '12px Inter';
            for (let i = 0; i < labels.length; i++) {
                const x = legendItemWidth * i + legendItemWidth / 2;

                // Legend color box
                ctx.fillStyle = colors[i];
                ctx.fillRect(x - 20, legendY, 12, 12);

                // Legend text
                ctx.fillStyle = '#374151';
                ctx.textAlign = 'center';
                ctx.fillText(labels[i], x, legendY + 25);
                ctx.fillText(data[i], x, legendY + 40);
            }
        }

        // Initialize charts when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Performance Chart Data
            const performanceData = [7.8, 8.0, 7.9, 8.1, 8.2, 8.2];
            const performanceLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
            drawLineChart('performanceChart', performanceData, performanceLabels);

            // Class Distribution Data
            const classData = [162, 165, 160];
            const classLabels = ['Kelas 7', 'Kelas 8', 'Kelas 9'];
            const classColors = ['#3b82f6', '#10b981', '#f59e0b'];
            drawDoughnutChart('classChart', classData, classLabels, classColors);
        });
    </script>
</body>

</html>
