<!DOCTYPE html>
<html>
<head>
    <title>Electricity Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Electricity Calculator</h2>
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="voltage">Voltage (V)</label>
                <input type="number" step="any" class="form-control" name="voltage" required value="<?php echo isset($_POST['voltage']) ? $_POST['voltage'] : ''; ?>">
                <p>Voltage(V)</p>
            </div>
            <div class="form-group">
                <label for="current">Current (A)</label>
                <input type="number" step="any" class="form-control" name="current" required value="<?php echo isset($_POST['current']) ? $_POST['current'] : ''; ?>">
                <p>Ampere (A)</p>
            </div>
            <div class="form-group">
                <label for="rate">Current Rate</label>
                <input type="number" step="any" class="form-control" name="rate" required value="<?php echo isset($_POST['rate']) ? $_POST['rate'] : ''; ?>">
                <p>sen/kWh</p>
            </div>
            <button type="submit" class="btn btn-primary">Calculate</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $voltage = $_POST["voltage"];
            $current = $_POST["current"];
            $rate = $_POST["rate"]/100;    //convert the rate to sen


            function calculatePower($voltage, $current)
            {
                return ($voltage * $current) / 1000;              //calculate the power (kW)
            }

            function calculateEnergy($power, $hour)
            {
                return  $power * $hour;                            //calculate energy (kWh)
            }

            function calculateTotalCharge($energy, $rate)
            {
                return $energy * $rate;                             //calculate charge(RM)
            }

            $power = calculatePower($voltage, $current);
            

            echo "<div class='container mt-4'>
                    
                    <div class='border border-success p-2 mb-2'>
                    <div class='text-success font-weight-bold'>Power: $power kW</div>
                    <div class='text-success font-weight-bold'>Rate: RM $rate</div>    
                    
                </div>

                    <h2>Electricity Calculator - Results</h2>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Hour</th>
                                <th>Energy (kWh)</th>
                                <th>Total (RM)</th>
                            </tr>
                        </thead>
                        <tbody>";

            for ($hour = 1; $hour <= 24; $hour++) {
                $energy = calculateEnergy($power, $hour);
                $totalCharge = calculateTotalCharge($energy, $rate);

                echo "<tr>
                        <td>$hour</td>
                        <td>" . ($energy) . "</td>
                        <td>" . number_format($totalCharge, 2) . "</td>
                    </tr>";
            }

            echo "</tbody>
                </table>
            </div>";
        }
        ?>
    </div>
</body>

 <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <p>&copy; <?php echo date('Y'); ?> Written by @haikalrezza</p>
        </div>
    </footer>
</html>
