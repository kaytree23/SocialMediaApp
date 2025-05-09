<!-- goal_setting.php -->
<!-- handles UI of goal setting menu -->
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Goal Setting</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            body 
            {
                font-family: 'Trebuchet MS', sans-serif;
                margin: 0;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #F0FFF0;
            }

            .goal-setting-container
            {
                width: 500px;
                max-width: 90%;
                /* change to light green bg? */
                background-color: #FFFFFF;
                padding: 30px;
                border-radius: 20px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            }

            .goal-setting-container h2
            {
                text-align: center;
                margin-bottom: 20px;
                color: #2F4F4F;
            }

            .goal-input
            {
                margin-bottom: 15px;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .goal-input input 
            {
                padding: 12px;
                border: 1px solid #8FBC8F;
                border-radius: 15px;
                font-size: 16px;
                background-color: #E8F5E9;
                color: #2F4F4F;
                margin-top: 10px;
                width: 100%;
                max-width: 400px;
                box-sizing: border-box;
            }

            
            .goal-input input:focus 
            {
                outline: none;
                border-color: #66BB6A;
                background-color: #C8E6C9;
            }

            .add-button, .action-buttons
            {
                display: flex;
                justify-content: center;
                margin-top: 15px;
            }
            
            .add-button button, .action-buttons button
            {
                padding: 10px 15px;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                font-size: 16px;
            }

            .add-button button
            {
                background-color: #8FBC8F;
                color: #FFFFFF;
            }

            /* buttons to save goals */
            .action-buttons button.save-btn
            {
                background-color: #FFE4E1;
                color: #2F4F4F;
                margin-right: 10px;
            }
            
            /* button to post goals */
            .action-buttons button.post-btn
            {
                background-color: #FFE4E1;
                color: #2F4F4F;
            }

            /* circle chart for progress */
            #progress-container
            {
                margin-top: 30px;
                text-align: center;
            }    
        </style>
    </head>

<body>
    <div class="goal-setting-container">
        <h2>What are your goals?</h2>
        <p>Small, large, long-term, silly. They're yours to accomplish.</p>
        <div id="goal-list">
            <div class="goal-input">
                <input type="text" placeholder="Enter your goal..." required> 
            </div>
        </div>

    <div class="add-button">
        <button onclick="addGoal()">+ Add Goal</button>
    </div>

    <div class="action-buttons">
        <button class="save-btn" onclick="saveGoals()">Save Goals</button>
        <button class="post-btn" onclick="postGoals()">Save and Post Goals</button>
    </div>

    <div id="progress-container">
        <h3>See Your Progress</h3>
        <canvas id="progress-chart" width="200" height="200"></canvas>
    </div>
    </div>

    <script>
        function addGoal()
        {
            const container = document.getElementById('goal-list');
            const newGoal = document.createElement('div');
            newGoal.className = 'goal-input';
            newGoal.innerHTML = '<input type="text" placeholder="Enter your goal..." required>';
            container.appendChild(newGoal);
        }

        function saveGoals()
        {
            alert('Goals saved successfully!');
        }

        function postGoals()
        {
            alert('Goals saved and shared!');
        }

        const ctx = document.getElementById('progress-chart').getContext('2d');
        const progressChart = new Chart(ctx, 
        {
            type: 'doughnut',
            data: 
            {
                labels: ['Completed', 'In Progress'],
                datasets: [
                    {
                    label: 'Goal Progress',
                    <!-- Example data: 3 completed, 7 in progress -->
                    data: [3,7],
                    backgroundColor: ['#E37383', '#EEE'],
                    borderWidth: 1
                    }]
            },
            options: 
            {
                cutout: '70%',
                plugins:
                {
                    legend:
                    {
                        display: true,
                        position: 'bottom'
                    }
                }     
            }
        });
    </script>

</body>
</html>